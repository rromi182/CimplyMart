<?php
session_start();

include dirname(__DIR__) . "/config/database.php";



$url_inicio = $url_base . "/modules/start/view.php";
$url_compras = $url_base . "/modules/compras/view.php";
$url_ventas = $url_base . "/modules/ventas/view.php";
$url_pedido_compra = $url_base . "/modules/pedido_compra/view.php";
$url_presupuesto_compra = $url_base . "/modules/presupuesto_compra/view.php";
$url_orden_compra = $url_base . "/modules/orden_compra/view.php";
$url_ajuste_stock = $url_base . "/modules/ajuste_stock/view.php";

if (!isset($_SESSION['username'])) {
    // Si no ha iniciado sesión, redirige a la página de inicio de sesión
    header("location:" . $url_base . "/?alert=3");
    exit();
}
//Para evitar que ingrese con el URL sin iniciar sesión
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
    exit();
}

$query = mysqli_query($mysqli, "SELECT id_user, name_user, foto, permisos_acceso FROM usuarios WHERE id_user='$_SESSION[id_user]'")
    or die('error' . mysqli_error($mysqli));

$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Comercial 2 Hermanas">
    <meta name="author" content="Romina Almeida">
    <title>Comercial 2 Hermanas</title>

    <link rel="shortcut icon" href="<?php echo $url_base; ?>/assets/img/2hermanitaslogo.png">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?php echo $url_base ?>/plugins/select2/css/select2.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $url_base; ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo $url_base; ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?php echo $url_base; ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo $url_base; ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="<?php echo $url_base; ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo $url_base; ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo $url_base; ?>/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $url_base; ?>/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo $url_base; ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo $url_base; ?>/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo $url_base; ?>/plugins/summernote/summernote-bs4.min.css">

    <script language="javascript">
        function getkey(e) {
            if (window.event)
                return window.event.keyCode;
            else if (e)
                return e.which;
            else
                return null;
        }

        function goodchars(e, goods, field) {
            var key, keychar;
            key = getkey(e);
            if (key == null) return true;

            keychar = String.fromCharCode(key);
            keychar = keychar.toLowerCase();
            goods = goods.toLowerCase();

            //check goodkeys
            if (goods.indexOf(keychar) != -1)
                return true;
            if (key == null || key == 0 || key == 9 || key == 27)
                return true;
            if (key == 13) {
                var i;
                for (i = 0; i < field.form.elements.length; i++)
                    if (field == field.form.elements.length[i])
                        break;
                i = (i + 1) % field.form.elements.length;
                field.form.elements[i].focus();
                return false;
            }
            //else return false
            return false;
        }
    </script>


