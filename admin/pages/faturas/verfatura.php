<?php


if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
  exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

if(isset($_GET['id'])){

  $fatura_id=$_GET['id'];


  $SQLUPUser= "SELECT * FROM fatura where id='".$fatura_id."'";
  $SQLUPUser = $conn->prepare($SQLUPUser);
  $SQLUPUser->execute();

  $conta=$SQLUPUser->rowCount();
  if($conta==0){
    echo '<script type="text/javascript">';
    echo  'alert("Fatura não encontrada!");';
    echo  'window.location="home.php?page=faturas/abertas";';
    echo '</script>';

  }
  $fatu=$SQLUPUser->fetch();

                       //Datas

  $datacriado=$fatu['data'];
  $dataconvcriado = substr($datacriado, 0, 10);
  $partes = explode("-", $dataconvcriado);
  $ano = $partes[0];
  $mes = $partes[1];
  $dia = $partes[2];

  $datavenc=$fatu['datavencimento'];
  $datanv = substr($datavenc, 0, 10);
  $partes2 = explode("-", $datanv);
  $anov = $partes2[0];
  $mesv = $partes2[1];
  $diav = $partes2[2];

// Busca usuario
  $user= "SELECT * FROM usuario where id_usuario='".$fatu['usuario_id']."'";
  $user = $conn->prepare($user);
  $user->execute();
  $usufatu=$user->fetch();

// busca servidor

  $server= "SELECT * FROM servidor where id_servidor='".$fatu['servidor_id']."'";
  $server = $conn->prepare($server);
  $server->execute();
  $servidor=$server->fetch();

// busca conta
  if($fatu['tipo']=='vpn'){
    $acc= "SELECT * FROM usuario_ssh where id_usuario_ssh='".$fatu['conta_id']."'";
    $acc = $conn->prepare($acc);
    $acc->execute();
    $conta=$acc->fetch();

  }

//valores
  $desconto1=$fatu['desconto'];
  $desconto=number_format($fatu['desconto'], 2, ',', '.');
  $valor=number_format($fatu['valor'], 2, ',', '.');
  $total=ceil(($fatu['valor']*$fatu['qtd'])-$desconto1);
  $valorfinal=$fatu['valor'];
  $total=number_format($total, 2, ',', '.');


  switch($fatu['tipo']){
    case 'vpn':$tipo='Acesso VPN';break;
    case 'revenda':$tipo='Revenda';break;
    default:$tipo='Outros';break;
  }


}else{
  echo '<script type="text/javascript">';
  echo  'alert("Fatura Inexistente!");';
  echo  'window.location="home.php?page=faturas/abertas";';
  echo '</script>';
  exit;
}

