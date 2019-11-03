<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastro extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->model('CadastroModel');
	}

	/**
		Metodo principal
	*/
	public function index()
	{

		$this->load->view('cadastro');
	}

	/**
		Metodo para inserir novo cadastro

		verifica se ja existe registro com o mesmo email e retornar um true ou false

		recebe a senha via post e trata a criptografia com a função password_hash()
	*/
	public function add()
	{

		$senha = password_hash($this->input->post('senha'), PASSWORD_DEFAULT);

		$dados = array(
			'nome'=>$this->input->post('nome'),
			'login'=>$this->input->post('email'),
			'senha'=>$senha
		);

		$cad = $this->CadastroModel->add($dados);

		if($cad > 0){
			$this->session->set_flashdata('sucesso', 1);
		}else{
			$this->session->set_flashdata('sucesso', 2);
		}

		return redirect(base_url('panel/index.php/Cadastro'), 'refresh');

	}	
}
