<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->model('DashboardModel');
	}

	/**
		Metodo principal
	*/
	public function index()
	{
		require_once('validar_acesso.php');
		
		$dados = $this->DashboardModel->getDados();

		$data['dados'] = $dados[0];

		$saldo = $this->DashboardModel->getSaldo();
		$data['saldo'] = $saldo[0];

		$historico = $this->DashboardModel->getHistorico();
		$data['historico'] = $historico;

		$this->load->view('dashboard',$data);
	}

	/**
		Metodo para atualizar os dados do usuario

		Caso a senha esteja em branco, não altera a mesma, caso contrario a converte em password_hash()
	*/
	public function MeusDadosAtualizar()
	{
		if(strlen($this->input->post('senha')) > 0){
			$senha = password_hash($this->input->post('senha'), PASSWORD_DEFAULT);

			$dados = array(
				'nome'=>$this->input->post('nome'),
				'login'=>$this->input->post('email'),
				'senha'=>$senha
			);
		}else{
			$dados = array(
				'nome'=>$this->input->post('nome'),
				'login'=>$this->input->post('email')
			);
		}

		$upd = $this->DashboardModel->editDados($dados);

		if($upd > 0){
			$this->session->set_flashdata('sucesso_dados', 1);
		}else{
			$this->session->set_flashdata('sucesso_dados', 2);
		}

		return redirect(base_url('panel/index.php/Dashboard'), 'refresh');
	}

	/**
		Metodo para inserir um novo saldo ao usuario
		Obs: somente para usuário novo que não tem saldo cadastrado
	*/
	public function inserirSaldo()
	{
		$dados = array(
			'valor'=>str_replace(' ','',str_replace(',','.',$this->input->post('saldo')))
		);

		$cadastrar_saldo = $this->DashboardModel->insertSaldo($dados);

		return redirect(base_url('panel/index.php/Dashboard'), 'refresh');
	}

	/**
		Metodo para transferir valor, pesquisando pelo id do usuario e realizando as verificações para efetuar a transferencia
	*/
	public function transferirValor()
	{
		$beneficiario = $this->input->post('beneficiario');

		if($beneficiario != $this->session->socio_id_home){

			$valor = str_replace(' ','',str_replace(',','.',$this->input->post('valor')));

			$getBeneficiario = $this->DashboardModel->getBeneficiario($beneficiario);

			if(count($getBeneficiario) > 0){

				$dados = array(
					'id_quem'=>$this->session->socio_id_home,
					'id_para'=>$getBeneficiario[0]->_id,
					'valor'=>$valor,
					'id_transacao'=>uniqid(rand(),false)
				);

				$efetuar = $this->DashboardModel->realizarTransacao($dados,$valor,$getBeneficiario[0]->_id);

				if($efetuar > 0){
					$this->session->set_flashdata('sucesso_transf', 1);
				}else{
					$this->session->set_flashdata('sucesso_transf', 4);
				}
			}else{
				$this->session->set_flashdata('sucesso_transf', 2);
			}
		}else{
			$this->session->set_flashdata('sucesso_transf', 3);
		}

		return redirect(base_url('panel/index.php/Dashboard'), 'refresh');

	}

	
}
