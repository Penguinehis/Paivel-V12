<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="msapplication-TileColor" content="#ef2a55">
	<meta name="theme-color" content="#ef2a55">
    <meta name="description" content="">
    <meta name="author" content="Crazy_vpn">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>CRACKEDPENGUIN | Entrar</title>
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="lineModalLabel"><i class="fas fa-envelope-open-text"></i> Recuperar Acesso</h4>
                </div>
                <div class="modal-body">
                    <!-- content goes here -->
                    <form name="recupera" action="recuperando.php" method="post">
                        <div class="form-group">
                            <center><label for="exampleInputPassword1"><b>Informe o E-mail</label></center>
                            <input type="text" class="form-control" name="email" placeholder="Digite...">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-inverse" data-dismiss="modal" role="button">Cancelar</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
        <div class="login-register" style="background-image: linear-gradient(0deg, #ffffff, #ef2a55);">        
            <div class="login-box card">
                <div class="card-body">
                    <form action="validacao.php" method="post">
                        <form class="form-horizontal form-../material" id="loginform" action="home.php">
                            <center><h3><i class="fab fa-linux"></i> CRACKED<b>PENGUIN</b></h3></center>
                            <div class="form-group ">
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" required="required" id="login" name="login" placeholder="Usuario">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input class="form-control" type="password" required="required" id="senha" name="senha" placeholder="Senha">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="checkbox checkbox-primary pull-left p-t-0">
                                        <input id="checkbox-signup" type="checkbox">
                                        <label for="checkbox-signup"> Salvar </label>
                                    </div><a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Esqueceu?</a>
                                </div>
                            </div>
                            <div class="form-group text-center m-t-20">
                                <div class="col-xs-12"><br>
                                    <button class="btn btn-danger btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Entrar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                                    <div class="social">
                                        <a href="../index.php" class="btn btn-circle btn-primary" data-toggle="tooltip" title="Area do Usúario"> <i aria-hidden="true" class="fas fa-user"></i></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </form>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <p>
                              &copy;
                              <script>
                                document.write(new Date().getFullYear())
                            </script>
                            Todos Direitos Reservados <a href="https://t.me/sshplus" class="text-info m-l-5"><b>CRACKEDPENGUIN</b></a></p>
                        </div>
                    </div>
        
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../../assets/plugins/jquery/jquery.min.js"></script>
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
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
	<script>
	$(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
		});
	});
	</script>
	<script>
	function myFunction() {
		var x = document.getElementById("senha");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	}
	</script>
	<script type="text/javascript">
    $().ready(function() {
        demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
	</script>
</body>

</html