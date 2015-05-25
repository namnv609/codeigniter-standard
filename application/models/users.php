<?php

class Users extends MY_Model
{
    public $validates = array(
        'name' => array(
            'label' => 'Username',
            'rules' => array(
                "trim",
                "required",
                "xss_clean"
            )
        )
    );

    public function __construct()
    {
        parent::__construct();
    }

    public function columnMap()
    {
        return array(
            'name' => 'txtName'
        );
    }
}
