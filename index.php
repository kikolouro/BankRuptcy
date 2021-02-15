<?php
session_start();
require_once('connect.php');
if (isset($_REQUEST['cmd'])) $cmd = $_REQUEST['cmd'];
else $cmd = 'home';

if (isset($_REQUEST['Verkey'])) {
    $verkey = $_REQUEST['Verkey'];
    $cmd = 'VerKey';
}
$cookflag = true;



if (isset($_REQUEST['cookie'])) {
    $cook = $_REQUEST['cookie'];

    if ($cook == 'sim') {
        setcookie("User", $_SESSION['Nome'], time() + (86400 * 30), "/");
        $cookflag = false;
    } else {
        setcookie("User", "nao", time() + (86400 * 30), "/");
        $cookflag = false;
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="css/botao.css" rel="stylesheet">
    <link href="css/autocomplete.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bank Ruptcy</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="img/logo.png">
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/criarconta.js"></script>
    <link href="admin_css/addons/datatables.min.css" rel="stylesheet">
    <?php
    if (!isset($_COOKIE['User'])) {
        if (isset($_SESSION['Nome'])) {
            if ($cookflag) {
    ?>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#modalcookie").modal('show');
                    });
                </script>
    <?php
            }
        }
    }
    ?>
    <script>
        var onloadCallback = function() {
            grecaptcha.render('captcha1', {
                'sitekey': '6Ld7vs0UAAAAAL-MDbd2BYfSMaPEPiKYkrA_5YMO'
            });
        };
    </script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
    </script>
    <!-- Plugin CSS -->
    <link rel="stylesheet" href="device-mockups/device-mockups.min.css">

    <!-- Custom styles for this template -->
    <link href="css/new-age.css" rel="stylesheet">


    <script>
        /*
        $(function() {
            var dataa = $("#tags").val();
            $.ajax({

                url: "apis/criarcontamult.php",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    dataa: dataa
                },
                success: function(response) {

                    $("#tags").autocomplete({
                        source: response
                    });

                },
                error: function() {
                    alert("erro");
                }
            });



        });
        */
    </script>
</head>

