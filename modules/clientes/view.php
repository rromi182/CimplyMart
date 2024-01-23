<?php
include "../../views/header.php";
$url_client_process = $url_base . "/modules/clientes/process.php";
$url_client_print = $url_base . "/modules/clientes/print.php";
$url_client_form = $url_base . "/modules/clientes/form.php";
?>
<?php if ($_SESSION['permisos_acceso'] == 'Super Admin') { ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #fff">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <li class="fa fa-user icon-title" style="margin: 5px;"></li> Datos de Clientes
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                            </a>
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Clientes
                            </a>
                        </ol>
                    </div><!-- /.col -->
                </div>
                <div class="text-right" style="margin-right: 20px">
                    <a class="btn btn-warning pull-left" href="<?php echo $url_client_print ?>" title="Imprimir Reporte"
                        data-toggle="tool-tip" style="margin-top: 10px; margin-right: 10px" target="_blank">
                        <i class="fa fa-print"></i> Imprimir Reporte
                    </a>
                    <a class="btn btn-info" href="<?php echo $url_client_form ?>?form=add" title="Agregar"
                        data-toggle="tool-tip" style="margin-top: 10px">
                        <i class="fa fa-plus"></i> Agregar
                    </a>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if (empty($_GET['alert'])) {
                        echo "";
                    } elseif ($_GET['alert'] == 1) {
                        echo "<div class='alert alert-success alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Exitoso!</h4>
                Datos registrados correctamente
                </div>";
                    } elseif ($_GET['alert'] == 2) {
                        echo "<div class='alert alert-success alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Exitoso!</h4>
                Datos Modificados correctamente
                </div>";
                    } elseif ($_GET['alert'] == 3) {
                        echo "<div class='alert alert-success alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Exitoso!</h4>
                Datos Eliminados correctamente
                </div>";
                    } elseif ($_GET['alert'] == 4) {
                        echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Error!</h4>
                No se pudo realizar la operación
                </div>";
                    }
                    ?>

                    <!--Tabla de Clientes-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tabla de usuarios</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="center">Id</th>
                                        <th class="center">Ruc</th>
                                        <th class="center">Dpto.</th>
                                        <th class="center">Ciudad</th>
                                        <th class="center">Nombre</th>
                                        <th class="center">Apellido</th>
                                        <th class="center">Teléfono</th>
                                        <th class="center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $nro = 1;
                                    $query = mysqli_query($mysqli, "SELECT * FROM v_clientes")
                                        or die('Error' . mysqli_error($mysqli));

                                    while ($data = mysqli_fetch_assoc($query)) {
                                        $id_cliente = $data['id_cliente'];
                                        $ci_ruc = $data['ci_ruc'];
                                        $cli_nombre = $data['cli_nombre'];
                                        $cli_apellido = $data['cli_apellido'];
                                        $cli_telefono = $data['cli_telefono'];
                                        $dep_descripcion = $data['dep_descripcion'];
                                        $descrip_ciudad = $data['descrip_ciudad'];

                                        echo "<tr>
                               <td class='center'>$id_cliente</td>
                               <td class='center'>$ci_ruc</td>
                               <td class='center'>$dep_descripcion</td>
                               <td class='center'>$descrip_ciudad</td>
                               <td class='center'>$cli_nombre</td>
                               <td class='center'>$cli_apellido</td>
                               <td class='center'>$cli_telefono</td>                               
                               <td class='center' width='80'>
                               <div>
                               <a data-toggle='tooltip' data-placement='top' title='Modificar datos de Clientes' style='margin-right:5px' 
                               class='btn btn-primary btn-sm' href='$url_client_form?form=edit&id=$data[id_cliente]'>
                                    <i class='fa fa-edit' style='color:#fff'></i> </a>";
                                        ?>
                                        <a data-toggle="tooltip" data-data-placement="top" title="Eliminar datos"
                                            class="btn btn-danger btn-sm"
                                            href="<?php echo $url_client_process ?>?act=delete&id_cliente=<?php echo $data['id_cliente']; ?>"
                                            onclick="return confirm('¿Estás seguro/a de eliminar <?php echo $data['cli_nombre']; ?>?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <?php
                                        echo "</div>
                                </td>
                                </tr>" ?>
                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
        </section>
    <?php } ?>
    <?php
    include "../../views/footer.php"; ?>