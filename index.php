<?php
session_start();

// Destruir la sesión si ya está iniciada al llegar a la página de inicio de sesión
if (isset($_SESSION['username'])) {
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Comercial 2 Hermanas">
    <meta name="autor" content="Romina Almeida">
    <title>CimplyMart - Login</title>

    <link rel="shortcut icon" href="assets/img/2hermanitasLogo.png">

    <link rel="stylesheet" href="assets/css/styles.css">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    
        <link rel="stylesheet" href="assets/css/AdminLTE.min.css" type="text/css">

        <link rel="stylesheet" href="assets/css/style.css" type="text/css">
</head>

<body>

    <main>

        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                </div>
            </div>
            <!--Formulario de Login-->
            <div class="contenedor__login-register">
                <!--Login-->
                <form action="login-check.php" method="POST" class="formulario__login">
                    <img src="assets/img/2hermanitasLogo.png" alt="Logo de la empresa" class="logo">
                    <h4>Iniciar Sesión</h4>
                    <?php
                    if (empty($_GET['alert'])) {
                        echo "";
                    } elseif ($_GET['alert'] == 1) {
                        echo "<div class='alert alert-danger alert-dismissable'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                <h6 style='font-size: 18px'> <i class='icon fa fa-times-circle'></i>Error al iniciar sesión</h6>
                                <small>Usuario no encontrado, vuelva a ingresar sus datos.</small>
                            </div>";
                    } elseif ($_GET['alert'] == 2) {
                        echo "<div class='alert alert-success alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <h6 style='font-size: 18px'> <i class='icon fa fa-times-circle'></i>¡Sesión cerrada exitosamente!</h6>
                            <small>¡Gracias por utilizar nuestro sistema!</small>
                        </div>";
                    }elseif($_GET['alert'] == 3){
                        echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h6 style='font-size: 18px'> <i class='icon fa fa-times-circle'></i>¡Atención: Inicie Sesión!</h6>
                        <small>Por favor introduzca sus datos para ingresar.</small>
                    </div>";
                    }elseif($_GET['alert'] == 4){
                        echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h6 style='font-size: 18px'> <i class='icon fa fa-times-circle'></i>¡Atención: Ha intentado iniciar sesión más de 3 veces!</h6>
                        <small>Por favor, envíe comuniquese con el Administrador del Sistema.</small>
                    </div>";
                    }elseif($_GET['alert'] == 5){
                        echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h6 style='font-size: 18px'> <i class='icon fa fa-times-circle'></i>¡Contraseña incorrecta!</h6>
                        <small>Vuelva a ingresar sus datos.</small>
                    </div>";
                    }elseif($_GET['alert'] == 6){
                        echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h6 style='font-size: 18px'> <i class='icon fa fa-times-circle'></i>¡Contraseña incorrecta!</h6>
                        <small>Tiene 1 intento más.</small>
                    </div>";
                    }elseif($_GET['alert'] == 7){
                        echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h6 style='font-size: 18px'> <i class='icon fa fa-times-circle'></i>¡Atención: Usuario Bloqueado!</h6>
                        <small>Comuniquese con el Administrador del Sistema.</small>
                    </div>";}
                    ?>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control form-control-lg" placeholder="Nombre de usuario"
                            name="username" autocomplete="off" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control form-control-lg" placeholder="Contraseña"
                            name="password" autocomplete="off" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <button class="ingresar-btn">Ingresar</button>
                </form>
            </div>
        </div>
    </main>
    <script src="assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>
