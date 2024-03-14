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
            $codigo_deposito = $_POST['codigo_deposito'];

            // Definir variables de la cabecera de compra
            $codigo_proveedor = $_POST['codigo_proveedor'];
            $id_orden_compra = $_POST['id_orden_compra'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $nro_factura = $_POST['nro_factura'];
            // $suma_total = $_POST['suma_total'];
            $estado = 'activo';
            $usuario = $_SESSION['id_user'];

            //verificar NRO DE FACTURA
            $verificarFACTURA = mysqli_query($mysqli, "SELECT * FROM compra WHERE nro_factura = '$nro_factura'");
            if (mysqli_num_rows($verificarFACTURA) > 0) {
                header("Location: view.php?alert=5"); 
                exit();
            }

            //Treaemos los datos de cantidad y costo
            foreach ($data as $_data) {
                $codigo_producto = $_data['codigoProducto'];
                $cantidad = isset($_POST['cantidad'][$codigo_producto]) ? $_POST['cantidad'][$codigo_producto] : 0;
                $precio = isset($_POST['precio'][$codigo_producto]) ? $_POST['precio'][$codigo_producto] : 0;

                if ($codigo_producto || $cantidad || $precio) {
                    $insert_tmp = mysqli_query($mysqli, "INSERT INTO tmp (id_producto, cantidad_tmp, precio_tmp, session_id) 
                    VALUES('$codigo_producto', '$cantidad', '$precio','$session_id')");
                }
                //Eliminar datos de productos que se hayan eliminado (cantidad 0 y precio 0)
                $delete_zero_quantity = mysqli_query($mysqli, "DELETE FROM tmp WHERE cantidad_tmp = 0 or precio_tmp = 0");
            }

            // Calcular la suma total antes de la inserción
            $query_total = mysqli_query($mysqli, "SELECT SUM(tmp.precio_tmp * tmp.cantidad_tmp) AS total_costo
            FROM tmp");

            $row_total = mysqli_fetch_assoc($query_total);
            $suma_total = $row_total['total_costo'];

            // Insertar cabecera de compra
            $query_cabecera = mysqli_query($mysqli, "INSERT INTO compra (cod_compra, cod_proveedor, cod_deposito, nro_factura, fecha, hora, estado, total_compra, id_user, id_orden_compra) 
            VALUES ($codigo, $codigo_proveedor, $codigo_deposito, '$nro_factura', '$fecha', '$hora', '$estado', $suma_total, $usuario, $id_orden_compra)")
                or die('Error al insertar la cabecera de compra: ' . mysqli_error($mysqli));

            // Insertar detalles de compra
            if ($query_cabecera) {
                $sql = mysqli_query($mysqli, "SELECT * FROM producto, tmp WHERE producto.cod_producto=tmp.id_producto");
                while ($row = mysqli_fetch_array($sql)) {
                    $codigo_producto = $row['id_producto'];
                    $precio = $row['precio_tmp'];
                    $cantidad = $row['cantidad_tmp'];

                    // Insertar detalle de compra
                    $insert_detalle = mysqli_query($mysqli, "INSERT INTO detalle_compra (cod_producto, cod_compra, cod_deposito, precio, cantidad) 
                    VALUES ($codigo_producto, $codigo, $codigo_deposito, $precio, $cantidad)") or die('Error al insertar detalle de compra: ' . mysqli_error($mysqli));

                    // Insertar stock
                    $query_stock = mysqli_query($mysqli, "SELECT * FROM stock WHERE cod_producto=$codigo_producto AND cod_deposito=$codigo_deposito")
                        or die('Error al consultar stock: ' . mysqli_error($mysqli));

                    if ($count_stock = mysqli_num_rows($query_stock) == 0) {
                        // Insertar
                        $insertar_stock = mysqli_query($mysqli, "INSERT INTO stock (cod_deposito, cod_producto, cantidad) 
                        VALUES ($codigo_deposito, $codigo_producto, $cantidad )") or die('Error al insertar stock: ' . mysqli_error($mysqli));
                    } else {
                        // Actualizar stock
                        $actualizar_stock = mysqli_query($mysqli, "UPDATE stock SET cantidad = cantidad + $cantidad WHERE cod_producto=$codigo_producto AND cod_deposito=$codigo_deposito ")
                            or die('Error al actualizar stock: ' . mysqli_error($mysqli));
                    }
                }
                // Actualizar estado del pedido de compra (fuera del bucle)
                $update_pedido_compra = mysqli_query($mysqli, "UPDATE orden_compra SET estado = 'procesado' WHERE id_orden_compra = $id_orden_compra");
                //CREAR TRIGGER EN LA BD Y LUEGO ELIMINAR ESTA LINEA DE CODIGO
                //$sql = mysqli_query($mysqli,"DELETE FROM tmp;");

                // Redireccionar si todo es exitoso
                header("Location: view.php?alert=1");
            } else {
                header("Location: view.php?alert=3");
            }
        }
    } elseif ($_GET['act'] == 'anular') {
        if (isset($_GET['cod_compra']) && isset($_GET['id_orden_compra'])) {
            $codigo = $_GET['cod_compra'];
            $cod_orden = $_GET['id_orden_compra'];

            //Anular cabecera de compra (cambiar estado a anulado)
            $query = mysqli_query($mysqli, "UPDATE compra SET estado='anulado' WHERE cod_compra=$codigo")
                or die('Error' . mysqli_error($mysqli));
                // //Volver a pendiente el pedido de compra
                $query = mysqli_query($mysqli, "UPDATE orden_compra SET estado='pendiente' WHERE id_orden_compra=$cod_orden")
                    or die('Error' . mysqli_error($mysqli));

            //Consultar detalle de compra con el código que llegó por get
            $sql = mysqli_query($mysqli, "SELECT * FROM detalle_compra WHERE cod_compra=$codigo");
            while ($row = mysqli_fetch_array($sql)) {
                $codigo_producto = $row['cod_producto'];
                $codigo_deposito = $row['cod_deposito'];
                $cantidad = $row['cantidad'];

                $actualizar_stock = mysqli_query($mysqli, "UPDATE stock set cantidad = cantidad - $cantidad
                WHERE cod_producto=$codigo_producto
                AND cod_deposito=$codigo_deposito")
                    or die('Error' . mysqli_error($mysqli));
            }
            if ($query) {
                header("Location: view.php?alert=2");
            } else {
                header("Location: view.php?alert=3");
            }
        }
    }
}
?>
