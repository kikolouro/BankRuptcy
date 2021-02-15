<?php
session_start();
if (isset($_SESSION['cargo'])) {
    if ($_SESSION['cargo'] != 3)
        header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');
require_once(__DIR__ . '/../../connect.php');
try {
    $stmt = $db->prepare('Select * from Trasacao order by idtrans');
    $stmt->execute();
    $arr = $stmt->fetchAll();

    foreach ($arr as $key => $value) {
        $codigouti = $value->idtrans;
    }
} catch (PDOException $ex) {
    echo $ex;
}

?>
<div class="row h-100">
    <div class="col-10 my-auto">
        <h1>Adicionar Transações</h1>
        <form class="form-horizontal" action="index.php?cmd=AdicionarTipoConta" method="post">
            <div class="container">
                <div class="form-group row">
                    <div class="col-4">
                        <label class="control-label " for="id">código da transação:</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control" name="id" value="<?= $codigouti + 1 ?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4">
                        <label class="control-label" for="valor">Valor</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control" name="valor" placeholder="50">
                    </div>
                </div>
                <button type="submit" class="kbtn kbtn-2">Adicionar</button>
            </div>
        </form>
    </div>