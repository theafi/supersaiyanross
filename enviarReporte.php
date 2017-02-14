<?php
	session_start();
	
	if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
		header('Location: login.php');
	}
	else{
		include 'funcion.php';
		$conexion = conectarBD();
		$idincidencia = mysqli_real_escape_string($conexion, $_POST['idincidencia']);
		$idusuario = mysqli_real_escape_string($conexion, $_POST['idusuario']);
		$usuario = "SELECT Nombre, Apellidos, Email FROM usuarios WHERE IDUsuario = $idusuario";
		$consultaUsuario = mysqli_query($conexion, $usuario);
		$resultadoUsuario = mysqli_fetch_array($conexion, $consultaUsuario);
		$email = resultadoUsuario['Email'];
		$nombre = resultadoUsuario['Nombre'];
		$apellido = resultadoUsuario['Apellidos'];
		$tipoReporte = $_POST['tipoReporte'];
		$detalles = $_POST['descripcion'];
		$consultarAdmins = "SELECT Email FROM usuarios WHERE tipoUsuario = 'Administrador'";
		$realizarConsulta = mysqli_query($conexion, $consultarAdmins);
		// Destino
		$email = "";
		while($resultadoConsulta = mysqli_fetch_array($conexion, $realizarConsulta)) {
			$email = $email+$resultadoConsulta['Email'];
		}
		$para = '$email';
		// Asunto
		$titulo = 'El usuario $nombre $apellido ha reportado la incidencia #$idincidencia';
		// Mensaje
		$mensaje = 'Se ha reportado la incidencia #'.$idincidencia.'con los siguientes detalles::\r\n
		\r\n
		Enviado por:'. $email.
		'Motivo del reporte:' .$tipoReporte.
		'Otros detalles:'. $detalles.
		'\r\n
		Consulte la incidencia haciendo click aquí: incidencia.php?ID=$idincidencia.\r\n';
		mail($para, $titulo, $mensaje);
		header('Location: incidencia.php?ID='.$idincidencia);
	}