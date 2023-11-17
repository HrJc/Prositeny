<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	public function __construct()
	{
		parent::__construct();

		$this->load->library(['form_validation','session']);
		$this->load->model('login/login_model');
		//$this->load->helper('url');
	}

	public function deconnecter()
	{
		$this->session->sess_destroy();
		$this->session->set_flashdata('login-msg', "Veuillez-vous identifier");
		redirect(base_url());
	}

	/******************************************************************************************
			Vérifier état connexion : se déconnecter si session null
	******************************************************************************************/
	public function testerSession()
	{
		if (!$this->session->userdata('isconnected'))
		{
			$this->session->set_flashdata('login-msg', "Votre session est expirée. Veuillez-vous reconnecter");
			redirect('login/connexion');
			return;
		}
	}

	public function index()
	{
		$this->load->view('login');
	}

	public function verificationUser()
	{
		$pseudo = $this->input->post('pseudo');
		$mdp = $this->input->post('password');
		$datauser = $this->login_model->userLogin($pseudo,$mdp);		
		$test = (!empty($datauser)) ? true : false ;

		if($test==true)
		{
			$tabSession = array(
				'utilisateur' => $pseudo,				
				'id' => $datauser->id,				
				'email' => $datauser->email,				
				'prenom' => $datauser->prenom,				
				'isconnected' => TRUE,
				'idRegion' => $datauser->id_region,
				'idDistrict' => $datauser->id_district,
				'tabRegion' => explode("_",$datauser->id_region),
				'type' => $datauser->type,
			);
			$this->session->set_userdata($tabSession);
			redirect('AdminCont/resultat','location');		
		}
		else{
			$this->session->set_flashdata('login-msg', "Nom d'utilisateur ou mot de passe invalide");
			redirect('login/index');
		}
		
	}
}
