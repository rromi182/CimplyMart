<?php
include "../../views/header.php";
$url_producto_process = $url_base . "/modules/producto/proses.php";
$url_productos = $url_base . "/modules/producto/view.php"; ?>

<?php
if ($_GET['form'] == 'add') { ?>
    <div class="content-wrapper" style="background-color: #fff">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <li class="fa fa-boxes icon-title" style="margin: 5px;"></li> Agregar Producto
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                            </a>
                            <a href="<?php echo $url_productos ?>" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li>Prodcutos
                            </a>
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Agregar Producto
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
                                <h3 class="card-title">Agregar Producto</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" class="form-horizontal"
                                action="<?php echo $url_producto_process ?>?act=insert" method="POST">
                                <div class="box-body">
                                    <?php
                                    //Método para generar código
                                    $query_id = mysqli_query($mysqli, "SELECT MAX(cod_producto) as id FROM producto")
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
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="codigo"
                                                value="<?php echo $codigo; ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- Combo para seleccionar tipo de producto-->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Tipo Producto</label>
                                        <div class="col-sm-4">
                                            <select name="tipo_producto" class="form-control select2" required>
                                                <option value="">Seleccionar</option>
                                                <?php
                                                $query_prov = mysqli_query($mysqli, "SELECT *
                                               FROM tipo_producto
                                               ORDER BY cod_tipo_prod ASC") or die('Error' . mysqli_error($mysqli));
                                                while ($data_prov = mysqli_fetch_assoc($query_prov)) {
                                                    echo "<option value=\"$data_prov[cod_tipo_prod]\">$data_prov[cod_tipo_prod] | $data_prov[t_p_descrip]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Unidad de Medida</label>
                                        <div class="col-sm-4">
                                            <select class="form-control select2" name="u_medida" required>
                                                <option value="">Seleccionar</option>
                                                <?php
                                                $query_prov = mysqli_query($mysqli, "SELECT *
                                               FROM u_medida
                                               ORDER BY id_u_medida ASC") or die('Error' . mysqli_error($mysqli));
                                                while ($data_prov = mysqli_fetch_assoc($query_prov)) {
                                                    echo "<option value=\"$data_prov[id_u_medida]\">$data_prov[id_u_medida] | $data_prov[u_descrip]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Descripción</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="p_descrip" autocomplete="off"
                                                placeholder="Descripcion del Producto" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Precio</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="precio" maxlength="7"
                                                autocomplete="off" onkeypress="return goodchars(event, '0123456789',this)"
                                                placeholder="Precio" required>
                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="submit" class="btn btn-primary btn-submit" name="Guardar"
                                                    value="Guardar">
                                                <a href="<?php echo $url_productos ?>"
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
        $query = mysqli_query($mysqli, "SELECT prod.cod_producto, prod.p_descrip, prod.precio,
                                        tp.t_p_descrip, um.u_descrip, tp.cod_tipo_prod, um.id_u_medida
                                        FROM producto prod
                                        JOIN tipo_producto tp ON prod.cod_tipo_prod = tp.cod_tipo_prod
                                        JOIN u_medida um ON prod.id_u_medida = um.id_u_medida
                                        WHERE cod_producto = '$_GET[id]'")
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
                                <li class="fa fa-boxes icon-title" style="margin: 5px;"></li> Editar Producto
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                    <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                                </a>
                                <a href="<?php echo $url_productos ?>" style="color: inherit; text-decoration: none;">
                                    <li class="fas fa-angle-right" style="margin: 5px;"></li> Productos
                                </a>
                                <a href="#" style="color: inherit; text-decoration: none;">
                                    <li class="fas fa-angle-right" style="margin: 5px;"></li> Editar Producto
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
                                    <h3 class="card-title">Editar Producto</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" class="form-horizontal"
                                    action="<?php echo $url_producto_process ?>?act=update" method="POST">
                                    <div class="box-body">

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Código</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="codigo"
                                                    value="<?php echo $data['cod_producto']; ?>" readonly>
                                            </div>
                                        </div>

                                        <!-- Combo para seleccionar tipo de producto-->
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tipo Producto</label>
                                            <div class="col-sm-4">
                                                <select name="tipo_producto" class="form-control select2" value="" required>
                                                    <option value="<?php echo $data['cod_tipo_prod'] ?>">
                                                        <?php echo $data['cod_tipo_prod'] . " | " . $data['t_p_descrip'] ?>
                                                    </option>
                                                    <?php
                                                    $query_prov = mysqli_query($mysqli, "SELECT *
                                                                                        FROM tipo_producto
                                                                                        ORDER BY cod_tipo_prod ASC") or die('Error' . mysqli_error($mysqli));
                                                    while ($data_prov = mysqli_fetch_assoc($query_prov)) {
                                                        echo "<option value=\"$data_prov[cod_tipo_prod]\">$data_prov[cod_tipo_prod] | $data_prov[t_p_descrip]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Unidad de Medida</label>
                                            <div class="col-sm-4">
                                                <select class="form-control select2" name="u_medida" required>
                                                <option value="<?php echo $data['id_u_medida'] ?>">
                                                        <?php echo $data['id_u_medida'] . " | " . $data['u_descrip'] ?>
                                                    </option>
                                                    <?php
                                                    $query_prov = mysqli_query($mysqli, "SELECT *
                                               FROM u_medida
                                               ORDER BY id_u_medida ASC") or die('Error' . mysqli_error($mysqli));
                                                    while ($data_prov = mysqli_fetch_assoc($query_prov)) {
                                                        echo "<option value=\"$data_prov[id_u_medida]\">$data_prov[id_u_medida] | $data_prov[u_descrip]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Descripción</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="p_descrip" autocomplete="off"
                                                value="<?php echo $data['p_descrip']; ?>"  required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Precio</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="precio" maxlength="7"
                                                    autocomplete="off"
                                                    onkeypress="return goodchars(event, '0123456789',this)"
                                                    value="<?php echo $data['precio']; ?>" required>
                                            </div>
                                        </div>


                                        <div class="box-footer">
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <input type="submit" class="btn btn-primary btn-submit" name="Guardar"
                                                        value="Guardar">
                                                    <a href="<?php echo $url_productos ?>"
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