</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php
        $isHomePage = $_SERVER['REQUEST_URI'] == "/CimplyMart/modules/start/view.php";
        if ($isHomePage) { ?>
            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="<?php echo $url_base ?>/assets/img/2hermanitaslogo.png"
                    alt="AdminLTELogo" height="60" width="60">
            </div>
        <?php } ?>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #FFF">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"
                            style="color: #476072;"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?php echo $url_base ?>/modules/start/view.php" class="nav-link"
                        style="color: #476072; ">Inicio</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
               

                <!-- User Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <?php
                        if ($data['foto'] == "") { ?>
                            <img src="<?php echo $url_base ?>/images/user/user-default.png" class="img-circle elevation-2"
                                alt="Imagen de Usuario" width="30" height="30" style="padding: -20px; margin-right: 10px;">
                        <?php } else { ?>
                            <img src="<?php echo $url_base ?>/images/user/<?php echo $data['foto']; ?>"
                                class="img-circle elevation-2" alt="Imagen de Usuario" width="30" height="30"
                                style="margin-top: -5px; margin-right: 10px;">
                        <?php } ?>
                        <span class="hidden-xs" style="color: #476072">
                            <?php echo $data['name_user']; ?>
                        </span>
                        <i class="fas fa-angle-down right" style="color: #476072"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">Opciones</span>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-divider"></div>
                        <!--Perfil-->
                        <a href="../perfil/view.php" class="dropdown-item">
                            <i class="fa fa-user mr-2"></i> Perfil
                        </a>
                        <div class="dropdown-divider"></div>
                        <!--Cerrar Sesión-->
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                        </a>
                    </div>
                    <!--Modal Cerrar Sesión-->
                    <div class="modal fade" id="logout" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Cerrar Sesión
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!--Modal Logout-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cerrar Sesión</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas cerrar sesión?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <a class="btn btn-primary" href="<?php echo $url_base . "/logout.php"; ?>">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Modal Logout-->
        <!-- /.navbar -->
        <?php if ($_SESSION['permisos_acceso'] == 'Super Admin') { ?>

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #476072">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link" style="border-bottom: 1px solid #EEEEEE;">
                    <img src="<?php echo $url_base ?>/assets/img/2hermanitaslogo.png" alt="Comercial 2 Hermanas logo"
                        class="brand-image " width="50" height="50">
                    <small class="brand-text" style="color: #EEEEEE; font-weight: 650; font-size: 17px; ">Comercial 2
                        Hermanas</small>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom: 1px solid #EEEEEE;">
                        <div class="image">
                            <?php
                            if ($data['foto'] == "") { ?>
                                <img src="<?php echo $url_base ?>/images/user/user-default.png" class="img-circle elevation-2"
                                    alt="Imagen de Usuario" width="30" height="30">
                            <?php } else { ?>
                                <img src="<?php echo $url_base ?>/images/user/<?php echo $data['foto']; ?>"
                                    class="img-circle elevation-2" alt="Imagen de Usuario" width="30" height="30">
                            <?php } ?>
                        </div>
                        <div class="info">
                            <a href="../perfil/view.php" class="d-block" style="color:#EEEEEE; font-weight: 550;">
                                <?php echo $data['name_user']; ?>
                            </a>
                            <small style="color: #EEEEEE">
                                <?php echo $data['permisos_acceso']; ?>
                            </small>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">

                            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
                            <li class="nav-item">
                                <div class="nav-link active" style="background-color: #548CA8; ">
                                    <p style="color: #EEEEEE;">
                                        <i class="fas fa-list nav-icon"></i> Menú
                                    </p>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $url_base ?>/modules/start/view.php" class="nav-link">
                                    <i class="nav-icon fas fa-home" style="color: #EEEEEE"></i>
                                    <p style="color: #EEEEEE">
                                        Inicio
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-copy" style="color: #EEEEEE"></i>
                                    <p style="color: #EEEEEE">
                                        Referenciales Generales
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo $url_base?>/modules/departamento/view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Departamento</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $url_base?>/modules/ciudad/view.php" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ciudad</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p> Referenciales de Compras
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo $url_pedido_compra ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Pedido Compra</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $url_presupuesto_compra ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Presupuesto Compra</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $url_orden_compra ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Orden de Compra</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $url_compras ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nueva Compra</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Depósito</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Proveedor</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Producto</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Tipo de Producto</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Unidad de Medida</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-cart"></i>
                                    <p>
                                        Referenciales de Ventas
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo $url_base ?>/modules/clientes/view.php" class="nav-link"
                                            class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Cliente</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $url_ventas ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nueva Venta</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $url_base ?>/modules/user/view.php" class="nav-link">
                                    <i class="nav-icon fa fa-user"></i>
                                    <p>
                                        Administrar Usuario
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item" id="opcion1">
                                <a href="<?php echo $url_base ?>/modules/password/view.php" class="nav-link">
                                    <i class="nav-icon fa fa-lock icon-title"></i>
                                    <p>
                                        Cambiar Contraseña
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
            <!--SIDEBAR COMPRAS-->
        <?php } elseif ($_SESSION['permisos_acceso'] == "Compras") { ?>
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #476072">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link" style="border-bottom: 1px solid #EEEEEE;">
                    <img src="<?php echo $url_base ?>/assets/img/2hermanitaslogo.png" alt="Comercial 2 Hermanas logo"
                        class="brand-image " width="50" height="50">
                    <small class="brand-text" style="color: #EEEEEE; font-weight: 650; font-size: 17px; ">Comercial 2
                        Hermanas</small>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom: 1px solid #EEEEEE;">
                        <div class="image">
                            <?php
                            if ($data['foto'] == "") { ?>
                                <img src="<?php echo $url_base ?>/images/user/user-default.png" class="img-circle elevation-2"
                                    alt="Imagen de Usuario" width="30" height="30">
                            <?php } else { ?>
                                <img src="<?php echo $url_base ?>/images/user/<?php echo $data['foto']; ?>"
                                    class="img-circle elevation-2" alt="Imagen de Usuario" width="30" height="30">
                            <?php } ?>
                        </div>
                        <div class="info">
                            <a href="../perfil/view.php" class="d-block" style="color:#EEEEEE; font-weight: 550;">
                                <?php echo $data['name_user']; ?>
                            </a>
                            <small style="color: #EEEEEE">
                                <?php echo $data['permisos_acceso']; ?>
                            </small>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">

                            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
                            <li class="nav-item">
                                <div class="nav-link active" style="background-color: #548CA8; ">
                                    <p style="color: #EEEEEE;">
                                        <i class="fas fa-list nav-icon"></i> Menú
                                    </p>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $url_base ?>/modules/start/view.php" class="nav-link">
                                    <i class="nav-icon fas fa-home" style="color: #EEEEEE"></i>
                                    <p style="color: #EEEEEE">
                                        Inicio
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-copy" style="color: #EEEEEE"></i>
                                    <p style="color: #EEEEEE">
                                        Referenciales Generales
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Departamento</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ciudad</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-bag"></i>
                                    <p> Referenciales de Compras
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo $url_pedido_compra ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Pedido Compra</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $url_compras ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nueva Compra</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Depósito</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Proveedor</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Producto</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Tipo de Producto</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Unidad de Medida</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            </li>
                            <li class="nav-item" id="opcion1">
                                <a href="<?php echo $url_base ?>/modules/password/view.php" class="nav-link">
                                    <i class="nav-icon fa fa-lock icon-title"></i>
                                    <p>
                                        Cambiar Contraseña
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
            <!--SIDEBAR VENTAS-->
        <?php } elseif ($_SESSION['permisos_acceso'] == "Ventas") { ?>
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #476072">
                <!-- Brand Logo -->
                <a href="index3.html" class="brand-link" style="border-bottom: 1px solid #EEEEEE;">
                    <img src="<?php echo $url_base ?>/assets/img/2hermanitaslogo.png" alt="Comercial 2 Hermanas logo"
                        class="brand-image " width="50" height="50">
                    <small class="brand-text" style="color: #EEEEEE; font-weight: 650; font-size: 17px; ">Comercial 2
                        Hermanas</small>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom: 1px solid #EEEEEE;">
                        <div class="image">
                            <?php
                            if ($data['foto'] == "") { ?>
                                <img src="<?php echo $url_base ?>/images/user/user-default.png" class="img-circle elevation-2"
                                    alt="Imagen de Usuario" width="30" height="30">
                            <?php } else { ?>
                                <img src="<?php echo $url_base ?>/images/user/<?php echo $data['foto']; ?>"
                                    class="img-circle elevation-2" alt="Imagen de Usuario" width="30" height="30">
                            <?php } ?>
                        </div>
                        <div class="info">
                            <a href="../perfil/view.php" class="d-block" style="color:#EEEEEE; font-weight: 550;">
                                <?php echo $data['name_user']; ?>
                            </a>
                            <small style="color: #EEEEEE">
                                <?php echo $data['permisos_acceso']; ?>
                            </small>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">

                            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
                            <li class="nav-item">
                                <div class="nav-link active" style="background-color: #548CA8; ">
                                    <p style="color: #EEEEEE;">
                                        <i class="fas fa-list nav-icon"></i> Menú
                                    </p>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $url_base ?>/modules/start/view.php" class="nav-link">
                                    <i class="nav-icon fas fa-home" style="color: #EEEEEE"></i>
                                    <p style="color: #EEEEEE">
                                        Inicio
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-copy" style="color: #EEEEEE"></i>
                                    <p style="color: #EEEEEE">
                                        Referenciales Generales
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Departamento</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ciudad</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-shopping-cart"></i>
                                    <p>
                                        Referenciales de Ventas
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Cliente</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $url_ventas ?>" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nueva Venta</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item" id="opcion1">
                                <a href="<?php echo $url_base ?>/modules/password/view.php" class="nav-link">
                                    <i class="nav-icon fa fa-lock icon-title"></i>
                                    <p>
                                        Cambiar Contraseña
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

        <?php } ?>


        <!-- /.content-header -->

        <!-- Main content -->

        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <!-- right col -->