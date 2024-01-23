<?php
include "../../views/header.php";
$url_presupuesto_process = $url_base . "/modules/presupuesto_compra/proses.php";
$url_presupuesto_view = $url_base . "/modules/presupuesto_compra/view.php";
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
                            <li class="fa fa-edit icon-title" style="margin: 5px;"></li> Agregar Presupuesto Compra
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                            </a>
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Presupuesto Compra
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
                                <h3 class="card-title">Agregar Presupuesto</h3>
                            </div>
                            <form role="form" action="<?php echo $url_presupuesto_process ?>?act=insert" method="POST">
                                <div class="box-body">
                                    <?php
                                    //Método para generar código
                                    $query_id = mysqli_query($mysqli, "SELECT MAX(id_presupuesto_compra) as id FROM presupuesto_compra")
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
                                        <label class="col-sm-1 col-form-label"
                                            style="margin-left: 30px; margin-top:15px;">Código</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" style="margin-top: 15px" name="codigo"
                                                value="<?php echo $codigo; ?>" readonly>
                                        </div>

                                        <label class="col-sm-1 col-form-label" style="margin-top: 15px">Fecha
                                            Registro</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control date-picker" style="margin-top: 15px"
                                                data-date-format="dd-mm-yyyy" name="fecha_registro" autocomplete="off"
                                                value="<?php echo date("Y-m-d"); ?>" readonly>
                                        </div>
                                        <label class="col-sm-2 col-form-label" style="margin-top: 15px">Fecha
                                            Vencimiento</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control date-picker" style="margin-top: 15px"
                                                data-date-format="dd-mm-yyyy" name="fecha_vencimiento" autocomplete="off"
                                                value="<?php echo date("Y-m-d"); ?>">
                                        </div>

                                        <label class="col-sm-1 col-form-label" style="margin-top: 15px">Hora</label>
                                        <div class="col-sm-1">
                                            <?php
                                            date_default_timezone_set('America/Asuncion');
                                            ?>
                                            <input type="text" class="form-control date-picker" style="margin-top: 15px"
                                                data-date-format="H-mm-ss" name="hora" autocomplete="off"
                                                value="<?php echo date("H:i:s"); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label" style="margin-left: 30px;">Proveedor</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" name="codigo_proveedor"
                                                data-placeholder="-- Seleccionar Proveedor --" autocomplete="off" required>
                                                <option value="">Seleccionar Proveedor</option>
                                                <?php
                                                $query_prov = mysqli_query($mysqli, "SELECT cod_proveedor, razon_social, ruc
                                            FROM proveedor
                                            ORDER BY cod_proveedor ASC") or die('Error' . mysqli_error($mysqli));
                                                while ($data_prov = mysqli_fetch_assoc($query_prov)) {
                                                    echo "<option value=\"$data_prov[cod_proveedor]\">$data_prov[razon_social] | $data_prov[ruc]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-1 col-form-label" style="margin-left: 30px;">Pedido de
                                            Compra</label>
                                        <div class="col-sm-3">
                                            <select class="form-control select2" name="id_pedido_compra"
                                                data-placeholder="-- Seleccionar Pedido --" autocomplete="off" required
                                                onchange="cargarTabla(this.value)">
                                                <option value="">Seleccionar Pedido</option>
                                                <?php
                                                $query_prov = mysqli_query($mysqli, "SELECT *
                                            FROM pedido_compra WHERE estado = 'pendiente'
                                            ORDER BY id_pedido_compra ASC") or die('Error' . mysqli_error($mysqli));
                                                while ($data_prov = mysqli_fetch_assoc($query_prov)) {
                                                    echo "<option value=\"$data_prov[id_pedido_compra]\">Cod. Pedido: $data_prov[id_pedido_compra] |Fecha Pedido: $data_prov[fecha_registro]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="tablaDetalles">
                                        <!-- Aquí se mostrarán los detalles del pedido seleccionado -->
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
                                    <!-- <div id="resultados" class="col-md-9"></div> -->

                                    <div class="box-footer">
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="submit" class="btn btn-primary btn-submit" name="Guardar"
                                                    value="Guardar">
                                                <a href="<?php echo $url_presupuesto_view ?>"
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

    <!-- <script>
        $(document).ready(function () {
            load(1);
        });

        function load(page) {
            var x = $("#x").val();
            var parametros = { "action": "ajax", "page": page, "x": x };
            $("#loader").fadeIn('slow');
            $.ajax({
                url: '../../ajax/productos_pedido.php',
                data: parametros,
                beforeSend: function (objeto) {
                    $('#loader').html('<img src="../../images/ajax-loader.gif"> Cargando...');
                },
                success: function (data) {
                    $(".outer_div").html(data).fadeIn('slow');
                    $('#loader').html('');
                }
            })

        }
    </script> -->
    <!-- <script>
        function agregar(id) {
            var precio_compra = $('#precio_compra_' + id).val();
            var cantidad = $('#cantidad_' + id).val();
            if (isNaN(cantidad)) {
                alert('Esto no es un nro');
                document.getElementById('cantidad_' + id).focus();
                return false;
            }
            if (isNaN(precio_compra)) {
                alert('Esto no es un nro');
                document.getElementById('precio_compra_' + id).focus();
                return false;
            }
            //fin de la validación
            var parametros = { "id": id, "precio_compra_": precio_compra, "cantidad": cantidad };
            $.ajax({
                type: "POST",
                url: "../../ajax/agregar_pedido.php",
                data: parametros,
                beforeSend: function (objeto) {
                    $("#tablaDetalles").html("Mensaje: Cargando...");
                },
                success: function (datos) {
                    $("#tablaDetalles").html(datos);
                }
            });
        }   
    </script> -->
    <script>
        $(document).ready(function () {
            cargarTabla(idPedido); // Asegúrate de tener el valor correcto aquí
        });

        function cargarTabla(idPedido) {
            $.ajax({
                url: '../../ajax/cargarTabla.php',
                method: 'GET',
                data: { id_pedido: idPedido },
                success: function (response) {
                    // Actualiza la tabla con los detalles del pedido
                    $('#tablaDetalles').html(response);
                },
                error: function () {
                    console.error('Error al obtener los detalles del pedido.');
                }
            });
        }
        function eliminar(id) {
            $.ajax({
                type: "GET",
                url: "../../ajax/cargarTabla.php",
                data: "id=" + id,
                beforeSend: function (objeto) {
                    $("#tablaDetalles").html("Mensaje: Cargando...");
                },
                success: function (datos) {
                    $("#tablaDetalles").html(datos);
                }
            });
        }
    </script>

    <script>
        // Agrega un evento al hacer clic en el ID del pedido
        $('select[name="id_pedido_compra"]').on('change', function () {
            var idPedidoSeleccionado = $(this).val();
            cargarTabla(idPedidoSeleccionado);
        });
    </script>


    <!-- <div class="modal fade bs-example-modal-lg modal" id="myModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Buscar Productos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="x" placeholder="Buscar productos"
                                    onkeyup="load(1)">
                            </div>
                            <button type="button" class="btn btn-default" onclick="load(1)"><span
                                    class="fa fa-search"></span>Buscar</button>
                        </div>
                    </form>
                    <div id="loader"
                        style="position: absolute; text-align: center; top: 55px; width:100%; display:none;"></div>
                    <div class="outer_div"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div> -->

    <?php include "../../views/footer.php"; ?>