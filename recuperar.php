	<?php 
		session_start();
		if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
			header('Location: login.php');
		} 
	?>
<html>

	<head>
		<meta charset="UTF-8">
		<title>Recuperar contraseña</title>
		
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
			$email = mysqli_real_escape_string($conexion, $_POST['email']);
			$buscaremail = "SELECT IDUsuario FROM Usuarios WHERE Email = '$email';";
			$consultamail = mysqli_query($conexion, $buscaremail);
			$filas = mysqli_fetch_array($consultamail);
			$resultado = print_r($filas[0], true);
			$numfilas = mysqli_num_rows($consultamail);
			if ($numfilas == 0 OR NULL) {
				echo "<div id=\"error\">El correo solicitado no está registrado en nuestra base de datos. <a href=\"registro.php\">Pulse aquí para registrarse.</a></p></div>";
				
			} else {
				// ID encriptado
				$salt=random_bytes(25);
				$idcifrado = hash('sha256', $resultado . $salt);
				// Envio los datos a una URL
				$url = 'reset.php';
				$myvars = 'ID=' . $idcifrado . '&salt=' . $salt;
				$ch = curl_init( $url );
				curl_setopt( $ch, CURLOPT_POST, 1);
				curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
				curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt( $ch, CURLOPT_HEADER, 0);
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
				$response = curl_exec( $ch );
				// Destino
				$para = '$email';
				// Asunto
				$titulo = 'Restauración de contraseña de usuario';
				// Mensaje
				$mensaje = 'Si recibe este mail es porque ha intentado restaurar su contraseña a través de nuestro formulario de restauración de contraseñas. Si es así, por favor, pulse en el siguiente enlace para continuar:\r\n
				\r\n
				$response
				\r\n
				Si no ha solicitado restaurar su contraseña, por favor contacte con un administrador lo antes posible.\r\n';
				mail($para, $titulo, $mensaje);
				echo "<p>Se ha enviado un correo a su cuenta de correo electrónico. Sígalo para restaurar la contraseña</p>";
				
				
		}
		
	
?>	
	</body>

</html>