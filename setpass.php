<?php
	session_start();
		if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
		header('Location: login.php'); // en el futuro reusaré el script para reestablecer la contraseña
	} elseif ($_SESSION['tipoUsuario'] === 'Usuario' ) {
		header('Location: index.php'); 
	} elseif (!isset($_GET['ID']) && ($_GET['ID'] === "")){
        header('Location: index.php');
	}
	include 'funcion.php';
	$conexion = conectarBD();
	$id = mysqli_real_escape_string($conexion, $_GET['ID']);
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Cambiar contraseña</title>
		<link rel="stylesheet" href="css/bootstrap.css">
        <script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<style>			
		.setpass {
				position: absolute;
				top: 50%;
				left: 50%;
				margin-right: -50%;
				transform: translate(-50%, -50%)
			}
        </style>
	</head>
	<body>
	<?php include 'navegacion.php'; ?>
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
} </script>
    <div class="container">
        <div class="setpass">
            <form class="" action="setpass1.php" onSubmit="return checkPass(this);" autocomplete="on" method="post" >
                <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <input type="password" name="clave1" required placeholder="Nueva contraseña"> <br>
                </div>
                <div class="form-group">
                    <input type="password" name="clave2" required placeholder="Repita la contraseña"> <br>
                </div>
                <div class="submit">
                    <button type="submit" class="btn btn-default">Cambiar contraseña</button>
                </div>
                
            </form>
                <div id="error"></div>
        </div>
    </div>
</body>
