<!DOCTYPE html>
<?php
	session_start();
    if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
			header('Location: login.php');
	} 
	include 'funcion.php';
	if (!isset($conexion)) {
        $conexion = conectarBD();
    }
    $idusuario = mysqli_real_escape_string($conexion, $_SESSION['id']);
    $consultaTablaUsuario = "SELECT * FROM incidencias WHERE subidaPor = $idusuario AND estado <> 'Resuelta' ORDER BY fechaModificacion DESC LIMIT 5";
    $resultadoTablaUsuario = mysqli_query($conexion, $consultaTablaUsuario);
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
			}
			td:first-child, th:first-child {
				 border-left: none;
                }
                
            table {
				border-collapse:separate;
				border:solid grey 1px;
				border-radius:6px;
				-moz-border-radius:6px;
			}
            .idincidencias{
            width: 50px;
            }
            .incidencias-usuario {
            width: 800px;
            max-width: 900px;
            text-align: center;
            margin: auto;
            margin-top: 10px;
    

            }
            .asunto{
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .table>thead:first-child>tr:first-child>th.idincidencias {
            width:80px;
            max-width:80px;
            }
            .table>thead:first-child>tr:first-child>th.idincidencias {
            width:80px;
            max-width:80px;
            }
            .table>tbody>tr>td.columna-asunto {
                max-width: 150px;
            }
            .modificaciones {
                max-width: 500px;
            }
            .modificaciones li{
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            
		
		</style>
    </head>
    <body>
        <?php include 'navegacion.php'; ?>
        <div class="container">
            <div class="row">
                <div class="incidencias-usuario">
                    <table class="table table-striped">
                        <thead>
                            <tr><th colspan="4">Tus incidencias</th><th style="text-align:center;">Fecha de modificación</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                    if ((isset($idusuario)) && (!empty($resultadoTablaUsuario))) {
                                        while ($tablaUsuario = mysqli_fetch_array($resultadoTablaUsuario)) {
                                            echo "<tr><td class=\"idincidencias \"><a href=\"incidencia.php?ID={$tablaUsuario['idincidencias']}\">{$tablaUsuario['idincidencias']}</a></td>".
                                                "<td class=\"asunto columna-asunto\" >". htmlspecialchars($tablaUsuario['nombre']). "</td>".
                                                "<td class=\"\">{$tablaUsuario['estado']}</td>".
                                                "<td class=\"\">{$tablaUsuario['prioridad']}</td>".
                                                "<td class=\"\" align=\"center\">{$tablaUsuario['fechaModificacion']}</td>";
                                            }
                                    } else{
                                        echo "<td colspan=\"5\">No tiene ninguna incidencia pendiente o en activo.</td>";
                                    }
                                ?>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr><td colspan="5"><a href="nuevaIncidencia.php"><span class="glyphicon glyphicon-plus"> </span> Añadir incidencia</a></td></tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped">
                        <thead>
                            <tr><th colspan="4">Últimas por prioridad: Máxima</th><th style="text-align:center;">Fecha de expedición</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                    $consultaPrioridad = "SELECT idincidencias, nombre, estado, prioridad, fechaExpedicion FROM incidencias WHERE prioridad = 'Máxima' AND estado <> 'Resuelta' ORDER BY fechaExpedicion DESC LIMIT 5";
                                    $ejecutarPrioridad = mysqli_query($conexion, $consultaPrioridad);
                                    if ($ejecutarPrioridad !== NULL) {
                                        while ($resultado = mysqli_fetch_array($ejecutarPrioridad)) {
                                            echo "<tr><td class=\"idincidencias\"><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                                    "<td class=\"asunto columna-asunto\">". htmlspecialchars($resultado['nombre']). "</td>".
                                                    "<td class=\"\">{$resultado['estado']}</td>".
                                                    "<td class=\"\">{$resultado['prioridad']}</td>".
                                                    "<td class=\"\" align=\"center\">{$resultado['fechaExpedicion']}</td>";
                                        }
                                    } else {
                                        echo "<td colspan=\"5\">No existe ninguna incidencia en activo con esta prioridad.</td>";
                                    } 
                                ?>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr><td colspan="5"><small><a href="listar_incidencias.php?prioridad=Máxima">Ver más</a></small></td></tr>
                        </tfoot>
                    </table>
                    <table class="table table-striped">
                        <thead>
                            <tr><th colspan="4">Últimas por prioridad: Alta</th><th style="text-align:center;">Fecha de expedición</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                if(!empty($ejecutarPrioridad) && ($ejecutarPrioridad !== NULL)) {
                                    $consultaPrioridad = "SELECT idincidencias, nombre, estado, prioridad, fechaExpedicion FROM incidencias WHERE prioridad = 'Alta' AND estado <> 'Resuelta' ORDER BY fechaExpedicion DESC LIMIT 5";
                                    $ejecutarPrioridad = mysqli_query($conexion, $consultaPrioridad);
                                    while ($resultado = mysqli_fetch_array($ejecutarPrioridad)) {
                                                echo "<tr><td class=\"idincidencias\"><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                                "<td id=\"asunto columna-asunto\">". htmlspecialchars($resultado['nombre']). "</td>".
                                                "<td>{$resultado['estado']}</td>".
                                                "<td>{$resultado['prioridad']}</td>".
                                                "<td align=\"center\">{$resultado['fechaExpedicion']}</td>"; 
                                    }
                                } else{
                                    echo "<td colspan=\"5\">No existe ninguna incidencia en activo con esta prioridad.</td>"; 
                                    } 
                                ?>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr><td colspan="5"><small><a href="listar_incidencias.php?prioridad=Alta">Ver más</a></small></td></tr>
                        </tfoot>
                    </table>
                    
                    <table class="table table-striped">
                        <thead>
                            <tr><th colspan="4">Últimas por prioridad: Baja</th><th style="text-align:center;">Fecha de expedición</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                        $consultaPrioridad = "SELECT idincidencias, nombre, estado, prioridad, fechaExpedicion FROM incidencias WHERE prioridad = 'Baja' AND estado <> 'Resuelta' ORDER BY fechaExpedicion DESC LIMIT 5";
                                        $ejecutarPrioridad = mysqli_query($conexion, $consultaPrioridad);
                                        if(!empty($ejecutarPrioridad)) {
                                            while ($resultado = mysqli_fetch_array($ejecutarPrioridad)) {
                                                echo "<tr><td class=\"idincidencias\"><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                                    "<td id=\"asunto columna-asunto\">". htmlspecialchars($resultado['nombre']). "</td>".
                                                    "<td>{$resultado['estado']}</td>".
                                                    "<td>{$resultado['prioridad']}</td>".
                                                    "<td align=\"center\">{$resultado['fechaExpedicion']}</td>";
                                            } 
                                    }  else {
                                                echo "<td colspan=\"5\">No existe ninguna incidencia en activo con esta prioridad.</td>";  
                                        } 
                            ?>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr><td colspan="5"><small><a href="listar_incidencias.php?prioridad=Baja">Ver más</a></small></td></tr>
                        </tfoot>
                    </table>
                    <table class="table table-striped">
                            <thead>
                                <tr><th colspan="4">Últimas por prioridad: No definida</th><th style="text-align:center;">Fecha de expedición</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                        $consultaPrioridad = "SELECT idincidencias, nombre, estado, prioridad, fechaExpedicion FROM incidencias WHERE prioridad = 'No definida' AND estado <> 'Resuelta' ORDER BY fechaExpedicion DESC LIMIT 5 ";
                                        $ejecutarPrioridad = mysqli_query($conexion, $consultaPrioridad);
                                        if(!empty($ejecutarPrioridad)) {
                                            while ($resultado = mysqli_fetch_array($ejecutarPrioridad)) {
                                                echo "<tr><td class=\"idincidencias\"><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                                        "<td class=\"asunto columna-asunto\">". htmlspecialchars($resultado['nombre']). "</td>".
                                                        "<td>{$resultado['estado']}</td>".
                                                        "<td>{$resultado['prioridad']}</td>".
                                                        "<td align=\"center\">{$resultado['fechaExpedicion']}</td>";
                                            }
                                        } else{ echo "<td colspan=\"5\">No existe ninguna incidencia en activo con esta prioridad.</td>"; }
                                    ?>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr><td colspan="5"><small><a href="listar_incidencias.php?prioridad=No_definida">Ver más</a></small></td></tr>
                            </tfoot>
                        </table>
                </div>
                <div class="col-md-6 col-xs-12">
                    <table class="table table-striped">
                            <thead>
                                <tr><th colspan="5"><span class="glyphicon glyphicon-time"></span> Línea del tiempo</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                        $consultaModificacion = "SELECT idincidencia, idModificacion, fechaModificacion, motivo, modificadaPor FROM incidencias_modificaciones ORDER BY fechaModificacion DESC LIMIT 17";
                                        $ejecutarModificacion = mysqli_query($conexion, $consultaModificacion);
                                        if (!empty($ejecutarModificacion) && ($ejecutarModificacion !== NULL)) {
                                            while ($resultadoMod = mysqli_fetch_array($ejecutarModificacion)) {
                                                $usuarioEmail = mysqli_query($conexion, "SELECT Email FROM usuarios WHERE IDUsuario = {$resultadoMod['modificadaPor']}");
                                                $resultadoEmail = mysqli_fetch_array($usuarioEmail);
                                                echo "<tr><td class=\"modificaciones\" colspan=\"5\"><small><ul><li>El usuario ". htmlspecialchars($resultadoEmail[0]). " modificó la incidencia #<a href=\"incidencia.php?ID={$resultadoMod['idincidencia']}#{$resultadoMod['idModificacion']}\">{$resultadoMod['idincidencia']}</a> </li><li>Motivo: ". htmlspecialchars($resultadoMod['motivo']). "</li></ul></small></td></tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan=\"5\">No se ha realizado ninguna modificación en el sistema</td></tr>";
                                        } 
                                    ?>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr><td colspan="5"><small><a href="listar_incidencias.php?tabla=historial">Ver más</a></small></td></tr>
                            </tfoot>
                        </table>
                    </div>
            </div>
    </body>
</html>
