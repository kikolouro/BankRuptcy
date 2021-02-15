<?php
require_once(__DIR__ . '/../connect.php');
$ibanReceb = $_POST['IbanReceb'];
$msg = $_POST['msg'];
$conta = $_POST['Iban'];
$valor = $_POST['valor'];
try {
  $stmt = $db->prepare('select * from Conta where idconta = :conta');
  $stmt->bindValue(':conta', $conta);
  $stmt->execute();
  $arr = $stmt->fetchAll();

  foreach ($arr as $key => $value) {
    $limite = $value->limite;
    $saldo = $value->saldo;
    $tipo = $value->tipo;
    $iban = $value->IBAN;
  }
  $stmt = $db->prepare('select * from TipoConta where idTipo = :tipo');
  $stmt->bindValue(':tipo', $tipo);
  $stmt->execute();
  $arrtipo = $stmt->fetchAll();

  foreach ($arrtipo as $key => $value) {
    $nometipo = $value->Tipo;
  }
  if (!strcmp($nometipo, "Poupança")) {
    if (($saldo - $valor) <= $limite)
      echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=TransacaoFail" />';
  } else {
    $data = date("Y-m-d H:i:s");
    $stmt = $db->prepare('Insert into Transacao (Mensagem, Valor, IbanReceb, CreditoDebito, data, idconta) values (:msg, :valor, :ibanreceb, "Débito", :data, :conta)');
    $stmt->bindValue(':msg', $msg);
    $stmt->bindValue(':valor', $valor);
    $stmt->bindValue(':ibanreceb', $ibanReceb);
    $stmt->bindValue(':data', $data);
    $stmt->bindValue(':conta', $conta);


    $stmt->execute();

    $stmt = $db->prepare('Select IBAN, saldo, idconta from Conta where IBAN = :ibanreceb');
    $stmt->bindValue(':ibanreceb', $ibanReceb);
    $stmt->execute();

    unset($arr);

    $arr = $stmt->fetchAll();

    foreach ($arr as $key => $value) {
      $ibanconta = $value->IBAN;
      $saldo2 = $value->saldo;
      $idConta = $value->idconta;
    }


    $stmt = $db->prepare('Insert into Transacao (Mensagem, Valor, IbanReceb, CreditoDebito, data, idconta) values (:msg, :valor, :ibanreceb, "Crédito", :data, :conta)');
    $stmt->bindValue(':msg', $msg);
    $stmt->bindValue(':valor', $valor);
    $stmt->bindValue(':ibanreceb', $iban);
    $stmt->bindValue(':data', $data);
    $stmt->bindValue(':conta', $idConta);

    $stmt->execute();

    $saldomenos = $saldo - $valor;
    $stmt = $db->prepare('update Conta set saldo = :saldo where idconta = :conta');
    $stmt->bindValue(':saldo', $saldomenos);
    $stmt->bindValue(':conta', $conta);

    $stmt->execute();

    $saldomais = $saldo2 + $valor;
    $stmt = $db->prepare('update Conta set saldo = :saldo where IBAN = :iban');
    $stmt->bindValue(':saldo', $saldomais);
    $stmt->bindValue(':iban', $ibanReceb);

    $stmt->execute();

    echo '<meta http-equiv="refresh" content="0.10;url=index.php?cmd=success" />';
  }
} catch (PDOException $ex) {

  echo $ex;
}
