<?php
	session_start();
		if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
		header('Location: login.php'); // en el futuro reusaré el script para reestablecer la contraseña
	} elseif ($_SESSION['tipoUsuario'] == 'usuario' ) {
		header('Location: index.php'); 
	}
	
	
	$dbhost = "localhost";
	$dbusuario = "root";
	$dbpassword = "culo";
	$port = "3306";
	$conexion = mysqli_connect($dbhost . ":" . $port, $dbusuario, $dbpassword);
	$usardb = "use rmi;";
		mysqli_query($conexion, $usardb);
	$clave = password_hash($_POST['clave1'], PASSWORD_BCRYPT);
	$id = $_POST['id'];
	$sentencia = "UPDATE Usuarios SET Clave = '$clave' WHERE IDUsuario = $id;";
	mysqli_query($conexion, $sentencia);
	header('Location: listarUsuarios.php')
?>

	