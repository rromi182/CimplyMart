<?php include "../../views/header.php";
$url_form_pcompra = $url_base."/modules/pedido_compra/form.php";
    $url_proses =$url_base."/modules/pedido_compra/proses.php";
    $url_print =$url_base."/modules/pedido_compra/print.php";
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #fff">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <li class="fa fa-folder icon-title" style="margin: 5px;"></li> Pedidos de Compras
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                            <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                        </a>
                        <a href="#" style="color: inherit; text-decoration: none;">
                            <li class="fas fa-angle-right" style="margin: 5px;"></li> Pedidos de Compras
                        </a>
                    </ol>
                </div><!-- /.col -->
            </div>
            <div class="text-right" style="margin-right: 20px">
                <a class="btn btn-info" href="<?php echo $url_form_pcompra; ?>?form=add" title="Agregar"
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
                Pedido realizado correctamente
                </div>";
                    } elseif ($_GET['alert'] == 2) {
                        echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Exitoso!</h4>
                Pedido anulado correctamente
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
                            <h3 class="card-title">Lista de Pedidos de Compra</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="center">Id Pedido</th>
                                        <th class="center">Usuario</th>
                                        <th class="center">Fecha Pedido</th>
                                        <th class="center">Hora</th>
                                        <th class="center">Estado</th>
                                        <th class="center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $nro = 1;
                                    $query = mysqli_query($mysqli, "SELECT * FROM v_pedido_compra WHERE estado IN ('pendiente', 'revisado', 'procesado');")
                                        or die('Error' . mysqli_error($mysqli));

                                    while ($data = mysqli_fetch_assoc($query)) {
                                        $cod = $data['id_pedido_compra'];
                                        $usuario = $data['username'];
                                        $fecha_registro = $data['fecha_registro'];
                                        $hora = $data['hora'];
                                        $estado = $data['estado'];

                                        echo "<tr>
                               <td class='center'>$cod</td>
                               <td class='center'>$usuario</td>
                               <td class='center'>$fecha_registro</td>
                               <td class='center'>$hora</td>
                               <td class='center'>$estado</td>                                 
                               <td class='center' width='80'>
                               <div>"; ?>
                                        <a data-toggle="tooltip" data-placement="top" title="Anular Pedido"
                                            class="btn btn-danger btn-sm"
                                            href="<?php echo $url_proses?>?act=anular&id_pedido_compra=<?php echo $data['id_pedido_compra']; ?>"
                                            onclick="return confirm('Estás seguro/a de anular el pedido <?php echo $data['id_pedido_compra']; ?>?');">
                                            <i style="color:#000" class="fa fa-trash"></i>
                                        </a>

                                        <a data-toggle="tooltip" data-placement="top" title="Imprimir Informe del Pedido"
                                            class="btn btn-warning btn-sm"
                                            href="<?php echo $url_print?>?act=imprimir&id_pedido_compra=<?php echo $data['id_pedido_compra']; ?>"
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