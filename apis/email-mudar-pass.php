<?php

if (isset($_REQUEST['id']))
    $id = $_REQUEST['id'];

require 'PHPMailer/PHPMailerAutoload.php';
require_once(__DIR__ . '/../connect.php');
require 'PHPMailer/class.smtp.php';
require 'PHPMailer/class.phpmailer.php';
try {
    $stmt = $db->prepare('Select * from Utilizador where iduti = :id');
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $arr = $stmt->fetchAll();


    foreach ($arr as $key => $value) {
        $ver = $value->Verificacao;
        $email = $value->email;
    }
    //echo $email;

    //echo '<meta charset="UTF-8">';
    $mail = new PHPMailer;

    $mail->Host = 'smtp.live.com';
    $mail->Porto = 465;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'Francisco34796pap@hotmail.com';
    $mail->Password = 'Teste123!';

    $mail->setFrom('Francisco34796pap@hotmail.com');

    //print_r($_FILES);

    $mail->CharSet = 'UTF-8';
    $mail->addAddress($email);
    $mail->addReplyTo($email);

    $mail->Subject = 'Mudar de Password';
    $mail->Body = "<table cellpadding='0' cellspacing='0' border='0' bgcolor='#f7dede' style='border:solid 10px #f7dede; width:550px;'>
    <tr bgcolor='#f7dede' height='25'>
	<td><img src='http://papserver.aelc.pt/~Francisco34796/psi/project2/img/imgemail.jpg' border='0' width='200' height='60' /></td>
	</tr>
	<tr bgcolor='#FFFFFF'><td>&nbsp;</td></tr>
	<tr bgcolor='#FFFFFF' height='35'>
	<td style='padding-left:20px; font-family:Arial; font-size:13px; line-height:18px; text-decoration:none; color:#000000;'><br>Foi requesitado uma troca de passoword, pode alterar a mesma no link abaixo:</td>
	</tr>
    <tr bgcolor='#FFFFFF' height='35'>
	<td style='padding-left:20px; font-family:Arial; font-size:12px; line-height:18px; text-decoration:none; color:#000000;'>Clique no link para verificar a sua conta </b><a href='http://papserver.aelc.pt/~Francisco34796/psi/project2/index.php?Verkey=$ver'>Clique Aqui</a></td>
	</tr>
	<tr bgcolor='#FFFFFF' height='35'>
	<td style='padding-left:20px; font-family:Arial; font-size:12px; line-height:18px; text-decoration:none; color:#000000;'>Agradeciamos que não respondesse a este email.</td>
	</tr>
    </table> ";
    if (!$mail->send())
        $res = "Alguma coisa não correu como esperado. Tente novamente";
    else echo "queijo";
    //echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=mudapassmailsucc" />';

} catch (PDOException $ex) {
    echo $ex;
}
