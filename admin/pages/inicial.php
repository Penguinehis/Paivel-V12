<?php
$procnoticias= "select * FROM noticias where status='ativo'";
$procnoticias = $conn->prepare($procnoticias);
$procnoticias->execute();


        // Clientes
        $SQLbuscaclientes= "select * from usuario where tipo='vpn'";
        $SQLbuscaclientes = $conn->prepare($SQLbuscaclientes);
        $SQLbuscaclientes->execute();
        $totalclientes = $SQLbuscaclientes->rowCount();
        // Revendedores
        $SQLbuscarevendedores= "select * from  usuario where tipo='revenda'";
        $SQLbuscarevendedores = $conn->prepare($SQLbuscarevendedores);
        $SQLbuscarevendedores->execute();
        $totalrevendedores = $SQLbuscarevendedores->rowCount();
        // Servidores
        $SQLbuscaservidores= "select * from  servidor";
        $SQLbuscaservidores= $conn->prepare($SQLbuscaservidores);
        $SQLbuscaservidores->execute();
        $totalservidores = $SQLbuscaservidores->rowCount();

?>
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor"><a href="home.php">CRACKED<b>PENGUIN</a></b></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                <center><h3><i class="fas fa-user-tie" ></i> Bem-Vindoª</center>
            </div>

     <!-- Noticias -->
    <?php if($procnoticias->rowCount()>0){
     $noticia=$procnoticias->fetch();

    $datapega=$noticia['data'];
    $data = date('D',strtotime($datapega));
    $mes = date('M',strtotime($datapega));
    $dia = date('d',strtotime($datapega));
    $ano = date('Y',strtotime($datapega));

    $semana = array(
        'Sun' => 'Domingo',
        'Mon' => 'Segunda-Feira',
        'Tue' => 'Terça-Feira',
        'Wed' => 'Quarta-Feira',
        'Thu' => 'Quinta-Feira',
        'Fri' => 'Sexta-Feira',
        'Sat' => 'Sábado'
    );

    $mes_extenso = array(
        'Jan' => 'Janeiro',
        'Feb' => 'Fevereiro',
        'Mar' => 'Marco',
        'Apr' => 'Abril',
        'May' => 'Maio',
        'Jun' => 'Junho',
        'Jul' => 'Julho',
        'Aug' => 'Agosto',
        'Nov' => 'Novembro',
        'Sep' => 'Setembro',
        'Oct' => 'Outubro',
        'Dec' => 'Dezembro'
    );


     ?>
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                <center>
				<h3 class="text-info"><i class="fa fa-bullhorn"></i> <?php echo $noticia['titulo'];?> </h3> <i class="fa fa-info"></i> 
				<?php echo $noticia['subtitulo'];?> <br/>
				<?php echo $noticia['msg'];?><br/>
				<?php echo $semana["$data"] . ", {$dia} de " . $mes_extenso["$mes"] . " de {$ano}";;?>		
				</center>
            </div>
			<?php } ?>

                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card"><a href="home.php?page=ssh/online">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-info"><i class="fa fa-rocket"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-light"><b><?php echo $total_acesso_ssh_online; ?></b></h3>
                                        <h5 class="text-muted m-b-0">Online</h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card"><a href="home.php?page=ssh/contas">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-warning"><i class="fa fa-terminal"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?php echo $contas_ssh;?></h3>
                                        <h5 class="text-muted m-b-0">Contas</h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card"><a href="home.php?page=ssh/contas">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-primary"><i class="fa fa-code"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?php echo $total_acesso_ssh;?></h3>
                                        <h5 class="text-muted m-b-0">Acessos</h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card"><a href="home.php?page=usuario/usuario_ssh">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-danger"><i class="fas fa-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?php echo $all_usuarios_vpn_qtd;?></h3>
                                        <h5 class="text-muted m-b-0">Clientes</h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card"><a href="home.php?page=usuario/revenda">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-warning"><i class="fas fa-users"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?php echo $all_usuarios_revenda_qtd;?></h3>
                                        <h5 class="text-muted m-b-0">Revendedores</h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card"><a href="home.php?page=servidor/listar">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-info"><i class="fas fa-server"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?php echo $servidor_qtd; ?></h3>
                                        <h5 class="text-muted m-b-0">Servidores</h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card"><a href="home.php?page=faturas/abertas">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-warning"><i class="fas fa-file-invoice-dollar"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?php echo $faturas; ?></h3>
                                        <h5 class="text-muted m-b-0">Faturas</h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card"><a href="home.php?page=chamados/abertas">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-primay"><i class="fas fa-info-circle"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?php echo $all_chamados;?></h3>
                                        <h5 class="text-muted m-b-0">Chamados</h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card"><a href="home.php?page=download/downloads">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-primary"><i class="fas fa-cloud"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?php echo $todosarquivos; ?></h3>
                                        <h5 class="text-muted m-b-0">Downloads</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card"><a href="home.php?page=ssh/contas">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-danger"><i class="fa fa-warning"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-light"><?php echo $ssh_susp_qtd;?></h3>
                                        <h5 class="text-muted m-b-0">Contas SSH<br>Suspensas</h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card"><a href="home.php?page=usuario/revenda">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-danger"><i class="fa fa-warning"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?php echo $revenda_qtd_susp;?></h3>
                                        <h5 class="text-muted m-b-0">Revendedores<br>Suspensos</h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card"><a href="home.php?page=usuario/revenda">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-danger"><i class="fa fa-warning"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?php echo $all_usuarios_vpn_qtd_susp;?></h3>
                                        <h5 class="text-muted m-b-0">Clientes SSH<br>Suspensos</h5></div>
                                </div>
                            </div>
                        </div></a>
                    </div>
                    <!-- Column -->
                </div>
            </div>
