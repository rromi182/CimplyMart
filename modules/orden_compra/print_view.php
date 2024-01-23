<?php 
    require_once "../../config/database.php";
    if($_GET['act']=='imprimir'){
        if(isset($_GET['id_orden_compra'])){
            $codigo = $_GET['id_orden_compra'];
            //Cabecera de compra
            $cabecera_pedido_compra = mysqli_query($mysqli, "SELECT * FROM v_orden_compra WHERE id_orden_compra = $codigo")
                                                    or die('Error'.mysqli_error($mysqli));
                                                    while($data = mysqli_fetch_assoc($cabecera_pedido_compra)){
                                                        $cod = $data['id_orden_compra'];
                                                        $fecha = $data['fecha_registro'];
                                                        $total_costo = $data['total_costo'];
                                                        $usuario = $data['name_user'];
                                                        $username = $data['username'];
                                                        $hora = $data['hora'];}
                                                        
            //Detalle de compra
            $pedido_compra_det = mysqli_query($mysqli, "SELECT * FROM v_orden_compra_det WHERE id_orden_compra =$codigo ")
                                                        or die('Error'.mysqli_error($mysqli));

        }
    }
?> 
<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title> Informe de Pedido de Com</title>
    </head>
    <body>
        <div align='center'>
            <h4>Informe Orden de Compra</h4><br>
            <label><strong>Fecha Registro: </strong><?php echo $fecha; ?></label><br>
            <label><strong>Hora: </strong><?php echo $hora; ?></label><br>
            <label><strong>Usuario: </strong><?php echo $usuario.", ".$username; ?></label>
        </div>
        <hr>
            <div>
                <table width="100%" border="0.3" cellpadding="0" cellspacing="0" align="center">
                    <thead style="background:#e8ecee">
                        <tr class="tabla-title">
                            <th height="20" align="center" valign="middle"><small>Tipo de Producto</small></th>
                            <th height="20" align="center" valign="middle"><small>Producto</small></th>
                            <th height="20" align="center" valign="middle"><small>Unidad de Medidaf</small></th>
                            <th height="20" align="center" valign="middle"><small>Cantidad</small></th>
                            <th height="20" align="center" valign="middle"><small>Precio Unit.</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            while ($data2 = mysqli_fetch_assoc($pedido_compra_det)){
                                $t_p_descrip = $data2['t_p_descrip'];
                                $p_descrip = $data2['p_descrip'];
                                $u_medida = $data2['u_descrip'];
                                $cantidad = $data2['cantidad'];
                                $costo = $data2['costo'];

                                echo "<tr>
                                        <td width='100' align='left'>$t_p_descrip</td>
                                        <td width='80' align='left'>$p_descrip</td>
                                        <td width='80' align='left'>$u_medida</td>
                                        <td width='80' align='left'>$cantidad</td>
                                        <td width='80' align='left'>$costo</td>
                                      </tr> ";
                            }                        
                            ?>
                    </tbody>
                </table>         
            </div>
            <hr>
            <div align='center'>
             <label> <strong>Total de la Orden de Compra: Gs. <?php echo number_format($total_costo); ?></strong></label> 
            </div>
    </body>
</html>
