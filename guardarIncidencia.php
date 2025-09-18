<?php
	session_start();
	if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
			die();
			header('Location: login.php');
	}
		
		include 'funcion.php';
		$conexion = conectarBD();
		$id = $_POST['id'];
		$nombre = mysqli_real_escape_string($conexion, $_POST['asunto']);
		$descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
		$tipoIncidencia = $_POST['tipoIncidencia'];
		if(isset($_FILES["imagen"]["name"][0]) && ($_FILES["imagen"]["name"][0] !== "")) {  
			$imagen1 = mysqli_real_escape_string($conexion, subirImagen(0));
		}
		if(isset($_FILES["imagen"]["name"][1]) && ($_FILES["imagen"]["name"][1] !== "")) {  
			$imagen2 = mysqli_real_escape_string($conexion, subirImagen(1));
		}
		if(isset($_FILES["imagen"]["name"][2]) && ($_FILES["imagen"]["name"][2] !== "")) {  
			$imagen3 = mysqli_real_escape_string($conexion, subirImagen(2));
		}
		if(isset($_FILES["imagen"]["name"][3]) && ($_FILES["imagen"]["name"][3] !== "")) {  
			$imagen4 = mysqli_real_escape_string($conexion, subirImagen(3));
		}
		
		
		$fecha = date("Y-m-d H:i:s");
		$añadirIncidencia = "INSERT INTO rmi.incidencias(nombre, descripcion, subidaPor, tipoProblema, fechaExpedicion, fechaModificacion) VALUES ('$nombre', '$descripcion', $id, '$tipoIncidencia', '$fecha', '$fecha');";
		mysqli_query($conexion, $añadirIncidencia);
		$fechaImagen = date("Y-m-d-H-i-s")."-";
		$consultaIncidencia = "SELECT idincidencias FROM incidencias WHERE subidaPor=$id AND fechaExpedicion='$fecha';";
		
		$buscarIncidencia = mysqli_fetch_array(mysqli_query($conexion, $consultaIncidencia));
		$idIncidencia = print_r($buscarIncidencia[0], true);
		if(isset($imagen1) && !empty($imagen1)) {
			$añadirImagen = "INSERT INTO incidencias_imagenes(idincidencias_imagenes, imagen) VALUES ($idIncidencia, '$fechaImagen$imagen1');";
			mysqli_query($conexion, $añadirImagen);
			if(isset($imagen2)) {
				$añadirImagen = "INSERT INTO incidencias_imagenes(idincidencias_imagenes, imagen) VALUES ($idIncidencia, '$fechaImagen$imagen2');";
				mysqli_query($conexion, $añadirImagen);
				if(isset($imagen3)) {
					$añadirImagen = "INSERT INTO incidencias_imagenes(idincidencias_imagenes, imagen) VALUES ($idIncidencia, '$fechaImagen$imagen3');";
					mysqli_query($conexion, $añadirImagen);
					if(isset($imagen4)) {
						$añadirImagen = "INSERT INTO incidencias_imagenes(idincidencias_imagenes, imagen) VALUES ($idIncidencia, '$fechaImagen$imagen4');";
						mysqli_query($conexion, $añadirImagen);
					}
				}
			}
		}
		// Nombre del servidor
		$dominio = $_SERVER['SERVER_NAME'];
		//Destino
		$para = 'admin@rmi.com';
		// Asunto
		$titulo = 'Se ha publicado una nueva incidencia';
		// Mensaje
		$mensaje = 'Una nueva incidencia ha sido añadida a la base de datos. Por favor, haga click aquí para revisar la incidencia:\r\n
				\r\n
				$dominio/proyecto/incidencia.php?ID=$idIncidencia
				\r\n';
		mail($para, $titulo, $mensaje); 
		mysqli_close($conexion);
		header('Refresh: 0; URL=incidencia.php?ID='.$idIncidencia)
?>
