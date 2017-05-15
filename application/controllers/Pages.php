<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller {

    public function index() {
        $this->load->setTitle("Manage Pages");
        $this->load->setDescription("Manage page details");

        $this->load->addPlugins("bootstrap/js/bootbox", "js", 10);
        $this->load->addPlugins("selectpicker/js/bootstrap-select", "js", 10);
        $this->load->addPlugins("selectpicker/css/bootstrap-select", "css", 10);
        $this->load->addPlugins("datatables/jquery.dataTables", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "js", 12);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "css", 10);

        $this->load->addScripts("modules/page");

        $this->load->model('Page', 'page', TRUE);

        $this->load->template('page/manage', array(
            "render_url" => site_url(self::class . "/render"),
            "status_action" => site_url(self::class . "/change_status"),
            "status_method" => "post",
            "statuses" => Page::getStatuses()
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
        if ($this->page->getPsid() == 4) {
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
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        $this->load->model('Page', 'page', TRUE);
        $this->page->setId($this->input->post("id", TRUE));
        if ($this->page->getPsid() == 4) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "errors" => $this->form_validation->error_array(),
                "message" => "Deleted page cannot be edited!"
            )))->_display();
            exit;
        }

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

        $this->load->model("Page", "page", TRUE);

        $this->load->library("SSP_lib", NULL, "ssp");
        $this->load->database();

        $this->ssp->setTable('page');
        $this->ssp->setPrimary_key('pid');
        $this->ssp->setJoin_query(' FROM page AS p LEFT JOIN page_status AS ps ON p.psid = ps.psid');

        $status_formatter = function($id, $row) {
            return Page::getStatusLabel($id, $row);
        };
        $action_formatter = function($id, $row) {
            return $this->load->view('page/action', array("id" => $id, "row" => $row), TRUE);
        };

        $i = 0;
        $columns = array(
            array('db' => 'p.pid', 'field' => 'pid', 'dt' => $i++),
            array('db' => 'p.title', 'field' => 'title', 'dt' => $i++),
            array('db' => 'p.content', 'field' => 'content', 'dt' => $i++),
            array('db' => 'ps.name', 'field' => 'status', 'as' => 'status', 'dt' => $i++, "formatter" => $status_formatter),
            array('db' => 'p.created_auid', 'field' => 'created_auid', 'dt' => $i++),
            array('db' => 'p.updated_auid', 'field' => 'updated_auid', 'dt' => $i++),
            array('db' => 'p.created_time', 'field' => 'created_time', 'dt' => $i++),
            array('db' => 'p.updated_time', 'field' => 'updated_time', 'dt' => $i++),
            array('db' => 'p.pid', 'field' => 'pid', 'dt' => $i++, "formatter" => $action_formatter),
            array('db' => 'ps.psid', 'field' => 'psid', 'dt' => $i++), // Extras
            array('db' => 'ps.icon', 'field' => 'icon', 'dt' => $i++),
            array('db' => 'ps.color', 'field' => 'color', 'dt' => $i++),
            array('db' => 'ps.pstid', 'field' => 'pstid', 'dt' => $i++)
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

    public function change_status() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->model('Page', 'page', TRUE);
        $this->page->setId($this->input->post("id"));
        if (!$this->page->getPsid()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Invalid page!"
            )))->_display();
            exit;
        }

        $this->page->setPsid($this->input->post("status"));
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
            "type" => "success",
            "message" => "Data saved successfully!"
        )))->_display();
        exit;
    }

}
