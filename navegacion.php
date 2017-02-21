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
                    <form class="navbar-form navbar-left">
                        <div class="form-group">
                        <input type="text" class="form-control" placeholder="Buscar">
                        </div>
                        <button type="submit" post="buscar.php" class="btn btn-default">Buscar</button>
                    </form>
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php
                        include_once 'funcion.php';
                        if (!isset($conexion)) {
                            $conexion = conectarBD();
                            global $conexion;
                        }
                        $nombre = $_SESSION['nombre'];
                        $apellidos = $_SESSION['apellidos'];
                        echo $nombre;
                        if (isset($apellidos) && ($apellidos !== NULL)) {
                        echo " ".$apellidos;
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
    
