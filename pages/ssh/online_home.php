<?php
require_once('../../pages/system/seguranca.php');
require_once('../../pages/system/config.php');
require_once('../../pages/system/funcoes.php');
require_once('../../pages/system/classe.ssh.php');

protegePagina("user");


if(isset($_GET['requisicao'])){

$eubusca = "SELECT * FROM usuario where id_usuario='".$_SESSION['usuarioID']."'";
$eubusca = $conn->prepare($eubusca);
$eubusca->execute();
$eu=$eubusca->fetch();

if($_GET['requisicao']==1){
$SQLSub = "SELECT * FROM usuario_ssh where id_usuario='".$_SESSION['usuarioID']."'";
$SQLSub = $conn->prepare($SQLSub);
$SQLSub->execute();

if(($SQLSub->rowCount()) > 0){
while($rowSub = $SQLSub->fetch()) {

if($rowSub['online']>0){

$SQLdono = "SELECT * FROM usuario where id_usuario='".$rowSub['id_usuario']."'";
$SQLdono = $conn->prepare($SQLdono);
$SQLdono->execute();
$dono=$SQLdono->fetch();
?>

                       <li>
                        <a href="?page=ssh/editar&id_ssh=<?php echo $rowSub['id_usuario_ssh'];?>">
                           <font color="green"><i class="fa fa-circle"></i></font><font color="black"><b>  <?php echo $rowSub['online'];?> / <?php echo $rowSub['acesso'];?> - <?php echo $rowSub['login'];?> <small>(Meu) </b></font></small>
                        </a>
                       </li>
<?php
}

}

if($eu['tipo']=='revenda'){
$SQLSubuser = "SELECT * FROM usuario where id_mestre='".$_SESSION['usuarioID']."' and subrevenda='nao'";
$SQLSubuser = $conn->prepare($SQLSubuser);
$SQLSubuser->execute();

if(($SQLSubuser->rowCount()) > 0){
while($subus = $SQLSubuser->fetch()) {


$SQLSubssh = "SELECT * FROM usuario_ssh where id_usuario='".$subus['id_usuario']."'";
$SQLSubssh = $conn->prepare($SQLSubssh);
$SQLSubssh->execute();

if(($SQLSubssh->rowCount()) > 0){
while($subussh = $SQLSubssh->fetch()) {


if($subussh['online']>0){

$SQLdono = "SELECT * FROM usuario where id_usuario='".$subussh['id_usuario']."'";
$SQLdono = $conn->prepare($SQLdono);
$SQLdono->execute();
$dono=$SQLdono->fetch();
?>
                       <li>
                        <a href="?page=ssh/editar&id_ssh=<?php echo $subussh['id_usuario_ssh'];?>">
                          <font color="green"><i class="fa fa-circle"></i></font><font color="black"><b> <?php echo $subussh['online'];?> / <?php echo $subussh['acesso'];?> - <?php echo $subussh['login'];?> <small>(<?php echo $dono['nome'];?>)</b></font></small>
                        </a>
                      </li>

<?php
}


}
}

}
}

}

}

}elseif($_GET['requisicao']==2){


$total_acesso_ssh_online = 0;
$SQLAcessoSSH = "SELECT sum(online) AS quantidade  FROM usuario_ssh  where id_usuario='".$_SESSION['usuarioID']."'";
$SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
$SQLAcessoSSH->execute();
$SQLAcessoSSH = $SQLAcessoSSH->fetch();
$total_acesso_ssh_online += $SQLAcessoSSH['quantidade'];

if($eu['tipo']=='revenda'){
$SQLSub= "select * from usuario WHERE id_mestre = '".$_SESSION['usuarioID']."' and subrevenda='nao'";
$SQLSub = $conn->prepare($SQLSub);
$SQLSub->execute();

if (($SQLSub->rowCount()) > 0) {

                while($row = $SQLSub->fetch()) {

                    $SQLAcessoSSHon = "SELECT sum(online) AS quantidade  FROM usuario_ssh  where id_usuario='".$row['id_usuario']."' ";
                    $SQLAcessoSSHon = $conn->prepare($SQLAcessoSSHon);
                    $SQLAcessoSSHon->execute();
		            $SQLAcessoSSHon = $SQLAcessoSSHon->fetch();
                    $total_acesso_ssh_online += $SQLAcessoSSHon['quantidade'];

}
}


}

echo $total_acesso_ssh_online;

}


}

?>