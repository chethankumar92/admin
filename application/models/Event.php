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
    private $fee;
    private $accomodation;
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

    function getFee() {
        return $this->fee;
    }

    function getAccomodation() {
        return $this->accomodation;
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

    function setFee($fee) {
        $this->fee = $fee;
    }

    function setAccomodation($accomodation) {
        $this->accomodation = $accomodation;
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

    public function load() {
        $result = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE auid = ?", array(
            $this->auid
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
        $this->eid = $this->db->insert_id();
        return TRUE;
    }

}
