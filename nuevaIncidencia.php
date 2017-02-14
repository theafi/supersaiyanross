<!DOCTYPE html>
<?php
	session_start();
		if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
			header('Location: login.php');
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
				position: absolute;
				top: 50%;
				left: 50%;
				margin-right: -50%;
				transform: translate(-50%, -50%);
			}
			.incidencia form{
				position: relative;
				width: 100%;
			}
			.form-group textarea{
				position: relative;
				width: 100%
				}
		</style>
	</head>
	<body>
		<div class="incidencia">
			<form action="guardarIncidencia.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
				<input type="hidden" name="id" required value="<?php echo $_SESSION['id']; ?>" >
				<input type="text" name="asunto" class="form-control" placeholder="Escriba una descripción breve del problema" required maxLength="80"><br>
				<textarea name="descripcion" class="form-control" rows="10" maxLength="599" placeholder="Escriba una descripción más detallada del problema si lo ve necesario (máx. 600 caracteres)"></textarea>
				</div>
				<div class="input_fields_wrap">
					<label>Adjuntar imágenes (opcional)</label>
					<div id="file"><input type="file" id="imagen" name="imagen[]" id="InputFile" accept="image/*"></div>
					<button type="button" id="boton">Añadir más imágenes</button>
					<small class="help-block">Tamaño máximo: 1MB. Puede subir hasta cuatro imágenes.</small>
				</div>
				<div class="form-group">
					  <label for="sel1">Tipo de problema:</label>
					  <select class="form-control" id="sel1" name="tipoIncidencia">
						<option>Hardware</option>
						<option>Software</option>
						<option>Impresora</option>
						<option>Red</option>
						<option>Otros</option>
					  </select>
				</div>
				
				<div type="submit">
					<input name="submit" type="submit" class="btn btn-default">
				</div>
			</form>
		</div>
	</body>
</html>
