<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

    public function index() {
        $this->load->setTitle("Manage Profile");
        $this->load->setDescription("Manage your details");

        $this->load->addPlugins("bootstrap/js/bootbox", "js", 10);
        $this->load->addPlugins("selectpicker/js/bootstrap-select", "js", 10);
        $this->load->addPlugins("selectpicker/css/bootstrap-select", "css", 10);
        $this->load->addPlugins("datatables/jquery.dataTables", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "js", 12);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "css", 10);

        $this->load->addScripts("modules/admin_user");

        $this->load->model('AdminUser', 'logged_in_user', TRUE);
        $this->logged_in_user->setId($this->session->userdata("logged_in_auid"));

        $this->load->template('admin_user/profile', array(
            "method" => "post",
            "logout_action" => site_url(Logout::class . "/log_out"),
            "logged_in_user" => $this->logged_in_user,
            "profile_url" => site_url(self::class . "/save"),
            "password_url" => site_url(self::class . "/change_password")
        ));
    }

    public function save() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('first-name', 'First name', 'required|min_length[4]');
        $this->form_validation->set_rules("email", 'Email', 'required|valid_email');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        $this->load->model('AdminUser', 'admin_user', TRUE);
        $this->admin_user->setId($this->session->userdata("logged_in_auid"));
        if ($this->admin_user->getAusid() == 4) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "errors" => $this->form_validation->error_array(),
                "message" => "Deleted admin user cannot be edited!"
            )))->_display();
            exit;
        }

        $this->admin_user->setFirst_name($this->input->post("first-name", TRUE));
        $this->admin_user->setLast_name($this->input->post("last-name", TRUE));
        $this->admin_user->setEmail($this->input->post("email", TRUE));
        $this->admin_user->setPhone($this->input->post("phone", TRUE));
        $this->admin_user->setMobile($this->input->post("mobile", TRUE));
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

    public function change_password() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('old-password', 'Old password', 'required|min_length[4]');
        $this->form_validation->set_rules('new-password', 'New password', 'required|min_length[4]');
        $this->form_validation->set_rules('re-password', 'Re-entered password', 'required|min_length[4]');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        if (trim($this->input->post("new-password", TRUE)) != trim($this->input->post("re-password", TRUE))) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "errors" => $this->form_validation->error_array(),
                "message" => "New password and re-entered password do not match!"
            )))->_display();
            exit;
        }

        $this->load->model('AdminUser', 'admin_user', TRUE);
        $this->admin_user->setId($this->session->userdata("logged_in_auid"));
        if ($this->admin_user->getAusid() == 4) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "errors" => $this->form_validation->error_array(),
                "message" => "Deleted admin user cannot be edited!"
            )))->_display();
            exit;
        }

        $this->load->helper('phpass');
        $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);

        $old_password = $this->input->post("old-password", TRUE);
        if (!$hasher->check_password($old_password, $this->admin_user->getPassword())) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Old password is incorrect!"
            )))->_display();
            exit;
        }

        $new_password = $this->input->post("new-password", TRUE);
        $this->admin_user->setPassword($hasher->hash_password($new_password));
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

}
