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
<script>
  $(function () {
  $('#example1').DataTable({
    "language": {
        "sProcessing":    "Processando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "Não foram encontrados resultados",
        "sEmptyTable":    "Nenhum dado disponivel",
        "sInfo":          "Mostrando de _START_ até _END_ de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando de 0 até 0 de 0 registos",
        "sInfoFiltered":  "(filtrado de _MAX_ registos no total)",
        "sInfoPostFix":   "",
        "sSearch":        "Procurar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sSearchPlaceholder": "Procure o CP",
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
		<div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">CRACKED<b>PENGUIN</b></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                            <li class="breadcrumb-item active">Comprovantes</li>
                        </ol>
                    </div>
                </div>
    <section class="content">
						<div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Verifique os comprovantes dos clientes<</h4>
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID Fatura</th>
                                                <th>Tipo</th>
                                                <th>Status</th>
                                                <th>Data</th>
                                                <th>Vencimento</th>
                                                <th>Valor</th>
												<th>Informações</th>
												</tr>
										</thead>
									<tbody>
                <?php




					$SQLUPUser= "SELECT * FROM  fatura_comprovantes where status='aberto' ORDER BY id desc ";
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
				   <td >#<?php echo $row['fatura_id'];?></td>
                   <td><?php echo $usuario['nome'];?></td>
                   <td><?php echo $botao;?></td>
                   <td><?php echo $dia;?>/<?php echo $mes;?> - <?php echo $ano;?></td>
                   <td><?php echo $tipo;?></td>
                   <td><?php echo $row['nota'];?></td>
				   <td><a href="../../../painelssh/admin/pages/faturas/comprovantes/<?php echo $row['imagem'];?>" target="_blank" class="btn btn-block btn-success">Ver</a></td>


				   <td>

					   <a href="home.php?page=faturas/verfatura&id=<?php echo $row['fatura_id'];?>" class="btn btn-block btn-success">Visualizar</a>



				   </td>
                  </tr>

   <?php } } ?>

									
									</tbody>
									</table>
                                </div>
                            </div>
                        </div>
		</div>