 <?php

 if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
 {
   exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
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
        <li class="breadcrumb-item active">Confirmações</li>
      </ol>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-outline-danger">
        <div class="card-header">
          <h4 class="m-b-0 text-white"><i class="fas fa-file-csv"></i> Comprovantes dos clientes</h4>
        </div>
        <div class="col-12"><br>
          <div class="form-responsive">
            <input type="text" id="myInput" placeholder="Pesquisar..." class="form-control">
          </div>
        </div>                                   
        <div class="table-responsive m-t-40">
          <table class="js-sort-table">
            <thead>
              <tr>
                <th>FATURA</th>
                <th>CLIENTE</th>
                <th>STATUS</th>
                <th>DONO</th>
                <th>FORMA</th>
                <th>NOTA</th>
                <th>IMG</th>
                <th>INFORMACOES</th>
              </tr>
            </thead>
            <tbody id="myTable">
             <?php




             $SQLUPUser= "SELECT * FROM  fatura_comprovantes where status='fechado' ORDER BY id desc ";
             $SQLUPUser = $conn->prepare($SQLUPUser);
             $SQLUPUser->execute();

					// output data of each row
             if (($SQLUPUser->rowCount()) > 0) {

               while($row = $SQLUPUser->fetch())


               {

                switch($row['formapagamento']){
                 case 'boleto':$tipo='Boleto';break;
                 case 'deptra':$tipo='CEF-DEP';break;
                 default:$tipo='Outros';break;
               }



               $datacriado=$row['data'];
               $dataconvcriado = substr($datacriado, 0, 10);
               $partes = explode("-", $dataconvcriado);
               $ano = $partes[0];
               $mes = $partes[1];
               $dia = $partes[2];




               switch($row['status']){
                 case 'aberto':$botao='<span class="label label-warning">Aberto</span>';break;
                 case 'cancelado':$botao='<span class="label label-danger">Cancelado</span>';break;
                 case 'pago':$botao='<span class="label label-success">Pago</span>';break;
                 default:$botao='Outros';break;
               }


               $Susuario= "SELECT * FROM usuario where id_usuario='".$row['usuario_id']."'";
               $Susuario = $conn->prepare($Susuario);
               $Susuario->execute();
               $usuario=$Susuario->fetch();

               ?>

               <tr >
                 <td >#<?php echo $row['id'];?></td>
                 <td><?php echo $usuario['nome'];?></td>
                 <td><?php echo $botao;?></td>
                 <td><?php echo $dia;?>/<?php echo $mes;?> - <?php echo $ano;?></td>
                 <td><?php echo $tipo;?></td>
                 <td><?php echo $row['nota'];?></td>
                 <td><a href="../../../painelssh/admin/pages/faturas/comprovantes/<?php echo $row['imagem'];?>" target="_blank" class="btn btn-block btn-success">Ver</a></td>


                 <td>

                  <a href="home.php?page=faturas/verfatura&id=<?php echo $row['id'];?>" class="btn btn-block btn-success">Visualizar</a>



                </td>
              </tr>

            <?php } } ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>