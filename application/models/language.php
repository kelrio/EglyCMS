<?php

class panelUser_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function getLang(){
        $query = $this->db->get_where('EglyCMS_setting', array('name' => 'language'));
    }

}