<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    require_once 'ssp/SSP.php';

    class SSP_lib extends SSP
    {

        private $db;
        private $input;
        private $columns;
        private $table;
        private $primary_key;
        private $join_query = '';
        private $extra_where = '';

        function __construct()
        {
            
        }

        function getDb()
        {
            return $this->db;
        }

        function getInput()
        {
            return $this->input;
        }

        function getColumns()
        {
            return $this->columns;
        }

        function getTable()
        {
            return $this->table;
        }

        function getPrimary_key()
        {
            return $this->primary_key;
        }

        function getJoin_query()
        {
            return $this->join_query;
        }

        function getExtra_where()
        {
            return $this->extra_where;
        }

        function setDb($db)
        {
            $this->db = $db;
        }

        function setInput($input)
        {
            $this->input = $input;
        }

        function setColumns($columns)
        {
            $this->columns = $columns;
        }

        function setTable($table)
        {
            $this->table = $table;
        }

        function setPrimary_key($primary_key)
        {
            $this->primary_key = $primary_key;
        }

        function setJoin_query($join_query)
        {
            $this->join_query = $join_query;
        }

        function setExtra_where($extra_where)
        {
            $this->extra_where = $extra_where;
        }

        function render()
        {
            $sql_details = array(
                'user' => $this->db->username,
                'pass' => $this->db->password,
                'db' => $this->db->database,
                'host' => $this->db->hostname
            );

            return json_encode(
                SSP::simple($this->input, $sql_details, $this->table, $this->primary_key, $this->columns, $this->join_query, $this->extra_where)
            );
        }

    }
    