<!DOCTYPE html>
<?php
session_start();
	
	if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
			header('Location: login.php');
	}
	include 'funcion.php';
	$conexion = conectarBD();
	$idincidencia = mysqli_real_escape_string($conexion, $_GET['ID']);
	$consultaIncidencia = "SELECT * FROM rmi.incidencias WHERE idincidencias = $idincidencia";
	$datosIncidencia = mysqli_fetch_array(mysqli_query($conexion, $consultaIncidencia));
	if ($_SESSION['id'] != $datosIncidencia['subidaPor']){
		if ($_SESSION['tipoUsuario'] != "Administrador") {
			die();
			header('Location: listarIncidencias.php');
		}
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Borrar usuario</title>
	</head>
	<body>
		<?php 
	
			$id = mysqli_real_escape_string($conexion, $_GET['ID']);
			$borrarincidencia = "DELETE FROM incidencias WHERE idincidencias = '$id'";
			mysqli_query($conexion, $borrarincidencia);
			$borrarimagenes = "DELETE FROM incidencias_imagenes WHERE idincidencias_imagenes = '$id'";
			mysqli_query($conexion, $borrarimagenes);
			$_SESSION['error'] = "La incidencia se ha eliminado correctamente.";
			header('Refresh: 0; URL=listarIncidencias.php');
			
		?>
	</body>
</html>