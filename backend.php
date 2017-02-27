
<?php
	session_start();
		if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
		header('Location: login.php');
	} elseif ($_SESSION['tipoUsuario'] === 'Usuario' ) {
		header('Location: index.php');
	}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>Inicio de sesión</title>
		<link rel="stylesheet" href="css/bootstrap.css">
        <script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<style>
        .add-on .input-group-btn > .btn {
        border-left-width:0;left:-2px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        }
        /* stop the glowing blue shadow */
        .add-on .form-control:focus {
        box-shadow:none;
        -webkit-box-shadow:none; 
        border-color:#cccccc; 
        }
		
		</style>
	</head>
	<body>
		<?php include 'navegacion.php'; ?>
		<div class="col-md-3" role="complementary"> 
					<nav class="bs-docs-sidebar hidden-print hidden-sm hidden-xs affix"> 
						<ul class="nav bs-docs-sidenav"> 
							<li> <a href="#users">Lista de administradores</a></li> <ul class="nav"> 
							<li><a href="#stats">Estadísticas</a></li> 
							<li><a href="#backup">Copias de seguridad</a></li>
							</ul> 
					</nav> 
		</div>
		<div class="container">
			<div class="jumbotron">
				<div class="panel panel-default">
					<div class="panel-heading" id="users"><strong>LISTA DE ADMINISTRADORES </strong><small><a href="listarUsuarios.php">Ver más</a></small></div>
					<div class="panel-body">
						<table class="table table-striped" style="text-align=center;">
							<thead>
								<th>ID</th><th>NOMBRE</th><th>APELLIDOS</th><th>EMAIL</th><th>FECHA DE REGISTRO</th>
							</thead>
							<tbody>
								<?php $consultaAdmins = "SELECT IDUsuario, Nombre, Apellidos, Email, fechaAlta FROM usuarios WHERE tipoUsuario = 'Administrador'";
									$ejecutarAdmins = mysqli_query($conexion, $consultaAdmins);
									while ($resultado = mysqli_fetch_array($ejecutarAdmins)): ?>
										<tr>
											<td><?php echo $resultado[0]; ?></td>
											<td><?php echo htmlspecialchars($resultado[1]); ?></td>
											<td><?php echo htmlspecialchars($resultado[2]); ?></td>
											<td><?php echo htmlspecialchars($resultado[3]); ?></td>
											<td><?php echo $resultado[4]; ?></td>
										</tr>
									<?php endwhile; ?>
							</tbody>
							<tfoot>
								<small><a href="listarUsuarios.php">Ver más</a></small>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" id="stats"><strong>ESTADÍSTICAS</strong></div>
					<div class="panel-body">
						<?php include 'stats.php'; ?>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading" id="backup"><strong>COPIAS DE SEGURIDAD</strong></div>
					<div class="panel-body">
						<div class="container">
							<div class="panel panel-default">
								<div class="panel-body">
									Hacer copia de seguridad en el servidor <button formaction="backup.php" formmethod="post" name="backupservidor" type="submit" class="btn btn-default">Copia</button><br> 
									<br>
									Hacer copia de seguridad en el equipo <button type="button" class="btn btn-default">Copia</button>
								</div>
							</div>
						</div>
					</div>
				</div>
					
			</div>
		</div>
	</body>
	
</html>
