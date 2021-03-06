<!DOCTYPE html>
<?php
    session_start();
    if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
            $_SESSION['ultimaPaginaVisitada'] = $_SERVER['REQUEST_URI'];
			header('Location: login.php');
	} 
	include 'funcion.php';
	$conexion = conectarBD();
    $idusuario = $_SESSION['id'];
    $tipoUsuario = $_SESSION['tipoUsuario'];
	if (isset($_GET['usuario']) && ($_GET['usuario'] !== NULL)) {
        $usuario = mysqli_real_escape_string($conexion, $_GET['usuario']);
        }
	if (isset($_GET['prioridad']) && ($_GET['prioridad'] !== NULL)) {
        $prioridad = mysqli_real_escape_string($conexion, $_GET['prioridad']);
        }
	if (isset($_GET['historial']) && ($_GET['historial'] !== NULL)) {
        $historial = mysqli_real_escape_string($conexion, $_GET['historial']);
        }
    if (isset($_GET['buscar']) && ($_GET['buscar'] !== NULL)) {
        $buscar = mysqli_real_escape_string($conexion, $_GET['buscar']);
        }

	if (isset($prioridad) && ($prioridad !== NULL)) {
        if ($tipoUsuario === 'Usuario') {
            $resultadoTabla = mysqli_query($conexion, "");
        } else {
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
        }
        
	} elseif (isset($historial) && ($historial !== NULL)){
		switch ($tipoUsuario)  {
			case 'Administrador':
				$consultaTabla = "SELECT * FROM incidencias_modificaciones ORDER BY fechaModificacion DESC";
				$resultadoTabla = mysqli_query($conexion, $consultaTabla);
				break;
			case 'Usuario':
				$idusuario = $_SESSION['id'];
				$consultaTabla = "SELECT idincidencia, idModificacion, fechaModificacion, motivo, modificadaPor FROM incidencias_modificaciones WHERE idincidencia IN (SELECT idincidencias FROM incidencias WHERE subidaPor = $idusuario) ORDER BY fechaModificacion DESC";
				$resultadoTabla = mysqli_query($conexion, $consultaTabla);
				break;
		}
	} elseif (isset($buscar) && ($buscar !== NULL)) {
		switch ($tipoUsuario) {
			case 'Administrador':
				$consultaTabla = "SELECT * FROM incidencias WHERE idincidencias LIKE '%$buscar%' OR nombre LIKE '%$buscar%' OR descripcion LIKE '%$buscar%'";
				$resultadoTabla = mysqli_query($conexion, $consultaTabla);
				break;
			case 'Usuario':
				$consultaTabla = "SELECT * FROM incidencias WHERE idincidencias IN (SELECT idincidencias FROM incidencias WHERE subidaPor = $idusuario AND idincidencias LIKE '%$buscar%' OR nombre LIKE '%$buscar%' OR descripcion LIKE '%$buscar%')";
				$resultadoTabla = mysqli_query($conexion, $consultaTabla);
				break;
		} 
		} elseif (isset($usuario) && ($usuario !== NULL)) {
        $consultaTabla = "SELECT * FROM incidencias WHERE subidaPor = $usuario ORDER BY idincidencias DESC";
        $resultadoTabla = mysqli_query($conexion, $consultaTabla);                                                                                                                                                                                              
	
	} else{
        $tipoUsuario = $_SESSION['tipoUsuario'];
		switch ($tipoUsuario)  {
            case 'Administrador':
                $consultaTabla = "SELECT * FROM incidencias ORDER BY idincidencias DESC";
                $resultadoTabla = mysqli_query($conexion, $consultaTabla);
                break;
            case 'Usuario': 
                $consultaTabla = "SELECT * FROM incidencias WHERE subidaPor = $idusuario ORDER BY idincidencias DESC";
                $resultadoTabla = mysqli_query($conexion, $consultaTabla);
                break;
        }
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
            @media (min-width: 1000px) {
            .container {
                width: 100%;
            }
            .contenedorprincipal {
                width: 100%
            }
            }
            th {
				background-color: #B0C4DE;
				border-top: solid black 1px;
				text-align: center;
			}
			td:first-child, th:first-child {
				 border-left: none;
                }
            .incidencias-usuario{
			}
			.incidencias-modificaciones{
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
            .asunto-modificaciones {
                max-width: 1000px;
                overflow: auto;
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
        <div class="container contenedorprincipal">
            <div class="row">
                <div class="col-md-12">
                    <form class="buscar" role="search" action="<?php if (isset($historial)) {echo "listar_incidencias.php?historial&buscar=";} else{echo "listar_incidencias.php?buscar=";} ?>" method="get">
                        <div class="input-group add-on">
                            <input type="text" class="form-control" placeholder="Buscar" name="buscar" id="buscar">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <br>
		<?php if (!isset($historial)): ?>
            <div class="row">
                <div class="col-md-12">
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
                                                    echo "<td>". htmlspecialchars($usuario[0]). "</td>";
                                                    $consultaAdmin = "SELECT Email FROM usuarios WHERE IDUsuario = {$tabla['asignadaA']}";
                                                    $resultadoAdmin = mysqli_query($conexion, $consultaAdmin);
                                                    $admin = @mysqli_fetch_array($resultadoAdmin);
                                                    if (@mysqli_num_rows($resultadoAdmin) === 1 ) {
                                                            echo "<td>".htmlspecialchars($admin['Email'])."</td>";
                                                        } else {
                                                            echo "<td>Nadie</td>";
                                                        }
                                                    
                                                    echo "<td class=\"\">{$tabla['estado']}</td>".
                                                    "<td class=\"\">{$tabla['prioridad']}</td>".
                                                    "<td class=\"\" align=\"center\">{$tabla['fechaExpedicion']}</td>";
                                                    if (isset($tabla['fechaResolucion']) && ($tabla['fechaResolucion'] !== NULL)) {
                                                        echo "<td class=\"\" align=\"center\">{$tabla['fechaResolucion']}</td>";
                                                    } else {
                                                        echo "<td>Pendiente</td>";
                                                    }
                                                    echo "<td>".$tabla['fechaModificacion']."</td>";
                                        }
                                        if (isset($buscar) && ($buscar !== NULL)){
                                            if (mysqli_num_rows($resultadoTabla) === 0) {
                                                echo "<tr><td colspan=\"9\">No se encuentra ninguna incidencia con esas características.</td></tr>";
                                            }
                                            
                                        } elseif (isset($prioridad) && ($prioridad !== NULL)){
                                            if (mysqli_num_rows($resultadoTabla) === 0 || $resultadoTabla === NULL) {
                                                echo "<tr><td colspan=\"9\">No existe ninguna incidencia con esa prioridad en el sistema.</td></tr>";
                                            }
                                        } else {
                                            if (mysqli_num_rows($resultadoTabla) === 0) {
                                                echo "<tr><td colspan=\"9\">No existe ninguna incidencia en el sistema o no tiene permisos para verla.</td></tr>";
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
            </div>
		<?php endif; ?>
		<?php if (isset($historial) && ($historial !== NULL)): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="incidencias-modificaciones">
                        <div class="container">
                            <table class="table table-striped">
                                <thead>
                                    <tr><th colspan="5" style="">Línea del tiempo</th></tr>
                                </thead>
                                <tbody>
                                            <tr>
                                                <?php
                                                    
                                                    if (!empty($resultadoTabla) && ($resultadoTabla !== NULL)) {
                                                        if (mysqli_num_rows($resultadoTabla) === 0) {
                                                                if ($_SESSION['tipoUsuario'] === 'Usuario'){
                                                                    echo "<td colspan=\"5\">No se ha realizado ninguna modificación en sus incidencias.</td>";
                                                                } else {
                                                                    echo "<td colspan=\"5\">No se ha realizado ninguna modificación en el sistema.</td>";
                                                                }
                                                        } else {
                                                            while ($resultadoMod = mysqli_fetch_array($resultadoTabla)) {
                                                            $usuarioEmail = mysqli_query($conexion, "SELECT Email FROM usuarios WHERE IDUsuario = {$resultadoMod['modificadaPor']}");
                                                            $resultadoEmail = mysqli_fetch_array($usuarioEmail);
                                                            echo "<tr><td>{$resultadoMod['fechaModificacion']}</td><td class=\"asunto asunto-modificaciones\" colspan=\"4\" align=\"left\"><small><ul><li>El usuario ". htmlspecialchars($resultadoEmail[0]). " modificó la incidencia #<a href=\"incidencia.php?ID={$resultadoMod['idincidencia']}#{$resultadoMod['idModificacion']}\">{$resultadoMod['idincidencia']}</a> </li><li>Motivo: ". htmlspecialchars($resultadoMod['motivo']). "</li></ul></small></td></tr>";
                                                            }
                                                        }
                                                    } else {
                                                        if ($_SESSION['tipoUsuario'] === 'Usuario'){
                                                                    echo "<td colspan=\"5\">No se ha realizado ninguna modificación en sus incidencias.</td>";
                                                                } else {
                                                                    echo "<td colspan=\"5\">No se ha realizado ninguna modificación en el sistema.</td>";
                                                                }
                                                    } 
                                                ?>
                                            </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<?php endif ?>
    </body>
