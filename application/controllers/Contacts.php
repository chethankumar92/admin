<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends MY_Controller {

    public function index() {
        $this->load->setTitle("Manage Contacts");
        $this->load->setDescription("Manage contact details");
        $this->load->addScripts("modules/contact");
        $this->load->addPlugins("datatables/jquery.dataTables", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "css", 10);
        $this->load->template('contact/manage', array(
            "render_url" => site_url(self::class . "/render")
        ));
    }

    public function add() {
        $this->load->setTitle("Add Contact");
        $this->load->setDescription("Provide contact details and save");
        $this->load->template('contact/add', array(
            "action" => site_url(self::class . "/add_submit"),
            "method" => "post"
        ));
    }

    public function add_submit() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
    }

    public function render() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->library("SSP_lib", NULL, "ssp");
        $this->load->database();

        $this->ssp->setTable('contact');
        $this->ssp->setPrimary_key('cid');

        $i = 0;
        $columns = array(
            array('db' => 'cid', 'dt' => $i++),
            array('db' => 'name', 'dt' => $i++),
            array('db' => 'email', 'dt' => $i++),
            array('db' => 'mobile', 'dt' => $i++),
            array('db' => 'subject', 'dt' => $i++),
            array('db' => 'message', 'dt' => $i++),
            array('db' => 'created_auid', 'dt' => $i++),
            array('db' => 'updated_auid', 'dt' => $i++),
            array('db' => 'created_time', 'dt' => $i++),
            array('db' => 'updated_time', 'dt' => $i++)
        );
        $this->ssp->setColumns($columns);

        $this->ssp->setDb($this->db);
        $this->ssp->setInput($this->input->post());

        echo $this->ssp->render();
    }

}
