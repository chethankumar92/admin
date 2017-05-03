<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminUsers extends MY_Controller {

    public function index() {
        $this->load->setTitle("Manage Admin Users");
        $this->load->setDescription("Manage admin user details");
        $this->load->addScripts("modules/admin_user");
        $this->load->addPlugins("datatables/jquery.dataTables", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "css", 10);
        $this->load->template('admin_user/manage', array(
            "render_url" => site_url(self::class . "/render")
        ));
    }

    public function add() {
        $this->load->setTitle("Add Admin User");
        $this->load->setDescription("Provide admin user details and save");

        $this->load->model('AdminUser', 'admin_user', TRUE);
        $this->load->template('admin_user/add_edit_form', array(
            "action" => site_url(self::class . "/add_submit"),
            "method" => "post",
            "admin_user" => $this->admin_user
        ));
    }

    public function edit($id) {
        if (!is_numeric($id)) {
            redirect(self::class);
        }

        $this->load->model('AdminUser', 'admin_user', TRUE);
        $this->admin_user->setId($id);
        if (!$this->admin_user->getAusid()) {
            redirect(self::class);
        }

        $this->load->setTitle("Edit Admin User");
        $this->load->setDescription("Provide admin user details and save");

        $this->load->template('admin_user/add_edit_form', array(
            "action" => site_url(self::class . "/edit_submit"),
            "method" => "post",
            "admin_user" => $this->admin_user
        ));
    }

    public function add_submit() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('first-name', 'First name', 'required|min_length[4]');
        $this->form_validation->set_rules("email", 'Email', 'required|valid_email');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "type" => "danger",
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        $this->load->helper('phpass');
        $password = get_random_password();
        $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);

        $this->load->model('AdminUser', 'admin_user', TRUE);
        $this->admin_user->setFirst_name($this->input->post("first-name", TRUE));
        $this->admin_user->setLast_name($this->input->post("last-name", TRUE));
        $this->admin_user->setEmail($this->input->post("email", TRUE));
        $this->admin_user->setPhone($this->input->post("phone", TRUE));
        $this->admin_user->setMobile($this->input->post("mobile", TRUE));
        $this->admin_user->setAusid(1);
        $this->admin_user->setPassword($hasher->hash_password($password));
        $this->admin_user->setCreated_auid($this->session->userdata("logged_in_auid"));
        if (!$this->admin_user->insert()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Failed to save data!"
            )))->_display();
            exit;
        }

        if ($this->admin_user->getEmail()) {
            $this->load->library('email');
            $this->email->from('mountaintrekkersblr@gmail.com', 'Mountain Trekkers');
            $this->email->to($this->input->post("email"));
            $this->email->subject("Registration: You are now an admin user");
            $this->email->message("Hi " . $this->admin_user->getFirst_name() . ",<br><br>"
                    . "You are registered as an admin user for <a href='" . site_url() . "'>Mountain Trekkers</a> administrative portal.<br><br>"
                    . "Following are the credetials with which you can access the portal,<br>"
                    . "<b>Email:</b> <i>" . $this->admin_user->getEmail() . "</i><br>"
                    . "<b>Password:</b> <i>" . $password . "</i><br><br>"
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

        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'Id', 'required');
        $this->form_validation->set_rules('first-name', 'First name', 'required|min_length[4]');
        $this->form_validation->set_rules("email", 'Email', 'required|valid_email');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "type" => "danger",
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        $this->load->model('AdminUser', 'admin_user', TRUE);
        $this->admin_user->setId($this->input->post("id", TRUE));
        $this->admin_user->setFirst_name($this->input->post("first-name", TRUE));
        $this->admin_user->setLast_name($this->input->post("last-name", TRUE));
        $this->admin_user->setEmail($this->input->post("email", TRUE));
        $this->admin_user->setPhone($this->input->post("phone", TRUE));
        $this->admin_user->setMobile($this->input->post("mobile", TRUE));
        $this->admin_user->setAusid(1);
        $this->admin_user->setUpdated_auid($this->session->userdata("logged_in_auid"));
        if (!$this->admin_user->update()) {
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

        $this->ssp->setTable('admin_user');
        $this->ssp->setPrimary_key('auid');

        $i = 0;
        $columns = array(
            array('db' => 'auid', 'dt' => $i++),
            array('db' => 'first_name', 'dt' => $i++),
            array('db' => 'last_name', 'dt' => $i++),
            array('db' => 'email', 'dt' => $i++),
            array('db' => 'phone', 'dt' => $i++),
            array('db' => 'mobile', 'dt' => $i++),
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

        $this->load->model('AdminUser', 'admin_user', TRUE);
        $this->admin_user->setId($id);
        if (!$this->admin_user->getAusid()) {
            redirect(self::class);
        }

        $this->load->setTitle("View Admin User");
        $this->load->setDescription("Details of the admin user");

        $this->load->template('admin_user/view', array(
            "admin_user" => $this->admin_user
        ));
    }

}
