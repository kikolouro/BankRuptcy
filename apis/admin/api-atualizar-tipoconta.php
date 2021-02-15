<?php
session_start();
if (isset($_SESSION['cargo'])) {
    if ($_SESSION['cargo'] != 3)
        header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');
require_once(__DIR__ . '/../../connect.php');


$tipo = $_POST['TipoConta'];


if (isset($_REQUEST['id']))
    $id = $_REQUEST['id'];

try {

    $stmt = $db->prepare('update TipoConta 
    set Tipo = :tipo
    where idTipo = :id');
    $stmt->bindValue(':tipo', $tipo);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=ListarTipoConta"/>';
} catch (PDOException $ex) {
    echo $ex;
}
