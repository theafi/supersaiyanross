<!DOCTYPE html>

<?php

	session_start();
	if (isset($_SESSION['tipoUsuario']) && ($_SESSION['tipoUsuario'])  === 'Usuario' ) {
		header('Location: index.php');
	}

?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Registrar usuario</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<style>
			#error {
				color: red;
				top: 50%;
				left: 50%;

			}
			.registro{
                position: absolute;
                top: 50%;
				left: 50%;
				margin-right: -50%; 
				transform: translate(-50%, -50%)
			}
			.registro form{
                position: relative;
				width: 100%;
			}
		</style>
	</head>
	
	<body>
        <script type="text/javascript" >

        function checkPass(f) {
        
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
        <?php 
        include ('funcion.php');
        $conexion = conectarBD();
        if(isset($_SESSION['id']) && $_SESSION['tipoUsuario'] === 'Administrador') {
        include 'navegacion.php';
        }
        ?>
        <div class="registro">
            <form enctype="multipart/form-data" onSubmit="return checkPass(this) && checkCountry(this.elements['pais']);" action="registro1.php" autocomplete="on" method="post" >
            <div class="form-group">
                    <input type="text" class="form-control" name="nombre" maxlength="30" required placeholder="Nombre"> <br>
                    <input type="text" class="form-control" name="apellidos" maxlength="50" placeholder="Apellidos"> <br>
                    <input type="email" class="form-control" name="email" required placeholder="Correo electrónico"> <br>
                    <select class="form-control" onchange="checkCountry(this)" name="pais" >
                        <option value="0">Elige un país</option>
                        <?php 
                            $query = "select ID, Name from rmi.pais ORDER BY Name;";
                            $resultado = mysqli_query($conexion, $query);
                            while ($valor = mysqli_fetch_array($resultado)) {
                                echo "<option value='". $valor['ID']. "'>". $valor['Name']. "</option>";
                                
                            }
                        ?>
                    </select> <br>
                <div class="form-group">
                    <input type="text" class="form-control" name="ciudad" placeholder="Ciudad" required> <br>
                    <input type="password" class="form-control" name="clave1" id="clave1" minlength="5" maxlength="10" placeholder="Contraseña" required> <br>
                    <input type="password" class="form-control" name="clave2" id="clave2" minlength="5" maxlength="10" placeholder="Vuelva a introducir la contraseña" required> <br>
                </div>
                <div id="error"><?php
                    if (!empty($_SESSION['error'])) {
                        echo $_SESSION['error'];
                        $_SESSION['error'] = "";
                    } else{
                        $_SESSION['error'] = "";
                    }
                    ?>
                </div>
                <div class="submit">
                    <button type="submit" class="btn btn-default" name="Registrar">Registrar</button> <br>
                </div>
            </form> 

                </div>
    </div>

			</div>
    </body>
</html>

