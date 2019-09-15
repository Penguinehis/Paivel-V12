<?php


require_once("pages/system/seguranca.php");
require_once("pages/system/config.php");
require_once("pages/system/classe.ssh.php");

protegePagina("user");


$quantidade_ssh = 0;
$quantidade_ssh_user =0;
$quantidade_ssh_sub =0;
$quantidade_sub = 0;
$all_ssh_susp_qtd = 0;

$SQLUsuario = "SELECT * FROM usuario WHERE id_usuario = '".$_SESSION['usuarioID']."'";
$SQLUsuario = $conn->prepare($SQLUsuario);
$SQLUsuario->execute();
$usuario = $SQLUsuario->fetch();
        // avatares
switch($usuario['avatar']){
  case 1:$avatarusu="avatar1.png";break;
  case 2:$avatarusu="avatar2.png";break;
  case 3:$avatarusu="avatar3.png";break;
  case 4:$avatarusu="avatar4.png";break;
  case 5:$avatarusu="avatar5.png";break;
  default:$avatarusu="boxed-bg.png";break;
}


if($usuario['tipo']=='revenda'){
  $tipouser='Revendedor';
}elseif($usuario['tipo']=='vpn'){
  $tipouser='Usuário VPN';
}

$datacad=$usuario['data_cadastro'];

$partes = explode("-", $datacad);
$ano = $partes[0];
$mes = $partes[1];

$Mes = muda_mes($mes);
$Meses = muda_mes2($mes);




$SQLUsuario_ssh = "select * from usuario_ssh WHERE id_usuario = '".$_SESSION['usuarioID']."' ";
$SQLUsuario_ssh = $conn->prepare($SQLUsuario_ssh);
$SQLUsuario_ssh->execute();
$quantidade_ssh += $SQLUsuario_ssh->rowCount();

$SQLUsuario_sshSUSP = "select * from usuario_ssh WHERE id_usuario = '".$_SESSION['usuarioID']."' and  status='2' and apagar='0' ";
$SQLUsuario_sshSUSP = $conn->prepare($SQLUsuario_sshSUSP);
$SQLUsuario_sshSUSP->execute();
$all_ssh_susp_qtd += $SQLUsuario_sshSUSP->rowCount();

$total_acesso_ssh = 0;
$SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$_SESSION['usuarioID']."' ";
$SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
$SQLAcessoSSH->execute();
$SQLAcessoSSH = $SQLAcessoSSH->fetch();
$total_acesso_ssh += $SQLAcessoSSH['quantidade'];

$total_acesso_ssh_online = 0;
$SQLAcessoSSH = "SELECT sum(online) AS quantidade  FROM usuario_ssh  where id_usuario='".$_SESSION['usuarioID']."' ";
$SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
$SQLAcessoSSH->execute();
$SQLAcessoSSH = $SQLAcessoSSH->fetch();
$total_acesso_ssh_online += $SQLAcessoSSH['quantidade'];




$SQLAcesso= "select * from acesso_servidor WHERE id_usuario = '".$_SESSION['usuarioID']."' ";
$SQLAcesso = $conn->prepare($SQLAcesso);
$SQLAcesso->execute();
$acesso_servidor = $SQLAcesso->rowCount();


        //Arquivos download
$SQLArquivos= "select * from  arquivo_download";
$SQLArquivos = $conn->prepare($SQLArquivos);
$SQLArquivos->execute();
$todosarquivos = $SQLArquivos->rowCount();
if($usuario['id_mestre']==0){
        // Faturas
  $SQLfaturas= "select * from  fatura where status='pendente' and usuario_id='".$_SESSION['usuarioID']."'";
  $SQLfaturas = $conn->prepare($SQLfaturas);
  $SQLfaturas->execute();
  $faturas = $SQLfaturas->rowCount();
}else{
        // Faturas
  $SQLfaturas= "select * from  fatura_clientes where status='pendente' and usuario_id='".$_SESSION['usuarioID']."'";
  $SQLfaturas = $conn->prepare($SQLfaturas);
  $SQLfaturas->execute();
  $faturas = $SQLfaturas->rowCount();
}
if($usuario['tipo']=='revenda'){
        // Faturas
  $SQLfaturas2= "select * from  fatura_clientes where status='pendente' and id_mestre='".$_SESSION['usuarioID']."'";
  $SQLfaturas2 = $conn->prepare($SQLfaturas2);
  $SQLfaturas2->execute();
  $faturas_clientes = $SQLfaturas2->rowCount();
}
        // Notificações
