<?php
session_start();
require_once '../config/database.php';

if(isset($_POST['id']) && isset($_POST['cantidad']) && isset($_POST['deposito'])){
    $id = $_POST['id'];
    $cantidad = $_POST['cantidad'];
    $deposito_code = $_POST['deposito'];


    //verificar cantidad en el stock
    $stock_query = mysqli_query($mysqli, "SELECT cantidad FROM v_stock WHERE cod_producto = $id AND cod_deposito = $deposito_code");
    $stock_data = mysqli_fetch_assoc($stock_query);
    
    if ($stock_data['cantidad'] >= $cantidad) {
        echo "ok"; 
    } else {
        echo "not_enough";
    }
}
?>