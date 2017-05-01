<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $this->load->model('AdminUser', 'admin_user', TRUE, $this->session->userdata('logged_in_auid'));
        $this->session->set_userdata('logged_in_user', $this->admin_user);
    }

}
