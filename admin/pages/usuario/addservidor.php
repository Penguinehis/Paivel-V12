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
            <h3 class="text-themecolor"><a href="home.php">CRACKED<b>PENGUIN<a></b></h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                    <li class="breadcrumb-item active">Add Servidor</li>
                </ol>
            </div>
        </div>
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <center><i class="fas fa-info-circle"></i>  Logo Abaixo vc pode adicionar um servidor pra um cliente com validade e limite!</center>
        </div>
     <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-server"></i> Adicionar Servidor ao Cliente</h4>
                </div>
                <div class="card-body">              
                <form action="pages/usuario/addservidor_exe.php" method="POST" role="form">
                        <div class="form-group">
                            <label>Selecione um Servidor</label>
                            <select class="form-control custom-select" style="width: 100%;"  name="servidor" id="servidor">
                                <?php


                                $SQLAcesso= "select * from servidor where tipo='premium'";
                                $SQLAcesso = $conn->prepare($SQLAcesso);
                                $SQLAcesso->execute();


                                if (($SQLAcesso->rowCount()) > 0) {
    // output data of each row
                                    while($row_srv = $SQLAcesso->fetch()) {



                                      ?>

                                      <option value="<?php echo $row_srv['id_servidor'];?>" > <?php echo $row_srv['nome'];?> - <?php echo $row_srv['ip_servidor'];?></option>

                                  <?php }
                              }else{ ?>
                                <option>Nenhum Servidor</option>
                                <?php
                            }

                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Revendedor</label>
                        <select class="form-control custom-select" style="width: 100%;"  name="revendedor" id="revendedor">
                          <?php



                          $SQL = "SELECT * FROM usuario where tipo='revenda' and subrevenda='nao' and id_mestre=0";
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
                        <option>Nenhum Revendedor</option>
                        <?php
                    }

                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Validade em Dias</label>
                <input type="number" name="dias" id="dias" class="form-control" placeholder="30" required>
                <small>Tempo de acesso ao painel</small> 
            </div>
            <div class="form-group">
                <label>Limite</label>
                <input type="number" name="limite" id="limite" placeholder="30" class="form-control" required>
                <small>Limite de contas que ele pode criar</small>
            </div>
            <div class="form-group m-b-0">
              <div class="form-group m-b-0">
                  <button type="submit" class="btn btn-success">Salvar Registro</button>
                  <button type="reset" class="btn btn-inverse">Limpar</button> 
              </div>
          </form>
      </div>
  </div>
</div>
</div>
</div>
</div>