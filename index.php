<!DOCTYPE html>
<?php
	session_start();
/*	if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
			header('Location: login.php');
	} */
	include 'funcion.php';
	$conexion = conectarBD();
	if(isset($_SESSION['id'])) {
        $idusuario = mysqli_real_escape_string($conexion, $_SESSION['id']);
        $consultaTablaUsuario = "SELECT * FROM incidencias WHERE subidaPor = $idusuario AND estado <> 'Resuelta' ORDER BY fechaModificacion LIMIT 5";
        $resultadoTablaUsuario = mysqli_query($conexion, $consultaTablaUsuario);
    } else{$idusuario = "";}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>Ver incidencia</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<style> 
			th {
				background-color: #B0C4DE;
				border-top: solid black 1px;
			}
			td:first-child, th:first-child {
				 border-left: none;
                }
            td {
            width: 30px;
             white-space: nowrap;
  overflow: hidden;
            }
            .asunto {
            width: 30px;
             white-space: nowrap;
  overflow: hidden;
            }
            
            table {
				border-collapse:separate;
				border:solid grey 1px;
				border-radius:6px;
				-moz-border-radius:6px;
			}
			
			.incidencias {
                width: 40%;
                display: inline-block;
                vertical-align: top;
                margin: 10px;
            }
            .incidencias td{

            }

            .incidencias-usuario {
            display: block;
            margin: 20px auto;
    

            }
            .incidencias-maxima{

            }
            .incidencias-alta{

            }
            
            
            .index {
                text-align: center;
            }
		</style>
	</head>
	<body>
		<div class="index">
			<div class="incidencias-usuario incidencias">
				<table class="table table-striped">
					<thead>
						<tr><th colspan="4">Tus incidencias</th><th style="text-align:center;">Fecha de modificación</th></tr>
					</thead>
					<tbody>
                        <tr>
                            <?php
                                if ((isset($idusuario)) && (!empty($resultadoTablaUsuario))) {
                                    while ($tablaUsuario = mysqli_fetch_array($resultadoTablaUsuario)) {
                                        echo "<tr><td><a href=\"incidencia.php?ID={$tablaUsuario['idincidencias']}\">{$tablaUsuario['idincidencias']}</a></td>".
                                            "<td id=\"asunto\" lc>{$tablaUsuario['nombre']}</td>".
                                            "<td>{$tablaUsuario['estado']}</td>".
                                            "<td>{$tablaUsuario['prioridad']}</td>".
                                            "<td>{$tablaUsuario['fechaModificacion']}</td>";
                                    }
                                } else{
                                    echo "<td colspan=\"5\">No tiene ninguna incidencia activa. <a href=\"nuevaIncidencia.php\">Añadir incidencia.</a></td>";
                                }
                            ?>
                        </tr>
					</tbody>
                </table>
			</div>
            <div class="incidencias-maxima incidencias">
                <table class="table table-striped">
					<thead>
						<tr><th colspan="4">Últimas por prioridad: Máxima</th><th style="text-align:center;">Fecha de modificación</th></tr>
					</thead>
					<tbody>
                        <tr>
                            <?php
                                $consultaPrioridad = "SELECT idincidencias, nombre, estado, prioridad, fechaModificacion FROM incidencias WHERE prioridad = 'Máxima' AND estado <> 'Resuelta' ORDER BY fechaExpedicion LIMIT 5";
                                $ejecutarPrioridad = mysqli_query($conexion, $consultaPrioridad);
                                if ($ejecutarPrioridad !== NULL) {
                                    while ($resultado = mysqli_fetch_array($ejecutarPrioridad)) {
                                        echo "<tr><td><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                                "<td class=\"asunto\">{$resultado['nombre']}</td>".
                                                "<td>{$resultado['estado']}</td>".
                                                "<td>{$resultado['prioridad']}</td>".
                                                "<td>{$resultado['fechaModificacion']}</td>";
                                    }
                                } else {
                                    echo "<td colspan=\"5\">No existe ninguna incidencia en activo con esta prioridad.</td>";
                                } 
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="incidencias-alta incidencias">
                <table class="table table-striped">
					<thead>
						<tr><th colspan="4">Últimas por prioridad: Alta</th><th style="text-align:center;">Fecha de modificación</th></tr>
					</thead>
					<tbody>
                        <tr>
                            <?php
                            if(!empty($ejecutarPrioridad)) {
                                $consultaPrioridad = "SELECT idincidencias, nombre, estado, prioridad, fechaModificacion FROM incidencias WHERE prioridad = 'Alta' AND estado <> 'Resuelta' ORDER BY fechaExpedicion LIMIT 5";
                                $ejecutarPrioridad = mysqli_query($conexion, $consultaPrioridad);
                                while ($resultado = mysqli_fetch_array($ejecutarPrioridad)) {
                                            echo "<tr><td><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                            "<td id=\"asunto\">{$resultado['nombre']}</td>".
                                            "<td>{$resultado['estado']}</td>".
                                            "<td>{$resultado['prioridad']}</td>".
                                            "<td>{$resultado['fechaModificacion']}</td>"; 
                                }
                            } else{
                                echo "<td colspan=\"5\">No existe ninguna incidencia en activo con esta prioridad.</td>"; 
                                } 
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="incidencias-baja incidencias">
            <table class="table table-striped">
					<thead>
						<tr><th colspan="4">Últimas por prioridad: Baja</th><th style="text-align:center;">Fecha de modificación</th></tr>
					</thead>
					<tbody>
                        <tr>
                            <?php
                                    $consultaPrioridad = "SELECT idincidencias, nombre, estado, prioridad, fechaModificacion FROM incidencias WHERE prioridad = 'Baja' AND estado <> 'Resuelta' ORDER BY fechaExpedicion LIMIT 5";
                                    $ejecutarPrioridad = mysqli_query($conexion, $consultaPrioridad);
                                    if(!empty($ejecutarPrioridad)) {
                                        while ($resultado = mysqli_fetch_array($ejecutarPrioridad)) {
                                            echo "<tr><td><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                                "<td id=\"asunto\">{$resultado['nombre']}</td>".
                                                "<td>{$resultado['estado']}</td>".
                                                "<td>{$resultado['prioridad']}</td>".
                                                "<td>{$resultado['fechaModificacion']}</td>";
                                        } 
                                  }  else {
                                            echo "<td colspan=\"5\">No existe ninguna incidencia en activo con esta prioridad.</td>";  
                                    } 
                           ?>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="incidencias-pendiente incidencias">
            <table class="table table-striped">
					<thead>
						<tr><th colspan="4">Últimas por prioridad: No definida</th><th style="text-align:center;">Fecha de modificación</th></tr>
					</thead>
					<tbody>
                        <tr>
                            <?php
                                $consultaPrioridad = "SELECT idincidencias, nombre, estado, prioridad, fechaModificacion FROM incidencias WHERE prioridad = 'No definida' AND estado <> 'Resuelta' ORDER BY fechaExpedicion LIMIT 5 ";
                                $ejecutarPrioridad = mysqli_query($conexion, $consultaPrioridad);
                                if(!empty($ejecutarPrioridad)) {
                                    while ($resultado = mysqli_fetch_array($ejecutarPrioridad)) {
                                        echo "<tr><td><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                                "<td id=\"asunto\">{$resultado['nombre']}</td>".
                                                "<td>{$resultado['estado']}</td>".
                                                "<td>{$resultado['prioridad']}</td>".
                                                "<td>{$resultado['fechaModificacion']}</td>";
                                    }
                                } else{ echo "<td colspan=\"5\">No existe ninguna incidencia en activo con esta prioridad.</td>"; }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
		</div>
	</body>
