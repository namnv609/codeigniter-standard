<?php

if (!defined("BASEPATH"))
    exit("Restricted access");

/**
 * Front-end controller
 */
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper("form");

        $this->twig->add_function($this->_form_helper_functions());
        $this->twig->add_function("base_url");
        $this->twig->add_function("validation_errors");
    }

    private function _form_helper_functions()
    {
        return array(
            "form_open",
            "form_open_multipart",
            "form_hidden",
            "form_input",
            "form_password",
            "form_upload",
            "form_textarea",
            "form_dropdown",
            "form_multiselect",
            "form_fieldset",
            "form_fieldset_close",
            "form_checkbox",
            "form_radio",
            "form_submit",
            "form_label",
            "form_reset",
            "form_button",
            "form_close",
            "form_prep",
            "set_value",
            "set_select",
            "set_checkbox",
            "set_radio"
        );
    }
}

/**
 * Admin controller
 */
class Admin_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
}
