<?php 
	session_start();
	if((isset($_SESSION['id'])) && (!empty($_SESSION['id']))) { 
		header('Location: index.php');
	}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Inicio de sesión</title>
		
	</head>
	<body>
		<?php
			include 'funcion.php';
			$conexion = conectarBD();
			$email = mysqli_real_escape_string($conexion, $_POST['email']);
			$clave = $_POST['clave1'];
			$buscaremail = "SELECT IDUsuario, Nombre, Clave, bloqueado, nErrores, tipoUsuario FROM Usuarios WHERE Email = '$email';";
			$consultamail = mysqli_query($conexion, $buscaremail);
			$filas = mysqli_fetch_array($consultamail);
			$resultadoid = print_r($filas[0], true);
			$resultadonombre = print_r($filas[1], true);
			$resultadoclave = print_r($filas[2], true);
			$estadocuenta = print_r($filas[3], true);
			$numeroerrores = print_r($filas[4], true);
			$tipousuario = print_r($filas[5], true);
			// Variables para contar tanto los intentos como si ha sido un bloqueo temporal
			if(!isset($_SESSION['cuentaBloqueo'])) {
				$_SESSION['cuentaBloqueo'] = 4;
				$_SESSION['bloqueoPorContador'] = 0;
			}
			$numfilas = mysqli_num_rows($consultamail);
			if ($numfilas == 0 OR NULL) {
				$_SESSION['error'] = "El correo no está registrado.";
				header('Location: login.php');
			} elseif (password_verify($clave, $resultadoclave) == FALSE ) {
				$actualizarerror = "UPDATE Usuarios SET nErrores = nErrores + 1 WHERE IDUsuario = '$resultadoid';";
				mysqli_query($conexion, $actualizarerror);
				$_SESSION['error'] = "La contraseña introducida es incorrecta.";
				header('Location: login.php');
				/* Esto es parte de una operación para bloquear conexiones tras x intentos que ya veré cómo implementar
				
				if($_SESSION['cuentaBloqueo'] > 0) {
					$_SESSION['cuentaBloqueo']= $_SESSION['cuentaBloqueo']-1;
					$variableLeible = $_SESSION['cuentaBloqueo'];
					$_SESSION['error'] = "La contraseña introducida es incorrecta. Le quedan $variableLeible intentos.";
					header('Location: login.php');
				} else{
					$actualizarestado = "UPDATE Usuarios SET bloqueado = '1' WHERE IDUsuario = '$resultadoid';";
					mysqli_query($conexion, $actualizarestado);
					$_SESSION['bloqueoPorContador'] = 1;
					$_SESSION['error'] = "Por motivos de seguridad su cuenta ha sido bloqueada temporalmente. Espere un poco antes de volver a intentar iniciar sesión.";
					 header('Location: login.php');
					$fecha = date("Y-m-d H:i:s");
					if(!isset($_SESSION['fechaBloqueo'])) {
						$_SESSION['fechaBloqueo'] = $fecha;
						$fechaDesbloqueo = date_add($fecha, date_interval_create_from_date_string('10 seconds'));;
						echo $fechaDesbloqueo;/*
						$_SESSION['fechaDesbloqueo'] = date("Y-m-d H:i:s", $fechaDesbloqueo);
							if($fecha >= $fechaDesbloqueo) {
							$_SESSION['cuentaBloqueo'] = 4;
							$_SESSION['bloqueoPorContador'] = 0;
							$_SESSION['error'] = ""; 
							$_SESSION['fechaBloqueo'] = "";
							$_SESSION['fechaDesbloqueo'] = "";
							$actualizarestado = "UPDATE Usuarios SET bloqueado = '0' WHERE IDUsuario = '$resultadoid';";
							mysqli_query($conexion, $actualizarestado);
							} */
					
				
	
							
							/* if($i==0) {
							break;
							
							/* $i = 3;
							$_SESSION['bloqueoPorContador'] = 0;
							$_SESSION['error'] = ""; 
							} else {
								header('Location: login.php');
							}
				} */
			} elseif (($estadocuenta == '1') && ($_SESSION['bloqueoPorContador'] == 0)) {
				$_SESSION['error'] = "Su cuenta ha sido bloqueada. Por favor, contacte con un administrador lo antes posible.";
				header('Location: login.php');
			} /* elseif (($estadocuenta == '1') && ($_SESSION['bloqueoPorContador'] == 1)) {
				$_SESSION['error'] = "Por motivos de seguridad su cuenta ha sido bloqueada temporalmente. Espere un poco antes de volver a intentar iniciar sesión.";
				header('Location: login.php'); 
			} */ 
			
			else{
				$fecha = date("Y-m-d H:i:s");
				$_SESSION['id'] = $resultadoid;
				$_SESSION['nombre'] = $resultadonombre;
				$_SESSION['email'] = $email;
				$_SESSION['fecha'] = date("Y-m-d H:i:s");
				$_SESSION['tipoUsuario'] = $tipousuario;
				$actualizarusuario = "UPDATE Usuarios SET nEntradas = nEntradas + 1, ultimaVisita = '$fecha' WHERE IDUsuario = '$resultadoid';";
				mysqli_query($conexion, $actualizarusuario);
				//$_SESSION['cuentaBloqueo'] = 4;
				if($tipousuario == 'Administrador') {
					header('Location: backend.php');
				} else{
				header('Location: index.php');
				mysqli_close($conexion);
				}
			}
			
		?>
	</body>