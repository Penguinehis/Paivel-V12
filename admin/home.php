<?php
require_once("../pages/system/funcoes.php");
require_once("../pages/system/seguranca.php");
require_once("../pages/system/config.php");
require_once("../pages/system/classe.ssh.php");

protegePagina("admin");
if( $_SESSION['tipo'] == "user"){
	expulsaVisitante();
}


$data_atual = date("Y-m-d");

$SQLAdministrador = "SELECT * FROM admin WHERE id_administrador = '".$_SESSION['usuarioID']."'";
$SQLAdministrador = $conn->prepare($SQLAdministrador);
$SQLAdministrador->execute();
$administrador = $SQLAdministrador->fetch();

		 //Carrega qtd contas ssh do sistema

$SQLUsuario_sshSUSP = "select * from usuario_ssh WHERE status='2' ";
$SQLUsuario_sshSUSP = $conn->prepare($SQLUsuario_sshSUSP);
$SQLUsuario_sshSUSP->execute();
$ssh_susp_qtd += $SQLUsuario_sshSUSP->rowCount();

$SQLContasSSH = "SELECT * FROM usuario_ssh ";
$SQLContasSSH = $conn->prepare($SQLContasSSH);
$SQLContasSSH->execute();
$contas_ssh = $SQLContasSSH->rowCount();


$total_acesso_ssh = 0;
$SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh  ";
$SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
$SQLAcessoSSH->execute();
$SQLAcessoSSH = $SQLAcessoSSH->fetch();
$total_acesso_ssh += $SQLAcessoSSH['quantidade'];

$total_acesso_ssh_online = 0;
$SQLAcessoSSH = "SELECT sum(online) AS quantidade  FROM usuario_ssh  ";
$SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
$SQLAcessoSSH->execute();
$SQLAcessoSSH = $SQLAcessoSSH->fetch();
$total_acesso_ssh_online += $SQLAcessoSSH['quantidade'];


		//carrega qtd de todos os usuarios do sistema
$SQLUsuarios = "SELECT * FROM usuario ";
$SQLUsuarios = $conn->prepare($SQLUsuarios);
$SQLUsuarios->execute();
$all_usuarios_qtd = $SQLUsuarios->rowCount();

		//carrega qtd de todos os usuarios do sistema SSH
$SQLVPN = "SELECT * FROM usuario  where tipo='vpn' ";
$SQLVPN = $conn->prepare($SQLVPN);
$SQLVPN->execute();
$all_usuarios_vpn_qtd = $SQLVPN->rowCount();

$SQLVPN = "SELECT * FROM usuario  where tipo='vpn' and ativo='2' ";
$SQLVPN = $conn->prepare($SQLVPN);
$SQLVPN->execute();
$all_usuarios_vpn_qtd_susp = $SQLVPN->rowCount();

		//carrega qtd de todos os usuarios do sistema SSH
$SQLRevenda = "SELECT * FROM usuario  where tipo='revenda' ";
$SQLRevenda = $conn->prepare($SQLRevenda);
$SQLRevenda->execute();
$all_usuarios_revenda_qtd = $SQLRevenda->rowCount();
		//carrega qtd de todos os usuarios do sistema SSH
$SQLRevenda = "SELECT * FROM usuario  where tipo='revenda' and ativo='2'";
$SQLRevenda = $conn->prepare($SQLRevenda);
$SQLRevenda->execute();
$revenda_qtd_susp = $SQLRevenda->rowCount();

		//carrega qtd de servidores
$SQLServidor = "SELECT * FROM servidor ";
$SQLServidor = $conn->prepare($SQLServidor);
$SQLServidor->execute();
$servidor_qtd = $SQLServidor->rowCount();

        // arquivos download
$SQLArquivos= "select * from  arquivo_download";
$SQLArquivos = $conn->prepare($SQLArquivos);
$SQLArquivos->execute();
$todosarquivos = $SQLArquivos->rowCount();
        // Faturas
$SQLfaturas= "select * from  fatura where status='pendente'";
$SQLfaturas = $conn->prepare($SQLfaturas);
$SQLfaturas->execute();
$faturas = $SQLfaturas->rowCount();
         // Notificações
