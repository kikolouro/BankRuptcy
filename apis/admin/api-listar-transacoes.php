<?
session_start();
if (isset($_SESSION['cargo'])) {
    if ($_SESSION['cargo'] != 3)
        header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');
require_once(__DIR__ . '/../../connect.php');
try {
    if (isset($_REQUEST['filtro'])) {
        $filtroo = $_REQUEST['filtro'];
    }
    $stmt = $db->prepare('Select Transacao.*, Conta.IBAN from Transacao, Conta where creditoDebito = "Débito" and Transacao.idconta = Conta.idconta  and IBAN like :filtro order by idtrans');
    $stmt->bindValue(':filtro', '%' . $filtroo . '%');
    $stmt->execute();
    $arr = $stmt->fetchAll();
    echo '<div class="row h-100"><div class="col my-auto"><h1 class="text-dark">Listar Transações</h1>';
    $filtro = '<div class="col-2">
    <h1>Filtrar por Iban</h1>
    <form action="" method="POST">
        
        <select class="form-control" name="filtro">';
    $stmt = $db->prepare('select * from Conta');
    $stmt->execute();
    $arrconta = $stmt->fetchAll();

    foreach ($arrconta as $key => $value) {
        $filtro .= '<option value="' . $value->IBAN . '">' . $value->IBAN . '</option>';
    }
    $filtro .= '
    <option value="">Mostrar todos</option>
    </select>
    
    <br>
    <button type="submit" class="btn btn-dark">Filtrar</button>
    </div>
    </form>';

    $tabeladebito = '<div class="col-5 my-auto">
    <h1> Débito </h1>';
    $tabeladebito .= '<table class="table table-striped table-dark">
    <thead>
    <tr>
      <th scope="col">Código da Transaão</th>
      <th scope="col">Valor</th>
      <th scope="col">Conta que enviou</th>
      <th scope="col">Enviado para o Iban</th>
      <th scope="col">Data</th>
      <th scope="col">Mensagem</th>
      
    </tr>
  </thead>
    <tbody>
    ';
    foreach ($arr as $key => $value) {
        $tabeladebito .= '<tr><th scope="row">' . $value->idtrans . '</th>';
        $tabeladebito .= '<td>' . $value->Valor . '</td>';
        $tabeladebito .= '<td>' . $value->IBAN . '</td>';
        $tabeladebito .= '<td>' . $value->IbanReceb . '</td>';
        $tabeladebito .= '<td>' . $value->data . '</td>';
        $tabeladebito .= '<td>' . $value->Mensagem . '</td>';


        ?>
        <div id="modaleliminar<?= $value->idTipo ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <font color="black">
                            <h4>Apagar o Tipo de Conta</h4>
                    </div>
                    <div class="modal-body">
                        <form action="index.php?cmd=DeleteTipoConta&id=<?= $value->idTipo ?>" method="POST" class="form-horizontal">

                            <h1>Têm a certeza que pretende apagar o Tipo de Conta, Ao eliminar irão ser perdidos permanentemente os dados do mesmo!</h1>
                            </font>
                            <center>
                                <input type="submit" name="1" class="kbtn kbtn-2" value="Sim">   
                                <input name="1" type="submit" class="kbtn kbtn-2" value="Não" data-dismiss="modal">
                            </center>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    <? }
        $tabeladebito .= '</tbody></table></div>';


        $tabelacredito = '<div class="col-5 my-auto">
        <h1> Crédito </h1>';
        $tabelacredito .= '<table class="table table-striped table-dark">
    <thead>
    <tr>
      <th scope="col">Código da Transaão</th>
      <th scope="col">Valor</th>
      <th scope="col">Conta que recebeu</th>
      <th scope="col">Recebido do Iban</th>
      <th scope="col">Data</th>
      <th scope="col">Mensagem</th>
     
    </tr>
  </thead>
    <tbody>
    ';
        $stmt = $db->prepare('Select Transacao.*, Conta.IBAN from Transacao, Conta where creditoDebito = "Crédito" and Transacao.idconta = Conta.idconta and IbanReceb like :filtro order by idtrans');
        $stmt->bindValue(':filtro', '%' . $filtroo . '%');
        $stmt->execute();
        $arr = $stmt->fetchAll();
        foreach ($arr as $key => $value) {
            $tabelacredito .= '<tr><th scope="row">' . $value->idtrans . '</th>';
            $tabelacredito .= '<td>' . $value->Valor . '</td>';
            $tabelacredito .= '<td>' . $value->IbanReceb . '</td>';
            $tabelacredito .= '<td>' . $value->IBAN . '</td>';
            $tabelacredito .= '<td>' . $value->data . '</td>';
            $tabelacredito .= '<td>' . $value->Mensagem . '</td>';


            ?>
        <div id="modaleliminar<?= $value->idTipo ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <font color="black">
                            <h4>Apagar o Tipo de Conta</h4>
                    </div>
                    <div class="modal-body">
                        <form action="index.php?cmd=DeleteTipoConta&id=<?= $value->idTipo ?>" method="POST" class="form-horizontal">

                            <h1>Têm a certeza que pretende apagar o Tipo de Conta, Ao eliminar irão ser perdidos permanentemente os dados do mesmo!</h1>
                            </font>
                            <center>
                                <input type="submit" name="1" class="kbtn kbtn-2" value="Sim">   
                                <input name="1" type="submit" class="kbtn kbtn-2" value="Não" data-dismiss="modal">
                            </center>
                        </form>
                    </div>

                </div>
            </div>
        </div>
<? }
    $tabelacredito .= '</tbody></table></div></div></div>';
    echo $tabeladebito;
    echo $filtro;
    echo $tabelacredito;
} catch (PDOException $ex) {
    echo $ex;
}
