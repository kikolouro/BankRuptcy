<?php
session_start();
if (isset($_SESSION['cargo'])) {
    if ($_SESSION['cargo'] != 3)
        header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');
require_once(__DIR__ . '/../../connect.php');
try {
    $stmt = $db->prepare('Select * from Utilizador order by iduti');
    $stmt->execute();
    $arr = $stmt->fetchAll();

    foreach ($arr as $key => $value) {
        $codigouti = $value->iduti;
    }
    $stmt = $db->prepare('Select * from TipoUtilizador order by idTipoUser');
    $stmt->execute();
    $arrTipo = $stmt->fetchAll();



?>
    <div class="row h-100">
        <div class="col my-auto">
            <div class="container">
                <div class="jumbotron card kcardbg shadow-sm border-dark">
                    <h1>Adicionar Utilizadores</h1>
                    <form class="form-horizontal" action="index.php?cmd=AdicionarUtilizadores" method="post" >
                        <div class="container">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="id">Próximo código do utilizador:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="id" value="<?= $codigouti + 1 ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="Nome">Nome:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="Nome" placeholder="João Maria">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="cc">Cartão de cidadão:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="cc" placeholder="01234567 ZA3">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="datanasc">Data de Nascimento:</label>
                                </div>
                                <div class="col-8">
                                    <input type="date" class="form-control" name="datanasc">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="email">Email:</label>
                                </div>
                                <div class="col-8">
                                    <input type="email" class="form-control" name="email" placeholder="exemplo@bankruptcy.pt">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="morada">Morada:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="morada" placeholder="Rua Augusto Teodoro da Silva 2710-368 Sintra">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="tel">Telemovel:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="tel" placeholder="912345678">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="cargo">Cargo:</label>
                                </div>
                                <div class="col-8">
                                    <select class="form-control" name="cargo">
                                        <?php foreach ($arrTipo as $key => $value) { ?>
                                            <option value="<?= $value->idTipoUser ?>"><?= $value->TipoUser ?></option>
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
