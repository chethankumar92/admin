<?php

/**
 * Event related logic
 * 
 */
class Event extends CI_Model {

    private $eid;
    private $name;
    private $description;
    private $from_date;
    private $to_date;
    private $trek_distance;
    private $distance_from_bangalore;
    private $cost;
    private $accommodation;
    private $food;
    private $transportation;
    private $things_to_carry;
    private $terms_and_conditions;
    private $egid;
    private $esid;
    private $created_auid;
    private $updated_auid;
    private $created_time;
    private $updated_time;

    /**
     * Constants
     */
    const TABLE = "event";
    const TABLE_GRADE = "event_grade";
    const TABLE_COST = "event_cost";
    const TABLE_POLICY = "event_policy";

    /**
     * Class constructor
     *
     * @return	void
     */
    public function __construct($id = NULL) {
        parent::__construct();
        if ($id) {
            $this->eid = $id;
            $this->load();
        }
    }

    function getId() {
        return $this->eid;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getFrom_date() {
        return $this->from_date;
    }

    function getTo_date() {
        return $this->to_date;
    }

    function getTrek_distance() {
        return $this->trek_distance;
    }

    function getDistance_from_bangalore() {
        return $this->distance_from_bangalore;
    }

    function getCost() {
        return $this->cost;
    }

    function getAccommodation() {
        return $this->accommodation;
    }

    function getFood() {
        return $this->food;
    }

    function getTransportation() {
        return $this->transportation;
    }

    function getThings_to_carry() {
        return $this->things_to_carry;
    }

    function getTerms_and_conditions() {
        return $this->terms_and_conditions;
    }

    function getEgid() {
        return $this->egid;
    }

    function getEsid() {
        return $this->esid;
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

    function setId($eid, $load = TRUE) {
        $this->eid = $eid;
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

    function setFrom_date($from_date) {
        $this->from_date = $from_date;
    }

    function setTo_date($to_date) {
        $this->to_date = $to_date;
    }

    function setTrek_distance($trek_distance) {
        $this->trek_distance = $trek_distance;
    }

    function setDistance_from_bangalore($distance_from_bangalore) {
        $this->distance_from_bangalore = $distance_from_bangalore;
    }

    function setCost($cost) {
        $this->cost = $cost;
    }

    function setAccommodation($accommodation) {
        $this->accommodation = $accommodation;
    }

    function setFood($food) {
        $this->food = $food;
    }

    function setTransportation($transportation) {
        $this->transportation = $transportation;
    }

    function setThings_to_carry($things_to_carry) {
        $this->things_to_carry = $things_to_carry;
    }

    function setTerms_and_conditions($terms_and_conditions) {
        $this->terms_and_conditions = $terms_and_conditions;
    }

    function setEgid($egid) {
        $this->egid = $egid;
    }

    function setEsid($esid) {
        $this->esid = $esid;
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
        $result = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE eid = ?", array(
            $this->eid
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
        $result = $this->db->query("INSERT INTO " . self::TABLE . " (name, from_date, to_date, trek_distance, "
                . "distance_from_bangalore, egid, cost, description, accommodation, transportation, food, things_to_carry, "
                . "terms_and_conditions, esid, created_auid) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
            $this->name,
            $this->from_date,
            $this->to_date,
            $this->trek_distance,
            $this->distance_from_bangalore,
            $this->egid,
            $this->cost,
            $this->description,
            $this->accommodation,
            $this->transportation,
            $this->food,
            $this->things_to_carry,
            $this->terms_and_conditions,
            $this->esid,
            $this->created_auid
        ));

        if (!$result) {
            return FALSE;
        }
        $this->eid = $this->db->insert_id();
        return TRUE;
    }

    public function update() {
        $result = $this->db->query("UPDATE " . self::TABLE . " SET name = ?, from_date = ?, "
                . "to_date = ?, trek_distance = ?, distance_from_bangalore = ?, egid = ?, cost = ?, "
                . "description = ?, accommodation = ?, transportation = ?, food = ?, things_to_carry = ?, "
                . "terms_and_conditions = ?, esid = ?, updated_auid = ? WHERE eid = ?", array(
            $this->name,
            $this->from_date,
            $this->to_date,
            $this->trek_distance,
            $this->distance_from_bangalore,
            $this->egid,
            $this->cost,
            $this->description,
            $this->accommodation,
            $this->transportation,
            $this->food,
            $this->things_to_carry,
            $this->terms_and_conditions,
            $this->esid,
            $this->updated_auid,
            $this->eid
        ));

        if (!$result) {
            return FALSE;
        }
        return TRUE;
    }

    public static function getGrades($egsid) {
        $db = &get_instance()->db;

        $result = $db->query("SELECT * FROM " . self::TABLE_GRADE . " WHERE egsid IN(?)", array(
            is_array($egsid) ? implode(",", $egsid) : $egsid
        ));

        if (!$result || $result->num_rows() < 1) {
            return FALSE;
        }
        return $result->result();
    }

}
