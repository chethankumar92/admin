<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends MY_Controller {

    public function index() {
        $this->load->setTitle("Manage Events");
        $this->load->setDescription("Manage event details");

        $this->load->addPlugins("datatables/jquery.dataTables", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "js", 10);
        $this->load->addPlugins("datatables/dataTables.bootstrap", "css", 10);

        $this->load->addScripts("modules/event");

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
        $this->load->addPlugins("dropzone/dropzone", "js", 10);
        $this->load->addPlugins("dropzone/dropzone", "css", 10);

        $this->load->addScripts("modules/event");

        $this->load->model('Event', 'event', TRUE);

        $this->load->template('event/add_edit_form', array(
            "action" => site_url(self::class . "/add_submit"),
            "method" => "post",
            "event" => $this->event,
            "grades" => Event::getGrades(1)
        ));
    }

    public function edit($id) {
        if (!is_numeric($id)) {
            redirect(self::class);
        }

        $this->load->model('Event', 'event', TRUE);
        $this->event->setId($id);
        if (!$this->event->getEsid()) {
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
        $this->load->addPlugins("dropzone/dropzone", "js", 10);
        $this->load->addPlugins("dropzone/dropzone", "css", 10);

        $this->load->addScripts("modules/event");

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
        $this->form_validation->set_rules("images", 'Image(/s)', 'required|min_length[40]');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "type" => "danger",
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        $instance = &get_instance();
        $instance->load->database();
        $instance->db->trans_begin();

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
        $this->event->setCost_includes($this->input->post("cost-includes", TRUE));
        $this->event->setCost_excludes($this->input->post("cost-excludes", TRUE));
        $this->event->setTentative_schedule($this->input->post("tentative-schedule", TRUE));
        $this->event->setFood($this->input->post("food", TRUE));
        $this->event->setThings_to_carry($this->input->post("things-to-carry", TRUE));
        $this->event->setCancellation_policy($this->input->post("cancellation-policy", TRUE));
        $this->event->setRefund_policy($this->input->post("refund-policy", TRUE));
        $this->event->setTerms_and_conditions($this->input->post("terms-and-conditions", TRUE));
        $this->event->setEsid(1);
        $this->event->setCreated_auid($this->session->userdata("logged_in_auid"));
        if (!$this->event->insert()) {
            $instance->db->trans_rollback();
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Failed to save data!"
            )))->_display();
            exit;
        }

        $uploaded = array();
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = TRUE;
        $images = json_decode($this->input->post('images'), TRUE);
        foreach ($images as $image) {
            $config['source_image'] = realpath(APPPATH . '../../files/event') . "/" . $image["file_name"];
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
                $config['new_image'] = realpath(APPPATH . '../../files/event') . "/" . $folder . '/' . $image['file_name'];
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    $instance->db->trans_rollback();
                    $this->output->set_output(json_encode(array(
                        "success" => FALSE,
                        "message" => "Failed to save image!",
                        "data" => $this->image_lib->display_errors('<p>', '</p>')
                    )))->_display();
                    exit;
                }
                $this->image_lib->clear();
            }
            $uploaded[] = $image['file_name'];
        }

        $this->load->model('EventImage', 'event_image', TRUE);
        $this->event_image->setEid($this->event->getId());
        $this->event_image->setEisid(1);
        $this->event_image->setCreated_auid($this->session->userdata("logged_in_auid"));
        foreach ($uploaded as $image) {
            $this->event_image->setName($image);
            $this->event_image->setDescription($image);
            if (!$this->event_image->insert()) {
                $instance->db->trans_rollback();
                $this->output->set_output(json_encode(array(
                    "success" => FALSE,
                    "message" => "Failed to save data!"
                )))->_display();
                exit;
            }
        }

        $instance->db->trans_commit();
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
        $this->form_validation->set_rules("images", 'Image(/s)', 'required|min_length[40]');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "type" => "danger",
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        $instance = &get_instance();
        $instance->load->database();
        $instance->db->trans_begin();

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
        $this->event->setCost_includes($this->input->post("cost-includes", TRUE));
        $this->event->setCost_excludes($this->input->post("cost-excludes", TRUE));
        $this->event->setTentative_schedule($this->input->post("tentative-schedule", TRUE));
        $this->event->setFood($this->input->post("food", TRUE));
        $this->event->setThings_to_carry($this->input->post("things-to-carry", TRUE));
        $this->event->setCancellation_policy($this->input->post("cancellation-policy", TRUE));
        $this->event->setRefund_policy($this->input->post("refund-policy", TRUE));
        $this->event->setTerms_and_conditions($this->input->post("terms-and-conditions", TRUE));
        $this->event->setUpdated_auid($this->session->userdata("logged_in_auid"));
        if (!$this->event->update()) {
            $instance->db->trans_rollback();
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Failed to save data!"
            )))->_display();
            exit;
        }

        $uploaded = array();
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = TRUE;
        $images = json_decode($this->input->post('images'), TRUE);
        foreach ($images as $image) {
            $config['source_image'] = realpath(APPPATH . '../../files/event') . "/" . $image["file_name"];
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
                $config['new_image'] = realpath(APPPATH . '../../files/event') . "/" . $folder . '/' . $image['file_name'];
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    $instance->db->trans_rollback();
                    $this->output->set_output(json_encode(array(
                        "success" => FALSE,
                        "message" => "Failed to save image!",
                        "data" => $this->image_lib->display_errors('<p>', '</p>')
                    )))->_display();
                    exit;
                }
                $this->image_lib->clear();
            }
            $uploaded[] = $image['file_name'];
        }

        $this->load->model('EventImage', 'event_image', TRUE);
        if (!$this->event_image->delete(NULL, $this->event->getId())) {
            $instance->db->trans_rollback();
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Failed to save images!"
            )))->_display();
            exit;
        }

        $this->event_image->setEid($this->event->getId());
        $this->event_image->setEisid(1);
        $this->event_image->setCreated_auid($this->session->userdata("logged_in_auid"));
        foreach ($uploaded as $image) {
            $this->event_image->setName($image);
            $this->event_image->setDescription($image);
            if (!$this->event_image->insert()) {
                $instance->db->trans_rollback();
                $this->output->set_output(json_encode(array(
                    "success" => FALSE,
                    "message" => "Failed to save data!"
                )))->_display();
                exit;
            }
        }

        $instance->db->trans_commit();
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

    public function view($id) {
        if (!is_numeric($id)) {
            redirect(self::class);
        }

        $this->load->model('Event', 'event', TRUE);
        $this->event->setId($id);
        if (!$this->event->getEsid()) {
            redirect(self::class);
        }

        $this->load->setTitle("View Event");
        $this->load->setDescription("Details of the event");

        $this->load->template('event/view', array(
            "event" => $this->event
        ));
    }

    public function upload() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $config['upload_path'] = realpath(APPPATH . '../../files/event') . "/";
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 10 * 1024;
        $config['max_width'] = 6400;
        $config['max_height'] = 4800;
        $config['file_name'] = get_random_string(15, 15);
        $this->load->library('upload', $config);

        $files = $_FILES;
        $count = count($files['file']['name']);
        for ($key = 0; $key < $count; $key++) {
            $_FILES['file']['name'] = $files['file']['name'][$key];
            $_FILES['file']['type'] = $files['file']['type'][$key];
            $_FILES['file']['tmp_name'] = $files['file']['tmp_name'][$key];
            $_FILES['file']['error'] = $files['file']['error'][$key];
            $_FILES['file']['size'] = $files['file']['size'][$key];

            if (!$this->upload->do_upload("file")) {
                $this->output->set_output(json_encode(array(
                    "success" => FALSE,
                    "message" => "Failed to save data!",
                    "data" => $this->upload->display_errors('<p>', '</p>')
                )))->_display();
                exit;
            }
        }

        $this->output->set_output(json_encode(array(
            "success" => TRUE,
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

        $instance = &get_instance();
        $instance->load->database();
        $instance->db->trans_begin();

        $image = $this->input->post('image');
        if (file_exists(realpath(APPPATH . '../../files/event') . "/" . $image["file_name"])) {
            if (!unlink(realpath(APPPATH . '../../files/event') . "/" . $image["file_name"])) {
                $instance->db->trans_rollback();
                $this->output->set_output(json_encode(array(
                    "success" => FALSE,
                    "message" => "Failed to remove image!"
                )))->_display();
                exit;
            }
        }

        if (isset($image["file_id"]) && is_numeric($image["file_id"])) {
            $this->load->model('EventImage', 'event_image', TRUE);
            $this->event_image->setId($image["file_id"]);
            if (!$this->event_image->delete($image["file_id"])) {
                $instance->db->trans_rollback();
                $this->output->set_output(json_encode(array(
                    "success" => FALSE,
                    "message" => "Failed to remove image!"
                )))->_display();
                exit;
            }

            $sizes = array(IMAGE_LARGE_FOLDER, IMAGE_MEDIUM_FOLDER, IMAGE_SMALL_FOLDER, IMAGE_THUMBNAIL_FOLDER);
            foreach ($sizes as $folder) {
                if (file_exists(realpath(APPPATH . '../../files/event') . "/" . $folder . "/" . $image["file_name"])) {
                    if (!unlink(realpath(APPPATH . '../../files/event') . "/" . $folder . "/" . $image["file_name"])) {
                        $instance->db->trans_rollback();
                        $this->output->set_output(json_encode(array(
                            "success" => FALSE,
                            "message" => "Failed to remove image!"
                        )))->_display();
                        exit;
                    }
                }
            }
        }

        $instance->db->trans_commit();
        $this->output->set_output(json_encode(array(
            "success" => TRUE,
            "type" => "success",
            "url" => site_url(self::class),
            "message" => "Image removed successfully!"
        )))->_display();
        exit;
    }

}
