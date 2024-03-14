<?php
include "../../views/header.php";
$url_depart_process = $url_base . "/modules/proveedor/proses.php";
$url_depart = $url_base . "/modules/proveedor/view.php"; ?>
<?php
if ($_GET['form'] == 'add') { ?>
    <div class="content-wrapper" style="background-color: #fff">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <li class="fa fa-truck icon-title" style="margin: 5px;"></li> Agregar Proveedor
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                            </a>
                            <a href="<?php echo $url_depart ?>" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Proveedores
                            </a>
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Agregar Proveedor
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
                    <div class="col-md-12 mx-auto" style="margin-top: 20px">
                        <!-- general form elements -->
                        <div class="card card-info center">
                            <div class="card-header" style="background-color: #548CA8">
                                <h3 class="card-title">Agregar Proveedor</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" class="form-horizontal" action="<?php echo $url_depart_process ?>?act=insert"
                                method="POST">
                                <div class="box-body">
                                    <?php
                                    //Método para generar código
                                    $query_id = mysqli_query($mysqli, "SELECT MAX(cod_proveedor) as id FROM proveedor")
                                        or die('Error' . mysqli_error($mysqli));

                                    $count = mysqli_num_rows($query_id);
                                    if ($count <> 0) {
                                        $data_id = mysqli_fetch_assoc($query_id);
                                        $codigo = $data_id['id'] + 1;
                                    } else {
                                        $codigo = 1;
                                    }
                                    ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Código</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="cod_proveedor"
                                                value="<?php echo $codigo; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Razon Social</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="razon_social" maxlength="75"
                                                autocomplete="off" placeholder="Ingresa Razon Social" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">RUC</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="ruc" autocomplete="off"
                                                placeholder="Ingrese el RUC" maxlength="11"
                                                onkeypress="return goodchars(event, '0123456789',this)" required>
                                            <small style="opacity: 0.6">Ingrese solo números y sin espacios</small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Dirección</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="direccion" maxlength="100"
                                                autocomplete="off" placeholder="Ingrese la Dirección" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Teléfono</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="telefono" autocomplete="off"
                                                placeholder="Ingrese N° de Teléfono" maxlength="12"
                                                onkeypress="return goodchars(event, '0123456789',this)" required>
                                            <small style="opacity: 0.6">Ingrese solo números y sin espacios</small>
                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="submit" class="btn btn-primary btn-submit" name="Guardar"
                                                    value="Guardar">
                                                <a href="<?php echo $url_depart ?>"
                                                    class="btn btn-default btn-reset">Cancelar</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>

    <?php } elseif ($_GET['form'] == 'edit') {
    if (isset($_GET['id'])) {
        $query = mysqli_query($mysqli, "SELECT * FROM proveedor WHERE cod_proveedor = '$_GET[id]'")
            or die('Error' . mysqli_error($mysqli));
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
                                <li class="fa fa-truck icon-title" style="margin: 5px;"></li> Editar Proveedor
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                    <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                                </a>
                                <a href="<?php echo $url_depart ?>" style="color: inherit; text-decoration: none;">
                                    <li class="fas fa-angle-right" style="margin: 5px;"></li> Proveedores
                                </a>
                                <a href="#" style="color: inherit; text-decoration: none;">
                                    <li class="fas fa-angle-right" style="margin: 5px;"></li> Editar Departamento
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
                        <div class="col-md-12 mx-auto" style="margin-top: 20px">
                            <!-- general form elements -->
                            <div class="card card-info center">
                                <div class="card-header" style="background-color: #548CA8">
                                    <h3 class="card-title">Editar Proveedor</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" class="form-horizontal"
                                    action="<?php echo $url_depart_process ?>?act=update" method="POST">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Código</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="cod_proveedor"
                                                    value="<?php echo $data['cod_proveedor']; ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Razón Social</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="razon_social" maxlength="75"
                                                    autocomplete="off" value="<?php echo $data['razon_social']; ?>"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">RUC</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="ruc" autocomplete="off"
                                                value="<?php echo $data['ruc']; ?>" maxlength="11"
                                                    onkeypress="return goodchars(event, '0123456789',this)" required>
                                                <small style="opacity: 0.6">Ingrese solo números y sin espacios</small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Dirección</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="direccion" maxlength="100"
                                                    autocomplete="off" value="<?php echo $data['direccion']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Teléfono</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="telefono" autocomplete="off"
                                                value="<?php echo $data['telefono']; ?>" maxlength="12"
                                                    onkeypress="return goodchars(event, '0123456789',this)" required>
                                                <small style="opacity: 0.6">Ingrese solo números y sin espacios</small>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <input type="submit" class="btn btn-primary btn-submit" name="Guardar"
                                                        value="Guardar">
                                                    <a href="<?php echo $url_depart ?>"
                                                        class="btn btn-default btn-reset">Cancelar</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </section>
        </div>

    <?php }

?>
    <?php
    include "../../views/footer.php"; ?>
