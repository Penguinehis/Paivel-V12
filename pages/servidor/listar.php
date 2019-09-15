 <?php

 if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
 {
   exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
 }

// Usados

 $qtddoserverusado=0;

 $SQLusuariosdele= "SELECT * FROM usuario where id_mestre = '".$_SESSION['usuarioID']."' and subrevenda='nao'";
 $SQLusuariosdele = $conn->prepare($SQLusuariosdele);
 $SQLusuariosdele->execute();

 if ($SQLusuariosdele->rowCount()>0) {
  while($usuariosdele=$SQLusuariosdele->fetch()){
    $SQLcontaqtdsshusadodele= "SELECT sum(acesso) as acessosdosserversusados2 FROM usuario_ssh where id_usuario = '".$usuariosdele['id_usuario']."'";
    $SQLcontaqtdsshusadodele = $conn->prepare($SQLcontaqtdsshusadodele);
    $SQLcontaqtdsshusadodele->execute();

    $qtdusadosdele=$SQLcontaqtdsshusadodele->fetch();

    $qtddoserverusado+=$qtdusadosdele['acessosdosserversusados2'];

  }

}


$SQLcontaqtdsshusado= "SELECT sum(acesso) as acessosdosserversusados FROM usuario_ssh where id_usuario = '".$_SESSION['usuarioID']."'";
$SQLcontaqtdsshusado = $conn->prepare($SQLcontaqtdsshusado);
$SQLcontaqtdsshusado->execute();

$qtdusados=$SQLcontaqtdsshusado->fetch();

$qtddoserverusado+=$qtdusados['acessosdosserversusados'];


// Todos Acessos

$todosacessos=0;

$SQLqtdserveracessos= "SELECT sum(qtd) as todosacessos FROM  acesso_servidor where id_usuario = '".$_SESSION['usuarioID']."'";
$SQLqtdserveracessos = $conn->prepare($SQLqtdserveracessos);
$SQLqtdserveracessos->execute();

$totalacess=$SQLqtdserveracessos->fetch();

$todosacessos+=$totalacess['todosacessos'];

//Disponiveis
$disponiveis=$todosacessos-$qtddoserverusado;

if($disponiveis<=0){$disponiveis=0;}

//Calculo Porcentagem

$porcent = ($qtddoserverusado/$todosacessos)*100; // %

$resultado = $porcent;

$valor_porce = round($resultado);

if($valor_porce>=100){
  $valor_porce=100;
}

if($valor_porce<=0){
  $valor_porce=0;
}

if(($valor_porce>=70)and($valor_porce<90)){
  $sucessobar="warning";
  $bgbar="orange";
}elseif($valor_porce>=90){
  $sucessobar="danger";
  $bgbar="red";
}else{
  $sucessobar="success";
  $bgbar="green";
}






?>
<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="../../plugins/datatables/sort-table.js"></script>
<style type="text/css">

  table { 
    width: 100%; 
    border-collapse: collapse; 
  }
  /* Zebra striping */
  tr:nth-of-type(odd) { 
    background: #f3f4f8; 
  }
  th { 
    background: white; 
    color: black; 
    font-weight: bold; 
  }
  td, th { 
    padding: 6px; 
    border: 1px solid #d7dfe2; 
    text-align: left; 
  }

