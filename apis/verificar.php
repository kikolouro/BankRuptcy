<?php
if (isset($_REQUEST['Verkey']))
    $verkey = $_REQUEST['Verkey'];
else die;

require_once(__DIR__ . '/../connect.php');

$stmt = $db->prepare('Update Utilizador set Verificacao="Verificado" where Verificacao = :verkey');
$stmt->bindValue(':verkey', $verkey);
$stmt->execute();
$_SESSION['VerKey'] = "Verificado";
echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=successVer" />';
