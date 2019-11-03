<?php

class CadastroModel extends CI_Model {

	public function add($arr)
	{

		$this->db->select('*');
		$this->db->where('login', $arr['login']);
		$query = $this->db->get('cadastro');

		if($query->num_rows() == 0){

			$this->db->insert('cadastro',$arr);
			
			$id = $this->db->insert_id();

			$dado = array(
				'cad_id'=>$id
			);

			$this->db->insert('saldo',$dado);

			return $id;

		}else{
			return 0;
		}
	}

	

}