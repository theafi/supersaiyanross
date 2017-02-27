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
		
		$tablaincidencias = "CREATE TABLE IF NOT EXISTS `incidencias` (
							  `idincidencias` int(11) NOT NULL AUTO_INCREMENT,
							  `nombre` varchar(80) NOT NULL,
							  `descripcion` varchar(650) NOT NULL,
							  `subidaPor` int(11) NOT NULL,
							  `tipoProblema` enum('Hardware','Software','Impresora','Red','Otros') NOT NULL,
							  `fechaExpedicion` datetime NOT NULL,
							  `prioridad` enum('Baja','Alta','Máxima','No definida') NOT NULL DEFAULT 'No definida',
							  `estado` enum('En resolución','Resuelta','Pendiente') NOT NULL DEFAULT 'Pendiente',
							  `fechaModificacion` datetime NOT NULL,
							  `fechaResolucion` datetime DEFAULT NULL,
							  `asignadaA` int(11) DEFAULT NULL,
							  PRIMARY KEY (`idincidencias`),
							  KEY `fk_subidaport_idx` (`subidaPor`),
							  KEY `fk_admin_idx` (`asignadaA`),
							  CONSTRAINT `fk_admin` FOREIGN KEY (`asignadaA`) REFERENCES `usuarios` (`IDUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
							  CONSTRAINT `fk_subidaport` FOREIGN KEY (`subidaPor`) REFERENCES `usuarios` (`IDUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
							) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='aquí se almacenan las incidencias';" or die(mysqli_error());
		mysqli_query($conexion, $tablaincidencias);
		$tablaImagenes = "CREATE TABLE IF NOT EXISTS `incidencias_imagenes` (
							  `idincidencias_imagenes` int(11) NOT NULL,
							  `imagen` varchar(100) NOT NULL,
							  KEY `fk_imagenes_idx` (`idincidencias_imagenes`),
							  CONSTRAINT `fk_imagenes` FOREIGN KEY (`idincidencias_imagenes`) REFERENCES `incidencias` (`idincidencias`) ON DELETE CASCADE ON UPDATE CASCADE
							) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='aquí van las imagenes en texto plano';" or die(mysqli_error());
		mysqli_query($conexion, $tablaImagenes);
		$tablaModificaciones = "CREATE TABLE IF NOT EXISTS `incidencias_modificaciones` (
								  `idincidencia` int(11) NOT NULL,
								  `idModificacion` int(11) NOT NULL AUTO_INCREMENT,
								  `fechaModificacion` datetime NOT NULL,
								  `motivo` varchar(600) NOT NULL,
								  `modificadaPor` int(11) NOT NULL,
								  PRIMARY KEY (`idModificacion`),
								  KEY `fk_idincidencia_idx` (`idincidencia`),
								  KEY `fk_modificadaPor_idx` (`modificadaPor`),
								  CONSTRAINT `fk_idincidencia` FOREIGN KEY (`idincidencia`) REFERENCES `incidencias` (`idincidencias`) ON DELETE CASCADE ON UPDATE CASCADE,
								  CONSTRAINT `fk_modificadaPor` FOREIGN KEY (`modificadaPor`) REFERENCES `usuarios` (`IDUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
								) ENGINE=InnoDB DEFAULT CHARSET=utf8;" or die(mysqli_error());
		mysqli_query($conexion, $tablaModificaciones);
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
