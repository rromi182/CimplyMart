<?php
session_start();
$session_id = session_id();
require_once '../../config/database.php';

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
} else {
    if (isset($_POST['data'])) {
        $data = json_decode($_POST['data'], true);
        // echo '<pre>';
        // var_dump($data);
        // echo '</pre>';
        // exit();
    }
    if ($_GET['act'] == 'insert') {

        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];

            // Definir variables de la cabecera de compra
            $codigo_proveedor = $_POST['codigo_proveedor'];
            $id_pedido_compra = $_POST['id_pedido_compra'];
            $fecha_registro = $_POST['fecha_registro'];
            $fecha_vence = $_POST['fecha_vencimiento'];
            $hora = $_POST['hora'];
            $estado = 'pendiente';
            $usuario = $_SESSION['id_user'];

            foreach ($data as $_data) {
                $codigo_producto = $_data['codigoProducto'];
                $cantidad = isset($_POST['cantidad'][$codigo_producto]) ? $_POST['cantidad'][$codigo_producto] : 0;
                $precio = isset($_POST['precio'][$codigo_producto]) ? $_POST['precio'][$codigo_producto] : 0;


                if ($codigo_producto || $cantidad || $precio) {
                    $insert_tmp = mysqli_query($mysqli, "INSERT INTO tmp (id_producto, cantidad_tmp, precio_tmp, session_id) 
                VALUES('$codigo_producto', '$cantidad', '$precio','$session_id')");
                }
                //Eliminar datos de productos que se hayan eliminado (cantidad 0 y precio 0)
                $delete_zero_quantity = mysqli_query($mysqli, "DELETE FROM tmp WHERE cantidad_tmp = 0 AND precio_tmp = 0");
            }


            // Calcular la suma total antes de la inserción
            $query_total = mysqli_query($mysqli, "SELECT SUM(tmp.precio_tmp * tmp.cantidad_tmp) AS total_costo
            FROM tmp");

            $row_total = mysqli_fetch_assoc($query_total);
            $suma_total = $row_total['total_costo'];

            // Insertar cabecera de presupuesto compra
            $query_cabecera = mysqli_query($mysqli, "INSERT INTO presupuesto_compra (id_presupuesto_compra, id_pedido_compra,cod_proveedor, fecha_registro, fecha_vencimiento, estado, hora, total_costo, id_user) 
                                                VALUES ($codigo, $id_pedido_compra,$codigo_proveedor, '$fecha_registro', '$fecha_vence','$estado', '$hora',$suma_total, $usuario)") or die('Error al insertar la cabecera de compra: ' . mysqli_error($mysqli));

            // Insertar detalles del Presupuesto de compra
            if ($query_cabecera) {
                $sql = mysqli_query($mysqli, "SELECT * FROM producto, tmp WHERE producto.cod_producto=tmp.id_producto");

                // Preparar la inserción de detalles del presupuesto de compra
                $insert_detalle = mysqli_prepare($mysqli, "INSERT INTO presupuesto_compra_det (id_presupuesto_compra, cod_producto, cantidad, costo) VALUES (?, ?, ?, ?)");

                while ($row = mysqli_fetch_array($sql)) {
                    $codigo_producto = $row['id_producto'];
                    $costo = $row['precio_tmp'];
                    $cantidad = $row['cantidad_tmp'];

                    // Asignar valores a los parámetros y ejecutar la declaración preparada
                    mysqli_stmt_bind_param($insert_detalle, "iiid", $codigo, $codigo_producto, $cantidad, $costo);
                    mysqli_stmt_execute($insert_detalle);
                }
                // Actualizar estado del pedido de compra (fuera del bucle)
                $update_pedido_compra = mysqli_query($mysqli, "UPDATE pedido_compra SET estado = 'procesado' WHERE id_pedido_compra = $id_pedido_compra");
                // //CREAR TRIGGER EN LA BD Y LUEGO ELIMINAR ESTA LINEA DE CODIGO
                // $sql = mysqli_query($mysqli, "DELETE FROM tmp;");

                // Redireccionar si todo es exitoso
                header("Location: view.php?alert=1");
            } else {
                header("Location: view.php?alert=4");
            }
        }
    } elseif ($_GET['act'] == 'aprobar') {
        if (isset($_GET['id_presupuesto_compra'])) {
            $codigo = $_GET['id_presupuesto_compra'];
            //
            $query = mysqli_query($mysqli, "UPDATE presupuesto_compra SET estado='aprobado' WHERE id_presupuesto_compra=$codigo")
                or die('Error' . mysqli_error($mysqli));
            // //Volver a pendiente el pedido de compra
            // $query = mysqli_query($mysqli, "UPDATE orden_compra SET estado='pendiente' WHERE id_orden_compra=$codigo")
            //     or die('Error' . mysqli_error($mysqli));
            if ($query) {
                header("Location: view.php?alert=2");
            } else {
                header("Location: view.php?alert=3");
            }
        }
    } elseif ($_GET['act'] == 'anular') {
        if (isset($_GET['id_presupuesto_compra']) && isset($_GET['id_pedido_compra'])) {
            $codigo = $_GET['id_presupuesto_compra'];
            $cod_pedido = $_GET['id_pedido_compra'];
            //Anular cabecera de compra (cambiar estado a anulado)
            $query = mysqli_query($mysqli, "UPDATE presupuesto_compra SET estado='anulado' WHERE id_presupuesto_compra=$codigo")
                or die('Error' . mysqli_error($mysqli));

            //Volver a pendiente el pedido de compra
            $query = mysqli_query($mysqli, "UPDATE pedido_compra SET estado='pendiente' WHERE id_pedido_compra=$cod_pedido")
                or die('Error' . mysqli_error($mysqli));

            if ($query) {
                header("Location: view.php?alert=3");
            } else {
                header("Location: view.php?alert=4");
            }
        }
    }
}
