<?php
session_start();
require_once(__DIR__ . '/../connect.php');


if (isset($_POST['tipo']))
    $tipo = $_POST['tipo'];


try {
    $stmt = $db->prepare('SELECT AUTO_INCREMENT as k
    FROM  INFORMATION_SCHEMA.TABLES
    WHERE TABLE_SCHEMA = "Francisco34796"
    AND   TABLE_NAME   = "Conta"');

    $stmt->execute();
    $d = $stmt->fetchAll();
    switch ($tipo) {
        case 1: {
                $limite = 0;
                break;
            }
        case 3: {
                $limite = $_POST['limite'];
                break;
            }
    }

    $codbank = 1586;
    $agencia = 7812;

    $idconta = str_pad($d[0]->k, 11, '0', STR_PAD_LEFT);

    $nrrand = rand(10, 99);

    $iban = 'PT50' . $codbank . $agencia . $idconta . $nrrand;


    $stmt = $db->prepare('Insert into Conta (IBAN, saldo, limite, tipo, userid) values (:iban, 0, :limite, :tipo, :userid)');
    $stmt->bindValue(':iban', $iban);
    $stmt->bindValue(':limite', $limite);
    $stmt->bindValue(':tipo', $tipo);
    $stmt->bindValue(':userid', $_SESSION['id']);
    $stmt->execute();

    echo '<meta http-equiv="refresh" content="0.10;url=index.php" />';
} catch (PDOException $ex) {
    echo $ex;
}
