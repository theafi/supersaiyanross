<!-- 2.- Se pretende crear un formulario usuario.php para agregar usuarios a una base de datos. El
formulario HTML5 tendrá los siguientes campos:
•  Nombre, de tipo text, propiedad required activa, y maxlength de 30 caracteres.
•  Apellidos, de tipo text y maxlength de 50 caracteres.
•  Direccion, de tipo text y maxlength de 100 caracteres.
•  Telefono, de tipo number.
•  Email, de tipo email, propiedad required activa, y maxlength de 100 caracteres.
•  Clave, de tipo password, propiedad required activa, y maxlength de 10 caracteres.
El IDUsuario es un código numérico que se asigna automáticamente. El Nombre, Email
y la Clave son campos obligatorios. El resto de campos son opcionales. Los datos del formulario
se deben enviar a un script usuario1.php, el cuál debe asegurarse que la base de datos Test
existe, y si no existe, la debe crear. Así mismo, debe verificar que la tabla usuarios existe, y en
caso de no existir, la creará. El código para la creación de la BD y la tabla es el siguiente:
CREATE DATABASE IF NOT EXISTS Test;
use test;
CREATE TABLE IF NOT EXISTS Usuarios (
IDUsuario int(11) NOT NULL AUTO_INCREMENT,
Nombre char(30) NOT NULL,
Apellidos char(50) NULL,
Direccion char(100) NULL,
Telefono int(11) NULL,
Email char(100) NOT NULL,
Clave char(10) NOT NULL,
PRIMARY KEY (IDUsuario)
) ENGINE=InnoDB;
El script usuario1.php recoge la información del formulario, verifica que los campos
obligatorios están rellenos, y en caso afirmativo inserta los datos en la tabla usuarios mediante
una instrucción SQL INSERT INTO. Si los campos obligatorios no están rellenos, se debe dar un
mensaje de error al usuario. Tras insertar, se debe dar un mensaje al usuario indicándole que
sus datos han sido almacenados. -->

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Editar usuario</title>
	</head>
	<body>
	<?php 
		//Parámetros de conexión a la BD
		$dbhost = "localhost"; //Los nombres de las variables son case-sensitive, no así las palabras reservadas
		$dbusuario = "root";
		$dbpassword = "Culete_69";
		$port = "3306";
		$conexion = mysqli_connect($dbhost . ":" . $port, $dbusuario, $dbpassword);
		$usardb = "use rmi;";
		mysqli_query($conexion, $usardb);
		$id = $_POST['id'];
		$nombre = $_POST['nombre'];
		$apellidos = $_POST['apellidos'];
		$ciudad = $_POST['ciudad'];
		$pais = $_POST['pais'];
		$insertarusuario = "UPDATE Usuarios SET Nombre = '$nombre', Apellidos = '$apellidos', Pais = $pais, Ciudad = '$ciudad' WHERE IDUsuario = $id;";
		mysqli_query($conexion, $insertarusuario);
		echo "<p>Los datos han sido introducidos correctamente.<p>";
		header('Refresh: 5; URL=listarUsuarios.php');
		?>
		</body>
	</html>