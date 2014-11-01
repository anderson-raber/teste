<?php
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

function cadastra_face() {
	//$c = @conectar();
	$inserir = "insert into teste values (NULL,1)";
	$resultado = conectar()->query($inserir);
	if ($resultado == TRUE) {
		echo "<br>gravado";
	} else {
		echo "<br>erro" . mysql_errno();
	}
}

$sql = "CREATE TABLE MyGuests (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
	echo "Table MyGuests created successfully";
} else {
	echo "Error creating table: " . mysqli_error($conn);
}

function criar_tabela($id) {
	$criar = "CREATE TABLE IF NOT EXISTS '" . $id . "' (
		codigo INT(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		id INT(40) NOT NULL,
		nome VARCHAR(20) NOT NULL
		)";
	$resultado = conectar()->query($criar);
	if ($resultado == TRUE) {
		echo "tabela criada com sucesso";
	} else {
		echo "<br>erro" . mysql_errno();
	}

}