</style>
<script>
  $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
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
        <li class="breadcrumb-item active">Servidores</li>
      </ol>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-outline-info">
        <div class="card-header">
          <h4 class="m-b-0 text-white"><i class="fa fa-server"></i> Lista de Servidores</h4>
        </div>
        <div class="col-12"><br>
          <div class="form-responsive">
            <input type="text" id="myInput" placeholder="Pesquisar..." class="form-control">
          </div>
        </div><br>                                  
        <div class="table-responsive">
          <div class="col-12">                                  
          </div>
          <table class="js-sort-table">
            <thead>
              <tr>
                <th>NOME</th>
                <th>ENDERECO IP</th>
                <th>OPENVPN</th>
                <th>LIMITE</th>
                <th>UTILIZADO</th>
                <th>UTILIZADO (%)</th>
                <th>VALIDADE</th>
              </tr>
            </thead>
            <tbody id="myTable">

             <?php

             $SQLAcessoServidor = "SELECT * FROM acesso_servidor where id_usuario = '".$_SESSION['usuarioID']."' ";
             $SQLAcessoServidor = $conn->prepare($SQLAcessoServidor);
             $SQLAcessoServidor->execute();



					// output data of each row
             if (($SQLAcessoServidor->rowCount()) > 0) {

               while($row = $SQLAcessoServidor->fetch())


               {

                $contas=0;
                $total_acesso_ssh = 0;

                $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$_SESSION['usuarioID']."' and id_servidor='".$row['id_servidor']."'";
                $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                $SQLAcessoSSH->execute();
                $SQLAcessoSSH = $SQLAcessoSSH->fetch();
                $total_acesso_ssh += $SQLAcessoSSH['quantidade'];

                $SQLContasSSH = "select * from usuario_ssh WHERE id_usuario = '".$_SESSION['usuarioID']."' and id_servidor='".$row['id_servidor']."'";
                $SQLContasSSH = $conn->prepare($SQLContasSSH);
                $SQLContasSSH->execute();
                $contas += $SQLContasSSH->rowCount();

                $SQLUserSub = "select * from usuario WHERE id_mestre = '".$_SESSION['usuarioID']."' and subrevenda='nao'";
                $SQLUserSub = $conn->prepare($SQLUserSub);
                $SQLUserSub->execute();

                if (($SQLUserSub->rowCount()) > 0) {

                  while($rowS = $SQLUserSub->fetch()) {
                   $SQLContasSSH = "select * from usuario_ssh WHERE id_usuario = '".$rowS['id_usuario']."'  and id_servidor='".$row['id_servidor']."'";
                   $SQLContasSSH = $conn->prepare($SQLContasSSH);
                   $SQLContasSSH->execute();
                   $contas += $SQLContasSSH->rowCount();

                   $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$rowS['id_usuario']."'  and id_servidor='".$row['id_servidor']."'";
                   $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                   $SQLAcessoSSH->execute();
                   $SQLAcessoSSH = $SQLAcessoSSH->fetch();
                   $total_acesso_ssh += $SQLAcessoSSH['quantidade'];


                 }
               }




               $todosacessos2=0;

               $SQLqtdserveracessos2= "SELECT sum(qtd) as todosacessos FROM  acesso_servidor where id_usuario = '".$row['id_usuario']."' and id_servidor='".$row['id_servidor']."' ";
               $SQLqtdserveracessos2 = $conn->prepare($SQLqtdserveracessos2);
               $SQLqtdserveracessos2->execute();

               $totalacess2=$SQLqtdserveracessos2->fetch();

               $todosacessos2+=$totalacess2['todosacessos'];

//Calculo Porcentagem

$porcentagem = ($total_acesso_ssh/$todosacessos2)*100; // %

$resultado2 = $porcentagem;

$valor_porcetage = round($resultado2);

if($valor_porcetage>=100){
  $valor_porcetage=100;
}
if($valor_porcetage<=0){
  $valor_porcetage=0;
}
if(($valor_porcetage>=70)and($valor_porcetage<90)){
  $sucessobar="warning";
  $bgbar2="warning";
}elseif($valor_porcetage>=90){
  $sucessobar="danger";
  $bgbar2="danger";
}else{
  $sucessobar="success";
  $bgbar2="success";
}


$SQLServidor= "select * from servidor WHERE id_servidor = '".$row['id_servidor']."' ";
$SQLServidor = $conn->prepare($SQLServidor);
$SQLServidor->execute();
$servidor =  $SQLServidor->fetch();


$SQLopen = "select * from ovpn WHERE servidor_id = '".$row['id_servidor']."' ";
$SQLopen = $conn->prepare($SQLopen);
$SQLopen->execute();
if($SQLopen->rowCount()>0){
 $openvpn=$SQLopen->fetch();
 $texto="<a href='../admin/pages/servidor/baixar_ovpn.php?id=".$openvpn['id']."' class=\"label label-info\">Baixar</a>";
}else{
 $texto="<span class=\"label label-danger\">Indisponivel</span>";
}

                 //Calcula os dias restante
$data_atual = date("Y-m-d");
$data_validade = $row['validade'];
if($data_validade > $data_atual){
 $data1 = new DateTime( $data_validade );
 $data2 = new DateTime( $data_atual );
 $dias_acesso = 0;
 $diferenca = $data1->diff( $data2 );
 $ano = $diferenca->y * 364 ;
 $mes = $diferenca->m * 30;
 $dia = $diferenca->d;
 $dias_acesso = $ano + $mes + $dia;

}else{
  $dias_acesso = 0;
}



?>

<tr>
 <td><?php echo $servidor['nome'];?></td>
 <td><?php echo $servidor['ip_servidor'];?></td>
 <td><?php echo $texto;?></td>
 <td><?php echo $row['qtd'];?></td>
 <td><?php echo $contas;?></td>
 <td><span class="badge bg-<?php echo $bgbar2;?>"><?php echo $valor_porcetage;?>%</span></td>
 <td><span class="pull-left-container" style="margin-right: 5px;">
  <span class="label label-primary pull-left">
   <?php echo $dias_acesso."  dias   "; ?>
 </span>
</span></td>

</tr>

<?php }
}

?>

</tbody>
<tfoot>
</tfoot>
</table>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
<!-- /.box -->
</div>

<div class="row">
    <div class="col-lg-12">
      <div class="card card-outline-warning">
        <div class="card-header">
          <h4 class="m-b-0 text-white"><i class="fa fa-bar-chart"></i> Estatisticas</h4>
        </div>
  <!-- /.box-header -->
  <div class="box-body no-padding">
    <table class="table table-condensed">
      <tbody><tr>
        <th style="width: 50%">Acessos</th>
        <th style="width: 50%">Acessos Disponíveis</th>
      </tr>
      <tr>
        <td><?php echo $qtddoserverusado;?>/<?php echo $todosacessos;?></td>
        <td><?php echo $disponiveis;?></td>
      </tr>
      <tr>
        <th>Progresso de Uso</th>
        <th style="width: 40px">Utilizado (%)</th>
      </tr>
      <tr>
        <td>
          <div class="progress progress-xs">
            <div class="progress-bar progress-bar-<?php echo $sucessobar;?>" style="width: <?php echo $valor_porce;?>%"></div>
          </div>
        </td>
        <td><span class="badge badge-<?php echo $bgbar2;?>"><?php echo $valor_porce;?>%</span></td>
      </tr>


    </tbody></table>
  </div>
  <!-- /.box-body -->
</div>

</div>


</section>
</div>



