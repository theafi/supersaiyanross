<!DOCTYPE html>
<?php
	session_start();
		if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
		header('Location: login.php');
	} elseif ($_SESSION['tipoUsuario'] == 'Usuario' ) {
		header('Location: index.php');
	} 
	include 'funcion.php';
	$conexion = conectarBD();
?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lista de usuarios</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<style>
		
			<!-- Ancho máximo de la página antes de adaptarse la tabla a dispositivos móviles.-->
			#error {
					color: red;
				
				}
			.topright {
					position: absolute;
					top: 8px;
					right: 17px;
					font-size: 18px;
				}
			@media 
			only screen and (max-width: 760px),
			(min-device-width: 768px) and (max-device-width: 1024px)  {
			
				table, thead, tbody, th, td, tr { 
					display: block; 
				}
				
				<!-- Hide table headers (but not display: none;, for accessibility) -->
				thead tr { 
					position: absolute;
					top: -9999px;
					left: -9999px;
				}
				
				tr { border: 1px solid #ccc; }
				
				td { 
				
					border: none;
					border-bottom: 1px solid #eee; 
					position: relative;
					padding-left: 50%; 
				}
				
				td:before { 
					
					position: absolute;
					top: 6px;
					left: 6px;
					width: 45%; 
					padding-right: 10px; 
					white-space: nowrap;
				}
				

				td:nth-of-type(1):before { content: "CÓDIGO DE USUARIO"; }
				td:nth-of-type(2):before { content: "NOMBRE"; }
				td:nth-of-type(3):before { content: "APELLIDO"; }
				td:nth-of-type(4):before { content: "EMAIL"; }
				td:nth-of-type(5):before { content: "CIUDAD"; }
				td:nth-of-type(6):before { content: "PAIS"; }
				td:nth-of-type(7):before { content: "TIPO DE USUARIO"; }
				td:nth-of-type(8):before { content: "FECHA DE ALTA"; }
				td:nth-of-type(9):before { content: "Nº DE ENTRADAS"; }
				td:nth-of-type(10):before { content: "INICIOS DE SESIÓN ERRÓNEOS"; }
				td:nth-of-type(11):before { content: "ÚLTIMO INICIO DE SESIÓN"; }
				td:nth-of-type(12):before { content: "OPERACIONES"; }
			} 
			<!-- Smartphones (portrait and landscape) ----------- -->
			@media only screen
			and (min-device-width : 320px)
			and (max-device-width : 480px) {
				body {
					padding: 0;
					margin: 0;
					width: 320px; }
				}

			<!-- iPads (portrait and landscape) ----------- -->
			@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
				body {
					width: 450px;
				} 
				.tabla {
					position: relative;

				}

				}
				table , th, tr, td {
					position: relative;
					border-collapse: collapse;
					text-align:center;
					transform: scale 0.5;
					overflow: hidden; 
					text-overflow: ellipsis; 
					word-wrap: break-word;
				}
				table {
					border: transparent solid 2px;
					margin: 50px auto;
					box-shadow: 0 0 25px;
					overflow: hidden; 
					text-overflow: ellipsis; 
					word-wrap: break-word;
					width: 85%;
				}
				.impar{
					background-color:silver;
					color:black;
				}
				.par {
					background-color:white;
					color:black;
				}
				
				.impar td {
					
				}
				.par td {
					
				}
				td {
					padding: 5px 10px;
					overflow: hidden; 
					text-overflow: ellipsis; 
					word-wrap: break-word;
				}
				.eliminar {
					
					background: url("x.png") no-repeat center;
					background-size: 20px 20px;
					width: 20px;
				}
				.editar{
					
					background: url("y.png") no-repeat center;
					background-size: 20px 20px;
					width: 20px;
				}
				.cambiarPass{
					
					background: url("z.png") no-repeat center;
					background-size: 20px 20px;
				}
				
				.cambiarPass a{
					
					color: transparent;
				}
				
				.eliminar a{
					color: transparent;

				}
				.editar a{
					color: transparent;

				}
				.admin{
					width: 40px;
					overflow: hidden; 
					text-overflow: ellipsis; 
					word-wrap: break-word;
				} 
				table {
					border-collapse:separate;
					border:solid grey 1px;
					border-radius:6px;
					-moz-border-radius:6px;
				}


	</style>
	
	</head>
	<body>
		<div class="topright"><a href="logout.php">Cerrar sesión</a></div>
		<div class="usuarios">
			<table clas="table table-striped">
				<thead>
					<tr bgcolor="#DDDDDD"><th>CÓDIGO DE USUARIO</th><th>NOMBRE</th><th>APELLIDO</th><th>EMAIL</th><th>CIUDAD</th><th>PAIS</th><th>TIPO DE USUARIO</th><th>FECHA DE ALTA</th><th>Nº DE ENTRADAS AL SISTEMA</th><th>Nº DE INICIOS DE SESIÓN ERRÓNEOS</th><th>ÚLTIMO INICIO DE SESIÓN</th><th>OPERACIONES</th></tr>
				</thead>
				<tbody>
					<?php

					$sql = "select * from Usuarios;";
					$result  =  mysqli_query($conexion,  $sql)  or  die("ERROR:  " .mysqli_error($conexion));;
					$hola=0;
					while ($row = mysqli_fetch_assoc($result)) {
						if($hola == 1) {
							$hola = -1;
							$clase = "impar";
						}
						else {
							$clase = "par";
						}
						$pais = $row['Pais'];
						$consultapais = "SELECT Name FROM rmi.pais WHERE ID=$pais;";
						$ejecutarConsulta = mysqli_query($conexion, $consultapais);
						$resConsultaPais = mysqli_fetch_assoc($ejecutarConsulta);
						if ($row['bloqueado'] == 0) {
							$candadito = "<img src=\"unlock.png\" height=\"20\" width=\"20\" title=\"Bloquear usuario\" alt=\"Bloquear usuario\">";
						} else {
							$candadito = "<img src=\"lock.png\" height=\"20\" title=\"Desbloquear usuario\" alt=\"Desbloquear usuario\">";
						}

						echo "<tr class='$clase'>".
							"<td>{$row['IDUsuario']}</td>".
							"<td>{$row['Nombre']}</td>".
							"<td>{$row['Apellidos']}</td>".
							"<td>{$row['Email']}</td>".
							"<td>{$row['Ciudad']}</td>".
							"<td>{$resConsultaPais['Name']}</td>".
							"<td>{$row['tipoUsuario']}</td>".
							"<td>{$row['fechaAlta']}</td>".
							"<td>{$row['nEntradas']}</td>".
							"<td>{$row['nErrores']}</td>".
							"<td>{$row['ultimaVisita']}</td>".
							"<td class='admin'>".
							"<a title=\"Editar usuario\" href='usuario.php?ID={$row['IDUsuario']}'><img src=\"y.png\" title=\"Editar usuario\" alt=\"Editar usuario\" width=\"20\" height=\"20\"></a>".
							"<a title=\"Cambiar contraseña\" href='setpass.php?ID={$row['IDUsuario']}'><img src=\"z.png\" title=\"Cambiar contraseña\" alt=\"Cambiar contraseña\" width=\"20\" height=\"20\"></a>".
							"<a href='bloquearUsuario.php?ID={$row['IDUsuario']}'>". $candadito ."</a>".
							"<a title=\"Eliminar usuario\" href='borrarUsuario.php?ID={$row['IDUsuario']}' onclick=\"return confirm('¿Desea eliminar el registro?')\"><img src=\"x.png\" title=\"Eliminar usuario\" alt=\"Eliminar usuario\" width=\"20\" height=\"20\"></a>".
							"</td>".
						 "</tr>";
						 $hola++;
					}
					?>
				</tbody>
			</table>
		</div>
		<div id="error">
					<?php
						if (!empty($_SESSION['error'])) {
							echo $_SESSION['error'];
							$_SESSION['error'] = "";
						} else{
							$_SESSION['error'] = "";
						}
					?>
		</div>
			 <br> <a href="registro.php">Agregar usuario</a>
	</body>
</html>