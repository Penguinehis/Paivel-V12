<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}
$procnoticias= "select * FROM noticias where status='ativo'";
$procnoticias = $conn->prepare($procnoticias);
$procnoticias->execute();


        // Clientes
        $SQLbuscaclientes= "select * from usuario where tipo='vpn'";
        $SQLbuscaclientes = $conn->prepare($SQLbuscaclientes);
        $SQLbuscaclientes->execute();
        $totalclientes = $SQLbuscaclientes->rowCount();
        // Revendedores
        $SQLbuscarevendedores= "select * from  usuario where tipo='revenda'";
        $SQLbuscarevendedores = $conn->prepare($SQLbuscarevendedores);
        $SQLbuscarevendedores->execute();
        $totalrevendedores = $SQLbuscarevendedores->rowCount();
        // Servidores
        $SQLbuscaservidores= "select * from  servidor";
        $SQLbuscaservidores= $conn->prepare($SQLbuscaservidores);
        $SQLbuscaservidores->execute();
        $totalservidores = $SQLbuscaservidores->rowCount();
?>
		<div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor"><a href="home.php">CRACKED<b>PENGUIN</a></b></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                            <li class="breadcrumb-item active">Configurações</li>
                        </ol>
                    </div>
                </div>
              <div class="card card-outline-info">
                       <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-edit"></i> Alterar Informações</h4>
                        </div>
               <div class="card-body">
				<div class="row">
                    <div class="col-sm-12">
                        <!--<div class="card card-body">-->
						<form action="pages/admin/alterar.php" method="POST" role="form">
                            <form class="form-horizontal m-t-40">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" name="nome" id="nome" class="form-control" minlength="4"  value="<?php echo $administrador['nome'];?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Login</label>
                                    <input type="text" disabled class="form-control" minlength="4" value="<?php echo $administrador['login'];?>" required="">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" id="email" minlength="5" class="form-control" value="<?php echo $administrador['email'];?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Site do Painel</label>
                                    <input type="text" name="site" id="site" minlength="5" value="<?php echo $administrador['site'];?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Senha Antiga</label>
                                    <input type="password" name="senhaantiga" id="senhaantiga" minlength="5" placeholder="Digite a Senha Antiga..." class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Senha Nova</label>
                                    <input type="password" name="novasenha" id="novasenha" minlength="5" placeholder="Digite a Nova Senha..." class="form-control">
                                </div>
                                   <div class="form-actions">
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Alterar Dados</button>
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
	
