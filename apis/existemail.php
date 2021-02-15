<?php
ini_get('display_errors', 1);
if (isset($_REQUEST['email']))
    $email = $_REQUEST['email'];
try {
    $sUserName = 'Francisco34796';
    $sPassword = 'Eslc2019';
    $sConnection = "mysql:host=localhost; dbname=Francisco34796; charset=utf8mb4";

    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    $aOptions = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    );
    $db = new PDO($sConnection, $sUserName, $sPassword, $aOptions);

    $stmt = $db->prepare('Select * from Utilizador where email like :email');
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    $arr = $stmt->fetchAll();
    $cont = 0;
    foreach ($arr as $key => $value) {
        $cont++;
    }
    if ($cont != 0)
        echo "Email já existente!";
    else echo "";
} catch (PDOException $e) {
    echo $e;
    //exit();
}
