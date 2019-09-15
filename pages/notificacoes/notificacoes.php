<?php
if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

if(isset($_GET['ler'])){

    switch($_GET['ler']){
        case 'all':$ler='tudo';$tipo='tudo';break;
        case 'others':$ler='others';$tipo='outros';break;
        case 'fatu':$ler='fatu';$tipo='fatura';break;
        case 'accs':$ler='contas';$tipo='conta';break;
        case 'reve':$ler='revenda';$tipo='revenda';break;
        case 'subreve':$ler='subrevenda';$tipo='subrevenda';break;
        case 'usuario':$ler='usuario';$tipo='usuario';break;
        case 'chamados':$ler='chamados';$tipo='chamados';break;
        default:$ler='nada';break;
    }
    if($ler=='nada'){

    }elseif($ler=='tudo'){

// Notificações
        $SQLnoti= "select * from  notificacoes where lido='nao' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnoti = $conn->prepare($SQLnoti);
        $SQLnoti->execute();
        $totalnoti = $SQLnoti->rowCount();

        if($totalnoti>0){
            while($tudo= $SQLnoti->fetch()){

                $SQLnotiler= "update notificacoes set lido='sim' where id='".$tudo['id']."'";
                $SQLnotiler = $conn->prepare($SQLnotiler);
                $SQLnotiler->execute();

            }
        }

    }elseif($ler=='others'){

        // Notificações
        $SQLnoti= "select * from  notificacoes where lido='nao' and tipo='outros' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnoti = $conn->prepare($SQLnoti);
        $SQLnoti->execute();
        $totalnoti = $SQLnoti->rowCount();

        if($totalnoti>0){
            while($tudo= $SQLnoti->fetch()){

                $SQLnotiler= "update notificacoes set lido='sim' where id='".$tudo['id']."'";
                $SQLnotiler = $conn->prepare($SQLnotiler);
                $SQLnotiler->execute();

            }
        }

    }elseif($ler=='fatu'){

        // Notificações
        $SQLnoti= "select * from  notificacoes where lido='nao' and tipo='fatura' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnoti = $conn->prepare($SQLnoti);
        $SQLnoti->execute();
        $totalnoti = $SQLnoti->rowCount();

        if($totalnoti>0){
            while($tudo= $SQLnoti->fetch()){

                $SQLnotiler= "update notificacoes set lido='sim' where id='".$tudo['id']."'";
                $SQLnotiler = $conn->prepare($SQLnotiler);
                $SQLnotiler->execute();

            }
        }

    }elseif($ler=='contas'){

        // Notificações
        $SQLnoti= "select * from  notificacoes where lido='nao' and tipo='conta' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnoti = $conn->prepare($SQLnoti);
        $SQLnoti->execute();
        $totalnoti = $SQLnoti->rowCount();

        if($totalnoti>0){
            while($tudo= $SQLnoti->fetch()){

                $SQLnotiler= "update notificacoes set lido='sim' where id='".$tudo['id']."'";
                $SQLnotiler = $conn->prepare($SQLnotiler);
                $SQLnotiler->execute();

            }
        }

    }elseif($ler=='revenda'){

        // Notificações
        $SQLnoti= "select * from  notificacoes where lido='nao' and tipo='revenda' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnoti = $conn->prepare($SQLnoti);
        $SQLnoti->execute();
        $totalnoti = $SQLnoti->rowCount();

        if($totalnoti>0){
            while($tudo= $SQLnoti->fetch()){

                $SQLnotiler= "update notificacoes set lido='sim' where id='".$tudo['id']."'";
                $SQLnotiler = $conn->prepare($SQLnotiler);
                $SQLnotiler->execute();

            }
        }

    }elseif($ler=='subrevenda'){

        // Notificações
        $SQLnoti= "select * from  notificacoes where lido='nao' and tipo='subrevenda' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnoti = $conn->prepare($SQLnoti);
        $SQLnoti->execute();
        $totalnoti = $SQLnoti->rowCount();

        if($totalnoti>0){
            while($tudo= $SQLnoti->fetch()){

                $SQLnotiler= "update notificacoes set lido='sim' where id='".$tudo['id']."'";
                $SQLnotiler = $conn->prepare($SQLnotiler);
                $SQLnotiler->execute();

            }
        }

    }elseif($ler=='usuario'){

        // Notificações
        $SQLnoti= "select * from  notificacoes where lido='nao' and tipo='subrevenda' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnoti = $conn->prepare($SQLnoti);
        $SQLnoti->execute();
        $totalnoti = $SQLnoti->rowCount();

        if($totalnoti>0){
            while($tudo= $SQLnoti->fetch()){

                $SQLnotiler= "update notificacoes set lido='sim' where id='".$tudo['id']."'";
                $SQLnotiler = $conn->prepare($SQLnotiler);
                $SQLnotiler->execute();

            }
        }

    }elseif($ler=='chamados'){

        // Notificações
        $SQLnoti= "select * from  notificacoes where lido='nao' and tipo='chamados' and usuario_id='".$_SESSION['usuarioID']."'";
        $SQLnoti = $conn->prepare($SQLnoti);
        $SQLnoti->execute();
        $totalnoti = $SQLnoti->rowCount();

        if($totalnoti>0){
            while($tudo= $SQLnoti->fetch()){

                $SQLnotiler= "update notificacoes set lido='sim' where id='".$tudo['id']."'";
                $SQLnotiler = $conn->prepare($SQLnotiler);
                $SQLnotiler->execute();

            }
        }

    }

}else{$tipo='tudo';}

