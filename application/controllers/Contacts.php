<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends MY_Controller {

    public function index() {
        $this->load->setTitle("Manage Contacts");
        $this->load->setDescription("Manage contact details");

        $this->load->addPlugins("bootstrap/js/bootbox", "js", 10);
        $this->load->addPlugins("selectpicker/js/bootstrap-select", "js", 10);
        $this->load->addPlugins("selectpicker/css/bootstrap-select", "css", 10);
        $this->load->addPlugins("datatables/jquery.dataTables", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "js", 12);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "css", 10);

        $this->load->addScripts("modules/contact");

        $this->load->model('Contact', 'contact', TRUE);

        $this->load->template('contact/manage', array(
            "render_url" => site_url(self::class . "/render"),
            "status_action" => site_url(self::class . "/change_status"),
            "status_method" => "post",
            "statuses" => Contact::getStatuses()
        ));
    }

    public function add() {
        $this->load->setTitle("Add Contact");
        $this->load->setDescription("Provide contact details and save");

        $this->load->model('Contact', 'contact', TRUE);
        $this->load->template('contact/add_edit_form', array(
            "action" => site_url(self::class . "/add_submit"),
            "method" => "post",
            "contact" => $this->contact
        ));
    }

    public function edit($id) {
        if (!is_numeric($id)) {
            redirect(self::class);
        }

        $this->load->model('Contact', 'contact', TRUE);
        $this->contact->setId($id);
        if ($this->contact->getCsid() == 3) {
            redirect(self::class);
        }

        $this->load->setTitle("Edit Contact");
        $this->load->setDescription("Provide contact details and save");

        $this->load->template('contact/add_edit_form', array(
            "action" => site_url(self::class . "/edit_submit"),
            "method" => "post",
            "contact" => $this->contact
        ));
    }

    public function add_submit() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules("name", 'Name', 'required|min_length[3]|max_length[31]');
        $this->form_validation->set_rules("email", 'Email', 'valid_email');
        $this->form_validation->set_rules("mobile", 'Mobile', 'integer');
        $this->form_validation->set_rules('subject', 'Subject', 'required|min_length[4]|max_length[63]');
        $this->form_validation->set_rules('message', 'Message', 'required|min_length[10]|max_length[255]');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid contact details!"
            )))->_display();
            exit;
        }

        if (!trim($this->input->post("email")) && !trim($this->input->post("mobile"))) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Email or mobile number is needed to contact!"
            )))->_display();
            exit;
        }

        $this->load->model('Contact', 'contact', TRUE);
        $this->contact->setName($this->input->post("name", TRUE));
        $this->contact->setEmail($this->input->post("email", TRUE));
        $this->contact->setMobile($this->input->post("mobile", TRUE));
        $this->contact->setSubject($this->input->post("subject", TRUE));
        $this->contact->setMessage($this->input->post("message", TRUE));
        $this->contact->setCsid(1);
        $this->contact->setCreated_auid($this->session->userdata("logged_in_auid"));
        if (!$this->contact->insert()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Failed to save the contact details!"
            )))->_display();
            exit;
        }

        if (trim($this->contact->getEmail())) {
            $this->load->library('email');
            $this->email->from('mountaintrekkersblr@gmail.com', 'Mountain Trekkers');
            $this->email->to($this->contact->getEmail());
            $this->email->subject("Acknowledgement: " . $this->contact->getSubject());
            $this->email->message("Hi " . $this->contact->getName() . ",<br><br>"
                    . "Thank you for your interest in our services. This is an acknowledgement for your request. Our representative will contact you shortly.<br><br>"
                    . "Following are the details of your request for your reference,<br>"
                    . "<b>Subject:</b> <i>" . $this->contact->getSubject() . "</i><br>"
                    . "<b>Messsage:</b> <i>" . $this->contact->getMessage() . "</i><br><br>"
                    . "Regards<br>"
                    . "Mountain Trekkers");
            $this->email->send();
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

        sleep(3);
        $this->output->set_output(json_encode(array(
            "success" => FALSE,
            "message" => "Invalid data!"
        )))->_display();
        exit;

        $this->load->library('form_validation');
        $this->form_validation->set_rules("id", 'Id', 'required');
        $this->form_validation->set_rules("name", 'Name', 'required|min_length[3]|max_length[31]');
        $this->form_validation->set_rules("email", 'Email', 'valid_email');
        $this->form_validation->set_rules("mobile", 'Mobile', 'integer');
        $this->form_validation->set_rules('subject', 'Subject', 'required|min_length[4]|max_length[63]');
        $this->form_validation->set_rules('message', 'Message', 'required|min_length[10]|max_length[255]');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        if (!trim($this->input->post("email")) && !trim($this->input->post("mobile"))) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Email or mobile number is needed to contact!"
            )))->_display();
            exit;
        }

        $this->load->model('Contact', 'contact', TRUE);
        $this->contact->setId($this->input->post("id", TRUE));
        if ($this->contact->getCsid() == 3) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Deleted contact cannot be edited!"
            )))->_display();
            exit;
        }

        $this->contact->setName($this->input->post("name", TRUE));
        $this->contact->setEmail($this->input->post("email", TRUE));
        $this->contact->setMobile($this->input->post("mobile", TRUE));
        $this->contact->setSubject($this->input->post("subject", TRUE));
        $this->contact->setMessage($this->input->post("message", TRUE));
        $this->contact->setUpdated_auid($this->session->userdata("logged_in_auid"));
        if (!$this->contact->update()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Failed to save the data!"
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

        $this->load->model("Contact", "contact", TRUE);

        $this->load->library("SSP_lib", NULL, "ssp");
        $this->load->database();

        $this->ssp->setTable('contact');
        $this->ssp->setPrimary_key('cid');
        $this->ssp->setJoin_query(' FROM contact AS c LEFT JOIN contact_status AS cs ON c.csid = cs.csid');

        $status_formatter = function($id, $row) {
            return Contact::getStatusLabel($id, $row);
        };
        $action_formatter = function($id, $row) {
            return $this->load->view('contact/action', array("id" => $id, "row" => $row), TRUE);
        };

        $i = 0;
        $columns = array(
            array('db' => 'c.cid', 'field' => 'cid', 'dt' => $i++),
            array('db' => 'c.name', 'field' => 'name', 'dt' => $i++),
            array('db' => 'c.email', 'field' => 'email', 'dt' => $i++),
            array('db' => 'c.mobile', 'field' => 'mobile', 'dt' => $i++),
            array('db' => 'c.subject', 'field' => 'subject', 'dt' => $i++),
            array('db' => 'c.message', 'field' => 'message', 'dt' => $i++),
            array('db' => 'cs.name', 'field' => 'status', 'as' => 'status', 'dt' => $i++, "formatter" => $status_formatter),
            array('db' => 'c.created_auid', 'field' => 'created_auid', 'dt' => $i++),
            array('db' => 'c.updated_auid', 'field' => 'updated_auid', 'dt' => $i++),
            array('db' => 'c.created_time', 'field' => 'created_time', 'dt' => $i++),
            array('db' => 'c.updated_time', 'field' => 'updated_time', 'dt' => $i++),
            array('db' => 'c.cid', 'field' => 'cid', 'dt' => $i++, "formatter" => $action_formatter),
            array('db' => 'cs.csid', 'field' => 'csid', 'dt' => $i++), // Extras
            array('db' => 'cs.icon', 'field' => 'icon', 'dt' => $i++),
            array('db' => 'cs.color', 'field' => 'color', 'dt' => $i++),
            array('db' => 'cs.cstid', 'field' => 'cstid', 'dt' => $i++)
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

        $this->load->model('Contact', 'contact', TRUE);
        $this->contact->setId($id);
        if (!$this->contact->getCsid()) {
            redirect(self::class);
        }

        $this->load->setTitle("View Contact");
        $this->load->setDescription("Details of the contact");

        $this->load->template('contact/view', array(
            "contact" => $this->contact
        ));
    }

    public function change_status() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->model('Contact', 'contact', TRUE);
        $this->contact->setId($this->input->post("id"));
        if (!$this->contact->getCsid()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Invalid contact!"
            )))->_display();
            exit;
        }

        $this->contact->setCsid($this->input->post("status"));
        $this->contact->setUpdated_auid($this->session->userdata("logged_in_auid"));
        if (!$this->contact->update()) {
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
