<!DOCTYPE html>
<style>
        .add-on .input-group-btn > .btn {
        border-left-width:0;left:-2px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        }
        /* stop the glowing blue shadow */
        .add-on .form-control:focus {
        box-shadow:none;
        -webkit-box-shadow:none; 
        border-color:#cccccc; 
        }

</style>

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
                        <li><a href="listar_incidencias.php">Incidencias</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                    <form class="navbar-form navbar-left" action="listar_incidencias.php?buscar=" method="get">
                        <div class="input-group add-on">
                        <input type="text" class="form-control" placeholder="Buscar" name="buscar" id="buscar">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                    </form>
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php
                        include_once 'funcion.php';
                        if (!isset($conexion)) {
                            $conexion = conectarBD();
                            global $conexion;
                        }
                        $nombre = htmlspecialchars($_SESSION['nombre']);
                        if (isset($_SESSION['apellidos'])){
                            $apellidos = htmlspecialchars($_SESSION['apellidos']);
                        }
                        echo $nombre;
                        if (isset($apellidos) && ($apellidos !== NULL)) {
                        echo " ".$apellidos;
                        } ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="listar_incidencias.php?usuario=<?php echo $_SESSION['id']; ?>">Ver tus incidencias</a></li>
                            <li><a href="listar_incidencias.php?historial">Últimas modificaciones</a></li>
                            <?php if ($_SESSION['tipoUsuario'] === 'Administrador'): ?>
                                <li><a href="backend.php">Panel de administración</a></li>
                            <?php endif; ?>
                            <li role="separator" class="divider"></li>
                            <li><a href="logout.php">Cerrar sesión</a></li>
                        </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    
