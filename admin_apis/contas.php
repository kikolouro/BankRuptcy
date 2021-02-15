<?php
require_once(__DIR__ . '/../connect.php');
if (isset($_REQUEST['vermais']))
	$vermais = $_REQUEST['vermais'];


try {
	$stmt = $db->prepare('Select Utilizador.iduti as idutilizador, Nome, Conta.*, TipoConta.Tipo, Conta.tipo as Tipodaconta
    from TipoConta, Conta, uticonta, Utilizador 
    where Conta.Tipo = TipoConta.idtipo  
    and uticonta.idconta = Conta.idconta 
    and Utilizador.iduti = uticonta.iduti 
    order by Conta.idconta');
	$stmt->execute();
	$arrUti = $stmt->fetchAll();


	if (isset($vermais)) {
		$string .= '<div class="container">';

		$string .= '<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="85%">';

		$string .= '
	<thead>
	<th scope="col">Código da Conta</th>
	<th scope="col">Tipo de Conta</th>
	<th scope="col">Pertence a</th>
	<th scope="col">Iban</th>
	<th scope="col">Saldo</th>
	<th scope="col">Limite</th>
	  </thead>
	  <tbody>';
		foreach ($arrUti as $key => $value) {
			if ($value->idconta == $vermais) {
				$stmt = $db->prepare('Select * from TipoConta where idTipo <> :tipo');
				$stmt->bindValue(':tipo', $value->Tipodaconta);
				$stmt->execute();
				$arrTipos = $stmt->fetchAll();
				$stmt = $db->prepare('Select * from Utilizador where iduti <> :idtulizador');
				$stmt->bindValue(':idtulizador', $value->idutilizador);
				$stmt->execute();
				$arrUtis = $stmt->fetchAll();
				$string .= '<tr>';
				$string .= '<td>' . $value->idconta . '</td>';
				$string .= '<td>' . $value->Tipo . '</td>';
				$string .= '<td>' . $value->Nome . '</td>';
				$string .= '<td>' . $value->IBAN . '</td>';
				$string .= '<td>' . $value->saldo . '</td>';
				$string .= '<td>';
				if ($value->limite > 0)
					$string .= $value->limite;
				else $string .= "Não tem limite";
				$string .= '</td>';

				$string .= '</tr>';
				$string .= '</tbody></table>';

				echo $string;
?>
				<br><br>
				<div class="col-10 my-auto">
					<form class="form-horizontal" action="index.php?cmd=AtualizarContas&id=<?= $value->idconta ?>" method="post">
						<div class="container">
							<div class="form-group row">
								<div class="col-4">
									<label class="control-label " for="id">Código da conta:</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control" name="id" value="<?= $value->idconta ?>" disabled>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-4">
									<label class="control-label" for="iban">IBAN:</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control" name="iban" value="<?= $value->IBAN ?>">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-4">
									<label class="control-label " for="tipo">Tipo da Conta</label>
								</div>	
								<div class="col-8">
									<select name="tipo" class="form-control">
										<option value="<?= $value->Tipodaconta ?>">
											<?= $value->Tipo ?>
										</option>
										<?php
										foreach ($arrTipos as $key => $tipos) {
										?>
											<option value="<?= $tipos->idTipo ?>">
												<?= $tipos->Tipo ?>
											</option>
										<?php

										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-4">
									<label class="control-label " for="pertence">Pertence a:</label>
								</div>
								<div class="col-8">
									<select name="tipo" class="form-control">
										<option value="<?= $value->idutilizador ?>">
											<?= $value->Nome ?>
										</option>
										<?php
										foreach ($arrUtis as $key => $utis) {
										?>
											<option value="<?= $utis->iduti ?>">
												<?= $utis->Nome ?>
											</option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<button type="submit" class="btn btn-primary">Atualizar</button>
						</div>
					</form>
				</div>
<?php
			}
		}
	} else {

		$string .= '<div class="container">';

		$string .= '<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="85%">';

		$string .= '
	<thead>
	<th scope="col">Código da Conta</th>
	<th scope="col">Tipo de Conta</th>
	<th scope="col">Pertence a</th>
	<th scope="col">Iban</th>
	<th scope="col">Saldo</th>
	<th scope="col">Limite</th>
	<th scope="col">Ver mais</th>
	  </thead>
	  <tbody>';

		foreach ($arrUti as $key => $value) {
			$string .= '<tr>';
			$string .= '<td>' . $value->idconta . '</td>';
			$string .= '<td>' . $value->Tipo . '</td>';
			$string .= '<td>' . $value->Nome . '</td>';
			$string .= '<td>' . $value->IBAN . '</td>';
			$string .= '<td>' . $value->saldo . '</td>';
			$string .= '<td>';
			if ($value->limite > 0)
				$string .= $value->limite;
			else $string .= "Não tem limite";
			$string .= '</td>';
			$string .= '<td><a target="BLANK" href="admin.php?cmd=contas&vermais=' . $value->idconta . '">Ver Mais</a></td>';
			$string .= '</tr>';
		}
		$string .= "</tbody></table>";
		$string .= "<script>$(document).ready(function () {
			$('#dtBasicExample').DataTable();
			$('.dataTables_length').addClass('bs-select');
		  });</script>
		  
		<a href='admin.php?cmd=utilizadoresadd' align='right' class='btn btn-primary' role='buttom' >Adicionar Utilizador </a>
		  ";

		echo $string;
	}
} catch (PDOException $ex) {
	echo $ex;
}