$SQLnoti= "select * from  notificacoes where lido='nao' and usuario_id='".$_SESSION['usuarioID']."'";
$SQLnoti = $conn->prepare($SQLnoti);
$SQLnoti->execute();
$totalnoti = $SQLnoti->rowCount();
        // Notificações Contas
$SQLnoti1= "select * from  notificacoes where lido='nao' and tipo='conta' and usuario_id='".$_SESSION['usuarioID']."'";
$SQLnoti1= $conn->prepare($SQLnoti1);
$SQLnoti1->execute();
$totalnoti_contas = $SQLnoti1->rowCount();

        // Notificações fatura
$SQLnoti2= "select * from  notificacoes where lido='nao' and tipo='fatura' and usuario_id='".$_SESSION['usuarioID']."'";
$SQLnoti2= $conn->prepare($SQLnoti2);
$SQLnoti2->execute();
$totalnoti_fatura = $SQLnoti2->rowCount();

if($usuario['tipo']=='revenda'){
        // Notificações Revenda
  $SQLnoti3= "select * from  notificacoes where lido='nao' and tipo='revenda' and usuario_id='".$_SESSION['usuarioID']."'";
  $SQLnoti3= $conn->prepare($SQLnoti3);
  $SQLnoti3->execute();
  $totalnoti_revenda = $SQLnoti3->rowCount();

        //Todos os chamados subRevendedores e usuarios do revendedor
  $SQLchamadoscli2= "select * from  chamados where status='resposta' and id_mestre='".$_SESSION['usuarioID']."'";
  $SQLchamadoscli2= $conn->prepare($SQLchamadoscli2);
  $SQLchamadoscli2->execute();
  $all_chamados_clientes += $SQLchamadoscli2->rowCount();
        //Todos os chamados subRevendedores e usuarios do revendedor
  $SQLchamadoscli= "select * from  chamados where status='aberto' and id_mestre='".$_SESSION['usuarioID']."'";
  $SQLchamadoscli= $conn->prepare($SQLchamadoscli);
  $SQLchamadoscli->execute();
  $all_chamados_clientes += $SQLchamadoscli->rowCount();

        //subrevendedores
  $SQLsbrevenda = "select * from usuario WHERE id_mestre = '".$_SESSION['usuarioID']."' and subrevenda='sim' ";
  $SQLsbrevenda = $conn->prepare($SQLsbrevenda);
  $SQLsbrevenda->execute();
  $quantidade_sub_revenda = $SQLsbrevenda->rowCount();
}

        //Todos os chamados meus 1
$SQLchamados= "select * from  chamados where status='aberto' and usuario_id='".$_SESSION['usuarioID']."'";
$SQLchamados= $conn->prepare($SQLchamados);
$SQLchamados->execute();
$all_chamados += $SQLchamados->rowCount();
        //Todos os chamados meus 2
$SQLchamados2= "select * from  chamados where status='resposta' and usuario_id='".$_SESSION['usuarioID']."'";
$SQLchamados2= $conn->prepare($SQLchamados2);
$SQLchamados2->execute();
$all_chamados += $SQLchamados2->rowCount();
        // Notificações chamados
$SQLnotichama= "select * from  notificacoes where lido='nao' and tipo='chamados' and usuario_id='".$_SESSION['usuarioID']."'";
$SQLnotichama= $conn->prepare($SQLnotichama);
$SQLnotichama->execute();
$totalnoti_chamados = $SQLnotichama->rowCount();
        // Notificações Outros
$SQLnoti4= "select * from  notificacoes where lido='nao' and tipo='outros' and usuario_id='".$_SESSION['usuarioID']."'";
$SQLnoti4= $conn->prepare($SQLnoti4);
$SQLnoti4->execute();
$totalnoti_outros = $SQLnoti4->rowCount();

if($usuario['id_mestre']<>0){
        // Notificações users
  $SQLnoti5= "select * from  notificacoes where lido='nao' and tipo='usuario' and usuario_id='".$_SESSION['usuarioID']."'";
  $SQLnoti5= $conn->prepare($SQLnoti5);
  $SQLnoti5->execute();
  $totalnoti_users = $SQLnoti5->rowCount();


}


