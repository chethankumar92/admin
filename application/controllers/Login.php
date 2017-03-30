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
        $this->load->library('form_validation');

        $this->form_validation->set_rules("email", 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');

        if (!$this->form_validation->run()) {
            echo json_encode(array(
                "success" => FALSE,
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid credentials!"
            ));
            exit;
        }


        $this->load->model('Employee', 'employee', TRUE);
        $this->employee->setEmail($this->input->post("email"));
        $this->employee->setPassword($this->input->post("password"));
        if (!$this->employee->auth()) {
            echo json_encode(array(
                "success" => FALSE,
                "message" => "Login failed, incorrect credentials!"
            ));
            exit;
        }

        $this->session->set_userdata("logged_in", TRUE);
        echo json_encode(array(
            "success" => TRUE,
            "url" => site_url("home"),
            "message" => "Logged in successfully!"
        ));
        exit;
    }

}
