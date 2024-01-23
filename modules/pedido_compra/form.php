<?php
include "../../views/header.php";
$url_pedido_compra_process = $url_base . "/modules/pedido_compra/proses.php";
$url_pedido_compra_view = $url_base . "/modules/pedido_compra/view.php";
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
                            <li class="fa fa-edit icon-title" style="margin: 5px;"></li> Agregar Pedido Compra
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                            </a>
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Pedido Compra
                            </a>
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Agregar Pedido Compra
                            </a>
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="row">
                <div class="col-md-11 mx-auto">
                    <div class="box box-primary">
                        <!-- general form elements -->
                        <div class="card card-info center">
                            <div class="card-header" style="background-color: #548CA8">
                                <h3 class="card-title">Agregar Pedido Compra</h3>
                            </div>
                            <form role="form" action="<?php echo $url_pedido_compra_process ?>?act=insert" method="POST">
                                <div class="box-body">
                                    <?php
                                    //Método para generar código
                                    $query_id = mysqli_query($mysqli, "SELECT MAX(id_pedido_compra) as id FROM pedido_compra")
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
                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                data-target="#myModal">
                                                <span class="fa fa-plus">Agregar Productos</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div id="resultados" class="col-md-9"></div>



                                    <div class="box-footer">
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

        </section>

    <?php } ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>

    <script>
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

    </script>


    <div class="modal fade bs-example-modal-lg modal" id="myModal" tabindex="-1" role="dialog"
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
    </div>

    <?php include "../../views/footer.php"; ?>