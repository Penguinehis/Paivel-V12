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
        <li class="breadcrumb-item active">Encerrados</li>
      </ol>
    </div>
  </div>	
 <div class="row">
    <div class="col-lg-12">
      <div class="card card-outline-danger">
        <div class="card-header">
          <h4 class="m-b-0 text-white"><i class="fas fa-user-times"></i> Encerrados</h4>
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
              <th>N° DE CHAMADO</th>
              <th>STATUS</th>
              <th>ABERTO POR</th>
              <th>TIPO DE CHAMADO</th>
              <th>LOGIN/SERVIDOR</th>
              <th>ULTIMA ATUALIZACAO</th>
              <th>INFORMACOES</th>
            </tr>
          </thead>
          <tbody id="myTable">
           <?php




           $SQLUsuario = "SELECT * FROM chamados   where  status = 'encerrado' and usuario_id='".$_SESSION['usuarioID']."' ORDER BY id desc";
           $SQLUsuario = $conn->prepare($SQLUsuario);
           $SQLUsuario->execute();


					// output data of each row
           if (($SQLUsuario->rowCount()) > 0) {

             while($row = $SQLUsuario->fetch())


             {

              $SQLUsuario2 = "SELECT * FROM usuario   where  id_usuario = '".$row['usuario_id']."'";
              $SQLUsuario2 = $conn->prepare($SQLUsuario2);
              $SQLUsuario2->execute();
              $user2 = $SQLUsuario2->fetch();

              switch($row['tipo']){
                case 'contassh':$tipo='SSH';break;
                case 'revendassh':$tipo='REVENDA SSH';break;
                case 'usuariossh':$tipo='USUÁRIO SSH';break;
                case 'servidor':$tipo='SERVIDOR';break;
                case 'outros':$tipo='OUTROS';break;
                default:$tipo='Erro';break;
              }

              $data1=explode(' ',$row['data']);
              $data2=explode('-',$data1[0]);
              $dia=$data2[2];
              $mes=$data2[1];
              $ano=$data2[0];


              ?>




              <div class="modal fade" id="squarespaceModal<?php echo $row['id'];?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog">
                 <div class="modal-content">
                  <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                   <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-info"></i> Informações do Chamado</h3>
                 </div>
                 <div class="modal-body">

                  <!-- content goes here -->
                  <div class="form-group">
                    <label for="exampleInputEmail1">Motivo</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row['motivo'];?>" disabled>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Mensagem</label>
                    <textarea class="form-control" rows=5 cols=20 wrap="off" disabled><?php echo $row['mensagem'];?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Problema</label>
                    <select size="1" class="form-control" disabled>
                      <option  selected=selectes><?php echo $tipo;?></option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Resposta da Administração</label>
                    <textarea class="form-control" rows=5 cols=20 wrap="off" placeholder="Deixe uma resposta para ele visualizar" required disabled><?php echo $row['resposta'];?></textarea>
                  </div>



                </div>
                <div class="modal-footer">
                 <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                  <div class="btn-group" role="group">
                   <button class="btn btn-default btn-hover-green" data-dismiss="modal">Sair</button>
                 </form>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>

     <tr>
       <td>#<?php echo $row['id'];?></td>
       <td><small class="label label-success"><?php echo ucfirst($row['status']);?></small></td>
       <td><?php echo $tipo;?></td>
       <td><?php echo $row['login'];?></td>
       <td><?php echo $dia;?>/<?php echo $mes;?> - <?php echo $ano;?></td>


       <td>

         <a data-toggle="modal" href="#squarespaceModal<?php echo $row['id'];?>" class="btn-sm btn-primary"><i class="fa fa-eye"></i></a>
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