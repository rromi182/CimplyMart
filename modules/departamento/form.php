<?php
include "../../views/header.php";
$url_depart_process = $url_base . "/modules/departamento/proses.php";
$url_depart = $url_base . "/modules/departamento/view.php"; ?>
<?php
if ($_GET['form'] == 'add') { ?>
    <div class="content-wrapper" style="background-color: #fff">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <li class="fa fa-user icon-title" style="margin: 5px;"></li> Agregar Departamento
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                            </a>
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Departamento
                            </a>
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Agregar Departamento
                            </a>
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12 mx-auto" style="margin-top: 20px">
                        <!-- general form elements -->
                        <div class="card card-info center">
                            <div class="card-header" style="background-color: #548CA8">
                                <h3 class="card-title">Agregar Departamento</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" class="form-horizontal" action="<?php echo $url_depart_process ?>?act=insert"
                                method="POST">
                                <div class="box-body">
                                    <?php
                                    //Método para generar código
                                    $query_id = mysqli_query($mysqli, "SELECT MAX(id_departamento) as id FROM departamento")
                                        or die('Error' . mysqli_error($mysqli));

                                    $count = mysqli_num_rows($query_id);
                                    if ($count <> 0) {
                                        $data_id = mysqli_fetch_assoc($query_id);
                                        $codigo = $data_id['id'] + 1;
                                    } else {
                                        $codigo = 1;
                                    }
                                    ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Código</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="codigo"
                                                value="<?php echo $codigo; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Descripción</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="dep_descripcion"
                                                pleaceholder="Ingresa un departamento" required>
                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="submit" class="btn btn-primary btn-submit" name="Guardar"
                                                    value="Guardar">
                                                <a href="<?php echo $url_depart ?>"
                                                    class="btn btn-default btn-reset">Cancelar</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>

    <?php } elseif ($_GET['form'] == 'edit') {
    if (isset($_GET['id'])) {
        $query = mysqli_query($mysqli, "SELECT * FROM departamento WHERE id_departamento = '$_GET[id]'")
            or die('Error' . mysqli_error($mysqli));
        $data = mysqli_fetch_assoc($query);
    } ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: #fff">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">
                                <li class="fa fa-user icon-title" style="margin: 5px;"></li> Editar Departamento
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                    <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                                </a>
                                <a href="#" style="color: inherit; text-decoration: none;">
                                    <li class="fas fa-angle-right" style="margin: 5px;"></li> Departamentos
                                </a>
                                <a href="#" style="color: inherit; text-decoration: none;">
                                    <li class="fas fa-angle-right" style="margin: 5px;"></li> Editar Departamento
                                </a>
                            </ol>
                        </div><!-- /.col -->
                    </div>
                </div><!-- /.container-fluid -->
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-10 mx-auto" style="margin-top: 20px">
                            <!-- general form elements -->
                            <div class="card card-info center">
                                <div class="card-header" style="background-color: #548CA8">
                                    <h3 class="card-title">Editar Departamento</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" class="form-horizontal"
                                    action="<?php echo $url_depart_process?>?act=update" method="POST">
                                    <div class="box-body">

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Código</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="codigo"
                                                    value="<?php echo $data['id_departamento']; ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Descripción</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="dep_descripcion"
                                                    value="<?php echo $data['dep_descripcion']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="box-footer">
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <input type="submit" class="btn btn-primary btn-submit" name="Guardar"
                                                        value="Guardar">
                                                        <a href="<?php echo $url_depart ?>"
                                                    class="btn btn-default btn-reset">Cancelar</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </section>
        </div>

    <?php }

?>
    <?php
    include "../../views/footer.php"; ?>