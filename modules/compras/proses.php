<?php 
session_start();

require_once '../../config/database.php';

if(empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
}
else{
    /*if($_GET['act']=='insert'){
        if(isset($_POST['Guardar'])){
            $codigo = $_POST['codigo'];
            $codigo_deposito= $_POST['codigo_deposito'];
            //Insertar detalle de compra
            $sql=mysqli_query($mysqli, "SELECT * FROM producto, tmp WHERE producto.cod_producto=tmp.id_producto");
            while($row = mysqli_fetch_array($sql)){
                $codigo_producto= $row['id_producto'];
                $precio= $row['precio_tmp'];
                $cantidad= $row['cantidad_tmp'];
                $insert_detalle = mysqli_query($mysqli, "INSERT INTO detalle_compra (cod_producto, cod_compra, cod_deposito,
                precio, cantidad) VALUES ($codigo_producto, $codigo, $codigo_deposito, $precio, $cantidad)")
                or die('Error'.mysqli_error($mysqli));

                //Insertar stock
                $query = mysqli_query($mysqli, "SELECT * FROM stock WHERE cod_producto=$codigo_producto
                AND cod_deposito=$codigo_deposito") 
                or die('Error'.mysqli_error($mysqli));
                if($count = mysqli_num_rows($query)==0){
                    //Insertar
                    $insertar_stock = mysqli_query($mysqli, "INSERT INTO stock (cod_deposito, cod_producto, cantidad)
                    VALUES ($codigo_deposito, $codigo_producto,$cantidad )")
                    or die('Error'.mysqli_error($mysqli));
                }else {
                    $actualizar_stock = mysqli_query($mysqli, "UPDATE stock SET cantidad = cantidad + $cantidad
                    WHERE cod_producto=$codigo_producto
                    AND cod_deposito=$codigo_deposito ")
                    or die('Error'.mysqli_error($mysqli));
                }
            }
            //Insertar cabecera de compra
            //Definir variables
            $codigo_proveedor = $_POST['codigo_proveedor'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $nro_factura = $_POST['nro_factura'];
            $suma_total=$_POST['suma_total'];
            $estado='activo';
            $usuario = $_SESSION['id_user'];
            //insertar
            $query = mysqli_query($mysqli, "INSERT INTO compra (cod_compra, cod_proveedor, cod_deposito,
            nro_factura, fecha, hora, estado, total_compra, id_user)
            VALUES ($codigo, $codigo_proveedor, $codigo_deposito,
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

        // Definir variables de la cabecera de compra
        $codigo_proveedor = $_POST['codigo_proveedor'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $nro_factura = $_POST['nro_factura'];
        $suma_total = $_POST['suma_total'];
        $estado = 'activo';
        $usuario = $_SESSION['id_user'];

        // Insertar cabecera de compra
        $query_cabecera = mysqli_query($mysqli, "INSERT INTO compra (cod_compra, cod_proveedor, cod_deposito, nro_factura, fecha, hora, estado, total_compra, id_user) VALUES ($codigo, $codigo_proveedor, $codigo_deposito, '$nro_factura', '$fecha', '$hora', '$estado', $suma_total, $usuario)") or die('Error al insertar la cabecera de compra: ' . mysqli_error($mysqli));

        // Insertar detalles de compra
        if ($query_cabecera) {
            $sql = mysqli_query($mysqli, "SELECT * FROM producto, tmp WHERE producto.cod_producto=tmp.id_producto");
            while ($row = mysqli_fetch_array($sql)) {
                $codigo_producto = $row['id_producto'];
                $precio = $row['precio_tmp'];
                $cantidad = $row['cantidad_tmp'];

                // Insertar detalle de compra
                $insert_detalle = mysqli_query($mysqli, "INSERT INTO detalle_compra (cod_producto, cod_compra, cod_deposito, precio, cantidad) VALUES ($codigo_producto, $codigo, $codigo_deposito, $precio, $cantidad)") or die('Error al insertar detalle de compra: ' . mysqli_error($mysqli));

                // Insertar stock
                $query_stock = mysqli_query($mysqli, "SELECT * FROM stock WHERE cod_producto=$codigo_producto AND cod_deposito=$codigo_deposito") or die('Error al consultar stock: ' . mysqli_error($mysqli));

                if ($count_stock = mysqli_num_rows($query_stock) == 0) {
                    // Insertar
                    $insertar_stock = mysqli_query($mysqli, "INSERT INTO stock (cod_deposito, cod_producto, cantidad) VALUES ($codigo_deposito, $codigo_producto, $cantidad )") or die('Error al insertar stock: ' . mysqli_error($mysqli));
                } else {
                    // Actualizar stock
                    $actualizar_stock = mysqli_query($mysqli, "UPDATE stock SET cantidad = cantidad + $cantidad WHERE cod_producto=$codigo_producto AND cod_deposito=$codigo_deposito ") or die('Error al actualizar stock: ' . mysqli_error($mysqli));
                }
            }
            //CREAR TRIGGER EN LA BD Y LUEGO ELIMINAR ESTA LINEA DE CODIGO
        //$sql = mysqli_query($mysqli,"DELETE FROM tmp;");

            // Redireccionar si todo es exitoso
            header("Location: view.php?alert=1");
        } else {
            header("Location: view.php?alert=3");
        }
    }
}

    elseif($_GET['act']=='anular'){
        if(isset($_GET['cod_compra'])){
            $codigo = $_GET['cod_compra'];
            //Anular cabecera de compra (cambiar estado a anulado)
            $query = mysqli_query($mysqli, "UPDATE compra SET estado='anulado' WHERE cod_compra=$codigo")
            or die('Error'.mysqli_error($mysqli));

            //Consultar detalle de compra con el código que llegó por get
            $sql = mysqli_query($mysqli, "SELECT * FROM detalle_compra WHERE cod_compra=$codigo");
            while($row = mysqli_fetch_array($sql)){
                $codigo_producto = $row['cod_producto'];
                $codigo_deposito = $row['cod_deposito'];
                $cantidad = $row['cantidad'];

                $actualizar_stock = mysqli_query($mysqli, "UPDATE stock set cantidad = cantidad - $cantidad
                WHERE cod_producto=$codigo_producto
                AND cod_deposito=$codigo_deposito")
                or die('Error'.mysqli_error($mysqli));
            }
            if($query){
                header("Location: view.php?alert=2");
            } else {
                header("Location: view.php?alert=3");
            }
        }
    }
}
?>