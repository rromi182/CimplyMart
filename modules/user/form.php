<?php
include "../../views/header.php";
$url_user_process = $url_base."/modules/user/process.php";
$url_user = $url_base."/modules/user/view.php"; ?>
<?php
if ($_GET['form'] == 'add') { ?>
    <!--AGEGAR USUARIO-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #fff">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <li class="fa fa-user icon-title" style="margin: 5px;"></li> Agregar Usuario
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
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Agregar Usuario
                            </a>
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-10 mx-auto" style="margin-top: 20px">
                        <!-- general form elements -->
                        <div class="card card-info center">
                            <div class="card-header" style="background-color: #548CA8">
                                <h3 class="card-title">Agregar Usuario</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" method="POST" action="<?php echo $url_user_process ?>?act=insert"
                                enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nombre de Usuario</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="username" autocomplete="off"
                                                placeholder="Ingresar nombre de usuario" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nombre y Apellido</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="name_user" autocomplete="off"
                                                placeholder="Ingresar nombre y apellido" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Contraseña</label>
                                        <div class="col-sm-5">
                                            <input type="password" class="form-control" name="password" autocomplete="off"
                                                placeholder="Ingresar contraseña" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="email" autocomplete="off"
                                                placeholder="Ingresar email" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Teléfono</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="telefono" autocomplete="off"
                                                maxlength="13" onkeypress="return goodchars(event, '0123456789',this)"
                                                placeholder="Ingresar Teléfono" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Permisos de acceso</label>
                                        <div class="col-sm-5">
                                            <select class="form-control" name="permisos_acceso" id="">
                                                <option value="0">Seleccionar Permiso</option>
                                                <option value="Super Admin">Adminisitrador de Sistemas</option>
                                                <option value="compras">Compras</option>
                                                <option value="ventas">Ventas</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <input type="submit" class="btn btn-info btn-submit" name="Guardar" value="Guardar"
                                        style="margin-right: 10px; margin-left: 5px">
                                    <a href="<?php echo $url_user ?>" class="btn btn-default btn-reset">Cancelar</a>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--EDITAR USUARIO-->
<?php } elseif ($_GET['form'] == 'edit') {
    if (isset($_GET['id'])) {
        $query = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE id_user = '$_GET[id]'")
            or die('error' . mysqli_error($mysqli));
        $data = mysqli_fetch_assoc($query);

    } ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #fff">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <li class="fa fa-user icon-title" style="margin: 5px;"></li> Editar Usuario
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
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Editar Usuario
                            </a>
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-10 mx-auto" style="margin-top: 20px">
                        <!-- general form elements -->
                        <div class="card card-info center">
                            <div class="card-header" style="background-color: #548CA8">
                                <h3 class="card-title">Editar Usuario</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" method="POST" action="<?php echo $url_user_process ?>?act=update"
                                enctype="multipart/form-data">
                                <input type="hidden" name="id_user" value="<?php echo $data['id_user']; ?>">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nombre de Usuario</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="username" autocomplete="off"
                                                value="<?php echo $data['username']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nombre y Apellido</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="name_user" autocomplete="off"
                                                value="<?php echo $data['name_user']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <div class="col-sm-5">
                                            <input type="email" class="form-control" name="email" autocomplete="off"
                                                value="<?php echo $data['email']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Teléfono</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="telefono" autocomplete="off"
                                                maxlength="13" onkeypress="return goodchars(event, '0123456789',this)"
                                                value="<?php echo $data['telefono']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Foto</label>
                                        <div class="col-sm-5">
                                            <div class="input-group mb-3">
                                                <input type="file" class="form-control" name="foto" id="inputGroupFile02">
                                                <?php
                                                if ($data['foto'] == "") { ?>
                                                    <img class="img-circle"
                                                        src="<?php echo $url_base ?>/images/user/user-default.png" width="45"
                                                        style="margin-left: 10px">
                                                <?php } else { ?>
                                                    <img class="img-circle"
                                                        src="<?php echo $url_base ?>/images/user/<?php echo $data['foto']; ?>"
                                                        width="45" style="margin-left: 10px">
                                                <?php }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Permisos de acceso</label>
                                        <div class="col-sm-5">
                                            <select class="form-control" name="permisos_acceso">
                                                <option value="<?php echo $data['permisos_acceso']; ?>">
                                                    <?php echo $data['permisos_acceso']; ?>
                                                </option>
                                                <option value="Super Admin">Adminisitrador de Sistemas</option>
                                                <option value="compras">Compras</option>
                                                <option value="ventas">Ventas</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <input type="submit" class="btn btn-info btn-submit" name="Guardar" value="Guardar"
                                        style="margin-right: 10px; margin-left: 5px">
                                    <a href="<?php echo $url_user ?>" class="btn btn-default btn-reset">Cancelar</a>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php } ?>

<?php include "../../views/footer.php"; ?>