if($usuario['tipo']=="revenda"){
  $SQLSub= "select * from usuario WHERE id_mestre = '".$_SESSION['usuarioID']."' and subrevenda='nao'";
  $SQLSub = $conn->prepare($SQLSub);
  $SQLSub->execute();


  if (($SQLSub->rowCount()) > 0) {

    while($row = $SQLSub->fetch()) {

      $SQLSubSSH= "select * from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."'  ";
      $SQLSubSSH = $conn->prepare($SQLSubSSH);
      $SQLSubSSH->execute();
      $quantidade_ssh += $SQLSubSSH->rowCount();

      $sshsub=$SQLSubSSH->rowCount();

      $SQLUsuario_sshSUSP = "select * from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."' and status='2' and apagar='0' ";
      $SQLUsuario_sshSUSP = $conn->prepare($SQLUsuario_sshSUSP);
      $SQLUsuario_sshSUSP->execute();
      $all_ssh_susp_qtd += $SQLUsuario_sshSUSP->rowCount();

      $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$row['id_usuario']."' ";
      $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
      $SQLAcessoSSH->execute();
      $SQLAcessoSSH = $SQLAcessoSSH->fetch();
      $total_acesso_ssh += $SQLAcessoSSH['quantidade'];


      $SQLAcessoSSHon = "SELECT sum(online) AS quantidade  FROM usuario_ssh  where id_usuario='".$row['id_usuario']."' ";
      $SQLAcessoSSHon = $conn->prepare($SQLAcessoSSHon);
      $SQLAcessoSSHon->execute();
      $SQLAcessoSSHon = $SQLAcessoSSHon->fetch();
      $total_acesso_ssh_online += $SQLAcessoSSHon['quantidade'];

    }


  }
  $quantidade_sub += $SQLSub->rowCount();


      //Calcula os dias restante
  $data_atual = date("Y-m-d ");
  $data_validade = $usuario['validade'];

  $data1 = new DateTime( $data_validade );
  $data2 = new DateTime( $data_atual );

  $diferenca = $data1->diff( $data2 );
  $ano = $diferenca->y * 364 ;
  $mes = $diferenca->m * 30;
  $dia = $diferenca->d;
  $dias_acesso = $ano + $mes + $dia;

  $quantidade_ssh +=   $quantidade_ssh_sub+$quantidade_ssh_user;

  if($usuario['ativo']==2){
    echo '<script type="text/javascript">';
    echo   'alert("Sua conta  esta suspensa!");';
    echo 'window.location="pages/suspenso.php";';
    echo '</script>';
    exit;

  }

}

?>
<!DOCTYPE html>
<html lang="pt_BR">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="crazy_vpn">
<!-- Favicon icon -->
<link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
<title>CRACKEDPENGUIN | Painel</title>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<!-- Bootstrap Core CSS -->
<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">  <!-- Ionicons -->
<!-- chartist CSS -->
<link href="assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
<link href="assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
<link href="assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
<!--This page css - Morris CSS -->
<link href="assets/plugins/c3-master/c3.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="material/css/style.css" rel="stylesheet">
<!-- You can change the theme colors from here -->
<link href="material/css/colors/red-dark.css" id="theme" rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
<script>
  //paste this code under head tag or in a seperate js file.
  // Wait for window load
  $(window).load(function() {
    // Animate loader off screen
    $(".se-pre-con").fadeOut('slow');;
  });
</script>
<script>
  function usuariosonline()
  {

  // Requisição
  $.post('pages/ssh/online_home.php?requisicao=1',
    function (resposta) {
          //Adiciona Efeito Fade
          $("#usuarioson").fadeOut("slow").fadeIn('slow');
      // Limpa
      $('#usuarioson').empty();
      // Exibe
      $('#usuarioson').append(resposta);
    });
}
// Intervalo para cada Chamada
setInterval("usuariosonline()", 30000);

// Após carregar a Pagina Primeiro Requisito
$(function() {
    // Requisita Função acima
    usuariosonline();
  });
</script>
<script>
  function atualizar()
  {
    // Fazendo requisição AJAX
    $.post('pages/ssh/online_home.php?requisicao=2',
      function (online) {
        // Exibindo frase
        $('#online_nav').html(online);
        $('#online').html(online);

      }, 'JSON');
  }
// Definindo intervalo que a função será chamada
setInterval("atualizar()", 10000);
// Quando carregar a página
$(function() {
    // Faz a primeira atualização
    atualizar();
  });
