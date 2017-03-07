<?php
    if((!isset($_SESSION['id'])) && (empty($_SESSION['id']))) { 
		header('Location: login.php');
	} elseif ($_SESSION['tipoUsuario'] === 'Usuario' ) {
		header('Location: index.php');
	}
    if (isset($_POST['backupservidor'])) {
        $dbhost = "localhost";
        $dbusuario = "proyecto";
        $dbpassword = "71JYNcXnIOejQZvk";
        $fecha = date(YmdH);
      if (file_exists('dump/rmi-'.$fecha.'.sql')) {
            $_SESSION['error'] = "<div class=\"alert alert-error alert-dismissible\" role=\"alert\">
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                                            <strong>Error</strong>Ya se ha creado una copia de seguridad recientemente. Espere un poco antes de volver a hacer otra.</div>";
            header('Location: backend.php#backup');
        } else{ 
            exec('mysqldump rmi -u proyecto -p'. $dbpassword. '> dump/rmi-'.$fecha.'.sql');
            $_SESSION['success'] = "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">
                                            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                                            <strong>Éxito</strong> Se ha realizado la copia de seguridad con éxito.</div>";
            header('Location: backend.php#backup');
        }
    }
	?>
