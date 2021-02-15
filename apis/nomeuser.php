<?php
ini_get('display_errors', 0);
if (isset($_REQUEST['query']))
    $query = $_REQUEST['query'];
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

    $stmt = $db->prepare('Select iduti,Nome, Foto, cargo from Utilizador where Nome like :nome limit 4');
    $stmt->bindValue(':nome', '%' . $query . '%');
    $stmt->execute();
    //echo "<h1>" . $query;
    $arr = $stmt->fetchAll();
    echo json_encode($arr);
} catch (PDOException $e) {
    echo $e;
}
