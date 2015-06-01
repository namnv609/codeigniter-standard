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

    public function model()
    {
        $users = $this->Users->find("all", array(
            "fields" => array("users.*", "Posts.title"),
            "order" => array("users.id DESC"),
            "joins" => array(
                array(
                    "table" => "posts",
                    "alias" => "Posts",
                    "type"  => "INNER",
                    "conditions" => array(
                        "Posts.user_id = users.id"
                    )
                )
            ),
            "conditions" => array(
                // "name LIKE" => "user",
                // "OR" => array(
                //     "Posts.title" => "dolor sit amet",
                //     "users.id" => 1
                // ),
                // "IN" => array(
                //     "users.id" => array(1, 2)
                // ),
                "NOT IN" => array(
                    "users.id" => array(2)
                ),
            )
        ));

        echo "<pre>";
        var_dump($users);
        echo "</pre>";
        echo $this->db->last_query();
    }
}
