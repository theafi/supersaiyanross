<!DOCTYPE html>
<?php
	session_start();
	
	if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
			header('Location: login.php');
	}
	include 'funcion.php';
	$conexion = conectarBD();
	$idincidencia = mysqli_real_escape_string($conexion, $_GET['ID']);
	$consultaIncidencia = "SELECT * FROM rmi.incidencias WHERE idincidencias = $idincidencia";
	$datosIncidencia = mysqli_fetch_array(mysqli_query($conexion, $consultaIncidencia));
	if ($_SESSION['id'] != $datosIncidencia['subidaPor']){
		if ($_SESSION['tipoUsuario'] != "Administrador") {
			header('Location: listarIncidencias.php');
		}
	}
	
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<title>Añadir incidencia</title>
		
		<script>
		window.onload = function(){
			var contador = 1;
			document.getElementById("boton").addEventListener("click",function(){
				if (++contador > 4) return;
				var imagen = document.createElement("input");
				imagen.type = "file";
				imagen.name = "imagen[]";
				imagen.accept = "image/*";
				var padre = document.getElementById('file');
				padre.appendChild(imagen);
			})

		};

		</script>
		<style>
			* {
				.border-radius(0) !important;
			}
			#field {
				margin-bottom:20px;
			}
			#error {
				color: red;	
			}
			::-webkit-input-placeholder {
			   text-align: justify;
			   text-overflow: ellipsis;

			  /* Required for text-overflow to do anything */
			  white-space: nowrap;
			  overflow: hidden;
			}

			:-moz-placeholder { /* Firefox 18- */
			   text-align: justify;
			   text-overflow: ellipsis
			}

			::-moz-placeholder {  /* Firefox 19+ */
			   text-align: justify;
			   text-overflow: ellipsis
			}

			:-ms-input-placeholder {  
			   text-align: justify;
			   text-overflow: ellipsis
			}
			.incidencia {
                text-align: center;
				}
            .formulario {
                width: 30%;
                display: inline-block;
                vertical-align: top;
                margin: 20px;
            }
		</style>
	</head>
	<body>
		<div class="incidencia">
            <div class="formulario">
                <form action="guardarModificacion.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                    <input type="hidden" name="idusuario" required value="<?php echo $_SESSION['id']; ?>" >
                    <input type="hidden" name="idincidencia" required value="<?php echo $datosIncidencia['idincidencias']; ?>" >
                    <input type="text" name="asunto" class="form-control" placeholder="Escriba una descripción breve del problema" value="<?php echo $datosIncidencia['nombre']; ?>" required <?php if ($_SESSION['tipoUsuario'] === 'Usuario') { echo "readonly";} ?> maxLength="80"><br>
                    <textarea name="descripcion"  class="form-control" rows="10" maxLength="600" placeholder="Escriba una descripción más detallada del problema si lo ve necesario (máx. 600 caracteres)"><?php echo $datosIncidencia['descripcion'] ?></textarea>
                    </div>
                    <!-- ya lo implementaré cuando tenga tiempo
                    <div class="input_fields_wrap">
                        <label>Adjuntar imágenes (opcional)</label>
                        <div id="file"><input type="file" id="imagen" name="imagen[]" id="InputFile" accept="image/*"></div>
                        <button type="button" id="boton">Añadir más imágenes</button>
                        <small class="help-block">Tamaño máximo: 1MB. Puede subir hasta cuatro imágenes.</small>
                    </div> -->
                    <div class="form-group">
                        <label for="sel1">Tipo de problema:</label>
                        <select class="form-control" id="sel1" name="tipoIncidencia" selected="<?php echo $datosIncidencia['tipoProblema']; ?>">
                            <option>Hardware</option>
                            <option>Software</option>
                            <option>Impresora</option>
                            <option>Red</option>
                            <option>Otros</option>
                        </select>
                    </div>
                    <?php 
                    if ($_SESSION['tipoUsuario'] == "Administrador") {
                        echo "<div class=\"form-group\">".
                                "<label for=\"sel1\">Prioridad:</label>".
                                "<select class=\"form-control\" id=\"sel1\" name=\"prioridad\" selected=\"". $datosIncidencia['prioridad']. "\">".
                                    "<option>No definida</option>".
                                    "<option>Baja</option>".
                                    "<option>Alta</option>".
                                    "<option>Máxima</option>".
                                    "</select>".
                            "</div>".
                            "<div class=\"form-group\">".
                                "<label for=\"sel1\">Estado:</label>".
                                "<select class=\"form-control\" id=\"sel1\" name=\"estado\" selected=\"". $datosIncidencia['estado']. "\">".
                                    "<option>Pendiente</option>".
                                    "<option>Activa</option>".
                                    "<option>Resuelta</option>".
                                    "</select>".
                            "</div>".
                            "<div class=\"form-group\">".
                                "<label for=\"sel1\">Asignado a:</label>".
                                "<select class=\"form-control\" id=\"sel1\" name=\"asignadaA\" selected=\"". $datosIncidencia['asignadaA']. "\">";
                                $query = "select IDUsuario, email from rmi.usuarios WHERE tipoUsuario='Administrador' ORDER BY IDUsuario;";
                                $resultado = mysqli_query($conexion, $query);
                                while ($valor = mysqli_fetch_array($resultado)) {
                                    echo "<option value='". $valor['IDUsuario']. "'>". $valor['email']. "</option>";
                                }
                            echo "<option value=\"NULL\">Nadie</option>".
                            "</div>";
                            
                        }
                    ?>
                    <div class="form-group">
                        <textarea name="motivo" class="form-control" rows="10" maxLength="600" placeholder="¿Por qué edita esta incidencia?" required></textarea>
                        <small>Este campo es obligatorio.</small>
                    </div>
                    <div class="submit">
                        <input name="submit" type="submit" class="btn btn-default">
                    </div>
                </form>
            </div>
        </div>
	</body>
</html>
