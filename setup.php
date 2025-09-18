<?php
    session_start();
        if((isset($_SESSION['id'])) && (!empty($_SESSION['id']))) { 
			header('Location: index.php');
	} 
    $errors = [];
    include 'funcion.php';
		if (!isset($conexion)) {
        $conexion = conectarBD();
    }
    $tablaUsuarios = "CREATE TABLE IF NOT EXISTS `usuarios` (
                                `IDUsuario` int(11) NOT NULL AUTO_INCREMENT,
                                `Nombre` char(30) NOT NULL,
                                `Apellidos` char(80) DEFAULT NULL,
                                `Email` char(80) NOT NULL,
                                `Ciudad` char(50) NOT NULL,
                                `Pais` char(2) NOT NULL,
                                `Clave` char(100) NOT NULL,
                                `tipoUsuario` enum('Usuario','Administrador') NOT NULL DEFAULT 'Usuario',
                                `fechaAlta` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                `nEntradas` int(11) NOT NULL DEFAULT '0',
                                `nErrores` int(11) NOT NULL DEFAULT '0',
                                `ultimaVisita` datetime, #NOT NULL DEFAULT '0000-00-00 00:00:00',
                                `bloqueado` tinyint(1) NOT NULL DEFAULT '0',
                                PRIMARY KEY (`IDUsuario`)
                                ) DEFAULT CHARSET=utf8;" or die(mysqli_error());
    $tablaIncidencias = "CREATE TABLE IF NOT EXISTS `incidencias` (
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
    $tablaImagenes = "CREATE TABLE IF NOT EXISTS `incidencias_imagenes` (
                                `idincidencias_imagenes` int(11) NOT NULL,
                                `imagen` varchar(100) NOT NULL,
                                KEY `fk_imagenes_idx` (`idincidencias_imagenes`),
                                CONSTRAINT `fk_imagenes` FOREIGN KEY (`idincidencias_imagenes`) REFERENCES `incidencias` (`idincidencias`) ON DELETE CASCADE ON UPDATE CASCADE
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='aquí van las imagenes en texto plano';" or die(mysqli_error());
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

    $tablas = [$tablaUsuarios, $tablaIncidencias, $tablaImagenes, $tablaModificaciones];
    foreach($tablas as $k) {
        try {
        mysqli_query($conexion, $k);
        echo json_encode(array(
            "status" => "Ok",
            "message" => "Success",
        ));
        }
        catch (mysqli_sql_exception $e) {
        echo json_encode(array(
            "status" => "Error",
            "message" => $e->getMessage()
        ));
        }
    }

    #Ya que estoy voy a crear al admin aqui en vez de en la pantalla de registro
    $compadmin = "SELECT * FROM rmi.usuarios WHERE tipoUsuario = 'Administrador';";
	$compadminsql = mysqli_query($conexion, $compadmin);
	if (mysqli_num_rows($compadminsql) == 0) {
		$claveadmin = password_hash('admin', PASSWORD_BCRYPT); 
		$insertaradmin = "INSERT INTO usuarios(Nombre, Email, Ciudad, Pais, Clave, tipoUsuario) VALUES ('admin', 'admin@rmi.com', 'Madrid', 'ES', '$claveadmin', 'Administrador');";
		mysqli_query($conexion, $insertaradmin);
	}
    header('Location: login.php');
?>