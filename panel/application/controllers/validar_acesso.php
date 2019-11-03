<?php

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

if(!isset($this->session->socio_id_home)){

	return redirect(base_url('panel/index.php/Login'), 'refresh');

	exit;
}

?>