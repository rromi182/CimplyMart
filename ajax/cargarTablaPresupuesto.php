<?php
session_start();
$session_id = session_id();

require_once '../config/database.php';
$data = [];
$productoData = [];
$index = 0;

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
                                    pcd.cantidad, prod.precio
                                    FROM pedido_compra_det pcd
                                    JOIN producto prod ON pcd.cod_producto = prod.cod_producto
                                    JOIN tipo_producto tp ON prod.cod_tipo_prod = tp.cod_tipo_prod
                                    JOIN u_medida um ON prod.id_u_medida = um.id_u_medida
                                    WHERE id_pedido_compra = $idPedido");

        while ($row = mysqli_fetch_array($sql)) {
            // Obtener datos de la fila
            $data[] = [
                'idPedidoCompra' => $row['id_pedido_compra'],
                'codigoProducto' => $row['cod_producto'],
                'descripcionProducto' => $row['p_descrip'],
                'codigoTipoProducto' => $row['cod_tipo_prod'],
                'tipoProducto' => $row['t_p_descrip'],
                'idUnidadMedida' => $row['id_u_medida'],
                'unidadMedida' => $row['u_descrip'],
                'precioProducto' => $row['precio'],
                'cantidad' => $row['cantidad']
            ];
            // echo '<pre>';
            // var_dump($data);
            // echo '</pre>';
            $data = array_filter($data, function ($item) {
                return $item['cantidad'] > 0;
            });
        }
        $jsonData = json_encode($data);
        foreach ($data as $data) {
            ?>
            <tr data-codigo="<?php echo $data['codigoProducto']; ?>">

                <td>
                    <?php echo $data['codigoProducto']; ?>
                    <input type="hidden" class="form-control" name="codigo_producto"
                        value="<?php echo $data['codigoProducto']; ?>">
                </td>
                <td>
                    <?php echo $data['tipoProducto']; ?>
                </td>
                <td>
                    <?php echo $data['unidadMedida']; ?>
                </td>
                <td>
                    <?php echo $data['descripcionProducto']; ?>
                </td>
                <td class="col-xs-1">
                    <span class="pull-right">
                        <input type="text" class="form-control editable cantidad"
                            name="cantidad[<?php echo $data['codigoProducto']; ?>]"
                            id="cantidad_<?php echo $data['codigoProducto']; ?>" value="<?php echo $data['cantidad']; ?>">
                    </span>
                </td>
                <td class="col-xs-1">
                    <span class="pull-right">
                        <input type="text" class="form-control editable precio"
                            name="precio[<?php echo $data['codigoProducto']; ?>]"
                            id="precio_compra_<?php echo $data['codigoProducto']; ?>" value="<?php echo $data['precioProducto']; ?>">
                    </span>
                </td>
                <td><span class="pull-right"><a href="#" onclick="eliminarProducto('<?php echo $data['codigoProducto']; ?>')"><i
                                class="fa fa-trash"></i></a></span></td>


            </tr>


        <?php }

        ?>
        <tr>
            <td colspan=5><span class="pull-right">Total Gs.</span></td>
            <td class="totals"><strong><span class="grand-total" style="margin-left: 10px;">0</span></strong></td>
        </tr>
        <?php
    }

    ?>
</table>

<input type="hidden" class="form-control" name="data" value='<?php echo $jsonData; ?>'>

<script>
    $(document).ready(function () {
        updateTotals();

        // Attach event listener for input changes
        $('.editable').on('input', function () {
            updateTotals();
        });
    });

    function updateTotals() {
        var grandTotal = 0;

        $('.table tbody tr').each(function () {
            var quantity = parseInt($(this).find('.cantidad').val()) || 0;
            var price = parseFloat($(this).find('.precio').val()) || 0;

            var totalRow = (quantity * price).toFixed(2);
            $(this).find('.total-row').text(parseInt(totalRow));

            grandTotal += parseInt(totalRow);
        });

        // Display the grand total below the table
        $('.grand-total').text(grandTotal);
    }
</script>