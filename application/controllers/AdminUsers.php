<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AdminUsers extends MY_Controller {

    public function index() {
        $this->load->setTitle("Manage Admin Users");
        $this->load->setDescription("Manage admin user details");

        $this->load->addPlugins("bootstrap/js/bootbox", "js", 10);
        $this->load->addPlugins("selectpicker/js/bootstrap-select", "js", 10);
        $this->load->addPlugins("selectpicker/css/bootstrap-select", "css", 10);
        $this->load->addPlugins("datatables/jquery.dataTables", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "js", 12);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "css", 10);
        $this->load->addPlugins("datatables/extensions/Buttons/js/buttons.bootstrap", "js", 12);
        $this->load->addPlugins("datatables/extensions/Buttons/css/buttons.bootstrap", "scss", 12);
        $this->load->addPlugins("datatables/extensions/Buttons/js/dataTables.buttons", "js", 12);
        $this->load->addPlugins("datatables/extensions/Buttons/css/buttons.dataTables", "scss", 12);
        $this->load->addPlugins("datatables/extensions/Buttons/js/buttons.flash", "js", 13);
        $this->load->addPlugins("datatables/extensions/Buttons/js/jszip.min", "js", 13);
        $this->load->addPlugins("datatables/extensions/Buttons/js/vfs_fonts", "js", 13);
        $this->load->addPlugins("datatables/extensions/Buttons/js/pdfmake.min", "js", 13);
        $this->load->addPlugins("datatables/extensions/Buttons/js/buttons.html5", "js", 13);
        $this->load->addPlugins("datatables/extensions/Buttons/js/buttons.print", "js", 13);

        $this->load->addScripts("modules/admin_user");

        $this->load->model('AdminUser', 'admin_user', TRUE);

        $this->load->template('admin_user/manage', array(
            "render_url" => site_url(self::class . "/render"),
            "status_action" => site_url(self::class . "/change_status"),
            "status_method" => "post",
            "statuses" => AdminUser::getStatuses()
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
        if ($this->admin_user->getAusid() == 4) {
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
        $password = get_random_string();
        $hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);

        $this->load->model('AdminUser', 'admin_user', TRUE);
        $this->admin_user->setFirst_name($this->input->post("first-name", TRUE));
        $this->admin_user->setLast_name($this->input->post("last-name", TRUE));
        $this->admin_user->setEmail($this->input->post("email", TRUE));
        $this->admin_user->setPhone($this->input->post("phone", TRUE));
        $this->admin_user->setMobile($this->input->post("mobile", TRUE));
        $this->admin_user->setAusid(2);
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
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        $this->load->model('AdminUser', 'admin_user', TRUE);
        $this->admin_user->setId($this->input->post("id", TRUE));
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

    public function render() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->model("AdminUser", "admin_user", TRUE);

        $this->load->library("SSP_lib", NULL, "ssp");
        $this->load->database();

        $this->ssp->setTable('admin_user');
        $this->ssp->setPrimary_key('au.auid');
        $this->ssp->setJoin_query('FROM admin_user AS au LEFT JOIN admin_user_status AS aus ON au.ausid = aus.ausid '
                . 'LEFT JOIN admin_user AS au1 ON au.created_auid = au1.auid LEFT JOIN admin_user AS au2 ON au.updated_auid = au2.auid');

        $status_formatter = function($id, $row) {
            return AdminUser::getStatusLabel($id, $row);
        };
        $action_formatter = function($id, $row) {
            return $this->load->view('admin_user/action', array("id" => $id, "row" => $row), TRUE);
        };
        $created_user_formatter = function ($id, $row) {
            return "<a href='" . site_url(self::class . "/view/" . $id) . "' target='_blank'>" . trim($row["created_user_first_name"] . " " . $row["created_user_last_name"]) . "</a>";
        };
        $updated_user_formatter = function ($id, $row) {
            return "<a href='" . site_url(self::class . "/view/" . $id) . "' target='_blank'>" . trim($row["updated_user_first_name"] . " " . $row["updated_user_last_name"]) . "</a>";
        };

        $i = 0;
        $columns = array(
            array('db' => 'au.auid', 'field' => 'auid', 'dt' => $i++),
            array('db' => 'au.first_name', 'field' => 'first_name', 'dt' => $i++),
            array('db' => 'au.last_name', 'field' => 'last_name', 'dt' => $i++),
            array('db' => 'au.email', 'field' => 'email', 'dt' => $i++),
            array('db' => 'au.phone', 'field' => 'phone', 'dt' => $i++),
            array('db' => 'au.mobile', 'field' => 'mobile', 'dt' => $i++),
            array('db' => 'aus.name', 'field' => 'status', 'as' => 'status', 'dt' => $i++, "formatter" => $status_formatter),
            array('db' => 'au.created_auid', 'field' => 'created_auid', 'dt' => $i++, "formatter" => $created_user_formatter),
            array('db' => 'au.updated_auid', 'field' => 'updated_auid', 'dt' => $i++, "formatter" => $updated_user_formatter),
            array('db' => 'au.created_time', 'field' => 'created_time', 'dt' => $i++),
            array('db' => 'au.updated_time', 'field' => 'updated_time', 'dt' => $i++),
            array('db' => 'au.auid', 'field' => 'auid', 'dt' => $i++, "formatter" => $action_formatter),
            array('db' => 'aus.ausid', 'field' => 'ausid', 'dt' => $i++), // Extras
            array('db' => 'aus.icon', 'field' => 'icon', 'dt' => $i++),
            array('db' => 'aus.color', 'field' => 'color', 'dt' => $i++),
            array('db' => 'aus.austid', 'field' => 'austid', 'dt' => $i++),
            array('db' => 'au1.first_name', 'field' => 'created_user_first_name', 'as' => 'created_user_first_name', 'dt' => $i++),
            array('db' => 'au1.last_name', 'field' => 'created_user_last_name', 'as' => 'created_user_last_name', 'dt' => $i++),
            array('db' => 'au2.first_name', 'field' => 'updated_user_first_name', 'as' => 'updated_user_first_name', 'dt' => $i++),
            array('db' => 'au2.last_name', 'field' => 'updated_user_last_name', 'as' => 'updated_user_last_name', 'dt' => $i++)
        );
        $this->ssp->setColumns($columns);

        $this->ssp->setDb($this->db);
        $this->ssp->setInput($this->input->post());

        $this->output->set_output($this->ssp->render())->_display();
        exit;
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

    public function change_status() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->model('AdminUser', 'admin_user', TRUE);
        $this->admin_user->setId($this->input->post("id"));
        if (!$this->admin_user->getAusid()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Invalid admin user!"
            )))->_display();
            exit;
        }

        $this->admin_user->setAusid($this->input->post("status"));
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
            "type" => "success",
            "message" => "Data saved successfully!"
        )))->_display();
        exit;
    }

}
