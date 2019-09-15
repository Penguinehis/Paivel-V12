<?php

if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}


$buscausuario = "SELECT * FROM usuario WHERE id_usuario='".$_SESSION['usuarioID']."'";
$buscausuario = $conn->prepare($buscausuario);
$buscausuario->execute();
$usuario = $buscausuario->fetch();


?>

<style>
  /* -------------------- Select Box Styles: stackoverflow.com Method */
  /* -------------------- Source: http://stackoverflow.com/a/5809186 */
  select#soflow, select#soflow-color {
   -webkit-appearance: button;
   -webkit-border-radius: 2px;
   -webkit-box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
   -webkit-padding-end: 20px;
   -webkit-padding-start: 2px;
   -webkit-user-select: none;
   cursor:pointer;
   background-image: url(http://i62.tinypic.com/15xvbd5.png), -webkit-linear-gradient(#FAFAFA, #F4F4F4 40%, #E5E5E5);
   background-position: 97% center;
   background-repeat: no-repeat;
   border: 1px solid #AAA;
   color: #555;
   font-size: inherit;
   overflow: hidden;
   padding: 5px 10px;
   text-overflow: ellipsis;
   white-space: nowrap;
   width: 300px;
 }
 @media screen and (max-width: 480px) {
  select#soflow{
    width: 200px;
  }

}


select#soflow-color {
 color: #fff;
 background-image: url(http://i62.tinypic.com/15xvbd5.png), -webkit-linear-gradient(#779126, #779126 40%, #779126);
 background-color: #779126;
 -webkit-border-radius: 20px;
 -moz-border-radius: 20px;
 border-radius: 20px;
 padding-left: 15px;
}

.classehr{
  margin-bottom: 5px;
  margin-top: 0px;
}
#aumente{
  font-weight:normal;color:#000000;letter-spacing:-2pt;word-spacing:-6pt;font-size:25px;text-align:left;font-family:courier new, courier, monospace;
}
.tooltipsy
{
  padding: 10px;
  max-width: 200px;
  color: #303030;
  background-color: #f5f5b5;
  border: 1px solid #deca7e;
}
.small-box h3 {
  font-size:25px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

<script>
  function carregadownloads(){

    var obj = document.getElementById("conteudo");
    obj.innerHTML = '<div class="col-lg-12"><center><i class="fa fa-cog fa-spin fa-3x fa-fw margin-bottom"></i> <br /><small>Buscando arquivos...</small></center></div>';
    var tipo=$("#soflow").val();
    $('#conteudo').fadeOut(0).fadeIn();
    setTimeout(function() {
      $("#conteudo").load('../pages/downloads/ajax_downloads.php?tipo='+tipo);
      $('#conteudo').fadeOut(0).fadeIn();
    }, 2000);
  }

</script>

<script>
  function carregainicial(){
    $("#conteudo").load('../pages/downloads/ajax_downloads.php?tipo=0');
    $('#conteudo').fadeOut(0).fadeIn();
  }
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
        <li class="breadcrumb-item active">Nuvem</li>
      </ol>
    </div>
  </div>

  <div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
    <center><h3 class="text-info"><i class="fa fa-cloud" ></i> Nuvem dos  Servidores </h3> Todos arquivos disponiveis dos servidores</center>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div class="card card-outline-info">
        <div class="card-header">
          <h4 class="m-b-0 text-white"><i class="fa fa-download"></i> Downloads</h4>
        </div>
        <div class="card-body">
          <h4 class="card-title">Selecione o tipo de arquivo</h4>
            <select class="form-control custom-select"  onchange="carregadownloads()" id="soflow" size="1" name="Name">
              <option value="0" selected=selected>Todos</option>
              <option value="1">Arquivos Ehi</option>
              <option value="2">Aplicativos</option>
              <option value="3">Outros</option>
            </select></span>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-body -->
      </div>
        <div class="row" id="conteudo">
          <script>carregainicial();</script>
        </div>
    </div>
  </div>
</div>
