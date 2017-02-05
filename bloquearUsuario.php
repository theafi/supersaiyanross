<!DOCTYPE html>
<?php
	session_start();
	if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
		header('Location: login.php');
	} elseif ($_SESSION['tipoUsuario'] == 'Usuario' ) {
		header('Location: index.php');
	} 
	//Parámetros de conexión a la BD
	include 'funcion.php';
	$conexion = conectarBD();

	$id = $_GET['ID'];
	// Compruebo si el usuario está bloqueado o no
	
	$estado = "SELECT bloqueado from rmi.usuarios WHERE IDUsuario = {$id};";
	$comprobarestado = mysqli_query($conexion, $estado);
	$resultadoestado = mysqli_fetch_array($comprobarestado);

	if ($resultadoestado['bloqueado'] == '0') {
		if ($_SESSION['id'] == $id) {
			$_SESSION['error'] = "ERROR: No puedes bloquearte a ti mismo.";
			header('Refresh: 0; URL=listarUsuarios.php');
		} else{
			$bloquear = "UPDATE rmi.usuarios SET bloqueado = '1' WHERE IDusuario = {$id};";
			mysqli_query($conexion, $bloquear);
			mysqli_query($conexion, "commit;");
			header('Refresh: 0; URL=listarUsuarios.php');
		} 
	} else{
		$desbloquear = "UPDATE rmi.usuarios SET bloqueado = '0' WHERE IDusuario = {$id};";
		mysqli_query($conexion, $desbloquear);
		mysqli_query($conexion, "commit;");
		header('Refresh: 0; URL=listarUsuarios.php');
	}
?>