<?php

class panelSetting_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    /**
     * zwraca wszystkie ustawienia zapisane w bazie danych
     */
    public function getSetting(){
        $this->db->select("idsetting, name, value, group, options");
        $query = $this->db->get('EglyCMS_setting');

        $result = array();

        if($query->num_rows() > 0){
            foreach($query->result() as $row){
                $tmp = array();
                $tmp['idsetting'] = $row->idsetting;
                $tmp['name'] = $row->name;
                $tmp['value'] = $row->value;
                $tmp['group'] = $row->group;
                $tmp['options'] = $row->options;

                $result[] = $tmp;
            }
        }

        return $result;
    }

    /**
     * zwraca konkretną wartośc ustawień
     * parametry:
     * name - nazwa ustawienia
     */
    public function getSpecificSettingValue($params){
        $this->db->select("idsetting, name, value, options");
        $query = $this->db->get_where('EglyCMS_setting', array('name'=>$params['name']));

        if($query->num_rows() > 0){
            $row = $query->row();
            $result = array('idsetting'=>$row->idsetting, 'name'=>$row->name, 'value'=>$row->value, 'options'=>$row->options);

            return $result;
        }
    }

    /**
     * metoda zmienia wartość jednej z wartości ustawień
     * parametry:
     * idsetting - id wartości do zmienienia
     * value - nowa wartość do zmiany
     */
    public function setValue($params){
        $data = array('value'=>$params['value']);
        $where = "idsetting=".$params['idsetting'];
        $str = $this->db->update_string('EglyCMS_setting', $data, $where);

        $query = $this->db->query($str);
    }

    /**
     * metoda pobiera wartość języka 
     */
    public function getLang(){
        $this->db->select("value");
        $query = $this->db->get_where('EglyCMS_setting', array('name' => 'language'));

        if ($query->num_rows() > 0){
            $row = $query->row(); 

            return $row->value;
        }else{
            return 'english';
        }
    }
}