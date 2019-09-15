<?php

if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="plugins/select2/select2.full.min.js"></script>
<script>
 $(document).ready(function ($) {
				//Initialize Select2 Elements
				$(".select2").select2();
			});
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
            <li class="breadcrumb-item active">Add Servidor</li>
          </ol>
        </div>
      </div>
      <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <center><i class="fas fa-info-circle"></i>  Logo abaixo Você entrega parte de seu limite em um dos seus servidores ao seu Subrevendedor não é possivel entregar mais que o seu limite disponivel.</center>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="card card-outline-info">
            <div class="card-header">
              <h4 class="m-b-0 text-white"><i class="fa fa-server"></i> Adicionar Servidor ao Cliente</h4>
            </div>
            <div class="card-body">   
              <form action="pages/subrevenda/addservidor_exe.php" method="POST" role="form">
                <form class="form-material m-t-40">
                  <div class="form-group">
                    <label>Selecione um Servidor</label>
                    <select class="form-control" style="width: 100%;"  name="servidor" id="servidor">
                      <option selected="selected">selecione</option>
                      <?php

                      $SQLAcesso= "select * from acesso_servidor where id_usuario='".$usuario['id_usuario']."'  ";
                      $SQLAcesso = $conn->prepare($SQLAcesso);
                      $SQLAcesso->execute();


                      if (($SQLAcesso->rowCount()) > 0) {
    // output data of each row
                        while($row_srv = $SQLAcesso->fetch()) {
                          $contas_ssh_criadas = 0;

                          $SQLServidor = "select * from servidor WHERE id_servidor = '".$row_srv['id_servidor']."' ";
                          $SQLServidor = $conn->prepare($SQLServidor);
                          $SQLServidor->execute();
                          $servidor = $SQLServidor->fetch();


		//Carrega contas SSH criadas
                          $SQLContasSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '".$row_srv['id_servidor']."' and id_usuario='".$usuario['id_usuario']."' ";
                          $SQLContasSSH = $conn->prepare($SQLContasSSH);
                          $SQLContasSSH->execute();
                          $SQLContasSSH = $SQLContasSSH->fetch();
                          $contas_ssh_criadas += $SQLContasSSH['quantidade'];

	    //Carrega usuario sub
                          $SQLUsuarioSub = "SELECT * FROM usuario WHERE id_mestre ='".$usuario['id_usuario']."' and subrevenda='nao'";
                          $SQLUsuarioSub = $conn->prepare($SQLUsuarioSub);
                          $SQLUsuarioSub->execute();


                          if (($SQLUsuarioSub->rowCount()) > 0) {
                            while($row = $SQLUsuarioSub->fetch()) {
                              $SQLSubSSH= "select sum(acesso) AS quantidade  from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."' and id_servidor='".$row_srv['id_servidor']."' ";
                              $SQLSubSSH = $conn->prepare($SQLSubSSH);
                              $SQLSubSSH->execute();
                              $SQLSubSSH = $SQLSubSSH->fetch();
                              $contas_ssh_criadas += $SQLSubSSH['quantidade'];

                            }

                          }

                          $resta=$row_srv['qtd']-$contas_ssh_criadas;
                          //echo $resultado;

                          ?>

                          <option value="<?php echo $row_srv['id_acesso_servidor'];?>" > <?php echo $servidor['nome'];?> - <?php echo $servidor['ip_servidor'];?> - Limite: <?php echo $resta;?> </option>

                        <?php }
                      }else{ ?>
                        <option value="nada">Nenhum Servidor</option>
                        <?php
                      }

                      ?>
                    </select>

                  </div>
                  <div class="form-group">
                    <label>SubRevendedor</label>
                    <select class="form-control" style="width: 100%;"  name="subusuario" id="subusuario">
                      <option selected="selected">selecione</option>
                      <?php



                      $SQL = "SELECT * FROM usuario where id_mestre='".$usuario['id_usuario']."' and subrevenda='sim'";
                      $SQL = $conn->prepare($SQL);
                      $SQL->execute();



                      if (($SQL->rowCount()) > 0) {
    // output data of each row
                        while($row = $SQL->fetch()) {

                         $SQLServidor = "select * from acesso_servidor  WHERE id_usuario = '".$row['id_usuario']."' ";
                         $SQLServidor = $conn->prepare($SQLServidor);
                         $SQLServidor->execute();
                         $acesso_server=$SQLServidor->rowCount();

                         ?>

                         <option value="<?php echo $row['id_usuario'];?>" ><?php echo $row['login'];?> - Servidores Alocados: <?php echo $acesso_server;?> </option>

                       <?php }
                     }else{ ?>
                      <option value="nada">Nenhum Subrevendedor</option>
                      <?php
                    }

                    ?>
                  </select>	
                </div>
                <div class="form-group">
                  <label>Validade em Dias</label>
                  <input type="number" name="dias" id="dias" class="form-control" placeholder="30" required="required"> 
                </div>
                <div class="form-group">
                  <label>Limite</label>
                  <input type="number" name="limite" id="limite" class="form-control" placeholder="30" required="required"> 
                </div>
                <input  type="hidden" class="form-control" id="diretorio" name="diretorio" value="../../admin/home.php?page=ssh/adicionar">
                <input  type="hidden" class="form-control" id="owner" name="owner"  value="<?php echo $accessKEY;?>">
                <div class="form-group m-b-0">
                  <div class="offset-sm-3 col-sm-9">
                    <button type="submit" class="btn btn-success">Salvar Registro</button>
                    <button type="reset" class="btn btn-inverse">Limpar</button>
                  </div>
                </form>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>