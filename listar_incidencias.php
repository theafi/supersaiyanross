<!DOCTYPE html>
<?php
    session_start();
    if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
            $_SESSION['ultimaPaginaVisitada'] = $_SERVER['REQUEST_URI'];
			header('Location: login.php');
	} 
	include 'funcion.php';
	$conexion = conectarBD();
	if (isset($_GET['usuario']) && ($_GET['usuario'] !== NULL)) {
        $usuario = mysqli_real_escape_string($conexion, $_GET['usuario']);
        }
	if (isset($_GET['prioridad']) && ($_GET['prioridad'] !== NULL)) {
        $prioridad = mysqli_real_escape_string($conexion, $_GET['prioridad']);
        }
    if (isset($_GET['buscar']) && ($_GET['buscar'] !== NULL)) {
        $buscar = mysqli_real_escape_string($conexion, $_GET['buscar']);
        }
	if (isset($prioridad) && ($prioridad !== NULL)) {
        switch ($prioridad) {
            case 'Máxima':
                $consultaTabla = "SELECT * FROM incidencias WHERE prioridad = 'Máxima' ORDER BY idincidencias DESC";
                $resultadoTabla = mysqli_query($conexion, $consultaTabla);
                break;
            case 'Alta':
                $consultaTabla = "SELECT * FROM incidencias WHERE prioridad = 'Alta' ORDER BY idincidencias DESC";
                $resultadoTabla = mysqli_query($conexion, $consultaTabla);
                break;
            case 'Baja':
                $consultaTabla = "SELECT * FROM incidencias WHERE prioridad = 'Baja' ORDER BY idincidencias DESC";
                $resultadoTabla = mysqli_query($conexion, $consultaTabla);
                break;
            case 'No_definida':
                $consultaTabla = "SELECT * FROM incidencias WHERE prioridad = 'No definida' ORDER BY idincidencias DESC";
                $resultadoTabla = mysqli_query($conexion, $consultaTabla);
                break;
        }
    
        
	} elseif (isset($buscar) && ($buscar !== NULL)) {
        $consultaTabla = "SELECT * FROM incidencias WHERE nombre LIKE '%$buscar%' OR descripcion LIKE '%$buscar%' ORDER BY idincidencias DESC";
        $resultadoTabla = mysqli_query($conexion, $consultaTabla);
	
	} elseif (isset($usuario) && ($usuario !== NULL)) {
        $consultaTabla = "SELECT * FROM incidencias WHERE subidaPor = $usuario ORDER BY idincidencias DESC";
        $resultadoTabla = mysqli_query($conexion, $consultaTabla);                                                                                                                                                                                              
	
	} else{
        $consultaTabla = "SELECT * FROM incidencias ORDER BY idincidencias DESC";
        $resultadoTabla = mysqli_query($conexion, $consultaTabla);
	}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Página principal</title>
		<link rel="stylesheet" href="css/bootstrap.css">
        <script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<style>
            th {
				background-color: #B0C4DE;
				border-top: solid black 1px;
				text-align: center;
			}
			td:first-child, th:first-child {
				 border-left: none;
                }
                
            table {
				border-collapse:separate;
				border:solid grey 1px;
				border-radius:6px;
				-moz-border-radius:6px;
				text-align: center;
			}
			.asunto{
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .table>tbody>tr>td.columna-asunto {
                max-width: 200px;
            }
            /*#search {
                position: relative;
                width: 200px;
                margin: auto;
            }

            #search input {
                width: 194px;
            }

            #search button {
                position: absolute;
                top: 0;
                right: 0;
                margin: 3px 1px;
            } */
            .buscar{
                margin:auto;
            }
		</style>
    </head>
    <body>
        <?php include 'navegacion.php'; ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form class="buscar" role="search" action="listar_incidencias.php?buscar=" method="get">
                        <div class="input-group add-on">
                            <input type="text" class="form-control" placeholder="Buscar" name="buscar" id="buscar">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <div class="incidencias-usuario">
                    <table class="table table-striped">
                        <thead>
                            <tr><th>ID</th><th>Nombre</th><th>Subida por</th><th>Asignado a</th><th>Estado</th><th>Prioridad</th><th>Fecha de expedición</th><th>Fecha de resolución</th><th>Última fecha de modificación</th></tr>
                        </thead>
                        <tbody>
                                <?php
                                    while ($tabla = mysqli_fetch_array($resultadoTabla)) {
                                          echo "<tr><td class=\"idincidencias \"><a href=\"incidencia.php?ID={$tabla['idincidencias']}\">{$tabla['idincidencias']}</a></td>
                                               <td class=\"asunto columna-asunto\" >". htmlspecialchars($tabla['nombre']). "</td>";
                                                $consultaUsuario = "SELECT Email FROM usuarios WHERE IDUsuario = {$tabla['subidaPor']}";
                                                $resultadoUsuario = mysqli_query($conexion, $consultaUsuario);
                                                $usuario = mysqli_fetch_array($resultadoUsuario);
                                                echo "<td>". $usuario[0]. "</td>";
                                                $consultaAdmin = "SELECT Email FROM usuarios WHERE IDUsuario = {$tabla['asignadaA']}";
                                                $resultadoAdmin = mysqli_query($conexion, $consultaAdmin);
                                                $admin = @mysqli_fetch_array($resultadoAdmin);
                                                if (@mysqli_num_rows($resultadoAdmin) === 1 ) {
                                                        echo "<td>".$admin['Email']."</td>";
                                                    } else {
                                                        echo "<td>Nadie</td>";
                                                    }
                                                
                                                echo "<td class=\"\">{$tabla['estado']}</td>".
                                                "<td class=\"\">{$tabla['prioridad']}</td>".
                                                "<td class=\"\" align=\"center\">{$tabla['fechaExpedicion']}</td>";
                                                if (isset($tabla['fechaResolucion']) && ($tabla['fechaResolucion'] !== NULL)) {
                                                    echo "<td class=\"\" align=\"center\">{$tabla['fechaResolucion']}</td></tr>";
                                                } else {
                                                    echo "<td>Pendiente</td>";
                                                }
                                                echo "<td>".$tabla['fechaModificacion']."</td>";
                                    }
                                    if (isset($buscar) && ($buscar !== NULL)){
                                        if (mysqli_num_rows($resultadoTabla) === 0) {
                                            echo "<tr><td colspan=\"9\">No se encuentra ninguna incidencia con esas características.</td></tr>";
                                        }
                                    }
                                    elseif (isset($prioridad) && ($prioridad !== NULL)){
                                        if (mysqli_num_rows($resultadoTabla) === 0) {
                                            echo "<tr><td colspan=\"9\">No existe ninguna incidencia con esa prioridad en el sistema.</td></tr>";
                                        }
                                    } else {
                                        if (mysqli_num_rows($resultadoTabla) === 0) {
                                            echo "<tr><td colspan=\"9\">No existe ninguna incidencia en el sistema.</td></tr>";
                                        }
                                    }
                                ?>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr><td align="center" colspan="9"><a href="nuevaIncidencia.php"><span class="glyphicon glyphicon-plus"> </span> Añadir incidencia</a></td></tr>
                        </tfoot>
                    </table>
                </div>
            </div>
    </body>
