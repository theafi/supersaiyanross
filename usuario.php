<!DOCTYPE html>
<?php
	session_start();
		if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
		header('Location: login.php');
	} elseif ($_SESSION['tipoUsuario'] === 'usuario' ) {
		header('Location: index.php');
	}
?>
<html>
	<head>
        <link rel="stylesheet" href="css/bootstrap.min.css">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Editar usuario</title>
		<style>
		
			.topright {
				position: absolute;
				top: 8px;
				right: 16px;
				font-size: 18px;
			}
			.editar {
				position: absolute;
				top: 50%;
				left: 50%;
				margin-right: -50%;
				transform: translate(-50%, -50%)
				
			}
			.editar form{
				position: relative;
				width: 100%;
			}
		</style>
		<script type="text/javascript" >

			function checkPass(f)
		{
			
			//Store the password field objects into variables ...
			var pass1 = f.elements["clave1"];
			var pass2 = f.elements["clave2"];
			//Store the Confimation Message Object ...
			var message = document.getElementById('error');
			//Set the colors we will be using ...3.
			var badColor = "#ff6666";
			//Compare the values in the password field 
			//and the confirmation field
			if(pass1.value == pass2.value){
				//Las contraseñas coinciden
				//Ahora quiero comprobar que cumplan el mínimo de caracteres (soy tonto del culo y había olvidado que el campo password de HTML tiene para definir un máximo y un mínimo)
				if(pass1.value.length >= 5 && pass2.value.length >= 5) {
						if(pass1.value.length <= 10 && pass2.value.length <= 10){
							return true;
						} else{
							pass1.style.backgroundColor = badColor;
							pass2.style.backgroundColor = badColor;
							//message.style.color = badColor;
							message.innerHTML = "La contraseña tiene que ser de 10 caracteres máximo";
							return (false);	
						}
					
				} else{
					pass1.style.backgroundColor = badColor;
					pass2.style.backgroundColor = badColor;
					//message.style.color = badColor;
					message.innerHTML = "La contraseña tiene que ser de 5 caracteres mínimo";
					return (false);
				}
			} else{
				//The passwords do not match.
				//Set the color to the bad color and
				//notify the user.
			   pass2.style.backgroundColor = badColor;
			   //message.style.color = badColor;
			   message.innerHTML = "Las contraseñas no coinciden";
				return (false);
			}
		}  
			function checkCountry(s)
		{
			//Store the password field objects into variables ...
			var pais = s.selectedIndex;
			//Store the Confimation Message Object ...
			var message = document.getElementById('error');
			//Set the colors we will be using ...
			//var badColor = "#ff6666";
			if(pais != 0){
				//El país es correcto 
				return true;
			} else{
				//No es un pais válido
			  // message.style.color = badColor;
			   message.innerHTML = "Por favor, elija un país";
				return (false);
			}
		}  
	</script>
	</head>
	<body>
	<div class="topright"><a href="logout.php">Cerrar sesión</a></div>
	<?php 
		include ('funcion.php');
		$conexion = conectarBD();
		$id = mysqli_real_escape_string($conexion, $_GET['ID']);
		$usuario = "SELECT * from usuarios WHERE IDUsuario=$id;";
		$usuariosql = mysqli_query($conexion, $usuario);
		$row = mysqli_fetch_array($usuariosql);	
		echo "<div class=\"editar\">".
		
            "<form onSubmit=\"return checkPass(this) && checkCountry(this.elements['pais']);\" action=\"editar.php\" autocomplete=\"on\" method=\"post\" >".
                "<div class=\"form-group\">".
				"<input type=\"hidden\" name=\"id\" value=\"". $row['IDUsuario']. "\">".
				"<input type=\"text\" class=\"form-control\" name=\"nombre\" maxlength=\"30\" placeholder=\"Nombre\"required value=\"". $row['Nombre']. "\"> <br>".
				"<input type=\"text\" class=\"form-control\" name=\"apellidos\" maxlength=\"50\" placeholder=\"Apellidos\"value=\"". $row['Apellidos']. "\"> <br>".
				"<input type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"Correo electrónico\" required readonly disabled value=\"". $row['Email']. "\"> <br>".
				"<strong>País:</strong> <br>".
				"<select class=\"form-control\" onchange=\"checkCountry(this)\" name=\"pais\" value=\"". $row['Pais']. "\">".
					"<option value=\"0\">Elige un país</option>";
						$query = "select ID, Name from rmi.pais ORDER BY Name;";
						$resultado = mysqli_query($conexion, $query);
						while ($valor = mysqli_fetch_array($resultado)) {
							echo "<option value='". $valor['ID']. "'>". $valor['Name']. "</option>";
							
						}
				echo "</select> <br>".
				"<input type=\"text\" class=\"form-control\" name=\"ciudad\" required placeholder=\"Ciudad\" value=\"". $row['Ciudad']. "\"> <br>".
				"<input type=\"password\" class=\"form-control\" name=\"clave1\" id=\"clave1\" minlength=\"5\" maxlength=\"10\" placeholder=\"Contraseña\" required readonly disabled> <br>".
				"<button type=\"submit\" class=\"btn btn-default\">Editar</button> <br>".
				"</form>". 
				"<div id=\"error\">";
					if ($_SESSION['error'] == "El email ya está registrado por un usuario. Si no recuerda su contraseña, por favor <a href=\"recuperar.html\">pulse aquí.</a>") {
						echo $_SESSION['error'];
						$_SESSION['error'] = "";
					} else{
						$_SESSION['error'] = "";
					}
				echo "</div>".
				"</body>";
				
