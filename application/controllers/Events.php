<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends MY_Controller {

    public function index() {
        $this->load->setTitle("Manage Events");
        $this->load->setDescription("Manage event details");
        $this->load->addScripts("modules/event");
        $this->load->addPlugins("datatables/jquery.dataTables", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "css", 10);
        $this->load->template('event/manage', array(
            "render_url" => site_url(self::class . "/render")
        ));
    }

    public function add() {
        $this->load->setTitle("Add Event");
        $this->load->setDescription("Provide event details and save");
        $this->load->template('event/add', array(
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

        $this->ssp->setTable('event');
        $this->ssp->setPrimary_key('eid');

        $i = 0;
        $columns = array(
            array('db' => 'eid', 'dt' => $i++),
            array('db' => 'name', 'dt' => $i++),
            array('db' => 'from_date', 'dt' => $i++),
            array('db' => 'to_date', 'dt' => $i++),
            array('db' => 'trek_distance', 'dt' => $i++),
            array('db' => 'fee', 'dt' => $i++),
            array('db' => 'egid', 'dt' => $i++),
            array('db' => 'esid', 'dt' => $i++),
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
