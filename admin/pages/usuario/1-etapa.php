<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<script language="JavaScript">
<!--
function desabilitar(){
with(document.form){
qtd_ssh.disabled=true;
}
}
function habilitar(){
with(document.form){

qtd_ssh.disabled=false;

}
}
// -->
$('.radiosbordas').click(function() {
  $('.hli').removeClass('hli');
  $(this).addClass('hli').find('input').prop('checked', true)
});
</script>
<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../plugins/select2/select2.full.min.js"></script>
<script src="../plugins/validator/validator.min.js"></script>
<script src="../plugins/input-mask/jquery.inputmask.js"></script>
<script src="../plugins/show-password/bootstrap-show-password.min.js"></script>
<script>
$(document).ready(function ($) {
	//Initialize Select2 Elements
	$(".select2").select2();
			});
</script>

<!-- Main content -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor"><a href="home.php">CRACKED<b>PENGUIN</a></b></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                            <li class="breadcrumb-item active">Criar</li>
                        </ol>
                    </div>
                </div>
				 <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-user-plus"></i> Adicionar Usuario ao Painel</h4>
                            </div>
                            <div class="card-body">
                                <form data-toggle="validator" action="pages/usuario/adicionar_exe.php" method="POST" role="form">
                                    <div class="form-body">
                                        <h3 class="card-title">Preencha todos os campos</h3>
                                        <hr>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">                                            
                                                    <label class="control-label">Nome</label>
                                                    <input type="text" name="nome" id="nome" class="form-control" minlength="4" placeholder="Digite o Nome ..." required> 
                                                    <small class="form-control-feedback">Mínimo 4 caracteres e no máximo 32</small> </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Celular</label>
                                                    <input type="text" name="celular" id="celular" placeholder="Digite os 11 Digítos..." value="(11) 99999-9999" class="form-control" minlength="4" maxlength="16" required>
                                                    
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">                                            
                                                    <label class="control-label">Login</label>
                                                    <input type="text" name="login" id="login" class="form-control" minlength="4" placeholder="Digite o Login..." required="">
                                                    <small class="form-control-feedback">Login de Acesso ao Painel</small> </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Senha</label>
                                                    <input type="password" min="4" max="32" class="form-control"  name="senha" data-minlength="4" id="senha" placeholder="Digite a Senha..." required>
                                                    <small class="form-control-feedback">Mínimo 4 caracteres e no máximo 32</small> </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label></label>
                                                    <div class="input-group">
                                                        <ul class="icheck-list">
                                                            <li>
                                                                <input type="radio" class="check" id="radio1" name="tipo" value="revenda" data-radio="iradio_flat-red">
                                                                <label for="radio1">Revendedor</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" class="check" id="radio2" name="tipo" value="vpn" checked data-radio="iradio_flat-red">
                                                                <label for="radio2">Usuário VPN</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <!--/span-->
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Adicionar</button>
                                        <button type="button" class="btn btn-inverse">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
			</div>
