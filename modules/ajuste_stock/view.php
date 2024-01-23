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
                            <li class="fas fa-angle-right" style="margin: 5px;"></li> Stock de Productos
                        </a>
                    </ol>
                </div><!-- /.col -->
            </div>
            <div class="text-right" style="margin-right: 20px">
                <!-- <a class="btn btn-info" href="<?php echo $url_form_compras; ?>?form=add" title="Agregar"
                    data-toggle="tool-tip" style="margin-top: 10px">
                    <i class="fa fa-plus"></i> Agregar
                </a> -->
            </div><!-- /.row -->
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
                    } elseif ($_GET['alert'] == 3) {
                        echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Error!</h4>
                No se pudo realizar la acción
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
                                $deposito = $data['descrip'];}
                        ?>

                        <div class="card-header">
                            <h3 class="card-title">Stock de Productos: <?php echo $deposito?></h3>
                        </div>
                        <form role="form" method="post">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                    style="margin-left: 20px; margin-top: 10px;">Buscar por Depósito</label>
                                <div class="col-sm-3">
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

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="center">Cod.Depósito</th>
                                        <th class="center">Depósito</th>
                                        <th class="center">Tip. Prod.</th>
                                        <th class="center">Producto</th>
                                        <th class="center">U. Medida</th>
                                        <th class="center">Cantidad</th>
                                        <th class="center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($mysqli, "SELECT * FROM v_stock where cod_deposito = $cod_deposito ")
                                        or die('Error' . mysqli_error($mysqli));

                                    while ($data = mysqli_fetch_assoc($query)) {
                                        $cod_pro = $data['cod_producto'];
                                        $cod_depo = $data['cod_deposito'];
                                        $deposito = $data['descrip'];
                                        $t_p_descrip = $data['t_p_descrip'];
                                        $producto = $data['p_descrip'];
                                        $u_medida = $data['u_descrip'];
                                        $cantidad = $data['cantidad'];


                                        echo "<tr>
                               <td class='center'> $cod_depo</td>
                               <td class='center'> $deposito</td>
                               <td class='center'>$t_p_descrip</td>
                               <td class='center'>$producto</td>
                               <td class='center'>$u_medida</td>  
                               <td class='center'>$cantidad</td>                              
                               <td class='center' width='80'>
                               <div>"; ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Imprimir Reporte de Stock"
                                            class="btn btn-warning btn-sm"
                                            href="<?php echo $url_print ?>?act=imprimir&cod_producto=<?php echo $data['cod_producto']; ?>"
                                            target="_blank">
                                            <i style="color:#000" class="fa fa-print"></i>
                                        </a>
                                        <a data-toggle='tooltip' data-placement='top' title='Ajustar Stock'
                                            class='btn btn-primary btn-sm'
                                            href='<?php echo $url_form_ajuste?>?form=edit&id=$data[cod_producto]'><i class='fas fa-edit'></i>
                                        </a>
                            </div>
                            </td>
                            <?php echo "</div>
                                </td>
                                </tr>" ?>
                        <?php }
                                    ?>
                        </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
</div>
</section>
<?php include "../../views/footer.php"; ?>