<?php
session_start();
require_once(__DIR__ . '/../connect.php');

if (isset($_REQUEST['id']))
    $id = $_REQUEST['id'];

if ($id == $_SESSION['id']) {
    $origem = $_FILES['foto']['tmp_name'];
    $path = "./img/";
    $nomefoto = $_FILES['foto']['name'];
    $tipoficheiro = ".jpg";

    try {

        $stmt = $db->prepare('Select * from Utilizador where iduti = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $arr = $stmt->fetchAll();

        foreach ($arr as $key => $value) {
            $login = $value->Login;
        }

        $destino = $path . $login . $tipoficheiro;
        //echo $destino;
        //echo __DIR__;



        if ($nomefoto == "") {
            $destino = "./img/user.jpg";
            $stmt = $db->prepare('Update Utilizador set Foto = :foto where iduti = :id');
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':foto', $destino);
            $stmt->execute();
            if (file_exists("img/$login.jpg")) {
                unlink("img/$login.jpg");
            }
            $_SESSION['foto'] = $destino;
            echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=perfil&id=' . $id . '" />';
        } else {
            if (copy($origem, $destino)) {
                $stmt = $db->prepare('Update Utilizador set Foto = :foto where iduti = :id');
                $stmt->bindValue(':id', $id);
                $stmt->bindValue(':foto', $destino);
                $stmt->execute();
                //echo __DIR__;
                if (file_exists(__DIR__ . "/img/$login.jpg")) {

                    unlink("img/$login.jpg");
                }
                $_SESSION['foto'] = $destino;
                echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=perfil&id=' . $id . '"  />';
            } else {
                echo "erro";
            }
        }
    } catch (PDOException $ex) {
        echo $ex;
    }
} else echo "ai ai ai ";
