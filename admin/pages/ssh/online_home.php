<?php
require_once("../../../pages/system/seguranca.php");
require_once("../../../pages/system/config.php");
require_once("../../../pages/system/classe.ssh.php");




if(isset($_GET['requisicao'])){


if($_GET['requisicao']==1){
$SQLSub = "SELECT * FROM usuario_ssh";
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
                          <font color="green"><i class="fa fa-circle"></i></font><font color="black"><b> <?php echo $rowSub['online'];?> / <?php echo $rowSub['acesso'];?> - <?php echo $rowSub['login'];?> <small>(<?php echo $dono['nome'];?>)</b></font></small>
                        </a>
                      </li>

<?php
}

}


}

}elseif($_GET['requisicao']==2){


$total_acesso_ssh_online = 0;
$SQLAcessoSSH = "SELECT sum(online) AS quantidade  FROM usuario_ssh  ";
$SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
$SQLAcessoSSH->execute();
$SQLAcessoSSH = $SQLAcessoSSH->fetch();
$total_acesso_ssh_online += $SQLAcessoSSH['quantidade'];

echo $total_acesso_ssh_online;

}


}

?>