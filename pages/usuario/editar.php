<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}



   if(isset($_GET["id_usuario"])){
	   $res_usuario = $mysqli->query("select * from usuario WHERE id_usuario = '".$_GET['id_usuario']."' and id_mestre= '".$_SESSION['id']."' ") or die($mysqli->error);
       $usuario = $res_usuario->fetch_assoc();
	   if($usuario['id_mestre']!=0 ){
		$res_usuario_mestre = $mysqli->query("select * from usuario WHERE id_usuario = '".$usuario['id_mestre']."' ") or die($mysqli->error);
        $usuario_mestre = $res_usuario_mestre->fetch_assoc();
	   }
	   
   }else{
	   
	    echo '<script type="text/javascript">';
		echo 	'alert("Preencha todos os campos!");';
		echo	'window.location="home.php?page=usuario/listar";';
		echo '</script>'; 
   }
	

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
                            <li class="breadcrumb-item active">Editar</li>
                        </ol>
                    </div>
                </div>
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Usuário do sistema</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="pages/usuario/editar_exe.php" method="post">
              <div class="box-body">
			  
			 
			  
               <div class="form-group">
                  <label for="exampleInputEmail1">Nome</label>
                  <input required="required" type="text" class="form-control" id="nome" name="nome" value="<?php echo $usuario['nome'];?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">E-mail</label>
                  <input required="required" type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email'];?>">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Login</label>
				  <p><?php echo $usuario['login'];?></p>
                  <input  type="hidden" class="form-control" id="login" name="login"  value="<?php echo $usuario['login'];?>" >
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Senha</label>
                  <input required="required" type="password" class="form-control" id="senha" name="senha"  value="<?php echo $usuario['senha'];?>">
                </div>
				
			
			
			  
			
                
				
			  <tr>
       
        <td >

				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Alterar Usuário</button>
				  <a href="home.php?page=usuario/excluir&id_usuario=<?php echo $usuario['id_usuario'];?>" class="btn btn-danger">Deletar</a>
              </div>
            </form>
          </div>
          <!-- /.box -->

         
         

          

        </div>
        
      </div>
      <!-- /.row -->
    </section>
	</div>