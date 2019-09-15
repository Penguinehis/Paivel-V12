<?php

if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
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
                <li class="breadcrumb-item active">Adicionar usuário</li>
            </ol>
        </div>
    </div>
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="plugins/validator/validator.min.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.js"></script>
    <script src="plugins/show-password/bootstrap-show-password.min.js"></script>
    <script>
       $(document).ready(function ($) {
			 //$("[data-mask]").inputmask();
			 //Inputmask().mask(document.querySelectorAll("input"));
        $('#celular').inputmask("(11) 999[9]9999");  //static mask
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><i class="fa fa-user"></i> Adicionar Usuario ao Painel</h4>
            </div>
            <div class="card-body">
                <form data-toggle="validator" action="pages/system/funcoes.usuario.php" method="GET" role="form">
                    <div class="form-body">
                        <h3 class="card-title">Preencha todos os dados</h3>
                        <hr>
                        <form data-toggle="validator" action="pages/system/funcoes.usuario.php" method="GET" role="form">
                            <form class="form-horizontal m-t-40">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" name="nome" id="nome" class="form-control" minlength="4" placeholder="Digite o Nome..." required>
                                </div>
                                <div class="form-group">
                                    <label>Celular</label>
                                    <input type="text" name="celular" id="celular" placeholder="Digite os 11 Digítos..." value="(11) 99999-9999" class="form-control" minlength="8" maxlength="16" required>
                                </div>
                                <div class="form-group">
                                    <label>Login</label>
                                    <input type="text" name="login" id="login" class="form-control" data-minlength="4" data-maxlength="32" placeholder="Digite o Login..." required="">
                                    <small>Mínimo 4 caracteres e no máximo 32!</small>
                                </div>
                                <div class="form-group">
                                    <label>Senha</label>
                                    <input type="password" min="4" max="32" class="form-control"  name="senha" data-minlength="6" id="senha"  placeholder="Digite a Senha..." required>
                                    <small>Mínimo 4 caracteres e no máximo 32!</small>
                                </div>
                                <!-- column -->
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <div class="radiosanimados">
                                          <input type="hidden" class="form-control" id="owner" name="owner" value="<?php echo $_SESSION['usuarioID']; ?>">
                                          <input type="hidden" class="form-control" id="diretorio" name="diretorio"  value="../../home.php">
                                          <input type="hidden" class="form-control" id="op" name="op"  value="new">
                                          <?php if($usuario['subrevenda']<>'sim'){ ?>
                                              <eae class="radiosbordas descricao" title="<b>SUB-Revendedor</b>:<br /><small>*Pode Vender SSH<br />*Pode Criar Contas Usuarios VPN</small>"><input id="radio1" type="radio" name="tipo" value="1"><label for="radio1"><span><span></span></span>Sub-Revendedor </eae></label>
                                          <?php } ?>
                                          <eae class="radiosbordas descricao" title="<b>Usuário VPN</b>:<br />*Acesso Comum VPN"><input id="radio2" type="radio" name="tipo" value="2"><label for="radio2"><span><span></span></span>Usuário VPN</eae></label>
                                      </div>
                                  </div>
                              </div>
                              <!-- column -->
                              <div class="form-actions">
                                <button type="submit" class="btn btn-success">Salvar Registro</button>
                                <button type="reset" class="btn btn-inverse">Limpar</button>
                            </div>
                        </form>
                    </form>
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

