<?php
session_start();
if (isset($_SESSION['cargo'])) {
    if ($_SESSION['cargo'] != 3)
        header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');
require_once(__DIR__ . '/../../connect.php');
try {
    $stmt = $db->prepare('Select * from TipoUtilizador order by idTipoUser');
    $stmt->execute();
    $arr = $stmt->fetchAll();

    foreach ($arr as $key => $value) {
        $codigouti = $value->idTipoUser;
    }
} catch (PDOException $ex) {
    echo $ex;
}

?>
<div class="row h-100">
    <div class="col my-auto">
        <div class="container">
            <div class="jumbotron card kcardbg shadow-sm border-dark">
                <h1 class="text-light">Adicionar Tipo de Utilizador</h1>
                <form class="form-horizontal" action="index.php?cmd=AdicionarTipoUser" method="post">
                    <div class="container">
                        <div class="form-group row">
                            <div class="col-4">
                                <label class="control-label " for="id">Código do tipo de Utilizador:</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" name="id" value="<?= $codigouti + 1 ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <label class="control-label" for="TipoConta">Tipo de Utilizador:</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" name="TipoConta" placeholder="Cliente">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-light">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>