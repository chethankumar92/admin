<?php

/**
 * Event grade related logic
 * 
 */
class EventGrade extends CI_Model {

    private $egid;
    private $name;
    private $description;
    private $egsid;
    private $created_auid;
    private $updated_auid;
    private $created_time;
    private $updated_time;

    /**
     * Constants
     */
    const TABLE = "event_grade";

    /**
     * Class constructor
     *
     * @return	void
     */
    public function __construct($id = NULL) {
        parent::__construct();
        if ($id) {
            $this->egid = $id;
            $this->loadById();
        }
    }

    function getId() {
        return $this->egid;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getEgsid() {
        return $this->egsid;
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

    function setId($egid, $load = TRUE) {
        $this->egid = $egid;
        if ($load) {
            $this->loadById();
        }
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setEgsid($egsid) {
        $this->egsid = $egsid;
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
        $result = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE egid = ?", array(
            $this->egid
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

    public function populate($row) {
        if (is_array($row) || is_object($row)) {
            foreach ($row as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function insert() {
        $result = $this->db->query("INSERT INTO " . self::TABLE . " (name, description, egsid, created_auid)"
                . " VALUES(?, ?, ?, ?)", array(
            $this->name,
            $this->description,
            $this->egsid,
            $this->created_auid
        ));

        if (!$result) {
            return FALSE;
        }
        $this->egid = $this->db->insert_id();
        return TRUE;
    }

    public function update() {
        $result = $this->db->query("UPDATE " . self::TABLE . " SET name = ?, description = ?,"
                . " egsid = ?, updated_auid = ? WHERE egid = ?", array(
            $this->name,
            $this->description,
            $this->egsid,
            $this->updated_auid,
            $this->egid
        ));

        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

}
