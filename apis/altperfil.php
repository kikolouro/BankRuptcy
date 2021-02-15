<?php
require_once(__DIR__ . '/../connect.php');
require 'PHPMailer/PHPMailerAutoload.php';
//echo "boa";
$mail = new PHPMailer;

$mail->Host = 'smtp.live.com';
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Username = 'Francisco34796pap@hotmail.com';
$mail->Password = 'Teste123!';

$mail->setFrom('Francisco34796pap@hotmail.com');
try {
    $id = $_REQUEST['id'];
    $cc = $_REQUEST['cc'];
    $tel = $_REQUEST['tel'];
    $email = $_REQUEST['email'];
    $morada = $_REQUEST['morada'];
    $datanasc = $_REQUEST['datanscimento'];
    $nome = trim($_REQUEST['nome']);
    $nomepass = str_replace(' ', '', $nome);
    $login = "$nomepass@$id";

    //$ver = uniqid() . "-" . uniqid();

    $mail->CharSet = 'UTF-8';
    $mail->addAddress($email);
    $mail->addReplyTo($email);

    $stmt = $db->prepare('Select * from Utilizador where iduti = :id');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $user = $stmt->fetchAll();
    $mail->isHTML(true);
    $mail->Subject = 'Alteração no Perfil';
    $mail->Body = "<table cellpadding='0' cellspacing='0' border='0' bgcolor='#f7dede' style='border:solid 10px #f7dede; width:550px;'>
    <tr bgcolor='#f7dede' height='25'>
	<td><img src='http://papserver.aelc.pt/~Francisco34796/psi/project2/img/imgemail.jpg' border='0' width='200' height='60' /></td>
	</tr>
	<tr bgcolor='#FFFFFF'><td>&nbsp;</td></tr>
	<tr bgcolor='#FFFFFF' height='35'>
	<td style='padding-left:20px; font-family:Arial; font-size:13px; line-height:18px; text-decoration:none; color:#000000;'><br> Caro " . $user[0]->Nome . " o seu perfil no website foi alterado, se não foi você a alterar o perfil contacte um administrador.</td>
	</tr>
	<tr bgcolor='#FFFFFF' height='35'>
    <td style='padding-left:20px; font-family:Arial; font-size:12px; line-height:18px; text-decoration:none; color:#000000;'><b>O seu novo Login é: $login</td>
    </tr>
	<tr bgcolor='#FFFFFF' height='35'>
	<td style='padding-left:20px; font-family:Arial; font-size:12px; line-height:18px; text-decoration:none; color:#000000;'>Agradeciamos que não respondesse a este email.</td>
	</tr>
    </table> ";

    if (!$mail->send()) {
        $res = "Alguma coisa não correu como esperado. Tente novamente";
    } else {
        $stmt = $db->prepare('UPDATE Utilizador SET CC=:cc, Nome=:nome, Login=:login, datanasc=:datanasc, email=:email, morada=:morada, telefone=:tel where iduti = :id');
        $stmt->bindValue(':cc', $cc);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':login', $login);
        $stmt->bindValue(':datanasc', $datanasc);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':morada', $morada);
        $stmt->bindValue(':tel', $tel);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=perfil&id=' . $id . '" />';
    }
} catch (PDOException $ex) {
    echo $ex;
}
