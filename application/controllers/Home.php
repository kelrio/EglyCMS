<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function index()
	{
		
		$this->load->helper('url');
		$this->load->model('home/Home_model', '', TRUE);

		//pobranie pierwszego elementu z bazy
		$firstElement = $this->Home_model->getFirstElementMenu();

		if($firstElement){
			header('Location: '.base_url('Home/page/'.$firstElement));
		}else{
			$this->load->model('panel/PanelSetting_model', '', TRUE);

			$data['language'] =  $this->PanelSetting_model->getLang();
			$this->load->view('homeView/empty_view.php', $data);
		}
		
	}

	//wyświetlanie treści podstrony
	public function page($id = '@#$null%1209^&'){
		

		$this->load->helper('url');

		$this->load->model('home/Home_model', '', TRUE);
		$this->load->model('panel/PanelEditPage_model', '', TRUE);
		$this->load->model('panel/PanelMenu_model', '', TRUE);
		$this->load->model('panel/PanelSetting_model', '', TRUE);

		//jeśli nie zostanie przekazane id dla strony
		if($id == '@#$null%1209^&'){
			//przekieruj na stronę głowną
			header('Location: '.base_url('Home'));
		}else{
			//jeśli id zostanie przekazane

			$idElement = $id;

			$data['activeStyle'] = $this->PanelSetting_model->getSpecificSettingValue(array('name'=>'activeStyle'));
			$data['logo'] = $this->PanelSetting_model->getSpecificSettingValue(array('name'=>'logo'));

			//nazwa podstrony (string)
			$nameElement = $this->Home_model->getNameElement(array('idmenu'=>$id)); 
			$data['nameElement'] = $nameElement;

			//elementy z danej strony
			$elementsOnPage = $this->PanelEditPage_model->getAllElements(array('idpage'=>$id)); 
			$data['elementsOnPage'] = json_encode($elementsOnPage);

			//elementy menu
			$menuElements = $this->PanelMenu_model->get_menu();
			$data['menuElements'] = json_encode($menuElements);
			
			$this->load->view('homeView/index.php', $data);
		}
	}

	//zwraca przykładowy widok tylko dla osb zalogowanych, ktore posiadają dostęp do zmiany layotow
	public function example(){
		

		session_start();

        if($_SESSION['user']){
            if($_SESSION['access'][2] == 1){

				$this->load->view('homeView/example_view.php');

			}else{
				//wywołaj widok blokujący dostęp do treści
                $this->load->helper('url');
                header("Location: ".base_url().'panel/accessDenied');
            }
        }else{
			//jeśli nie zalogowany to przerzuć do zwykłej strony
            $this->load->helper('url');
            header("Location: ".base_url().'Home');
        }
	}
}