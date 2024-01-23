<?php include "../../views/header.php";
$url_form_compras = $url_base."/modules/compras/form.php";
    $url_proses =$url_base."/modules/compras/proses.php";
    $url_print =$url_base."/modules/compras/print.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #fff">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <li class="fa fa-folder icon-title" style="margin: 5px;"></li> Datos de Compra
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                            <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                        </a>
                        <a href="#" style="color: inherit; text-decoration: none;">
                            <li class="fas fa-angle-right" style="margin: 5px;"></li> Datos de Compra
                        </a>
                    </ol>
                </div><!-- /.col -->
            </div>
            <div class="text-right" style="margin-right: 20px">
                <a class="btn btn-info" href="<?php echo $url_form_compras; ?>?form=add" title="Agregar"
                    data-toggle="tool-tip" style="margin-top: 10px">
                    <i class="fa fa-plus"></i> Agregar
                </a>
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
                Compra realizada correctamente
                </div>";
                    } elseif ($_GET['alert'] == 2) {
                        echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Exitoso!</h4>
                Compra anulada correctamente
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
                        <div class="card-header">
                            <h3 class="card-title">Lista de Compras</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="center">Id</th>
                                        <th class="center">Proveedor</th>
                                        <th class="center">Deposito</th>
                                        <th class="center">N° Fact.</th>
                                        <th class="center">Fecha</th>
                                        <th class="center">Hora</th>
                                        <th class="center">Total</th>
                                        <th class="center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $nro = 1;
                                    $query = mysqli_query($mysqli, "SELECT * FROM v_compras WHERE estado='activo'")
                                        or die('Error' . mysqli_error($mysqli));

                                    while ($data = mysqli_fetch_assoc($query)) {
                                        $cod = $data['cod_compra'];
                                        $id_cliente = $data['razon_social'];
                                        $deposito = $data['descrip'];
                                        $nro_factura = $data['nro_factura'];
                                        $fecha = $data['fecha'];
                                        $hora = $data['hora'];
                                        $total_compra = $data['total_compra'];


                                        echo "<tr>
                               <td class='center'>$nro</td>
                               <td class='center'>$id_cliente</td>
                               <td class='center'> $deposito</td>
                               <td class='center'>$nro_factura</td>
                               <td class='center'>$fecha</td>
                               <td class='center'>$hora</td>
                               <td class='center'>$total_compra</td>                               
                               <td class='center' width='80'>
                               <div>"; ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Anular Compra"
                                            class="btn btn-danger btn-sm"
                                            href="<?php echo $url_proses?>?act=anular&cod_compra=<?php echo $data['cod_compra']; ?>"
                                            onclick="return confirm('Estás seguro/a de anular la factura <?php echo $data['nro_factura']; ?>?');">
                                            <i style="color:#000" class="fa fa-trash"></i>
                                        </a>

                                        <a data-toggle="tooltip" data-placement="top" title="Imprimir factura de compra"
                                            class="btn btn-warning btn-sm"
                                            href="<?php echo $url_print?>?act=imprimir&cod_compra=<?php echo $data['cod_compra']; ?>"
                                            target="_blank">
                                            <i style="color:#000" class="fa fa-print"></i>
                                        </a>
                                        <?php echo "</div>
                                </td>
                                </tr>" ?>
                                    <?php $nro++; }
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