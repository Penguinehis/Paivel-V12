<?php


	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

            $SQLmp = "select * from mercadopago";
            $SQLmp = $conn->prepare($SQLmp);
            $SQLmp->execute();
            $mp=$SQLmp->fetch();


if(isset($_GET['delinfo'])){

         $SQLinfo = "select * from informativo";
         $SQLinfo = $conn->prepare($SQLinfo);
         $SQLinfo->execute();

         if($SQLinfo->rowCount()>0){

         $info=$SQLinfo->fetch();


         if(unlink("../admin/pages/noticias/".$info['imagem']."")){

         $SQLinfo2 = "delete from informativo";
         $SQLinfo2 = $conn->prepare($SQLinfo2);
         $SQLinfo2->execute();

         echo '<script type="text/javascript">';
		 echo 	'alert("Informativo apagado!");';
		 echo	'window.location="home.php?page=apis/gerenciar";';
		 echo '</script>';


         }else{

         echo '<script type="text/javascript">';
		 echo 	'alert("houve algum erro durante o apagamento!");';
		 echo	'window.location="home.php?page=apis/gerenciar";';
		 echo '</script>';


         }





         }else{

         echo '<script type="text/javascript">';
		 echo 	'alert("Não foi encontrado nenhum informativo!");';
		 echo	'window.location="home.php?page=apis/gerenciar";';
		 echo '</script>';

         }



}

// desativa a noticia ativada
if(isset($_GET['delnoti'])){
         $id=$_GET['delnoti'];
         $SQLnoticia = "select * from noticias where id='".$id."'";
         $SQLnoticia = $conn->prepare($SQLnoticia);
         $SQLnoticia->execute();

         if($SQLnoticia->rowCount()>0){

         $not=$SQLnoticia->fetch();

         if($not['status']<>'ativo'){
         echo '<script type="text/javascript">';
		 echo 	'alert("Noticia já está desativada!");';
		 echo	'window.location="home.php?page=apis/gerenciar";';
		 echo '</script>';
         exit;
         }


         $SQLinfo2 = "update noticias set status='desativado' where id='".$id."'";
         $SQLinfo2 = $conn->prepare($SQLinfo2);
         $SQLinfo2->execute();

         echo '<script type="text/javascript">';
		 echo 	'alert("Noticia Desativada!");';
		 echo	'window.location="home.php?page=apis/gerenciar";';
		 echo '</script>';


         }else{

         echo '<script type="text/javascript">';
		 echo 	'alert("Nenhuma noticia encontrada!");';
		 echo	'window.location="home.php?page=apis/gerenciar";';
		 echo '</script>';


         }





   }


?>

<!-- Main content -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor"><a href="home.php">CRACKED<b>PENGUIN</a></b></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                            <li class="breadcrumb-item active">API</li>
                        </ol>
                    </div>
                </div>
            <div class="row">
			      <div class="col-md-6">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">API Mercado Pago</h4></div>
                            <div class="card-body">                                
						        <form role="form" action="pages/apis/atualizamp.php" method="post" onsubmit="return confirm('Tem certeza que deseja atualizar a autenticação (pode parar de funcionar)?');">                                
                                    <div clnass="form-group">
                                        <label>ID De Cliente</label>
                                        <input required="required" value="<?php echo $mp['CLIENT_ID'];?>" class="form-control" id="clientid" name="clientid" placeholder="Digite o Seu Client_ID!">
										<small><p class=help-block">Obtenha os dados: <a href="https://www.mercadopago.com.br/developers/pt/api-docs/basics/authentication/" target="_Blank">Clique Aqui</a> !</p></small><br>
									</div>
									<div class="form-group">
                                        <label>Token Secreto</label>
										<input required="required" value="<?php echo $mp['CLIENT_SECRET'];?>" class="form-control" id="clientsecret" name="clientsecret" placeholder="Digite o Seu CLIENT_SECRET">
									</div>
									<hr>
									<small><p>Funcional em: (Faturas, SSHPAGA, SSHREVENDA)</p></small><br>
									<div class="form-group m-b-0">
										<button type="submit" class="btn btn-success">Alterar</button>
									</div>                         
								</form>
                            </div>                  
                        </div>
				  </div>
                    <div class="col-md-6">
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Gerenciar Email do Sistema</h4></div>
                            <div class="card-body">                           
                                <form class="form-material m-t-40">
                                    <div class="form-group">
									<div class="box-footer" align="center">
									<a href="home.php?page=email/enviaremail" class="btn btn-danger">Configurar o PHP Mailer</a>
									<hr>
									<small><p>Funcional em: (Recuperar Senha, Enviar Email, Contato)</p></small>
									</div>
								</form>
                            </div>
                        </div>
					</div>
				</div>
			</div>
<?php
$procnoticias= "select * FROM noticias where status='ativo'";
$procnoticias = $conn->prepare($procnoticias);
$procnoticias->execute();
?>
	            <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-warning">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Noticiar na Tela Inicial</h4></div>
                            <div class="card-body">                                
								<form role="form" action="pages/apis/addnoti.php" method="post" onsubmit="return confirm('Tem certeza que deseja fazer isso');" enctype="multipart/form-data" >
                                <form class="form-material m-t-40">
                                    <div clnass="form-group">
                                        <label>Titulo</label>
                                        <input required="required" class="form-control" name="titu" placeholder="Titulo da noticia">
									</div><br>
									<div class="form-group">
                                        <label>Subtitulo</label>
                                        <input required="required" class="form-control" name="subtitu" placeholder="Exemplo: Varias novas atualizações são aplicadas!">
									</div>
									<div class="form-group">
                                        <label>Area da Noticia</label>
                                        <textarea class="form-control" rows="10" name="msg" placeholder="Digite ... Use <br> para quebra de linhas"></textarea>
									</div>
									<hr>
									<div class="form-group m-b-0">
									<small><p>Funcional em: (Home Clientes)</p></small><br>
									<button type="submit" name="adicionanoticia" class="btn btn-success">Adicionar</button></form><?php if($procnoticias->rowCount()>0){ $noticia=$procnoticias->fetch(); ?>
									<a href="home.php?page=apis/gerenciar&delnoti=<?php echo $noticia['id'];?>"  name="remove" class="btn btn-danger">Desativar</a>
									<?php } ?>
									<br><br />
									</div>
									<?php if($procnoticias->rowCount()>0){ ?>
						<div class="alert alert-danger">
                            <center><h6><i class="fa fa-info-circle" ></i> Existe uma Noticia Ativa</h6></center>
                        </div>
					<?php } ?>
                                </form>
								</form>
                            </div>
                        </div>
					</div>
				</div>
				
				