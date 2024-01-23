<?php 
require_once "../../config/database.php";

$query = mysqli_query($mysqli, "SELECT cod_ciudad, descrip_ciudad, 
dep.id_departamento, dep.dep_descripcion
FROM ciudad ciu
JOIN departamento dep
WHERE ciu.id_departamento=dep.id_departamento")
    or die('Error'.mysqli_error($mysqli));

$count = mysqli_num_rows($query);    
?>

<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de Ciudad</title>
    </head>
    <body>
        <div>
            Reporte de ciudad
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
                        <th height="30" align="center" valign="middle"><small>Departamento</small></th>                      
                        <th height="30" align="center" valign="middle"><small>Ciudad</small></th>                      
                    </tr>
                </thead>
                <tbody>
                <?php
                    while ($data = mysqli_fetch_assoc($query)){
                        $codigo = $data['cod_ciudad'];
                        $dep_descripcion = $data['dep_descripcion'];
                        $descrip_ciudad = $data['descrip_ciudad'];

                        echo "<tr>
                        <td width='100' align='left'>$codigo</td>
                        <td width='150' align='left'>$dep_descripcion</td>
                        <td width='150' align='left'>$descrip_ciudad</td>
                        </tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </body>
</html>