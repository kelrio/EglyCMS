<?php

class panelUser_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    function getAccount(){
        $this->db->select('iduser, login, editArticle, createPage, changeSetting, changeAccount, delete');
        $query = $this->db->get('EglyCMS_user');
        $result = array();

        if($query->num_rows() > 0){

            foreach($query->result() as $row){
                $tmpArray = array();

                $tmpArray['iduser'] = $row->iduser;
                $tmpArray['login'] = $row->login;
                $tmpArray['editArticle'] = $row->editArticle;
                $tmpArray['createPage'] = $row->createPage;
                $tmpArray['changeSetting'] = $row->changeSetting;
                $tmpArray['changeAccount'] = $row->changeAccount;
                $tmpArray['delete'] = $row->delete;

                $result[] = $tmpArray;
            }
        }

        return $result;
    }

    /**
     * zmienia wartość konta
     * parametry:
     * iduser - identyfikator konta
     * element - nazwa elementu do zmiany
     * value - nowa artość elementu
     */
    function changeAccount($params){
        $data = array($params['element']=>$params['value']);
        $where = "iduser=".$params['iduser'];
        $str = $this->db->update_string('EglyCMS_user', $data, $where);

        $query = $this->db->query($str);
    }

    /**
     * usuwa użytkownika z bazy danych
     * parametry
     * iduser - identyfikator użytkownika
     */
    function deleteUser($params){
        $this->db->delete('EglyCMS_user',array('iduser'=>$params['iduser']));

    }

    /**
     * tworzy nowego użytkownika
     * parametry:
     * login - login nadany przez system
     */
    function addUser($params){
        $array = array('login'=>$params['login'], 'password'=>'', 'editArticle'=>1, 'createPage'=>0, 'changeSetting'=>0, 'changeAccount'=>0);
        $this->db->insert('EglyCMS_user', $array);

        return $this->db->insert_id();
    }

    /**
     * pobiera dane uzytkownika po jest nazwie
     * parametry
     * login - nazwa uzytkownika
     */
    function getUser($params){

        $this->db->select('iduser, password, editArticle, createPage, changeSetting, changeAccount');
        $query = $this->db->get_where('EglyCMS_user', array('login'=>$params['login']));

        if($query->num_rows() > 0){
            $row = $query->row();

            $result = array();

            $result['iduser'] = $row->iduser;
            $result['password'] = $row->password;
            $result['editArticle'] = $row->editArticle;
            $result['createPage'] = $row->createPage;
            $result['changeSetting'] = $row->changeSetting;
            $result['changeAccount'] = $row->changeAccount;

            return $result;
        }else{
            return false;
        }
    }

}