<?php

session_start();
require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
} else {
    if ($_GET['act'] == 'insert') {
        if (isset($_POST['Guardar'])) {
            $cod_proveedor = $_POST['cod_proveedor'];
            $razon_social = trim($_POST['razon_social']);
            $ruc = trim($_POST['ruc']);
            $direccion = trim($_POST['direccion']);
            $telefono = trim($_POST['telefono']);

            if (empty($razon_social) || empty($ruc) || empty($direccion) || empty($telefono)) {
                header("Location: view.php?alert=4");
                exit();
            }

            // Verificar si el RUC ya existe
            $validarDatos = mysqli_query($mysqli, "SELECT cod_proveedor FROM proveedor WHERE ruc = '$ruc' OR telefono = '$telefono' OR razon_social = '$razon_social'");
            $existe = mysqli_fetch_assoc($validarDatos);

            if ($existe) {
                // El RUC ya existe, mostrar mensaje de error o redireccionar a otra página
                header("Location: view.php?alert=5");
                exit();
            }

            $query = mysqli_query($mysqli, "INSERT INTO proveedor (cod_proveedor, razon_social, ruc,direccion, telefono )
            VALUES ($cod_proveedor, '$razon_social', '$ruc', '$direccion', $telefono )") or die('Error' . mysqli_error($mysqli));

            if ($query) {
                header("Location: view.php?alert=1");
            } else {
                header("Location: view.php?alert=4");
            }

        }
    } elseif ($_GET['act'] == 'update') {
        if (isset($_POST['Guardar'])) {
            if (isset($_POST['cod_proveedor'])) {
                $cod_proveedor = $_POST['cod_proveedor'];
    
                // Obtener los valores actuales de la base de datos
                $query_get_values = mysqli_query($mysqli, "SELECT razon_social, ruc, direccion, telefono FROM proveedor WHERE cod_proveedor = $cod_proveedor");
                $current_values = mysqli_fetch_assoc($query_get_values);
    
                // Obtener los valores del formulario (o usar los valores actuales si no se proporcionan en el formulario)
                $razon_social = isset($_POST['razon_social']) ? $_POST['razon_social'] : $current_values['razon_social'];
                $ruc = isset($_POST['ruc']) ? $_POST['ruc'] : $current_values['ruc'];
                $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : $current_values['direccion'];
                $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : $current_values['telefono'];
    
                // Verificar si el RUC, teléfono o razón social ya existe
                $validarDatos = mysqli_query($mysqli, "SELECT cod_proveedor FROM proveedor WHERE (ruc = '$ruc' OR telefono = '$telefono' OR razon_social = '$razon_social') AND cod_proveedor != $cod_proveedor");
                $existe = mysqli_fetch_assoc($validarDatos);
    
                if ($existe) {
                    // El RUC, teléfono o razón social ya existe en otro proveedor
                    header("Location: view.php?alert=5");
                    exit();
                }
    
                // Actualizar solo los campos que se proporcionaron en el formulario
                $query = mysqli_query($mysqli, "UPDATE proveedor SET razon_social = '$razon_social',
                                                                     ruc = '$ruc',
                                                                     direccion = '$direccion',
                                                                     telefono = '$telefono'
                                                                    WHERE cod_proveedor = $cod_proveedor")
                    or die('Error' . mysqli_error($mysqli));
    
                if ($query) {
                    header("Location: view.php?alert=2");
                } else {
                    header("Location: view.php?alert=4");
                }
            }
        }
    } elseif ($_GET['act'] == 'delete') {
        if (isset($_GET['cod_proveedor'])) {
            $cod_proveedor = $_GET['cod_proveedor'];

            $query = mysqli_query($mysqli, "DELETE FROM proveedor
                                            WHERE cod_proveedor = $cod_proveedor")
                or die('Error' . mysqli_error($mysqli));
            if ($query) {
                header("Location: view.php?alert=3");
            } else {
                header("Location: view.php?alert=4");
            }
        }
    }


}

?>