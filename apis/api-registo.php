<?php
require_once(__DIR__ . '/../connect.php');
require 'PHPMailer/PHPMailerAutoload.php';
echo '<meta charset="UTF-8">';
$mail = new PHPMailer;

$mail->Host = 'smtp.live.com';
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Username = 'Francisco34796pap@hotmail.com';
$mail->Password = 'Teste123!';

$mail->setFrom('Francisco34796pap@hotmail.com');

$nome = trim($_POST['Nome']);
$cc = $_POST['cc'];
$datanasc = $_POST['datanasc'];
$email = $_POST['email'];
$morada = $_POST['morada'];
$telefone = $_POST['tel'];
$nomepass = str_replace(' ', '', $nome);
$origem = $_FILES['foto']['tmp_name'];
$path = "./img/";
$nomefoto = $_FILES['foto']['name'];
$tipoficheiro = ".jpg";
$ver = uniqid() . "-" . uniqid();
//print_r($_FILES);

$mail->CharSet = 'UTF-8';
$mail->addAddress($email);
$mail->addReplyTo($email);
try {
    $stmt = $db->prepare('Select * from Utilizador order by iduti');
    $stmt->execute();
    $arr = $stmt->fetchAll();

    foreach ($arr as $key => $value) {
        $prxid = $value->iduti;
    }
    $prxid++;
    $login = "$nomepass@$prxid";
    $pass = $_POST['Pass'];
    $mail->isHTML(true);
    $mail->Subject = 'Verificação de Email';
    $mail->Body = "<table cellpadding='0' cellspacing='0' border='0' bgcolor='#f7dede' style='border:solid 10px #f7dede; width:550px;'>
    <tr bgcolor='#f7dede' height='25'>
	<td><img src='http://papserver.aelc.pt/~Francisco34796/psi/project2/img/imgemail.jpg' border='0' width='200' height='60' /></td>
	</tr>
	<tr bgcolor='#FFFFFF'><td>&nbsp;</td></tr>
	<tr bgcolor='#FFFFFF' height='35'>
	<td style='padding-left:20px; font-family:Arial; font-size:13px; line-height:18px; text-decoration:none; color:#000000;'><br>Obrigado $nome por escolher Bank ruptcy, a sua conta está<b> quase pronta, </b>Para Continuar clique no link abaixo</td>
	</tr>
	<tr bgcolor='#FFFFFF' height='35'>
    <td style='padding-left:20px; font-family:Arial; font-size:12px; line-height:18px; text-decoration:none; color:#000000;'><b>O seu Login é: $login</td>
    </tr>
    <tr bgcolor='#FFFFFF' height='35'>
	<td style='padding-left:20px; font-family:Arial; font-size:12px; line-height:18px; text-decoration:none; color:#000000;'>Clique no link para verificar a sua conta </b><a href='http://papserver.aelc.pt/~Francisco34796/psi/project2/index.php?Verkey=$ver'>Clique Aqui</a></td>
	</tr>
	<tr bgcolor='#FFFFFF' height='35'>
	<td style='padding-left:20px; font-family:Arial; font-size:12px; line-height:18px; text-decoration:none; color:#000000;'>Agradeciamos que não respondesse a este email.</td>
	</tr>
    </table> ";

    if (!$mail->send()) {
        $res = "Alguma coisa não correu como esperado. Tente novamente";
    } else {


        $destino = $path . $login . $tipoficheiro;


        if ($nomefoto == "") {
            $destino = "./img/user.jpg";
            $stmt = $db->prepare('Insert into Utilizador (CC, Nome, Login, Pass, Foto, datanasc, email, morada, telefone, cargo, Verificacao) values (:cc, :nome, :login, :pass, :foto, :datanasc, :email, :morada, :telefone, :cargo, :ver)');
            $stmt->bindValue(':cc', $cc);
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':login', $login);
            $stmt->bindValue(':pass', crypt($pass));
            $stmt->bindValue(':foto', $destino);
            $stmt->bindValue(':datanasc', $datanasc);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':morada', $morada);
            $stmt->bindValue(':telefone', $telefone);
            $stmt->bindValue(':cargo', 1);
            $stmt->bindValue(':ver', $ver);
            $stmt->execute();
            echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=registocompleto" />';
            header('Location: index.php?cmd=registocompleto');
        } else {
            if (copy($origem, $destino)) {
                $stmt = $db->prepare('Insert into Utilizador (CC, Nome, Login, Pass, Foto, datanasc, email, morada, telefone, cargo, Verificacao) values (:cc, :nome, :login, :pass, :foto, :datanasc, :email, :morada, :telefone, :cargo, :ver)');
                $stmt->bindValue(':cc', $cc);
                $stmt->bindValue(':nome', $nome);
                $stmt->bindValue(':login', $login);
                $stmt->bindValue(':pass', crypt($pass));
                $stmt->bindValue(':foto', $destino);
                $stmt->bindValue(':datanasc', $datanasc);
                $stmt->bindValue(':email', $email);
                $stmt->bindValue(':morada', $morada);
                $stmt->bindValue(':telefone', $telefone);
                $stmt->bindValue(':cargo', 1);
                $stmt->bindValue(':ver', $ver);
                $stmt->execute();
                echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=registocompleto" />';
                header('Location: index.php?cmd=registocompleto');
            } else {
                echo "erro";
            }
        }
    }
} catch (PDOException $ex) {
    echo $ex;
}
