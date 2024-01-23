<?php
include "../../views/header.php"; 
$url_user_process = $url_base."/modules/user/process.php";

$url_user_form = $url_base."/modules/user/form.php";
?>
<?php if ($_SESSION['permisos_acceso'] == 'Super Admin') { ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #fff">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <li class="fa fa-user icon-title" style="margin: 5px;"></li> Administrar Usuario
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                            </a>
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Administrar Usuario
                            </a>
                        </ol>
                    </div><!-- /.col -->
                </div>
                <div class="text-right" style="margin-right: 20px">
                    <a class="btn btn-info" href="<?php echo $url_user_form ?>?form=add" title="Agregar" data-toggle="tool-tip"
                        style="margin-top: 10px">
                        <i class="fa fa-plus"></i> Agregar
                    </a>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <!--Alerts de errores-->
                    <?php
                    if (empty($_GET['alert'])) {
                        echo "";
                    } elseif ($_GET['alert'] == 1) {
                        echo "<div class='alert alert-success alert-dismissable'>
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                <h4 style='font-size: 18px'> <i class='icon fa fa-check-circle'></i>¡Éxito!:</h4>
                                <small>El usuario ha sido registrado correctamente.</small>
                            </div>";
                    } elseif ($_GET['alert'] == 2) {
                        echo "<div class='alert alert-success alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                            <h6 style='font-size: 18px'> <i class='icon fa fa-check-circle'></i>¡Éxito!:</h6>
                            <small>Los datos se actualizaron correctamente.</small>
                        </div>";
                    } elseif ($_GET['alert'] == 3) {
                        echo "<div class='alert alert-success alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h6 style='font-size: 18px'> <i class='icon fa fa-check-circle'></i>¡Éxito!</h6>
                        <small>El usuario ha sido activado correctamente.</small>
                    </div>";
                    } elseif ($_GET['alert'] == 4) {
                        echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h6 style='font-size: 18px'> <i class='icon fa fa-check-circle'></i>¡Éxito!</h6>
                        <small>El usuario ha sido bloqueado correctamente.</small>
                    </div>";
                    } elseif ($_GET['alert'] == 5) {
                        echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h6 style='font-size: 18px'> <i class='icon fa fa-times-circle'></i>¡Error!</h6>
                        <small>Asegurese de que la imagen es del formato indicado.</small>
                    </div>";
                    } elseif ($_GET['alert'] == 6) {
                        echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h6 style='font-size: 18px'> <i class='icon fa fa-times-circle'></i>¡Error!</h6>
                        <small>El archivo debe ser menor a 1 MB.</small>
                    </div>";
                    } elseif ($_GET['alert'] == 7) {
                        echo "<div class='alert alert-danger alert-dismissable'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h6 style='font-size: 18px'> <i class='icon fa fa-times-circle'></i>¡Error!</h6>
                        <small>Asegurese de que el tipo de archivo es: *.JPG *.JPEG *.PNG.</small>
                    </div>";
                    }
                    ?>
                    <!--Tabla de Usuarios-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tabla de usuarios</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Foto</th>
                                        <th>Nombre del Usuario</th>
                                        <th>Nombre</th>
                                        <th>Permisos de acceso</th>
                                        <th>Status</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $nro = 1;

                                    $query = mysqli_query($mysqli, "SELECT * FROM usuarios ORDER BY id_user ASC")
                                        or die('error' . mysqli_error($mysqli));

                                    while ($data = mysqli_fetch_assoc($query)) {
                                        echo "<tr>
                                        <td>$nro</td>";

                                        if ($data['foto'] == "") { ?>
                                            <td><img class="img-circle" src="<?php echo $url_base ?>/images/user/user-default.png"
                                                    width="45"></td>
                                        <?php } else { ?>
                                            <td><img class="img-circle"
                                                    src="<?php echo $url_base ?>/images/user/<?php echo $data['foto']; ?>"
                                                    width="45"></td>
                                        <?php }

                                        echo "<td>$data[username]</td>
                                            <td>$data[name_user]</td>
                                            <td>$data[permisos_acceso]</td>
                                            <td>$data[status]</td>
                                            <td class='center' witdh=100>
                                            <div>";
                                        if ($data['status'] == "activo") { ?>
                                            <a data-toggle="tooltip" data-placement="top" title="Bloquear"
                                                style="margin-right: 5px;" class="btn btn-warning btn-sm"
                                                href="<?php echo $url_user_process ?>?act=off&id=<?php echo $data['id_user']; ?>">
                                                <i class="fas fa-power-off"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a data-toggle="tooltip" data-placement="top" title="Activar"
                                                style="margin-right: 5px;" class="btn btn-success btn-sm"
                                                href="<?php echo $url_user_process ?>?act=on&id=<?php echo $data['id_user']; ?>">
                                                <i class="fas fa-power-off"></i>
                                            </a>
                                        <?php }

                                        echo"<a data-toggle='tooltip' data-placement='top' title='Modificar' class='btn btn-primary btn-sm' 
                                        href='$url_user_form?form=edit&id=$data[id_user]'><i class='fas fa-edit'></i>
                                        </a>
                                        </div>
                                        </td>";

                                        echo "</tr>";
                                        $nro++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
        </section>
    <?php } ?>

    <?php include "../../views/footer.php"; ?>