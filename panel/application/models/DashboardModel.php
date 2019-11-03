<?php

class DashboardModel extends CI_Model {

	public function getDados()
	{
		$this->db->select('*');
		$this->db->where('_id',$this->session->socio_id_home);
		$resultado = $this->db->get('cadastro')->result();
		
		return $resultado;
	}

	public function editDados($arr)
	{
		$this->db->where('_id',$this->session->socio_id_home);
		$upd = $this->db->update('cadastro',$arr);

		return $upd;
	}

	public function getSaldo()
	{
		$this->db->select('*');
		$this->db->where('cad_id',$this->session->socio_id_home);
		$resultado = $this->db->get('saldo')->result();
		
		return $resultado;
	}

	public function insertSaldo($arr)
	{
		$this->db->where('cad_id',$this->session->socio_id_home);
		$upd = $this->db->update('saldo',$arr);

		return $upd;
	}

	public function getBeneficiario($valor)
	{

		$this->db->select('*');
		$this->db->where('_id',$valor);
		$resultado = $this->db->get('cadastro')->result();
		
		return $resultado;

	}

	public function realizarTransacao($arr,$valor,$id)
	{

		$this->db->select('*');
		$this->db->where('cad_id',$this->session->socio_id_home);
		$verSeTem = $this->db->get('saldo')->result();

		if($verSeTem[0]->valor >= $valor){

			$this->db->insert('historico_transacao',$arr);

			$this->db->select('*');
			$this->db->where('cad_id',$id);
			$resultado = $this->db->get('saldo')->result();

			if(empty($resultado[0]->valor)){
				$valorAtual = '0.00';
			}else{
				$valorAtual = $resultado[0]->valor;
			}

			$novoValor = $valorAtual + $valor;

			$dado = array(
				'valor'=>$novoValor
			);

			$this->db->where('cad_id',$id);
			$upd = $this->db->update('saldo',$dado);

			$this->db->select('*');
			$this->db->where('cad_id',$this->session->socio_id_home);
			$resultados = $this->db->get('saldo')->result();

			$valorAtualQuem = $resultados[0]->valor;
			$novoValorQuem = $valorAtualQuem - $valor;

			$dado2 = array(
				'valor'=>$novoValorQuem
			);

			$this->db->where('cad_id',$this->session->socio_id_home);
			$upd2 = $this->db->update('saldo',$dado2);		

			return $upd2;
		}else{
			return 0;
		}
	}

	public function getHistorico()
	{
		$this->db->select('*,c.nome as nomeQuem,cc.nome as nomePara, ht.time_upd as times_ok');
		$this->db->where('ht.id_quem',$this->session->socio_id_home);
		$this->db->or_where('ht.id_para',$this->session->socio_id_home);
		$this->db->join('cadastro c','c._id = ht.id_quem');
		$this->db->join('cadastro cc','cc._id = ht.id_para');
		$resultados = $this->db->get('historico_transacao ht')->result();

		return $resultados;
	}

}