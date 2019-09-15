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
<!-- SlimScroll -->
<script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->
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
        <li class="breadcrumb-item active">Contas SSH</li>
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
             <th>IP SSH</th>
             <th>LOGIN</th>
             <th>SENHA</th>
             <th>OPENVPN</th>
             <th>VALIDADE</th>
             <th>ACESSOS</th>
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
            $SQLSubSSH = "SELECT * FROM usuario_ssh, servidor  where usuario_ssh.id_servidor = servidor.id_servidor and usuario_ssh.id_usuario = '".$_SESSION['usuarioID']."' ORDER BY status";
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

               $color = "";
               if($row['status']== 2){

                $color = "bgcolor='#FF6347'";
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


            $pegando = "SELECT * FROM usuario_ssh  where id_usuario_ssh='".$row['id_usuario_ssh']."'";
            $pegando = $conn->prepare($pegando);
            $pegando ->execute();
            $pegasenha = $pegando->fetch();

            $SQLopen = "select * from ovpn WHERE servidor_id = '".$row['id_servidor']."' ";
            $SQLopen = $conn->prepare($SQLopen);
            $SQLopen->execute();
            if($SQLopen->rowCount()>0){
             $openvpn=$SQLopen->fetch();
             $texto="<a href='../pages/servidor/baixar_ovpn.php?id=".$openvpn['id']."' class=\"label label-info\">Baixar</a>";
           }else{
             $texto="<span class=\"label label-danger\">Indisponivel</span>";
           }


           ?>
           <tr <?php echo $color; ?>>

             <td><?php echo $row['nome'];?></td>
             <td><?php echo $row['ip_servidor'];?></td>
             <td><?php echo $row['login'];?></td>
             <td><?php echo $pegasenha['senha'];?></td>
             <td><?php echo $texto;?></td>
             <td>
              <span class="pull-left-container" style="margin-right: 5px;">
                <span class="label label-primary pull-left">
                 <?php echo $dias_acesso."  dias   "; ?>
               </span>
             </span>
           </td>
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
         $color = "";
         if($row['status']== 2){

          $color = "bgcolor='#FF6347'";
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
      
      $pegando2 = "SELECT * FROM usuario_ssh  where id_usuario_ssh='".$row['id_usuario_ssh']."'";
      $pegando2 = $conn->prepare($pegando2);
      $pegando2 ->execute();
      $pegasenha2 = $pegando->fetch();
            
      $SQLopen = "select * from ovpn WHERE servidor_id = '".$row['id_servidor']."' ";
      $SQLopen = $conn->prepare($SQLopen);
      $SQLopen->execute();
      if($SQLopen->rowCount()>0){
       $openvpn=$SQLopen->fetch();
       $texto="<a href='../pages/servidor/baixar_ovpn.php?id=".$openvpn['id']."' class=\"label label-info\">Baixar</a>";
     }else{
       $texto="<span class=\"label label-danger\">Indisponivel</span>";
     }

     ?>
     <div class="modal fade" id="criarfatura<?php echo $row['id_usuario_ssh'];?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
       <div class="modal-content">
        <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
         <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-money"></i> Cria uma Fatura</h3>
       </div>
       <div class="modal-body">

        <!-- content goes here -->
        <form name="editaserver" action="pages/ssh/criafatura_ssh.php" method="post">
         <input name="idcontausuario" type="hidden" value="<?php echo $row['id_usuario'];?>">
         <input name="contassh" type="hidden" value="<?php echo $row['id_usuario_ssh'];?>">
         <div class="form-group">
           <label for="exampleInputEmail1">Conta SSH</label>
           <input type="text" class="form-control" value="<?php echo $row['login'];?>" disabled="">
         </div>
         <div class="form-group">
          <label for="exampleInputEmail1">Cliente</label>
          <input type="text" class="form-control" disabled value="<?php echo $rowSub['login'];?>">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Tipo</label>
          <select size="1" class="form-control" disabled>
            <option value="1" selected=selected>Acesso VPN</option>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Valor</label>
          <input type="number" class="form-control" name="valor" value="1">
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
          <textarea class="form-control" name="msg" rows="3" cols="20" wrap="off" placeholder="Digite..."></textarea>
        </div>



      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-inverse" data-dismiss="modal" role="button">Cancelar </button>
         <button type="button" class="btn btn-success">Confirmar</button>
       </div>
     </form>
   </div>
 </div>
</div>
</div>
</div>

<tr <?php echo $color; ?>>
 <td><?php echo $row['nome'];?></td>
 <td><?php echo $row['ip_servidor'];?></td>
 <td><?php echo $row['login'];?></td>
 <td><?php echo $pegasenha2['senha'];?></td>
 <td><?php echo $texto;?></td>
 <td>
  <span class="pull-left-container" style="margin-right: 5px;">
    <span class="label label-primary pull-left">
     <?php echo $dias_acesso."  dias   "; ?>
   </span>
 </span>
</td>
<td><?php echo $row['acesso'];?></td>
<td><?php echo $rowSub['login'];?></td>

<td>
 <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row['id_usuario_ssh'];?>" class="btn-sm btn-primary"><i class="fa fa-eye"></i></a>
 <a data-toggle="modal" href="#criarfatura<?php echo $row['id_usuario_ssh'];?>" class="btn-sm btn-success label-orange"><i class="fa fa-usd"></i></a>
</td>
</tr>
<?php
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