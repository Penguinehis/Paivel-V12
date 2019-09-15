<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

$buscasmtp = "SELECT * FROM smtp_usuarios WHERE usuario_id='".$_SESSION['usuarioID']."'";
$buscasmtp = $conn->prepare($buscasmtp);
$buscasmtp->execute();
$smtp = $buscasmtp->fetch();

$conta=$buscasmtp->rowCount();

?>
		<div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Mundo<b>SSH</b></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                            <li class="breadcrumb-item active">Email</li>
                        </ol>
                    </div>
                </div>
				<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Digite abaixo os novos dados do seu servidor de email</h4>
                                <h6 class="card-subtitle"><i class="fa fa-pencil"></i> Alterar Informações</h6>
								<form action="pages/email/configurasmtp.php" method="POST" role="form"
                                <form class="form-material m-t-40">
                                    <div class="form-group">
                                        <label>Nome de Sua Empresa</label>
                                        <input required="required" type="text" value="<?php echo $smtp['empresa'];?>" class="form-control" id="nomeempresa" name="nomeempresa" placeholder="Ex: MundoSSH"> 
									</div>
									<div class="form-group">
                                        <label>Servidor</label>
                                        <input required="required" type="text" value="<?php echo $smtp['servidor'];?>" class="form-control" id="servidor" name="servidor" placeholder="Ex: smtp.gmail.com"> 
									</div>
									<div class="form-group">
                                        <label>Porta</label>
                                        <input required="required" type="text" value="<?php echo $smtp['porta'];?>" class="form-control" id="porta" name="porta" placeholder="Ex: 465 SSL ou 587 TLS">
									</div>
									<div class="form-group">
                                        <label>SSL</label>
                                        <input required="required" type="text" value="<?php echo $smtp['ssl_secure'];?>" class="form-control" id="ssl" name="ssl" placeholder="Ex: SSL ou TLS">
									</div>
									<div class="form-group">
                                        <label>Email</label>
                                        <input required="required" type="text" value="<?php echo $smtp['email'];?>" class="form-control" id="email" name="email" placeholder="Email do servidor">
									</div>
									<div class="form-group">
                                        <label>Senha</label>
                                        <input  class="form-control" type="password" value ="<?php echo $smtp['senha'];?>" id="senha" name="senha" placeholder="Senha do Email"> 
									</div>
									<div class="form-group m-b-0">
										<div class="offset-sm-3 col-sm-9">
										<button type="submit" class="btn btn-info waves-effect waves-light m-t-10">Salvar Registro</button>
										<button type="reset" class="btn btn-info waves-effect waves-light m-t-10">Limpar</button>
									</div>
                                </form>
								</form>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>