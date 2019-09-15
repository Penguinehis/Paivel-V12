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
        <li class="breadcrumb-item active">Erro</li>
      </ol>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-outline-danger">
        <div class="card-header">
          <h4 class="m-b-0 text-white"><i class="fa fa-ban"></i> Contas SSH Com Erros</h4>
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
               <th>Servidor</th>
               <th>IP SSH</th>
               <th>Problema</th>
               <th>Login</th>
               <th>Validade</th>
               <th>Owner</th>
               <th>Informações</th>
             </tr>
           </thead>
           <tbody id="myTable">
            <?php
            $SQLSSH = "SELECT * FROM usuario_ssh , servidor  where usuario_ssh.id_servidor = servidor.id_servidor and usuario_ssh.status > '2'";
            $SQLSSH = $conn->prepare($SQLSSH);
            $SQLSSH->execute();


					// output data of each row
            if (($SQLSSH->rowCount()) > 0) {

             while($row = $SQLSSH->fetch())


             {
              $class = "class='btn btn-danger'";
              $status="";
              $erro="";
              $owner="";
              $color = "";


              if($row['status']== 1){
               $status="Ativo";
               $class = "class='btn btn-primary'";
             }else if($row['status']== 2){
              $status="Suspenso";
              $color = "bgcolor='#FF6347'";
            } if($row['apagar']== 5){
             $erro="Erro ao deletar";

           }
           if($row['id_usuario'] == 0){
             $owner="Sistema";
           }else{

            $SQLRevendedor = "select * from usuario WHERE id_usuario = '".$row['id_usuario']."'";
            $SQLRevendedor = $conn->prepare($SQLRevendedor);
            $SQLRevendedor->execute();
            $revendedor = $SQLRevendedor->fetch();

            $owner = $revendedor['login'];
          }
//Calcula os dias restante
          $data_atual = date("Y-m-d ");
          $data_validade = $row['data_validade'];
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

        <tr <?php echo $color; ?> >

         <td><?php echo $row['nome'];?></td>
         <td><?php echo $row['ip_servidor'];?></td>
         <td> <?php echo $erro; ?></td>
         <td><?php echo $row['login'];?></td>

         <td>
           <span class="pull-left-container" style="margin-right: 5px;">
            <span class="label label-primary pull-left">
             <?php echo $dias_acesso."  dias   "; ?>
           </span>
         </span>

         <?php echo date('d/m/Y', strtotime($row['data_validade']));?>


       </td>
       <td><?php echo $owner;?></td>

       <td>


         <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row['id_usuario_ssh'];?>" <?php echo $class;?>>Visualizar</a>



       </td>
     </tr>




   <?php }
 }


 ?>
</tbody>
</table>
</div>
</div>
</div>
</div>