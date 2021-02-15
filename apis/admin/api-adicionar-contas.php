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



    $stmt = $db->prepare('Insert into Conta (IBAN, saldo, limite, tipo, userid) values (:iban, 0, :limite, :tipo, :userid)');
    $stmt->bindValue(':iban', $iban);
    $stmt->bindValue(':limite', $limite);
    $stmt->bindValue(':tipo', $tipoconta);
    $stmt->bindValue(':userid', $utilizador);
    $stmt->execute();

    unset($stmt);
    $stmt = $db->prepare('Select * from Conta order by idconta');
    $stmt->execute();
    $arr = $stmt->fetchAll();


    echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=ListarContas" />';
} catch (PDOException $ex) {
    echo $ex;
}
