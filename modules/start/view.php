<?php

include "../../views/header.php"; 

$url_inicio = $url_base."/modules/start/view.php";

$url_compras = $url_base.'/modules/compras/view.php';
$url_ventas = $url_base."/modules/ventas/view.php";
$url_stock = $url_base."/modules/stock/view.php";?>


<?php if ($_SESSION['permisos_acceso'] == 'Super Admin') { ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color: #fff">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">
              <li class="fa fa-home icon-title"></li> Inicio
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                <li class="fa fa-home"></li>
              </a>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!--Bienvenida-->
    <section class="content">
      <div class="row ">
        <div class="col-lg-12 col-xs-12">
          <div class="alert alert alert-dismissable" style="opacity: 0.9; background-color: #d9edf2; color: #476072;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p style="font-size: 18px;">
              <i class="icon fa fa-user"></i> Bienvenido/a <strong>
                <?php echo $_SESSION['name_user'] ?>
              </strong>
              al sistema: <strong>CimplyMart</strong>
            </p>
          </div>
        </div>
      </div>
    </section>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 class="m-0">
              <i class="fa-solid fa-file-pen"></i> Formularios de Movimientos
            </h3>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- BOX-COMPRAS -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>Compras</h3>
                <p>Registrar compra de productos</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php  echo $url_compras?>" class="small-box-footer" title="Registrar Compras">Ir <i
                  class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- BOX-VENTAS -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>Ventas</h3>
                <p>Regristrar venta de productos</p>
              </div>
              <div class="icon">
                <i class="fa fa-cart-plus"></i>
              </div>
              <a href="<?php echo $url_ventas?>" class="small-box-footer" tittle="Registrar Ventas">Ir <i
                  class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- BOX-STOCK -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>Stock</h3>
                <p>Ver stock de productos</p>
              </div>
              <div class="icon">
                <i class="fas fa-box-open"></i>
              </div>
              <a href="<?php echo $url_stock?>" class="small-box-footer">Ir <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- BOX-PEDIDOS -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>Pedidos</h3>
                <p>Regristrar pedidos de compras</p>
              </div>
              <div class="icon">
              <i><img src="<?php echo $url_base ?>/images/entrega-de-pedidos.png"
                    style="margin-bottom: 80px; opacity: 0.5" height="60" width="60"></i>
              </div>
              <a href="<?php echo $url_pedido_compra ?>" class="small-box-footer" tittle="Registrar Ventas">Ir <i
                  class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- BOX-PRESUPUESTO -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3>Presupuesto</h3>
                <p>Regristrar presupuesto de compra</p>
              </div>
              <div class="icon">
              <i><img src="<?php echo $url_base ?>/images/presupuesto.png"
                    style="margin-bottom: 80px; opacity: 0.5" height="70" width="70"></i>
              </div>
              <a href="<?php echo $url_presupuesto_compra ?>" class="small-box-footer" tittle="Registrar Ventas">Ir <i
                  class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- BOX-PRESUPUESTO -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>Orden</h3>
                <p>Regristrar orden de compra</p>
              </div>
              <div class="icon">
              <i><img src="<?php echo $url_base ?>/images/orden.png"
                    style="margin-bottom: 80px; opacity: 0.5" height="70" width="70"></i>
              </div>
              <a href="<?php echo $url_orden_compra ?>" class="small-box-footer" tittle="Registrar Ventas">Ir <i
                  class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- BOX-PRESUPUESTO -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>Ajuste de Stock</h3>
                <p>Regristrar ajuste de stock</p>
              </div>
              <div class="icon">
              <i class="fas fa-box-open"></i>
              </div>
              <a href="<?php echo $url_ajuste_stock ?>" class="small-box-footer" tittle="Registrar Ventas">Ir <i
                  class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
        </div>
        <!-- /.row -->

      </div>
      <!-- /.card -->
    </section>
    <!--PERFIL COMPRAS-->
  <?php } elseif (($_SESSION['permisos_acceso'] == 'Compras')) { ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #fff">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">
                <li class="fa fa-home icon-title"></li> Inicio
              </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                  <li class="fa fa-home"></li>
                </a>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!--Bienvenida-->
      <section class="content">
        <div class="row ">
          <div class="col-lg-12 col-xs-12">
            <div class="alert alert alert-dismissable" style="opacity: 0.9; background-color: #d9edf2; color: #476072;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <p style="font-size: 18px;">
                <i class="icon fa fa-user"></i> Bienvenido/a <strong>
                  <?php echo $_SESSION['name_user'] ?>
                </strong>
                al sistema: <strong>CimplyMart</strong>
              </p>
            </div>
          </div>
        </div>
      </section>
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h3 class="m-0">
                <i class="fa-solid fa-file-pen"></i> Formularios de Movimientos
              </h3>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- BOX-COMPRAS -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>Compras</h3>
                  <p>Registrar compra de productos</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="<?php  echo $url_compras?>" class="small-box-footer" title="Registrar Compras">Ir <i
                    class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- BOX-STOCK -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>Stock</h3>
                  <p>Ver stock de productos</p>
                </div>
                <div class="icon">
                  <i class="fas fa-box-open"></i>
                </div>
                <a href="<?php echo $url_stock?>" class="small-box-footer">Ir <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <!-- ./col -->
          </div>
          <!-- /.row -->

        </div>
        <!-- /.card -->
      </section>
    <?php } elseif (($_SESSION['permisos_acceso'] == 'Ventas')) { ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="background-color: #fff">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">
                  <li class="fa fa-home icon-title"></li> Inicio
                </h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <a href="<?php echo $url_inicio ?>" style="color: inherit; text-decoration: none;">
                    <li class="fa fa-home"></li>
                  </a>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!--Bienvenida-->
        <section class="content">
          <div class="row ">
            <div class="col-lg-12 col-xs-12">
              <div class="alert alert alert-dismissable" style="opacity: 0.9; background-color: #d9edf2; color: #476072;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p style="font-size: 18px;">
                  <i class="icon fa fa-user"></i> Bienvenido/a <strong>
                    <?php echo $_SESSION['name_user'] ?>
                  </strong>
                  al sistema: <strong>CimplyMart</strong>
                </p>
              </div>
            </div>
          </div>
        </section>
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h3 class="m-0">
                  <i class="fa-solid fa-file-pen"></i> Formularios de Movimientos
                </h3>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-lg-3 col-6">
                <!-- BOX-VENTAS -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>Ventas</h3>
                    <p>Regristrar venta de productos</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-cart-plus"></i>
                  </div>
                  <a href="<?php echo $url_ventas?>" class="small-box-footer" tittle="Registrar Ventas">Ir <i
                      class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- BOX-STOCK -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>Stock</h3>
                    <p>Ver stock de productos</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-box-open"></i>
                  </div>
                  <a href="<?php echo $url_stock?>" class="small-box-footer">Ir <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <!-- ./col -->
            </div>
            <!-- /.row -->

          </div>
          <!-- /.card -->
        </section>
      <?php } ?>
      <?php include "../../views/footer.php"; ?>