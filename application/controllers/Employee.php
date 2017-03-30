<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends MY_Controller {

    public function index() {
        $this->load->setTitle("Manage Employees");
        $this->load->setDescription("Manage employee details");
        $this->load->addScripts("modules/employee");
        $this->load->addPlugins("datatables/jquery.dataTables", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "js", 10);
//            $this->load->addPlugins("datatables/jquery.dataTables", "css", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "css", 10);
        $this->load->addPlugins("datatables/extensions/Buttons/js/buttons.dataTables", "js", 10);
        $this->load->addPlugins("datatables/extensions/Buttons/css/buttons.dataTables", "css", 10);
        $this->load->template('employee/manage', array(
            "render_url" => site_url(self::class . "/render")
        ));
    }

    public function add() {
        $this->load->setTitle("Add Employees");
        $this->load->setDescription("Provide employee details and save");
        $this->load->template('employee/add', array(
            "action" => site_url(self::class . "/add_submit"),
            "method" => "post"
        ));
    }
    
    public function add_submit(){
        
    }

    public function render() {
        $this->load->library("SSP_lib", NULL, "ssp");
        $this->load->database();

        $this->ssp->setTable('employee');
        $this->ssp->setPrimary_key('emp_id');

        $i = 0;
        $columns = array(
            array('db' => 'emp_id', 'dt' => $i++),
            array('db' => 'first_name', 'dt' => $i++),
            array('db' => 'email', 'dt' => $i++),
            array('db' => 'phone', 'dt' => $i++),
            array('db' => 'mobile', 'dt' => $i++),
            array('db' => 'created_time', 'dt' => $i++),
            array('db' => 'updated_time', 'dt' => $i++),
            array('db' => 'created_emp', 'dt' => $i++),
            array('db' => 'updated_emp', 'dt' => $i++)
        );
        $this->ssp->setColumns($columns);

        $this->ssp->setDb($this->db);
        $this->ssp->setInput($this->input->post());

        echo $this->ssp->render();
    }

}
