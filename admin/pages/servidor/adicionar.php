<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../plugins/show-password/bootstrap-show-password.min.js"></script>
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
                            <li class="breadcrumb-item active">Adicionar</li>
                        </ol>
                    </div>
                </div>

<section class="content">
<script>
function ValidateIPaddress(inputText)
 {
 var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
 if(inputText.value.match(ipformat))
 {
 document.form1.ip.focus();
 return true;
 }
 else
 {
 alert("Endereço IP Invalido!");
 document.form1.ip.focus();<br>return false;
 }
 }
</script>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-server"></i> Adicionar Servidor ao Painel</h4>
                            </div>
                            <div class="card-body">
                                <form action="pages/servidor/adicionar_exe.php" method="POST" enctype="multipart/form-data" role="form">
                                    <div class="form-body">
                                        <h3 class="card-title">Informe todos os dados</h3>
                                        <hr>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">                                            
                                                    <label class="control-label">Nome</label>                                                                  
                                                    <input type="text" id="nomesrv" name="nomesrv" class="form-control" minlength="4" placeholder="Ex: Brasil-1" required>
                                                    <small class="form-control-feedback">Nome para identificacao do servidor</small> </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Endereço de IP</label>
                                                    <input type="text" name="ip" id="ip" class="form-control" minlength="4" placeholder="Digite o IP" required>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Login Root</label>
                                                    <input type="text" name="login" id="login" value="root" class="form-control" required>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Senha Root</label>
                                                    <input type="password" min="6" max="32" class="form-control"  name="senha" data-minlength="6" id="senha" placeholder="Digite a Senha" required>                                                  
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Região Global</label>
                                                    <select class="form-control custom-select" name="regiao" data-placeholder="Selecione a regiao" tabindex="1">
                                                        <option value="1">Asia</option>
                                                        <option value="2">America</option>
                                                        <option value="3">Europa</option>
                                                        <option value="4">Australia</option>
                                                    </select>
                                                </div>
                                            </div>                                      
                                            <div class="col-md-6 ">
                                                <div class="form-group">
                                                    <label>Localização</label>
                                                    <input type="text" name="localiza" id="localiza" placeholder="Ex: São Paulo" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Hostname</label>
                                                    <input type="text" name="siteserver" id="siteserver" value="Seusite.com" class="form-control" required>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Validade</label>
                                                    <input type="number" name="validade" id="validade" placeholder="Ex: 1000" class="form-control" required>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Limite</label>
                                                    <input type="number" name="limite" id="limite" placeholder="Ex: 1000" class="form-control" required>
                                                </div>
                                            </div>                                          
                                            <!--/span-->
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Adicionar</button>
                                        <button type="button" class="btn btn-inverse">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
</section>
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