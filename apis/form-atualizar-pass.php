<?php
session_start();
if (isset($_REQUEST['id']))
    $id = $_REQUEST['id'];
if ($id == $_SESSION['id']) {


?>
    <div class="row h-100">
        <div class="col my-auto">
            <div class="container">
                <div class="jumbotron card kcardbg shadow-sm border-dark">
                    <h1>Alterar Palavra-passe</h1><br>
                    <form class="form-horizontal" action="index.php?cmd=mudapass&id=<?= $id ?>" onsubmit="return ReturnPasses();" method="post">
                        <div class="container">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="pass1">Palavra-passe antiga:</label>
                                </div>
                                <div class="col-8">
                                    <input type="password" class="form-control" onblur='passAntiga(this,<?= $id ?>);' id="passantiga" placeholder="Palavra-passe antiga" name="pass1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="pass1">Nova Palavra-passe:</label>
                                </div>
                                <div class="col-8">
                                    <input type="password" class="form-control" onkeyup="ValidarPass(this);" id="pass1" placeholder="Nova Palavra-passe" name="pass1">
                                    <span id="spanpass" class="badge badge-danger"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label class="control-label " for="pass2">Confirmação da Palavra-passe</label>
                                </div>
                                <div class="col-8">
                                    <input type="password" class="form-control" onkeyup="ValidarPassIgual();" id="pass2" placeholder="Confirmação da nova Palavra-passe" name="pass2">
                                    <span id="spanpass1" class="badge"></span>
                                </div>
                            </div>
                            <div class="row justify-content-md-center">
                                <button type="submit" class="btn btn-dark">Alterar palavra pass</button>   
                                <a role="button" href="index.php" class="btn btn-danger" data-dismiss="modal">Voltar atrás</a>
                            </div>

                        </div>
                        <span id="spanform" class="badge badge-danger"></span>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } else die;
