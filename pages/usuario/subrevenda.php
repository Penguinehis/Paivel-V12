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
  $(function () {
    $('#example1').DataTable({
      "language": {
        "sProcessing":    "Processando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "Não foram encontrados resultados",
        "sEmptyTable":    "Nenhuma conta online no momento",
        "sInfo":          "Mostrando de _START_ até _END_ de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando de 0 até 0 de 0 registos",
        "sInfoFiltered":  "(filtrado de _MAX_ registos no total)",
        "sInfoPostFix":   "",
        "sSearch":        "Procurar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sSearchPlaceholder": "Procure",
        "sLoadingRecords": "A carregar dados...",
        "oPaginate": {
          "sFirst":    "Primeiro",
          "sLast":    "Último",
          "sNext":    "Seguinte",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending":  ": Clique para ordenar ascendente (ASC)",
          "sSortDescending": ": Clique para ordenar descendente (DESC)"
        }
      }
    });
    responsive: true
  });
</script>
<!-- Main content -->
<div class="container-fluid">
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
      <h3 class="text-themecolor">Mundo<b>SSH</b></h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home.php">Início</a></li>
        <li class="breadcrumb-item active">SUBRevenda</li>
      </ol>
    </div>
  </div>
  <section class="content">
   <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">


        <div class="box-header">
          <h3 class="box-title">SUB-Revendedores</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="js-sort-table">
            <thead>
              <tr>
               <th>STATUS</th>
               <th>NOME</th>
               <th>LOGIN</th>
               <th>SENHA</th>
               <th>CONTAS SSH</th>
               <th>ACESSOS SSH</th>
               <th>SERVIDORES</th>
               <th>INFORMACOES</th>
             </tr>
           </thead>
           <tbody>

             <?php




             $SQLUsuario = "SELECT * FROM usuario   where  tipo = 'revenda' and subrevenda='sim' and id_mestre='".$usuario['id_usuario']."' ORDER BY ativo ";
             $SQLUsuario = $conn->prepare($SQLUsuario);
             $SQLUsuario->execute();


					// output data of each row
             if (($SQLUsuario->rowCount()) > 0) {

               while($row = $SQLUsuario->fetch())


               {
                $class = "class='btn btn-danger'";
                $status="";
                $color = "";
                $contas = 0;
                $servidores = 0;
                if($row['ativo']== 1){
                 $status="Ativo";
                 $class = "class='btn-sm btn-primary'";
               }else{
                $status="Desativado";
                $color = "bgcolor='#FF6347'";
              }


              $SQLContasSSH = "select * from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."'";
              $SQLContasSSH = $conn->prepare($SQLContasSSH);
              $SQLContasSSH->execute();
              $contas += $SQLContasSSH->rowCount();

              $SQLServidores = "select * from acesso_servidor WHERE id_usuario = '".$row['id_usuario']."'";
              $SQLServidores = $conn->prepare($SQLServidores);
              $SQLServidores->execute();
              $servidores += $SQLServidores->rowCount();

              $total_acesso_ssh = 0;
              $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$row['id_usuario']."' ";
              $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
              $SQLAcessoSSH->execute();
              $SQLAcessoSSH = $SQLAcessoSSH->fetch();
              $total_acesso_ssh += $SQLAcessoSSH['quantidade'];


              $SQLUserSub = "select * from usuario WHERE id_mestre = '".$row['id_usuario']."'";
              $SQLUserSub = $conn->prepare($SQLUserSub);
              $SQLUserSub->execute();

              if (($SQLUserSub->rowCount()) > 0) {

                while($rowS = $SQLUserSub->fetch()) {
                 $SQLContasSSH = "select * from usuario_ssh WHERE id_usuario = '".$rowS['id_usuario']."'";
                 $SQLContasSSH = $conn->prepare($SQLContasSSH);
                 $SQLContasSSH->execute();
                 $contas += $SQLContasSSH->rowCount();

                 $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$rowS['id_usuario']."' ";
                 $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                 $SQLAcessoSSH->execute();
                 $SQLAcessoSSH = $SQLAcessoSSH->fetch();
                 $total_acesso_ssh += $SQLAcessoSSH['quantidade'];


               }
             }







             ?>
             <div class="modal fade" id="squarespaceModal<?php echo $row['id_usuario'];?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog">
               <div class="modal-content">
                <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                 <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-pencil-square-o"></i> Notificar Usuario</h3>
               </div>
               <div class="modal-body">

                <!-- content goes here -->
                <form action="pages/usuario/notifica_sub.php" method="post">
                 <input name="idsubrev" type="hidden" value="<?php echo $row['id_usuario'];?>">
                 <div class="form-group">
                  <label for="exampleInputEmail1">Usuario</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row['nome'];?>" disabled>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Tipo de Alerta</label>
                  <select size="1" name="tipo" class="form-control">
                    <option value="1" selected=selected>SUBRevenda</option>
                    <option value="2">Outros</option>
                  </select>
                </div>


                <div class="form-group">
                  <label for="exampleInputEmail1">Mensagem</label>
                  <textarea class="form-control" name="msg" rows=5 cols=20 wrap="off" placeholder="Digite..." required></textarea>
                </div>
              </div>
              <div class="modal-footer">
               <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                <div class="btn-group" role="group">
                 <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Cancelar</button>
               </div>
               <div class="btn-group" role="group">
                 <button class="btn btn-default btn-hover-green">Confirmar</button>
               </form>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>

   <tr  <?php echo $color; ?> >
     <td><?php echo $status;?></td>
     <td><?php echo $row['nome'];?></td>

     <td><?php echo $row['login'];?></td>
     <td><?php echo $row['senha'];?></td>


     <td><?php echo $contas;?></td>
     <td><?php echo $total_acesso_ssh;?></td>
     <td><?php echo $servidores;?></td>


     <td>

       <a href="home.php?page=usuario/perfil&id_usuario=<?php echo $row['id_usuario'];?>" <?php echo $class;?>><i class="fa fa-eye"></i></a>
       <a data-toggle="modal" href="#squarespaceModal<?php echo $row['id_usuario'];?>"  class="btn-sm btn-warning"><i class="fa fa-flag"></i></a>
     </td>
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
</div>


</section>

</div>

