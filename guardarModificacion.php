<?php
	session_start();
	
	if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
			die();
			header('Location: login.php');
	}
	include 'funcion.php';
	$conexion = conectarBD();
	$idincidencia = $_POST['idincidencia'];
	$idusuario = $_POST['idusuario'];
	$consultaIncidencia = "SELECT * FROM rmi.incidencias WHERE idincidencias = $idincidencia";
	$datosIncidencia = mysqli_fetch_array(mysqli_query($conexion, $consultaIncidencia));
	if ($_SESSION['id'] != $idusuario){
		if ($_SESSION['tipoUsuario'] != "Administrador") {
			die();
			header('Location: listarIncidencias.php');
		}
	}
	$nombre = mysqli_real_escape_string($conexion, $_POST['asunto']);
	$descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
	$tipoIncidencia = $_POST['tipoIncidencia'];
	if(isset($_POST['prioridad']) && ($_POST['estado'])) {
		$prioridad = $_POST['prioridad'];
		$estado = $_POST['estado'];
		if(isset($_POST['asignadaA'])) {
			$asignadaA = $_POST['asignadaA'];
		}
	}
	$motivo = $_POST['motivo'];
	$fecha = date("Y-m-d H:i:s");
	$insertarHistoria = "INSERT INTO `rmi`.`incidencias_modificaciones`
										(`idincidencia`,
										`fechaModificacion`,
										`motivo`,
										`modificadaPor`)
										VALUES
										($idincidencia,
										'$fecha',
										'$motivo',
										$idusuario);" or die(mysqli_error());
	if(isset($prioridad) && isset($estado)) {
			if($estado == 'Resuelta'){
				$actualizarIncidencia = "UPDATE rmi.incidencias SET `nombre` = '$nombre',
								`descripcion` = '$descripcion',
								`tipoProblema` = '$tipoIncidencia',
								`prioridad` = '$prioridad',
								`estado` = '$estado',
								`fechaModificacion` = '$fecha',
								`fechaResolucion` = '$fecha',
								`asignadaA` = $asignadaA
								WHERE `idincidencias` = $idincidencia;" or die(mysqli_error());
				mysqli_query($conexion, $actualizarIncidencia);
				mysqli_query($conexion, $insertarHistoria);
			} else{
				$actualizarIncidencia = "UPDATE rmi.incidencias SET `nombre` = '$nombre',
								`descripcion` = '$descripcion',
								`tipoProblema` = '$tipoIncidencia',
								`prioridad` = '$prioridad',
								`estado` = '$estado',
								`fechaModificacion` = '$fecha',
								`fechaResolucion` = NULL,
								`asignadaA` = $asignadaA
								WHERE `idincidencias` = $idincidencia;" or die(mysqli_error());
								mysqli_query($conexion, $actualizarIncidencia);
								mysqli_query($conexion, $insertarHistoria);
			}
	} else {
		$actualizarIncidencia = "UPDATE rmi.incidencias SET `nombre` = '$nombre',
								`descripcion` = '$descripcion',
								`tipoProblema` = '$tipoIncidencia',
								`fechaModificacion` = '$fecha',
								`fechaResolucion` = NULL,
								WHERE `idincidencias` = $idincidencia;" or die(mysqli_error());
				mysqli_query($conexion, $actualizarIncidencia);
				mysqli_query($conexion, $insertarHistoria);
		
	}
	mysqli_close($conexion);
	header('Location: incidencia.php?ID='.$idincidencia);
?>