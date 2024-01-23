<?php
session_start();
$session_id = session_id();
require_once '../../config/database.php';

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
} else {
    if ($_GET['act'] == 'insert') {
        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];

            // Definir variables de la cabecera de compra
            $codigo_proveedor = $_POST['codigo_proveedor'];
            $id_presupuesto_compra = $_POST['id_presupuesto_compra'];
            $fecha_registro = $_POST['fecha_registro'];
            $hora = $_POST['hora'];
            $estado = 'pendiente';
            $usuario = $_SESSION['id_user'];

            //Treaemos los datos de cantidad y costo
            if (isset($_POST['codigo_producto'])) { $codigo_producto = $_POST['codigo_producto'];}
            if (isset($_POST['cantidad'])) { $cantidad = $_POST['cantidad'];}
            if (isset($_POST['costo'])) { $costo = $_POST['costo'];}

            // echo "Codigo: $codigo, Cod_Producto: $codigo_producto, Cantidad: $cantidad, Precio: $costo";
            // exit();

            if (!empty($codigo_producto) and !empty($cantidad) and !empty($costo)) {
                $insert_tmp = mysqli_query($mysqli, "INSERT INTO tmp (id_producto, cantidad_tmp, precio_tmp, session_id) 
                VALUES('$codigo_producto', '$cantidad', '$costo','$session_id')");
            }

            // Calcular la suma total antes de la inserción
            $query_total = mysqli_query($mysqli, "SELECT SUM(tmp.precio_tmp * tmp.cantidad_tmp) AS total_costo
            FROM tmp");

            $row_total = mysqli_fetch_assoc($query_total);
            $suma_total = $row_total['total_costo'];
    //         echo "INSERT INTO orden_compra (id_orden_compra, id_presupuesto_compra, cod_proveedor, fecha_registro, estado, hora, total_costo, id_user) 
    //   VALUES ($codigo, $id_presupuesto_compra, $codigo_proveedor, '$fecha_registro', '$estado', '$hora', $suma_total, $usuario)";
    //         exit();
            // Insertar cabecera de presupuesto compra
            $query_cabecera = mysqli_query($mysqli, "INSERT INTO orden_compra (id_orden_compra, id_presupuesto_compra,cod_proveedor, fecha_registro, estado, hora, total_costo, id_user) 
                                                VALUES ($codigo, $id_presupuesto_compra,$codigo_proveedor, '$fecha_registro','$estado', '$hora',$suma_total, $usuario)") 
                                                or die('Error al insertar la cabecera de compra: ' . mysqli_error($mysqli));

            // Insertar detalles del Presupuesto de compra
            if ($query_cabecera) {
                $sql = mysqli_query($mysqli, "SELECT * FROM producto, tmp WHERE producto.cod_producto=tmp.id_producto");

                // Preparar la inserción de detalles del presupuesto de compra
                $insert_detalle = mysqli_prepare($mysqli, "INSERT INTO orden_compra_det (id_orden_compra, cod_producto, cantidad, costo) VALUES (?, ?, ?, ?)");

                while ($row = mysqli_fetch_array($sql)) {
                    $codigo_producto = $row['id_producto'];
                    $costo = $row['precio_tmp'];
                    $cantidad = $row['cantidad_tmp'];

                    // Asignar valores a los parámetros y ejecutar la declaración preparada
                    mysqli_stmt_bind_param($insert_detalle, "iiid", $codigo, $codigo_producto, $cantidad, $costo);
                    mysqli_stmt_execute($insert_detalle);
                }
                // Actualizar estado del pedido de compra (fuera del bucle)
                $update_pedido_compra = mysqli_query($mysqli, "UPDATE presupuesto_compra SET estado = 'procesado' WHERE id_presupuesto_compra = $id_presupuesto_compra");
                //CREAR TRIGGER EN LA BD Y LUEGO ELIMINAR ESTA LINEA DE CODIGO
                $sql = mysqli_query($mysqli, "DELETE FROM tmp;");

                // Redireccionar si todo es exitoso
                header("Location: view.php?alert=1");
            } else {
                header("Location: view.php?alert=4");
            }
        }
    } elseif ($_GET['act'] == 'aprobar') {
        if (isset($_GET['id_orden_compra'])) {
            $codigo = $_GET['id_orden_compra'];
            //Anular cabecera de compra (cambiar estado a anulado)
            $query = mysqli_query($mysqli, "UPDATE orden_compra SET estado='aprobado' WHERE id_orden_compra=$codigo")
                or die('Error' . mysqli_error($mysqli));

            if ($query) {
                header("Location: view.php?alert=2");
            } else {
                header("Location: view.php?alert=3");
            }
        }
    }elseif ($_GET['act'] == 'rechazar') {
        if (isset($_GET['id_orden_compra'])) {
            $codigo = $_GET['id_orden_compra'];
            //Anular cabecera de compra (cambiar estado a anulado)
            $query = mysqli_query($mysqli, "UPDATE orden_compra SET estado='rechazado' WHERE id_orden_compra = $codigo")
                or die('Error' . mysqli_error($mysqli));

            if ($query) {
                header("Location: view.php?alert=3");
            } else {
                header("Location: view.php?alert=4");
            }
        }
    }
}
