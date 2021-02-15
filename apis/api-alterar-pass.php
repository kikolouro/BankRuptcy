<?php
session_start();
require_once(__DIR__ . '/../connect.php');
require 'PHPMailer/PHPMailerAutoload.php';
//echo "boa";

if (isset($_REQUEST['id']))
    $id = $_REQUEST['id'];

if ($id == $_SESSION['id']) {
    $mail = new PHPMailer;

    $mail->Host = 'smtp.live.com';
    $mail->Port = 465;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'Francisco34796pap@hotmail.com';
    $mail->Password = 'Teste123!';

    $mail->setFrom('Francisco34796pap@hotmail.com');

    $pass = $_REQUEST['pass1'];
    try {
        $stmt = $db->prepare('Select * from Utilizador where iduti = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $user = $stmt->fetchAll();
        $email = $user[0]->email;
        echo $email;
        $mail->CharSet = 'UTF-8';
        $mail->addAddress($email);
        $mail->addReplyTo($email);
        $mail->isHTML(true);
        $mail->Subject = 'Alteração de Palavra-passe';
        $mail->Body = "<table cellpadding='0' cellspacing='0' border='0' bgcolor='#f7dede' style='border:solid 10px #f7dede; width:550px;'>
        <tr bgcolor='#f7dede' height='25'>
        <td><img src='http://papserver.aelc.pt/~Francisco34796/psi/project2/img/imgemail.jpg' border='0' width='200' height='60' /></td>
        </tr>
        <tr bgcolor='#FFFFFF'><td>&nbsp;</td></tr>
        <tr bgcolor='#FFFFFF' height='35'>
        <td style='padding-left:20px; font-family:Arial; font-size:13px; line-height:18px; text-decoration:none; color:#000000;'><br> Caro " . $user[0]->Nome . " a sua Palavra-passe foi alterada, se não foi você a alterar o perfil contacte um administrador.</td>
        </tr>
        <tr bgcolor='#FFFFFF' height='35'>
        <td style='padding-left:20px; font-family:Arial; font-size:12px; line-height:18px; text-decoration:none; color:#000000;'>Agradeciamos que não respondesse a este email.</td>
        </tr>
        </table> ";

        if (!$mail->send()) {
            $res = "Alguma coisa não correu como esperado. Tente novamente";
        } else {
            $stmt = $db->prepare('Update Utilizador set Pass = :pass where iduti = :id');
            $stmt->bindValue(':pass', crypt($pass));
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            session_destroy();
            echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=mudapasstxt" />';
        }
    } catch (PDOException $ex) {
        echo $ex;
    }
} else echo "macaquinho pah!";
