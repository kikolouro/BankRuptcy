<?php
session_start();
if (isset($_SESSION['cargo'])) {
    if ($_SESSION['cargo'] != 3)
        header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');
require_once(__DIR__ . '/../../connect.php');
try {
    $stmt = $db->prepare('Select * from TipoConta where Tipo like "Poupança"');
    $stmt->execute();
    $arr = $stmt->fetchAll();
    foreach ($arr as $key => $value) {
        $poupancaid = $value->idTipo;
    }
    $tipoconta = $_POST['TipoConta'];
    if ($tipoconta == $poupancaid)
        $limite = $_POST['limite'];
    else $limite = 0;
    $iban = $_POST['iban'];
    $utilizador = $_POST['Utilizador'];

    if (isset($_REQUEST['id']))
        $id = $_REQUEST['id'];

    $stmt = $db->prepare('update Conta set IBAN = :iban, limite = :limite, tipo = :tipo, userid = :user where idconta = :id');
    $stmt->bindValue(':iban', $iban);
    $stmt->bindValue(':limite', $limite);
    $stmt->bindValue(':tipo', $tipoconta);
    $stmt->bindValue(':user', $utilizador);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    unset($stmt);
    $stmt = $db->prepare('Select * from Conta order by idconta');
    $stmt->execute();
    $arr = $stmt->fetchAll();

    echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=ListarContas" />';
} catch (PDOException $ex) {
    echo $ex;
}
