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
		<title>Página principal</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<style>
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
                width: 270px;
                max-width: 270px;
            }
            
		
		</style>
    </head>
    <div class="container">
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr><th class="idincidencias">Tus incidencias</th><th class="asunto columna-asunto"></th><th></th><th></th><th style="text-align:center;">Fecha de modificación</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if ((isset($idusuario)) && (!empty($resultadoTablaUsuario))) {
                                while ($tablaUsuario = mysqli_fetch_array($resultadoTablaUsuario)) {
                                    echo "<tr><td class=\"idincidencias \"><a href=\"incidencia.php?ID={$tablaUsuario['idincidencias']}\">{$tablaUsuario['idincidencias']}</a></td>".
                                        "<td class=\"asunto columna-asunto\" lc>{$tablaUsuario['nombre']}</td>".
                                        "<td class=\"\">{$tablaUsuario['estado']}</td>".
                                        "<td class=\"\">{$tablaUsuario['prioridad']}</td>".
                                        "<td class=\"\">{$tablaUsuario['fechaModificacion']}</td>";
                                    }
                            } else{
                                echo "<td colspan=\"5\">No tiene ninguna incidencia activa. <a href=\"nuevaIncidencia.php\">Añadir incidencia.</a></td>";
                            }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6">
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
                                        echo "<tr><td class=\"idincidencias\"><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                                "<td class=\"asunto columna-asunto\">{$resultado['nombre']}</td>".
                                                "<td class=\"\">{$resultado['estado']}</td>".
                                                "<td class=\"\">{$resultado['prioridad']}</td>".
                                                "<td class=\"\">{$resultado['fechaModificacion']}</td>";
                                    }
                                } else {
                                    echo "<td colspan=\"5\">No existe ninguna incidencia en activo con esta prioridad.</td>";
                                } 
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
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
                                            echo "<tr><td class=\"idincidencias\"><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                            "<td id=\"asunto columna-asunto\">{$resultado['nombre']}</td>".
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
        </div>
        <div class="row">
            <div class="col-md-6">
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
                                            echo "<tr><td class=\"idincidencias\"><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                                "<td id=\"asunto columna-asunto\">{$resultado['nombre']}</td>".
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
                <div class="col-md-6">
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
                                            echo "<tr><td class=\"idincidencias\"><a href=\"incidencia.php?ID={$resultado['idincidencias']}\">{$resultado['idincidencias']}</a></td>".
                                                    "<td class=\"asunto columna-asunto\">{$resultado['nombre']}</td>".
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
        </div>
    </body>
</html>
