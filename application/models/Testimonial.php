<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial extends CI_Model {

    private $tid;
    private $name;
    private $designation;
    private $image;
    private $content;
    private $tsid;
    private $created_auid;
    private $updated_auid;
    private $created_time;
    private $updated_time;

    /**
     * Constants
     */
    const TABLE = "testimonial";
    const TABLE_STATUS = "testimonial_status";

    /**
     * Class constructor
     *
     * @return	void
     */
    public function __construct($id = NULL) {
        parent::__construct();
        if ($id) {
            $this->tid = $id;
            $this->loadById();
        }
    }

    function getId() {
        return $this->tid;
    }

    function getPid() {
        return $this->tid;
    }

    function getName() {
        return $this->name;
    }

    function getDesignation() {
        return $this->designation;
    }

    function getImage() {
        return $this->image;
    }

    function getContent() {
        return $this->content;
    }

    function getTsid() {
        return $this->tsid;
    }

    function getCreated_auid() {
        return $this->created_auid;
    }

    function getUpdated_auid() {
        return $this->updated_auid;
    }

    function getCreated_time() {
        return $this->created_time;
    }

    function getUpdated_time() {
        return $this->updated_time;
    }

    function setId($tid, $load = TRUE) {
        $this->tid = $tid;
        if ($load) {
            $this->loadById();
        }
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDesignation($designation) {
        $this->designation = $designation;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setContent($content) {
        $this->content = $content;
    }

    function setTsid($tsid) {
        $this->tsid = $tsid;
    }

    function setCreated_auid($created_auid) {
        $this->created_auid = $created_auid;
    }

    function setUpdated_auid($updated_auid) {
        $this->updated_auid = $updated_auid;
    }

    function setCreated_time($created_time) {
        $this->created_time = $created_time;
    }

    function setUpdated_time($updated_time) {
        $this->updated_time = $updated_time;
    }

    public function loadById() {
        $result = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE tid = ?", array(
            $this->tid
        ));

        if (!$result || $result->num_rows() < 1) {
            return FALSE;
        }

        $row = $result->result()[0];
        foreach ($row as $key => $value) {
            $this->$key = $value;
        }
        return TRUE;
    }

    public function insert() {
        $result = $this->db->query("INSERT INTO " . self::TABLE . " (name, designation, content, "
                . "image, tsid, created_auid) VALUES(?, ?, ?, ?, ?, ?)", array(
            $this->name,
            $this->designation,
            $this->content,
            $this->image,
            $this->tsid,
            $this->created_auid
        ));

        if (!$result) {
            return FALSE;
        }
        $this->tid = $this->db->insert_id();
        return TRUE;
    }

    public function update() {
        $result = $this->db->query("UPDATE " . self::TABLE . " SET name = ?, designation = ?, "
                . "content = ?, image = ?, tsid = ?, updated_auid = ? WHERE tid = ?", array(
            $this->name,
            $this->designation,
            $this->content,
            $this->image,
            $this->tsid,
            $this->updated_auid,
            $this->tid
        ));

        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

    public static function getStatuses($tstid = 0) {
        $db = &get_instance()->db;

        $result = $db->query("SELECT * FROM " . self::TABLE_STATUS . " WHERE tstid IN(?)", array(
            is_array($tstid) ? implode(",", $tstid) : $tstid
        ));

        if (!$result || $result->num_rows() < 1) {
            return FALSE;
        }
        return $result->result();
    }

    public static function getStatusLabel($id, $row) {
        return "<span class='label' style='background-color: " . $row["color"] . "'>"
                . "<i class='" . $row["icon"] . "'></i>" . $row["status"] .
                "</span>";
    }

}
