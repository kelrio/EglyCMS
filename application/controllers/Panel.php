<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller{
    public function index(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->model('panel/PanelSetting_model', '', TRUE);

			$data['language'] =  $this->PanelSetting_model->getLang();
            $data['page_title'] = 'content_view_index_title';
            $data['header_title'] = 'content_view_index_header';
            $data['last_page'] = '';
            $this->load->view('panelView/index_view', $data);
        }else{
            $this->load->helper('url');
            header("Location: ".base_url().'panel/login');
        }
        
    }

    public function login(){
        
        $this->load->model('panel/PanelSetting_model', '', TRUE);

		$language =  $this->PanelSetting_model->getLang();
        $this->lang->load('messageWindow', $language);
        $this->lang->load('panel/login', $language);

        $__lang = array(
            'message_sending'=>$this->lang->line('message_sending'), 
            'message_sending_ok'=>$this->lang->line('message_sending_ok'), 
            'message_error'=>$this->lang->line('message_error'),
            'message_logining'=>$this->lang->line('message_logining'),
            'message_logining_ok'=>$this->lang->line('message_logining_ok'),
            'message_account_doesnt_exist'=>$this->lang->line('message_account_doesnt_exist'),
            'message_password_incorrect'=>$this->lang->line('message_password_incorrect'),
            'message_logining_error'=>$this->lang->line('message_logining_error'),
            'login_login'=>$this->lang->line('login_login'),
            'login_password'=>$this->lang->line('login_password'),
            'login_button_logining'=>$this->lang->line('login_button_logining'),
        );

        $data['contentLang'] = json_encode($__lang);
        $data['language'] =  $language;
        $data['page_title'] = 'content_view_login_title';
        $data['header_title'] = 'content_view_login_header';
        $data['last_page'] = '';

        $this->load->view('panelView/login_view', $data);
    }

    public function layout(){
        
        session_start();

        if($_SESSION['user']){
            if($_SESSION['access'][2] == 1){
                $this->load->model('panel/PanelSetting_model', '', TRUE);

			    $language =  $this->PanelSetting_model->getLang();
                $this->lang->load('messageWindow', $language);
                $this->lang->load('panel/layout', $language);

                $__lang = array(
                    'message_sending'=>$this->lang->line('message_sending'), 
                    'message_sending_ok'=>$this->lang->line('message_sending_ok'), 
                    'message_error'=>$this->lang->line('message_error'),
                    'message_sending_file'=>$this->lang->line('message_sending_file'),
                    'message_sending_file_ok'=>$this->lang->line('message_sending_file_ok'),
                    'message_downloading_file'=>$this->lang->line('message_downloading_file'),
                    'message_downloading_file_ok'=>$this->lang->line('message_downloading_file_ok'),
                    'layout_active_style'=>$this->lang->line('layout_active_style'),
                    'layout_not_selected_file'=>$this->lang->line('layout_not_selected_file'),
                    'layout_button_example_view'=>$this->lang->line('layout_button_example_view'),
                );

                $data['contentLang'] = json_encode($__lang);
                $data['language'] =  $language;

                $data['activeStyle'] = json_encode($this->PanelSetting_model->getSpecificSettingValue(array('name'=>'activeStyle')));
                $data['page_title'] = 'content_view_layout_title';
                $data['header_title'] = 'content_view_layout_header';
                $data['last_page'] = 'panel';
                $this->load->view('panelView/layout_view', $data);
            }else{
                $this->load->helper('url');
                header("Location: ".base_url().'panel/accessDenied');
            }
        }else{
            $this->load->helper('url');
            header("Location: ".base_url().'panel/login');
        }
    }

    public function content(){
        
        session_start();
        
        if($_SESSION['user']){
            $this->load->model('panel/PanelMenu_model', '', TRUE);
            $this->load->model('panel/PanelSetting_model', '', TRUE);

			$language =  $this->PanelSetting_model->getLang();
            $data['language'] =  $language;

            $data['menu_json'] = json_encode($this->PanelMenu_model->get_menu());
            $data['page_title'] = 'content_view_content_title';
            $data['header_title'] = 'content_view_content_header';
            $data['last_page'] = 'panel';
            $this->load->view('panelView/content_view', $data);
        }else{
            $this->load->helper('url');
            header("Location: ".base_url().'panel/login');
        }
    }

    public function setting(){
        
        session_start();

        if($_SESSION['user']){
            if($_SESSION['access'][2] == 1){
                $this->load->model('panel/PanelSetting_model', '', TRUE);

                $language =  $this->PanelSetting_model->getLang();
                $this->lang->load('messageWindow', $language);

                $__lang = array(
                    'message_sending'=>$this->lang->line('message_sending'), 
                    'message_sending_ok'=>$this->lang->line('message_sending_ok'), 
                    'message_error'=>$this->lang->line('message_error'),
                );

                $data['contentLang'] = json_encode($__lang);
                $data['language'] =  $language;
                
                $data['setting'] = json_encode($this->PanelSetting_model->getSetting());
                $data['page_title'] = 'content_view_setting_title';
                $data['header_title'] = 'content_view_setting_header';
                $data['last_page'] = 'panel';
                $this->load->view('panelView/setting_view', $data);
            }else{
                $this->load->helper('url');
            header("Location: ".base_url().'panel/accessDenied');
            }
        }else{
            $this->load->helper('url');
            header("Location: ".base_url().'panel/login');
        }
    }

    public function users(){
        
        session_start();

        if($_SESSION['user']){
            if($_SESSION['access'][3] == 1){
                $this->load->model('panel/PanelUser_model', '', TRUE);
                $this->load->model('panel/PanelSetting_model', '', TRUE);

                $language =  $this->PanelSetting_model->getLang();

                $this->lang->load('messageWindow', $language);
                $this->lang->load('panel/user', $language);

                $__lang = array(
                    'message_sending'=>$this->lang->line('message_sending'), 
                    'message_sending_ok'=>$this->lang->line('message_sending_ok'), 
                    'message_error'=>$this->lang->line('message_error'),
                    'message_password_not_equal'=>$this->lang->line('message_password_not_equal'),
                    'user_login' =>$this->lang->line('user_login'),
                    'user_password' =>$this->lang->line('user_password'),
                    'user_password_re' =>$this->lang->line('user_password_re'),
                    'user_edit_article' =>$this->lang->line('user_edit_article'),
                    'user_create_page' =>$this->lang->line('user_create_page'),
                    'user_change_setting' =>$this->lang->line('user_change_setting'),
                    'user_change_account' =>$this->lang->line('user_change_account'),
                    'user_popup_confirm_delete_account'=>$this->lang->line('user_popup_confirm_delete_account')
                );

                $data['contentLang'] = json_encode($__lang);

                $data['language'] = $language;
                $data['page_title'] = 'content_view_users_title';
                $data['header_title'] = 'content_view_users_header';
                $data['last_page'] = 'panel';
                $data['userData'] = json_encode($this->PanelUser_model->getAccount());

                $this->load->view('panelView/user_view.php', $data);
            }else{
                $this->load->helper('url');
                header("Location: ".base_url().'panel/accessDenied');
            }
        }else{
            $this->load->helper('url');
            header("Location: ".base_url().'panel/login');
        }
    }

    public function menu(){
        
        session_start();

        if($_SESSION['user']){
            if($_SESSION['access'][1] == 1){
                $this->load->model('panel/PanelMenu_model', '', TRUE);
                $this->load->model('panel/PanelSetting_model', '', TRUE);

			    $language =  $this->PanelSetting_model->getLang();
                $this->lang->load('messageWindow', $language);
                $this->lang->load('panel/content', $language);

                $__lang = array(
                    'message_sending'=>$this->lang->line('message_sending'), 
                    'message_sending_ok'=>$this->lang->line('message_sending_ok'), 
                    'message_error'=>$this->lang->line('message_error'),
                    'text_add_new_menu_el'=>$this->lang->line('content_menu_button_add_new_element'),
                    'text_confirm_delete_element'=>$this->lang->line('content_popup_confirm_query_delete_element'),
                );

                $data['contentLang'] = json_encode($__lang);
                $data['language'] = $language;
                $data['menu_json'] = json_encode($this->PanelMenu_model->get_menu());
                $data['page_title'] = 'content_view_menu_title';
                $data['header_title'] = 'content_view_menu_header';
                $data['last_page'] = 'panel/content';
                
                $this->load->view('panelView/menu_view', $data);
            }else{
                $this->load->helper('url');
                header("Location: ".base_url().'panel/accessDenied');
            }
        }else{
            $this->load->helper('url');
            header("Location: ".base_url().'panel/login');
        }
    }

    public function accessDenied(){
        
            $this->load->model('panel/PanelSetting_model', '', TRUE);

            $data['language'] =  $this->PanelSetting_model->getLang();
            $data['page_title'] = 'content_view_accessDenied_title';
            $data['header_title'] = 'content_view_accessDenied_header';
            $data['last_page'] = 'panel';
            $data['message'] = 'content_view_accessDenied_message';
            
            $this->load->view('panelView/accessDenied_view', $data);
    }

    public function editPage($id = null){
        
        session_start();

        if($_SESSION['user']){
            if($_SESSION['access'][0] == 1){
                $this->load->model('panel/PanelMenu_model', '', TRUE);
                $this->load->model('panel/PanelEditPage_model', '', TRUE);
                $this->load->model('panel/PanelSetting_model', '', TRUE);

                $el = $this->PanelMenu_model->get_menu(['idmenu='.$id]);

                $elementsOnPage = $this->PanelEditPage_model->getAllElements(array('idpage'=>$id));

                if(isset($el[0])){

                    $language =  $this->PanelSetting_model->getLang();
                    $this->lang->load('messageWindow', $language);
                    $this->lang->load('panel/content', $language);
                    $this->lang->load('panel/editPage', $language);

                    $__lang = array(
                        'message_sending'=>$this->lang->line('message_sending'), 
                        'message_sending_ok'=>$this->lang->line('message_sending_ok'), 
                        'message_error'=>$this->lang->line('message_error'),
                        'message_editPage_save_change'=>$this->lang->line('message_editPage_save_change'),
                        'editPage_modal_upload_file'=>$this->lang->line('editPage_modal_upload_file'),
                        'editPage_modal_add_picture'=>$this->lang->line('editPage_modal_add_picture'),
                        'editPage_picture_description'=>$this->lang->line('editPage_picture_description'),
                    );

                    $data['contentLang'] = json_encode($__lang);
                    $data['language'] = $language;

                    $data['menu_element'] = json_encode($el);
                    $data['elements_on_page'] = json_encode($elementsOnPage);

                    $data['page_title'] = 'content_view_editPage_title';
                    $data['header_title'] = 'content_view_editPage_header';
                    $data['last_page'] = 'panel/content';
                    
                    $this->load->view('panelView/editPage_view', $data);
                }else{
                    $data['page_title'] = 'content_view_error';
                    $data['header_title'] = 'content_view_error_header';
                    $data['last_page'] = 'panel/content';
                    $data['error'] = 'controller_panel_editPage_notEqualId';

                    $this->load->view('panelView/error_view', $data);
                }
            }else{
                $this->load->helper('url');
                header("Location: ".base_url().'panel/accessDenied');
            }
        }else{
            $this->load->helper('url');
            header("Location: ".base_url().'panel/login');
        }
    }

    /**
     * metoda do wylogowania użytkownika
     */
    public function logout(){
        $this->load->helper('url');

        session_start();

        session_unset(); 

        header("Location: ".base_url());
    }

    
    /**
     * metoda służąca do zmiany nazwy elementu
     * sprawdza czy element o danym id istnieje, jesli tak to zmienia jego nazwę
     */
    public function renameMenuElements(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->model('panel/PanelMenu_model', '', TRUE);
            $this->lang->load('error_lang');

            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $valueControl = $this->input->post('valueControl');

            $results = $this->PanelMenu_model->get_menu(['idmenu='.$id]);

            if(isset($results[0])){
                if($results[0]->name == $valueControl){
                    echo $this->PanelMenu_model->changeMenu($id, $name, $valueControl);
                }else{
                    echo $this->lang->line('controller_Panel_changeMenuElements_not_equal_values');
                }
            }else{
                echo $this->lang->line('controller_Panel_changeMenuElements_no_id');
            }
        }
    }
    /**
     * metoda dodająca nowy element do menu, dodaje nowy pień badź gałąź
     */
    public function addMenuElements(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->model('panel/PanelMenu_model', '', TRUE);

            $name = $this->input->post('name');
            $subelement = ($_POST['subelement'] != null) ? $_POST['subelement'] : NULL;
            
            echo $this->PanelMenu_model->addMenu($name, $subelement);
        }
    }
    /**
     * metoda usuwająca element o danym id, a także jego podelementy
     * najpierw sprawdza czy istnieje element o danym id, potem czy suswana jest poprawy element
     * a następnie pobiera id wszystkich podelementow i je usuwan, na końcu usuwa głwny element
     */
    public function deleteMenuElement(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->model('panel/PanelMenu_model', '', TRUE);

            $id = $this->input->post('id');
            $name = $this->input->post('name');

            $result = $this->PanelMenu_model->get_menu(['idmenu='.$id]);
            if(count($result) > 0){
                if($result[0]->name == $name){
                    $result2 = $this->PanelMenu_model->get_menu(['subelement='.$id]);
                    if(count($result2) > 0){
                        for($i = 0; $i < count($result2); $i++){
                            $this->PanelMenu_model->deleteMenu($result2[$i]->idmenu);
                        }
                    }
                    echo $this->PanelMenu_model->deleteMenu($id);
                }
            }
        }
    }

    public function getImages(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->helper('url');
            $this->load->helper('file');
            $this->load->model('panel/PanelEditPage_model', '', TRUE);
            $this->load->library('images');

            $imagesInBase = $this->PanelEditPage_model->getAllImage();
            $result = [];

            // //sprawdzanie czy na serwerze istnieją pliki nieistniejące w bazie danych
            // $fileOnServer = array();
            // $click=opendir(base_url().'media/upload/');
            // while (false !== ($file = readdir($click))) {
            //     if (($file !=".")&&($file !="..")){ 
            //         $fileOnServer[] = $file;
            //     }
            // }
            // closedir($click);

            foreach ($imagesInBase as $row) {
                //jeśli istnieje plik z bazy na serwerrze
                if(read_file(base_url().'media/upload/'.$row->name.'.'.$row->type)){
                    $array = array('name' => $row->name, 'type' => $row->type, 'url' => base_url().'media/upload/');
                    $result[] = ['id' => $row->idImage, 'name' => $row->name, 'code' => $this->images->convertImage($array), 'type' => $row->type];
                //jeśli plik został usunięty z serwera a jest w bazie danych
                }else{
                    $array = array('name' => 'empty-image', 'type' => 'png', 'url' => base_url().'media/');
                    $result[] = ['id' => $row->idImage, 'name' => $row->name, 'code' => $this->images->convertImage($array), 'type' => $row->type];
                }
                // $array = array('name' => $row->name, 'type' => $row->type, 'url' => base_url().'media/upload/');
                // $result[] = ['id' => $row->idImage, 'name' => $row->name, 'code' => $this->images->convertImage($array), 'type' => $row->type];
            }
            
            echo json_encode($result);
        }
    }

    /**
     * metoda do zapisu pliku graficznego na serwerze
     */
    public function editPage_saveFile(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->helper('file');
            $this->load->model('panel/PanelEditPage_model', '', TRUE);
            $this->lang->load('error_lang');

            $url = $this->input->post('url');
            $type;

            $result = [];
            
            // dzieli kod url na części
            // $data[ 0 ] == "data:image/png;base64"
            // $data[ 1 ] == obrazek zakodowany w base64
            $data = explode(',', $url);

            switch($data[0]){
                case 'data:image/jpeg;base64':  $type = 'jpg'; break;
                case 'data:image/png;base64':  $type = 'png'; break;
                case 'data:image/gif;base64':  $type = 'jpg'; break;
            }
            
            //zapisanie danych o obrazku w bazie danych
            $date = date('Y-m-d H:i:s').'';
            $id = md5($date);

            //upload obrazka na dysku, wraz ze sprawdzeniem czy plik został załądowany
            if ( ! write_file('./media/upload/'.$id.'.'.$type,  base64_decode($data[1])) ){
                $result['result'] = $this->lang->line('controller_panel_uploadImage_failed');
                $result['type'] = null;
            }else{
                $result['result'] =  $this->lang->line('controller_panel_uploadImage_success');
                //wygenerowanie nowej nazwy z pliku
                $newFileName = md5_file('./media/upload/'.$id.'.'.$type);
                //jeśli istnieje już takki plik na serwerze
                if(!file_exists('./media/upload/'.$newFileName.'.'.$type)){
                    //zmień jego nazwę
                    rename('./media/upload/'.$id.'.'.$type, './media/upload/'.$newFileName.'.'.$type);

                    //zapisanie danych o pliku na serwerze
                    $params = array('name'=>$newFileName, 'type'=>$type);
                    $result['id'] = $this->PanelEditPage_model->addImage($params);

                    $result['type'] = $type;
                    $result['name'] = $newFileName;
                    $result['code'] = $data[1];

                }else{
                    $result['type'] = null;
                    $result['name'] = null;
                    $result['code'] = null;
                    $result['result'] = $this->lang->line('controleer_panel_updateImage_thereIsFile');

                    //usunięcie pliku tymczasowego
                    unlink('./media/upload/'.$id.'.'.$type);
                }
            }

            echo json_encode($result);
        }
    }

    /**
     * metoda tworząca nowe elementy w bazie dla danej strony
     */
    public function createElementsWithPanel(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->model('panel/PanelEditPage_model', '', TRUE);

            $res = json_decode($this->input->post('data'));
            $idPage = $this->input->post('idPage');
            $return = array();

            //pobieranie istniejacych elementow strony
            $existingElementsOnPage = $this->PanelEditPage_model->getPageElement(array('idPage'=>$idPage));

            //elementy do usunięcia połączenia
            //idtext - id tekstu do usunięcia
            //idimage - idimage do usunięcia
            $elementsForDelete = array();

            //dodawanie elementow
            foreach ($res as $key => $value) {
                //tekst
                $type = $value->type;
                if($type == 'text'){

                    $ret = array();
                    //ustawianie id w bazie dla tekstu oraz tworzenie połączenia z elementem na stronie jeśli takiego nie posiada
                    if($value->idElement != 'null'){
                        $idInBase = $value->idElement;
                        //zmiana kolejności wyświetlania elementu na stronie
                        $idInPage = $this->PanelEditPage_model->changeOrderInPage(array('idtext'=>$idInBase, 'idimage'=>null, 'orders'=>$key));
                        
                    }else{
                        $idInBase = $this->PanelEditPage_model->setTextOnPage();
                        $array = array('idmenu'=>$idPage, 'idtext'=>$idInBase, 'idimage'=>null, 'orders'=>$key);
                        //utworzenie nowego połączenia element - strona
                        $idInPage = $this->PanelEditPage_model->setConnectionWithPageAndElement($array);
                    }
                    $ret['id'] = $idInBase;

                    $array = array('idtextOnPage' => $idInBase, 'text' => $value->description);
                    $this->PanelEditPage_model->changeTextOnPage($array);
                    

                    $return[] = $ret;
                }

                if($type == 'image'){
                //obrazki
                    $ret = array();

                    $idImageInAllBase = $this->PanelEditPage_model->getIndexImageByName(array('name' => $value->imageName));

                    //ustawianie id w bazie dla tekstu jeśli takiego nie posiada
                    if($value->idElement != 'null'){
                        $idInBase = $value->idElement;
                        $idInPage = $this->PanelEditPage_model->changeOrderInPage(array('idtext'=>null, 'idimage'=>$idInBase, 'orders'=>$key));
                        $replaceDescription = $this->PanelEditPage_model->replaceDescriptionImage(array('idimageOnPage'=>$value->idElement, 'description'=>$value->description));
                    }else{
                        $idInBase = $this->PanelEditPage_model->addImageToPage(array('idImage' => $idImageInAllBase, 'description' => $value->description));
                        $array = array('idmenu'=>$idPage, 'idtext'=>null, 'idimage'=>$idInBase, 'orders'=>$key);
                        $idInPage = $this->PanelEditPage_model->setConnectionWithPageAndElement($array);
                    }
                    $ret['id'] = $idInBase;

                    //$idInBase = $this->PanelEditPage_model->addImageToPage(array('idImage'=>$idImage, 'description'=>$value->description));
                    //$ret['id'] = $idInBase;

                    $return[] = $ret;
                }
            }
            echo json_encode($return);
            
            //zrobić zapisywanie danych zmienionych od użytkownika w bazie danych
        }
    }

    //obsługa layotow

    /**
     * usuwanie elementu z bazy danych
     */
    public function removeElementsWithPanel(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->model('panel/PanelEditPage_model', '', TRUE);

            $idElement = $this->input->post('id');
            $typeElement = $this->input->post('type');

            echo $idElement.' '.$typeElement;

            if($typeElement == 'text'){
                $array = array('idtext'=>$idElement, 'idimage'=>null);
            }else{
                $array = array('idtext'=>null, 'idimage'=>$idElement);
            }
            $model = $this->PanelEditPage_model->removeElementFromPage($array);
            

            echo 'done';
        }
    }


    //zmienia wartośc w ustawieniach
    public function changeValue_setting(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->model('panel/PanelSetting_model', '', TRUE);

            $idsetting = $this->input->post('idsetting');
            $value = $this->input->post('value');

            $this->PanelSetting_model->setValue(array('idsetting'=>$idsetting, 'value'=>$value));

            echo 'done';
        }
    }

    //pobiera zawartość pliku styli od użytkownika
    public function downloadStyle(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->helper('url');
            $this->load->helper('file');

            $nameFile = $this->input->post('nameFile');

            $string = read_file('./media/css/presentationView/userView/'.$nameFile.'.css');

            echo $string;
        }
    }

    //zapisanie styli użytkownika
    public function uploadStyle(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->helper('url');
            $this->load->helper('file');

            $nameFile = $this->input->post('nameFile');
            $content = $this->input->post('content');

            if (!write_file('./media/css/presentationView/userView/'.$nameFile, $content)){
                echo 'Nie można zapisać pliku';
            }else{
                echo 'Plik zapisany!';
            }
        }
    }

    //pobiera zawartość wszystkich plikow styli od użytkownika
    public function downloadAllStyle(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->helper('url');
            $this->load->helper('file');

            $string = array();
            $string['body'] = read_file('./media/css/presentationView/userView/body.css');
            $string['footer'] = read_file('./media/css/presentationView/userView/footer.css');
            $string['header'] = read_file('./media/css/presentationView/userView/header.css');
            $string['menu'] = read_file('./media/css/presentationView/userView/menu.css');

            echo json_encode($string);
        }
    }

    //zarządzanie kontami

    //zmiana parametrow konta
    public function changeUser(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->model('panel/PanelUser_model', '', TRUE);

            $id = $this->input->post('iduser');
            $element = $this->input->post('element');

            if($element == 'password'){
                $value = md5($this->input->post('value'));
            }else{
                $value = $this->input->post('value');
            }
            $this->PanelUser_model->changeAccount(array('iduser'=>$id, 'element'=>$element, 'value'=>$value));

            echo 'done';
        }
    }

    //usuwanie użytkownika, jeśli był zalogowwany w sesji to go wyloguj
    public function deleteUser(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->model('panel/PanelUser_model', '', TRUE);

            $id = $this->input->post('iduser');
            $login = $this->input->post('login');

            if($_SESSION['user'] == $login){
                session_unset();
            }

            $this->PanelUser_model->deleteUser(array('iduser'=>$id));

            echo 'done';
        }
    }

    //dodawanie nowego użytkwnika
    public function addUser(){
        
        session_start();

        if($_SESSION['user']){
            $this->load->model('panel/PanelUser_model', '', TRUE);

            $login = 'user'.rand(10000,99999);

            $id =  $this->PanelUser_model->addUser(array('login'=>$login));

            $array = array('iduser'=>$id, 'login'=>$login);
            echo json_encode($array);
        }
    } 

    //logowanie
    public function logining(){
        

        $this->load->model('panel/PanelUser_model', '', TRUE);

        $result;

        $login = $this->input->post('login');
        $password = md5($this->input->post('password'));
        $userAccess = $this->PanelUser_model->getUser(array('login'=>$login));

        if($userAccess != false){
            if($password == $userAccess['password']){
                session_start();

                $_SESSION['user'] = $login;
                $_SESSION['access'] = ''.$userAccess['editArticle'].''.$userAccess['createPage'].''.$userAccess['changeSetting'].''.$userAccess['changeAccount'];

                $result = 'ok';
            }else{
                $result = 'password';
            }
        }else{
            $result = 'login';
        }

        echo $result;
    }
}