$SQLnoti= "select * from  notificacoes where lido='nao' and admin='sim'";
$SQLnoti = $conn->prepare($SQLnoti);
$SQLnoti->execute();
$totalnoti = $SQLnoti->rowCount();
         // Notificações fatura
$SQLnoti2= "select * from  notificacoes where lido='nao' and tipo='fatura' and admin='sim'";
$SQLnoti2= $conn->prepare($SQLnoti2);
$SQLnoti2->execute();
$totalnoti_fatura = $SQLnoti2->rowCount();
        // Notificações chamados
$SQLnoti3= "select * from  notificacoes where lido='nao' and tipo='chamados' and admin='sim'";
$SQLnoti3= $conn->prepare($SQLnoti3);
$SQLnoti3->execute();
$totalnoti_chamados = $SQLnoti3->rowCount();

         //Todos os chamados subRevendedores e usuarios do revendedor
$SQLchamadoscli2= "select * from  chamados where status='resposta' and id_mestre=0";
$SQLchamadoscli2= $conn->prepare($SQLchamadoscli2);
$SQLchamadoscli2->execute();
$all_chamados += $SQLchamadoscli2->rowCount();
        //Todos os chamados subRevendedores e usuarios do revendedor
$SQLchamadoscli= "select * from  chamados where status='aberto' and id_mestre=0";
$SQLchamadoscli= $conn->prepare($SQLchamadoscli);
$SQLchamadoscli->execute();
$all_chamados += $SQLchamadoscli->rowCount();



