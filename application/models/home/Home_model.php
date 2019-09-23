<?php

class home_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function getFirstElementMenu(){
        $this->db->select('idmenu');
        $query = $this->db->get('EglyCMS_menu');

        $result = null;

        if ($query->num_rows() > 0){
            $row = $query->row(); 
            $result = $row->idmenu;
        }

        return $result;
    }

    function getNameElement($params){
        $this->db->select('name');
        $this->db->where('idmenu', $params['idmenu']);
        $query = $this->db->get('EglyCMS_menu');

        $result = null;

        if ($query->num_rows() > 0){
            $row = $query->row(); 
            $result = $row->name;
        }

        return $result;
    }
}
