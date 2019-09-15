<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}


$buscausuario = "SELECT * FROM usuario WHERE id_usuario='".$_SESSION['usuarioID']."'";
$buscausuario = $conn->prepare($buscausuario);
$buscausuario->execute();
$usuario = $buscausuario->fetch();

if($usuario['tipo']=='vpn'){
echo '<script type="text/javascript">';
			echo 	'alert("Você não tem acesso a esta área!");';
			echo	'window.location="../home.php";';
			echo '</script>';
}


?>
<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
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
                            <li class="breadcrumb-item active">Meus Servidores</li>
                        </ol>
                    </div>
                </div>
    <section class="content">
 <div class="row">
    <div class="col-lg-12">
      <div class="card card-outline-warning">
        <div class="card-header">
          <h4 class="m-b-0 text-white"><i class="fa fa-server"></i> Meus Servidores</h4>
        </div>
        <div class="col-12"><br>
          <div class="form-responsive">
            <input type="text" id="myInput" placeholder="Pesquisar..." class="form-control">
          </div>
        </div><br>                                   
        <div class="table-responsive">
          <div class="col-12">                                  
          </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                 <th>ID</th>
                  <th>Nome</th>
                  <th>IP</th>
                  <th>Limite</th>
                  <th>OpenVPN</th>
                  <th>Validade</th>
                  <th>Acessos SSH</th>
                  <th>Contas SSH</th>
                </tr>
                </thead>
                <tbody id="myTable">

                 <?php
                 $SQLSubSSH = "SELECT * FROM acesso_servidor where id_usuario='".$usuario['id_usuario']."' ORDER BY id_usuario desc";
                 $SQLSubSSH = $conn->prepare($SQLSubSSH);
                 $SQLSubSSH->execute();
                 if(($SQLSubSSH->rowCount()) > 0){
                 while($row = $SQLSubSSH->fetch()){


                 $buscaserver = "SELECT * FROM servidor where id_servidor='".$row['id_servidor']."'";
                 $buscaserver = $conn->prepare($buscaserver);
                 $buscaserver->execute();
                 $servidor = $buscaserver->fetch();


                  $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '".$servidor['id_servidor']."'  and id_usuario='".$row['id_usuario']."' ";
                  $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                  $SQLAcessoSSH->execute();
	              $SQLAcessoSSH = $SQLAcessoSSH->fetch();
                  $acessos = $SQLAcessoSSH['quantidade'];
                  if($acessos==0){$acessos=0;}

                  $SQLUsuarioSSH = "SELECT * from usuario_ssh WHERE id_servidor = '".$servidor['id_servidor']."' and id_usuario='".$row['id_usuario']."'";
                  $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
                  $SQLUsuarioSSH->execute();
		          $contas = $SQLUsuarioSSH->rowCount();
                  if($contas==0){$contas=0;}

                 //Calcula os dias restante
	             $data_atual = date("Y-m-d");
		         $data_validade = $row['validade'];
		         if($data_validade > $data_atual){
		         $data1 = new DateTime( $data_validade );
                 $data2 = new DateTime( $data_atual );
                 $dias_acesso = 0;
                 $diferenca = $data1->diff( $data2 );
                 $ano = $diferenca->y * 364 ;
	             $mes = $diferenca->m * 30;
		         $dia = $diferenca->d;
                 $dias_acesso = $ano + $mes + $dia;

		         }else{
			     $dias_acesso = 0;
		         }

		               $SQLopen = "select * from ovpn WHERE servidor_id = '".$row['id_servidor']."' ";
                       $SQLopen = $conn->prepare($SQLopen);
                       $SQLopen->execute();
                       if($SQLopen->rowCount()>0){
                       $openvpn=$SQLopen->fetch();
                       $texto="<a href='../admin/pages/servidor/baixar_ovpn.php?id=".$openvpn['id']."' class=\"label label-info\">Baixar</a>";
                       }else{
                       $texto="<span class=\"label label-danger\">Indisponivel</span>";
                       }


                 ?>
                <tr>
                  <td>#<?php echo $row['id_acesso_servidor'];?></td>
                  <td><?php echo ucfirst($servidor['nome']);?></td>
                  <td><?php echo ucfirst($servidor['ip_servidor']);?></td>
                  <td><?php echo $row['qtd'];?></td>
                   <td><?php echo $texto;?></td>
                  <td><span class="pull-left-container" style="margin-right: 5px;">
                            <span class="label label-primary pull-left">
					            <?php echo $dias_acesso."  dias   "; ?>
				            </span>
                       </span></td>
                  <td><?php echo $acessos;?></td>
                  <td><?php echo $contas;?></td>



                  <?php
                }

                  }


                  ?>
                  </tr>


                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          </div>
          <!-- /.box -->
        </div>
      </div>


    </section>

</div>

