
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
		<meta charset="UTF-8">
		<title>Inicio de sesión</title>
		<style>
			.container {
				position: relative;
			}

			.topright {
				position: absolute;
				top: 8px;
				right: 16px;
				font-size: 18px;
			}
		</style>
	</head>
	<body>
	<div class="topright"><a href="logout.php">Cerrar sesión</a></div>
	<h2>MENÚ SUPER SECRETO PARA ADMINISTRADORES</h2>

		<ul>
			<li><a href="listarUsuarios.php">Gestión de usuarios</a></li>
			<li><a href="copiaSeguridad.php">Realizar una copia de seguridad de la base de datos</a></li>
			<li>Más</li>
		</ul>
	</body>
	
</html>
