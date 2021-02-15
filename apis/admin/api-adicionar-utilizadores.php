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
$foto = './img/user.jpg';
try {
    $stmt = $db->prepare('Select * from Utilizador order by iduti');
    $stmt->execute();
    $arr = $stmt->fetchAll();

    foreach ($arr as $key => $value) {
        $prxid = $value->iduti;
    }
    $prxid++;
    $login = "$nomepass@$prxid";
    $pass = $nome . substr($cc, 0, 3);

    $stmt = $db->prepare('Insert into Utilizador (CC, Nome, Login, Pass, datanasc, email, morada, telefone, cargo, Foto) values (:cc, :nome, :login, :pass, :datanasc, :email, :morada, :telefone, :cargo, :foto)');
    $stmt->bindValue(':cc', $cc);
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':login', $login);
    $stmt->bindValue(':pass', crypt($pass));
    $stmt->bindValue(':datanasc', $datanasc);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':morada', $morada);
    $stmt->bindValue(':telefone', $telefone);
    $stmt->bindValue(':cargo', $cargo);
    $stmt->bindValue(':foto', $foto);
    $stmt->execute();
    echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=ListarUtilizadores" />';
    header('Location: index.php?cmd=ListarUtilizadores');
} catch (PDOException $ex) {
    echo $ex;
}
