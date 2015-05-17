<?php

if (!defined("BASEPATH"))
    exit("Restricted access");

class MY_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }
}
