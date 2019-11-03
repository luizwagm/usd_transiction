<?php require_once('includes/header.php') ?>

	<div id="homePlanos" class="container">
		<form id="form" action="<?php echo base_url('panel/index.php/Login/logar'); ?>" method="post">
			<div class="container">
				<?php if(isset($this->session->sucesso)){ ?>
					<div class="row">
						<div class="col-sm-12">
							<div class="alert alert-<?php if($this->session->sucesso == 1){ echo 'success'; }else{ echo 'warning'; } ?>" role="alert">
							  <?php if($this->session->sucesso == 1){ echo ''; }else{ echo 'E-mail ou senha incorretos!'; } ?>
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="div-space"></div>
					<div class="row">
						<div class="col-sm-4"></div>
							<div class="col-sm-4">
								<div class="card">
								<div class="card-body">
								<div class="row">
									<div class="col-sm-12">
						              <label for="login">E-mail</label>
						              <input type="text" class="form-control" id="login" name="login">
						            </div>
						        </div>
						        <div class="row">
						            <div class="col-sm-12">
						              <label for="senha" class="label-login">Senha</label>
						              <input type="password" class="form-control" id="senha" name="senha">
						            </div>
						        </div>
						        <div class="div-space"></div>
								<div class="row">
									<div class="col-md-12">
			                            <button id="submit" class="btn btn-success btn-block">Login</button>
									</div>
								</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="div-space"></div>
					<div class="row">
						<div class="col-sm-12 text-center">
							<p>Se você não tem cadastro, <a href="<?php echo base_url('panel/index.php/Cadastro'); ?>">Clique aqui</a> para se cadastrar.</p>
						</div>
					</div>

			</div>
		</form>
	</div>

<?php require_once('includes/footer.php') ?>