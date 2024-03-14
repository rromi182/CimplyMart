<?php 
session_start();

require_once '../../config/database.php';

if(empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
}
else{
   if ($_GET['act'] == 'insert') {
    if (isset($_POST['Guardar'])) {
        $codigo = $_POST['codigo'];

        // Definir variables de la cabecera de compra
       // $codigo_proveedor = $_POST['codigo_proveedor'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $estado = 'pendiente';
        $usuario = $_SESSION['id_user'];

        // Insertar cabecera de compra
        $query_cabecera = mysqli_query($mysqli, "INSERT INTO pedido_compra (id_pedido_compra, fecha_registro, hora, estado, id_user) VALUES ($codigo,'$fecha', '$hora', '$estado', $usuario)") or die('Error al insertar la cabecera de compra: ' . mysqli_error($mysqli));

        // Insertar detalles del pedido de compra
        if ($query_cabecera) {
            $sql = mysqli_query($mysqli, "SELECT * FROM producto, tmp WHERE producto.cod_producto=tmp.id_producto");
            while ($row = mysqli_fetch_array($sql)) {
                $codigo_producto = $row['id_producto'];
                $cantidad = $row['cantidad_tmp'];

                // Insertar detalle de compra
                $insert_detalle = mysqli_query($mysqli, "INSERT INTO pedido_compra_det (id_pedido_compra, cod_producto, cantidad) VALUES ($codigo, $codigo_producto, $cantidad)") or die('Error al insertar detalle de compra: ' . mysqli_error($mysqli));

                
            }
            //CREAR TRIGGER EN LA BD Y LUEGO ELIMINAR ESTA LINEA DE CODIGO
        // $sql = mysqli_query($mysqli,"DELETE FROM tmp;");

            // Redireccionar si todo es exitoso
            header("Location: view.php?alert=1");
        } else {
            header("Location: view.php?alert=3");
        }
    }
}

    elseif($_GET['act']=='anular'){
        if(isset($_GET['id_pedido_compra'])){
            $codigo = $_GET['id_pedido_compra'];
            //Anulara (cambiar estado a anulado)
            $query = mysqli_query($mysqli, "UPDATE pedido_compra SET estado='anulado' WHERE id_pedido_compra=$codigo")
            or die('Error'.mysqli_error($mysqli));

            if($query){
                header("Location: view.php?alert=2");
            } else {
                header("Location: view.php?alert=3");
            }
        }
    }elseif ($_GET['act'] == 'aprobar') {
        if (isset($_GET['id_pedido_compra'])) {
            $codigo = $_GET['id_pedido_compra'];
            //Anular cabecera de compra (cambiar estado a anulado)
            $query = mysqli_query($mysqli, "UPDATE pedido_compra SET estado='aprobado' WHERE id_pedido_compra=$codigo")
                or die('Error' . mysqli_error($mysqli));

                // //Presupuesto pendiente
                // $query = mysqli_query($mysqli, "UPDATE presupuesto_compra SET estado='pendiente' WHERE id_presupuesto_compra=$codigo")
                //     or die('Error' . mysqli_error($mysqli));

            if ($query) {
                header("Location: view.php?alert=4");
            } else {
                header("Location: view.php?alert=3");
            }
        }
    }
}
?>