// Sistema dos botões
if(isset($_GET['act'])){

  switch($_GET['act']){
    case '1':$vai='comfirma';break;
    case '2':$vai='cancela';break;
    case '3':$vai='deleta';break;
    default:$vai='erro';break;
  }

  if($vai=='erro'){
    echo '<script type="text/javascript">';
    echo  'alert("Erro na comfirmação!");';
    echo  'window.location="home.php?page=faturas/verfatura&id='.$fatu['id'].'";';
    echo '</script>';
    exit;
  }elseif($vai=='comfirma'){
//confirmando fatura
    $verifica= "SELECT * FROM fatura where id='".$fatura_id."'";
    $verifica = $conn->prepare($verifica);
    $verifica->execute();
    $verificado=$verifica->fetch();

    if($verificado['status']<>'pendente'){
      echo '<script type="text/javascript">';
      echo  'alert("Essa fatura não pode ser aceita!");';
      echo  'window.location="home.php?page=faturas/abertas";';
      echo '</script>';
      exit;
    }
//Verifica se tem comprovante
    $verificacp= "SELECT * FROM fatura_comprovantes where fatura_id='".$fatura_id."'";
    $verificacp = $conn->prepare($verificacp);
    $verificacp->execute();
    $cpconta=$verificacp->rowCount();
    if($cpconta>0){
      $comprovante=$verifica->fetch();
      $mudacp= "UPDATE fatura_comprovantes set status='fechado' where fatura_id='".$fatura_id."'";
      $mudacp = $conn->prepare($mudacp);
      $mudacp->execute();
    }
//fim


//modifica fatura
    $modificafatura= "UPDATE fatura SET status='pago' where id='".$fatura_id."'";
    $modificafatura = $conn->prepare($modificafatura);
    $modificafatura->execute();
//insere notificacao
    $usuarion=$fatu['usuario_id'];
    $data=date('Y-m-d H:i:s');
    $msg="A Fatura <b><small>#".$fatu['id']."</small></b> foi aprovada com sucesso!";
    $notificacao= "INSERT INTO notificacoes (usuario_id,data,tipo,linkfatura,mensagem) values ('".$usuarion."','".$data."','fatura','faturas/pagas','".$msg."')";
    $notificacao = $conn->prepare($notificacao);
    $notificacao->execute();

    echo '<script type="text/javascript">';
    echo  'alert("Fatura Aprovada com sucesso!");';
    echo  'window.location="home.php?page=faturas/abertas";';
    echo '</script>';

  }elseif($vai=='cancela'){

//Cancelando
    $verifica= "SELECT * FROM fatura where id='".$fatura_id."'";
    $verifica = $conn->prepare($verifica);
    $verifica->execute();
    $verificado=$verifica->fetch();

    if($verificado['status']<>'pendente'){
      echo '<script type="text/javascript">';
      echo  'alert("Essa fatura não pode ser cancelada!");';
      echo  'window.location="home.php?page=faturas/abertas";';
      echo '</script>';
      exit;
    }
//Verifica se tem comprovante
    $verificacp= "SELECT * FROM fatura_comprovantes where fatura_id='".$fatura_id."'";
    $verificacp = $conn->prepare($verificacp);
    $verificacp->execute();
    $cpconta=$verificacp->rowCount();
    if($cpconta>0){
      $comprovante=$verifica->fetch();
      $mudacp= "UPDATE fatura_comprovantes set status='fechado' where fatura_id='".$fatura_id."'";
      $mudacp = $conn->prepare($mudacp);
      $mudacp->execute();
    }
//fim
//modifica fatura
    $modificafatura= "UPDATE fatura SET status='cancelado' where id='".$fatura_id."'";
    $modificafatura = $conn->prepare($modificafatura);
    $modificafatura->execute();
//insere notificacao
    $usuarion=$fatu['usuario_id'];
    $data=date('Y-m-d H:i:s');
    $msg="A Fatura <small><b>#".$fatu['id']."</b></small> foi cancelada!";
    $notificacao= "INSERT INTO notificacoes (usuario_id,data,tipo,linkfatura,mensagem) values ('".$usuarion."','".$data."','fatura','faturas/canceladas','".$msg."')";
    $notificacao = $conn->prepare($notificacao);
    $notificacao->execute();

    echo '<script type="text/javascript">';
    echo  'alert("Fatura Cancelada!");';
    echo  'window.location="home.php?page=faturas/abertas";';
    echo '</script>';

  }elseif($vai=='deleta'){


//Verifica se tem comprovante
    $verificacp= "SELECT * FROM fatura_comprovantes where fatura_id='".$fatura_id."'";
    $verificacp = $conn->prepare($verificacp);
    $verificacp->execute();
    $cpconta=$verificacp->rowCount();
    if($cpconta>0){
      $comprovante=$verificacp->fetch();
      $arquivo = "../../painelssh/admin/pages/faturas/comprovantes/".$comprovante['imagem']."";
      if (!unlink($arquivo)){
       echo '<script type="text/javascript">';
       echo  'alert("Arquivo não encontrado!");';
       echo  'window.location="home.php?page=faturas/abertas";';
       echo '</script>';
       exit;

     }else{
//Deleta
      $modificafatura= "DELETE FROM fatura where id='".$fatura_id."'";
      $modificafatura = $conn->prepare($modificafatura);
      $modificafatura->execute();
      $mudacp= "DELETE FROM fatura_comprovantes where fatura_id='".$fatura_id."'";
      $mudacp = $conn->prepare($mudacp);
      $mudacp->execute();
      echo '<script type="text/javascript">';
      echo  'alert("Fatura Deletada!");';
      echo  'window.location="home.php?page=faturas/abertas";';
      echo '</script>';
    }
  }else{
//fim
//Deleta
    $modificafatura= "DELETE FROM fatura where id='".$fatura_id."'";
    $modificafatura = $conn->prepare($modificafatura);
    $modificafatura->execute();

    echo '<script type="text/javascript">';
    echo  'alert("Fatura Deletada!");';
    echo  'window.location="home.php?page=faturas/abertas";';
    echo '</script>';

  }

}




}


