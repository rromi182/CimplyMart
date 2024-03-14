<?php include "../../views/header.php";
$url_form_ajuste = $url_base . "/modules/ajuste_stock/form.php";
$url_proses = $url_base . "/modules/ajuste_stock/proses.php";
$url_print = $url_base . "/modules/ajuste_stock/print.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #fff">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <li class="fas fa-box-open" style="margin: 5px;"></li> Ajuste de Stock
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
                    </ol>
                </div><!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if (empty($_GET['alert'])) {
                        echo "";
                    } elseif ($_GET['alert'] == 1) {
                        echo "<div class='alert alert-success alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Exitoso!</h4>
                Stock actualizado correctamente
                </div>";
                    } elseif ($_GET['alert'] == 2) {
                        echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Exitoso!</h4>
                Stock actualizado correctamente
                </div>";
                    } elseif ($_GET['alert'] == 3) {
                        echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Error!</h4>
                No hay stock suficiente para realizar la accion
                </div>";
                    } elseif ($_GET['alert'] == 4) {
                        echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Exitoso!</h4>
                Ajuste anulado correctamente
                </div>";
                    }
                    ?>
                    <div class="card">


                        <?php
                        if (!empty($_POST['cod_deposito'])) {
                            $cod_deposito = $_POST['cod_deposito'];
                        } else {
                            $cod_deposito = 1;
                        }
                        $query = mysqli_query($mysqli, "SELECT * FROM v_stock WHERE cod_deposito = $cod_deposito")
                            or die('Error' . mysqli_error($mysqli));
                        while ($data = mysqli_fetch_assoc($query)) {
                            $deposito = $data['descrip'];
                        }
                        ?>
                        <!--Buscar por Codigo de Deposito-->
                        <div class="card-header">
                            <h3 class="card-title">Ajuste de Stock:
                                <?php echo $deposito ?>
                            </h3>
                        </div>

                        <div class="form-group row col-sm-12">

                            <form role="form" method="post">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"
                                        style="margin-left: 20px; margin-top: 10px;">Buscar por Depósito</label>
                                    <div class="col-sm-5">
                                        <select class="form-control" name="cod_deposito" style="margin-top: 10px;"
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
                                    <div class="col-sm-3" style="margin-top: 10px">
                                        <button type="submit" class="btn btn-default"><span
                                                class="fa fa-search"></span>Buscar</button>
                                    </div>

                                </div>
                            </form>
                            <!--Reporte por Codigo de Deposito-->
                            <form role="form" method="post">
                                <!-- ... (Código existente) ... -->
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"
                                        style="margin-left: 20px; margin-top: 10px;">Reporte por Deposito</label>
                                    <div class="col-sm-5">
                                        <select class="form-control" name="cod_deposito" style="margin-top: 10px;"
                                            data-placeholder="-- Seleccionar  Depósito --" autocomplete="off" required>
                                            <option value="all">Todos los Depósitos</option>
                                            <?php
                                            $query_dep = mysqli_query($mysqli, "SELECT cod_deposito, descrip FROM deposito ORDER BY cod_deposito ASC") or die('Error' . mysqli_error($mysqli));
                                            while ($data_dep = mysqli_fetch_assoc($query_dep)) {
                                                echo "<option value=\"$data_dep[cod_deposito]\">$data_dep[cod_deposito] | $data_dep[descrip]</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <a data-toggle="tooltip" data-placement="top" title="Imprimir Reporte de Stock"
                                        class="btn btn-warning"
                                        style="height: 40px; padding-top: 10px; padding-bottom: 3px; line-height: 15px; margin-top:10px"
                                        href="<?php echo $url_print ?>?act=imprimir&cod_deposito="
                                        onclick="updateCodDeposito()" target="_blank">
                                        <i style="color:#000" class="fa fa-print"></i>Imprimir
                                    </a>
                                </div>
                            </form>
                            <label class="col-sm-2 col-form-label" style="margin-top: 10px;">Realizar Ajuste: </label>
                            <a data-toggle='tooltip' data-placement='top' title='Agregar Producto'
                                class='btn btn-success btn-sm'
                                style="height: 40px; padding-top: 10px; padding-bottom: 3px; line-height: 15px; margin-top:10px; margin-right:10px"
                                href='<?php echo $url_form_ajuste ?>?form=agregar'>
                                <i class='fa fa-plus' style='color:#fff'></i>
                            </a>
                            <a data-toggle='tooltip' data-placement='top' title='Restar Producto'
                                style="height: 40px; padding-top: 10px; padding-bottom: 3px; line-height: 15px; margin-top:10px; margin-left:10px"
                                class='btn btn-danger btn-sm' href='<?php echo $url_form_ajuste ?>?form=restar'>
                                <i class='fa fa-minus' style='color:#fff'></i>
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="center" style="width: 50px;">Cod. Ajuste</th>
                                        <th class="center" style="width: 50px;">Cod. Depósito</th>
                                        <th class="center" style="width: 50px;">Depósito</th>
                                        <th class="center">Tip. Prod.</th>
                                        <th class="center">Producto</th>
                                        <th class="center">U. Medida</th>
                                        <th class="center">Usuario</th>
                                        <th class="center" style="width: 80px;">Fecha</th>
                                        <th class="center" style="width: 120px;">Motivo Ajuste</th>
                                        <th class="center" style="width: 50px;">Cantidad Actual</th>
                                        <th class="center" style="width: 50px;">Cantidad Ajuste</th>
                                        <th class="center" style="width: 50px;">Estado</th>
                                        <th class="center" style="width: 50px;">Acciones</th>
                                        <!-- Additional columns -->

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //Mostrar cantidad actual en el stock
                                    $query = mysqli_query($mysqli, "SELECT * FROM v_stock WHERE cod_deposito = $cod_deposito ")
                                        or die('Error' . mysqli_error($mysqli));

                                    while ($data = mysqli_fetch_assoc($query)) {
                                        $cod_depo = $data['cod_deposito'];
                                        $deposito = $data['descrip'];
                                        $t_p_descrip = $data['t_p_descrip'];
                                        $producto = $data['p_descrip'];
                                        $u_medida = $data['u_descrip'];
                                        $cantidad_actual = $data['cantidad'];

                                        $ajuste_stock = mysqli_query($mysqli, "SELECT * FROM v_ajuste_stock 
                                       WHERE cod_producto = {$data['cod_producto']} 
                                       AND cod_deposito = $cod_deposito 
                                       AND estado IN ('activo', 'anulado')
                                       ORDER BY fecha DESC")
                                            or die('Error' . mysqli_error($mysqli));

                                        //Mostrar los detalles del ajuste de stock
                                        while ($ajuste_data = mysqli_fetch_assoc($ajuste_stock)) {
                                            $id_ajuste = $ajuste_data['id_ajuste_stock'];
                                            $usuario = $ajuste_data['username'];
                                            $fecha = $ajuste_data['fecha'];
                                            $motivo = $ajuste_data['motivo'];
                                            $cantidad_ajuste = $ajuste_data['cantidad'];
                                            $estado = $ajuste_data['estado'];

                                            // Estilo para cambiar el color de la cantidad
                                            $cantidad_estilo = ($cantidad_ajuste < 0) ? 'color: red; font-weight: bold;' : 'color: green; font-weight: bold;';
                                            echo "<tr>
                                                    <td class='center'>$id_ajuste</td>
                                                    <td class='center'>$cod_depo</td>
                                                    <td class='center'>$deposito</td>
                                                    <td class='center'>$t_p_descrip</td>
                                                    <td class='center'>$producto</td>
                                                    <td class='center'>$u_medida</td>  
                                                    <td class='center'>$usuario</td>
                                                    <td class='center'>$fecha</td>
                                                    <td class='center'>$motivo</td>
                                                    <td class='center'>$cantidad_actual</td>
                                                    <td class='center'style='$cantidad_estilo'>$cantidad_ajuste</td> 
                                                    <td class='center'>$estado</td>                           
                                                    <td class='center' width='50'>
                               <div>"; ?>
                                            <a data-toggle="tooltip" data-placement="top" title="Anular Ajuste"
                                                class="btn btn-danger btn-sm"
                                                href="<?php echo $url_proses ?>?act=anular&id_ajuste_stock=<?php echo $ajuste_data['id_ajuste_stock']; ?>"
                                                onclick="return confirm('Estás seguro/a de anular el ajuste <?php echo $ajuste_data['id_ajuste_stock']; ?>?');">
                                                <i style="color:#000" class="fa fa-trash"></i>
                                            </a>
                                            <?php echo "</div>
                                </td>
                                                        
                                                    
                                                </tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        // JavaScript para actualizar el valor de $cod_deposito antes de hacer clic en el enlace de impresión
        function updateCodDeposito() {
            var selectedDeposito = document.getElementsByName("cod_deposito")[1].value;
            var printLink = document.querySelector(".btn.btn-warning");

            if (selectedDeposito === "all") {
                printLink.href = "<?php echo $url_print ?>?act=imprimir&cod_deposito=all";
            } else {
                printLink.href = "<?php echo $url_print ?>?act=imprimir&cod_deposito=" + selectedDeposito;
            }
        }
    </script>

    <?php include "../../views/footer.php"; ?>