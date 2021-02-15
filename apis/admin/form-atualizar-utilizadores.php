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
    $stmt = $db->prepare('Select * from Utilizador, TipoUtilizador where iduti = :id and cargo = idTipoUser');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $arr = $stmt->fetchAll();


    foreach ($arr as $key => $value) {
        $id = $value->iduti;
        $nome = $value->Nome;
        $cc = $value->CC;
        $datanasc = $value->datanasc;
        $email = $value->email;
        $morada = $value->morada;
        $telefone = $value->telefone;
        $cargo = $value->cargo;
        $cargonome = $value->TipoUser;
    }
    $stmt = $db->prepare('Select * from TipoUtilizador where idTipoUser <> :cargo');
    $stmt->bindValue(':cargo', $cargo);
    $stmt->execute();
    $arrtipo = $stmt->fetchAll();

?>
    <div class="row h-100">
        <div class="col my-auto">
            <div class="container">
                <div class="jumbotron card kcardbg shadow-sm border-dark">
                    <h1>Atualizar Utilizador</h1>
                    <form class="form-horizontal" action="index.php?cmd=AtualizarUtilizadores&id=<?= $id ?>" method="post">
                        <div class="container">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="id">Código do utilizador:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="id" value="<?= $id ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="Nome">Nome:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="Nome" value="<?= $nome ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="cc">Cartão de cidadão:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="cc" value="<?= $cc ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="datanasc">Data de Nascimento:</label>
                                </div>
                                <div class="col-8">
                                    <input type="date" class="form-control" name="datanasc" value="<?= $datanasc ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="email">Email:</label>
                                </div>
                                <div class="col-8">
                                    <input type="email" class="form-control" name="email" value="<?= $email ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="morada">Morada:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="morada" value="<?= $morada ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="tel">Telemovel:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="tel" value="<?= $telefone ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="cargo">Cargo:</label>
                                </div>
                                <div class="col-8">
                                    <select class="form-control" name="cargo">
                                        <option value="<?= $cargo ?>" selected><?= $cargonome ?></option>
                                        <?php
                                        foreach ($arrtipo as $key => $value) {
                                        ?>
                                            <option value="<?= $value->idTipoUser ?>"><?= $value->TipoUser ?></option>
                                        <?php
                                        }
                                        ?>
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
