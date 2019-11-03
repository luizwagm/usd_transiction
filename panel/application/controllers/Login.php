<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->model('LoginModel');
	}

	/**
		Metodo principal
	*/
	public function index()
	{
		if(isset($this->session->socio_id_home)){
			return redirect(base_url('panel/index.php/Dashboard'), 'refresh');
		}else{
			$this->session->sess_destroy();
		}

		$this->load->view('login');
	}

	/**
		Metodo para efetuar o login, verifica a existencia do usuario e analisa se a senha confere utilizando a função password_verify()
	*/
	public function logar()
	{
		$login = $this->input->post('login');
		$senha = $this->input->post('senha');

		$mod = $this->LoginModel->validar($login,$senha);

		if($mod != 0){

			$newdata = array(
			        'socio_id_home'  => $mod[0]->_id,
			        'permissao_id_home'     => 100
			);

			$this->session->set_userdata($newdata);
			return redirect(base_url('panel/index.php/Dashboard'), 'refresh');

		}else{
			$this->session->set_flashdata('sucesso', 2);
			return redirect(base_url('panel/index.php/Login'), 'refresh');
		}
		

	}

	/**
		Metodo para efetuar o logout, destruindo as sessões
	*/
	public function logout()
	{
		$this->session->sess_destroy();

		return redirect(base_url('panel/index.php/Login'), 'refresh');

	}
}
