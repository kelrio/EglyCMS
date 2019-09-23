<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		echo "Dostęp to tego kontrolera jest zabroniony, kliknij przycisk wstecz";
	}

	public function register(){
        
        $this->load->model('login/LoginRegister_model', '', TRUE);
        $this->load->helper('url');

        $login = $this->input->post('login');
        $password = hash('sha256', $this->input->post('password'));
        $email = $this->input->post('email');

        $id = $this->LoginRegister_model->register($login, $password, $email);

        $this->createConfirmMail($id, $email);
    }

    public function createConfirmMail($idUser, $email){
        
        $this->load->model('login/LoginRegister_model', '', TRUE);
        $this->load->helper('url');

        $id = $this->LoginRegister_model->getId($idUser);

        if(isset($id)){
            $dateTime = date('Y-m-d H:i:s');
            $nextWeek = time() + (3 * 24 * 60 * 60);
            $nextDateTime = date('Y-m-d H:i:s', $nextWeek);

            $confirmValue = hash('sha256',$idUser.' '.$dateTime);

            $result = $this->LoginRegister_model->createConfirmEmail($nextDateTime, $confirmValue, $idUser);

            
            //printf($result);
            if($result == 1){

                $res['id'] = $idUser;
                $res['key'] = $confirmValue;
                

                // $to= $email;
                // $subject = "Confirm Email";
                // $messages= "Hello\nPlease confirm your email entered with this link: <a href='".base_url()."login/confirmEmail/".$confirmValue."'>".base_url()."login/confirmEmail/".$confirmValue."</a>";

                // if( mail($to, $subject, $messages) ) {
                //     echo "Email sended!";
                // } else {
                //     echo "Error!";
                // }

            }
        }else{
            echo 'id istnieje';
        }

        
    }
    
    public function confirmEmail($confirmEmail){
        
        $this->load->model('login/LoginRegister_model', '', TRUE);
        $this->load->helper('url');
        
        $result = $this->LoginRegister_model->getConfirm($confirmEmail);

        echo $result->time;
    }
}