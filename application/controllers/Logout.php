<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Logout extends CI_Controller
    {

        /**
         * Index Page for this controller.
         *
         * Maps to the following URL
         * 		http://example.com/
         * 	- or -
         * 		http://example.com/index.php/login
         * 	- or -
         *              http://example.com/index.php/login/index
         * 
         * So any other public methods not prefixed with an underscore will
         * map to /index.php/welcome/<method_name>
         * @see https://codeigniter.com/user_guide/general/urls.html
         */
        public function index()
        {
            if ($this->session->userdata("logged_in"))
            {
                $this->session->unset_userdata("logged_in");
            }
            redirect("login");
        }

        public function log_out()
        {
            if ($this->session->userdata("logged_in"))
            {
                $this->session->unset_userdata("logged_in");
                echo json_encode(array(
                    "success" => TRUE,
                    "url" => site_url("login"),
                    "message" => "Logged out successfully!"
                ));
            }
            else
            {
                echo json_encode(array(
                    "success" => FALSE,
                    "message" => "Failed to logout!"
                ));
            }
        }

    }
    