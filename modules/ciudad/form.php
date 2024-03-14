<?php
include "../../views/header.php";
$url_ciu_process = $url_base . "/modules/ciudad/proses.php";
$url_ciudad = $url_base . "/modules/ciudad/view.php"; ?>
<?php
if ($_GET['form'] == 'add') { ?>
    <div class="content-wrapper" style="background-color: #fff">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <li class="fa fa-city icon-title" style="margin: 5px;"></li> Agregar Ciudad
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                            </a>
                            <a href="<?php echo $url_ciudad ?>" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li>Ciudades
                            </a>
                            <a href="#" style="color: inherit; text-decoration: none;">
                                <li class="fas fa-angle-right" style="margin: 5px;"></li> Agregar Ciudad
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
                                <h3 class="card-title">Agregar Ciudad</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" class="form-horizontal" action="<?php echo $url_ciu_process ?>?act=insert"
                                method="POST">
                                <div class="box-body">
                                    <?php
                                    //Método para generar código
                                    $query_id = mysqli_query($mysqli, "SELECT MAX(cod_ciudad) as id FROM ciudad")
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
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="codigo"
                                                value="<?php echo $codigo; ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- Combo para seleccionar un departamento-->
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Departamento</label>
                                        <div class="col-sm-3">
                                            <select name="departamento" class="form-control" required>
                                                <option value="">Seleccionar Departamento</option>
                                                <?php
                                                $query_prov = mysqli_query($mysqli, "SELECT *
                                               FROM departamento
                                               ORDER BY id_departamento ASC") or die('Error' . mysqli_error($mysqli));
                                                while ($data_prov = mysqli_fetch_assoc($query_prov)) {
                                                    echo "<option value=\"$data_prov[id_departamento]\">$data_prov[id_departamento] | $data_prov[dep_descripcion]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Descripción</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="descrip_ciudad"
                                                placeholder="Ingresa una ciudad" required>
                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="submit" class="btn btn-primary btn-submit" name="Guardar"
                                                    value="Guardar">
                                                <a href="<?php echo $url_ciudad ?>"
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
        $query = mysqli_query($mysqli, "SELECT ciu.cod_ciudad, ciu.descrip_ciudad,
                                               dep.id_departamento, dep.dep_descripcion
                                        FROM ciudad ciu
                                        JOIN departamento dep ON ciu.id_departamento = dep.id_departamento
                                        WHERE cod_ciudad = '$_GET[id]'")
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
                                <li class="fa fa-city icon-title" style="margin: 5px;"></li> Editar Ciudad
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                                    <li class="fa fa-home" style="margin: 5px;"></li> Inicio
                                </a>
                                <a href="<?php echo $url_ciudad ?>" style="color: inherit; text-decoration: none;">
                                    <li class="fas fa-angle-right" style="margin: 5px;"></li> Ciudades
                                </a>
                                <a href="#" style="color: inherit; text-decoration: none;">
                                    <li class="fas fa-angle-right" style="margin: 5px;"></li> Editar Ciudad
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
                                    <h3 class="card-title">Editar Ciudad</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" class="form-horizontal" action="<?php echo $url_ciu_process ?>?act=update"
                                    method="POST">
                                    <div class="box-body">

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Código</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="codigo"
                                                    value="<?php echo $data['cod_ciudad']; ?>" readonly>
                                            </div>
                                        </div>

                                        <!-- Combo para seleccionar un departamento-->
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Departamento</label>
                                            <div class="col-sm-5">
                                                <select name="departamento" class="form-control">
                                                    <option value="<?php echo $data['id_departamento'] ?>">
                                                        <?php echo $data['dep_descripcion'] ?>
                                                    </option>
                                                    <?php
                                                    $query_prov = mysqli_query($mysqli, "SELECT *
                                               FROM departamento
                                               ORDER BY id_departamento ASC") or die('Error' . mysqli_error($mysqli));
                                                    while ($data_prov = mysqli_fetch_assoc($query_prov)) {
                                                        echo "<option value=\"$data_prov[id_departamento]\">$data_prov[id_departamento] | $data_prov[dep_descripcion]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Descripción</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="descrip_ciudad"
                                                    value="<?php echo $data['descrip_ciudad']; ?>" required>
                                            </div>
                                        </div>


                                        <div class="box-footer">
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <input type="submit" class="btn btn-primary btn-submit" name="Guardar"
                                                        value="Guardar">
                                                    <a href="<?php echo $url_ciudad ?>"
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
