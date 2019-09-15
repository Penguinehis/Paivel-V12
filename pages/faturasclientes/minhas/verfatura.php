<script type="text/javascript" src="//resources.mlstatic.com/mptools/render.js"></script>
<?php
require_once("pages/system/seguranca.php");
require_once ('lib/mercadopago.php');

            $SQLmp = "select * from mercadopago";
            $SQLmp = $conn->prepare($SQLmp);
            $SQLmp->execute();
            $mp=$SQLmp->fetch();

$mp = new MP ("".$mp['CLIENT_ID']."", "".$mp['CLIENT_SECRET']."");

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
		echo 	'alert("Fatura não encontrada!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';

}
$fatu=$SQLUPUser->fetch();

if($fatu['usuario_id']<>$_SESSION['usuarioID']){
echo '<script type="text/javascript">';
		echo 	'alert("Esta fatura não é sua!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';

}
if($fatu['status']=='cancelado'){
echo '<script type="text/javascript">';
		echo 	'alert("Esta fatura está vencida ou expirada!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';

}
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


$total2=$fatu['valor']*$fatu['qtd'];
$total2=number_format($total2, 2, ',', '.');
// MercadoPago
$id=$fatu['id'];
$decricao=$fatu['descricao'];
$preference_data = array(
    "items" => array(
        array(
            "id" => $id,
            "title" => "Mercado Pago Inc - Pagamentos",
            "currency_id" => "BRL",
            "picture_url" =>"https://www.mercadopago.com/org-img/MP3/home/logomp3.gif",
            "description" => $decricao,
            "unit_price" => intval($valorfinal),
            "category_id" => "Category",
            "quantity" => intval($fatu['qtd']),
        )
    )
);

$preference = $mp->create_preference($preference_data);




switch($fatu['tipo']){
					  case 'vpn':$tipo='Acesso VPN';break;
					  case 'revenda':$tipo='Revenda';break;
					  default:$tipo='Outros';break;
	                  }


}else{
	    echo '<script type="text/javascript">';
		echo 	'alert("Fatura Inexistente!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';

}


?>
		<div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Mundo<b>SSH</b></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                            <li class="breadcrumb-item active">Abertas</li>
                        </ol>
                    </div>
                </div>
				<div class="row">
                    <div class="col-md-12">
                        <div class="card card-body printableArea">
                            <h3><b><?php echo $empresa;?></b>Data: <?php echo $dia;?>/<?php echo $mes;?>/<?php echo $ano;?> </h3>
							<h6 class="card-subtitle">Nota: Anexe uma Print do Comprovante para agilizar o processo que pode levar até 24 horas para ser efetuado e você ver refletido em sua conta.</h6>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
                                            <h3> &nbsp;<b class="text-danger"><?php echo $empresa;?>, Inc.</b></h3>
                                            <p class="text-muted m-l-5">
                                                <br/> Telefone: <?php echo formataTelefone($eu['celular']);?>
                                                <br/> Email: <?php echo $eu['email'];?>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
                                            <h3>Para,</h3>
                                            <h4 class="font-bold"><?php echo $usufatu['nome'];?><</h4>
                                            <p class="text-muted m-l-30">
                                                <br/> Telefone: <?php echo formataTelefone($usufatu['celular']);?>
                                                <br/> Email: <?php echo $usufatu['email'];?>
                                                </p>
                                            <p class="m-t-30"><b>Fatura #</b> <i class="fa fa-calendar"></i> <?php echo $fatu['id']; ?></p>
                                            <p><b>Vencimento:</b> <?php echo $diav;?>/<?php echo $mesv;?>/<?php echo $anov;?></p>
											<p><?php if($fatu['servidor_id']<>0){?><b>Servidor:</b> <i class="fa fa-calendar"></i> <?php echo $servidor['ip_servidor'];?> (<?php echo $servidor['nome'];?>)<?php } ?></p>
											<p><?php if($fatu['conta_id']<>0){
											if($fatu['tipo']=='vpn'){ ?></p>
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
                                        <p>Subtotal: R$<?php echo $total1;?></p>
                                        <p>Taxas: R$00,00</p>
										<p>Desconto: R$<?php echo $desconto;?></p>
                                        <hr>
                                        <h3><b>Total :</b> R$<?php echo $total;?></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr>
      <div class="row no-print">
        <div class="col-xs-12">
          <a onclick="window.print();"  class="btn btn-default"><i class="fa fa-print"></i> Print</a>

          <?php if($fatu['status']=='pendente'){ ?>
          <a href="<?php echo $preference["response"]["init_point"]; ?>" name="MP-Checkout" type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Pagar Agora
          </a>
          <button type="button" onclick="window.location.href='home.php?page=faturasclientes/minhas/confirmar&id=<?php echo $fatu['id'];?>'" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Confirmar
          </button>
          <?php }elseif($fatu['status']=='pago'){ ?>
          <h3 class="pull-right" style="margin-right: 5px;">Fatura Paga</h3>
          <?php }elseif($fatu['status']=='cancelado'){ ?>
          <h3 class="pull-right" style="margin-right: 5px;">Fatura Cancelada/Vencida</h3>
          <?php } ?>
        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>
                </div>