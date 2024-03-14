<?php
include "../../views/header.php";
$url_ajuste_stock_process = $url_base . "/modules/ajuste_stock/proses.php";
$url_pedido_compra_view = $url_base . "/modules/ajuste_stock/view.php";
?>

<?php
if (isset($_GET['form']) && $_GET['form'] == 'agregar') {
    ?>
    <!--AGREGAR PRODUCTO AL STOCK-->
    <div class="content-wrapper" style="background-color: #fff">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <li class="fa fa-edit icon-title" style="margin: 5px;"></li> Agregar Ajuste de Stock
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                            </a>
                            <a href="<?php echo $url_pedido_compra_view ?>" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Ajuste de Stock
                            </a>
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Agregar Ajuste de Stock
                            </a>
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div class="box box-primary">
                        <!-- general form elements -->
                        <div class="card card-info center">
                            <div class="card-header" style="background-color: #548CA8">
                                <h3 class="card-title">Agregar Producto al Stock</h3>
                            </div>
                            <form role="form" action="<?php echo $url_ajuste_stock_process ?>?act=add" method="POST">
                                <div class="box-body">
                                    <?php
                                    //Método para generar código
                                    $query_id = mysqli_query($mysqli, "SELECT MAX(id_ajuste_stock) as id FROM ajuste_stock")
                                        or die('Error' . mysqli_error($mysqli));

                                    $count = mysqli_num_rows($query_id);
                                    if ($count <> 0) {
                                        $data_id = mysqli_fetch_assoc($query_id);
                                        $codigo = $data_id['id'] + 1;
                                    } else {
                                        $codigo = 1;
                                    }
                                    ?>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                            style="margin-left: 28px; margin-top:15px;">Cód. Ajuste</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" style="margin-top: 15px" name="codigo"
                                                value="<?php echo $codigo; ?>" readonly>
                                        </div>

                                        <label class="col-sm-1 col-form-label" style="margin-top: 15px">Fecha</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control date-picker" style="margin-top: 15px"
                                                data-date-format="dd-mm-yyyy" name="fecha" autocomplete="off"
                                                value="<?php echo date("Y-m-d"); ?>" readonly>
                                        </div>

                                        <label class="col-sm-1 col-form-label" style="margin-top: 15px">Hora</label>
                                        <div class="col-sm-2">
                                            <?php
                                            date_default_timezone_set('America/Asuncion');
                                            ?>
                                            <input type="text" class="form-control date-picker" style="margin-top: 15px"
                                                data-date-format="H-mm-ss" name="hora" autocomplete="off"
                                                value="<?php echo date("H:i:s"); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                            style="margin-left: 28px; margin-top:15px;">Depósito</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" name="cod_deposito"
                                                data-placeholder="-- Seleccionar  Depósito --" autocomplete="off" required>
                                                <option value="">Seleccionar Depósito</option>
                                                <?php
                                                $query_dep = mysqli_query($mysqli, "SELECT cod_deposito, descrip
                                            FROM deposito
                                            ORDER BY cod_deposito ASC") or die('Error' . mysqli_error($mysqli));
                                                while ($data_dep = mysqli_fetch_assoc($query_dep)) {
                                                    echo "<option value=\"$data_dep[cod_deposito]\">$data_dep[cod_deposito] | $data_dep[descrip]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                            style="margin-left: 28px; margin-top:15px;">Producto</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" name="cod_producto"
                                                data-placeholder="-- Seleccionar  Producto --" autocomplete="off" required>
                                                <option value="">Seleccionar Producto</option>
                                                <?php
                                                $query_dep = mysqli_query($mysqli, "SELECT * FROM v_stock
                                            ORDER BY cod_producto ASC") or die('Error' . mysqli_error($mysqli));
                                                while ($data_dep = mysqli_fetch_assoc($query_dep)) {
                                                    echo "<option value=\"$data_dep[cod_producto]\">$data_dep[cod_producto] | $data_dep[p_descrip]| Dep: $data_dep[descrip] | Stock: $data_dep[cantidad]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                            style="margin-left: 28px; margin-top:15px;">Cantidad</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="cantidad" autocomplete="off"
                                                maxlength="6" onkeypress="return goodchars(event, '0123456789',this)"
                                                placeholder="Ingresa Cantidad a Ajustar" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                            style="margin-left: 28px; margin-top:15px;">Motivo</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="motivo" autocomplete="off"
                                                maxlength="50" placeholder="Ingrese Motivo" required>
                                            <small style="opacity: 0.8;">Describa el motivo en 50 caracteres máx</small>
                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input type="submit" class="btn btn-primary btn-submit" name="Guardar"
                                                value="Guardar">
                                            <a href="<?php echo $url_pedido_compra_view ?>"
                                                class="btn btn-default btn-reset">Cancelar</a>
                                        </div>
                                    </div>
                                </div>

                        </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    </div>

    </section>

    <?php
} elseif ($_GET['form'] == 'restar') {
    ?>
    <!--RESTAR PRODUCTO DEL STOCK-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #fff">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <li class="fa fa-edit icon-title" style="margin: 5px;"></li> Agregar Ajuste de Stock
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                            </a>
                            <a href="<?php echo $url_pedido_compra_view ?>" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Ajuste de Stock
                            </a>
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Agregar Ajuste de Stock
                            </a>
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div class="box box-primary">
                        <!-- general form elements -->
                        <div class="card card-info center">
                            <div class="card-header" style="background-color: #548CA8">
                                <h3 class="card-title">Restar Producto del Stock</h3>
                            </div>
                            <form role="form" action="<?php echo $url_ajuste_stock_process ?>?act=remove" method="POST">
                                <div class="box-body">
                                    <?php
                                    //Método para generar código
                                    $query_id = mysqli_query($mysqli, "SELECT MAX(id_ajuste_stock) as id FROM ajuste_stock")
                                        or die('Error' . mysqli_error($mysqli));

                                    $count = mysqli_num_rows($query_id);
                                    if ($count <> 0) {
                                        $data_id = mysqli_fetch_assoc($query_id);
                                        $codigo = $data_id['id'] + 1;
                                    } else {
                                        $codigo = 1;
                                    }
                                    ?>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                            style="margin-left: 28px; margin-top:15px;">Cód. Ajuste</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" style="margin-top: 15px" name="codigo"
                                                value="<?php echo $codigo; ?>" readonly>
                                        </div>

                                        <label class="col-sm-1 col-form-label" style="margin-top: 15px">Fecha</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control date-picker" style="margin-top: 15px"
                                                data-date-format="dd-mm-yyyy" name="fecha" autocomplete="off"
                                                value="<?php echo date("Y-m-d"); ?>" readonly>
                                        </div>

                                        <label class="col-sm-1 col-form-label" style="margin-top: 15px">Hora</label>
                                        <div class="col-sm-2">
                                            <?php
                                            date_default_timezone_set('America/Asuncion');
                                            ?>
                                            <input type="text" class="form-control date-picker" style="margin-top: 15px"
                                                data-date-format="H-mm-ss" name="hora" autocomplete="off"
                                                value="<?php echo date("H:i:s"); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                            style="margin-left: 28px; margin-top:15px;">Depósito</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" name="cod_deposito"
                                                data-placeholder="-- Seleccionar  Depósito --" autocomplete="off" required>
                                                <option value="">Seleccionar Depósito</option>
                                                <?php
                                                $query_dep = mysqli_query($mysqli, "SELECT cod_deposito, descrip
                                            FROM deposito
                                            ORDER BY cod_deposito ASC") or die('Error' . mysqli_error($mysqli));
                                                while ($data_dep = mysqli_fetch_assoc($query_dep)) {
                                                    echo "<option value=\"$data_dep[cod_deposito]\">$data_dep[cod_deposito] | $data_dep[descrip]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                            style="margin-left: 28px; margin-top:15px;">Producto</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" name="cod_producto"
                                                data-placeholder="-- Seleccionar  Producto --" autocomplete="off" required>
                                                <option value="">Seleccionar Producto</option>
                                                <?php
                                                $query_dep = mysqli_query($mysqli, "SELECT * FROM v_stock
                                            ORDER BY cod_producto ASC") or die('Error' . mysqli_error($mysqli));
                                                while ($data_dep = mysqli_fetch_assoc($query_dep)) {
                                                    echo "<option value=\"$data_dep[cod_producto]\">$data_dep[cod_producto] | $data_dep[p_descrip]| Dep: $data_dep[descrip] | Stock: $data_dep[cantidad]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                            style="margin-left: 28px; margin-top:15px;">Cantidad</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="cantidad" autocomplete="off"
                                                maxlength="6" onkeypress="return goodchars(event, '0123456789',this)"
                                                placeholder="Ingresa Cantidad a Ajustar" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                            style="margin-left: 28px; margin-top:15px;">Motivo</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="motivo" autocomplete="off"
                                                maxlength="50" placeholder="Ingrese Motivo" required>
                                            <small style="opacity: 0.8;">Describa el motivo en 50 caracteres máx</small>
                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input type="submit" class="btn btn-primary btn-submit" name="Guardar"
                                                value="Guardar">
                                            <a href="<?php echo $url_pedido_compra_view ?>"
                                                class="btn btn-default btn-reset">Cancelar</a>
                                        </div>
                                    </div>
                                </div>

                        </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    </div>

    </section>
<?php } ?>

<?php include "../../views/footer.php"; ?>
