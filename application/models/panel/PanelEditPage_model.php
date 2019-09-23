<?php

class panelEditPage_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    /**
     * zwraca wszystkie obrazki znajdujące się na serwerze
     */
    public function getAllImage(){
        $sql = 'SELECT idImage, name, type FROM EglyCMS_image';
        $query = $this->db->query($sql);
        $result = [];

        foreach($query->result() as $row){
            $result[] = $row;
        }

        return $result;
    }

    public function getImage($params){
        $condition = '';
        if($params['condition'] != null){
            $condition = 'WHERE '.$params['condition'];
        }
        $str = 'SELECT idimage, name, type FROM EglyCMS_image'.$condition;
        $query = $this->db->query($str);
        $result = array();

        foreach ($query as $row) {
            $res = array();
            $res['idimage'] = $row->idimage;
            $res['name'] = $row->name;
            $res['type'] = $row->type;

            $result[] = $res;
        }

        return $result; 
    }

    /**
     * Dodaje informacje o obrazku do bazy danych
     * parametry:
     * name - nazwa w bazie danych
     * type - typ obrazka (jpg, png, gif)
     * 
     * zwraca id nowo utworzonego elementu
     */
    public function addImage($params){
        $array = array('name'=>$params['name'], 'type'=>$params['type']);
        $str = $this->db->insert_string('EglyCMS_image', $array);
        $this->db->query($str);
        return $this->db->insert_id();
    }

    /**
     * tworzy id tekstu w bazoe danych
     */
    public function setTextOnPage(){
        $array = array('text' => '');
        $str = $this->db->insert_string('EglyCMS_textOnPage', $array);
        $this->db->query($str);
        return $this->db->insert_id();
    }

    /**
     * zmienia treść tekstu na stronie
     * parametry
     * text - tekst do zmiany
     * idtextOnPage - id tekstu do zmiany
     */
    public function changeTextOnPage($params){
        $data = array('text' => $params['text']);
        $where = "idtextOnPage = '".$params['idtextOnPage']."'"; 
        $str = $this->db->update_string('EglyCMS_textOnPage', $data, $where);
        $this->db->query($str);
        return $this->db->insert_id();
    }


    /**
     * pobiera index obrazka po nazwie
     * parametry
     * name - nazwa do wyszukania w bazie
     */
    public function getIndexImageByName($params){
        $str = "SELECT idimage FROM EglyCMS_image WHERE name = '".$params['name']."'";
        $query = $this->db->query($str);
        $row = $query->row();
        return $row->idimage;
    }

    /**
     * Dodaje obrazek do strony
     * parametry
     * idImage - id obrazka do dodania
     * description - opis pod obrazek na danej stronie
     */
    public function addImageToPage($params){
        $array = array('image_idimage' => $params['idImage'], 'description' => $params['description']);
        $str = $this->db->insert_string('EglyCMS_imageOnPage', $array);
        $this->db->query($str);
        return $this->db->insert_id();
    }

    /**
     * zwraca wszystkie elementy dla danej strony
     * parametry:
     * idPage
     */
    public function getPageElement($params){
        $abc = "abc";
        $str = "SELECT imageOnPage_idimageOnPage, textOnPage_idtextOnPage, orders FROM EglyCMS_page WHERE menu_idmenu = '".$params['idPage']."'";
        $query = $this->db->query($str);

        $result = array();

        if ($query->num_rows() > 0){
            foreach ($query->result() as $row){
                $tab = array();
                $tab['idImage'] = $row->imageOnPage_idimageOnPage;
                $tab['idText'] = $row->textOnPage_idtextOnPage;
                $tab['order'] = $row->orders;

                $result[] = $tab;
            }
        }
        return $result;
    }

    /**
     * tworzy połączenie elementu z danym elementem
     * parametry
     * idmenu - identyfikator elementu strony
     * idtext - id tekstu*
     * idimage - id grafiki*
     * orders - numer wyświetlenia na stronie
     * * - opcjonalne
     */
    public function setConnectionWithPageAndElement($params){
        $array = array('menu_idmenu' => $params['idmenu'], 'imageOnPage_idimageOnPage' => $params['idimage'], 'textOnPage_idtextOnPage'=>$params['idtext'], 'orders'=>$params['orders']);
        $str = $this->db->insert_string('EglyCMS_page', $array);
        $this->db->query($str);
        return $this->db->insert_id();
    }

    /**
     * zmienia kolejność wyświetlania elementow na stronie
     * parametry
     * idtext - id tekstu*
     * idimage - id grafiki*
     * orders - nowy numer kolejki
     * * - opcjonalne
     */
    public function changeOrderInPage($params){
        $where = '';
        if($params['idtext'] != null){
            $where = "textOnPage_idtextOnPage = '". $params['idtext'] ."'";
        }else{
            $where = "imageOnPage_idimageOnPage = '". $params['idimage'] ."'";
        }
        $data = array('orders'=>$params['orders']);
        $str = $this->db->update_string('EglyCMS_page', $data, $where);
        $this->db->query($str);
    }

    /**
     * usuwa z bazy obiekt należący do danej strony (page)
     * parametry:
     * idtext* - id textu
     * idimage* - id image
     * * - jedno opcjonalne
     */

    public function removeElementFromPage($params){

        if($params['idtext'] != null){
            $this->db->trans_start();
            $this->db->query("DELETE FROM EglyCMS_page WHERE textOnPage_idtextOnPage=".$params['idtext']);
            $this->db->query("DELETE FROM EglyCMS_textOnPage WHERE idtextOnPage=".$params['idtext']);
            $this->db->trans_complete();
        }else{
            $this->db->trans_start();
            $this->db->query("DELETE FROM EglyCMS_page WHERE imageOnPage_idimageOnPage=".$params['idimage']);
            $this->db->query("DELETE FROM EglyCMS_imageOnPage WHERE idimageOnPage=".$params['idimage']);
            $this->db->trans_complete();
        }
    }

    /**
     * zwraca wszystkie elementy znadujące się na stronie
     * parametry
     * idpage - id strony dla ktorej pobrać elementy
     */
    public function getAllElements($params){
        $str = "SELECT imageOnPage_idimageOnPage, textOnPage_idtextOnPage, orders FROM EglyCMS_page WHERE menu_idmenu = '".$params['idpage']."' ORDER BY orders";
        $query = $this->db->query($str);

        $result = array();

        if($query->num_rows() > 0){
            foreach($query->result() as $row){
                $idText = $row->textOnPage_idtextOnPage;
                $idImage = $row->imageOnPage_idimageOnPage;

                if($idText != null){
                    $result[] = $this->getText($idText);
                }else{
                    $result[] = $this->getImageFromPage($idImage);
                }
            }
        }

        return $result;
    }

    /**
     * zwraca dane o obrazku do wygenerowania danych w edytorze
     */
    private function getImageFromPage($id){
        $str = "SELECT iop.idimageOnPage as idimageOnPage, i.name as name, i.type as type, iop.description as description FROM EglyCMS_imageOnPage iop, EglyCMS_image i WHERE i.idimage = iop.image_idimage and iop.idimageOnPage = '".$id."'";
        $query = $this->db->query($str);

        $row = $query->row();
        
        if(isset($row)){
            $res = array();

            $res['type'] = 'image';
            $res['id'] = $row->idimageOnPage;
            $res['imageName'] = $row->name;
            $res['imageType'] = $row->type;
            $res['description'] = $row->description;

            return $res;
        }
    }
    private function getText($id){
        $str = "SELECT idtextOnPage, text FROM EglyCMS_textOnPage WHERE idtextOnPage = '".$id."'";
        $query = $this->db->query($str);

        $row = $query->row();
        
        if(isset($row)){
            $res = array();

            $res['type'] = 'text';
            $res['id'] = $row->idtextOnPage;
            $res['content'] = $row->text;

            return $res;
        }
    }

    /**
     * zmienia opis pod obrazkiem
     * praramtery
     * idimageOnPage - id 
     * description - opis pod obrazkiem
     */
    public function replaceDescriptionImage($params){
        $data = array('description'=>$params['description']);
        $where = "idimageOnPage = ". $params['idimageOnPage'];
        $str = $this->db->update_string('EglyCMS_imageOnPage', $data, $where);

        return $this->db->query($str);
    }


}