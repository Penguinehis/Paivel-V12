<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

$buscasmtp = "SELECT * FROM smtp WHERE usuario_id='".$_SESSION['usuarioID']."'";
$buscasmtp = $conn->prepare($buscasmtp);
$buscasmtp->execute();
$smtp = $buscasmtp->fetch();

$conta=$buscasmtp->rowCount();

?>
<script language="JavaScript">
<!--
function desabilitar(){
with(document.form){
qtd_ssh.disabled=true;
}
}
function habilitar(){
with(document.form){

qtd_ssh.disabled=false;

}
}
// -->
</script>
		<div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor"><a href="home.php">CRACKED<b>PENGUIN</a></b></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                            <li class="breadcrumb-item active">Email</li>
                        </ol>
                    </div>
                </div>
				<div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline-warning">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-envelope-o"></i> Enviar Email Personalizado</h4></div>
                            <div class="card-body">
								<form action="pages/email/enviandoemail.php" method="POST" role="form">
                                <form class="form-material m-t-40">
                                    <div class="form-group">
                                        <label>Tipo de Contato</label>
                                        <select class="form-control" name="tipomodelo">
                                            <option value="1">Suporte Tecnico</option>
											<option value="2">Entrega de Contas</option>
                                        </select>
									<p class="help-block"><small>Selecione o Tipo de contato</small></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Tipo de Conta</label>
                                        <select class="form-control" name="tipoconta">
                                            <option value="1" selected=selected>Conta SSH</option>
											<option value="2">Acesso Painel</option>
                                        </select>
									<p class="help-block"><small>Somente para Entrega de Contas</small></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Email do Destinatario</label>
                                        <input required="required" type="text" class="form-control" name="email" placeholder="Ex:admin@admin.com"> 
									</div>
									<div class="form-group">
                                        <label>Login</label>
                                        <input type="text" class="form-control" id="login" name="login" placeholder="Digite o Login">
										<p class="help-block"><small>Opcional no Suporte Técnico</small></p>
									</div>
									<div class="form-group">
                                        <label>Senha</label>
                                        <input class="form-control" id="senha" name="senha" placeholder="Digite a Senha">
										<p class="help-block"><small>Opcional no Suporte Técnico</small></p>
									</div>
									<div class="form-group">
                                        <label>Assunto</label>
                                        <input type="text" class="form-control" id="assunto" name="assunto" placeholder="Digite um Assunto EX: Compra de SSH ">
										<p class="help-block"><small>Opcional na Entrega de Contas</small></p>
									</div>
									<div class="form-group">
                                        <label>Validade</label>
                                        <input type="text" class="form-control" id="validade" name="validade" placeholder="30">
										<p class="help-block"><small>Opcional no Suporte Técnico</small></p>
									</div>
									<div class="form-group">
                                        <label>Mensagem</label>
                                        <textarea class="form-control" name="msg" id="msg" rows="3" placeholder="Digite a Mensagem ..."></textarea> 
									</div>
									<div class="form-group m-b-0">
										<div class="offset-sm-3 col-sm-9">
										<?php if($conta>0){ ?>
										<button href="home.php?page=email/1etapasmtp" class="btn btn-warning">Reconfigurar SMTP</button>
										<?php } ?>
										</div>
										<div class="form-actions">
										<?php if($conta>0){ ?><button type="submit" class="btn btn-success">Salvar Registro</button> <?php }else{ ?><a class="btn btn-warning" href="home.php?page=email/1etapasmtp">1° Configurar SMTP</a><?php } ?>
										<button type="reset" class="btn btn-inverse">Limpar</button> 
										</div>
									</div>
                                </form>
								</form>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>