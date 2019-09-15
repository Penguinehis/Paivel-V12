<?php

if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
    exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="plugins/select2/select2.full.min.js"></script>
<script src="plugins/validator/validator.min.js"></script>
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/show-password/bootstrap-show-password.min.js"></script>
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
                <li class="breadcrumb-item active">Criar SSH</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-terminal"></i> Criar Conta SSH</h4>
                </div>
                <div class="card-body">                           
                    <form data-toggle="validator" action="../pages/system/conta.ssh.php" method="POST" role="form">
                        <div class="form-body">
                            <h3 class="card-title">Preencha todos os dados</h3>
                            <hr>
                            <div class="row p-t-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Selecione um Servidor</label>
                                        <select class="form-control custom-select" style="width: 100%;"  name="acesso_servidor" id="acesso_servidor">
                                            <option selected="selected">selecione</option>
                                            <?php
                                            $SQLAcesso= "select * from acesso_servidor WHERE id_usuario = '".$usuario['id_usuario']."' ";
                                            $SQLAcesso = $conn->prepare($SQLAcesso);
                                            $SQLAcesso->execute();
                                            if (($SQLAcesso->rowCount()) > 0) {
                                                        // output data of each row
                                                while($row_srv = $SQLAcesso->fetch()) {
                                                    $contas_ssh_criadas = 0;

                                                    $SQLServidor = "select * from servidor WHERE id_servidor = '".$row_srv['id_servidor']."' ";
                                                    $SQLServidor = $conn->prepare($SQLServidor);
                                                    $SQLServidor->execute();
                                                    $servidor = $SQLServidor->fetch();


                                                    $SQLContasSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '".$row_srv['id_servidor']."' and id_usuario='".$_SESSION['usuarioID']."' ";
                                                    $SQLContasSSH = $conn->prepare($SQLContasSSH);
                                                    $SQLContasSSH->execute();
                                                    $SQLContasSSH = $SQLContasSSH->fetch();
                                                    $contas_ssh_criadas += $SQLContasSSH['quantidade'];

                                                    $SQLSub= "select * from usuario WHERE id_mestre = '".$_SESSION['usuarioID']."' ";
                                                    $SQLSub = $conn->prepare($SQLSub);
                                                    $SQLSub->execute();

                                                    $resta=$row_srv['qtd']-$contas_ssh_criadas;

                                                    ?>
                                                    <option value="<?php echo $row_srv['id_acesso_servidor'];?>"> <?php echo $servidor['nome'];?> [<?php echo $servidor['ip_servidor'];?>]  Resta <?php echo $resta;?> de <?php echo $row_srv['qtd'];?></option>
                                                <?php }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Usuário Gerenciador da conta ssh</label>
                                        <select class="form-control custom-select" style="width: 100%;"  name="usuario" id="usuario">
                                            <option selected="selected" value="<?php echo $_SESSION['usuarioID']; ?>">Usuário Atual do Sistema</option>
                                            <?php
                                            $SQL = "SELECT * FROM usuario where id_mestre = '".$_SESSION['usuarioID']."'";
                                            $SQL = $conn->prepare($SQL);
                                            $SQL->execute();

                                            if (($SQL->rowCount()) > 0) {
                                // output data of each row
                                                while($row = $SQL->fetch()) {?>

                                                    <option value="<?php echo $row['id_usuario'];?>" ><?php echo $row['login'];?></option>

                                                <?php }
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Validade em Dias</label>
                                            <input type="number" name="dias" id="dias" class="form-control" placeholder="30" required>
                                            <small class="form-control-feedback">Tempo ate a expiracao</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                          <label class="control-label">Quantidade de Acesso</label>
                                          <input type="number" name="acessos" id="acessos" placeholder="1" class="form-control" required>
                                          <small>Limite de conexoes simutaneas</small>
                                      </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Login SSH</label>
                                            <input type="text" name="login_ssh" id="login_ssh" class="form-control" data-minlength="4" data-maxlength="32" placeholder="Digite o Login..." required="">
                                            <small>Mínimo 4 caracteres e no máximo 32!</small>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Senha SSH</label>
                                            <input type="password" min="4" max="32" class="form-control" name="senha_ssh"
                                            data-minlength="4" id="senha_ssh" placeholder="Digite a Senha" required="">
                                            <small>Mínimo 4 caracteres e no máximo 32!</small>
                                        </div>
                                    </div>
                                </div>

                            <input  type="hidden" class="form-control" id="diretorio" name="diretorio" value="../../home.php?page=ssh/adicionar">
                            <input  type="hidden" class="form-control" id="owner" name="owner" value="<?php echo $_SESSION['usuarioID'];?>">

                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">Salvar Registro</button>
                                <button type="reset" class="cancel btn btn-inverse">Limpar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>