<style>
  label {
    color: #343a40 !important;
  }

  input {
    color: #ffffff !important;
    background-color: #343a40 !important;
    border-color: #343a40 !important;
  }

  .disabled {
    background-color: #a3acb3 !important;
    border-color: #a3acb3 !important;
  }

  .paginate_button a {
    background-color: #343a40 !important;
    color: #ffffff !important;
    border-color: #343a40 !important;
  }
</style>
<div class="row h-100 justify-content-md-center">
  <div class="col my-auto">
    <h1 class="text-dark">Listagem dos Tipos de Conta</h1>
    <?php
    session_start();
    if (isset($_SESSION['cargo'])) {
      if ($_SESSION['cargo'] != 3)
        header('Location: index.php?cmd=SemPerms');
    } else header('Location: index.php');
    require_once(__DIR__ . '/../../connect.php');
    try {
      $stmt = $db->prepare('Select * from TipoConta order by idTipo');
      $stmt->execute();
      $arr = $stmt->fetchAll();


      $tabela = '<div class="row justify-content-md-center">
  <div class="col-11">';
      $tabela .= '
  <table id="dtBasicExample" class="table table-striped table-dark">
    <thead>
    <tr>
      <th scope="col">Código do Tipo de Conta</th>
      <th scope="col">Tipo de Conta</th>

      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
    <tbody>
    ';
      foreach ($arr as $key => $value) {
        $tabela .= '<tr><th scope="row">' . $value->idTipo . '</th>';
        $tabela .= '<td>' . $value->Tipo . '</td>';

        $tabela .= '<td><a class="text-light" href="index.php?cmd=FormularioAtualizarTipoConta&id=' . $value->idTipo . '">Alterar</a></td>';
        $tabela .= '<td><a class="text-danger" id="login" data-toggle="modal" data-target="#modaleliminar' . $value->idTipo . '" href="index.php?cmd=DeleteTipoConta&id=' . $value->idTipo . '">Eliminar</a></td></tr>';

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
                    <input type="submit" name="1" class="btn btn-danger" value="Sim">   
                    <input name="1" type="submit" class="btn btn-dark" value="Não" data-dismiss="modal">
                  </center>
                </form>
              </div>

            </div>
          </div>
        </div>
      <?php

      }
      $tabela .= '</tbody></table></div></div>';
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
