<?php
include "../../views/header.php";
$url_ajuste_stock_process = $url_base . "/modules/ajuste_stock/proses.php";
$url_pedido_compra_view = $url_base . "/modules/ajuste_stock/view.php";
?>

<?php
$cod_producto = '';
if (isset($_GET['form']) && $_GET['form'] == 'edit') {
    if (isset($_GET['id'])) {
        $query = mysqli_query($mysqli, "SELECT * FROM v_stock WHERE cod_producto = '$_GET[id]'")
            or die('Error' . mysqli_error($mysqli));
        if ($query && mysqli_num_rows($query) > 0) {
            // Obtener la fila como un array asociativo
            $data = mysqli_fetch_assoc($query);
            $cod_producto = $data['cod_producto'];
        } else {

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
                                <li class="fa fa-edit icon-title" style="margin: 5px;"></li> Agregar Ajuste de Stock
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                    <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                                </a>
                                <a href="#" style="color: inherit; text-decoration: none;">
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
                                    <h3 class="card-title">Agregar Ajuste de Stock</h3>
                                </div>
                                <form role="form" action="<?php echo $url_ajuste_stock_process ?>?act=edit" method="POST">
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
                                                style="margin-left: 28px; margin-top:15px;">Código</label>
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
                                        <br>
                                        <hr>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label class="col-sm-2 control-label">Productos</label>
                                            </div>
                                        </div>
                                        <div>
                                            <table class="table table-bordered table-striped table-hover">
                                                <tr class="bg-warning">
                                                    <th>Código</th>
                                                    <th>Tipo de Produ.</th>
                                                    <th>Unid. de medida</th>
                                                    <th>Producto</th>
                                                    <th><span class="pull-right">Cantidad</span></th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?php echo $cod_producto ?>
                                                        <input type="text" class="form-control" name="codigo_producto"
                                                            value="<?php echo $data['cod_producto']; ?>">
                                                    </td>
                                                    <td>
                                                        <?php echo $data['t_p_descrip']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['u_descrip']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['p_descrip']; ?>
                                                    </td>
                                                    <td class="col-xs-1">
                                                        <span class="pull-right">
                                                            <input type="text" class="form-control editable cantidad"
                                                                name="cantidad" id="cantidad_<?php echo $cod_producto; ?>"
                                                                value="<?php echo $data['cantidad']; ?>">
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
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

        <?php echo "Debug: No product found for ID: " . $_GET['id'];
    }
} else {
    echo "No se puedo encontrar los valores";
} ?>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
    integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script> -->

<!-- <script>
    $(document).ready(function () {
        load(1);
    });

    function load(page) {
        var x = $("#x").val();
        var parametros = { "action": "ajax", "page": page, "x": x };
        $("#loader").fadeIn('slow');
        $.ajax({
            url: '../../ajax/productos_pedidoCompra.php',
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
</script>
<script>
    function agregar(id) {
        var cantidad = $('#cantidad_' + id).val();

        if (isNaN(cantidad)) {
            alert('Esto no es un número');
            document.getElementById('cantidad_' + id).focus();
            return false;
        }

        var productos = [];
        productos.push({ id: id, cantidad: cantidad });

        var parametros = { "productos": productos };

        $.ajax({
            type: "POST",
            url: "../../ajax/agregar_pedidoCompra.php",
            data: parametros,
            beforeSend: function (objeto) {
                $("#resultados").html("Mensaje: Cargando...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
            }
        });
    }
    function eliminar(id) {
        $.ajax({
            type: "GET",
            url: "../../ajax/agregar_pedidoCompra.php",
            data: "id=" + id,
            beforeSend: function (objeto) {
                $("#resultados").html("Mensaje: Cargando...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
            }
        });
    }

</script> -->


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
                <div id="loader" style="position: absolute; text-align: center; top: 55px; width:100%; display:none;">
                </div>
                <div class="outer_div"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div> -->

<?php include "../../views/footer.php"; ?>