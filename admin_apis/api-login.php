<?php
session_start();
require_once(__DIR__ . '/../connect.php');

$user = $_POST['user'];
//echo '<script>alert("' . $user . '");</script>';

try {
    $stmt = $db->prepare('Select * from Utilizador');
    $stmt->execute();
    $arr = $stmt->fetchAll();

    foreach ($arr as $key => $value) {
        $pass = crypt($_POST['password'], $value->Pass);
        if ($value->Login == $user) {
            if ($value->Pass == $pass) {
                $_SESSION['id'] = $value->iduti;
                $_SESSION['Nome'] = $value->Nome;
                $_SESSION['cargo'] = $value->cargo;
                $_SESSION['cc'] = $value->CC;
                $_SESSION['email'] = $value->email;
                $_SESSION['Login'] = $value->Login;
                $_SESSION['datanasc'] = $value->datanasc;
                $_SESSION['morada'] = $value->morada;
                $_SESSION['telefone'] = $value->telefone;
                $_SESSION['foto'] = $value->Foto;
                $_SESSION['VerKey'] = $value->Verificacao;
                echo '<meta http-equiv="refresh" content="0.10;url=admin.php"  />';
            } else header('Location: admin.php');
        }
    }
} catch (PDOException $ex) {
    echo $ex;
}
