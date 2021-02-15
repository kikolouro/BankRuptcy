<?
session_start();
if (isset($_SESSION['cargo'])) {
    if ($_SESSION['cargo'] != 3)
        header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');

require_once(__DIR__ . '/../../connect.php');

if (isset($_REQUEST['id']))
    $id = $_REQUEST['id'];


try {
    $stmt = $db->prepare('SELECT * FROM Utilizador where iduti = :id');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $arr = $stmt->fetchAll();
    foreach ($arr as $key => $value) {
        $nome = $value->Nome;
    }

    if (!strcmp($nome, "admin") || !strcmp($nome, "teste")) {
        echo "<br><br><h1> Boa tentativa ;) </h1>";
        echo '<meta http-equiv="refresh" content="2.5;url=index.php" />';
        die;
    }
    $cont++;
} catch (PDOException $ex) {
    echo $ex;
}

if ($cont != 0) {
    

    if (isset($_REQUEST['1'])) {

        $str = $_REQUEST['1'];
        if (strcmp($str, "Não")) {
            
            try {
                $stmt = $db->prepare('DELETE FROM Utilizador where iduti = :id');
                $stmt->bindValue(':id', $id);
                $stmt->execute();
                echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=ListarUtilizadores" />';
                
            } catch (PDOException $ex) {
                echo $ex;
            }
        } else {
            header('Location: index.php?cmd=ListarUtilizadores');
        }
    }
}

