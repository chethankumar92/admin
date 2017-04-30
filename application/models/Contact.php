<?php

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
    private $created_auid;
    private $updated_auid;
    private $created_time;
    private $updated_time;

    /**
     * Constants
     */
    const TABLE = "contact";

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

    function setCid($cid) {
        $this->cid = $cid;
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

    public function load() {
        $result = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE cid = ?", array(
            $this->cid
        ));

        if (!$result || $result->num_rows() < 1) {
            return FALSE;
        }

        $row = $result->result();
        foreach ($row as $key => $value) {
            $this->$key = $value;
        }
        return TRUE;
    }

    public function insert() {
        $result = $this->db->query("INSERT INTO " . self::TABLE . " SET name = ?, email = ?, mobile = ?, subject = ?, message = ?", array(
            $this->name,
            $this->email,
            $this->mobile,
            $this->subject,
            $this->message
        ));

        if (!$result) {
            return FALSE;
        }
        $this->cid = $this->db->insert_id();
        return TRUE;
    }

}
