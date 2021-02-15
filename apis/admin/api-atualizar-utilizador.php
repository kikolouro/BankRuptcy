<?php
session_start();
if (isset($_SESSION['cargo'])) {
  if ($_SESSION['cargo'] != 3)
    header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');
require_once(__DIR__ . '/../../connect.php');
$nome = trim($_POST['Nome']);
$cc = $_POST['cc'];
$datanasc = $_POST['datanasc'];
$email = $_POST['email'];
$morada = $_POST['morada'];
$telefone = $_POST['tel'];
$cargo = $_POST['cargo'];
$nomepass = str_replace(' ', '', $nome);

if (isset($_REQUEST['id']))
    $id = $_REQUEST['id'];

try {

    $stmt = $db->prepare('update Utilizador 
    set CC = :cc, Nome = :nome, datanasc = :datanasc, email = :email, morada = :morada, telefone = :telefone, cargo = :cargo
    where iduti = :id');
    $stmt->bindValue(':cc', $cc);
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':datanasc', $datanasc);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':morada', $morada);
    $stmt->bindValue(':telefone', $telefone);
    $stmt->bindValue(':cargo', $cargo);
    $stmt->execute();
    echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=ListarUtilizadores" />';
} catch (PDOException $ex) {
    echo $ex;
}
