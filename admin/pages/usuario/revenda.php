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

<div class="container-fluid">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
      <h3 class="text-themecolor">CRACKED<b>PENGUIN</b></h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home.php">Início</a></li>
        <li class="breadcrumb-item active">Listar Revenda</li>
      </ol>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-outline-info">
        <div class="card-header">
          <h4 class="m-b-0 text-white"><i class="fa fa-users"></i> Revendedores</h4>
        </div>
        <div class="col-12"><br>
          <div class="form-responsive">
            <input type="text" id="myInput" placeholder="Pesquisar..." class="form-control">
          </div>
        </div>                                   
        <div class="table-responsive m-t-40">
          <div class="col-12">                                  
          </div>
          <table class="js-sort-table">
            <thead>
              <tr>
                <th>STATUS</th>
                <th>NOME</th>
                <th>LOGIN</th>
                <th>SUB REVENDA</th>
                <th>CONTAS SSH</th>
                <th>ACESSOS SSH</</th>
                <th>SERVIDORES</th>
                <th>INFORMACOES</th>
              </tr>
            </thead>
            <tbody id="myTable">
             <?php



             $SQLUsuario = "SELECT * FROM usuario   where  tipo = 'revenda' ORDER BY ativo ";
             $SQLUsuario = $conn->prepare($SQLUsuario);
             $SQLUsuario->execute();


          // output data of each row
             if (($SQLUsuario->rowCount()) > 0) {

               while($row = $SQLUsuario->fetch())


               {
                 $class = "class='btn-sm btn-danger'";
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

               if($row['subrevenda']=='sim'){
                 $subrev='Sim';
               }else{
                 $subrev='Não';
               }





               ?>
               <?php if($row['id_mestre']==0){?>
                 <div class="modal fade" id="squarespaceModal<?php echo $row['id_usuario'];?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-money"></i> Cria uma Fatura</h3>
                      </div>
                      <div class="modal-body">

                        <!-- content goes here -->
                        <form name="editaserver" action="pages/usuario/criarfatura_usuario.php" method="post">
                          <input name="idcontausuario" type="hidden" value="<?php echo $row['id_usuario'];?>">
                          <div class="form-group">
                           <label for="exampleInputEmail1">Revendedor</label>
                           <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row['login'];?>" disabled>
                         </div>
                         <div class="form-group">
                          <label for="exampleInputEmail1">Tipo</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" value="Outros" disabled>
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
                          <textarea class="form-control" name="msg" rows=3 cols=20 wrap="off" placeholder="Digite..."></textarea>
                        </div>



                      </div>
                      <div class="modal-footer">               
                            <button type="button" class="btn btn-inverse" data-dismiss="modal" >Cancelar</button>                                                  
                            <br><button class="btn btn-success">Confirmar</button>                                             
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>

            <tr  <?php echo $color; ?> >
             <td><?php echo $status;?></td>
             <td><?php echo $row['nome'];?></td>

             <td><?php echo $row['login'];?></td>
             <td><?php echo $subrev;?></td>


             <td><?php echo $contas;?></td>
             <td><?php echo $total_acesso_ssh;?></td>
             <td><?php echo $servidores;?></td>


             <td>

              <a href="home.php?page=usuario/perfil&id_usuario=<?php echo $row['id_usuario'];?>" <?php echo $class;?>><i class="fa fa-eye"></i></a>
              <?php if($row['subrevenda']=='nao'){
               if($row['id_mestre']==0){
                ?>
                <a data-toggle="modal" href="#squarespaceModal<?php echo $row['id_usuario'];?>" class="btn-sm btn-success label-orange"><i class="fa fa-shopping-cart"></i></a>
              <?php } }else{?>

              <?php } ?>
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