<?php
session_start();
require_once(__DIR__ . '/../connect.php');
if (isset($_REQUEST['id']))
    $id = $_REQUEST['id'];

$edit = false;

if (isset($_REQUEST['edit']))
    $edit = $_REQUEST['edit'];

if ($id != $_SESSION['id']) {
    if ($_SESSION['cargo'] != 3)
        die;
}


try {
    $stmt = $db->prepare('Select Utilizador.*, TipoUser from Utilizador, TipoUtilizador where iduti = :id and idTipoUser = cargo');
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $arr = $stmt->fetchAll();

    foreach ($arr as $key => $value) {
        $nome = $value->Nome;
        $tel = $value->telefone;
        $foto = $value->Foto;
        $datanasc = $value->datanasc;
        $email = $value->email;
        $cc = $value->CC;
        $cargo = $value->TipoUser;
        $morada = $value->morada;
    }
    $stmt = $db->prepare('Select * from TipoUtilizador where TipoUser <> :cargo  order by idTipoUser');
    $stmt->bindValue(':cargo', "$cargo");
    $stmt->execute();
    $arrTipo = $stmt->fetchAll();

    $stmt = $db->prepare('Select * from TipoUtilizador where TipoUser = :cargo  ');
    $stmt->bindValue(':cargo', "$cargo");
    $stmt->execute();
    $arrTipo2 = $stmt->fetchAll();


?>

    <br><br><br>
    <div class="container">
        <div class="jumbotron card kcardbg shadow-sm border-dark">
            <div class="row">

                <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
                    <img src="<?= $foto ?>" alt="stack photo" width="200" height="200" id="fotoperfil" class="img"><br>
                </div>
                <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8">
                    <div class="container" style="border-bottom:1px solid black">
                        <h2 id="h2nome"><?= $nome ?></h2>
                        <input id="inputnome" class="form-control" placeholder="Nome" value="<?= $nome ?>">
                    </div>
                    <hr>
                    <?php if ($edit) {
                    ?>
                        <script>
                            $(document).ready(function() {
                                $("#divacoes").hide();
                                $("#h2nome").hide();
                                $("#inputnome").show();
                                $("#inputnome2").val($("#inputnome").val());
                                $("#inputnome").keyup(function() {
                                    $("#inputnome2").val($("#inputnome").val());
                                });



                            });
                        </script>
                        <ul class="container details" style="list-style: none;">
                            <form method="POST" action="index.php?cmd=AltPerfil&id=<?= $id ?>">
                                <input id="inputnome2" name="nome" class="form-control" type="hidden" value="">
                                <li>
                                    <p><span class="glyphicon glyphicon-map-marker one" style="width:50px;"></span><input name="cc" placeholder="Cartão de Cidadão" type="number" class="form-control" value="<?= $cc ?>"></p>
                                </li>
                                <li>
                                    <p><span class="glyphicon glyphicon-earphone one" style="width:50px;"></span><input type="number" name="tel" placeholder="Telemovél" class="form-control" value="<?= $tel ?>"></p>
                                </li>
                                <li>
                                    <p><span class="glyphicon glyphicon-envelope one" style="width:50px;"></span><input type="text" name="email" class="form-control" placeholder="Email" value="<?= $email ?>"></p>
                                </li>
                                <li>
                                    <p><span class="glyphicon glyphicon-map-marker one" style="width:50px;"></span><input type="text" name="morada" class="form-control" placeholder="Morada" value="<?= $morada ?>"></p>
                                </li>
                                <li>
                                    <p><span class="glyphicon glyphicon-new-window one" style="width:50px;"></span><input type="date" name="datanscimento" class="form-control" value="<?= $datanasc ?>"></p>
                                </li>
                                <?php /* 
                                <li>
                                    <p><span class="glyphicon glyphicon-new-window one" style="width:50px;"></span>
                                    </p>

                                   if ($_SESSION['cargo'] == 3) { ?> <select class="form-control"><?php
                                            foreach ($arrTipo2 as $key => $value) { ?>
                                                <option value="<?= $value->idTipoUSer ?>"><?= $value->TipoUser ?></option>
                                            <?php }
                                            foreach ($arrTipo as $key => $value) { ?>
                                                <option value="<?= $value->idTipoUser ?>"><?= $value->TipoUser ?></option>
                                            <?php } ?> </select>
                                        </p>
                                    <?php} ?>
                                </li>
                                */
                                ?>

                        </ul>
                        <button type="submit" class="btn btn-dark">Submeter</button>
                        <a href="index.php?cmd=perfil&id=<?= $id ?>" role="button" class="btn btn-danger">Voltar Atrás</a>
                        </form>
                    <?php } else {
                    ?>
                        <script>
                            $(document).ready(function() {
                                $("#divacoes").show();
                                $("#h2nome").show();
                                $("#inputnome").hide();
                            });
                        </script>
                        <ul class="container details" style="list-style: none;">
                            <li>
                                <p><span class="glyphicon glyphicon-map-marker one" style="width:50px;"></span>Cartão de Cidadão: <?= $cc ?></p>
                            </li>
                            <li>
                                <p><span class="glyphicon glyphicon-earphone one" style="width:50px;"></span>Telefone: <?= $tel ?></p>
                            </li>
                            <li>
                                <p><span class="glyphicon glyphicon-envelope one" style="width:50px;"></span>Email: <?= $email ?></p>
                            </li>
                            <li>
                                <p><span class="glyphicon glyphicon-map-marker one" style="width:50px;"></span>Morada: <?= $morada ?></p>
                            </li>
                            <li>
                                <p><span class="glyphicon glyphicon-new-window one" style="width:50px;"></span>Data de Nascimento: <?= $datanasc ?></p>
                            </li>
                            <li>
                                <p><span class="glyphicon glyphicon-new-window one" style="width:50px;"></span>Cargo: <?= $cargo ?></p>
                            </li>
                        </ul>
                    <?php } ?>

                    <!--<div class="btn btn-group" id="divacoes"> -->
                        <a class="btn dropdown-toggle btn-dark" data-toggle="dropdown" href="#">
                            Editar
                            <span class="icon-cog icon-white"></span><span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a role="button" class="text-dark" href="index.php?cmd=perfil&id=<?= $id ?>&edit=true"><span class="icon-wrench">  </span> Editar Perfil  </a></li>
                            <li><a role="button" class="text-dark" href="index.php?cmd=atualizarPass&id=<?= $id ?>"><span class="icon-wrench">  </span> Mudar de Password  </a></li>
                            <li><a role="button" data-toggle="modal" data-target="#modalfoto" class="text-dark" id="foto1" href="#">  <span class="icon-wrench">  </span> Editar fotografia  </a></li>
                        </ul>
                    <!-- </div> -->
                </div>

            </div>
        </div>
    </div>
    <?php /*
    if ($_SESSION['cargo'] == 3) {
    ?>
    <div class="row justify-content-center">
        <div class="md-form">
            <label for="form-autocomplete">
                <p class="text-dark"> Pesquisar Utilizadores</p>
            </label>
            <div class="col-6">
                    <input type="search" id="form-autocomplete" onkeyup="PesquisarPerfil(this);" class="form-control mdb-autocomplete"><br>
            </div>
        </div>
        <div id="divpesq" class="">
            <div class="row" id="divpesq2">
                <font color="black">

            </div>
            </font>
        </div>
    </div>
    <?php } 
    */
    ?>
    </div>
    <div id="modalfoto" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <font color="black">
                        <h4>Arraste a fotografia ou clique na caixa</h4>
                    </font>
                    <button type="button" class="close" data-dismiss="modal"> &times;</button>

                </div>
                <div class="modal-body">
                    <!--index.php?cmd=Registo -->

                    <form action="index.php?cmd=AlterarFoto&id=<?= $id ?>" method="POST" class="form-horizontal" enctype="multipart/form-data">

                        <div class="form-group">
                            <label class="sr-only" for="password"></label>
                            <input type="file" class="form-control input-sm" value="<?= $foto ?>" placeholder="Sua foto" id="foto" name="foto">
                            <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                        </div>
                        <center>
                            <span id="spanform" class="badge badge-danger"></span><br><br>
                            <button type="submit" class="btn btn-dark">Alterar</button>   
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </center>
                    </form>
                </div>

            </div>
        </div>
    </div>

<?php


} catch (PDOException $ex) {
    echo $ex;
}
