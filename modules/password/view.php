<?php
include "../../views/header.php"; 
$url_password_process = $url_base."/modules/password/process.php";?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #fff">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <li class="fa fa-lock icon-title" style="margin: 5px;"></li> Cambiar Contraseña
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                            </a>
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Cambiar Contraseña
                            </a>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!--Formulario Cambio de Contraseña-->
        <section class="content">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <!--Alerts de errores-->
                    <?php
                    if (empty($_GET['alert'])) {
                        echo "";
                    } elseif ($_GET['alert'] == 1) {
                        echo "<div class='alert alert-danger alert-dismissable'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                <h4 style='font-size: 18px'> <i class='icon fa fa-times-circle'></i>Error!:</h4>
                                <small>Contraseña incorrecta</small>
                            </div>";
                    } elseif ($_GET['alert'] == 2) {
                        echo "<div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <h6 style='font-size: 18px'> <i class='icon fa fa-times-circle'></i>Error!:</h6>
                            <small>La nueva contraseña ingresada no coincide </small>
                        </div>";
                    }elseif($_GET['alert'] == 3){
                        echo "<div class='alert alert-succsess alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h6 style='font-size: 18px'> <i class='icon fa fa-times-circle'></i>¡Contraseña actualizada!</h6>
                        <small>La nueva contraseña ha sido actualizada correctamente</small>
                    </div>";
                    }
                    ?>
                    <!-- Horizontal Form -->
                    <div class="card">
                        <div class="card-header"  style="background-color: #548CA8">
                            <h3 class="card-title" style="color: #fff">Cambio de Contraseña</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" class="form-horizontal" method="post" action="<?php echo $url_password_process?>">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Contraseña antigua</label>
                                    <div class="col-sm-5">
                                        <input type="password" class="form-control" name="old_pass"  autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Contraseña Nueva</label>
                                    <div class="col-sm-5">
                                        <input type="password" class="form-control" name="new_pass"  autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Repetir contraseña nueva</label>
                                    <div class="col-sm-5">
                                        <input type="password" class="form-control" name="retype_pass"  autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10" style="margin-left: 175px">
                                    <button type="submit" class="btn btn-info">Guardar</button>
                                    <a href="<?php echo $url_inicio?>" class="btn btn-default btn-reset">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                </div>
            </div>
        </section>
        
    <?php include "../../views/footer.php"; ?>