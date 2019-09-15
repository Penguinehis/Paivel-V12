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
                            <li class="breadcrumb-item active">Abrir Chamado</li>
                        </ol>
                    </div>
                </div>
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    <center><h3 class="text-warning"><i class="fa fa-info-circle" ></i> Abrir Chamado! </h3> Geralmente Respondido em 1 hora...</center>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-ticket"></i> Chamado Suporte</h4>
                            </div>
                            <div class="card-body">
							    <form name="abrirchamado" action="pages/chamados/abrindo_chamado.php" method="POST" role="form">
                                    <div class="form-group">
                                        <label>Selecione um Servidor</label>
                                        <select size="1" class="form-control" name="tipo" required>
                                            <option value="1">Problema na SSH</option>
											<?php if($usuario['tipo']=='revenda'){?>
											<option value="2">Problema na Revenda</option>
											<?php } ?>
											<option value="3">Problema no Usuário</option>
											<option value="4">Problema Em Servidor</option>
											<option value="5">Outros/Faturas Problemas</option>
                                        </select>	
                                    </div>
                                    <div class="form-group">
                                        <label>Login/Servidor/ContaSSH</label>
                                        <input type="text" class="form-control" name="login" minlength="4" placeholder="Digite o Login ou o Servidor com Problemas" required> 
									</div>
                                    <div class="form-group">
                                        <label>Assunto</label>
                                        <input type="text" name="motivo" placeholder="Fale qual é o motivo Principal..." minlength="5" class="form-control" required> 
									</div>
                                    <div class="form-group">
                                        <label>Qual o Problema?</label>
                                        <textarea class="form-control" name="problema" placeholder="Fale mais sobre oquê está acontecento..." rows=5 cols=20 wrap="off" required></textarea> 
									</div>
										<input  type="hidden" class="form-control" id="diretorio" name="diretorio"  value="../../admin/home.php?page=ssh/adicionar">
										<input  type="hidden" class="form-control" id="owner" name="owner"  value="<?php echo $accessKEY;?>">
									<div class="form-group m-b-0">
										<div class="offset-sm-3 col-sm-9">
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