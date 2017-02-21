<!DOCTYPE html>
<?php 
	session_start();
	include 'funcion.php';
	$conexion = conectarBD();
	$idincidencia = mysqli_real_escape_string($conexion, $_GET['ID']);
	$consultaIncidencia = "SELECT * FROM rmi.incidencias WHERE idincidencias = $idincidencia";
	$datosIncidencia = mysqli_fetch_array(mysqli_query($conexion, $consultaIncidencia));
	if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) {
        $_SESSION['ultimaPaginaVisitada'] = ($_SERVER['REQUEST_URI']);
        header('Location: login.php');

	} 
	if ($_SESSION['id'] === $datosIncidencia['subidaPor'])  {
		header('Location: index.php');
	 }
?>
<html>
	<head>
		<meta charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap.css">
        <script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<title>Reportar incidencia</title>
		<style>
				.reporte {
					position: absolute;
					top: 50%;
					left: 50%;
					margin-right: -50%;
					transform: translate(-50%, -50%)
				
				}
				.reporte form{
					position: relative;
					width: 100%;
					}
		</style>
	</head>
	<body>
	<?php include 'navegacion.php'; ?>
		<div class="reporte">
			<form action="enviarReporte.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<input type="hidden" name="idusuario" required readonly value="<?php echo $_SESSION['id']; ?>" >
					<input type="hidden" name="idincidencia" required readonly value="<?php echo $idincidencia ?>" >
					<label for="sel1">¿Por qué quiere reportar esta incidencia?</label>
						<select class="form-control" id="sel1" name="tipoReporte">
							<option>Ya se ha informado del problema</option>
							<option>Lenguaje o contenido ofensivo y/o discriminatorio</option>
							<option>Contenido malicioso</option>
							<option>El problema se solucionó en otra incidencia</option>
							<option>Otros</option>
						</select>
				</div><br>
				<div class="form-group">
					<textarea name="descripcion"  class="form-control" rows="10" maxLength="600" placeholder="Añada más detalles (máx. 600 caracteres)"></textarea><br>
					<div class="submit">
						<button name="submit" type="submit" class="btn btn-default">Enviar</button> <button name="back" type="button" onclick="location.href='incidencia.php?ID=<?php echo $_GET['ID']; ?>'" class="btn btn-default">Volver atrás</button>
					</div>
				</div>
		</div>
	</body>
</html>
