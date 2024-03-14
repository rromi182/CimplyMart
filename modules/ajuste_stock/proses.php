<?php
session_start();

require_once '../../config/database.php';

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
} else {
    if ($_GET['act'] == 'add') {
        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];

            // Variables de la cabecera de ajuste de stock
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $estado = 'activo';
            $usuario = $_SESSION['id_user'];
            //datos para el detalle del ajuste de stock
            $cod_deposito = $_POST['cod_deposito'];
            $cod_producto = $_POST['cod_producto'];
            $cantidad = $_POST['cantidad'];
            $motivo = $_POST['motivo'];

            // Insertar cabecera de ajuste de stock
            $query_cabecera = mysqli_query($mysqli, "INSERT INTO ajuste_stock (id_ajuste_stock, fecha, estado, hora, id_user) 
                                                VALUES ($codigo,'$fecha', '$estado', '$hora', $usuario)")
                or die('Error al insertar la cabecera de ajuste: ' . mysqli_error($mysqli));

            $query_detalle = mysqli_query($mysqli, "INSERT INTO ajuste_stock_det (id_ajuste_stock, cod_producto, cod_deposito, cantidad, motivo)
                                                VALUES($codigo, $cod_producto, $cod_deposito, $cantidad, '$motivo')")
                or die('Error al insertar detalle de ajuste: ' . mysqli_error($mysqli));

            // Insertar stock
            $query_stock = mysqli_query($mysqli, "SELECT * FROM stock WHERE cod_producto=$cod_producto AND cod_deposito=$cod_deposito")
                or die('Error al consultar stock: ' . mysqli_error($mysqli));

            if ($count_stock = mysqli_num_rows($query_stock) == 0) { //si es cero insertar 
                // Insertar
                $insertar_stock = mysqli_query($mysqli, "INSERT INTO stock (cod_deposito, cod_producto, cantidad) 
        VALUES ($cod_deposito, $cod_producto, $cantidad )") or die('Error al insertar stock: ' . mysqli_error($mysqli));
            } else { //si ya hay producto update
                // Actualizar stock
                $actualizar_stock = mysqli_query($mysqli, "UPDATE stock SET cantidad = cantidad + $cantidad WHERE cod_producto=$cod_producto AND cod_deposito=$cod_deposito ")
                    or die('Error al actualizar stock: ' . mysqli_error($mysqli));
            }
            if (($insertar_stock == true) || ($actualizar_stock == true)) {
                header("Location: view.php?alert=1");
            }
        }
    } elseif ($_GET['act'] == 'remove') {
        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
    
            // Variables de la cabecera de ajuste de stock
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $estado = 'activo';
            $usuario = $_SESSION['id_user'];
            //datos para el detalle del ajuste de stock
            $cod_deposito = $_POST['cod_deposito'];
            $cod_producto = $_POST['cod_producto'];
            $cantidad = $_POST['cantidad'];
            $motivo = $_POST['motivo'];
    
            // Verificar si hay suficiente stock para restar
            $query_stock = mysqli_query($mysqli, "SELECT * FROM stock WHERE cod_producto=$cod_producto AND cod_deposito=$cod_deposito AND cantidad >= $cantidad")
                or die('Error al consultar stock: ' . mysqli_error($mysqli));
    
            if ($count_stock = mysqli_num_rows($query_stock) > 0) {
                // Insertar cabecera de ajuste de stock
                $query_cabecera = mysqli_query($mysqli, "INSERT INTO ajuste_stock (id_ajuste_stock, fecha, estado, hora, id_user) 
                                                    VALUES ($codigo,'$fecha', '$estado', '$hora', $usuario)")
                    or die('Error al insertar la cabecera de ajuste: ' . mysqli_error($mysqli));
    
                // Insertar detalle del ajuste de stock
                $query_detalle = mysqli_query($mysqli, "INSERT INTO ajuste_stock_det (id_ajuste_stock, cod_producto, cod_deposito, cantidad, motivo)
                                                    VALUES($codigo, $cod_producto, $cod_deposito, -$cantidad, '$motivo')")
                    or die('Error al insertar detalle de ajuste: ' . mysqli_error($mysqli));
    
                // Restar stock
                $restar_stock = mysqli_query($mysqli, "UPDATE stock SET cantidad = cantidad - $cantidad WHERE cod_producto=$cod_producto AND cod_deposito=$cod_deposito ")
                    or die('Error al restar stock: ' . mysqli_error($mysqli));
    
                if ($restar_stock == true) {
                    header("Location: view.php?alert=2");
                } else {
                    // Manejar el caso en el que no se pudo restar el stock
                    header("Location: view.php?alert=3");
                }
            } else {
                // Manejar el caso en el que no hay suficiente stock para restar
                header("Location: view.php?alert=3");
            }
        }
    } elseif ($_GET['act'] == 'anular') {
        if (isset($_GET['id_ajuste_stock'])) {
            $codigo = $_GET['id_ajuste_stock'];
    
            // Obtener información del ajuste a anular
            $info_ajuste = mysqli_query($mysqli, "SELECT * FROM ajuste_stock WHERE id_ajuste_stock=$codigo");
            $ajuste_data = mysqli_fetch_assoc($info_ajuste);
    
            // Verificar si el ajuste ya está anulado
            if ($ajuste_data['estado'] != 'anulado') {
                // Anular cabecera de ajuste de stock (cambiar estado a anulado)
                $query_anular = mysqli_query($mysqli, "UPDATE ajuste_stock SET estado='anulado' WHERE id_ajuste_stock=$codigo")
                    or die('Error' . mysqli_error($mysqli));
    
                // Obtener detalles del ajuste
                $detalle_ajuste = mysqli_query($mysqli, "SELECT * FROM ajuste_stock_det WHERE id_ajuste_stock=$codigo");
                while ($detalle_data = mysqli_fetch_assoc($detalle_ajuste)) {
                    $cod_producto = $detalle_data['cod_producto'];
                    $cod_deposito = $detalle_data['cod_deposito'];
                    $cantidad = $detalle_data['cantidad'];
    
                    // Revertir la cantidad en la tabla stock
                    $revertir_stock = mysqli_query($mysqli, "UPDATE stock SET cantidad = cantidad - $cantidad WHERE cod_producto=$cod_producto AND cod_deposito=$cod_deposito ")
                        or die('Error al revertir stock: ' . mysqli_error($mysqli));
                }
    
                if ($query_anular && $revertir_stock) {
                    header("Location: view.php?alert=4");
                } else {
                    header("Location: view.php?alert=3");
                }
            } else {
                // Manejar el caso en el que el ajuste ya está anulado
                header("Location: view.php?alert=3");
            }
        }
    }
}
?>