<?php
session_start();
$session_id = session_id();

require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete = mysqli_query($mysqli, "DELETE FROM tmp WHERE id_tmp = '" . $id . "'");
}

$data = [];
$productoData = [];
$proveedor = '';
$ruc = '';

if (isset($_GET['id_orden'])) {
    $idOrden = $_GET['id_orden'];
    $sqlProveedor = mysqli_query($mysqli, "SELECT cod_proveedor, razon_social, ruc FROM v_orden_compra_tabla WHERE id_orden_compra = $idOrden");
    
    $proveedorData = mysqli_fetch_assoc($sqlProveedor);
    $cod_proveedor = $proveedorData['cod_proveedor'];
    $proveedor = $proveedorData['razon_social'];
    $ruc = $proveedorData['ruc'];

    $sqlProductos = mysqli_query($mysqli, "SELECT * FROM v_orden_compra_tabla WHERE id_orden_compra = $idOrden");
    
    while ($row = mysqli_fetch_array($sqlProductos)) {
        // Obtener datos de la fila
        $idOrdenCompra = $row['id_orden_compra'];
        $codigo_producto = $row['cod_producto'];
        $descripcionProducto = $row['p_descrip'];
        $codigoTipoProducto = $row['cod_tipo_prod'];
        $tipoProducto = $row['t_p_descrip'];
        $idUnidadMedida = $row['id_u_medida'];
        $unidadMedida = $row['u_descrip'];
        $cantidad = $row['cantidad'];
        $costo = $row['costo'];

        $data[] = [
            'idOrdenCompra' => $idOrdenCompra,
            'codigoProducto' => $codigo_producto,
            'descripcionProducto' => $descripcionProducto,
            'codigoTipoProducto' => $codigoTipoProducto,
            'tipoProducto' => $tipoProducto,
            'idUnidadMedida' => $idUnidadMedida,
            'unidadMedida' => $unidadMedida,
            'cantidad' => $cantidad,
            'costo' => $costo
        ];

        $data = array_filter($data, function ($item) {
            return $item['cantidad'] > 0;
        });
    }
}

$jsonData = json_encode($data);
?>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" style="margin-left: 20px;">Proveedor:</label>
    <strong style="margin-top: 5px"><?php echo $proveedor . " - " . $ruc ?></strong>
    <input type="hidden" class="form-control" name="codigo_proveedor" value="<?php echo $cod_proveedor; ?>">
</div>

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
    foreach ($data as $productData) {
    ?>
        <tr data-codigo="<?php echo $productData['codigoProducto']; ?>">
            <td>
                <?php echo $productData['codigoProducto']; ?>
                <input type="hidden" class="form-control" name="codigo_producto" value="<?php echo $productData['codigoProducto']; ?>">
            </td>
            <td>
                <?php echo $productData['tipoProducto']; ?>
            </td>
            <td>
                <?php echo $productData['unidadMedida']; ?>
            </td>
            <td>
                <?php echo $productData['descripcionProducto']; ?>
            </td>
            <td class="col-xs-1">
                <span class="pull-right">
                    <input type="text" class="form-control editable cantidad" name="cantidad[<?php echo $productData['codigoProducto']; ?>]" id="cantidad_<?php echo $productData['codigoProducto']; ?>" value="<?php echo $productData['cantidad']; ?>">
                </span>
            </td>
            <td class="col-xs-1">
                <span class="pull-right">
                    <input type="text" class="form-control editable precio" name="precio[<?php echo $productData['codigoProducto']; ?>]" id="precio_compra_<?php echo $productData['codigoProducto']; ?>" value="<?php echo $productData['costo']; ?>">
                </span>
            </td>
            <td><span class="pull-right"><a href="#" onclick="eliminarProducto('<?php echo $productData['codigoProducto']; ?>')"><i class="fa fa-trash"></i></a></span></td>
        </tr>
    <?php
    }
    ?>
    <tr>
            <td colspan=5><span class="pull-right">Total Gs.</span></td>
            <td class="totals"><strong><span class="grand-total" style="margin-left: 10px;">0</span></strong></td>
        </tr>
</table>


<input type="hidden" class="form-control" name="data" value='<?php echo $jsonData; ?>'>

<script>
    $(document).ready(function() {
        updateTotals();

        // Attach event listener for input changes
        $('.editable').on('input', function() {
            updateTotals();
        });
    });

    function updateTotals() {
        var grandTotal = 0;

        $('.table tbody tr').each(function() {
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