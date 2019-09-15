<?php

if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
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
			<h3 class="text-themecolor">CRACKED<b>PENGUIN</b></h3>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="home.php">Início</a></li>
				<li class="breadcrumb-item active">Contas</li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-outline-info">
				<div class="card-header">
					<h4 class="m-b-0 text-white"><i class="fas fa-users"></i> Usuariios e Rvendedores</h4>
				</div>
				<div class="col-12"><br>
					<div class="form-responsive">
						<input type="text" id="myInput" placeholder="Pesquisar..." class="form-control">
					</div>
				</div>                                   
				<div class="table-responsive m-t-40">        
					<table class="js-sort-table" id="myTable">
						<thead>
							<tr>
								<th>STATUS</th>
								<th>NOME</th>
								<th>LOGIN</th>
								<th>TIPO</th>
								<th>CONTAS SSH</th>
								<th>ACESSOS SSH</th>
								<th>DONO</th>
								<th>OPCOES</th>
							</tr>
						</thead>
						<tbody id="myTable">
							<?php

							$SQLUsuario = "select * from usuario ORDER BY ativo";
							$SQLUsuario = $conn->prepare($SQLUsuario);
							$SQLUsuario->execute();



					// output data of each row
							if (($SQLUsuario->rowCount()) > 0) {

								while($row = $SQLUsuario->fetch()) 


								{
									$status="";
									$tipo="";
									$owner = "";
									$contas = 0;
									$color = "";

									if($row['ativo']== 1){
										$status="Ativo";
									}else{
										$status="Desativado";
									}  


									$SQLContasSSH = "select * from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."'  ";
									$SQLContasSSH = $conn->prepare($SQLContasSSH);
									$SQLContasSSH->execute();
									$contas += $SQLContasSSH->rowCount();

									$total_acesso_ssh = 0;
									$SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$row['id_usuario']."' ";
									$SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
									$SQLAcessoSSH->execute();
									$SQLAcessoSSH = $SQLAcessoSSH->fetch();
									$total_acesso_ssh += $SQLAcessoSSH['quantidade'];


									if($row['ativo']!= 1){
										$color = "bgcolor='#FF6347'";
									} 	
									if($row['tipo']=="vpn"){
										$tipo="Usuário SSH";

									}else{
										$tipo="Revendedor";

										$SQLSub = "select * from usuario WHERE id_mestre = '".$row['id_usuario']."'  ";
										$SQLSub = $conn->prepare($SQLSub);
										$SQLSub->execute();
										if (($SQLSub->rowCount()) > 0) {

											while($rowS = $SQLSub->fetch()) {


												$SQLContasSSH = "select * from usuario_ssh WHERE id_usuario = '".$rowS['id_usuario']."'  ";
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


									}

									if($row['id_mestre'] == 0){
										$owner = "Sistema";
									}else{

										$SQLRevendedor = "select * from usuario WHERE id_usuario = '".$row['id_mestre']."'  ";
										$SQLRevendedor = $conn->prepare($SQLRevendedor);
										$SQLRevendedor->execute();
										$revendedor =  $SQLRevendedor->fetch();
										$owner = $revendedor['login'];

									}


									?>

									<tr <?php echo $color; ?> >
										<td><?php echo $status;?></td>
										<td><?php echo $row['nome'];?></td>

										<td><?php echo $row['login'];?></td>


										<td><?php echo $tipo;?></td>
										<td><?php echo $contas;?></td>
										<td><?php echo $total_acesso_ssh;?></td>

										<td><?php echo $owner;?></td>

										<td>


											<a href="home.php?page=usuario/perfil&id_usuario=<?php echo $row['id_usuario'];?>" class="btn btn-primary">Visualizar</a>


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