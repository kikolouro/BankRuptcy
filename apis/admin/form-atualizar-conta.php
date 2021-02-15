<?php
session_start();
if (isset($_SESSION['cargo'])) {
    if ($_SESSION['cargo'] != 3)
        header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');
require_once(__DIR__ . '/../../connect.php');
if (isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
try {
    $stmt = $db->prepare('Select Nome,Conta.*, TipoConta.Tipo 
    from TipoConta, Conta, Utilizador 
    where Conta.Tipo = TipoConta.idtipo  
    and Utilizador.iduti = Conta.userid 
    and Conta.idconta = :id');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $arr = $stmt->fetchAll();

    foreach ($arr as $key => $value) {

        $id = $value->idconta;
        $nome = $value->Nome;
        $limite = $value->limite;
        $iban = $value->IBAN;
        $saldo = $value->saldo;
        $Tipo = $value->Tipo;
    }
    $stmt = $db->prepare('select * from Utilizador where Nome <> :nome');
    $stmt->bindValue(':nome', $nome);
    $stmt->execute();
    $arruti = $stmt->fetchAll();

    $stmt = $db->prepare('select * from Utilizador where Nome = :nome');
    $stmt->bindValue(':nome', $nome);
    $stmt->execute();
    $arrusera = $stmt->fetchAll();
    foreach ($arrusera as $key => $value) {
        $usercodidgo = $value->iduti;
        $userdaconta = $value->Nome;
    }
    $stmt = $db->prepare('select * from TipoConta where Tipo <> :tipo');
    $stmt->bindValue(':tipo', $Tipo);
    $stmt->execute();
    $arrtipo = $stmt->fetchAll();

    $stmt = $db->prepare('select * from TipoConta where Tipo = :tipo');
    $stmt->bindValue(':tipo', $Tipo);
    $stmt->execute();
    $arrtipoa = $stmt->fetchAll();
    foreach ($arrtipoa as $key => $value) {
        $tipocodidgo = $value->idTipo;
        $tipodeconta = $value->Tipo;
    }


?>
    <div class="row h-100">
        <div class="col my-auto">
            <div class="container">
                <div class="jumbotron card kcardbg shadow-sm border-dark">
                    <h1>Atualizar Conta</h1>
                    <form class="form-horizontal" action="index.php?cmd=AtualizarConta&id=<?= $id ?>" method="post">
                        <div class="container">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="id">Código da conta:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="id" value="<?= $id ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="Utilizador">Pertence a:</label>
                                </div>
                                <div class="col-8">
                                    <select class="form-control" name="Utilizador">
                                        <option value="<?= $usercodidgo ?>" selected><?= $userdaconta ?></option>
                                        <?php foreach ($arruti as $key => $value) { ?>
                                            <option value="<?= $value->iduti ?>"><?= $value->Nome ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="limite">Limite:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="limite" value="<?= $limite ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="iban">IBAN:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="iban" value="<?= $iban ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="TipoConta">Tipo de Conta:</label>
                                </div>
                                <div class="col-8">
                                    <select class="form-control" name="TipoConta">
                                        <option value="<?= $tipocodidgo ?>" selected><?= $tipodeconta ?></option>
                                        <?php
                                        foreach ($arrtipo as $key => $value) {
                                            $op .= '<option value="' . $value->idTipo . '">' . $value->Tipo . '</option>';
                                        }
                                        echo $op; ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-light">Atualizar</button>
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
