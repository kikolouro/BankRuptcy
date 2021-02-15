<?php
session_start();
if (isset($_SESSION['cargo'])) {
    if ($_SESSION['cargo'] != 3)
        header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');
require_once(__DIR__ . '/../../connect.php');
$tipoconta = trim($_POST['TipoConta']);



try {
    $stmt = $db->prepare('Insert into TipoUtilizador (TipoUser) Values (:tipo)');
    $stmt->bindValue(':tipo', $tipoconta);
    $stmt->execute();
    //echo $tipoconta;
    echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=ListarTipoUtilizadores" />';
} catch (PDOException $ex) {
    echo $ex;
}
