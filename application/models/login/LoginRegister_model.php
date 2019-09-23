<?php

class LoginRegister_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function getId($id){
        $query = $this->db->query("SELECT iduser, email FROM EglyCMS_user");
        $idRow;

        if($query->num_rows() > 0){
            $idRow = [];
            foreach($query->result() as $row){
                $idRow['id'] = $row->iduser;
                $idRow['email'] = $row->email;
            }
        }

        return $idRow;
    }

    function getConfirm($key){
        $query = $this->db->query("SELECT idconfirmMail, time, key, user_iduser, status FROM EglyCMS_confirmMail WHERE key='".$key."'");
        $result;

        if($query->num_rows() > 0){
            $result = $query->row();
        }

        return $result;
    }

    function register($name, $password, $email){
        $array = array('name'=>$name, 'password'=>$password, 'email'=>$email);
        $str = $this->db->insert_string('EglyCMS_user', $array);
        $this->db->query($str);
        return $this->db->insert_id();
    }

    function createConfirmEmail($time, $key, $id){
        $array = array('time'=>$time, 'key'=>$key, 'user_iduser'=>$id);
        $str = $this->db->insert_string('EglyCMS_confirmMail', $array);
        return $this->db->query($str);
    }

}