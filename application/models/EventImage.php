<?php

/**
 * Event image related logic
 * 
 */
class EventImage extends CI_Model {

    private $eiid;
    private $eid;
    private $name;
    private $description;
    private $eisid;
    private $created_auid;
    private $updated_auid;
    private $created_time;
    private $updated_time;

    /**
     * Constants
     */
    const TABLE = "event_image";

    /**
     * Class constructor
     *
     * @return	void
     */
    public function __construct($id = NULL) {
        parent::__construct();
        if ($id) {
            $this->eiid = $id;
            $this->loadById();
        }
    }

    function getId() {
        return $this->eiid;
    }

    function getEid() {
        return $this->eid;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getEisid() {
        return $this->eisid;
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

    function setId($eiid, $load = TRUE) {
        $this->eiid = $eiid;
        if ($load) {
            $this->loadById();
        }
    }

    function setEid($eid) {
        $this->eid = $eid;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setEisid($eisid) {
        $this->eisid = $eisid;
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
        $result = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE eiid = ?", array(
            $this->eiid
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
        $result = $this->db->query("INSERT INTO " . self::TABLE . " (eid, name, description, "
                . "eisid, created_auid) VALUES(?, ?, ?, ?, ?)", array(
            $this->eid,
            $this->name,
            $this->description,
            $this->eisid,
            $this->created_auid
        ));

        if (!$result) {
            return FALSE;
        }
        $this->eiid = $this->db->insert_id();
        return TRUE;
    }

    public function update() {
        $result = $this->db->query("UPDATE " . self::TABLE . " SET eid = ?, name = ?, "
                . "description = ?, eisid = ?, updated_auid = ?  WHERE eiid = ?", array(
            $this->eid,
            $this->name,
            $this->description,
            $this->eisid,
            $this->updated_auid,
            $this->eiid
        ));

        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

    public static function delete($eiid = NULL, $eid = NULL) {
        $db = &get_instance()->db;

        $query = "DELETE FROM " . self::TABLE . " WHERE 1";
        $params = array();

        if ($eiid) {
            $query .= " AND eiid IN(?)";
            $params[] = is_array($eiid) ? implode(",", $eiid) : $eiid;
        } elseif ($eid) {
            $query .= " AND eid IN(?)";
            $params[] = is_array($eid) ? implode(",", $eid) : $eid;
        } else {
            return FALSE;
        }

        $result = $db->query($query, $params);
        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

}
