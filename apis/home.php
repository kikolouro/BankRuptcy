<?php
session_start();
require_once(__DIR__ . '/../connect.php');
try {
  $stmt = $db->prepare('Select Nome,Conta.*, TipoConta.Tipo 
    from TipoConta, Conta, Utilizador 
    where Conta.Tipo = TipoConta.idtipo  
    and Conta.userid = Utilizador.iduti
    and Utilizador.iduti = :id
    order by Conta.idconta');
  $stmt->bindValue(':id', $_SESSION['id']);
  $stmt->execute();
  $arr = $stmt->fetchAll();
  $cont = 0;
  foreach ($arr as $key => $value) {
    $cont++;
  }
} catch (PDOException $ex) {
  echo $ex;
}
?>
<div class="row h-100">

  <?php
  if (!isset($_SESSION['Nome'])) {
  ?>
    <div class="col-lg-7 my-auto">
      <div class="header-content mx-auto">
        <div class="card kcardbg shadow-sm border-dark">
          <div class="card-body">
            <h3 class="card-title">Bank ruptcy é o banco português com menos taxas!</h3>
            <ul class="list-group list-group-flush">
              <a href="#" data-toggle="modal" data-target="#modalregisto" class="btn btn-outline btn-xl js-scroll-trigger">Adere ao Banco BankRuptcy agora!</a>
            </ul>

          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5 my-auto">
      <div class="device-container">
        <div class="device-mockup iphone6_plus portrait black">
          <div class="device">
            <div class="screen">
              <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
              <img src="img/demo-screen-1.jpg" class="img-fluid" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<?
  } else {
    if (!strcmp($_SESSION['VerKey'], 'Verificado')) {

?>
<div class="col-lg my-auto">
  <div class="header-content mx-auto">
    <div class="card kcardbg shadow-sm border-dark " style="color:white;">
      <div class="card-body">
        <h3 class="card-title"><strong>Suas Contas: <span class="badge badge-dark badge-pill"><?= $cont ?></span></strong> </h3><br>
        <ul class="list-group list-group-flush">
          <?php

          foreach ($arr as $key => $value) {
            echo '<li class="list-group-item kcardbg">';
            if ($value->limite != 0)
              echo '<p class="card-text">Iban: ' . $value->IBAN . '<br> Saldo: ' . $value->saldo . ' Tipo: ' . $value->Tipo . ' Limite: ' . $value->limite . '</p>';
            else echo '<p class="card-text">Iban: ' . $value->IBAN . '<br> Saldo: ' . $value->saldo . ' Tipo: ' . $value->Tipo . '</p>';
            if ($_SESSION['cargo'] == 3)
              echo '<a href="adicionarsaldo.php?idconta=' . $value->idconta . '" class="btn btn-danger">Adicionar saldo(apenas para debug)</a>';

            echo '</li><br>';
          }
          if ($cont == 0)
            echo '<li class="list-group-item kcardbg"><p class="card-text">Não tem contas</p></li>';

          echo '<br></ul><br><ul class="list-group list-group-flush"><a class="btn btn-dark" data-toggle="modal" data-target="#modalcriarconta" href="index.php?cmd=CriarConta" role="button">Criar Conta</a></ul>';
          ?>

      </div>
    </div>
  </div>
</div>

<?php
  } else {
?>
  <div class="col-lg my-auto">
    <div class="header-content mx-auto">
      <div class="card shadow-sm border-dark " style="color:black;">
        <div class="card-body">
          <h3 class="card-title"><strong>Têm que estar Verificado para criar conta. Verifique o seu email.</strong> </h3><br>


        </div>
      </div>
    </div>
  </div>
<?php
  }
?>

<div class="col-lg my-auto">
  <div class="header-content mx-auto">
    <div class="card kcardbg shadow-sm border-dark" style="color:white;">
      <div class="card-body">
        <h3 class="card-title"><strong>Requisite já o seu cartão BankRuptcy</strong></h3><br>
        <center>
          <img id="myImg" alt="Cartão BankRuptcy" src="img/cartao.png" width="286" height="180"><br>
        </center>
        <ul class="list-group  list-group-flush">
          <li class="list-group-item kcardbg">
            <p class="card-text">
              Apartir de <b>1/Janeiro/2025</b> o uso de cartão vai ser obrigatório!
            </p>
          </li>
          <br>
          <li class="list-group-item kcardbg">
            <p class="card-text">
              Requisite o cartão no banco mais próximo de si!
            </p>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
</div>

</header>
<section class="download bg-primary text-center" id="download">
  <div class="card kcardbg shadow-sm " style="color:white;">
    <div class="container">

      <div class="row">
        <div class="col-md mx-auto">

          <h2 class="section-heading">Imprimir Informações</h2>
          <p>Clique nos botões para imprimir a devida informação</p>
          <a target="BLANK" class="btn btn-dark " href="pdf/PDFUtilizador.php?id=<?= $_SESSION['id'] ?>">Informação do utilizador</a>
          <a target="BLANK" class="btn btn-dark" href="pdf/pdf2.php?id=<?= $_SESSION['id'] ?>">Informações das contas</a>
          <a target="BLANK" class="btn btn-dark" href="pdf/PDFTrasacoes.php?id=<?= $_SESSION['id'] ?>">Transações de todas as contas*</a><br>

        </div>
      </div>
    </div>
  </div>
</section>

<?
  }
?>
</div>
<div id="modalregisto" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <font color="black">
          <h4>Registo</h4>
        </font>
        <button type="button" class="close" data-dismiss="modal"> &times;</button>

      </div>
      <div class="modal-body">
        <!--index.php?cmd=Registo -->

        <form action="index.php?cmd=Registo" method="POST" class="form-horizontal" onsubmit="return ValidarForm();" enctype="multipart/form-data">
          <div class="form-group">
            <label class="sr-only" for="Nome">Nome:</label>
            <input type="text" class="form-control input-sm" placeholder="O Seu Nome" onblur="return ValidarNome(this);" id="Nome" name="Nome">
            <span id="spannome" class="badge badge-danger"></span>
          </div>
          <div class="form-group">
            <label class="sr-only" for="password">Cartão de cidadão:</label>
            <input type="number" class="form-control input-sm" placeholder="Cartão de cidadão" onBlur="return ValidarCC(this);" id="cc" name="cc">
          </div>
          <div class="form-group">
            <label class="sr-only" for="password">Data de nascimento:</label>
            <input type="date" class="form-control input-sm" id="datanasc" onBlur="return ValidarData(this);" name="datanasc">
            <small id="datanaschelp" class="form-text text-muted">Data de Nascimento</small>
          </div>
          <div class="form-group">
            <label class="sr-only" for="password">Email:</label>
            <input type="text" class="form-control input-sm" placeholder="Email" id="email" onBlur="return ValidarEmail(this);" name="email">
          </div>
          <div class="form-group">
            <label class="sr-only" for="password">Telefone:</label>
            <input type="number" class="form-control input-sm" placeholder="Telefone" onBlur="return ValidarTel(this);" id=" tel" name="tel">
          </div>
          <div class="form-group">
            <label class="sr-only" for="password">Palavra-pass:</label>
            <input type="password" class="form-control input-sm" placeholder="Password" onkeyup="ValidarPass(this);" id="pass1" name="Pass">
            <span id="spanpass" class="badge badge-danger"></span>
          </div>
          <div class="form-group">
            <label class="sr-only" for="password">Confirme Palavra-pass:</label>
            <input type="password" class="form-control input-sm" placeholder="Confirme Password" onkeyup="ValidarPassIgual();" id="pass2" name="">
            <span id="spanpass1" class="badge"></span>
          </div>
          <div class="form-group">
            <label class="sr-only" for="password">Morada:</label>
            <input type="text" class="form-control input-sm" placeholder="Morada" id="morada" name="morada">
          </div>
          <div class="form-group">
            <label class="sr-only" for="password">Sua foto:</label>
            <input type="file" class="form-control input-sm" placeholder="Sua foto" id="foto" name="foto">
            <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
            <small id="filehelp" class="form-text text-muted">Sua foto aqui. Caso não insira vai ter uma automatica.</small>
          </div>
          <center>
            <span id="spanform" class="badge badge-danger"></span><br><br>
            <button type="submit" class="btn btn-dark">Registar</button>   
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </center>
        </form>
      </div>

    </div>
  </div>
</div>



<div id="myModal" class="kmodal">

  <span id="spanmodal" class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>

</div>





<script>
  var modal = document.getElementById("myModal");

  // Get the image and insert it inside the modal - use its "alt" text as a caption
  var img = document.getElementById("myImg");
  var modalImg = document.getElementById("img01");
  var captionText = document.getElementById("caption");
  img.onclick = function() {
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
  }

  // Get the <span> element that closes the modal
  var span = $("#spanmodal");

  // When the user clicks on <span> (x), close the modal
  span.click(function() {
    modal.style.display = "none";
  });
</script>