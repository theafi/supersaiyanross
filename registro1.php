<?php
		session_start();
		if (isset($_SESSION['tipoUsuario']) && ($_SESSION['tipoUsuario'] == 'Usuario') ) {
			header('Location:index.php');
	}
		//Parámetros de conexión a la BD
		include 'funcion.php';
		$conexion = conectarBD();
		
		$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
		$apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
		$email = mysqli_real_escape_string($conexion, $_POST['email']);
		$ciudad = mysqli_real_escape_string($conexion, $_POST['ciudad']);
		$pais = $_POST['pais'];
		$clave = $_POST['clave1'];
		$compemail =  ("SELECT Email FROM usuarios WHERE Email='$email';") or die(mysqli_error());
		$emailenlatabla = mysqli_query($conexion, $compemail);
		$filasmail = mysqli_num_rows($emailenlatabla);
		if ($filasmail != 0) {
			$_SESSION['error']="El email ya está registrado por un usuario. Si no recuerda su contraseña, por favor <a href=\"recuperar.php\">pulse aquí.</a>";
			header('Location: registro.php');
		}
		else {
			/* $compadmin = "SELECT * FROM rmi.usuarios WHERE tipoUsuario = 'Administrador';";
			$compadminsql = mysqli_query($conexion, $compadmin);
			if (mysqli_num_rows($compadminsql) == 0) {
				$claveadmin = password_hash('admin', PASSWORD_BCRYPT); // En la documentación de PHP me recomiendan que no le ponga una salt porque la función me generará una aleatoria cada vez que haga un hash
				$insertaradmin = "INSERT INTO usuarios(Nombre, Email, Ciudad, Pais, Clave, tipoUsuario) VALUES ('admin', 'admin@rmi.com', 'Madrid', 'ES', '$claveadmin', 'Administrador');";
				mysqli_query($conexion, $insertaradmin);
			} */
			$clavecifrada = password_hash($clave, PASSWORD_BCRYPT); 
			$insertarusuario = "INSERT INTO usuarios(Nombre, Apellidos, Email, Ciudad, Pais, Clave) VALUES ('$nombre', '$apellidos', '$email', '$ciudad', '$pais', '$clavecifrada');";
			mysqli_query($conexion, $insertarusuario);

			$iddelusuario = "SELECT IDUsuario, tipoUsuario FROM rmi.usuarios WHERE Email = '$email';";
			$consultausuario = mysqli_query($conexion, $iddelusuario);
			$filas = mysqli_fetch_array($consultausuario);
			$idresultado = print_r($filas[0], true);
			$tiporesultado = print_r($filas[1], true);
			$fecha = date("Y-m-d H:i:s");
			if (null !== $_SESSION['tipoUsuario'] && ($_SESSION['tipoUsuario'] != 'Administrador')) {
                    $_SESSION['id'] = $idresultado;
                    $_SESSION['nombre'] = $nombre;
                    $_SESSION['apellidos'] = $apellidos;
                    $_SESSION['email'] = $email;
                    $_SESSION['fecha'] = date("Y-m-d H:i:s");
                    $_SESSION['tipoUsuario'] = $tiporesultado;
                    $_SESSION['error'] = "";
                    $actualizarusuario = "UPDATE usuarios SET nEntradas = nEntradas + 1, ultimaVisita = '$fecha' WHERE IDUsuario = '$idresultado';";
                    mysqli_query($conexion, $actualizarusuario);
                    echo "<p>Usuario registrado con éxito. En breve se le redirigirá a la página principal.<p>";
                
            }

			mysqli_close($conexion);
			if ($_SESSION['tipoUsuario'] == 'Administrador') {
				//header('Refresh: 0; URL=listarUsuarios.php');
				//echo $insertarusuario;
			} else {
				header('Refresh: 0; URL=index.php');
				//echo $insertarusuario;
			}
		};
		?>
