<?php

class panelMenu_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }
    /**
     * Zwraca elementy menu, oraz może przyjąć parametry pobierania danych WHERE 
     * opcjonalnie jako parametr można podać zakres w tablicy np ['id=1'] lub ['name=michal', 'wiek=20']
     */
    function get_menu($params = null){
        $result = [];
        $paramsStr = '';

        if($params != null){
            $paramsStr .= ' WHERE ';
            if(count($params) > 1){
                for($i = 0; $i < count($params - 1); $i++){
                    $paramsStr .= $params[$i] . ' and ';
                }
            }
            $paramsStr .= $params[count($params) - 1];
        }

        $query = $this->db->query('SELECT idmenu, name, subelement FROM EglyCMS_menu'.$paramsStr);
        
        if($query->num_rows() > 0){
            foreach($query->result() as $row){
                $result[] = $row;
            }
        }
        /**
         * $result[0] = {idmenu: 1, name: 'name', subelement: 1/null}
         */
        return $result;
    }

    /**
     * Zmienia nazwę elementu menu
     */
    function changeMenu($id, $value, $valueControl){
        return $query = $this->db->query("UPDATE EglyCMS_menu SET name='".$value."' WHERE idmenu='".$id."'");  
    }

    /**
     * Dodaje nowy element menu
     */
    function addMenu($name, $subelement){
        $array = array('name'=>$name, 'subelement'=>$subelement);
        $str = $this->db->insert_string('EglyCMS_menu', $array);
        $this->db->query($str);
        return $this->db->insert_id();
    }
    /**
     * Usuwa element menu
     */
    function deleteMenu($idmenu){
        $elementsForDelete = [];
        $this->db->trans_start();
        $query = $this->db->query("DELETE FROM EglyCMS_page WHERE menu_idmenu=".$idmenu);
        $query = $this->db->query("DELETE FROM EglyCMS_menu WHERE idmenu=".$idmenu);
        $this->db->trans_complete();

        return $query;
    }

    
}