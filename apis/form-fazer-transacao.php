<?php
session_start();
require_once(__DIR__ . '/../connect.php');
$id = $_SESSION['id'];
try {
    $stmt = $db->prepare('Select * from Conta where userid = :id');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $arr = $stmt->fetchAll();
    foreach ($arr as $key => $value) {
        $cont++;
    }
    if ($cont == 0) {
        echo "<br><br><h1>Não têm Contas, fale com um adminstrador</h1>";
        echo '<meta http-equiv="refresh" content="2;url=index.php" />';
        die;
    }
    $stmt = $db->prepare('Select * from  Transacao order by idtrans');
    $stmt->execute();
    $arr = $stmt->fetchAll();
    foreach ($arr as $key => $value) {
        $codigouti = $value->idtrans;
    }

    $stmt = $db->prepare('Select Conta.* from Conta where userid = :id');
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $arrconta = $stmt->fetchAll();


?>
    <div class="row h-100">
        <div class="col my-auto">
            <div class="container">
                <div class="jumbotron card kcardbg shadow-sm border-dark">
                    <h1>Efetuar Transação</h1>
                    <form class="form-horizontal" action="index.php?cmd=FazerTrasacao" method="post">
                        <div class="container">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="valor">Valor:</label>
                                </div>
                                <div class="col-8">
                                    <input type="number" class="form-control" name="valor">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="Iban">Selecione a sua conta:</label>
                                </div>
                                <div class="col-8">
                                    <select class="form-control" name="Iban">
                                        <?php
                                        foreach ($arrconta as $key => $value) {
                                            $op .= '<option value="' . $value->idconta . '">Iban: ' . $value->IBAN . ' saldo: ' . $value->saldo . '</option>';
                                        }
                                        echo $op; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="IbanReceb">Enviar para o Iban:</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="IbanReceb">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label" for="msg">Mensagem (Opcional):</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control" name="msg">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-light">Fazer Transação</button>

                    </form>
                    <a href="index.php?cmd=home" class="btn btn-danger" role="button">Voltar atrás</a>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php
} catch (PDOException $ex) {
    echo $ex;
}
