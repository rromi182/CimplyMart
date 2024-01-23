<?php
session_start();
$session_id = session_id();

require_once '../config/database.php';


// if(!empty($id) and !empty($cantidad) and !empty($precio_compra_)){
//     $insert_tmp = mysqli_query($mysqli, "INSERT INTO tmp (id_producto, cantidad_tmp, precio_tmp, session_id)
//     VALUES('$id', '$cantidad', '$precio_compra_','$session_id')");
// }
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete = mysqli_query($mysqli, "DELETE FROM tmp WHERE id_tmp = '" . $id . "'");
}
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<table class="table table-bordered table-striped table-hover">
    <tr class="bg-warning">
        <th>Código</th>
        <th>Tipo de Produ.</th>
        <th>Unid. de medida</th>
        <th>Producto</th>
        <th><span class="pull-right">Cantidad</span></th>
        <th><span class="pull-right">Precio</span></th>
        <th style="width: 36px;">Eliminar</th>
    </tr>
    <?php
    if (isset($_GET['id_pedido'])) {
        $idPedido = $_GET['id_pedido'];
        $sql = mysqli_query($mysqli, "SELECT pcd.id_pedido_compra,
                                    prod.cod_producto, prod.p_descrip,
                                    tp.cod_tipo_prod, tp.t_p_descrip,
                                    um.id_u_medida, um.u_descrip,
                                    pcd.cantidad
                                    FROM pedido_compra_det pcd
                                    JOIN producto prod ON pcd.cod_producto = prod.cod_producto
                                    JOIN tipo_producto tp ON prod.cod_tipo_prod = tp.cod_tipo_prod
                                    JOIN u_medida um ON prod.id_u_medida = um.id_u_medida
                                    WHERE id_pedido_compra = $idPedido");
    
        while ($row = mysqli_fetch_array($sql)) {
            // Obtener datos de la fila
            $idPedidoCompra = $row['id_pedido_compra'];
            $codigo_producto = $row['cod_producto'];
            $descripcionProducto = $row['p_descrip'];
            $codigoTipoProducto = $row['cod_tipo_prod'];
            $tipoProducto = $row['t_p_descrip'];
            $idUnidadMedida = $row['id_u_medida'];
            $unidadMedida = $row['u_descrip'];
            $cantidad = $row['cantidad'];
            $precio = 0;
        ?>
        <tr>
            <td>
                <?php echo $codigo_producto; ?>
                <input type="hidden" class="form-control" name="codigo_producto" value="<?php echo $codigo_producto; ?>">
            </td>
            <td>
                <?php echo $tipoProducto; ?>
            </td>
            <td>
                <?php echo $unidadMedida; ?>
            </td>
            <td>
                <?php echo $descripcionProducto; ?>
            </td>
            <td class="col-xs-1">
                <span class="pull-right">
                    <input type="text" class="form-control editable cantidad" name="cantidad" id="cantidad_<?php echo $codigo_producto; ?>"
                        value="<?php echo $cantidad; ?>">
                </span>
            </td>
            <td class="col-xs-1">
                <span class="pull-right">
                    <input type="text" class="form-control editable precio" name="precio" id="precio_compra_<?php echo $codigo_producto; ?>"
                        value="<?php echo $precio; ?>">
                </span>
            </td>
            <td><span class="pull-right"><a href="#" onclick="eliminar('<?php echo $codigo_producto; ?>')"><i
                            class="fa fa-trash"></i></a></span></td>
                            
        </tr>
        <!-- <td><span class="pull-right"><a href="#" onclick="calcular('<?php //echo $codigo_producto; ?>')"><i class="fa fa-plus"></i></a></span></td> -->
    <?php    }
    }//}
    ?>
    <!-- <tr>
        <input type="hidden" class="form-control" name="suma_total" value="<?php //echo $suma_total; ?>">
        <?php /*if (empty($codigo_producto)) {
            $codigo_producto = 0;
        } else {
            $codigo_producto;
        } */?>
        <input type="hidden" class="form-control" name="codigo_producto" value="<?php // echo $codigo_producto; ?>">
        <?php /*if (empty($cantidad)) {
            $cantidad = 0;
        } else {
            $cantidad;
        } */?>
        <input type="hidden" class="form-control" name="cantidad" value="<?php //echo $cantidad; ?>">
        <td colspan=5><span class="pull-right">Total Gs.</span></td>
        <td>
            <strong><span class="pull-right  suma-total">
                    <?php //echo number_format($suma_total); ?>
                </span></strong>
        </td>
    </tr>  -->
</table>