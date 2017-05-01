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

        $this->load->addPlugins("summernote/summernote", "js", 10);
        $this->load->addPlugins("summernote/summernote", "css", 10);
        $this->load->addPlugins("datepicker/datepicker", "js", 10);
        $this->load->addPlugins("datepicker/datepicker", "css", 10);
        $this->load->addPlugins("selectpicker/js/bootstrap-select", "js", 10);
        $this->load->addPlugins("selectpicker/css/bootstrap-select", "css", 10);

        $this->load->model('Event', 'event', TRUE);
        $this->load->template('event/add_edit_form', array(
            "action" => site_url(self::class . "/add_submit"),
            "method" => "post",
            "event" => $this->event,
            "grades" => Event::getGrades(1)
        ));
    }

    public function edit() {
        if (!is_numeric($this->uri->segments[3])) {
            redirect(self::class);
        }

        $this->load->setTitle("Edit Event");
        $this->load->setDescription("Provide event details and save");

        $this->load->addPlugins("summernote/summernote", "js", 10);
        $this->load->addPlugins("summernote/summernote", "css", 10);
        $this->load->addPlugins("datepicker/datepicker", "js", 10);
        $this->load->addPlugins("datepicker/datepicker", "css", 10);
        $this->load->addPlugins("selectpicker/js/bootstrap-select", "js", 10);
        $this->load->addPlugins("selectpicker/css/bootstrap-select", "css", 10);

        $this->load->model('Event', 'event', TRUE);
        $this->event->setId($this->uri->segments[3]);
        $this->load->template('event/add_edit_form', array(
            "action" => site_url(self::class . "/edit_submit"),
            "method" => "post",
            "event" => $this->event,
            "grades" => Event::getGrades(1)
        ));
    }

    public function add_submit() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[4]');
        $this->form_validation->set_rules("from-date", 'From date', 'required');
        $this->form_validation->set_rules("to-date", 'From date', 'required');
        $this->form_validation->set_rules("trek-distance", 'Trek distance', 'required');
        $this->form_validation->set_rules("distance-from-bangalore", 'Distance from bangalore', 'required');
        $this->form_validation->set_rules("grade", 'Grade', 'required');
        $this->form_validation->set_rules("cost", 'Cost', 'required');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "type" => "danger",
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        $this->load->model('Event', 'event', TRUE);
        $this->event->setName($this->input->post("name", TRUE));
        $this->event->setFrom_date($this->input->post("from-date", TRUE));
        $this->event->setTo_date($this->input->post("to-date", TRUE));
        $this->event->setTrek_distance($this->input->post("trek-distance", TRUE));
        $this->event->setDistance_from_bangalore($this->input->post("distance-from-bangalore", TRUE));
        $this->event->setDescription($this->input->post("description", TRUE));
        $this->event->setAccommodation($this->input->post("accommodation", TRUE));
        $this->event->setTransportation($this->input->post("transportation", TRUE));
        $this->event->setEgid($this->input->post("grade", TRUE));
        $this->event->setCost($this->input->post("cost", TRUE));
        $this->event->setFood($this->input->post("food", TRUE));
        $this->event->setThings_to_carry($this->input->post("things-to-carry", TRUE));
        $this->event->setTerms_and_conditions($this->input->post("terms-and-conditions", TRUE));
        $this->event->setEsid(1);
        $this->event->setCreated_auid($this->session->userdata("logged_in_auid"));
        if (!$this->event->insert()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Failed to save data!"
            )))->_display();
            exit;
        }

        $this->output->set_output(json_encode(array(
            "success" => TRUE,
            "url" => site_url(self::class),
            "message" => "Data saved successfully!"
        )))->_display();
        exit;
    }

    public function edit_submit() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'Id', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[4]');
        $this->form_validation->set_rules("from-date", 'From date', 'required');
        $this->form_validation->set_rules("to-date", 'From date', 'required');
        $this->form_validation->set_rules("trek-distance", 'Trek distance', 'required');
        $this->form_validation->set_rules("distance-from-bangalore", 'Distance from bangalore', 'required');
        $this->form_validation->set_rules("grade", 'Grade', 'required');
        $this->form_validation->set_rules("cost", 'Cost', 'required');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "type" => "danger",
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        $this->load->model('Event', 'event', TRUE);
        $this->event->setId($this->input->post("id", TRUE));
        $this->event->setName($this->input->post("name", TRUE));
        $this->event->setFrom_date($this->input->post("from-date", TRUE));
        $this->event->setTo_date($this->input->post("to-date", TRUE));
        $this->event->setTrek_distance($this->input->post("trek-distance", TRUE));
        $this->event->setDistance_from_bangalore($this->input->post("distance-from-bangalore", TRUE));
        $this->event->setDescription($this->input->post("description", TRUE));
        $this->event->setAccommodation($this->input->post("accommodation", TRUE));
        $this->event->setTransportation($this->input->post("transportation", TRUE));
        $this->event->setEgid($this->input->post("grade", TRUE));
        $this->event->setCost($this->input->post("cost", TRUE));
        $this->event->setFood($this->input->post("food", TRUE));
        $this->event->setThings_to_carry($this->input->post("things-to-carry", TRUE));
        $this->event->setTerms_and_conditions($this->input->post("terms-and-conditions", TRUE));
        $this->event->setUpdated_auid($this->session->userdata("logged_in_auid"));
        if (!$this->event->update()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Failed to save data!"
            )))->_display();
            exit;
        }

        $this->output->set_output(json_encode(array(
            "success" => TRUE,
            "url" => site_url(self::class),
            "message" => "Data saved successfully!"
        )))->_display();
        exit;
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
            array('db' => 'cost', 'dt' => $i++),
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