?>
<script type="text/javascript" src="../../plugins/datatables/sort-table.js"></script>
<style type="text/css">

  table { 
    width: 100%; 
    border-collapse: collapse; 
  }
  /* Zebra striping */
  tr:nth-of-type(odd) { 
    background: #f3f4f8; 
  }
  th { 
    background: white; 
    color: black; 
    font-weight: bold; 
  }
  td, th { 
    padding: 6px; 
    border: 1px solid #d7dfe2; 
    text-align: left; 
  }

</style>
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">CRACKED<b>PENGUIN</b></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                <li class="breadcrumb-item active">Notificações</li>
            </ol>
        </div>
    </div>	
    <div class="row">
        <div class="col-lg-12">
          <div class="card card-outline-warning">
            <div class="card-header">
              <h4 class="m-b-0 text-white"><i class="fas fa-bell"></i> Últimas Notificacoes</h4>
          </div><br>
          <?php if(($_GET['ler']<>'all')and(isset($_GET['ler']))){?>
            <div class="box-tools">
                <a href="home.php?page=notificacoes/notificacoes" class="btn btn-block btn-default"><span class="fa fa-search"></span> Visualizar Todos</a>
            </div>
        <?php } ?>
        <div class="table-responsive m-t-40">
            <table class="js-sort-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TIPO</th>
                        <th>DATA</th>
                        <th>INFORMACOES</th>
                        <th>DETALHES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($tipo=='tudo'){
                        $SQLUPUser= "SELECT * FROM notificacoes where usuario_id =  '".$usuario['id_usuario']."' ORDER BY id desc LIMIT 15";
                    }else{
                        $SQLUPUser= "SELECT * FROM notificacoes where usuario_id =  '".$usuario['id_usuario']."' and tipo='".$tipo."' ORDER BY id desc LIMIT 15";
                    }
                    $SQLUPUser = $conn->prepare($SQLUPUser);
                    $SQLUPUser->execute();

					// output data of each row
                    if (($SQLUPUser->rowCount()) > 0) {
                     while($noti = $SQLUPUser->fetch()){

                         switch($noti['tipo']){
                             case 'fatura':$tipo='Fatura';$class='label label-success';$info='Visualizar';break;
                             case 'conta':$tipo='Conta';$class='label label-warning';$info=$noti['info_outros'];break;
                             case 'revenda':$tipo='Revenda';$class='label label-danger';$info=$noti['info_outros'];break;
                             case 'subrevenda':$tipo='Revenda-SUB';$class='label label-primary';$info='Sobre a Revenda';break;
                             case 'usuario':$tipo='Usúario VPN';$class='label label-primary';$info='Sobre Suas Contas';break;
                             case 'outros':$tipo='Outros';$class='label label-primary';$info=$noti['info_outros'];break;
                             case 'chamados':$tipo='Chamado/Suporte';$class='label label-primary';$info=$noti['info_outros'];break;
                             default:$tipo='erro';break;
                         }

                      //Datas

                         $datacriado=$noti['data'];
                         $dataconvcriado = substr($datacriado, 0, 10);
                         $partes = explode("-", $dataconvcriado);
                         $ano = $partes[0];
                         $mes = $partes[1];
                         $dia = $partes[2];


                         ?>

                         <tr>
                          <td><?php echo $noti['id'];?></td>
                          <td><?php echo $tipo;?></td>
                          <td><?php echo $dia;?>/<?php echo $mes;?>/<?php echo $ano;?></td>
                          <?php if($noti['linkfatura']=='Admin'){?>
                              <td><span class="label label-warning bg-yellow-active color-palette">Administração</span></td>
                          <?php }else{ if($tipo=='Fatura'){?>
                              <td><a href="home.php?page=<?php echo $noti['linkfatura'];?>"><span class="<?php echo $class;?>"><?php echo $info;?></span></a></td>

                          <?php }else{?>
                              <td><span class="<?php echo $class;?>"><?php echo $info;?></span></td>
                          <?php } } ?>
                          <td><?php echo $noti['mensagem'];?></td>
                      </tr>

                  <?php } }else{ ?>

                    <tr ><td valign="top" colspan="5">Nenhuma notificação encontrada</td></tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>