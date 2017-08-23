<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonials extends MY_Controller {

    public function index() {
        $this->load->setTitle("Manage Testimonials");
        $this->load->setDescription("Manage testimonial details");

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

        $this->load->addScripts("modules/testimonial");

        $this->load->model('Testimonial', 'testimonial', TRUE);

        $this->load->template('testimonial/manage', array(
            "render_url" => site_url(self::class . "/render"),
            "status_action" => site_url(self::class . "/change_status"),
            "status_method" => "post",
            "statuses" => Testimonial::getStatuses()
        ));
    }

    public function add() {
        $this->load->setTitle("Add Testimonial");
        $this->load->setDescription("Provide testimonial details and save");

        $this->load->addPlugins("dropzone/dropzone", "js", 10);
        $this->load->addPlugins("dropzone/dropzone", "css", 10);

        $this->load->addScripts("modules/testimonial");

        $this->load->model('Testimonial', 'testimonial', TRUE);
        $this->load->template('testimonial/add_edit_form', array(
            "action" => site_url(self::class . "/add_submit"),
            "method" => "post",
            "upload" => site_url(self::class . "/upload"),
            "remove" => site_url(self::class . "/remove"),
            "testimonial" => $this->testimonial
        ));
    }

    public function edit($id) {
        if (!is_numeric($id)) {
            redirect(self::class);
        }

        $this->load->model('Testimonial', 'testimonial', TRUE);
        $this->testimonial->setId($id);
        if ($this->testimonial->getTsid() == 4) {
            redirect(self::class);
        }

        $this->load->setTitle("Edit Testimonial");
        $this->load->setDescription("Provide testimonial details and save");

        $this->load->addPlugins("dropzone/dropzone", "js", 10);
        $this->load->addPlugins("dropzone/dropzone", "css", 10);

        $this->load->addScripts("modules/testimonial");

        $this->load->template('testimonial/add_edit_form', array(
            "action" => site_url(self::class . "/edit_submit"),
            "method" => "post",
            "upload" => site_url(self::class . "/upload"),
            "remove" => site_url(self::class . "/remove"),
            "testimonial" => $this->testimonial
        ));
    }

    public function add_submit() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[4]');
        $this->form_validation->set_rules('designation', 'Designation', 'required|min_length[4]');
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

        $this->load->model('Testimonial', 'testimonial', TRUE);
        $this->testimonial->setName($this->input->post("name", TRUE));
        $this->testimonial->setDesignation($this->input->post("designation", TRUE));
        $this->testimonial->setContent($this->input->post("content", TRUE));

        $uploaded = '';
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = TRUE;
        $images = json_decode($this->input->post('images'), TRUE);
        foreach ($images as $image) {
            $config['source_image'] = realpath(APPPATH . '../../files/testimonial') . "/" . $image["file_name"];
            $sizes = array(
                IMAGE_LARGE_FOLDER => array(
                    IMAGE_LARGE_WIDTH, IMAGE_LARGE_HEIGHT
                ),
                IMAGE_MEDIUM_FOLDER => array(
                    IMAGE_MEDIUM_WIDTH, IMAGE_MEDIUM_HEIGHT
                ),
                IMAGE_SMALL_FOLDER => array(
                    IMAGE_SMALL_WIDTH, IMAGE_SMALL_HEIGHT
                ),
                IMAGE_THUMBNAIL_FOLDER => array(
                    IMAGE_THUMBNAIL_WIDTH, IMAGE_THUMBNAIL_HEIGHT
                )
            );
            foreach ($sizes as $folder => $size) {
                $config['width'] = $size[0];
                $config['height'] = $size[1];
                $config['new_image'] = realpath(APPPATH . '../../files/testimonial') . "/" . $folder . '/' . $image['file_name'];
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    $this->output->set_output(json_encode(array(
                        "success" => FALSE,
                        "message" => "Failed to save image!",
                        "data" => $this->image_lib->display_errors('<p>', '</p>')
                    )))->_display();
                    exit;
                }
                $this->image_lib->clear();
            }
            $uploaded = $image['file_name'];
        }

        $this->testimonial->setImage($uploaded);
        $this->testimonial->setTsid(1);
        $this->testimonial->setCreated_auid($this->session->userdata("logged_in_auid"));
        if (!$this->testimonial->insert()) {
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
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[4]');
        $this->form_validation->set_rules('designation', 'Designation', 'required|min_length[4]');
        $this->form_validation->set_rules("content", 'Content', 'required');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        $this->load->model('Testimonial', 'testimonial', TRUE);
        $this->testimonial->setId($this->input->post("id", TRUE));
        if ($this->testimonial->getTsid() == 3) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "errors" => $this->form_validation->error_array(),
                "message" => "Deleted testimonial cannot be edited!"
            )))->_display();
            exit;
        }

        $this->testimonial->setName($this->input->post("name", TRUE));
        $this->testimonial->setDesignation($this->input->post("designation", TRUE));
        $this->testimonial->setContent($this->input->post("content", TRUE));

        $uploaded = '';
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = TRUE;
        $images = json_decode($this->input->post('images'), TRUE);
        foreach ($images as $image) {
            $config['source_image'] = realpath(APPPATH . '../../files/testimonial') . "/" . $image["file_name"];
            $sizes = array(
                IMAGE_LARGE_FOLDER => array(
                    IMAGE_LARGE_WIDTH, IMAGE_LARGE_HEIGHT
                ),
                IMAGE_MEDIUM_FOLDER => array(
                    IMAGE_MEDIUM_WIDTH, IMAGE_MEDIUM_HEIGHT
                ),
                IMAGE_SMALL_FOLDER => array(
                    IMAGE_SMALL_WIDTH, IMAGE_SMALL_HEIGHT
                ),
                IMAGE_THUMBNAIL_FOLDER => array(
                    IMAGE_THUMBNAIL_WIDTH, IMAGE_THUMBNAIL_HEIGHT
                )
            );
            foreach ($sizes as $folder => $size) {
                $config['width'] = $size[0];
                $config['height'] = $size[1];
                $config['new_image'] = realpath(APPPATH . '../../files/testimonial') . "/" . $folder . '/' . $image['file_name'];
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    $this->output->set_output(json_encode(array(
                        "success" => FALSE,
                        "message" => "Failed to save image!",
                        "data" => $this->image_lib->display_errors('<p>', '</p>')
                    )))->_display();
                    exit;
                }
                $this->image_lib->clear();
            }
            $uploaded = $image['file_name'];
        }

        $this->testimonial->setImage($uploaded);
        $this->testimonial->setCreated_auid($this->session->userdata("logged_in_auid"));
        if (!$this->testimonial->update()) {
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

        $this->load->model("Testimonial", "testimonial", TRUE);

        $this->load->library("SSP_lib", NULL, "ssp");
        $this->load->database();

        $this->ssp->setTable('testimonial');
        $this->ssp->setPrimary_key('t.tid');
        $this->ssp->setJoin_query(' FROM testimonial AS t LEFT JOIN testimonial_status AS ts ON t.tsid = ts.tsid '
                . 'LEFT JOIN admin_user AS au1 ON t.created_auid = au1.auid LEFT JOIN admin_user AS au2 ON t.updated_auid = au2.auid');

        $status_formatter = function($id, $row) {
            return Testimonial::getStatusLabel($id, $row);
        };
        $action_formatter = function($id, $row) {
            return $this->load->view('testimonial/action', array("id" => $id, "row" => $row), TRUE);
        };
        $created_user_formatter = function ($id, $row) {
            return "<a href='" . site_url(AdminUsers::class . "/view/" . $id) . "' target='_blank'>" . trim($row["created_user_first_name"] . " " . $row["created_user_last_name"]) . "</a>";
        };
        $updated_user_formatter = function ($id, $row) {
            return "<a href='" . site_url(AdminUsers::class . "/view/" . $id) . "' target='_blank'>" . trim($row["updated_user_first_name"] . " " . $row["updated_user_last_name"]) . "</a>";
        };

        $i = 0;
        $columns = array(
            array('db' => 't.tid', 'field' => 'tid', 'dt' => $i++),
            array('db' => 't.name', 'field' => 'name', 'dt' => $i++),
            array('db' => 't.designation', 'field' => 'designation', 'dt' => $i++),
            array('db' => 't.content', 'field' => 'content', 'dt' => $i++),
            array('db' => 'ts.name', 'field' => 'status', 'as' => 'status', 'dt' => $i++, "formatter" => $status_formatter),
            array('db' => 't.created_auid', 'field' => 'created_auid', 'dt' => $i++, "formatter" => $created_user_formatter),
            array('db' => 't.updated_auid', 'field' => 'updated_auid', 'dt' => $i++, "formatter" => $updated_user_formatter),
            array('db' => 't.created_time', 'field' => 'created_time', 'dt' => $i++),
            array('db' => 't.updated_time', 'field' => 'updated_time', 'dt' => $i++),
            array('db' => 't.tid', 'field' => 'tid', 'dt' => $i++, "formatter" => $action_formatter),
            array('db' => 'ts.tsid', 'field' => 'tsid', 'dt' => $i++), // Extras
            array('db' => 'ts.icon', 'field' => 'icon', 'dt' => $i++),
            array('db' => 'ts.color', 'field' => 'color', 'dt' => $i++),
            array('db' => 'ts.tstid', 'field' => 'tstid', 'dt' => $i++),
            array('db' => 'au1.first_name', 'field' => 'created_user_first_name', 'as' => 'created_user_first_name', 'dt' => $i++),
            array('db' => 'au1.last_name', 'field' => 'created_user_last_name', 'as' => 'created_user_last_name', 'dt' => $i++),
            array('db' => 'au2.first_name', 'field' => 'updated_user_first_name', 'as' => 'updated_user_first_name', 'dt' => $i++),
            array('db' => 'au2.last_name', 'field' => 'updated_user_last_name', 'as' => 'updated_user_last_name', 'dt' => $i++)
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

        $this->load->model('Testimonial', 'testimonial', TRUE);
        $this->testimonial->setId($id);
        if (!$this->testimonial->getTsid()) {
            redirect(self::class);
        }

        $this->load->setTitle("View Testimonial");
        $this->load->setDescription("Details of the testimonial");

        $this->load->template('testimonial/view', array(
            "testimonial" => $this->testimonial
        ));
    }

    public function upload() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $config['upload_path'] = realpath(APPPATH . '../../files/testimonial') . "/";
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 10 * 1024;
        $config['max_width'] = IMAGE_LARGE_WIDTH * 10;
        $config['max_height'] = IMAGE_LARGE_HEIGHT * 10;
        $config['file_name'] = get_random_string(15, 15);
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload("file")) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Failed to save data!",
                "data" => $this->upload->display_errors('<p>', '</p>')
            )))->_display();
            exit;
        }

        $this->output->set_output(json_encode(array(
            "success" => TRUE,
            "type" => "success",
            "url" => site_url(self::class),
            "message" => "Data saved successfully!",
            "data" => $this->upload->data()
        )))->_display();
        exit;
    }

    public function remove() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $image = $this->input->post('image');
        if (file_exists(realpath(APPPATH . '../../files/testimonial') . "/" . $image["file_name"])) {
            if (!unlink(realpath(APPPATH . '../../files/testimonial') . "/" . $image["file_name"])) {
                $this->output->set_output(json_encode(array(
                    "success" => FALSE,
                    "message" => "Failed to remove image!"
                )))->_display();
                exit;
            }
        }

        $sizes = array(IMAGE_LARGE_FOLDER, IMAGE_MEDIUM_FOLDER, IMAGE_SMALL_FOLDER, IMAGE_THUMBNAIL_FOLDER);
        foreach ($sizes as $folder) {
            if (file_exists(realpath(APPPATH . '../../files/testimonial') . "/" . $folder . "/" . $image["file_name"])) {
                if (!unlink(realpath(APPPATH . '../../files/testimonial') . "/" . $folder . "/" . $image["file_name"])) {
                    $this->output->set_output(json_encode(array(
                        "success" => FALSE,
                        "message" => "Failed to remove image!"
                    )))->_display();
                    exit;
                }
            }
        }

        $this->output->set_output(json_encode(array(
            "success" => TRUE,
            "type" => "success",
            "url" => site_url(self::class),
            "message" => "Image removed successfully!"
        )))->_display();
        exit;
    }

    public function change_status() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $this->load->model('Testimonial', 'testimonial', TRUE);
        $this->testimonial->setId($this->input->post("id"));
        if (!$this->testimonial->getTsid()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Invalid testimonial!"
            )))->_display();
            exit;
        }

        $this->testimonial->setTsid($this->input->post("status"));
        $this->testimonial->setUpdated_auid($this->session->userdata("logged_in_auid"));
        if (!$this->testimonial->update()) {
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
