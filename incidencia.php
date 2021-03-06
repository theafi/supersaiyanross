<!DOCTYPE html>
<?php
	session_start();
/*	if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
			header('Location: login.php');
	} */
	include 'funcion.php';
	$conexion = conectarBD();
	$id = mysqli_real_escape_string($conexion, $_GET['ID']);
	$buscarIncidencia = "SELECT * FROM incidencias WHERE idincidencias = $id;";
	$incidencia = mysqli_fetch_array(mysqli_query($conexion, $buscarIncidencia));
	

?>
<html>

	<head>
		<meta charset="UTF-8">
		<title>Ver incidencia</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/bootstrap.css">
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
		<style> 
				.incidencia {
                width: 50%;
                display: inline-block;
                vertical-align: top;
                margin: 20px;
				
			} 
			table {
				border-collapse:separate;
				border:solid grey 1px;
				border-radius:6px;
				-moz-border-radius:6px;
			}



			th {
				background-color: #B0C4DE;
				border-top: solid black 1px;
			}

			td:first-child, th:first-child {
				 border-left: none;
			}
			.descripcion {
				height: 150px;
			}
			.descripcion td {
				max-width: 300px;
				
				overflow: auto;
				
			}
			.header th {
				text-align: center;
			}
			.espaciador {
				background-color: 	#D3D3D3;
			}
			.modificaciones {
            display: inline-block;
            margin: 20px auto;
			}
			.modificaciones {
				max-width: 675px;
			}
			.modificaciones td{
			}
			.modificaciones-valores td {
				overflow: scroll;
			}
			.tablas {
                text-align: center;
			}
			.table td {
                text-align: left;
			}
			.header_datos td{
                text-align: center;
			}
			a{
				text-decoration: none;

			}
        
				

		</style>
	</head>
	<body>
        <?php include 'navegacion.php'; ?>
        <div class="tablas">
            <div class="incidencia">
                <table class="table tablaincidencias">
                    <tbody>
                        <tr class="header">
                            <th>ID</th>
                            <th>Categoría</th>
                            <th>Fecha de expedición</th>
                            <th>Última actualización</th>
                            <th>Operaciones</th>
                            
                        <tr class="header_datos">
                            <td align="center"><?php echo $incidencia['idincidencias']; ?></td>
                            <td align="center"><?php echo $incidencia['tipoProblema']; ?></td>
                            <td align="center"><?php echo $incidencia['fechaExpedicion']; ?></td>
                            <td align="center" colspan=""><?php echo $incidencia['fechaModificacion']; ?> </td>
                            <?php
                                if($_SESSION['tipoUsuario'] === 'Administrador') {
                                    echo "<td align=\"center\"><a title=\"Editar incidencia\" alt=\"Editar incidencia\" href=\"editarIncidencia.php?ID={$incidencia['idincidencias']}\"><span class=\"icon-pencil\"></span></a>".
                                    "&nbsp;".
                                    "<a title=\"Eliminar incidencia\" alt=\"Eliminar incidencia\" onclick=\"return confirm('¿Desea eliminar la incidencia?')\" href=\"borrarIncidencia.php?ID={$incidencia['idincidencias']}\"><span class=\"icon-cross\"></span>";
                                } elseif($_SESSION['id'] === $incidencia['subidaPor']) {
                                    if (!isset($incidencia['asignadaA']) && ($incidencia['estado'] === 'Pendiente') && ($incidencia['prioridad'] === 'No definida')) {
                                        echo "<td align=\"center\"><a title=\"Editar incidencia\" alt=\"Editar incidencia\" href=\"editarIncidencia.php?ID={$incidencia['idincidencias']}\"><span class=\"icon-pencil\"></span></a>".
                                        "&nbsp;".
                                        "<a title=\"Eliminar incidencia\" alt=\"Eliminar incidencia\" onclick=\"return confirm('¿Desea eliminar la incidencia?')\" href=\"borrarIncidencia.php?ID={$incidencia['idincidencias']}\"><span class=\"icon-cross\"></span>";
                                    } else{
                                         echo "<td align=\"center\"></td>";
                                 }
                                } else{
                                    echo "<td align=\"center\"><a title=\"Reportar incidencia\" alt=\"Reportar incidencia\" href=\"reportarIncidencia.php?ID={$incidencia['idincidencias']}\"><img src=\"flag.png\" height=\"20\"></a></td>";
                                }
                            
                            
                            ?>
                        </tr>
                            
                        </tr>
                        <tr class="espaciador">
                            <td colspan="5" rowspan=""></td> 
                        </tr>
                        <tr class="informador">
                            <th>Subido por</th>
                            <td colspan="2"><?php 
                                $consultaUsuario = "SELECT email FROM usuarios WHERE IDUsuario = {$incidencia['subidaPor']};";
                                $resultUsuario = mysqli_fetch_array(mysqli_query($conexion, $consultaUsuario));
                                echo htmlspecialchars($resultUsuario['email']); 
                                ?>
                            </td>
                            <th>Asignado a</th>
                            <td colspan=""><?php if ($incidencia['asignadaA'] == NULL) {
                                echo "Nadie";
                                } else{
                                $consultaUsuario = "SELECT email FROM usuarios WHERE IDUsuario = {$incidencia['asignadaA']};";
                                $resultUsuario = mysqli_fetch_array(mysqli_query($conexion, $consultaUsuario));
                                echo htmlspecialchars($resultUsuario['email']);
                                }
                                ?></td>
                            
                        </tr>
                        <tr class="prioridad">
                            <th>Prioridad</th>
                            <td colspan="4"><?php echo $incidencia['prioridad']; ?></td>
                        </tr>
                        <tr class="estado">
                            <th>Estado</th>
                            <td colspan="2"><?php echo $incidencia['estado']; ?>
                            
                            <th>Fecha de resolución</th>
                            <td colspan=""><?php echo $incidencia['fechaResolucion']; ?></td>
                        </tr>
                        <tr class="asunto">
                            <th>Resumen</th>
                            <td colspan="4"><?php echo htmlspecialchars($incidencia['nombre']); ?></td>
                        </tr>
                        <tr class="descripcion">
                            <th>Descripción</th>
                            <td colspan="4" ><?php echo htmlspecialchars($incidencia['descripcion']); ?></td>
                        </tr>
                        <tr class="espaciador">
                            <td colspan="5" rowspan=""></td>
                        </tr>
                        <tr class="imagenes">
                            <th align="left">Imágenes</th>
                            <?php
                                $consultaImagenes = "SELECT imagen FROM incidencias_imagenes WHERE idincidencias_imagenes = {$incidencia['idincidencias']}";
                                $imagen = mysqli_query($conexion, $consultaImagenes);
                                $nImagenes = mysqli_num_rows($imagen);
                                $colAsociada = 0;
                                $contador = 1;
                                //hola($imagen);
                                while ($row = mysqli_fetch_array($imagen)) {
                                        echo "<td align=\"center\"><a href=\"imagenes\\". $row[0] . "\" target=\"_blank\"><img src=\"imagenes\\" . $row[0] . "\" height=\"80px\"></a></td>";
                                        $contador++;
                                    }
                                if ($contador < 4) {
                                    for ($i=5-$contador; $i<4; $i++) {
                                        echo "<td align=\"center\">&nbsp;</td>";
                                    }
                                }
                                ?>
                                
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="espaciador">
            </div>
            <div class="modificaciones">
            <?php 
                $consultaModificaciones = "SELECT * FROM rmi.incidencias_modificaciones WHERE idincidencia = $id ORDER BY fechaModificacion DESC";
                $conexionModificaciones = mysqli_query($conexion, $consultaModificaciones);
                
                    if (!empty($conexionModificaciones)) {

                        echo "<table class=\"table table-striped\">".
                            "<th colspan=\"5\">Historial de modificaciones</th>".
                                "<tbody>".
                                    "<tr class=\"cabecera-historial\">".
                                        "<th>ID Modificación</th>".
                                        "<th colspan=\"4\">Detalles</th>".
                                        "</tr>";
                                    
                    while($resultadoModificaciones = mysqli_fetch_array($conexionModificaciones)) {
                        $modificadoremail = "SELECT email FROM rmi.usuarios WHERE IDUsuario = {$resultadoModificaciones['modificadaPor']};";
                        $resultadomodemail = mysqli_fetch_array(mysqli_query($conexion, $modificadoremail));
                        echo "<tr class=\"cuerpo-modificaciones\">".
                                    "<td id=\"{$resultadoModificaciones['idModificacion']}\">{$resultadoModificaciones['idModificacion']}</td>".
                                    "<td colspan=\"4\" class=\"modificaciones-valores\"><ul>". 
                                            "<li>Modificada por: ". $resultadomodemail['email']."</li>".
                                            "<li>Fecha: ". $resultadoModificaciones['fechaModificacion']. "</li>".
                                            "<li>Motivo: ". $resultadoModificaciones['motivo']. "</li>".
                                            "</ul></td></tr>";
                    }
                }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>
    </body>
</html>
