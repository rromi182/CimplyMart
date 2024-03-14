<?php
include "../../views/header.php";
$url_compra_process = $url_base . "/modules/compras/proses.php";
$url_compra_view = $url_base . "/modules/compras/view.php";
?>

<?php
if ($_GET['form'] == 'add') { ?>
    <!--AGREGAR COMPRAS-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #fff">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <li class="fa fa-edit icon-title" style="margin: 5px;"></li> Agregar Compra
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                            </a>
                            <a href="<?php echo $url_compra_view ?>" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Compras
                            </a>
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Agregar
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
                                <h3 class="card-title">Agregar Compra</h3>
                            </div>
                            <form role="form" action="<?php echo $url_compra_process ?>?act=insert" method="POST">
                                <div class="box-body">
                                    <?php
                                    //Método para generar código
                                    $query_id = mysqli_query($mysqli, "SELECT MAX(cod_compra) as id FROM compra")
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
                                            style="margin-left: 20px; margin-top:15px;">Código</label>
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
                                        <!-- <label class="col-sm-2 col-form-label" style="margin-left: 10px">Proveedor</label> -->
                                        <!-- <div class="col-sm-3">
                                            <select class="form-control select2" name="codigo_proveedor"
                                                data-placeholder="-- Seleccionar Proveedor --" autocomplete="off" required>
                                                <option value="">Seleccionar Proveedor</option>
                                                <?php
                                            //     $query_prov = mysqli_query($mysqli, "SELECT cod_proveedor, razon_social, ruc
                                            // FROM proveedor
                                            // ORDER BY cod_proveedor ASC") or die('Error' . mysqli_error($mysqli));
                                            //     while ($data_prov = mysqli_fetch_assoc($query_prov)) {
                                            //         echo "<option value=\"$data_prov[cod_proveedor]\">$data_prov[razon_social] | $data_prov[ruc]</option>";
                                            //     }
                                                ?>
                                            </select>
                                        </div> -->
                                        <label class="col-sm-2 col-form-label" style="margin-left: 20px;">Depósito</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" name="codigo_deposito"
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
                                        <?php
                                    //Método para generar código
                                    // $factura_nro = mysqli_query($mysqli, "SELECT MAX(nro_factura) as id FROM compra")
                                    //     or die('Error' . mysqli_error($mysqli));

                                    // $count1 = mysqli_num_rows($factura_nro);
                                    // if ($count1 <> 0) {
                                    //     $data_nro = mysqli_fetch_assoc($factura_nro);
                                    //     $nro = $data_nro['id'] + 1;
                                    // } else {
                                    //     $nro = 1;
                                    // }
                                    ?>
                                        <label class="col-sm-2 col-form-label">N° de Factura</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="nro_factura" autocomplete="off"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" style="margin-left: 20px;">Orden de Compra</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" name="id_orden_compra"
                                                data-placeholder="-- Seleccionar Orden --" autocomplete="off" required
                                                onchange="cargarTabla(this.value)">
                                                <option value="">Seleccionar Orden</option>
                                                <?php
                                                $query = mysqli_query($mysqli, "SELECT *
                                            FROM orden_compra WHERE estado = 'aprobado'
                                            ORDER BY id_orden_compra ASC") or die('Error' . mysqli_error($mysqli));
                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<option value=\"$data[id_orden_compra]\">Cod.: $data[id_orden_compra] |Fecha: $data[fecha_registro]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <hr>
                                    <!-- <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="col-sm-2 control-label">Productos</label>
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#myModal">
                                                <span class="fa fa-plus">Agregar Productos</span>
                                            </button>
                                        </div>
                                    </div> -->
                                    <div id="tablaDetalles" class="col-md-9"></div>

                                    <!-- Cargar tabla de los detalles de la orden de compra -->

                                    <div class="box-footer">
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="submit" class="btn btn-primary btn-submit" name="Guardar"
                                                    value="Guardar">
                                                <a href="<?php echo $url_compra_view ?>"
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

        </section>

    <?php } ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>


    <script>
        $(document).ready(function () {
            cargarTabla(idOrden); // Asegúrate de tener el valor correcto aquí
        });

        function cargarTabla(idOrden) {
            $.ajax({
                url: '../../ajax/cargarTablaCompra.php',
                method: 'GET',
                data: { id_orden: idOrden },
                success: function (response) {
                    // Actualiza la tabla con los detalles del pedido
                    $('#tablaDetalles').html(response);
                },
                error: function () {
                    console.error('Error al obtener los detalles del pedido.');
                }
            });
        }
        function eliminarProducto(codigoProducto) {
            // Eliminar la fila de la tabla en la interfaz de usuario
            $('#tablaDetalles tr[data-codigo="' + codigoProducto + '"]').remove();

            // Eliminar el producto correspondiente de la estructura de datos que se enviará al servidor
            data = data.filter(item => item.codigoProducto !== codigoProducto);
        }
    </script>

    <script>
        // Agrega un evento al hacer clic en el ID del pedido
        $('select[name="id_orden_compra"]').on('change', function () {
            var idOrdenSeleccionado = $(this).val();
            cargarTabla(idOrdenSeleccionado);
        });
    </script>
    

    <?php include "../../views/footer.php"; ?>