?>
<!DOCTYPE html>
<html lang="pt_BR">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="CRAZY_VPN">
<!-- Favicon icon -->
<link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
<title>CRACKEDPENGUIN | Painel</title>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<!-- Bootstrap Core CSS -->
<link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">  <!-- Ionicons -->
<!-- chartist CSS -->
<link href="../assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
<link href="../assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
<link href="../assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
<!--This page css - Morris CSS -->
<link href="../assets/plugins/c3-master/c3.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="../material/css/style.css" rel="stylesheet">
<!-- You can change the theme colors from here -->
<link href="../material/css/colors/red-dark.css" id="theme" rel="stylesheet">
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
<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
        </div>
        <!-- Site wrapper -->
        <div class="modal fade" id="flaggeral" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="display: none;">
          <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                 <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-flag"></i> Alertar Todos!</h3>
             </div>
             <div class="modal-body">

                <!-- content goes here -->
                <form name="editaserver" action="pages/notificacoes/notificar_home.php" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tipo de Notificação </label>
                        <select size="1" name="clientes" class="form-control select2 col-lg-12">
                            <option value="1" selected=selected>Todos</option>
                            <option value="2">Revendedores</option>
                            <option value="3" >Clientes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mensagem</label>
                        <textarea class="form-control" name="msg" rows="3" cols="20" wrap="off" placeholder="Digite..."></textarea>
                    </div>
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
                   
                  <li class="nav-item dropdown">
                     <a data-toggle="modal" href="#flaggeral" class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-flag"></i></a>
                 </li>

                 <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-rocket"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                        <ul>
                            <li>
                                <div class="drop-title">Usuários Online </div>
                                <div class="message-center">
                <ul class="menu" id="usuarioson">

                </ul>
                            </li>
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
                                <a href="?page=notificacoes/notificacoes&ler=fatu">
                                    <div class="mail-contnet">
                                        <h5><i class="fas fa-file-invoice-dollar"></i> <?php echo $totalnoti_fatura;?>  Em Faturas</h5></div>
                                    </a>
                                    <a href="?page=notificacoes/notificacoes&ler=chamados">
                                        <div class="mail-contnet">
                                            <h5><i class="fas fa-ticket-alt"></i> <?php echo $totalnoti_chamados;?>  Em Chamados</h5></div>
                                        </a>											
                                    </div>
										<?php /*
										<?php if($usuario['tipo']=='revenda'){ ?>
										<li>
										<a href="?page=notificacoes/notificacoes&ler=reve">
										<i class="fa fa-users text-aqua"></i> <?php echo $totalnoti_revenda;?> Em Revendas
										</a>
										</li>
										<?php } ?>
										
										<li>
										<a href="?page=notificacoes/notificacoes&ler=others">
										<i class="fa fa-info-circle"></i> <?php echo $totalnoti_outros;?> Em Outros
										</a>
										</li>
										<?php */ ?>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="?page=notificacoes/notificacoes&ler=all"> <strong>Ver Todos</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../dist/img/user2-160x160.jpg" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image"></div>
                                            <div class="u-text">
                                                <h4><?php echo strtoupper($administrador['nome']);?></h4>
                                                <p class="text-muted">Administrador</p>
                                                <p class="text-muted">Ceo & Fundador</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="?page=admin/dados"><i class="ti-user"></i> Meu Perfil</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="?page=apis/gerenciar"><i class="ti-settings"></i> Configuração</a></li>
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
                <div class="user-profile" style="background: url(../assets/images/background/back.jpg) no-repeat center;">
                    <!-- User profile image -->
                    <div class="profile-img"><img src="../dist/img/user2-160x160.jpg" alt="user"/></div>
                    <!-- User profile text-->
                    <div class="profile-text"> <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><?php echo strtoupper($administrador['nome']);?></a>
                        <div class="dropdown-menu animated flipInY"> <a href="?page=admin/dados" class="dropdown-item"><i class="ti-user"></i> Meu Perfil</a> <a href="?page=email/enviaremail" class="dropdown-item"><i class="ti-email"></i> Email</a>
                            <div class="dropdown-divider"></div> <a href="?page=apis/gerenciar" class="dropdown-item"><i class="ti-settings"></i> Configuração</a>
                            <div class="dropdown-divider"></div> <a href="sair.php" class="dropdown-item"><i class="fa fa-power-off"></i> Sair</a> </div>
                        </div>
                    </div>

                    <!-- End User profile text-->
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="nav-small-cap">NAVEGACAO PRINCIPAL</li>
                            <li><a href="home.php" aria-expanded="false"><i class="fas fa-home"></i><span class="hide-menu">INICIO</span></a>
                            </li>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-greater-than-equal"></i><span class="hide-menu">CONTAS</span>&emsp;&emsp;&emsp;<span class="badge badge-success ml-auto"><?php echo $contas_ssh; ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="?page=ssh/adicionar"><i class="fas fa-terminal"></i> Criar conta SSH</a></li>
                                    <li><a href="?page=ssh/add_teste"><i class="fas fa-clock"></i> Criar teste SSH</a></li>
                                    <li ><a href="?page=ssh/contas"><i class="fas fa-list-ul"></i> Listar contas SSH</a></li>
                                    <li ><a href="?page=ssh/online"><i class="fas fa-rocket"></i> Contas SSH Online</a></li>
                                    <li ><a href="?page=ssh/erro"><i class="fas fa-exclamation-circle"></i> Contas com erro</a></li>
                                </ul>
                            </li>
                            <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-user"></i><span class="hide-menu">CLIENTES</span>&emsp;&emsp;&ensp;  <span class="badge badge-success ml-auto"><?php echo $all_usuarios_qtd; ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="?page=usuario/1-etapa"><i class="fas fa-user-plus"></i> Novo usuário</a></li>
                                    <li><a href="?page=usuario/revenda"><i class="fas fa-user-tie"></i> Revendedores SSH</a></li>
                                    <li><a href="?page=usuario/usuario_ssh"><i class="fas fa-user-shield"></i> Usuários vpn</a></li>
                                    <li><a href="?page=usuario/addservidor"><i class="fas fa-user-edit"></i> ADD Servidor</a></li>
                                </ul>
                            </li>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-server"></i><span class="hide-menu">SERVIDORES</span>&emsp;&nbsp;&nbsp;<span class="badge badge-success ml-auto"><?php echo $servidor_qtd; ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="?page=servidor/adicionar"><i class="fas fa-hdd"></i> Novo servidor</a></li>
                                    <li><a href="?page=servidor/listar"><i class="fas fa-list-ul"></i> Listar servidores</a></li>
                                    <li><a href="?page=servidor/alocados"><i class="fas fa-user-cog"></i> Servidores Alocados</a></li>
                                </ul>
                            </li>
                            <li class="nav-devider"></li>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-wallet"></i><span class="hide-menu">FATURAS</span>&emsp;&emsp;&ensp;&ensp;<span class="badge badge-success ml-auto"><?php echo $faturas; ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="?page=faturas/abertas"><i class="fas fa-file-invoice-dollar"></i> Abertas</a></li>
                                    <li><a href="?page=faturas/pagas"><i class="fas fa-file-powerpoint"></i> Pagas</a></li>
                                    <li><a href="?page=faturas/canceladas"><i class="fas fa-file-excel"></i> Canceladas</a></li>
                                    <li><a href="?page=faturas/comprovantes"><i class="fas fa-file-invoice"></i> Comprovantes</a></li>
                                    <li><a href="?page=faturas/cpfechados"><i class="fas fa-file-csv"></i> CP Fechados</a></li>
                                </ul>
                            </li>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-bell"></i><span class="hide-menu">CHAMADOS</span>&emsp;&ensp;<span class="badge badge-success ml-auto"><?php echo $all_chamados; ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="?page=chamados/abertas"><i class="fas fa-user-tag"></i> Abertas</a></li>
                                    <li><a href="?page=chamados/respondidos"><i class="fas fa-user-check"></i> Respondidas</a></li>
                                    <li><a href="?page=chamados/encerrados"><i class="fas fa-user-times"></i> Encerradas</a></li>
                                </ul>
                            </li>
                            <li class="nav-devider"></li>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fas fa-cog"></i><span class="hide-menu">CONFIGURACOES</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="?page=admin/dados"><i class="fas fa-user-tie"></i> Minhas Informações</a></li>
                                    <li><a href="?page=apis/gerenciar"><i class="fas fa-cog"></i> Gerenciar APIS</a></li>
                                    <li><a href="?page=notificacoes/notificar"><i class="fas fa-bell"></i> Notificações</a></li>
                                    <li><a href="?page=email/enviaremail"><i class="fas fa-envelope"></i> <span> Email</span></a></li>
                                    <li><a href="?page=download/downloads"><i class="fas fa-cloud"></i> <span> Arquivos </span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
                <div class="sidebar-footer">
                    <!-- item--><a href="?page=apis/gerenciar" class="link" data-toggle="tooltip" title="Configuracoes"><i class="ti-settings"></i></a>
                    <!-- item--><a href="?page=email/enviaremail" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
                    <!-- item--><a href="sair.php" class="link" data-toggle="tooltip" title="Sair"><i class="mdi mdi-power"></i></a>
                </div>
                <!-- Bottom points-->
               
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


                   ?>
                   
                   <!-- footer -->
                   <!-- ============================================================== -->
                   <footer class="footer"><center> © <script>document.write(new Date().getFullYear())</script> CRACKED<b>PENGUIN</b> </center></footer>
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
           <script src="../assets/plugins/jquery/jquery.min.js"></script>
           <!-- Bootstrap tether Core JavaScript -->
           <script src="../assets/plugins/bootstrap/js/popper.min.js"></script>
           <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
           
           <!-- slimscrollbar scrollbar JavaScript -->
           <script src="../material/js/jquery.slimscroll.js"></script>
           <!--Wave Effects -->
           <script src="../material/js/waves.js"></script>
           <!--Menu sidebar -->
           <script src="../material/js/sidebarmenu.js"></script>
           <!--stickey kit -->
           <script src="../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
           <script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
           
           <!--Custom JavaScript -->
           <script src="../material/js/custom.min.js"></script>
           <!-- ============================================================== -->
           <!-- This page plugins -->
           <!-- ============================================================== -->
           <!-- chartist chart -->
           <script src="../assets/plugins/chartist-js/dist/chartist.min.js"></script>
           <script src="../assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
           <!--c3 JavaScript -->
           <script src="../assets/plugins/d3/d3.min.js"></script>
           <script src="../assets/plugins/c3-master/c3.min.js"></script>
           <!-- Chart JS -->
           <script src="../material/js/dashboard1.js"></script>
           <!-- ============================================================== -->
           <!-- Style switcher -->
           <!-- ============================================================== -->
           <script src="../assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
           <script>
              $(function () {
                $("#example1").DataTable();
                $('#example2').DataTable({
                  "paging": true,
                  "lengthChange": false,
                  "searching": false,
                  "ordering": true,
                  "info": true,
                  "autoWidth": false
              });
            });
        </script>
        <script src="../plugins/select2/select2.full.min.js"></script>
        <script>
         $(document).ready(function ($) {
				//Initialize Select2 Elements
				$(".select2").select2();
			});
		</script>
    </body>
    </html>