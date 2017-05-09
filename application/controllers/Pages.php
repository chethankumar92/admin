<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller {

    public function index() {
        $this->load->setTitle("Manage Pages");
        $this->load->setDescription("Manage page details");
        $this->load->addScripts("modules/page");
        $this->load->addPlugins("datatables/jquery.dataTables", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "css", 10);
        $this->load->template('page/manage', array(
            "render_url" => site_url(self::class . "/render")
        ));
    }

    public function add() {
        $this->load->setTitle("Add Page");
        $this->load->setDescription("Provide page details and save");

        $this->load->addPlugins("summernote/summernote", "js", 10);
        $this->load->addPlugins("summernote/summernote", "css", 10);

        $this->load->model('Page', 'page', TRUE);
        $this->load->template('page/add_edit_form', array(
            "action" => site_url(self::class . "/add_submit"),
            "method" => "post",
            "page" => $this->page
        ));
    }

    public function edit($id) {
        if (!is_numeric($id)) {
            redirect(self::class);
        }

        $this->load->addPlugins("summernote/summernote", "js", 10);
        $this->load->addPlugins("summernote/summernote", "css", 10);

        $this->load->model('Page', 'page', TRUE);
        $this->page->setId($id);
        if (!$this->page->getPsid()) {
            redirect(self::class);
        }

        $this->load->setTitle("Edit Page");
        $this->load->setDescription("Provide page details and save");

        $this->load->template('page/add_edit_form', array(
            "action" => site_url(self::class . "/edit_submit"),
            "method" => "post",
            "page" => $this->page
        ));
    }

    public function add_submit() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required|min_length[4]');
        $this->form_validation->set_rules("content", 'Content', 'required');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "type" => "danger",
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        $this->load->model('Page', 'page', TRUE);
        $this->page->setTitle($this->input->post("title", TRUE));
        $this->page->setContent($this->input->post("content", TRUE));
        $this->page->setPsid(2);
        $this->page->setCreated_auid($this->session->userdata("logged_in_auid"));
        if (!$this->page->insert()) {
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
        $this->form_validation->set_rules('title', 'Title', 'required|min_length[4]');
        $this->form_validation->set_rules("content", 'Content', 'required');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "type" => "danger",
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        $this->load->model('Page', 'page', TRUE);
        $this->page->setId($this->input->post("id", TRUE));
        $this->page->setTitle($this->input->post("title", TRUE));
        $this->page->setContent($this->input->post("content", TRUE));
        $this->page->setPsid(2);
        $this->page->setUpdated_auid($this->session->userdata("logged_in_auid"));
        if (!$this->page->update()) {
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

        $this->ssp->setTable('page');
        $this->ssp->setPrimary_key('pid');

        $i = 0;
        $columns = array(
            array('db' => 'pid', 'dt' => $i++),
            array('db' => 'title', 'dt' => $i++),
            array('db' => 'content', 'dt' => $i++),
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

    public function view($id) {
        if (!is_numeric($id)) {
            redirect(self::class);
        }

        $this->load->model('Page', 'page', TRUE);
        $this->page->setId($id);
        if (!$this->page->getPsid()) {
            redirect(self::class);
        }

        $this->load->setTitle("View Page");
        $this->load->setDescription("Details of the page");

        $this->load->template('page/view', array(
            "page" => $this->page
        ));
    }

}
