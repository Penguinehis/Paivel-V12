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
<script type="text/javascript">
  function deleta(id){
    decisao = confirm("Tem certeza que deseja deletar essa Conta?!");
    if (decisao){
      window.location.href='home.php?page=ssh/online_free&deletar='+id;
    } else {

    }


  }
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
        <li class="breadcrumb-item active">Online</li>
      </ol>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-outline-info">
        <div class="card-header">
          <h4 class="m-b-0 text-white"><i class="fa fa-rocket"></i> Contas SSH Onlines</h4>
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
             <th>SERVIDOR</th>
             <th>IP SSH</th>
             <th>LOGIN</th>
             <th>VALIDADE</th>
             <th>DONO</th>
             <th>TEMPO</th>
             <th>STATUS</th>
             <th>CONEXAO</th>
             <th>LIMITE</th>
             <th>OPCOES</th>
           </tr>
         </thead>
         <tbody id="myTable">
           <?php




           $SQLSub = "SELECT * FROM usuario_ssh";
           $SQLSub = $conn->prepare($SQLSub);
           $SQLSub->execute();


           if(($SQLSub->rowCount()) > 0){
             while($rowSub = $SQLSub->fetch()) {

              $SQLSSH = "SELECT * FROM servidor where tipo='premium' and id_servidor='".$rowSub['id_servidor']."' ORDER BY id_servidor";
              $SQLSSH = $conn->prepare($SQLSSH);
              $SQLSSH->execute();
              $row = $SQLSSH->fetch();



									//Calcula os dias restante
              $dias_acesso = 0 ;

              $data_atual = date("Y-m-d ");
              $data_validade = $rowSub['data_validade'];
              if($data_validade > $data_atual){
               $data1 = new DateTime( $data_validade );
               $data2 = new DateTime( $data_atual );
               $dias_acesso = 0;
               $diferenca = $data1->diff( $data2 );
               $ano = $diferenca->y * 364 ;
               $mes = $diferenca->m * 30;
               $dia = $diferenca->d;
               $dias_acesso = $ano + $mes + $dia;

             }

             $SQLSubowner = "SELECT * FROM usuario where id_usuario='".$rowSub['id_usuario']."'";
             $SQLSubowner = $conn->prepare($SQLSubowner);
             $SQLSubowner->execute();
             $own=$SQLSubowner->fetch();


             $status="";
             if($rowSub['status']== 1){
              $status="Ativo";
              $class = "class='btn-sm btn-primary'";
            }else{
             $status="Desativado";
           }

           if($rowSub['online'] != 0){

            ?>
            <tr>

             <td><?php echo $row['nome'];?></td>
             <td><?php echo $row['ip_servidor'];?></td>

             <td><?php echo $rowSub['login'];?></td>
             <td>

               <span class="pull-left-container" style="margin-right: 5px;">
                <span class="label label-primary pull-left">
                 <?php echo $dias_acesso."  dias   "; ?>
               </span>
             </span>



           </td>
           <td><?php echo $own['nome'];?></td>
           <td><?php echo tempo_corrido($rowSub['online_start']);?> </td>
           <td><?php
           if($rowSub['online']>0){ ?>
             <small class="label bg-success">Online</small>
           <?php }else{
             echo $rowSub['online']; } ?></td>

             <td><?php echo $rowSub['online'];?></td>
             <td><?php echo $rowSub['acesso'];?></td>
             <td>
              <a href="home.php?page=ssh/editar&id_ssh=<?php echo $rowSub['id_usuario_ssh'];?>" <?php echo $class;?>><i class="fa fa-eye"></i></a>
            </td>
          </tr>
          <?php
        }




      }
    }








    ?>
  </tbody>
</table>
</div>
</div>
</div>
</div>