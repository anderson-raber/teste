<?php
ini_set('default_charset', 'utf-8');

function conectar() {
	$conectar = new mysqli('localhost', 'grupo01', 'sDD48cBUch', 'grupo01');
	if (mysqli_connect_errno()) {
		die(mysqli_connect_error());
		exit();
	}
	return $conectar;
}
/*function conectar() {
$conectar = new mysqli('fdb12.steadywebs.com', '1737023_avancada', 'Anderson19', '1737023_avancada');

if (mysqli_connect_errno()) {
die(mysqli_connect_error());
exit();
}
return $conectar;
}*/

function cadastra_grupos($tabela, $valores, $id, $nome) {
	//$c = @conectar();
	//echo "<br>ID = " . $id;

	$selecionar = "select * from $tabela where id='$id'";
	$resultado2 = conectar()->query($selecionar);
	$numrow = mysqli_num_rows($resultado2);

	if ($numrow > 0) {
		//if ($resultado2 == TRUE) {
		//echo "<br>erro" . mysql_errno();

	} else {
		$inserir = "insert into $tabela values (NULL,$valores)";
		$resultado = conectar()->query($inserir);

	}
}

//IF NOT EXISTS
//
function criar_tabela($id) {

	$criar = "CREATE TABLE usuario_" . $id . " (
			  codigo INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				id VARCHAR(30) NOT NULL,
				nome VARCHAR(30) NOT NULL
				)";
	$resultado = conectar()->query($criar);
	if ($resultado == TRUE) {
		echo "tabela criada com sucesso";
	}
}
