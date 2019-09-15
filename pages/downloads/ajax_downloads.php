<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="scripts/tooltipsy.min.js"></script>
<script type="text/javascript">
  $('.descricao').tooltipsy({
    offset: [0, 10],
    css: {
      'padding': '10px',
      'max-width': '200px',
      'color': '#303030',
      'background-color': '#f5f5b5',
      'border': '1px solid #deca7e',
      '-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
      '-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
      'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
      'text-shadow': 'none'
    }
  });
</script>
<?php
require_once('../../pages/system/seguranca.php');
require_once('../../pages/system/config.php');
require_once('../../pages/system/funcoes.php');
require_once('../../pages/system/classe.ssh.php');

protegePagina("user");

if(isset($_GET['tipo'])){
  $tipo=$_GET['tipo'];
}else{
  $tipo=1;
}

switch($tipo){
  case 0:$tip='todos';break;
  case 1:$tip='ehi';break;
  case 2:$tip='apk';break;
  case 3:$tip='outros';break;
  default:$tip='todos';break;
}

$SQLUsuario = "SELECT * FROM usuario WHERE id_usuario = '".$_SESSION['usuarioID']."'";
$SQLUsuario = $conn->prepare($SQLUsuario);
$SQLUsuario->execute();
$usuario = $SQLUsuario->fetch();

if($tip=='todos'){
  $SQLSubSSH = "SELECT * FROM arquivo_download where cliente_tipo='".$usuario['tipo']."' or cliente_tipo='todos'  ORDER BY id desc";
}else{
  $SQLSubSSH = "SELECT * FROM arquivo_download where cliente_tipo='".$usuario['tipo']."' or cliente_tipo='todos' and tipo='".$tip."'  ORDER BY id desc";
}


$SQLSubSSH = $conn->prepare($SQLSubSSH);
$SQLSubSSH->execute();

if(($SQLSubSSH->rowCount()) > 0){
 while($row = $SQLSubSSH->fetch()){


   $dataatual=$row['data'];
   $dataconv = substr($dataatual, 0, 10);

   $partes = explode("-", $dataconv);
   $ano = $partes[0];
   $mes = $partes[1];
   $dia = $partes[2];

   switch($row['operadora']){
     case 'vivo':$bg='bg-primary';break;
     case 'claro':$bg='bg-danger';break;
     case 'tim':$bg='bg-info';break;
     case 'oi':$bg='bg-warning';break;
     default:$bg='bg-inverse';break;
   }

   switch($row['tipo']){
     case 'ehi':$ion='ion ion-android-document';break;
     case 'apk':$ion='ion ion-social-android';break;
     case 'outros':$ion='ion-shuffle';break;
     default:$ion='ion-shuffle';break;
   }

   ?>

      <div class="col-lg-3 col-md-6 descricao" title="<?php echo $row['detalhes'];?>">
        <!-- small box -->
        <div class="card"><a href="pages/downloads/baixar.php?id=<?php echo $row['id'];?>">
          <div class="d-flex flex-row">
            <div class="p-10 <?php echo $bg;?>">
              <h3 class="text-white box m-b-0"><i class="fa fa-download"></i></h3>
            </div>
            <div class="align-self-center m-l-20">
              <h3 class="m-b-0 text-info"><?php echo $row['nome'];?></h3>
              <?php if($row['status']=='funcionando'){?>
                <h5 class="text-success m-b-0">Funcionando</h5>
              <?php }elseif($row['status']=='testes'){ ?>
                <h5 class="text-warning m-b-0">Em testes</h5>
              <?php } ?>
            </div>
          </div>
        </div></a>
      </div>

                 <!--
                  <td><?php echo $row['id'];?></td>
                  <td><?php echo ucfirst($row['tipo']);?></td>
                  <td><?php echo ucfirst($row['operadora']);?></td>
                  <td><?php echo $dia;?>/<?php echo $mes;?> - <?php echo $ano;?></td>
                  <td><?php echo $row['detalhes'];?></td>
                  <td><a href="pages/downloads/baixar.php?id=<?php echo $row['id'];?>" class="btn btn-primary">Baixar</a></td>
                -->

                <?php
              }

            }else{ ?>

             <div class="col-lg-12"><center><small>Infelizmente nada foi encontrado !</small></center></div>
           <?php }


           ?>
         </div>
