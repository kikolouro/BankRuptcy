<?php
session_start();
if (isset($_SESSION['cargo'])) {
    if ($_SESSION['cargo'] != 3)
        header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');
require_once(__DIR__ . '/../../connect.php');
try {
    if (isset($_REQUEST['id']))
        $id = $_REQUEST['id'];
    $stmt = $db->prepare('Select * from TipoConta where idTipo = :id');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $arr = $stmt->fetchAll();

    foreach ($arr as $key => $value) {
        $codigouti = $value->idTipo;
        $nome = $value->Tipo;
    }
} catch (PDOException $ex) {
    echo $ex;
}

?>
<div class="row h-100">
    <div class="col my-auto">
        <div class="container">
            <div class="jumbotron card kcardbg shadow-sm border-dark">
                <h1>Atualizar Tipo de Conta</h1>
                <form class="form-horizontal" action="index.php?cmd=AtualizarTipoConta&id=<?= $id ?>" method="post">
                    <div class="container">
                        <div class="form-group row">
                            <div class="col-4">
                                <label class="control-label " for="id">Código do tipo de conta:</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" name="id" value="<?= $id ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <label class="control-label" for="TipoConta">Tipo de conta:</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" name="TipoConta" value="<?= $nome ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-light">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>