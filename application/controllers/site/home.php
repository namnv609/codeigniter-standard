<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model("users", "Users");
    }
    public function index()
    {
        $data['name'] = "world";

        $this->twig->display($data);
    }

    public function about()
    {
        $this->twig->display();
    }

    public function hello($name = "")
    {
        $data["name"] = $name;

        $this->twig->display($data, "./site/home/index.twig");
    }

    public function validation()
    {
        if ($this->input->post()) {
            var_dump($this->Users->validation());
        }

        return $this->twig->display();
    }
}