?>
<div class="container-fluid">
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
      <h3 class="text-themecolor">CRACKED<b>PENGUIN</b></h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home.php">Início</a></li>
        <li class="breadcrumb-item active">Abertas</li>
      </ol>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card card-body printableArea">
        <h3><b>CRACKEDPENGUIN</b><span class="pull-right">Fatura N°#<?php echo $fatu['id']; ?></span></h3>
        <small>Data: <?php echo $dia;?>/<?php echo $mes;?>/<?php echo $ano;?></small><br>
        <h6 class="card-subtitle">Nota: Anexe um Print do Comprovante para agilizar o processo.</h6>
        <div class="row">
          <div class="col-md-12">
            <div class="pull-left">
              <address>
                <h3> &nbsp;<b class="text-danger">CRACKEDPENGUIN, Inc.</b></h3>
                <p class="text-muted m-l-5">Sao Paulo, SP
                  <br/> Telefone: (11) 9293-7539
                  <br/> Email: crzvpn@@gmail.com
                  <br/> Telegram: @crazy_vpn</p>
                  <div class="col-xs-6"><br>
                    <p class="lead">Formas de Pagamento:</p>
                    <img src="../../dist/img/credit/visa.png" alt="Visa">
                    <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                    <img src="../../dist/img/credit/american-express.png" alt="American Express">
                    <img src="../../dist/img/credit/hipercard.png" alt="Hipercard">
                    <img src="../../dist/img/credit/caixa.png" alt="Caixa">
                    <img src="../../dist/img/credit/mp.png" alt="Mercado Pago">
                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                     Depósito e Transfêrencia Bancaria<br>
                     •Conta: 00001276-6<br>•Agencia: 3570<br>•Operação: 023<br>•Nome Dimas<br> 
                     <br>(OBS: Enviar a confirmação com o print do comprovante.)<br>
                   </p>
                 </div>
              </address>
             </div>
             <div class="pull-right text-right">
              <address>
                <h3>Para,</h3>
                <h4 class="font-bold"><?php echo $usufatu['nome'];?></h4>
                <p class="text-muted m-l-30">
                  <br/> Telefone: <?php echo $usufatu['celular'];?>
                  <br/> Email: <?php echo $usufatu['email'];?>
                </p>
                <p class="m-t-30"><b>Fatura #</b> <?php echo $fatu['id']; ?></p>
                <p><b>Vencimento:</b> <i class="fa fa-calendar"></i> <?php echo $diav;?>/<?php echo $mesv;?>/<?php echo $anov;?></p>
                <p><?php if($fatu['servidor_id']<>0){?><b>Servidor:</b> <i class="fa fa-calendar"></i> <?php echo $servidor['ip_servidor'];?> (<?php echo $servidor['nome'];?>)<?php } ?></p>
                <p><?php if($fatu['conta_id']<>0){?></p>
                <p><?php if($fatu['tipo']=='vpn'){ ?></p>
                <p><b>Conta:</b> <i class="fa fa-calendar"></i><?php echo $conta['login'];?></p>
              <?php } } ?>
            </address>
          </div>
        </div>
        <div class="col-md-12">
          <div class="table-responsive m-t-40" style="clear: both;">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center">Qtd</th>
                  <th>Produto</th>
                  <th class="text-right">Tipo</th>
                  <th class="text-right">Descrição</th>
                  <th class="text-right">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center"><?php echo $fatu['qtd'];?></td>
                  <td>Contas SSH</td>
                  <td class="text-right"> <?php echo $tipo;?> </td>
                  <td class="text-right"> <?php echo $fatu['descrição'];?></td>
                  <td class="text-right"> R$<?php echo $total;?> </td>
                </tr>
              </tr>
            </tbody>
          </table>
        </div>
      </div>    
      <div class="col-md-12">
        <div class="pull-right m-t-30 text-right">
        <div class="text-right">
        <a onclick="window.print();"  class="btn btn-primary"><font color="white"><i class="fa fa-print"></i> Print</font></a>

          <script type="text/javascript">
            function excluir_fatura(){
              decisao = confirm("Tem certeza que vai excluir?!");
              if (decisao){
               window.location.href='home.php?page=faturas/verfatura&id=<?php echo $fatu['id'];?>&act=3'
             } else {

             }

           }
         </script>
         <button type="button" onclick="excluir_fatura()" class="btn btn-danger"><i class="fa fa-trash-o"></i> Excluir
         </button>
         <?php if($fatu['status']=='pendente'){ ?>
          <button type="button" onclick="window.location.href='home.php?page=faturas/verfatura&id=<?php echo $fatu['id'];?>&act=1'" class="btn btn-success" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Confirmar
          </button>
          <button type="button" onclick="window.location.href='home.php?page=faturas/verfatura&id=<?php echo $fatu['id'];?>&act=2'" class="btn btn-warning" style="margin-right: 5px;">
            <i class="fa fa-times-circle"></i> Cancelar
          </button>
        <?php }elseif($fatu['status']=='pago'){ ?>
          <h3 class="pull-right" style="margin-right: 5px;">Fatura Paga</h3>
        <?php }elseif($fatu['status']=='cancelado'){ ?>
          <h4 class="pull-right" style="margin-right: 5px;">Fatura Cancelada</h4>
        <?php } ?>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>