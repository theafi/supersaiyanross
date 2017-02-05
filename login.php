<!DOCTYPE html>
<?php 
	session_start();
	if((isset($_SESSION['id'])) && (!empty($_SESSION['id']))) {
		header('Location: index.php');
	 }
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Iniciar sesión</title>
		<style>
			#error {
				color: red;	
			}
		</style>
		
	</head>
	<body>
		<form action="validarLogin.php" autocomplete="on" method="post" >
			Correo electrónico: <br> 
			<input type="email" name="email" required> <br>
			Contraseña: <br>
			<input type="password" name="clave1" id="clave1" minlength="5" maxlength="10" required> <br>
			<input type="submit" name="Iniciar sesión"> <a href="recuperar.html">Olvidé mi contraseña</a>
			</form> 
			<div id="error"><?php 
					if(!empty($_SESSION['error'])) {
							echo $_SESSION['error'];
							$_SESSION['error'] = "";
							}
				?></div>
	</body>
</html>