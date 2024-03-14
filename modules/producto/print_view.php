<?php 
require_once "../../config/database.php";

$query = mysqli_query($mysqli, "SELECT prod.cod_producto, prod.p_descrip, 
tp.t_p_descrip, um.u_descrip
FROM producto prod
JOIN tipo_producto tp ON prod.cod_tipo_prod = tp.cod_tipo_prod
JOIN u_medida um ON prod.id_u_medida = um.id_u_medida")
    or die('Error'.mysqli_error($mysqli));

$count = mysqli_num_rows($query);    
?>

<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de Productos</title>
    </head>
    <body>
        <div>
            Reporte de Productos
        </div>
        <div align="center">
            Cantidad: <?php echo $count; ?>
        </div>
        <hr>
        <div id="tabla">
        <table width="100%" border="0.3" cellpadding="0" cellspacing="0" align="center">
                <thead style="background:#e8ecee">
                    <tr class="table-title">
                        <th height="20" align="center" valign="middle"><small>Código</small></th>
                        <th height="30" align="center" valign="middle"><small>Producto</small></th>                      
                        <th height="30" align="center" valign="middle"><small>Tipo Prod.</small></th>   
                        <th height="30" align="center" valign="middle"><small>U. Medida</small></th>                    
                    </tr>
                </thead>
                <tbody>
                <?php
                    while ($data = mysqli_fetch_assoc($query)){
                        $codigo = $data['cod_producto'];
                        $producto = $data['p_descrip'];
                        $tipo_producto = $data['t_p_descrip'];
                        $u_medida = $data['u_descrip'];

                        echo "<tr>
                        <td width='100' align='left'>$codigo</td>
                        <td width='150' align='left'>$producto</td>
                        <td width='150' align='left'>$tipo_producto</td>
                        <td width='150' align='left'>$u_medida</td>
                        </tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </body>
</html>