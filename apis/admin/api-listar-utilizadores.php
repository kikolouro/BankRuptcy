<?php
session_start();
if (isset($_SESSION['cargo'])) {
  if ($_SESSION['cargo'] != 3)
    header('Location: index.php?cmd=SemPerms');
} else header('Location: index.php');
require_once(__DIR__ . '/../../connect.php');
try {

  if (isset($_REQUEST['cmd'])) {
    $cmd = $_REQUEST['cmd'];
  }



?>
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
      <h1 class="text-dark">Listagem dos Utilizadores</h1>
      <?php




      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      $stmt = $db->prepare('Select *, TipoUser from Utilizador, TipoUtilizador where cargo = idTipoUser order by iduti');
      $stmt->execute();
      $arr = $stmt->fetchAll();



      $tabela = '<div class="row justify-content-md-center">
      <div class="col-11">
        <table id="dtBasicExample" class="table table-striped table-dark">
          <thead>
            <tr>
              <th>Código do utilizador</th>
              <th class="align-middle" scope="col">Nome</th>
              <th class="align-middle" scope="col">Cartão de cidadão</th>
              <th class="align-middle" scope="col">Login</th>
              <th class="align-middle" scope="col">Foto</th>
              <th class="align-middle" scope="col">Data de nascimento</th>
              <th class="align-middle" scope="col">Email</th>
              <th class="align-middle" scope="col">Morada</th>
              <th class="align-middle" scope="col">Telefone</th>
              <th class="align-middle" scope="col">Cargo</th>
              <th></th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            ';
      foreach ($arr as $key => $value) {
        $tabela .= '<tr>
              <th class="align-middle">' . $value->iduti . '</th>';
        $tabela .= '<td class="align-middle">' . $value->Nome . '</td>';
        $tabela .= '<td class="align-middle">' . $value->CC . '</td>';
        $tabela .= '<td class="align-middle">' . $value->Login . '</td>';
        $tabela .= '<td class="align-middle"> <img src="' . $value->Foto . '" width="75" height="75"></td>';
        $tabela .= '<td class="align-middle">' . $value->datanasc . '</td>';
        $tabela .= '<td class="align-middle">' . $value->email . '</td>';
        $tabela .= '<td class="align-middle">' . $value->morada . '</td>';
        $tabela .= '<td class="align-middle">' . $value->telefone . '</td>';
        if ($value->TipoUser == 'Cliente')
          $tabela .= '<td><img src="img/cliente.png" width="75" height="75"></td>';
        else if ($value->TipoUser == 'Administrador')
          $tabela .= '<td><img src="img/admin.png" width="75" height="75"></td>';
        if ($value->Verificacao == "Verificado")
          $tabela .= '<td class="align-middle">' . $value->Verificacao . '</td>';
        else
          $tabela .= '<td class="align-middle">Não está Verificado</td>';
        $tabela .= '<td class="align-middle"><a class="text-light" href="index.php?cmd=FormularioAtualizarUtilizador&id=' . $value->iduti . '">Alterar</a></td>';
        $tabela .= '<td class="align-middle"><a class="text-danger" id="login" data-toggle="modal" data-target="#modaleliminar' . $value->iduti . '" href="index.php?cmd=DeleteUtilizador&id=' . $value->iduti . '">Eliminar</a></td>
            </tr>'; ?>

        <div id="modaleliminar<?= $value->iduti ?>" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <font color="black">
                  <h4>Apagar o Utilizador</h4>
              </div>
              <div class="modal-body">
                <form action="index.php?cmd=DeleteUtilizador&id=<?= $value->iduti ?>" method="POST" class="form-horizontal">

                  <h1>Têm a certeza que pretende apagar o utilizador, Ao eliminar irão ser perdidos permanentemente os dados do mesmo!</h1>
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

      $tabela .= '</tbody></table>';
      $tabela .= "</div></div>";

      //echo $form;
      //echo $filtro;
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
    ?>