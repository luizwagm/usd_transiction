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

					require_once('../resources/plugins/phpmailerOficial/PHPMailerAutoload.php');

					$quem = $this->DashboardModel->getDadosId($this->session->socio_id_home);
					$para = $this->DashboardModel->getDadosId($getBeneficiario[0]->_id);

					self::enviarEmails($quem[0]->login,$quem[0]->nome,'Transferiu',date('d/m/Y H:i:s'),number_format($valor,2,',','.'));
					self::enviarEmails($para[0]->login,$para[0]->nome,'Recebeu',date('d/m/Y H:i:s'),number_format($valor,2,',','.'));

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

	/**
		Enviar e-mails
	*/
	public function enviarEmails($email,$usuario,$transacao,$dataHora,$valor)
	{

		$mailer = new PHPMailer();
		$mailer->IsSMTP();
		$mailer->SMTPDebug = 1;
		$mailer->Port = 587; //Indica a porta de conexão 
		$mailer->Host = 'url-servidor';//Endereço do Host do SMTP 
		$mailer->SMTPAuth = true; //define se haverá ou não autenticação 
		$mailer->Username = 'email-suporte'; //Login de autenticação do SMTP
		$mailer->Password = 'senha-suporte'; //Senha de autenticação do SMTP
		$mailer->FromName = 'Suporte '; //Nome que será exibido
		$mailer->From = 'email-suporte'; //Obrigatório ser a mesma caixa postal configurada no remetente do SMTP
		$mailer->AddAddress($email,$usuario);
		//Destinatários
		$mailer->Subject = utf8_decode('Transação do sistema USD');
		$mailer->Body = '<p>Olá '.$usuario.',</p>
					<p>Você '.$transacao.' o valor de R$ '.$valor.' às '.$dataHora.'</p>';
		$mailer->IsHTML(true);
		$mailer->Send();
	}

	
}