<body id="page-top">
    <!--
    <div class="ui-widget">
        <label for="tags">Tags: </label>
        <input id="tags">
    </div>
     Navigation  -->

    <?php


    ?>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger kcolor" href="index.php">Bank Ruptcy</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <?php
                    //echo crypt("Aa1");
                    if (isset($_SESSION['cargo'])) {
                        if (!strcmp($_SESSION['cargo'], "3")) {
                    ?>
                            <!--   <li class="nav-item ">
                                    <a class="nav-link" href="admin.php" id="navbarDropdown">
                                        BackOffice
                                    </a>

                                </li>
                            -->
                            <li class="nav-item dropdown">
                                <a class="kcolor nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tipos de Utilizadores
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="kcolor dropdown-item" href="index.php?cmd=ListarTipoUtilizadores">Listar Tipos de Utilizadores</a>
                                    <a class="kcolor dropdown-item" href="index.php?cmd=FormularioAdicionarTipoUtilizadores">Adicionar Tipos de Utilizadores</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="kcolor nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Utilizadores
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="kcolor dropdown-item" href="index.php?cmd=ListarUtilizadores">Listar Utilizadores</a>
                                    <a class="kcolor dropdown-item" href="index.php?cmd=FormularioAdicionarUtilizadores">Adicionar Utilizadores</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="kcolor nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Contas
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="kcolor dropdown-item" href="index.php?cmd=ListarContas">Listar Contas</a>
                                    <a class="kcolor dropdown-item" href="index.php?cmd=FormularioAdicionarContas">Adicionar Contas</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="kcolor nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Tipos de conta
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                    <a class="kcolor dropdown-item" href="index.php?cmd=ListarTipoConta">Listar Tipos de conta</a>
                                    <a class="kcolor dropdown-item" href="index.php?cmd=FormularioAdicionarTipoConta">Adicionar Tipos de conta</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="kcolor nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Transações
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a target="BLANK" class="kcolor dropdown-item" href="pdf/PDFTrasacoes2.php">Listar Transações</a>
                                </div>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="kcolor nav-link js-scroll-trigger" href="index.php?cmd=logout">Logout</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="kcolor nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['Nome'] ?></a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                <a class="kcolor dropdown-item" href="#"><img src="<?= $_SESSION['foto'] ?>" class="rounded-circle bg-dark" width="75" height="75"> </a>
                                <a class="kcolor dropdown-item" href="index.php?cmd=perfil&id=<?= $_SESSION['id'] ?>">Ver Perfil</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="kcolor nav-link js-scroll-trigger" href="index.php?cmd=FormularioFazerTransacao">Fazer Transação</a>
                        </li>
                    <?php } else { ?> <li class="nav-item">
                            <a class="kcolor nav-link js-scroll-trigger" href="#" id="login" data-toggle="modal" data-target="#modallogin">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="kcolor nav-link js-scroll-trigger" href="index.php?cmd=contact">Contactos</a>
                        </li>
                    <?php } ?>

                </ul>
            </div>
        </div>
    </nav>


    <header class="masthead text-center bg-primary text-white">
        <div class="container-fluid h-100">

            <?php

            //echo "asdasdasd";
            $a = 0;
            switch ($cmd) {
                case "home":
                    require('apis/home.php');
                    break;
                case "FormularioAdicionarTipoUtilizadores":
                    require('apis/admin/form-adicionar-tipo-utilizadores.php');
                    break;
                case "DeleteTipoUser":
                    require('apis/admin/api-delete-tipouser.php');
                    break;
                case "AtualizarTipoUser":
                    require('apis/admin/api-atualizar-tipouser.php');
                    break;
                case "FormularioAtualizarTipoUser":
                    require('apis/admin/form-atualizar-tipouser.php');
                    break;
                case "AdicionarTipoUser":
                    require('apis/admin/api-adicionar-tipo-utilizador.php');
                    break;
                case "ListarUtilizadores":
                    require('apis/admin/api-listar-utilizadores.php');
                    break;
                case "ListarTipoUtilizadores":
                    require('apis/admin/api-listar-tipo-utilizadores.php');
                    break;
                case  "FormularioAdicionarUtilizadores":
                    require('apis/admin/form-adicionar-utilizadores.php');
                    break;
                case  "AdicionarUtilizadores":
                    require('apis/admin/api-adicionar-utilizadores.php');
                    break;
                case  "registocompleto": {
                        if ($a != 1) {
                            if (isset($_REQUEST['qwe'])) {
                                $a = 1;
                                echo '<script>$(document).ready(function(){
                                  $("#modallogin").modal();
                                });</script>';
                            }
                        }
                        echo '<br><br><h1 class="text-dark">Registo efetuado com sucesso!</h1><br>';
                        echo '<h1 class="text-dark"> Verifique os seu email e de seguida faça login.</h1>';
                        echo '<meta http-equiv="refresh" content="5;url=index.php?cmd=registocompleto&qwe=1" />';
                        break;
                    }
                case  "success":
                    echo '<br><br><h1>Operação realizada com sucesso</h1><br>';
                    echo '<h1> Vai ser redirecionado em 2 segundos</h1>';
                    echo '<meta http-equiv="refresh" content="2;url=index.php" />';
                    break;
                case  "AdicionarTipoConta":
                    require('apis/admin/api-adicionar-tipoconta.php');
                    break;
                case  "FormularioAdicionarTipoConta":
                    require('apis/admin/form-adicionar-tipoconta.php');
                    break;
                case "ListarTipoConta":
                    require('apis/admin/api-listar-tipoconta.php');
                    break;
                case "ListarContas":
                    require('apis/admin/api-listar-conta.php');
                    break;
                case "FormularioAdicionarContas":
                    require('apis/admin/form-adicionar-conta.php');
                    break;
                case "AdicionarContas":
                    require('apis/admin/api-adicionar-contas.php');
                    break;
                case "Login":
                    require('apis/api-login.php');
                    break;
                case "logout":
                    require('apis/api-logout.php');
                    break;
                case "FormularioAtualizarUtilizador":
                    require('apis/admin/form-atualizar-utilizadores.php');
                    break;
                case "AtualizarUtilizadores":
                    require('apis/admin/api-atualizar-utilizador.php');
                    break;
                case "SemPerms":
                    echo '<br><br><h1>Não tem permissão para entrar no site</h1><br>';
                    echo '<h1> Vai ser redirecionado em 2 segundos</h1>';
                    echo '<meta http-equiv="refresh" content="2;url=index.php" />';
                    break;
                case "DeleteUtilizador":
                    require('apis/admin/api-delete-utilizador.php');
                    break;
                case "DeleteConta":
                    require('apis/admin/api-delete-conta.php');
                    break;
                case "FormularioAtualizarConta":
                    require('apis/admin/form-atualizar-conta.php');
                    break;
                case "AtualizarConta":
                    require('apis/admin/api-atualizar-conta.php');
                    break;
                case "AtualizarTipoConta":
                    require('apis/admin/api-atualizar-tipoconta.php');
                    break;
                case "FormularioAtualizarTipoConta":
                    require('apis/admin/form-atualizar-tipoconta.php');
                    break;
                case "DeleteTipoConta":
                    require('apis/admin/api-delete-tipoconta.php');
                    break;
                case "ListarTransacoes":
                    require('apis/admin/api-listar-transacoes.php');
                    break;
                case "FormularioFazerTransacao":
                    require('apis/form-fazer-transacao.php');
                    break;
                case "FazerTrasacao":
                    require('apis/api-fazer-transacao.php');
                    break;
                case "TransacaoFail":
                    echo '<br><br><h1>Algo deu errado na Transação, Tente mais tarde ou contacte um Administrador</h1><br>';
                    echo '<h1> Vai ser redirecionado em 2 segundos</h1>';
                    echo '<meta http-equiv="refresh" content="2;url=index.php" />';
                    break;
                case "Registo":
                    require('apis/api-registo.php');
                    break;
                case "atualizarPass":
                    //echo "asdojknasfndjkoasndik";
                    require('apis/form-atualizar-pass.php');
                    break;
                case "loginInv":
                    echo '<br><br><h1>Algo errado no Login, Confirme os seus credêniais ou Tente mais tarde ou contacte um Administrador</h1><br>';
                    echo '<h1> Vai ser redirecionado em 2 segundos</h1>';
                    echo '<meta http-equiv="refresh" content="2;url=index.php" />';
                    break;
                case "perfil":
                    require('apis/perfil.php');
                    break;
                case "AlterarFoto":
                    require('apis/api-alterar-foto.php');
                    break;
                case "AltPerfil":
                    require('apis/altperfil.php');
                    break;
                case "mudapassmailsucc":
                    echo '<br><br><h1>Foi lhe enviado um email de confirmação. Abra o link que lhe foi mandado e prossiga por lá. Pode fechar esta janela.</h1><br>';
                    break;
                case "mudapassmail":
                    require('apis/email-mudar-pass.php');
                    break;
                case "mudapass":
                    require('apis/api-alterar-pass.php');
                    break;
                case "contact":
                    require('apis/contact.php');
                    break;
                case "mudapasstxt":
                    echo '<br><br><h1>Palavra-pass alterada com sucesso, faça login com a sua nova password para prosseguir.</h1><br>';
                    break;
                case "VerKey":
                    require('apis/verificar.php');
                    break;
                case "successVer":
                    echo '<br><br><h1>Está Agora Verificado Efetue Login Para Entrar na sua conta</h1><br>';
                    echo '<h1> Vai ser redirecionado em 2 segundos</h1>';
                    echo '<meta http-equiv="refresh" content="2;url=index.php" />';
                    break;
                case "CriarConta":
                    require('apis/CriarConta.php');
                    break;
            }




            /*<div class="row h-100">
    <div class="col my-auto">
        
    </div>*/


            ?>

        </div>
    </header>
    <div id="modalmudaPass" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Mudar de Password</h4>
                    <button type="button" class="close" data-dismiss="modal"> &times;</button>
                </div>
                <div class="modal-body">
                    <center>
                        <h4>Deseja mudar a palavra pass? É recomendado mudar a password</h4>
                        <a role="button" href="index.php?cmd=atualizarPass&id=<?= $_SESSION['id'] ?>" class="btn btn-primary ">Sim</a>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
                    </center>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div id="modallogin" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Login</h4>
                    <button type="button" data-dismiss="modal"> &times;</button>
                </div>
                <div class="modal-body">
                    <form action="index.php?cmd=Login" method="POST" class="form-horizontal">
                        <div class="form-group">
                            <label class="sr-only" for="user">Username</label>
                            <?php if (!isset($_COOKIE['User'])) { ?>
                                <input type="text" class="form-control input-sm" placeholder="Nome@código" id="user" name="user">
                            <?php

                            } else {
                            ?>
                                <input type="text" class="form-control input-sm" placeholder="Nome@código" id="user" value="<?= ($_COOKIE['User'] != 'nao') ? $_COOKIE['User'] : "" ?>" name="user">
                            <?php

                            }
                            ?>
                        </div>
                        <div class="form-group">

                            <label class="sr-only" for="password">Password</label>
                            <input type="password" class="form-control input-sm" placeholder="Password" id="password" name="password">
                        </div>


                        <center>
                            <div id="captcha1"></div>
                            <br>
                            <button type="submit" class="btn btn-dark">Sign in</button>   
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </center>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div id="modalcriarconta" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Criar uma Conta</h4>
                    <button type="button" data-dismiss="modal"> &times;</button>
                </div>
                <div class="modal-body">
                    <center>
                        <h4>Selecione um Tipo de Conta</h4>
                        <form action="index.php?cmd=CriarConta" method="POST">
                            <?php
                            try {
                                $stmt = $db->prepare('Select * from TipoConta order by idTipo');
                                $stmt->execute();
                                $arr = $stmt->fetchAll();
                            ?>
                                <select id="selectcriarconta" class="form-control" name="tipo">
                                    <?php foreach ($arr as $key => $value) { ?>
                                        <option value="<?= $value->idTipo ?>"><?= $value->Tipo ?></option>
                                    <?php } ?>
                                </select>
                            <?php
                            } catch (PDOException $ex) {
                                echo $ex;
                            }
                            ?>
                            <br>

                            <input class="form-control input-sm" placeholder="Email da pessoa que quer criar a conta" id="tags" name="email">

                            <input class="form-control input-sm" type="text" id="selectlimite" name="limite" placeholder="Limite da Conta"> <br>
                            <button type="submit" class="btn btn-dark">Criar Conta</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </form>
                    </center>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div id="modalcookie" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Deseja guardar o seu nome de login?</h4>
                    <button type="button" data-dismiss="modal"> &times;</button>
                </div>
                <div class="modal-body">
                    <center>
                        <h4>Ao guardar o seu nome de login, ao aparecer a caixa de login não terá de escrever o seu Login, apenas a Password</h4>
                        <a role="button" href="index.php?cookie=sim" class="btn btn-dark ">Sim</a>
                        <a role="button" href="index.php?cookie=nao" class="btn btn-danger">Não</a>
                    </center>
                    </form>
                </div>

            </div>
        </div>
    </div>



    <!-- Bootstrap core JavaScript -->

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/new-age.min.js"></script>

    <script src="js/validate.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/admin.js"></script>
    <script type="text/javascript" src="admin_js/addons/datatables.min.js"></script>
</body>

</html>