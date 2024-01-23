<?php 
session_start();
$session_id = session_id();
//Treaemos los datos del modal
if(isset($_POST['id'])){$id=$_POST['id'];}
if(isset($_POST['cantidad'])){$cantidad = $_POST['cantidad'];}
if(isset($_POST['precio_compra_'])){$precio_compra_ = $_POST['precio_compra_'];}

require_once '../config/database.php';

if(!empty($id) and !empty($cantidad) and !empty($precio_compra_)){
    $insert_tmp = mysqli_query($mysqli, "INSERT INTO tmp (id_producto, cantidad_tmp, precio_tmp, session_id) 
    VALUES('$id', '$cantidad', '$precio_compra_','$session_id')");
}
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete = mysqli_query($mysqli, "DELETE FROM tmp WHERE id_tmp = '".$id."'");
}
?>
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
        $suma_total=0;
        $sql=mysqli_query($mysqli, "SELECT * FROM producto, tmp WHERE producto.cod_producto=tmp.id_producto and tmp.session_id='".$session_id."'");
        while($row=mysqli_fetch_array($sql)){
            $id_tmp=$row['id_tmp'];
            $codigo_producto=$row['cod_producto'];
            $descrip_producto=$row['p_descrip'];
            $cantidad=$row['cantidad_tmp'];

            $codigo_tproducto=$row['cod_tipo_prod'];
            $sql_tproducto = mysqli_query($mysqli, "SELECT t_p_descrip FROM tipo_producto WHERE cod_tipo_prod='$codigo_tproducto'");
            $rw_tproducto = mysqli_fetch_array($sql_tproducto);
            $tproducto_nombre= $rw_tproducto['t_p_descrip'];

            $id_u_medida=$row['id_u_medida'];
            $sql_umedida = mysqli_query($mysqli, "SELECT u_descrip FROM u_medida WHERE id_u_medida='$id_u_medida'");
            $rw_u_medida = mysqli_fetch_array($sql_umedida);
            $u_medida_nombre= $rw_u_medida['u_descrip'];

            $precio_compra_=$row['precio_tmp'];
            $precio_compra_f=number_format($precio_compra_); //Formatear una variable (Poner ,)
            $precio_compra_r=str_replace(",","",$precio_compra_f);//Reemplazar la ,
            $precio_total=$precio_compra_r*$cantidad;
            $precio_total_f=number_format($precio_total);
            $precio_total_r=str_replace(",","",$precio_total_f);
            $suma_total+=$precio_total_r; //Sumador total
            ?>
            <tr>
                <td><?php echo $codigo_producto; ?></td>
                <td><?php echo $tproducto_nombre; ?></td>
                <td><?php echo $u_medida_nombre; ?></td>
                <td><?php echo $descrip_producto; ?></td>
                <td><span class="pull-right"><?php echo $cantidad; ?></span></td>
                <td><span class="pull-right"><?php echo $precio_total_f; ?></span></td>
                <td><span class="pull-right"><a href="#" onclick="eliminar('<?php echo $id_tmp; ?>')"><i class="fa fa-trash"></i></a></span></td>
            </tr>
       <?php }           
    ?>
            <tr>
                <input type="hidden" class="form-control" name="suma_total" value="<?php echo $suma_total; ?>">
                <?php if(empty($codigo_producto)){
                    $codigo_producto=0;
                }else {
                    $codigo_producto;
                } ?>
                <input type="hidden" class="form-control" name="codigo_producto" value="<?php echo $codigo_producto; ?>">
                <?php if(empty($cantidad)){
                    $cantidad=0;
                }else {
                    $cantidad;
                } ?>
                <input type="hidden" class="form-control" name="cantidad" value="<?php echo $cantidad; ?>">
                <td colspan=5><span class="pull-right">Total Gs.</span></td>
                <td><stron><span class="pull-right"><?php echo number_format($suma_total); ?></span></strong></td>
            </tr>
</table>
