<?php require_once('includes/header.php') ?>

	<!-- corpo da pagina inicio -->
	<div id="homePlanos" class="container">
		<div class="container">

			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-body text-right">
							Olá <b>#<?php echo $dados->_id; ?></b> - <b><?php echo $dados->nome; ?></b> <small><i>(<?php echo $dados->login; ?>)</i></small> - <a href="<?php echo base_url('panel/index.php/Login/logout'); ?>">Logout</a>
						</div>
					</div>
				</div>
			</div>

			<div class="div-space"></div>

			<div class="row">
				<div class="col-sm-4">
					<div class="card">
						<div class="card-header">
							Saldo disponível
						</div>
						<div class="card-body">
							<?php if(empty($saldo->valor)){ ?>
								<form action="<?php echo base_url('panel/index.php/Dashboard/inserirSaldo'); ?>" method="POST">
									<div class="row">
										<div class="col-sm-12">
											<label for="saldo">Seu saldo está vazio, insira um valor incial pra cadastrar.</label>
											<input type="text" name="saldo" id="saldo" class="form-control money text-right" required>
										</div>
									</div>
									<div class="div-space"></div>
									<div class="row">
										<div class="col-sm-12">
											<button class="btn btn-warning btn-block">Salvar saldo</button>
										</div>
									</div>
									
								</form>
							<?php }else{ ?>
								<h1>R$ <?php echo number_format($saldo->valor,2,',','.'); ?></h1>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="card">
						<div class="card-header">
							Realizar transferência
						</div>
						<div class="card-body">
							<?php if(isset($this->session->sucesso_transf)){ ?>
								<div class="row">
									<div class="col-sm-12">
										<div class="alert alert-<?php if($this->session->sucesso_transf == 1){ echo 'success'; }else{ echo 'warning'; } ?>" role="alert">
										  <?php if($this->session->sucesso_transf == 1){ echo 'Transferência realizada com sucesso!'; }elseif($this->session->sucesso_transf == 2){ echo 'Erro ao transferir, contacte o administrador.'; }elseif($this->session->sucesso_transf == 4){ echo 'Saldo insuficiente, tente novamente.'; }else{ echo 'Você não pode realizar uma transferência para você mesmo! :D'; } ?>
										</div>
									</div>
								</div>
							<?php } ?>
							<form action="<?php echo base_url('panel/index.php/Dashboard/transferirValor'); ?>" method="POST">
								
								<div class="row">
									<div class="col-sm-12">
										<label for="">Beneficiário</label>
										<input type="text" placeholder="Insira o ID do beneficiário" name="beneficiario" id="beneficiario" class="form-control" required>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<label for="valor">Valor</label>
										<input type="text" name="valor" id="valor" class="form-control money text-right" required>
									</div>
								</div>
								<div class="div-space"></div>
								<div class="row">
									<div class="col-sm-12">
										<button class="btn btn-warning btn-block">Transferir</button>
									</div>
								</div>

							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="card">
						<div class="card-header">
							Meus dados
						</div>
						<div class="card-body">
							<?php if(isset($this->session->sucesso_dados)){ ?>
								<div class="row">
									<div class="col-sm-12">
										<div class="alert alert-<?php if($this->session->sucesso_dados == 1){ echo 'success'; }else{ echo 'warning'; } ?>" role="alert">
										  <?php if($this->session->sucesso_dados == 1){ echo 'Dados atualizados com sucesso!'; }else{ echo 'Erro ao atualizar, contacte o administrador.'; } ?>
										</div>
									</div>
								</div>
							<?php } ?>
							<form action="<?php echo base_url('panel/index.php/Dashboard/MeusDadosAtualizar'); ?>" method="POST">
								<div class="row">
									<div class="col-sm-12">
										<label for="nome">Nome</label>
										<input type="text" id="nome" name="nome" value="<?php echo $dados->nome; ?>" class="form-control" required>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<label for="email">E-mail</label>
										<input type="email" id="email" name="email"  value="<?php echo $dados->login; ?>" class="form-control" required>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<label for="senha">Senha</label>
										<input type="password" id="senha" name="senha" class="form-control">
									</div>
								</div>
								<div class="div-space"></div>
								<div class="row">
									<div class="col-sm-12">
										<button class="btn btn-success btn-block" id="submit">Atualizar</button>
									</div>
								</div>

							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="div-space"></div>
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						Histórico de transações
					</div>
					<div class="card-body">
						<table class="table">
							<thead>
								<th>Cod Transação</th>
								<th>Ação</th>
								<th>Beneficiário</th>
								<th>Valor</th>
								<th>Data/Hora</th>
							</thead>
							<tbody>
								<?php
									foreach($historico as $trans){

										switch ($trans->id_quem) {
											case $this->session->socio_id_home:
												$acao = 'Transferido';
												$bene = $trans->nomePara;
												$color = 'orange';
												break;
											
											default:
												$acao = 'Recebido';
												$bene = $trans->nomeQuem;
												$color = 'green';
												break;
										}
								?>
									<tr style="color: <?php echo $color; ?>">
										<td><?php echo $trans->id_transacao; ?></td>
										<td><?php echo $acao; ?></td>
										<td><?php echo $bene; ?></td>
										<td>R$ <?php echo number_format($trans->valor,2,',','.'); ?></td>
										<td><?php echo date('d/m/Y H:i:s',strtotime($trans->times_ok)); ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>

	</div>
	<!-- corpo da pagina fim -->

<?php require_once('includes/footer.php') ?>