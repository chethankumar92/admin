<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends MY_Controller {

    public function index() {
        $this->load->setTitle("Manage Events");
        $this->load->setDescription("Manage event details");

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
        
        $this->load->addScripts("modules/event");

        $this->load->model('Event', 'event', TRUE);

        $this->load->template('event/manage', array(
            "render_url" => site_url(self::class . "/render"),
            "status_action" => site_url(self::class . "/change_status"),
            "status_method" => "post",
            "statuses" => Event::getStatuses()
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
            "upload" => site_url(self::class . "/upload"),
            "remove" => site_url(self::class . "/remove"),
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
        if ($this->event->getEsid() == 3) {
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
            "upload" => site_url(self::class . "/upload"),
            "remove" => site_url(self::class . "/remove"),
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
        $this->form_validation->set_rules("images", 'Image(/s)', 'required|min_length[10]');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "type" => "danger",
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        $this->load->database();
        $this->db->trans_begin();

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
            $this->db->trans_rollback();
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
                    $this->db->trans_rollback();
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
                $this->db->trans_rollback();
                $this->output->set_output(json_encode(array(
                    "success" => FALSE,
                    "message" => "Failed to save data!"
                )))->_display();
                exit;
            }
        }

        $this->db->trans_commit();
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
        $this->form_validation->set_rules("images", 'Image(/s)', 'required|min_length[10]');
        if (!$this->form_validation->run()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "errors" => $this->form_validation->error_array(),
                "message" => "Invalid data!"
            )))->_display();
            exit;
        }

        $this->load->database();
        $this->db->trans_begin();

        $this->load->model('Event', 'event', TRUE);
        $this->event->setId($this->input->post("id", TRUE));
        if ($this->event->getEsid() == 3) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "errors" => $this->form_validation->error_array(),
                "message" => "Deleted event cannot be edited!"
            )))->_display();
            exit;
        }

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
            $this->db->trans_rollback();
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
                    $this->db->trans_rollback();
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
            $this->db->trans_rollback();
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
                $this->db->trans_rollback();
                $this->output->set_output(json_encode(array(
                    "success" => FALSE,
                    "message" => "Failed to save data!"
                )))->_display();
                exit;
            }
        }

        $this->db->trans_commit();
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

        $this->load->model("Event", "event", TRUE);

        $this->load->library("SSP_lib", NULL, "ssp");
        $this->load->database();

        $this->ssp->setTable('event');
        $this->ssp->setPrimary_key('e.eid');
        $this->ssp->setJoin_query('FROM event AS e LEFT JOIN event_status AS es ON e.esid = es.esid '
                . 'LEFT JOIN event_grade AS eg ON e.egid = eg.egid '
                . 'LEFT JOIN admin_user AS au1 ON e.created_auid = au1.auid LEFT JOIN admin_user AS au2 ON e.updated_auid = au2.auid');

        $status_formatter = function($id, $row) {
            return Event::getStatusLabel($id, $row);
        };
        $action_formatter = function($id, $row) {
            return $this->load->view('event/action', array("id" => $id, "row" => $row), TRUE);
        };
        $created_user_formatter = function ($id, $row) {
            return "<a href='" . site_url(AdminUsers::class . "/view/" . $id) . "' target='_blank'>" . trim($row["created_user_first_name"] . " " . $row["created_user_last_name"]) . "</a>";
        };
        $updated_user_formatter = function ($id, $row) {
            return "<a href='" . site_url(AdminUsers::class . "/view/" . $id) . "' target='_blank'>" . trim($row["updated_user_first_name"] . " " . $row["updated_user_last_name"]) . "</a>";
        };

        $i = 0;
        $columns = array(
            array('db' => 'e.eid', 'field' => 'eid', 'dt' => $i++),
            array('db' => 'e.name', 'field' => 'name', 'dt' => $i++),
            array('db' => 'e.from_date', 'field' => 'from_date', 'dt' => $i++),
            array('db' => 'e.to_date', 'field' => 'to_date', 'dt' => $i++),
            array('db' => 'e.trek_distance', 'field' => 'trek_distance', 'dt' => $i++),
            array('db' => 'e.cost', 'field' => 'cost', 'dt' => $i++),
            array('db' => 'eg.name', 'field' => 'grade', 'as' => 'grade', 'dt' => $i++),
            array('db' => 'es.name', 'field' => 'status', 'as' => 'status', 'dt' => $i++, "formatter" => $status_formatter),
            array('db' => 'e.created_auid', 'field' => 'created_auid', 'dt' => $i++, "formatter" => $created_user_formatter),
            array('db' => 'e.updated_auid', 'field' => 'updated_auid', 'dt' => $i++, "formatter" => $updated_user_formatter),
            array('db' => 'e.created_time', 'field' => 'created_time', 'dt' => $i++),
            array('db' => 'e.updated_time', 'field' => 'updated_time', 'dt' => $i++),
            array('db' => 'e.eid', 'field' => 'eid', 'dt' => $i++, "formatter" => $action_formatter),
            array('db' => 'es.esid', 'field' => 'esid', 'dt' => $i++), // Extras
            array('db' => 'es.icon', 'field' => 'icon', 'dt' => $i++),
            array('db' => 'es.color', 'field' => 'color', 'dt' => $i++),
            array('db' => 'es.estid', 'field' => 'estid', 'dt' => $i++),
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
        $config['max_width'] = IMAGE_LARGE_WIDTH * 10;
        $config['max_height'] = IMAGE_LARGE_HEIGHT * 10;
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

        $this->load->database();
        $this->db->trans_begin();

        $image = $this->input->post('image');
        if (file_exists(realpath(APPPATH . '../../files/event') . "/" . $image["file_name"])) {
            if (!unlink(realpath(APPPATH . '../../files/event') . "/" . $image["file_name"])) {
                $this->db->trans_rollback();
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
                $this->db->trans_rollback();
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
                        $this->db->trans_rollback();
                        $this->output->set_output(json_encode(array(
                            "success" => FALSE,
                            "message" => "Failed to remove image!"
                        )))->_display();
                        exit;
                    }
                }
            }
        }

        $this->db->trans_commit();
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

        $this->load->model('Event', 'event', TRUE);
        $this->event->setId($this->input->post("id"));
        if (!$this->event->getEsid()) {
            $this->output->set_output(json_encode(array(
                "success" => FALSE,
                "message" => "Invalid event!"
            )))->_display();
            exit;
        }

        $this->event->setEsid($this->input->post("status"));
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
            "type" => "success",
            "message" => "Data saved successfully!"
        )))->_display();
        exit;
    }

}
