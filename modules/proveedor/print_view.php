<?php
require_once "../../config/database.php";
if ($_GET['act'] == 'imprimir') {


    $query = mysqli_query($mysqli, "SELECT * FROM proveedor")
        or die('Error' . mysqli_error($mysqli));

    $count = mysqli_num_rows($query);
}
?>

<!DOCTYPE HTML>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title> Reporte de Proveedores</title>
</head>

<body>
    <div align='center'>
        <h2> Reporte de Proveedores</h2><br>
    </div>
    <hr>
    <div>
        <table width="100%" border="0.3" cellpadding="0" cellspacing="0" align="center">
            <thead style="background:#e8ecee">
                <tr class="tabla-title">
                    <th height="20" align="center" valign="middle">Código</th>
                    <th height="20" align="center" valign="middle">Proveedor</th>
                    <th height="20" align="center" valign="middle">RUC</th>
                    <th height="20" align="center" valign="middle">Direccion</th>
                    <th height="20" align="center" valign="middle">Telefono</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($data2 = mysqli_fetch_assoc($query)) {
                    $cod_prov = $data2['cod_proveedor'];
                    $razon_social = $data2['razon_social'];
                    $ruc = $data2['ruc'];
                    $direccion = $data2['direccion'];
                    $telefono = $data2['telefono'];
                    echo "<tr>
                    <td width='50'>$cod_prov</td>
                    <td width='150'>$razon_social</td>
                    <td width='80'>$ruc</td>
                    <td width='200'>$direccion</td>
                    <td width='100'>$telefono</td>
                                      </tr> ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>