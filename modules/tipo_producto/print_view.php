<?php 
    require_once "../../config/database.php";
    if($_GET['act']=='imprimir'){


            $query = mysqli_query($mysqli, "SELECT * FROM tipo_producto")
            or die('Error'.mysqli_error($mysqli));
        
        $count = mysqli_num_rows($query);    }
?> 

<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title> Reporte de T. Productos</title>
    </head>
    <body>
        <div align='center'>
       <h2> Reporte de T. Productos</h2><br>
        </div>
        <hr>
            <div>
                <table width="100%" border="0.3" cellpadding="0" cellspacing="0" align="center">
                    <thead style="background:#e8ecee">
                        <tr class="tabla-title">
                            <th height="20" align="center" valign="middle"><small>Codigo</small></th>
                            <th height="20" align="center" valign="middle"><small>Tipo Producto</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            while ($data2 = mysqli_fetch_assoc($query)){
                                $id_departamento = $data2['cod_tipo_prod'];
                                $descrip = $data2['t_p_descrip'];

                                echo "<tr>
                                        <td width='100' align='left'>$id_departamento</td>
                                        <td width='200' align='left'>$descrip</td>
                                      </tr> ";
                            }                        
                            ?>
                    </tbody>
                </table>         
            </div>
    </body>
</html>
