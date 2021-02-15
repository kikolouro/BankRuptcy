<?php
session_start();
if (isset($_SESSION['cargo'])) {
    if ($_SESSION['cargo'] != 3)
        header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');
require_once(__DIR__ . '/../../connect.php');
try {
    $stmt = $db->prepare('Select * from Conta order by idconta');
    $stmt->execute();
    $arr = $stmt->fetchAll();

    foreach ($arr as $key => $value) {
        $codigouti = $value->idconta;
    }
    $stmt = $db->prepare('Select * from TipoConta order by idTipo');
    $stmt->execute();
    $arr = $stmt->fetchAll();

    $stmt = $db->prepare('Select * from TipoConta where tipo = "poupança"');
    $stmt->execute();
    $arrpo = $stmt->fetchAll();

    $stmt = $db->prepare('Select * from Utilizador');
    $stmt->execute();
    $arruti = $stmt->fetchAll();

    foreach ($arr as $key => $value) {
        $codpou = $value->idTipo;
    }



?>
    <div class="row h-100">
        <div class="col my-auto">
            <div class="container">
                <div class="jumbotron card kcardbg shadow-sm border-dark">
                    <h1>Adicionar Contas</h1>
                    <form class="form-horizontal" action="index.php?cmd=AdicionarContas" method="post">
                        <div class="container">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="id">Próximo código da Conta:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="id" value="<?= $codigouti + 1 ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="TipoConta">Tipo de conta:</label>
                                </div>
                                <div class="col-8">
                                    <select class="form-control" name="TipoConta">
                                        <?php foreach ($arr as $key => $value) { ?>
                                            <option value="<?= $value->idTipo ?>"><?= $value->Tipo ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="limite">Limite da Conta:</label>
                                </div>
                                <div class="col-8">
                                    <input type="number" class="form-control" name="limite" placeholder="500">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="iban">Iban:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="iban" placeholder="PT50158678120000000000178">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="iban">Pertence ao utilizador:</label>
                                </div>
                                <div class="col-8">
                                    <select class="form-control" name="Utilizador">
                                        <?php foreach ($arruti as $key => $value) { ?>
                                            <option value="<?= $value->iduti ?>"><?= $value->Nome ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-light">Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
} catch (PDOException $ex) {
    echo $ex;
}
