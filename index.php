<!DOCTYPE html>
<?php
	session_start();
    if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
			header('Location: login.php');
	} 
	include 'funcion.php';
	$conexion = conectarBD();
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
            margin-top: 30px;
    

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
            
		
		</style>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">RMI</a>
                </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Incidencias</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                    <form class="navbar-form navbar-left">
                        <div class="form-group">
                        <input type="text" class="form-control" placeholder="Buscar">
                        </div>
                        <button type="submit" class="btn btn-default">Buscar</button>
                    </form>
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php $consultaUsuario = "SELECT Nombre, Apellidos, Email FROM usuarios WHERE IDUsuario = $idusuario"; 
                        $resultadousuario = mysqli_query($conexion, $consultaUsuario);
                        $usuario = mysqli_fetch_array($resultadousuario);
                        echo $usuario['Nombre'];
                        if ($usuario['Apellidos'] !== NULL) {
                        echo " ".$usuario['Apellidos'];
                        } ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <?php if ($_SESSION['tipoUsuario'] === 'Administrador') {
                                echo "<li><a href=\"backend.php\">Panel de administración</a></li>";
                                }
                            ?>
                            <li role="separator" class="divider"></li>
                            <li><a href="logout.php">Cerrar sesión</a></li>
                        </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    
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
                                    $consultaPrioridad = "SELECT idincidencias, nombre, estado, prioridad, fechaModificacion FROM incidencias WHERE prioridad = 'Máxima' AND estado <> 'Resuelta' ORDER BY fechaExpedicion DESC LIMIT 5";
                                    $ejecutarPrioridad = mysqli_query($conexion, $consultaPrioridad);
                                    if ($ejecutarPrioridad !== NULL) {
                                        while ($resultado = mysqli_fetch_array($ejecutarPrioridad)) {
                                            echo "<tr><td class=\"idincidencias\"><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                                    "<td class=\"asunto columna-asunto\">". htmlspecialchars($resultado['nombre']). "</td>".
                                                    "<td class=\"\">{$resultado['estado']}</td>".
                                                    "<td class=\"\">{$resultado['prioridad']}</td>".
                                                    "<td class=\"\" align=\"center\">{$resultado['fechaModificacion']}</td>";
                                        }
                                    } else {
                                        echo "<td colspan=\"5\">No existe ninguna incidencia en activo con esta prioridad.</td>";
                                    } 
                                ?>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr><td colspan="5"><small>Ver más</small></td></tr>
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
                                    $consultaPrioridad = "SELECT idincidencias, nombre, estado, prioridad, fechaModificacion FROM incidencias WHERE prioridad = 'Alta' AND estado <> 'Resuelta' ORDER BY fechaExpedicion DESC LIMIT 5";
                                    $ejecutarPrioridad = mysqli_query($conexion, $consultaPrioridad);
                                    while ($resultado = mysqli_fetch_array($ejecutarPrioridad)) {
                                                echo "<tr><td class=\"idincidencias\"><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                                "<td id=\"asunto columna-asunto\">". htmlspecialchars($resultado['nombre']). "</td>".
                                                "<td>{$resultado['estado']}</td>".
                                                "<td>{$resultado['prioridad']}</td>".
                                                "<td align=\"center\">{$resultado['fechaModificacion']}</td>"; 
                                    }
                                } else{
                                    echo "<td colspan=\"5\">No existe ninguna incidencia en activo con esta prioridad.</td>"; 
                                    } 
                                ?>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr><td colspan="5"><small>Ver más</small></td></tr>
                        </tfoot>
                    </table>
                    
                    <table class="table table-striped">
                        <thead>
                            <tr><th colspan="4">Últimas por prioridad: Baja</th><th style="text-align:center;">Fecha de expedición</th></tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                        $consultaPrioridad = "SELECT idincidencias, nombre, estado, prioridad, fechaModificacion FROM incidencias WHERE prioridad = 'Baja' AND estado <> 'Resuelta' ORDER BY fechaExpedicion DESC LIMIT 5";
                                        $ejecutarPrioridad = mysqli_query($conexion, $consultaPrioridad);
                                        if(!empty($ejecutarPrioridad)) {
                                            while ($resultado = mysqli_fetch_array($ejecutarPrioridad)) {
                                                echo "<tr><td class=\"idincidencias\"><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                                    "<td id=\"asunto columna-asunto\">". htmlspecialchars($resultado['nombre']). "</td>".
                                                    "<td>{$resultado['estado']}</td>".
                                                    "<td>{$resultado['prioridad']}</td>".
                                                    "<td align=\"center\">{$resultado['fechaModificacion']}</td>";
                                            } 
                                    }  else {
                                                echo "<td colspan=\"5\">No existe ninguna incidencia en activo con esta prioridad.</td>";  
                                        } 
                            ?>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr><td colspan="5"><small>Ver más</small></td></tr>
                        </tfoot>
                    </table>
                    <table class="table table-striped">
                            <thead>
                                <tr><th colspan="4">Últimas por prioridad: No definida</th><th style="text-align:center;">Fecha de expedición</th></tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                        $consultaPrioridad = "SELECT idincidencias, nombre, estado, prioridad, fechaModificacion FROM incidencias WHERE prioridad = 'No definida' AND estado <> 'Resuelta' ORDER BY fechaExpedicion DESC LIMIT 5 ";
                                        $ejecutarPrioridad = mysqli_query($conexion, $consultaPrioridad);
                                        if(!empty($ejecutarPrioridad)) {
                                            while ($resultado = mysqli_fetch_array($ejecutarPrioridad)) {
                                                echo "<tr><td class=\"idincidencias\"><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                                        "<td class=\"asunto columna-asunto\">". htmlspecialchars($resultado['nombre']). "</td>".
                                                        "<td>{$resultado['estado']}</td>".
                                                        "<td>{$resultado['prioridad']}</td>".
                                                        "<td align=\"center\">{$resultado['fechaModificacion']}</td>";
                                            }
                                        } else{ echo "<td colspan=\"5\">No existe ninguna incidencia en activo con esta prioridad.</td>"; }
                                    ?>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr><td colspan="5"><small>Ver más</small></td></tr>
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
                                        $consultaModificacion = "SELECT idincidencia, fechaModificacion, motivo, modificadaPor FROM incidencias_modificaciones ORDER BY fechaModificacion DESC LIMIT 17";
                                        $ejecutarModificacion = mysqli_query($conexion, $consultaModificacion);
                                        if (!empty($ejecutarModificacion) && ($ejecutarModificacion !== NULL)) {
                                            while ($resultadoMod = mysqli_fetch_array($ejecutarModificacion)) {
                                                $usuarioEmail = mysqli_query($conexion, "SELECT Email FROM usuarios WHERE IDUsuario = {$resultadoMod['modificadaPor']}");
                                                $resultadoEmail = mysqli_fetch_array($usuarioEmail);
                                                echo "<tr><td colspan=\"5\"><small><ul><li>El usuario {$resultadoEmail[0]} modificó la incidencia #<a href=\"incidencia.php?ID={$resultadoMod['idincidencia']}\">{$resultadoMod['idincidencia']}</a> </li><li>Motivo: {$resultadoMod['motivo']}</li></ul></small></td></tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan=\"5\">No se ha realizado ninguna modificación en el sistema</td></tr>";
                                        } 
                                    ?>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr><td colspan="5"><small>Ver más</small></td></tr>
                            </tfoot>
                        </table>
                    </div>
            <div class="col-md-6">
                <div class="row">
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    
                </div>
            </div>
            <div class="row">
                    <div class="col-md-6">
                        
                    </div>
                </div>
            </div>
    </body>
</html>
