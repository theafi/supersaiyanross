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
	if (($_SESSION['id'] != $idusuario) && ($_SESSION['tipoUsuario'] != "Administrador")) {
			header('Location: listarIncidencias.php');
		}
	$nombre = mysqli_real_escape_string($conexion, $_POST['asunto']);
	$descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
	$tipoIncidencia = $_POST['tipoIncidencia'];
	if(isset($_POST['prioridad'])) {
		$prioridad = $_POST['prioridad'];
    }
    if(isset($_POST['estado'])) {
		$estado = $_POST['estado'];
    }
    if(isset($_POST['asignadaA'])) {
        $asignadaA = $_POST['asignadaA'];
    }
	$motivo = mysqli_real_escape_string($conexion, $_POST['motivo']);
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
	if ($_SESSION['tipoUsuario'] === 'Administrador' ) {
        $actualizarIncidencia = "UPDATE rmi.incidencias SET `nombre` = '$nombre',
                                    `descripcion` = '$descripcion',
                                    `tipoProblema` = '$tipoIncidencia',
                                    `prioridad` = '$prioridad',
                                    `estado` = '$estado',
                                    `fechaModificacion` = '$fecha',
                                    `fechaResolucion` = '$fecha',
                                    `asignadaA` = $asignadaA
                                    WHERE `idincidencias` = $idincidencia" or die(mysqli_error());
        mysqli_query($conexion, $actualizarIncidencia);
        mysqli_query($conexion, $insertarHistoria);
    } else{
        if ($_SESSION['id'] !== $idusuario) {
            header('Location: index.php');
        } else{
            $actualizarIncidencia = "UPDATE rmi.incidencias SET descripcion = '$descripcion',
								tipoProblema = '$tipoIncidencia',
								fechaModificacion = '$fecha'
								WHERE idincidencias = $idincidencia;" or die(mysqli_error());
								mysqli_query($conexion, $actualizarIncidencia);
								mysqli_query($conexion, $insertarHistoria);
			}
	} 
	mysqli_close($conexion);
	echo $actualizarIncidencia;
    header('Location: incidencia.php?ID='.$idincidencia);
?>
