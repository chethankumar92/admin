<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin User related logic
 * 
 */
class AdminUser extends CI_Model {

    private $auid;
    private $first_name;
    private $last_name = '';
    private $password;
    private $email;
    private $phone = '';
    private $mobile = '';
    private $ausid;
    private $created_auid;
    private $updated_auid;
    private $created_time;
    private $updated_time;

    /**
     * Constants
     */
    const TABLE = "admin_user";
    const TABLE_STATUS = "admin_user_status";
    const TABLE_SESSION = "admin_user_session";

    /**
     * Class constructor
     *
     * @return	void
     */
    public function __construct($id = NULL) {
        parent::__construct();
        if ($id) {
            $this->auid = $id;
            $this->load();
        }
    }

    function getId() {
        return $this->auid;
    }

    function getFirst_name() {
        return $this->first_name;
    }

    function getLast_name() {
        return $this->last_name;
    }

    function getPassword() {
        return $this->password;
    }

    function getEmail() {
        return $this->email;
    }

    function getPhone() {
        return $this->phone;
    }

    function getMobile() {
        return $this->mobile;
    }

    function getAusid() {
        return $this->ausid;
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

    function setId($auid, $load = TRUE) {
        $this->auid = $auid;
        if ($load) {
            $this->loadById();
        }
    }

    function setFirst_name($first_name) {
        $this->first_name = $first_name;
    }

    function setLast_name($last_name) {
        $this->last_name = $last_name;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setEmail($email, $load = FALSE) {
        $this->email = $email;
        if ($load) {
            $this->loadByEmail();
        }
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setMobile($mobile) {
        $this->mobile = $mobile;
    }

    function setAusid($ausid) {
        $this->ausid = $ausid;
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
        $result = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE auid = ?", array(
            $this->auid
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

    public function authenticate() {
        $result = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE email = ? AND password = ?", array(
            $this->email,
            $this->password
        ));

        if (!$result || $result->num_rows() < 1) {
            return FALSE;
        }
        $this->auid = $result->result()[0]->auid;
        return TRUE;
    }

    public function insertSession($session_string, $expiry_time) {
        $result = $this->db->query("INSERT INTO " . self::TABLE_SESSION . " (session_string, auid, expiry_time) VALUES(?, ?, ?)", array(
            $session_string,
            $this->auid,
            $expiry_time
        ));

        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

    public function insert() {
        $result = $this->db->query("INSERT INTO " . self::TABLE . " (first_name, last_name, email, "
                . "phone, mobile, password, ausid, created_auid) VALUES(?, ?, ?, ?, ?, ?, ?, ?)", array(
            $this->first_name,
            $this->last_name,
            $this->email,
            $this->phone,
            $this->mobile,
            $this->password,
            $this->ausid,
            $this->created_auid
        ));

        if (!$result) {
            return FALSE;
        }
        $this->auid = $this->db->insert_id();
        return TRUE;
    }

    public function update() {
        $result = $this->db->query("UPDATE " . self::TABLE . " SET first_name = ?, last_name = ?, "
                . "email = ?, phone = ?, mobile = ?, password = ?, ausid = ?, updated_auid = ? WHERE auid = ?", array(
            $this->first_name,
            $this->last_name,
            $this->email,
            $this->phone,
            $this->mobile,
            $this->password,
            $this->ausid,
            $this->updated_auid,
            $this->auid
        ));

        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

    private function loadByEmail() {
        $result = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE email = ?", array(
            $this->email
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

    public static function getStatuses($austid = 0) {
        $db = &get_instance()->db;

        $result = $db->query("SELECT * FROM " . self::TABLE_STATUS . " WHERE austid IN(?)", array(
            is_array($austid) ? implode(",", $austid) : $austid
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
