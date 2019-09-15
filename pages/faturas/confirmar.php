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
                        <h3 class="text-themecolor">Mundo<b>SSH</b></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                            <li class="breadcrumb-item active">Comprovar </li>
                        </ol>
                    </div>
                </div>
				<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Fatura N°<small>#<?php echo $fatu['id']; ?></small></h4>
                                <h6 class="card-subtitle">Nota:Anexe uma Print do Comprovante para agilizar o processo que pode levar até 24 horas para ser efetuado e você ver refletido em sua conta.</h6>
								<form role="form" action="pages/faturas/confirmando.php" enctype="multipart/form-data" method="post">
                                <form class="form-material m-t-40">
									<div class="form-group">
                                        <label>Fatura</label>
                                        <input type="text" class="form-control" placeholder="#<?php echo $fatu['id'];?>" value="#<?php echo $fatu['id'];?>" disabled="">
										<input name="fatura" value="<?php echo $fatu['id'];?>" type="hidden">
									</div>
                                    <div class="form-group">
                                        <label>Forma de Pagamento</label>
                                        <select name="formap" class="form-control">
                                            <option value="1" selected=selected>Boleto</option>
                                            <option value="2">Depósito/Transfência</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Deixar uma Nota</label>
                                        <textarea class="form-control" name="msg" id="msg" class="form-control" rows="5" placeholder="Digite ... (Opcional)"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Anexo de comprovante</label>
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> <span class="input-group-addon btn btn-default btn-file"> <span class="fileinput-new">SELECIONAR</span> <span class="fileinput-exists">MUDAR</span>
                                            <input type="file" id="arquivo" name="arquivo" required=required> </span> <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> </div>
                                    </div>
                                    <div class="form-group">
                                        <label>JPG , PNG ou GIF Tamanho Máximo 2MB.</label>
                                    </div>
									<div class="form-group m-b-0">
										<div class="offset-sm-3 col-sm-9">
										<button type="submit" class="btn btn-info waves-effect waves-light m-t-10">Enviar</button>
										<button type="button" onclick="window.location.href='home.php?page=faturas/verfatura&id=<?php echo $fatu['id'];?>'"  class="btn btn-info waves-effect waves-light m-t-10"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Voltar</button>
										</div>
									</div>
                                </form>
								</form>
                            </div>
                        </div>
					</div>
				</div>