</script>
<body class="fix-header fix-sidebar card-no-border">
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Site wrapper -->
    <div class="wrapper">
      <div class="modal fade" id="flaggeral" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
              <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-flag"></i> Alertar Todos!</h3>
            </div>
            <div class="modal-body">

              <!-- content goes here -->
              <form name="editaserver" action="pages/usuario/notificar_home.php" method="post">
                <div class="form-group">
                  <label for="exampleInputEmail1">Tipo de Notificação </label>
                  <?php if(($usuario['tipo']=='revenda') and ($usuario['subrevenda']=='nao')){?>
                    <select size="1" name="clientes" class="form-control select2">
                      <option value="1" selected=selected>Todos</option>
                      <option value="2">Revendedores</option>
                      <option value="3" >Clientes</option>
                    </select>
                  <?php }else{ ?>
                    <select size="1" name="clientes" class="form-control select2" disabled>
                      <option value="1" selected=selected>Todos Clientes</option>
                    </select>
                  <?php } ?>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Mensagem</label>
                  <textarea class="form-control" name="msg" rows="3" cols="20" wrap="off" placeholder="Digite..."></textarea>
                </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-inverse" data-dismiss="modal" role="button">Cancelar</button>
                <button class="btn btn-success">Confirmar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- Site wrapper -->
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
  <!-- ============================================================== -->
  <!-- Topbar header - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
      <!-- ============================================================== -->
      <!-- Logo -->
      <!-- ============================================================== -->

      <!-- ============================================================== -->
      <!-- End Logo -->
      <!-- ============================================================== -->
      <div class="navbar-collapse">
        <!-- ============================================================== -->
        <!-- toggle and nav items -->
        <!-- ============================================================== -->
        <ul class="navbar-nav mr-auto mt-md-0">
          <!-- This is  -->
          <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
          <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
        </ul>
        <!-- ============================================================== -->
        <ul class="navbar-nav my-lg-0">
          <!-- ============================================================== -->
          <!-- Comment -->
          <!-- ============================================================== -->
          <?php if($usuario['tipo']=='revenda'){?>
            <li class="nav-item dropdown">
             <a data-toggle="modal" href="#flaggeral" class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-flag"></i>
             </a>
           </li>
         <?php } ?>
         <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-rocket"></i>
            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div></a>
          <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
            <ul>
              <li>
                <div class="drop-title">Usuários Online </div>
                <div class="message-center">
                <ul class="menu" id="usuarioson">

                </ul>
              </div>
              
              <li>
                <a class="nav-link text-center" href="home.php?page=ssh/online"> <strong>Ver Todos</strong> <i class="fa fa-angle-right"></i> </a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-bell"></i>
          <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
          </a>
          <div class="dropdown-menu mailbox dropdown-menu-right scale-up" aria-labelledby="2">
            <ul>
              <li>
               <?php if($totalnoti==0){?>
                <div class="drop-title">Você não possui novas notificações</div>
              </li>
            <?php }else{ ?>
              <li>
                <div class="drop-title">Você possui <?php echo $totalnoti;?> nova <?php if($totalnoti>1){ echo "s";}?> <?php if($totalnoti<=1){ echo "notificação";}else { echo "notificações";}?></div>
              </li>
            <?php }?>
            <li>
              <div class="message-center">
                <!-- Message -->
                <a href="?page=notificacoes/notificacoes&ler=accs">
                  <div class="mail-contnet">
                    <h5><i class="fas fa-user"></i> <?php echo $totalnoti_contas;?>  Em Contas</h5></div>
                  </a>
                  <?php
                  if($usuario['subrervenda']=='nao'){
                   if($usuario['id_mestre']<>0){ ?>
                    <!-- Message -->
                    <a href="?page=notificacoes/notificacoes&ler=usuario">
                      <div class="mail-contnet">
                        <h5><i class="fas fa-users"></i> <?php echo $totalnoti_users;?>  Em Usuário</h5></div>
                      </a>
                    <?php }}
                    if($usuario['tipo']=='revenda'){ ?>
                      <!-- Message -->
                      <a href="?page=notificacoes/notificacoes&ler=reve">
                        <div class="mail-contnet">
                          <h5><i class="fas fa-users"></i> <?php echo $totalnoti_revenda;?>  Em Revendas</h5></div>
                        </a>
                      <?php } ?>
                      <!-- Message -->
                      <a href="?page=notificacoes/notificacoes&ler=others">
                        <div class="mail-contnet">
                          <h5><i class="fas fa-info-circle"></i> <?php echo $totalnoti_outros;?>  Em Outros</h5></div>
                        </a>
                        <a href="?page=notificacoes/notificacoes&ler=fatu">
                          <div class="mail-contnet">
                            <h5><i class="fas fa-file-invoice-dollar"></i> <?php echo $totalnoti_fatura;?>  Em Faturas</h5></div>
                          </a>
                          <a href="?page=notificacoes/notificacoes&ler=chamados">
                            <div class="mail-contnet">
                              <h5><i class="fas fa-ticket-alt"></i> <?php echo $totalnoti_chamados;?>  Em Chamados</h5></div>
                            </a>											
                          </div>
                        </li>
                        <li>
                          <a class="nav-link text-center" href="?page=notificacoes/notificacoes&ler=all"> <strong>Ver Todos</strong> <i class="fa fa-angle-right"></i> </a>
                        </li>
                      </ul>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="dist/img/<?php echo $avatarusu;?>" alt="user" class="profile-pic" /></a>
                    <div class="dropdown-menu dropdown-menu-right scale-up">
                      <ul class="dropdown-user">
                        <li>
                          <div class="dw-user-box">
                            <div class="u-img"><img src="dist/img/<?php echo $avatarusu;?>" class="user-image" alt="User Image"></div>
                            <div class="u-text">
                              <h4><?php echo strtoupper($usuario['nome']);?></h4>
                              <p class="text-muted"><?php echo $tipouser;?></p>
                              <p class="text-muted">Desde: <?php echo date('d-m-Y', strtotime($usuario['data_cadastro']));?></p>
                            </div>
                          </div>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a href="home.php?page=admin/dados"><i class="ti-user"></i> Meu Perfil</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="sair.php"><i class="fa fa-power-off"></i> Sair</a></li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </div>
            </nav>
          </header>
          <!-- ============================================================== -->
          <!-- End Topbar header -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- Left Sidebar - style you can find in sidebar.scss  -->
          <!-- ============================================================== -->
          <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
              <!-- User profile -->
              <div class="user-profile" style="background: url(../assets/images/background/back.jpg) no-repeat center ;">
                <!-- User profile image -->
                <div class="profile-img"> <img src="dist/img/<?php echo $avatarusu;?>" alt="user" /> </div>
                <!-- User profile text-->
                <div class="profile-text"> <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><?php echo strtoupper($usuario['nome']);?></a>
                  <div class="dropdown-menu animated flipInY">
                    <a href="home.php?page=admin/dados" class="dropdown-item"><i class="ti-user"></i> Meu Perfil</a>
                    <div class="dropdown-divider"></div>
                    <a href="sair.php" class="dropdown-item"><i class="fa fa-power-off"></i> Sair</a>
                  </div>
                </div>
              </div>
              <!-- End User profile text-->
              <!-- Sidebar navigation-->
              <nav class="sidebar-nav">
                <ul id="sidebarnav">
                  <li class="nav-small-cap">NAVEGACAO PRINCIPAL</li>
                  <li><a href="home.php" aria-expanded="false"><i class="fas fa-home"></i><span class="hide-menu">INICIO</span></a>
                  </li>
                  <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-greater-than-equal"></i><span class="hide-menu">CONTAS</span>&emsp;&emsp;&emsp; <span class="badge badge-success ml-auto"><?php echo $quantidade_ssh; ?></span></a>
                    <ul aria-expanded="false" class="collapse">
                     <?php if(($usuario['tipo']=="revenda") and ($acesso_servidor > 0) ){?>
                      <li><a href="?page=ssh/adicionar"><i class="fas fa-terminal"></i> Criar conta SSH</a></li>
                      <li><a href="?page=ssh/add_teste"><i class="fas fa-clock"></i> Criar teste SSH</a></li>
                    <?php }?>
                    <li ><a href="?page=ssh/contas"><i class="fas fa-list"></i> Listar contas SSH</a></li>
                    <li ><a href="?page=ssh/online"><i class="fas fa-rocket"></i> Contas SSH online</a></li>
                  </ul>
                </li>

                <?php if($usuario['tipo']=="revenda") {?>
                  <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-user"></i><span class="hide-menu">CLIENTES</span>&emsp;&emsp;&emsp;<span class="badge badge-success ml-auto"><?php echo $quantidade_sub; ?></span></a>
                    <ul aria-expanded="false" class="collapse">
                      <li><a href="?page=usuario/adicionar"><i class="fas fa-user-plus"></i> Novo usuario</a></li>
                      <li><a href="?page=usuario/listar"><i class="fas fa-user-shield"></i> Usuarios VPN</a></li>
                    </ul>
                  </li>


                  <?php if($usuario['subrevenda']<>'sim'){ ?>
                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-user-tie"></i><span class="hide-menu">SUBREVENDA</span>&ensp;&ensp;<span class="badge badge-success ml-auto"><?php echo $quantidade_sub_revenda; ?></span></a>
                      <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=subrevenda/adicionar"><i class="fas fa-user-edit"></i> ADD Servidor</a></li>
                        <li><a href="?page=subrevenda/revendedores"><i class="fas fa-user-tie"></i> Revendedores</a></li>
                      </ul>
                    </li>
                  <?php } ?>
                <?php } ?>

                <?php if(($usuario['tipo']=="revenda") and ($acesso_servidor > 0) ){?>
                  <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-server"></i><span class="hide-menu">SERVIDORES</span>&emsp;&nbsp;&nbsp;<span class="badge badge-success ml-auto"><?php echo $acesso_servidor; ?></span></a>
                    <ul aria-expanded="false" class="collapse">
                      <li><a href="?page=servidor/listar"><i class="fas fa-list-ul"></i> Listar servidores</a></li>
                      <?php if($usuario['subrevenda']<>'sim'){?>
                        <li><a href="?page=subrevenda/alocados"><i class="fas fa-user-cog"></i> Servidores Alocados</a></li>
                      <?php } ?>
                    </ul>
                  </li>
                <?php }?>
                <?php if($usuario['id_mestre']==0){?>
                  <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-wallet"></i><span class="hide-menu">M. FATURA</span>&emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="badge badge-success ml-auto"><?php echo $faturas; ?></span></a>
                    <ul aria-expanded="false" class="collapse">
                      <li><a href="?page=faturas/abertas"><i class="fas fa-file-invoice-dollar"></i> Abertas</a></li>
                      <li><a href="?page=faturas/pagas"><i class="fas fa-file-powerpoint"></i> Pagas</a></li>
                      <li><a href="?page=faturas/canceladas"><i class="fas fa-file-excel"></i> Canceladas</a></li>
                    </ul>
                  </li>
                  <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-id-badge"></i><span class="hide-menu">M. CHAMADOS</span>&nbsp;<span class="badge badge-success ml-auto"><?php echo $all_chamados; ?></span></a>
                    <ul aria-expanded="false" class="collapse">
                      <li><a href="?page=chamados/abrir"><i class="fas fa-user-plus"></i> Abrir um chamado</a></li>
                      <li><a href="?page=chamados/abertas"><i class="fas fa-user-tag"></i> Abertas</a></li>
                      <li><a href="?page=chamados/respondidos"><i class="fas fa-user-check"></i> Respondidas</a></li>
                      <li><a href="?page=chamados/encerrados"><i class="fas fa-user-times"></i> Encerradas</a></li>
                    </ul>
                  </li>
                <?php }else{ ?>
                  <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-wallet"></i><span class="hide-menu">M. FATURAS</span>&emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="badge badge-success ml-auto"><?php echo $faturas; ?></span></a>
                    <ul aria-expanded="false" class="collapse">
                      <li><a href="?page=faturasclientes/minhas/abertas"><i class="fas fa-file-invoice-dollar"></i> Abertas</a></li>
                      <li><a href="?page=faturasclientes/minhas/pagas"><i class="fas fa-file-powerpoint"></i> Pagas</a></li>
                      <li><a href="?page=faturasclientes/minhas/canceladas"><i class="fas fa-file-excel"></i> Canceladas</a></li>
                    </ul>
                  </li>
                  <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-id-badge"></i><span class="hide-menu">M. CHAMADOS</span>&nbsp;<span class="badge badge-success ml-auto"><?php echo $all_chamados; ?></span></a>
                    <ul aria-expanded="false" class="collapse">
                      <li><a href="?page=chamados/abrir"><i class="fas fa-user-plus"></i> Abrir um chamado</a></li>
                      <li><a href="?page=chamados/abertas"><i class="fas fa-user-tag"></i> Abertas</a></li>
                      <li><a href="?page=chamados/respondidos"><i class="fas fa-user-check"></i> Respondidas</a></li>
                      <li><a href="?page=chamados/encerrados"><i class="fas fa-user-times"></i> Encerradas</a></li>
                    </ul>
                  </li>
                <?php }?>
                <?php if($usuario['tipo']=='revenda'){ ?>
                  <li class="nav-devider"></li>
                  <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-wallet"></i><span class="hide-menu"> F. DO CLIENTE</span>&ensp;<span class="badge badge-success ml-auto"><?php echo $faturas_clientes; ?></span></a>
                    <ul aria-expanded="false" class="collapse">
                      <li><a href="?page=faturasclientes/abertas"><i class="fas fa-file-invoice-dollar"></i> Abertas</a></li>
                      <li><a href="?page=faturasclientes/pagas"><i class="fas fa-file-powerpoint"></i> Pagas</a></li>
                      <li><a href="?page=faturasclientes/canceladas"><i class="fas fa-file-excel"></i> Canceladas</a></li>
                      <li><a href="?page=faturasclientes/comprovantes"><i class="fas fa-file-invoice"></i> Comprovantes</a></li>
                      <li><a href="?page=faturasclientes/cpfechados"><i class="fas fa-file-csv"></i> CP Fechados</a></li>
                    </ul>
                  </li>
                  <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-id-badge"></i><span class="hide-menu">C. CLIENTE</span>&emsp;&emsp;&nbsp;<span class="badge badge-success ml-auto"><?php echo $all_chamados_clientes; ?></span></a>
                    <ul aria-expanded="false" class="collapse">
                      <li><a href="?page=chamadosclientes/abertas"><i class="fas fa-user-tag"></i> Abertas</a></li>
                      <li><a href="?page=chamadosclientes/respondidos"><i class="fas fa-user-check"></i> Respondidas</a></li>
                      <li><a href="?page=chamadosclientes/encerrados"><i class="fas fa-user-times"></i> Encerradas</a></li>
                    </ul>
                  </li>
                <?php } ?>
                <li class="nav-devider"></li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-cog"></i><span class="hide-menu">CONFIGURACOES</span></a>
                  <ul aria-expanded="false" class="collapse">
                    <li><a href="?page=admin/dados"><i class="fas fa-user-circle"></i> Minhas Informacoes</a></li>
                    <?php if($usuario['tipo']=="revenda") {?>
                      <li><a href="?page=email/enviaremail"><i class="fas fa-envelope"></i> <span> Email</span></a></li>
                    <?php } ?>
                    <li><a href="?page=downloads/downloads"><i class="fab fa-sellsy"></i> <span> Arquivos</span></a></li>
                  </ul>
                </li>
              </ul>
            </nav>
            <!-- End Sidebar navigation -->
          </div>
          <!-- End Sidebar scroll-->
          <!-- Bottom points-->
          <div class="sidebar-footer">
            <!-- item--><a href="?page=admin/dados" class="link" data-toggle="tooltip" title="Configuracoes"><i class="ti-settings"></i></a>
            <!-- item--><a href="?page=email/enviaremail" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
            <!-- item--><a href="sair.php" class="link" data-toggle="tooltip" title="Sair"><i class="mdi mdi-power"></i></a>
          </div>
          <!-- End Bottom points-->
        </aside>

        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">

         <?php

         if($usuario['atualiza_dados']==1){
           if(isset($_GET["page"])){
             $page = $_GET["page"];
             if($page and file_exists("pages/".$page.".php")) {
               include("pages/".$page.".php");
             } else {
               include("./pages/inicial.php");
             }
           }else{
             include("./pages/inicial.php");
           }
         }else{
          include("./pages/admin/dados.php");
        }

        ?>

        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer"><center> © <script>document.write(new Date().getFullYear())</script> CRACKED<b>PENGUIN</b></center></footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
      </div>
      <!-- ============================================================== -->
      <!-- End Page wrapper  -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="material/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="material/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="material/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!--Custom JavaScript -->
    <script src="material/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- chartist chart -->
    <script src="assets/plugins/chartist-js/dist/chartist.min.js"></script>
    <script src="assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
    <!--c3 JavaScript -->
    <script src="assets/plugins/d3/d3.min.js"></script>
    <script src="assets/plugins/c3-master/c3.min.js"></script>
    <!-- Chart JS -->
    <script src="material/js/dashboard1.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

  </body>
  </html>