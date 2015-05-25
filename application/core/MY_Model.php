<?php

if (!defined('BASEPATH'))
    exit('Restricted access');

class MY_Model extends CI_Model
{
    public $validates = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function validation()
    {
        $validation_rules = array();
        $validates = $this->validates;
        $columnMap = array();

        if (method_exists($this, 'columnMap')) {
            $columnMap = $this->columnMap();
        }

        foreach ($validates as $field => $validate) {
            $mapField = $field;

            if (isset($columnMap[$field])) {
                $mapField = $columnMap[$field];
            }

            $validation_rules[] = array(
                'field' => $mapField,
                'label' => $validate['label'],
                'rules' => implode("|", $validate['rules'])
            );
        }

        $this->form_validation->set_rules($validation_rules);
        return $this->form_validation->run();
    }
}
