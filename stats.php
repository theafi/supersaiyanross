<!DOCTYPE html>
<?php
	if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
		header('Location: login.php');
	} elseif ($_SESSION['tipoUsuario'] === 'Usuario' ) {
		header('Location: index.php');
	}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>Estadísticas de uso</title>
		<style>
		.table {
			margin: auto;
            margin-top: 10px;
		}
		.stats {
			max-width:800px;
			margin: auto;
            margin-top: 10px;
		}
		.stats th {
			text-align: right;
		}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="stats" id="stats">
					<div class="col-md-12">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<th>Total de incidencias</th><td><?php $consultaCuenta = "SELECT COUNT(*) FROM incidencias"; $resultadoCuenta = mysqli_query($conexion, $consultaCuenta); while ($resultado = mysqli_fetch_array($resultadoCuenta)) {echo $resultado[0];} ?></td>
								</tr>
								<tr>
									<th>Usuarios totales</th><td><?php $consultaCuenta = "SELECT COUNT(*) FROM usuarios"; $resultadoCuenta = mysqli_query($conexion, $consultaCuenta); while ($resultado = mysqli_fetch_array($resultadoCuenta)) {echo $resultado[0];} ?></td>
								</tr>
								<tr>
									<th>Usuarios conectados</th><td><?php $sessionCount = count(glob(session_save_path()."/*")); echo $sessionCount; ?></td>
								</tr>
								<tr>
									<th>Incidencias resueltas</th><td><?php $consultaCuenta = "SELECT COUNT(*) FROM incidencias WHERE estado = 'Resuelta'"; $resultadoCuenta = mysqli_query($conexion, $consultaCuenta); while ($resultado = mysqli_fetch_array($resultadoCuenta)) {echo $resultado[0];} ?></td>
								</tr>
								<tr>
									<th>Usuario con más incidencias subidas</th><td><?php 
										$consultaCuenta = "SELECT subidaPor, COUNT(*) as count FROM incidencias GROUP BY subidaPor ORDER BY count DESC LIMIT 1";
										$ejecutarCuenta = mysqli_query($conexion, $consultaCuenta);
										while ($resultado = mysqli_fetch_array($ejecutarCuenta)) {
											$id = $resultado['subidaPor'];
											$consultaNombre = "SELECT Email FROM usuarios WHERE IDUsuario = $id";
											$ejecutarNombre = mysqli_query($conexion, $consultaNombre);
											$resultadoNombre = mysqli_fetch_array($ejecutarNombre);
											echo $resultadoNombre['Email']. " (".$resultado['count'].")";
										}
										?>
										</td>
								</tr>
								<tr>
									<th>Administrador con más incidencias asignadas</th>
									<td>
									<?php 
										$consultaCuenta = "SELECT asignadaA, COUNT(*) as count FROM incidencias WHERE asignadaA IS NOT NULL GROUP BY asignadaA ORDER BY count DESC LIMIT 1";
										$ejecutarCuenta = mysqli_query($conexion, $consultaCuenta);
										while ($resultado = mysqli_fetch_array($ejecutarCuenta)) {
											$id = $resultado['asignadaA'];
											$consultaNombre = "SELECT Email FROM usuarios WHERE IDUsuario = $id";
											$ejecutarNombre = mysqli_query($conexion, $consultaNombre);
											$resultadoNombre = mysqli_fetch_array($ejecutarNombre);
											if (mysqli_num_rows($ejecutarNombre) !== 0) {
												echo $resultadoNombre['Email']. " (".$resultado['count'].")";
											} else {echo "Nadie.";}
										}
									?>
									</td>
								</tr>
								<tr>
									<th>Tiempo de ejecución del servidor</th>
									<td><?php  $buh = strtok( exec( "cat /proc/uptime" ), "." );
												 $days = sprintf( "%2d", ($buh/(3600*24)) );
												 $hours = sprintf( "%2d", ( ($buh % (3600*24)) / 3600) );
												 $min = sprintf( "%2d", ($buh % (3600*24) % 3600)/60 );
												 $sec = sprintf( "%2d", ($buh % (3600*24) % 3600)%60 );
												 
												echo "$days días, $hours horas, $min minutos, $sec segundos";
									  ?>
									</td>
								</tr>
							</tbody>
							
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
