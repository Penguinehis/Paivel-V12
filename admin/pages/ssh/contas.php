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
        <li class="breadcrumb-item active">Listar SSH</li>
      </ol>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-outline-info">
        <div class="card-header">
          <h4 class="m-b-0 text-white"><i class="fas fa-greater-than-equal"></i> Contas SSH</h4>
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
                <th>IP</th>                             
                <th>STATUS</th>
                <th>LOGIN</th>
                <th>VALIDADE</th>
                <th>DONO</th>
                <th>OPCOES</th>
              </tr>
            </thead>
            <tbody id="myTable">
              <?php
              $SQLSSH = "SELECT * FROM usuario_ssh , servidor  where usuario_ssh.id_servidor = servidor.id_servidor and  usuario_ssh.status <= '2' ORDER BY  usuario_ssh.status  ";
              $SQLSSH = $conn->prepare($SQLSSH);
              $SQLSSH->execute();


					// output data of each row
              if (($SQLSSH->rowCount()) > 0) {

               while($row = $SQLSSH->fetch())


               {
                $class = "class='btn btn-danger'";
                $status="";
                $owner="";
                $color = "";
                if($row['status']== 1){
                 $status="Ativo";
                 $class = "class='btn-sm btn-primary'";
               }else if($row['status']== 2){
                $status="Suspenso";
                $color = "bgcolor='#FF6347'";
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

          <div class="modal fade" id="squarespaceModal<?php echo $row['id_usuario_ssh'];?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
             <div class="modal-content">
              <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
               <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-money"></i> Cria uma Fatura</h3>
             </div>
             <div class="modal-body">

              <!-- content goes here -->
              <form name="editaserver" action="pages/ssh/criarfatura_ssh.php" method="post">
               <input name="idcontassh" type="hidden" value="<?php echo $row['id_usuario_ssh'];?>">
               <div class="form-group">
                 <label for="exampleInputEmail1">Conta SSH</label>
                 <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row['login'];?>" disabled>
               </div>
               <div class="form-group">
                <label for="exampleInputEmail1">Dono</label>
                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $revendedor['login'];?>" disabled>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Valor</label>
                <input type="number" class="form-control" name="valor" value="1">
                <p><small>*Vezes Acesso que ele possui</small></p>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Desconto</label>
                <input type="number" class="form-control" name="desconto" value="0">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Prazo</label>
                <input type="number" class="form-control" name="prazo" value="1">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Descrição</label>
                <textarea class="form-control" name="msg" rows=3 cols=20 wrap="off" placeholder="Digite..."></textarea>
              </div>



            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-inverse" data-dismiss="modal"  role="button">Cancelar</button>
               <button type="button" class="btn btn-success">Confirmar</button>
             </form>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>

 <tr <?php echo $color; ?> >

   <td><?php echo $row['nome'];?></td>
   <td><?php echo $row['ip_servidor'];?></td>                   
   <td ><?php echo $status;?></td>
   <td><?php echo $row['login'];?></td>

   <td>
     <span class="pull-left-container" style="margin-right: 5px;">
      <span class="label label-primary pull-left">
       <?php echo $dias_acesso."  dias   "; ?>
     </span>
   </span>



 </td>
 <td><?php echo $owner;?></td>

 <td>


   <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row['id_usuario_ssh'];?>" <?php echo $class;?>><i class="fa fa-eye"></i></a>
   <?php if(($revendedor['tipo']=='vpn')and($owner<>'Sistema')){?> <a data-toggle="modal" href="#squarespaceModal<?php echo $row['id_usuario_ssh'];?>" class="btn-sm btn-success label-warning"><i class="fa fa-shopping-cart"></i></a><?php }else{?><?php } ?>


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