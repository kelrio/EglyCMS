<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {
	
	public function index(){
        $this->load->helper('file');

        session_start();
        session_unset(); 
        $address = '';
        $cut = explode('/', $_SERVER['REQUEST_URI']);
        foreach ($cut as $index => $row) {
            if($index < count($cut) - 1){
                $address .= $row.'/';
            }
        }

        $url = ( ! empty($_SERVER['HTTPS'])) ? 'https://' : 'http://' . '' .$_SERVER['HTTP_HOST'].'/'.$cut[1];
        
        echo $url;

        // config/config
        $data = "<?php\n".
        "defined('BASEPATH') OR exit('No direct script access allowed');\n".
        '$config["base_url"] = "'.$url.'/";'."\n".
        '$config["index_page"] = "index.php";'."\n".
        '$config["uri_protocol"]	= "REQUEST_URI";'."\n".
        '$config["url_suffix"] = "";'."\n".

        '$config["language"]	= "polish";'."\n".
        '$config["charset"] = "UTF-8";'."\n".
        '$config["enable_hooks"] = FALSE;'."\n".
        '$config["subclass_prefix"] = "MY_";'."\n".
        '$config["composer_autoload"] = FALSE;'."\n".
        '$config["permitted_uri_chars"] = "a-z 0-9~%.:_\-";'."\n".
        '$config["enable_query_strings"] = FALSE;'."\n".
        '$config["controller_trigger"] = "c";'."\n".
        '$config["function_trigger"] = "m";'."\n".
        '$config["directory_trigger"] = "d";'."\n".
        '$config["allow_get_array"] = TRUE;'."\n".
        '$config["log_threshold"] = 0;'."\n".
        '$config["log_path"] = "";'."\n".
        '$config["log_file_extension"] = "";'."\n".
        '$config["log_file_permissions"] = 0644;'."\n".
        '$config["log_date_format"] = "Y-m-d H:i:s";'."\n".
        '$config["error_views_path"] = "";'."\n".
        '$config["cache_path"] = "";'."\n".
        '$config["cache_query_string"] = FALSE;'."\n".
        '$config["encryption_key"] = "ApIpMhNiZexbEW4WEQWKWrMHL8aa78PH";'."\n".
        '$config["sess_driver"] = "files";'."\n".
        '$config["sess_cookie_name"] = "ci_session";'."\n".
        '$config["sess_expiration"] = 7200;'."\n".
        '$config["sess_save_path"] = NULL;'."\n".
        '$config["sess_match_ip"] = FALSE;'."\n".
        '$config["sess_time_to_update"] = 300;'."\n".
        '$config["sess_regenerate_destroy"] = FALSE;'."\n".
        '$config["cookie_prefix"]	= "";'."\n".
        '$config["cookie_domain"]	= "";'."\n".
        '$config["cookie_path"]		= "/";'."\n".
        '$config["cookie_secure"]	= FALSE;'."\n".
        '$config["cookie_httponly"] 	= FALSE;'."\n".
        '$config["standardize_newlines"] = FALSE;'."\n".
        '$config["global_xss_filtering"] = FALSE;'."\n".
        '$config["csrf_protection"] = FALSE;'."\n".
        '$config["csrf_token_name"] = "csrf_test_name";'."\n".
        '$config["csrf_cookie_name"] = "csrf_cookie_name";'."\n".
        '$config["csrf_expire"] = 7200;'."\n".
        '$config["csrf_regenerate"] = TRUE;'."\n".
        '$config["csrf_exclude_uris"] = array();'."\n".
        '$config["compress_output"] = FALSE;'."\n".
        '$config["time_reference"] = "local";'."\n".
        '$config["rewrite_short_tags"] = FALSE;'."\n".
        '$config["proxy_ips"] = "";'."\n";

        if ( write_file('./application/config/config.php', $data)){
            header('Location: '.$url .'/install/setup');
        }
        
    }

    public function setup(){
        $this->load->view('install/install_view.php');
    }

    public function checkconnection(){

        $hostname = $this->input->post('hostname');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $database = $this->input->post('database');

        $polaczenie = @new mysqli($hostname, $username, $password, $database);
        if (mysqli_connect_errno() != 0){
                echo 'error';
        }else {
                echo 'success';
        }
    }

    public function setData(){
        $this->load->database();
        
        $hostname = $this->input->post('hostname');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $database = $this->input->post('database');

        

        //rozpoczęcie transakcji
        $this->db->trans_start();

        $this->db->query("INSERT INTO `eglycms_setting` (`idsetting`, `name`, `value`, `options`) VALUES (NULL, 'activeStyle', 'defaultView', 'defaultView|userView');");
        $this->db->query("INSERT INTO `eglycms_setting` (`idsetting`, `name`, `value`) VALUES (NULL, 'logo', 'Default')");
        $this->db->query("INSERT INTO `eglycms_setting` (`idsetting`, `name`, `value`, `options`) VALUES (NULL, 'language', 'polish', 'polish|english')");
        $this->db->query("INSERT INTO `eglycms_user` (`iduser`, `login`, `password`, `editArticle`, `createPage`, `changeSetting`, `changeAccount`, `delete`) VALUES (NULL, 'admin', '21232f297a57a5a743894a0e4a801fc3', '1', '1', '1', '1', 'no');");

        //koniec transakcji
        $this->db->trans_complete();

        echo 'success';
    }

    //zapisywanie zmienionego pliku database cofig
    public function saveConfig(){
        $this->load->helper('file');

        $success = 0;
        $total = 0;

        $hostname = $this->input->post('hostname');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $database = $this->input->post('database');

        $total++;
        $data = "<?php\n".
        "defined('BASEPATH') OR exit('No direct script access allowed');\n".
        '$active_group = \'default\';'."\n".
        '$query_builder = TRUE;'."\n".
        '$db[\'default\'] = array('."\n".
        "   'dsn'	=> '',"."\n".
        "   'hostname' => '$hostname',"."\n".
        "   'username' => '$username',"."\n".
        "   'password' => '$password',"."\n".
        "   'database' => '$database',"."\n".
        "   'dbdriver' => 'mysqli',"."\n".
        "   'dbprefix' => '',"."\n".
        "   'pconnect' => FALSE,"."\n".
        "   'db_debug' => (ENVIRONMENT !== 'production'),"."\n".
        "   'cache_on' => FALSE,"."\n".
        "   'cachedir' => '',"."\n".
        "   'char_set' => 'utf8',"."\n".
        "   'dbcollat' => 'utf8_general_ci',"."\n".
        "   'swap_pre' => '',"."\n".
        "   'encrypt' => FALSE,"."\n".
        "   'compress' => FALSE,"."\n".
        "   'stricton' => FALSE,"."\n".
        "   'failover' => array(),"."\n".
        "   'save_queries' => TRUE"."\n".
        ");";

        if ( ! write_file('./application/config/database.php', $data)){
        }else{
            $success++;
        }

        $total++;
        $data = "<?php"."\n".
        "defined('BASEPATH') OR exit('No direct script access allowed');"."\n".
        '$autoload[\'packages\'] = array();'."\n".
        '$autoload[\'libraries\'] = array(\'database\');'."\n".
        '$autoload[\'drivers\'] = array();'."\n".
        '$autoload[\'helper\'] = array();'."\n".
        '$autoload[\'config\'] = array();'."\n".
        '$autoload[\'language\'] = array();'."\n".
        '$autoload[\'model\'] = array();'."\n";

        if ( ! write_file('./application/config/autoload.php', $data)){
        }else{
            $success++;
        }

        if($success == $total){
            echo 'success';
        }else{
            echo 'error';
        }
    }
}