<style>
  label {
    color: #343a40 !important;
  }

  input {
    color: #ffffff !important;
    background-color: #343a40 !important;
    border-color: #343a40 !important;
  }

  .paginate_button a {
    background-color: #343a40 !important;
    color: #ffffff !important;
    border-color: #343a40 !important;
  }
</style>
<div class="row h-100 justify-content-md-center">
    <div class="col my-auto">
<?php
session_start();
if (isset($_SESSION['cargo'])) {
  if ($_SESSION['cargo'] != 3)
    header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');
require_once(__DIR__ . '/../../connect.php');
try {
  $tabela = '<div class="row justify-content-md-center">
  <div class="col-11">';

  $tabela .= '<h1 class="text-dark">Listar Contas</h1>
  <table id="dtBasicExample" class="table table-striped table-dark">
    <thead>
    <tr>
      <th class="align-middle" scope="col">Código da Conta</th>
      <th class="align-middle" scope="col">Tipo de Conta</th>
      <th class="align-middle" scope="col">Pertence a</th>
      <th class="align-middle" scope="col">Iban</th>
      <th class="align-middle" scope="col">Saldo</th>
      <th class="align-middle" scope="col">Limite</th>
      <th class="align-middle" scope="col"></th>
      <th class="align-middle" scope="col"></th>
    </tr>
  </thead>
    <tbody>
    ';




  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $stmt = $db->prepare('Select Nome,Conta.*, TipoConta.Tipo 
  from TipoConta, Conta, Utilizador 
  where Conta.Tipo = TipoConta.idtipo  
  and Utilizador.iduti = Conta.userid 
  order by Conta.idconta');
  $stmt->execute();

  $arr = $stmt->fetchAll();

  foreach ($arr as $key => $value) {
    $tabela .= '<tr><th class="align-middle" scope="row">' . $value->idconta . '</th>';
    $tabela .= '<td class="align-middle">' . $value->Tipo . '</td>';
    $tabela .= '<td class="align-middle">' . $value->Nome . '</td>';
    $tabela .= '<td class="align-middle">' . $value->IBAN . '</td>';
    $tabela .= '<td class="align-middle">' . $value->saldo . '</td>';
    $tabela .= '<td class="align-middle">' . $value->limite . '</td>';
    $tabela .= '<td class="align-middle"><a class="text-light" href="index.php?cmd=FormularioAtualizarConta&id=' . $value->idconta . '">Alterar</a></td>';
    $tabela .= '<td class="align-middle"><a class="text-danger" id="login" data-toggle="modal" data-target="#modaleliminar' . $value->idconta . '" href="index.php?cmd=DeleteConta&id=' . $value->iduti . '">Eliminar</a></td></tr>';

?>
    <div id="modaleliminar<?= $value->idconta ?>" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <font color="black">
              <h4>Apagar a Conta</h4>
          </div>
          <div class="modal-body">
            <form action="index.php?cmd=DeleteConta&id=<?= $value->idconta ?>" method="POST" class="form-horizontal">

              <h1>Têm a certeza que pretende apagar a Conta, Ao eliminar irão ser perdidos permanentemente os dados do mesmo!</h1>
              </font>
              <center>
                <input role="button" type="submit" name="1" class="btn btn-danger" value="Sim">   
                <input name="1" type="submit" class="btn btn-dark" value="Não" data-dismiss="modal">
              </center>
            </form>
          </div>

        </div>
      </div>
    </div>
  <?php
  }





  $tabela .= '</div></div>';
  echo $tabela;
  ?>
  <script>
    $(document).ready(function() {
      $('#dtBasicExample').DataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false,
        "language": {
          "sEmptyTable": "Não foi encontrado nenhum registo",
          "sLoadingRecords": "A carregar...",
          "sProcessing": "A processar...",
          "sLengthMenu": "Mostrar _MENU_ registos",
          "sZeroRecords": "Não foram encontrados resultados",
          "sInfo": "A mostrar _START_ até _END_ de _TOTAL_ registos",
          "sInfoEmpty": "A mostrar de 0 até 0 de 0 registos",
          "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
          "sInfoPostFix": "",
          "sSearch": "Procurar:",
          "sUrl": "",
          "oPaginate": {
            "sFirst": "Primeiro",
            "sPrevious": "Anterior",
            "sNext": "Seguinte",
            "sLast": "Último"
          },
          "oAria": {
            "sSortAscending": ": Ordenar colunas de forma crescente",
            "sSortDescending": ": Ordenar colunas de forma decrescente"
          }
        },
        "pagingType": "simple"

      });
    });
  </script>
<?php
} catch (PDOException $ex) {
  echo $ex;
}
