<!DOCTYPE html>
<?php
	session_start();
	if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
		header('Location: login.php');
	} elseif ($_SESSION['tipoUsuario'] == 'Usuario' ) {
		header('Location: index.php');
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Borrar usuario</title>
	</head>
	<body>
		<?php 
		//Parámetros de conexión a la BD
			include 'funcion.php';
			$conexion = conectarBD();
			$id = mysqli_real_escape_string($conexion, $_GET['ID']);
			if ($_SESSION['id'] == $id) {
				$_SESSION['error'] = "ERROR: No puedes borrarte a ti mismo.";
				header('Refresh: 0; URL=listarUsuarios.php');
			} else{
				$borrarusuario = "DELETE FROM usuarios WHERE idusuario = '$id';";
				mysqli_query($conexion, $borrarusuario);
				$_SESSION['error'] = "El usuario se ha eliminado correctamente";
				header('Refresh: 0; URL=listarUsuarios.php');
			}
		?>
	</body>
</html>