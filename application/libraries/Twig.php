<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}
class Twig
{
    private $CI;
    private $_twig;
    private $_template_dir;
    private $_cache_dir;
    /**
     * Constructor
     *
     */
    function __construct($debug = true)
    {
        $this->CI =& get_instance();
        $this->CI->config->load('twig');

        ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . APPPATH . 'libraries/Twig');
        require_once (string) "Autoloader" . EXT;
        log_message('debug', "Twig Autoloader Loaded");
        Twig_Autoloader::register();
        $this->_template_dir = $this->CI->config->item('template_dir');
        $this->_cache_dir = $this->CI->config->item('cache_dir');
        $loader = new Twig_Loader_Filesystem($this->_template_dir);
        $this->_twig = new Twig_Environment($loader, array(
            'cache' => $this->_cache_dir,
            'debug' => $debug,
        ));

        $this->_twig->addExtension(new Twig_Extension_Debug());

        foreach(get_defined_functions() as $functions) {
            foreach($functions as $function) {
                $this->_twig->addFunction($function, new Twig_Function_Function($function));
            }
        }
    }
    public function add_function($name)
    {
        if (is_array($name)) {
            foreach ($name as $fnName) {
                $this->_twig->addFunction($fnName, new Twig_Function_Function($fnName));
            }
        } else {
            $this->_twig->addFunction($name, new Twig_Function_Function($name));
        }
    }
    public function render($template, $data = array())
    {
        $template = $this->_twig->loadTemplate($template);
        return $template->render($data);
    }
    public function display($data = array(), $template = "")
    {
        $class_name = $this->CI->router->class;
        $method_name = $this->CI->router->method;
        $dir_name = $this->CI->router->directory;

        if ($method_name === $class_name) {
            $method_name = "index";
        }

        $template_path = sprintf("%s%s/%s.twig", $dir_name, $class_name, $method_name);

        if ($template === "" || $template === null) {
            $template = $template_path;
        }

        $template = $this->_twig->loadTemplate($template);
        /* elapsed_time and memory_usage */
        $data['elapsed_time'] = $this
                                ->CI
                                ->benchmark
                                ->elapsed_time('total_execution_time_start', 'total_execution_time_end');

        $memory = (!function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2) . 'MB';
        $data['memory_usage'] = $memory;
        $template->display($data);
    }
}
