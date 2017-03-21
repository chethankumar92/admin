<?php

    /*
     * Employee related logic
     * 
     */

    class Employee extends CI_Model
    {

        private $emp_id;
        private $first_name;
        private $last_name;
        private $password;
        private $email;
        private $phone;
        private $mobile;
        private $created_emp;
        private $updated_emp;
        private $created_time;
        private $updated_time;

        /**
         * Constants
         */
        const TABLE = "employee";
        const TABLE_SESSION = "employee_session";

        function getEmp_id()
        {
            return $this->emp_id;
        }

        function getFirst_name()
        {
            return $this->first_name;
        }

        function getLast_name()
        {
            return $this->last_name;
        }

        function getPassword()
        {
            return $this->password;
        }

        function getEmail()
        {
            return $this->email;
        }

        function getPhone()
        {
            return $this->phone;
        }

        function getMobile()
        {
            return $this->mobile;
        }

        function getCreated_emp()
        {
            return $this->created_emp;
        }

        function getUpdated_emp()
        {
            return $this->updated_emp;
        }

        function getCreated_time()
        {
            return $this->created_time;
        }

        function getUpdated_time()
        {
            return $this->updated_time;
        }

        function setFirst_name($first_name)
        {
            $this->first_name = $first_name;
        }

        function setLast_name($last_name)
        {
            $this->last_name = $last_name;
        }

        function setPassword($password)
        {
            $this->password = $password;
        }

        function setEmail($email)
        {
            $this->email = $email;
        }

        function setPhone($phone)
        {
            $this->phone = $phone;
        }

        function setMobile($mobile)
        {
            $this->mobile = $mobile;
        }

        function setCreated_emp($created_emp)
        {
            $this->created_emp = $created_emp;
        }

        function setUpdated_emp($updated_emp)
        {
            $this->updated_emp = $updated_emp;
        }

        function setCreated_time($created_time)
        {
            $this->created_time = $created_time;
        }

        function setUpdated_time($updated_time)
        {
            $this->updated_time = $updated_time;
        }

        /**
         * Class constructor
         *
         * @return	void
         */
        public function __construct()
        {
            parent::__construct();
        }

        public function auth()
        {
            $result = $this->db->query("SELECT * FROM " . self::TABLE . " WHERE email = ? AND password = ?", array(
                $this->email,
                $this->password
            ));

            if (!$result || $result->num_rows() < 1)
            {
                return FALSE;
            }
            return TRUE;
        }

        public function insertSession($session_string, $expiry_time)
        {
            $result = $this->db->query("INSERT INTO " . self::TABLE_SESSION . " (session_string, emp_id, expiry_time) VALUES(?, ?, ?)", array(
                $session_string,
                $this->emp_id,
                $expiry_time
            ));

            if (!$result)
            {
                return FALSE;
            }
        }

    }
    