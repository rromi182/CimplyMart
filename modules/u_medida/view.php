<?php
include "../../views/header.php";
$url_depart_process = $url_base . "/modules/u_medida/proses.php";
$url_dep_print = $url_base."/modules/u_medida/print.php";
$url_depart_form = $url_base . "/modules/u_medida/form.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color: #fff">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <li class="fa fa-ruler icon-title" style="margin: 5px;"></li> Unidad de Medida
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                            <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                        </a>
                        <a href="#" style="color: inherit; text-decoration: none;">
                            <li class="fas fa-angle-right" style="margin: 5px;"></li> Unidad de Medida
                        </a>
                    </ol>
                </div><!-- /.col -->
            </div>
            <div class="text-right" style="margin-right: 20px">
            <a class="btn btn-warning pull-left" href="<?php echo $url_dep_print ?>?act=imprimir" title="Imprimir Reporte"
                    data-toggle="tool-tip" style="margin-top: 10px; margin-right: 10px" target="_blank">
                    <i class="fa fa-print"></i> Imprimir Reporte
                </a>
                <a class="btn btn-info" href="<?php echo $url_depart_form ?>?form=add" title="Agregar"
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
                    echo "<div class='alert alert-danger alert-dismissable'>
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
                }elseif ($_GET['alert'] == 5) {
                    echo "<div class='alert alert-danger alert-dismissable'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4>  <i class='icon fa fa-check-circle'></i> Error!</h4>
                La Unidad de Medida ya existe, intente de nuevo.
                </div>";
                }
                ?>

                <div class="box box-primary">
                    <div class="box-body">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Lista de Unidades de Medida</h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Descripción</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $nro = 1;
                                        $query = mysqli_query($mysqli, "SELECT * FROM u_medida")
                                            or die('Error' . mysqli_error($mysqli));
                                        while ($data = mysqli_fetch_assoc($query)) {
                                            $cod_deposito = $data['id_u_medida'];
                                            $descripcion = $data['u_descrip'];

                                            echo "<tr>
                               <td class='center'>$cod_deposito</td>
                               <td class='center'>$descripcion</td>
                               <td class='center' width='80'>
                               <div>
                               <a data-toggle='tooltip' data-placement='top' title='Modificar datos' style='margin-right:5px' 
                               class='btn btn-primary btn-sm' href='$url_depart_form?form=edit&id=$data[id_u_medida]'>
                                    <i class='fa fa-edit' style='color:#fff'></i> </a>";
                                            ?>
                                            <a data-toggle="tooltip" data-data-placement="top" title="Eliminar datos"
                                                class="btn btn-danger btn-sm"
                                                href="<?php echo $url_depart_process?>?act=delete&id_u_medida=<?php echo $data['id_u_medida']; ?>"
                                                onclick="return confirm('¿Estás seguro/a de eliminar <?php echo $data['u_descrip']; ?>?')" style="margin-right:5px">
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
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php
    include "../../views/footer.php"; ?>