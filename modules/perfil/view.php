<?php
include "../../views/header.php";
$url_modificar_usu = $url_base . "/modules/perfil/form.php";

if (isset($_SESSION['id_user'])) {
    $query = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE id_user = '$_SESSION[id_user]'")
        or die('error' . mysqli_error($mysqli));
    $data = mysqli_fetch_assoc($query);
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #fff">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <li class="fa fa-user icon-title" style="margin: 5px;"></li> Perfil de Usuario
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                            <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                        </a>
                        <a href="#" style="color: inherit; text-decoration: none;">
                            <li class="fas fa-angle-right" style="margin: 5px;"></li> Perfil de Usuario
                        </a>
                    </ol>
                </div><!-- /.col -->
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php

                if (empty($_GET['alert'])) {
                    echo "";
                } elseif ($_GET['alert'] == 1) {
                    echo "<div class='alert alert-success alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h4>  <i class='icon fa fa-check-circle'></i> Exito!</h4>
                        Los datos de usuario ha sido cambiado satisfactoriamente.
                        </div>";
                } elseif ($_GET['alert'] == 2) {
                    echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h4>  <i class='icon fa fa-times-circle'></i> Error!</h4>
                        Asegúrese de que el archivo que se sube es correcto.
                        </div>";
                } elseif ($_GET['alert'] == 3) {
                    echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h4>  <i class='icon fa fa-times-circle'></i> Error!</h4>
                        Asegúrese de que la imagen no es más de 1 MB.
                        </div>";
                } elseif ($_GET['alert'] == 4) {
                    echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h4>  <i class='icon fa fa-times-circle'></i> Error!</h4>
                        Asegúrese de que el tipo de archivo subido sea  *.JPG, *.JPEG, *.PNG.
                        </div>";
                }
                ?>

                <div class="card">
                    <div class="card-header" style="background-color: #548CA8">
                        <h3 class="card-title" style="color: #fff">Perfil</h3>
                    </div>
                    <form class="form-horizontal" role="form" method="POST" action="<?php echo $url_modificar_usu ?>"
                        enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" name="id_user" value="<?php echo $data['id_user'] ?>">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">
                                    <?php
                                    if ($data['foto'] == "") { ?> 
                                        <img class="img-circle elevation-2" alt="Imagen de Usuario" width="75" height="75"
                                            style="border-radius: 50px; margin-top: 10px; margin-left: 130px; max-width: 75px;"
                                            src="<?php echo $url_base ?>/images/user/user-default.png">
                                    <?php } else { ?>
                                        <img class="img-circle elevation-2" alt="Imagen de Usuario" width="75" height="75"
                                            style="border-radius: 50px; margin-top: 10px; margin-left: 130px; max-width: 75px;"
                                            src="<?php echo $url_base ?>/images/user/<?php echo $data['foto']; ?>">
                                    <?php }
                                    ?>
                                </label>
                                <label style="font-size:25px; margin-left: 25px; margin-top:30px " class="col-sm-8">
                                    <?php echo $data['name_user'] ?>
                                </label>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" style="text-align:right" >Nombre de
                                    usuario</label>
                                <label style="text-align:left" class="col-sm-8 control-label">:
                                    <?php echo $data['username'] ?>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" style="text-align:right">Email</label>
                                <label style="text-align:left" class="col-sm-8 control-label">:
                                    <?php echo $data['email'] ?>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" style="text-align:right">Teléfono</label>
                                <label style="text-align:left" class="col-sm-8 control-label">:
                                    <?php echo $data['telefono'] ?>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" style="text-align:right">Permisos de
                                    acceso</label>
                                <label style="text-align:left" class="col-sm-8 control-label">:
                                    <?php echo $data['permisos_acceso'] ?>
                                </label>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" style="text-align:right">Status</label>
                                <label style="text-align:left" class="col-sm-8 control-label">:
                                    <?php echo $data['status'] ?>
                                </label>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10" style="margin-left: 130px">
                                    <input type="submit" class="btn btn-primary btn-submit" name="Modificar"
                                        value="Modificar">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include "../../views/footer.php"; ?>