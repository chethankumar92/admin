<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Home extends MY_Controller
    {

        public function index()
        {
            $this->load->setTitle("Home | Dashboard");
            $this->load->addMeta(array(
                "name" => "description",
                "content" => "Home page"
            ));
            $this->load->template('home/home');
        }

    }
    