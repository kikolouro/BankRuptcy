<?php
require_once(__DIR__ . '/../connect.php');
if (isset($_REQUEST['vermais']))
	$vermais = $_REQUEST['vermais'];


try {
	$stmt = $db->prepare('Select *, TipoUser from Utilizador, TipoUtilizador where cargo = idTipoUser order by iduti');
	$stmt->execute();
	$arrUti = $stmt->fetchAll();


	if (isset($vermais)) {
		$string .= '<div class="container">';

		$string .= '<table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="85%">';

		$string .= '
	<thead>
      <th class="th-sm">ID
      </th>
      <th class="th-sm">Nome
	  </th>
	  <th class="th-sm">Cartão de Cidadão
	  </th>
	  <th class="th-sm">Login
	  </th>
	  <th class="th-sm">Data de Nascimento
      </th>
      <th class="th-sm">Email
      </th>
      <th class="th-sm">Telefone
	  </th>
	  <th class="th-sm">Morada
      </th>
      <th class="th-sm">Cargo
	  </th>
	  <th class="th-sm">Fotografia
	  </th>
	  </thead>
	  <tbody>';
		foreach ($arrUti as $key => $value) {
			if ($value->iduti == $vermais) {
				$string .= '<tr>';
				$string .= '<td>' . $value->iduti . '</td>';
				$string .= '<td>' . $value->Nome . '</td>';
				$string .= '<td>' . $value->CC . '</td>';
				$string .= '<td>' . $value->Login . '</td>';
				$string .= '<td>' . $value->datanasc . '</td>';
				$string .= '<td>' . $value->email . '</td>';
				$string .= '<td>' . $value->telefone . '</td>';
				$string .= '<td>' . $value->morada . '</td>';

				if ($value->TipoUser == 'Cliente')
					$string .= '<td><img src="img/cliente.png" width="50" height="50"></td>';
				else if ($value->TipoUser == 'Administrador')
					$string .= '<td><img src="img/admin.png" width="50" height="50"></td>';
				$string .= '<td><img src="' . $value->Foto . '" width="50" height="50"></td>';
				$string .= '</tr>';
				$string .= '</tbody></table>';

				echo $string;
?>
				<br><br>
				<div class="col-10 my-auto">
					<form class="form-horizontal" action="index.php?cmd=AtualizarUtilizadores&id=<?= $value->iduti ?>" method="post">
						<div class="container">
							<div class="form-group row">
								<div class="col-4">
									<label class="control-label " for="id">Código do utilizador:</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control" name="id" value="<?= $value->iduti ?>" disabled>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-4">
									<label class="control-label" for="Nome">Nome:</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control" name="Nome" value="<?= $value->Nome ?>">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-4">
									<label class="control-label " for="cc">Cartão de cidadão:</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control" name="cc" value="<?= $value->CC ?>">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-4">
									<label class="control-label " for="foto">Fotografia:</label>
								</div>
								<div class="col-8">
									<input type="file" class="form-control" name="foto">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-4">
									<label class="control-label " for="datanasc">Data de Nascimento:</label>
								</div>
								<div class="col-8">
									<input type="date" class="form-control" name="datanasc" value="<?= $value->datanasc ?>">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-4">
									<label class="control-label" for="email">Email:</label>
								</div>
								<div class="col-8">
									<input type="email" class="form-control" name="email" value="<?= $value->email ?>">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-4">
									<label class="control-label" for="morada">Morada:</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control" name="morada" value="<?= $value->morada ?>">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-4">
									<label class="control-label" for="tel">Telemovel:</label>
								</div>
								<div class="col-8">
									<input type="text" class="form-control" name="tel" value="<?= $value->telefone ?>">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-4">
									<label class="control-label" for="cargo">Cargo:</label>
								</div>
								<div class="col-8">
									<input type="number" class="form-control" name="cargo" value="<?= $cargo ?>">
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
      <th class="th-sm">ID
      </th>
      <th class="th-sm">Nome
      </th>
      <th class="th-sm">Email
      </th>
      <th class="th-sm">Telefone
      </th>
      <th class="th-sm">Cargo
	  </th>
	  <th class="th-sm">
	  </th>
	  </thead>
	  <tbody>';

		foreach ($arrUti as $key => $value) {
			$string .= '<tr>';
			$string .= '<td>' . $value->iduti . '</td>';
			$string .= '<td>' . $value->Nome . '</td>';
			$string .= '<td>' . $value->email . '</td>';
			$string .= '<td>' . $value->telefone . '</td>';
			if ($value->TipoUser == 'Cliente')
				$string .= '<td><img src="img/cliente.png" width="50" height="50"></td>';
			else if ($value->TipoUser == 'Administrador')
				$string .= '<td><img src="img/admin.png" width="50" height="50"></td>';
			$string .= '<td><a target="BLANK" href="admin.php?cmd=utilizadores&vermais=' . $value->iduti . '">Ver Mais</a></td>';
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
