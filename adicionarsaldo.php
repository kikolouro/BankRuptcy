<?php
session_start();
require('connect.php');
if ($_SESSION['cargo'] == 3) {
    if (isset($_REQUEST['idconta'])) {
        $idconta = $_REQUEST['idconta'];
        try {
            $stmt = $db->prepare('Select * from Conta where idconta = :idconta');
            $stmt->bindValue(':idconta', $idconta);
            $stmt->execute();
            $conta = $stmt->fetchAll();

            $saldo = $conta[0]->saldo;
            
            $stmt = $db->prepare('UPDATE Conta SET saldo = :saldo where idconta = :idconta');
            $stmt->bindValue(':saldo', $saldo + 10000);
            $stmt->bindValue(':idconta', $idconta);
            $stmt->execute();

            echo '<script>window.location.replace("index.php");</script>';
            
        } catch (PDOException $ex) {
            echo $ex;
        }
    } else die;
} else die;
