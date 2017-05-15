<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Contact related logic
 * 
 */

class Contact extends CI_Model {

    private $cid;
    private $name;
    private $email;
    private $mobile;
    private $subject;
    private $message;
    private $csid;
    private $created_auid;
    private $updated_auid;
    private $created_time;
    private $updated_time;

    /**
     * Constants
     */
    const TABLE = "contact";
    const TABLE_STATUS = "contact_status";

    /**
     * Class constructor
     *
     * @return	void
     */
    public function __construct($id = NULL) {
        parent::__construct();
        if ($id) {
            $this->cid = $id;
            $this->load();
        }
    }

    function getId() {
        return $this->cid;
    }

    function getName() {
        return $this->name;
    }

    function getEmail() {
        return $this->email;
    }

    function getMobile() {
        return $this->mobile;
    }

    function getSubject() {
        return $this->subject;
    }

    function getMessage() {
        return $this->message;
    }

    function getCsid() {
        return $this->csid;
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

    function setId($cid, $load = TRUE) {
        $this->cid = $cid;
        if ($load) {
            $this->loadById();
        }
    }

    function setName($name) {
        $this->name = $name;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setMobile($mobile) {
        $this->mobile = $mobile;
    }

    function setSubject($subject) {
        $this->subject = $subject;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setCsid($csid) {
        $this->csid = $csid;
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
        $result = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE cid = ?", array(
            $this->cid
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
        $result = $this->db->query("INSERT INTO " . self::TABLE . " (name, email, mobile, "
                . "subject, message, csid, created_auid) VALUES(?, ?, ?, ?, ?, ?, ?)", array(
            $this->name,
            $this->email,
            $this->mobile,
            $this->subject,
            $this->message,
            $this->csid,
            $this->created_auid
        ));

        if (!$result) {
            return FALSE;
        }
        $this->cid = $this->db->insert_id();
        return TRUE;
    }

    public function update() {
        $result = $this->db->query("UPDATE " . self::TABLE . " SET name = ?, email = ?, "
                . "mobile = ?, subject = ?, message = ?, csid = ?, updated_auid = ? "
                . "WHERE cid = ?", array(
            $this->name,
            $this->email,
            $this->mobile,
            $this->subject,
            $this->message,
            $this->csid,
            $this->updated_auid,
            $this->cid
        ));

        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

    public static function getStatuses($cstid = 0) {
        $db = &get_instance()->db;

        $result = $db->query("SELECT * FROM " . self::TABLE_STATUS . " WHERE cstid IN(?)", array(
            is_array($cstid) ? implode(",", $cstid) : $cstid
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
