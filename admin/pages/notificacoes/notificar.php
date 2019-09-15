<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}


?>
<!-- Main content -->
           <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">CRACKED<b>PENGUIN</b></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                            <li class="breadcrumb-item active">Notificar</li>
                        </ol>
                    </div>
                </div>
				<div class="row">  
                     <div class="col-md-6">
                          <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Revendedor</h4></div>
                            <div class="card-body">
								<form role="form" name="form" id="form" action="pages/notificacoes/notificar_revendedor.php" method="post">                                
                                    <div class="form-group">
                                        <label>Selecione o Revendedor</label>
                                        <select class="form-control" name="revendedor">
                                            <option selected=selected>Selecione</option>
											<?php

                     $SQLUsuario = "SELECT * FROM usuario where tipo='revenda' and subrevenda='nao'";
     $SQLUsuario = $conn->prepare($SQLUsuario);
     $SQLUsuario->execute();

if (($SQLUsuario->rowCount()) > 0) {
    // output data of each row
    while($row = $SQLUsuario->fetch()) {
		if($row['id_usuario'] != $usuario_sistema['id_usuario']){

     $SQLserv = "SELECT * FROM acesso_servidor where id_usuario='".$row['id_usuario']."'";
     $SQLserv = $conn->prepare($SQLserv);
     $SQLserv->execute();
     $sv=$SQLserv->rowCount();

		?>

	<option value="<?php echo $row['id_usuario'];?>" ><?php echo ucfirst($row['nome']);?> - Servidores: <?php echo $sv;?> </option>

   <?php }
	}
}
                     ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Selecione o Tipo</label>
                                        <select class="form-control" name="tipo">
                                            <option selected=selected>Selecione</option>
											<option value="1">Fatura</option>
											<option value="2">Outros/Servidores</option>
                                        </select>
                                    </div>
									<div class="form-group">
                                        <label>Mensagem</label>
                                        <textarea class="form-control"  name="msg" rows="5" placeholder="Digite ..."></textarea>
									</div>
										<button type="submit" class="btn btn-success">Notificar</button> 
									</div>                                
								</form>                          
                        </div>
					</div>
                    <div class="col-md-6">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Cliente VPN</h4></div>
                            <div class="card-body">
								<form role="form" name="form" id="form" action="pages/notificacoes/notificar_clientevpn.php" method="post">                                
                                    <div class="form-group">
                                        <label>Selecione o Revendedor</label>
                                        <select class="form-control" name="clientevpn">
                                            <option selected=selected>Selecione</option>
                     <?php

     $SQLUsuario = "SELECT * FROM usuario where id_mestre='0' and tipo='vpn'";
     $SQLUsuario = $conn->prepare($SQLUsuario);
     $SQLUsuario->execute();

if (($SQLUsuario->rowCount()) > 0) {
    // output data of each row
    while($row = $SQLUsuario->fetch()) {
		if($row['id_usuario'] != $usuario_sistema['id_usuario']){

     $SQLserv = "SELECT * FROM  usuario_ssh where id_usuario='".$row['id_usuario']."'";
     $SQLserv = $conn->prepare($SQLserv);
     $SQLserv->execute();
     $sv=$SQLserv->rowCount();

		?>

	<option value="<?php echo $row['id_usuario'];?>" ><?php echo ucfirst($row['nome']);?> - Contas SSH: <?php echo $sv;?> </option>

   <?php }
	}
}
                     ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Selecione o Tipo</label>
                                        <select class="form-control" name="tipo">
                                            <option selected=selected>Selecione</option>
											<option value="1">Fatura</option>
											<option value="2">Outros/Servidores</option>
                                        </select>
                                    </div>
									<div class="form-group">
                                        <label>Mensagem</label>
                                        <textarea class="form-control"  name="msg" rows="5" placeholder="Digite ..."></textarea>
									</div>
										<button type="submit" class="btn btn-success">Notificar</button> 
									</div>
                                </form>
                            </div>
                        </div>
					</div>
				<div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline-warning">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Notificar Geral</h4></div>
                            <div class="card-body">
								<form role="form" name="form" id="form" action="pages/notificacoes/notificar_todos.php" method="post">                                
                                    <div class="form-group">
                                        <label>Selecione o Revendedor</label>
                                        <select class="form-control" name="revendedor">
                                            <option selected=selected>Selecione</option>
											<option value="1">Todos</option>
											<option value="2">Todos Revendedores</option>
											<option value="3">Todos Clientes VPN</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Selecione o Tipo</label>
                                        <select class="form-control" name="tipo">
                                            <option selected=selected>Selecione</option>
											<option value="1">Fatura</option>
											<option value="2">Outros/Servidores</option>
                                        </select>
                                    </div>
									<div class="form-group">
                                        <label>Mensagem</label>
                                        <textarea class="form-control"  name="msg" rows="5" placeholder="Digite ..."></textarea>
									</div>
										<button type="submit" class="btn btn-success">Notificar</button> 
									</div>
                                </form>
                            </div>
                        </div>
					</div>
				</div>
			</div>
