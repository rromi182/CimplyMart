<?php
require_once "../../config/database.php";


if (isset($_REQUEST['cod_deposito'])) {
    $cod_deposito = $_REQUEST['cod_deposito'];

    // Consulta SQL para obtener la información del stock
    if ($cod_deposito === 'all') {
        $consulta_stock = "SELECT * FROM v_ajuste_stock";
        $stmt = mysqli_query($mysqli, $consulta_stock);
        $result = $stmt;
    } else {
        $consulta_stock = "SELECT * FROM v_ajuste_stock WHERE cod_deposito = ?";
        
        // Utiliza consultas preparadas para evitar problemas de seguridad
        $stmt = mysqli_prepare($mysqli, $consulta_stock);
        mysqli_stmt_bind_param($stmt, "i", $cod_deposito);
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
    }

    // Puedes realizar cualquier otra acción necesaria con los resultados aquí

    // Obtiene el número de filas
    $count = mysqli_num_rows($result);
}
?>
<!DOCTYPE HTML>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Ajuste de Stock</title>
</head>

<body>
    <div>
        Reporte de Ajuste de Stock
    </div>
    <div align="center">
        Cantidad de Ajustes:
        <?php echo $count; ?>
    </div>
    <hr>

    <div id="tabla">
        <table width="100%" border="0.3" cellpadding="0" cellspacing="0" align="center">
            <thead style="background:#e8ecee">
                <tr class="table-title">
                    <th height="20" align="center" valign="middle"><small>Cód. Depósito</small></th>
                    <th height="30" align="center" valign="middle"><small>Depósito</small></th>
                    <th height="30" align="center" valign="middle"><small>Tipo. Prod.</small></th>
                    <th height="30" align="center" valign="middle"><small>Producto</small></th>
                    <th height="30" align="center" valign="middle"><small>U. Medida</small></th>
                    <th height="30" align="center" valign="middle"><small>Cant. Actual</small></th>
                    <th height="30" align="center" valign="middle"><small>Cant. Ajuste</small></th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($data = mysqli_fetch_assoc($result)) {
                    $cod_depo = $data['cod_deposito'];
                    $deposito = $data['descrip'];
                    $t_p_descrip = $data['t_p_descrip'];
                    $producto = $data['p_descrip'];
                    $u_medida = $data['u_descrip'];
                    $id_ajuste = $data['id_ajuste_stock'];
                    $cantidad_ajuste = $data['cantidad'];

                    // Consulta SQL para obtener la cantidad actual del producto desde la tabla de stock
                    $consulta_cantidad_actual = "SELECT cantidad FROM v_stock WHERE cod_producto = ? AND cod_deposito = ?";
                    $stmt_cantidad_actual = mysqli_prepare($mysqli, $consulta_cantidad_actual);
                    mysqli_stmt_bind_param($stmt_cantidad_actual, "ii", $data['cod_producto'], $cod_depo);
                    mysqli_stmt_execute($stmt_cantidad_actual);
                    $result_cantidad_actual = mysqli_stmt_get_result($stmt_cantidad_actual);
                    $data_cantidad_actual = mysqli_fetch_assoc($result_cantidad_actual);
                    $cantidad_actual = $data_cantidad_actual['cantidad'];

                    // Estilo para cambiar el color de la cantidad
                    $cantidad_estilo = ($cantidad_ajuste < 0) ? 'color: red; font-weight: bold;' : 'color: green; font-weight: bold;';
                    echo "<tr>
                            <td width='80' align='center'>$cod_depo</td>
                            <td width='80' align='center'>$deposito</td>
                            <td width='80' align='center'>$t_p_descrip</td>
                            <td width='150' align='center'>$producto</td>
                            <td width='80' align='center'>$u_medida</td>
                            <td width='80' align='center'>$cantidad_actual</td>
                            <td width='80' align='center'style='$cantidad_estilo'>$cantidad_ajuste</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>