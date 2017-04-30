<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {
        if ($this->session->userdata("logged_in")) {
            redirect('home');
        } else {
            $this->load->setTitle("Login");
            $this->load->addScripts("modules/login");
            $this->load->template('login/login', array(
                "action" => site_url(self::class . "/log_in"),
                "method" => "post"
                    ), FALSE, TRUE);
        }
    }

    public function log_in() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules("email", 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "type" => "danger",
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid credentials!"
            )))->_display();
            exit;
        }

        $this->load->helper('phpass');
        $password = $this->input->post("password", TRUE);
        $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);

        $this->load->model('AdminUser', 'admin_user', TRUE);
        $this->admin_user->setEmail($this->input->post("email", TRUE), TRUE);
        if (!$hasher->check_password($password, $this->admin_user->getPassword())) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Login failed, incorrect credentials!"
            )))->_display();
            exit;
        }

        $this->session->set_userdata("logged_in", TRUE);
        $this->session->set_userdata("logged_in_auid", $this->admin_user->getId());
        $this->output->set_output(json_encode(array(
            "success" => TRUE,
            "url" => site_url("home"),
            "message" => "Logged in successfully!"
        )))->_display();
        exit;
    }

}
