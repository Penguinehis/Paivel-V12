<?php
$procnoticias= "select * FROM noticias where status='ativo'";
$procnoticias = $conn->prepare($procnoticias);
$procnoticias->execute();

if($usuario['tipo']=='revenda'){
        // Clientes
    $SQLbuscaclientes= "select * from usuario where tipo='vpn' and id_mestre='".$usuario['id_usuario']."'";
    $SQLbuscaclientes = $conn->prepare($SQLbuscaclientes);
    $SQLbuscaclientes->execute();
    $totalclientes = $SQLbuscaclientes->rowCount();

         // Servidores
    $SQLbuscaservidores= "select * from acesso_servidor where id_usuario='".$usuario['id_usuario']."'";
    $SQLbuscaservidores = $conn->prepare($SQLbuscaservidores);
    $SQLbuscaservidores->execute();
    $servidoresclientes = $SQLbuscaservidores->rowCount();

        // Cotas
    $totaldecotas=0;
    $SQLbuscacontasssh= "select sum(qtd) as cotas from acesso_servidor where id_usuario='".$usuario['id_usuario']."'";
    $SQLbuscacontasssh = $conn->prepare($SQLbuscacontasssh);
    $SQLbuscacontasssh->execute();
    $minhascotas = $SQLbuscacontasssh->fetch();
    $totaldecotas+=$minhascotas['cotas'];


}else{
        // Contas
    $SQLbuscacontinhas= "select * from usuario_ssh where id_usuario='".$usuario['id_usuario']."'";
    $SQLbuscacontinhas = $conn->prepare($SQLbuscacontinhas);
    $SQLbuscacontinhas->execute();
    $totalcontas = $SQLbuscacontinhas->rowCount();

        // Cotas
    $totaldecotas2=0;
    $SQLbuscacontasssh2= "select sum(acesso) as cotas from usuario_ssh where id_usuario='".$usuario['id_usuario']."'";
    $SQLbuscacontasssh2 = $conn->prepare($SQLbuscacontasssh2);
    $SQLbuscacontasssh2->execute();
    $minhascotas2 = $SQLbuscacontasssh2->fetch();
    $totaldecotas2+=$minhascotas2['cotas'];

        // Faturas
    if($usuario['id_mestre']==0){
        $SQLbuscafaturinhas= "select * from fatura where usuario_id='".$usuario['id_usuario']."' and status='pendente'";
        $SQLbuscafaturinhas = $conn->prepare($SQLbuscafaturinhas);
        $SQLbuscafaturinhas->execute();
        $minhasfatu = $SQLbuscafaturinhas->rowCount();
    }else{
        // Faturas
        $SQLbuscafaturinhas= "select * from fatura_clientes where usuario_id='".$usuario['id_usuario']."' and status='pendente'";
        $SQLbuscafaturinhas = $conn->prepare($SQLbuscafaturinhas);
        $SQLbuscafaturinhas->execute();
        $minhasfatu = $SQLbuscafaturinhas->rowCount();

    }




}

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
        <center><h3><i class="fas fa-user-tie" ></i> Bem-vindoª</center>
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
                        <div class="round round-lg align-self-center round-info"><i class="fas fa-rocket"></i></div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0 font-light"><?php echo $total_acesso_ssh_online; ?></h3>
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
                            <div class="round round-lg align-self-center round-warning"><i class="fas fa-terminal"></i></div>
                            <div class="m-l-10 align-self-center">
                                <h3 class="m-b-0 font-lgiht"><?php echo $quantidade_ssh; ?></h3>
                                <h5 class="text-muted m-b-0">Contas</h5></div>
                            </div>
                        </div>
                    </div></a>
                </div>
                <!-- Column -->
                <?php if(($usuario['tipo']=="revenda") and ($usuario['subrevenda']=='nao') ){?>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card"><a href="home.php?page=subrevenda/revendedores">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-primary"><i class="fas fa-users"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht"><?php echo $quantidade_sub_revenda; ?></h3>
                                        <h5 class="text-muted m-b-0">Revendedores</h5></div>
                                    </div>
                                </div>
                            </div></a>
                        </div>
                        <!-- Column -->
                    <?php }?>
                    <?php if($usuario['tipo']=="revenda"){?>
                        <!-- Column -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card"><a href="home.php?page=usuario/listar">
                                <div class="card-body">
                                    <div class="d-flex flex-row">
                                        <div class="round round-lg align-self-center round-danger"><i class="fas fa-user"></i></div>
                                        <div class="m-l-10 align-self-center">
                                            <h3 class="m-b-0 font-lgiht"><?php echo $quantidade_sub; ?></h3>
                                            <h5 class="text-muted m-b-0">Clientes</h5></div>
                                        </div>
                                    </div>
                                </div></a>
                            </div>
                            <!-- Column -->
                        <?php }?>
                        <?php if(($usuario['tipo']=="revenda") and ($acesso_servidor > 0) ){?>
                            <!-- Column -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card"><a href="home.php?page=servidor/meuservidor">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="round round-lg align-self-center round-warning"><i class="fas fa-server"></i></div>
                                            <div class="m-l-10 align-self-center">
                                                <h3 class="m-b-0 font-light"><?php echo $acesso_servidor; ?></h3>
                                                <h5 class="text-muted m-b-0">Servidores</h5></div>
                                            </div>
                                        </div>
                                    </div></a>
                                </div>
                                <!-- Column -->
                            <?php }?>
                            <!-- Column -->
                            <div class="col-lg-3 col-md-6">
                                <div class="card"><a href="home.php?page=downloads/downloads">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="round round-lg align-self-center round-primary"><i class="fas fa-download"></i></div>
                                            <div class="m-l-10 align-self-center">
                                                <h3 class="m-b-0 font-lgiht"><?php echo $todosarquivos; ?></h3>
                                                <h5 class="text-muted m-b-0">Arquivos</h5></div>
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
                                                <div class="round round-lg align-self-center round-info"><i class="fas fa-file-invoice-dollar"></i></div>
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
                                                    <div class="round round-lg align-self-center round-danger"><i class="fas fa-info-circle"></i></div>
                                                    <div class="m-l-10 align-self-center">
                                                        <h3 class="m-b-0 font-lgiht"><?php echo $all_chamados;?></h3>
                                                        <h5 class="text-muted m-b-0">Chamados</h5></div>
                                                    </div>
                                                </div>
                                            </div></a>
                                        </div>
                                        <!-- Column -->
                                        <?php if($usuario['tipo']=='revenda'){ ?>
                                            <!-- Column -->
                                            <div class="col-lg-3 col-md-6">
                                                <div class="card"><a href="home.php?page=faturasclientes/abertas">
                                                    <div class="card-body">
                                                        <div class="d-flex flex-row">
                                                            <div class="round round-lg align-self-center round-primary"><i class="fas fa-file-invoice-dollar"></i></div>
                                                            <div class="m-l-10 align-self-center">
                                                                <h3 class="m-b-0 font-lgiht"><?php echo $faturas_clientes; ?></h3>
                                                                <h5 class="text-muted m-b-0">Faturas<br>Clientes</h5></div>
                                                            </div>
                                                        </div>
                                                    </div></a>
                                                </div>
                                                <!-- Column -->
                                                <!-- Column -->
                                                <div class="col-lg-3 col-md-6">
                                                    <div class="card"><a href="home.php?page=chamadosclientes/abertas">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-row">
                                                                <div class="round round-lg align-self-center round-danger"><i class="fas fa-info-circle"></i></div>
                                                                <div class="m-l-10 align-self-center">
                                                                    <h3 class="m-b-0 font-lgiht"><?php echo $all_chamados_clientes;?></h3>
                                                                    <h5 class="text-muted m-b-0">Chamados<br>Clientes</h5></div>
                                                                </div>
                                                            </div>
                                                        </div></a>
                                                    </div>
                                                    <!-- Column -->
                                                <?php } ?>
                                            </div>
                                        </div>
