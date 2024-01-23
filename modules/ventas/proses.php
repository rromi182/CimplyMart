<?php
session_start();

require_once '../../config/database.php';

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
} else {
    /*if($_GET['act']=='insert'){
        if(isset($_POST['Guardar'])){
            $codigo = $_POST['codigo'];
            $codigo_deposito= $_POST['codigo_deposito'];
            //Insertar detalle de venta
            $sql=mysqli_query($mysqli, "SELECT * FROM producto, tmp WHERE producto.cod_producto=tmp.id_producto");
            while($row = mysqli_fetch_array($sql)){
                $codigo_producto= $row['id_producto'];
                $precio= $row['precio_tmp'];
                $cantidad= $row['cantidad_tmp'];
                $insert_detalle = mysqli_query($mysqli, "INSERT INTO detalle_compra (cod_producto, cod_venta,
                precio, cantidad) VALUES ($codigo_producto, $codigo, $codigo_deposito, $precio, $cantidad)")
                or die('Error'.mysqli_error($mysqli));

                //Insertar stock
                $query = mysqli_query($mysqli, "SELECT * FROM stock WHERE cod_producto=$codigo_producto
                AN=$codigo_deposito") 
                or die('Error'.mysqli_error($mysqli));
                if($count = mysqli_num_rows($query)==0){
                    //Insertar
                    $insertar_stock = mysqli_query($mysqli, "INSERT INTO stock, cod_producto, cantidad)
                    VALUES ($codigo_deposito, $codigo_producto,$cantidad )")
                    or die('Error'.mysqli_error($mysqli));
                }else {
                    $actualizar_stock = mysqli_query($mysqli, "UPDATE stock SET cantidad = cantidad + $cantidad
                    WHERE cod_producto=$codigo_producto
                    AN=$codigo_deposito ")
                    or die('Error'.mysqli_error($mysqli));
                }
            }
            //Insertar cabecera de venta
            //Definir variables
            $id_cliente = $_POST['codigo_proveedor'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $nro_factura = $_POST['nro_factura'];
            $suma_total=$_POST['suma_total'];
            $estado='activo';
            $usuario = $_SESSION['id_user'];
            //insertar
            $query = mysqli_query($mysqli, "INSERT INTO venta (cod_venta, id_cliente,
            nro_factura, fecha, hora, estado, total_venta, id_user)
            VALUES ($codigo, $id_cliente, $codigo_deposito,
            '$nro_factura', '$fecha', '$hora', '$estado', $suma_total, $usuario)")
            or die('Error'.mysqli_error($mysqli));

            if($query){
                header("Location: ../../main.php?module=compras&alert=1");
            } else {
                header("Location: ../../main.php?module=compras&alert=3");
            }
        }
    }*/if ($_GET['act'] == 'insert') {
        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
            $codigo_deposito = $_POST['codigo_deposito'];

            // Definir variables de la cabecera de venta
            $id_cliente = $_POST['id_cliente'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $nro_factura = $_POST['nro_factura'];
            $suma_total = $_POST['suma_total'];
            $estado = 'activo';
            $usuario = $_SESSION['id_user'];

            // Iniciar transacción
            mysqli_autocommit($mysqli, false);

            // Insertar cabecera de venta
            $query_cabecera = mysqli_query($mysqli, "INSERT INTO venta (cod_venta, id_cliente, fecha, hora, estado, total_venta, nro_factura, id_user,cod_deposito)
                                                VALUES ($codigo, $id_cliente, '$fecha', '$hora', '$estado', $suma_total, '$nro_factura', '$usuario', $codigo_deposito)")
                or die('Error al insertar la cabecera de venta: ' . mysqli_error($mysqli));

            // Verificar si se insertó la cabecera correctamente
            if ($query_cabecera) {
                $sql = mysqli_query($mysqli, "SELECT * FROM producto, tmp WHERE producto.cod_producto=tmp.id_producto");
                while ($row = mysqli_fetch_array($sql)) {
                    $codigo_producto = $row['id_producto'];
                    $precio = $row['precio_tmp'];
                    $cantidad = $row['cantidad_tmp'];

                    // Verificar suficiente stock antes de la venta
                    $query_stock = mysqli_query($mysqli, "SELECT cantidad FROM stock WHERE cod_producto=$codigo_producto AND cod_deposito=$codigo_deposito") or die('Error al consultar stock: ' . mysqli_error($mysqli));
                    $row_stock = mysqli_fetch_assoc($query_stock);
                    $stock_disponible = $row_stock['cantidad'];

                    if ($stock_disponible >= $cantidad) {
                        // Insertar detalle de venta
                        $insert_detalle = mysqli_query($mysqli, "INSERT INTO det_venta (cod_producto, cod_venta, det_precio_unit, det_cantidad, cod_deposito) VALUES ($codigo_producto, $codigo, $precio, $cantidad,$codigo_deposito)") or die('Error al insertar detalle de venta: ' . mysqli_error($mysqli));
                        // Disminuir stock
                        $actualizar_stock = mysqli_query($mysqli, "UPDATE stock SET cantidad = cantidad - $cantidad WHERE cod_producto=$codigo_producto AND cod_deposito=$codigo_deposito ") or die('Error al actualizar stock: ' . mysqli_error($mysqli));
                    } else {
                        // No hay suficiente stock, hacer rollback y redirigir con alerta
                        mysqli_rollback($mysqli);
                        header("Location: view.php?alert=4");
                        exit;
                    }
                }

                // Confirmar la transacción
                mysqli_commit($mysqli);

                // Eliminar registros temporales
                $sql = mysqli_query($mysqli, "DELETE FROM tmp;");

                // Redireccionar si todo es exitoso
                header("Location: view.php?alert=1");
            } else {
                // Hubo un error en la cabecera, hacer rollback y redirigir con alerta
                mysqli_rollback($mysqli);
                header("Location: view.php?alert=3");
            }
        }
    } elseif ($_GET['act'] == 'anular') {
        if (isset($_GET['cod_venta'])) {
            $codigo = $_GET['cod_venta'];
            //Anular cabecera de venta (cambiar estado a anulado)
            $query = mysqli_query($mysqli, "UPDATE venta SET estado='anulado' WHERE cod_venta=$codigo")
                or die('Error' . mysqli_error($mysqli));

            //Consultar detalle de venta con el código que llegó por get
            $sql = mysqli_query($mysqli, "SELECT * FROM det_venta WHERE cod_venta=$codigo");
            while ($row = mysqli_fetch_array($sql)) {
                $codigo_producto = $row['cod_producto'];
                $codigo_deposito = $row['cod_deposito'];
                $cantidad = $row['det_cantidad'];

                $actualizar_stock = mysqli_query($mysqli, "UPDATE stock set cantidad = cantidad + $cantidad
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