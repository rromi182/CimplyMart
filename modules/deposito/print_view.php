<?php 
    require_once "../../config/database.php";
    if($_GET['act']=='imprimir'){


            $query = mysqli_query($mysqli, "SELECT * FROM deposito")
            or die('Error'.mysqli_error($mysqli));
        
        $count = mysqli_num_rows($query);    }
?> 

<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title> Reporte de Depósitos</title>
    </head>
    <body>
        <div align='center'>
       <h2> Reporte de Depósitos</h2><br>
        </div>
        <hr>
            <div>
                <table width="100%" border="0.3" cellpadding="0" cellspacing="0" align="center">
                    <thead style="background:#e8ecee">
                        <tr class="tabla-title">
                            <th height="20" align="center" valign="middle"><small>Codigo</small></th>
                            <th height="20" align="center" valign="middle"><small>Depósito</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            while ($data2 = mysqli_fetch_assoc($query)){
                                $id_departamento = $data2['cod_deposito'];
                                $descrip = $data2['descrip'];

                                echo "<tr>
                                        <td width='100' align='left'>$id_departamento</td>
                                        <td width='80' align='left'>$descrip</td>
                                      </tr> ";
                            }                        
                            ?>
                    </tbody>
                </table>         
            </div>
    </body>
</html>
