<?php require_once('includes/header.php') ?>


	<div id="homePlanos" class="container">
		<div class="container">
			<?php if(isset($this->session->sucesso)){ ?>
				<div class="row">
					<div class="col-sm-12">
						<div class="alert alert-<?php if($this->session->sucesso == 1){ echo 'success'; }else{ echo 'warning'; } ?>" role="alert">
						  <?php if($this->session->sucesso == 1){ echo 'Cadastro efetuado com sucesso, <a href="'.base_url('panel/index.php/Login').'">clique aqui</a> para efetuar o login'; }else{ echo 'E-mail já cadastrado.'; } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="row">
				<div class="col-sm-12">
					<h3 class="titulos">Cadastre-se para começar.</h3>
				</div>
			</div>
			<div class="div-space"></div>
			<form id="form" action="<?php echo base_url('panel/index.php/Cadastro/add'); ?>" method="post">
				<div class="row">
					<div class="col-sm-6">
						<label for="nome">Nome</label>
						<input type="text" id="noem" name="nome" class="form-control" required>	
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<label for="email">E-mail</label>
						<input type="email" id="email" name="email" class="form-control" required>	
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label for="senha">Senha</label>
						<input type="password" id="senha" name="senha" class="form-control" required>	
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<label for="resenha">Re-senha</label>
						<input type="password" id="resenha" name="resenha" class="form-control" required>	
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<button class="btn btn-primary pull-right" id="submit">Cadastrar</button>
					</div>
				</div>
			</form>
			<div class="div-space"></div>
			<div class="row">
				<div class="col-sm-12 text-center">
					<p>Se já tem cadastro, <a href="<?php echo base_url('panel/index.php/Login'); ?>">Clique aqui</a> para se logar no sistema.</p>
				</div>
			</div>
		</div>
	</div>


		</div>
	</div>
	<!-- corpo da pagina fim -->

<?php require_once('includes/footer.php') ?>