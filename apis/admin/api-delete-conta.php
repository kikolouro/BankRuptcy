<?
session_start();
if (isset($_SESSION['cargo'])) {
    if ($_SESSION['cargo'] != 3)
        header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');

require_once(__DIR__ . '/../../connect.php');

if (isset($_REQUEST['id']))
    $id = $_REQUEST['id'];

    
    if (isset($_REQUEST['1'])) {
        $str = $_REQUEST['1'];
        if (strcmp($str, "Não")) {

            try {
                $stmt = $db->prepare('DELETE FROM Conta where idconta = :id');
                $stmt->bindValue(':id', $id);
                $stmt->execute();
                echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=ListarContas" />';
                
            } catch (PDOException $ex) {
                echo $ex;
            }
        } else {
            header('Location: index.php?cmd=ListarContas');
        }
    }


