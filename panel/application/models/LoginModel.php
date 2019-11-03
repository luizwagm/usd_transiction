<?php

class LoginModel extends CI_Model {

	public function validar($login,$senha){

		$this->db->select('*');
		$this->db->where('login', $login);
		$query = $this->db->get('cadastro');

		if($query->num_rows() > 0){

			$res = $query->result();

			$hash = $res[0]->senha;

			if(password_verify($senha, $hash)){
				return $res;
			}else{
				return 0;
	    	}
		}else{
			return 0;
		}

	}

}