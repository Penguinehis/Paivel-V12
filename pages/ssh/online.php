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
                <th>TEMPO</th>
                <th>STATUS</th>
                <th>CONEXAO</th>
                <th>LIMITE</th>
                <th>DONO</th>
                <th>OPCOES</th>
              </tr>
            </thead>
            <tbody id="myTable">
              <?php

              $SQLSub = "SELECT * FROM usuario where id_usuario= '".$_SESSION['usuarioID']."'";
              $SQLSub = $conn->prepare($SQLSub);
              $SQLSub->execute();



              if(($SQLSub->rowCount()) > 0){
               while($rowSub = $SQLSub->fetch()) {
                $SQLSubSSH = "SELECT * FROM usuario_ssh, servidor  where usuario_ssh.id_servidor = servidor.id_servidor and usuario_ssh.id_usuario = '".$_SESSION['usuarioID']."'";
                $SQLSubSSH = $conn->prepare($SQLSubSSH);
                $SQLSubSSH->execute();


                if(($SQLSubSSH->rowCount()) > 0){
                  while($row = $SQLSubSSH->fetch()){
                    $status="";
                    if($row['status']== 1){
                      $status="Ativo";
                    }else{
                     $status="Desativado";
                   }
                   if($row['online'] != 0){
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



                    <tr>

                     <td><?php echo $row['nome'];?></td>
                     <td><?php echo $row['ip_servidor'];?></td>

                     <td><?php echo $row['login'];?></td>

                     <td><span class="pull-left-container" style="margin-right: 5px;">
                      <span class="label label-primary pull-left">
                       <?php echo $dias_acesso."  dias   "; ?>
                     </span>
                   </span>

                   <td><?php echo tempo_corrido($row['online_start']);?> </td>
                   <td><small class="label bg-success">Online</small></td>
                   <td><?php echo $row['online'];?></td>
                   <td><?php echo $row['acesso'];?></td>
                   <td>Sistema</td>
                   <td>
                     <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row['id_usuario_ssh'];?>" class="btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                   </td>
                 </tr>
                 <?php
               }

             }

           }

         }
       }



       if($usuario['tipo']=="revenda"){



         $SQLSub = "SELECT * FROM usuario where id_mestre= '".$_SESSION['usuarioID']."' and subrevenda='nao'";
         $SQLSub = $conn->prepare($SQLSub);
         $SQLSub->execute();


         if(($SQLSub->rowCount()) > 0){
           while($rowSub = $SQLSub->fetch()) {
            $SQLSSH = "SELECT * FROM usuario_ssh, servidor  where usuario_ssh.id_servidor = servidor.id_servidor and usuario_ssh.id_usuario = '".$rowSub['id_usuario']."'";
            $SQLSSH = $conn->prepare($SQLSSH);
            $SQLSSH->execute();


            if(($SQLSSH->rowCount()) > 0){
              while($row = $SQLSSH->fetch()){
                $status="";
                if($row['status']== 1){
                  $status="Ativo";
                }else{
                 $status="Desativado";
               }
               if($row['online'] != 0){


                ?>
                <tr>

                 <td><?php echo $row['nome'];?></td>
                 <td><?php echo $row['ip_servidor'];?></td>
                 <td><?php echo $row['login'];?></td>
                 <td><span class="pull-left-container" style="margin-right: 5px;">
                  <span class="label label-primary pull-left">
                   <?php echo $dias_acesso."  dias   "; ?>
                 </span>
               </span>

               <td><?php echo tempo_corrido($row['online_start']);?> </td>
               <td><small class="label bg-success">Online</small></td>
               <td><?php echo $row['online'];?></td>
               <td><?php echo $row['acesso'];?></td>
               <td><?php echo $rowSub['login'];?></td>

               <td>
                 <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row['id_usuario_ssh'];?>" class="btn-sm btn-primary"><i class="fa fa-eye"></i></a>
               </td>
             </tr>
             <?php
           }

         }

       }

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