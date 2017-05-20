<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_output(json_encode(array(
                    "success" => FALSE,
                    "type" => "warning",
                    "message" => "You are logged out of the portal!<br>Please use a new tab to login and try again."
                )))->_display();
                exit;
            }
            redirect('login');
        }
    }

}
