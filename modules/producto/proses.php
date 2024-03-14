<?php
session_start();
require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=alert=3'>";
} else {
    if ($_GET['act'] == 'insert') {
        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
            $tipo_producto = $_POST['tipo_producto'];
            $u_medida = $_POST['u_medida'];
            $p_descrip = trim($_POST['p_descrip']);
            $precio = trim($_POST['precio']);

            if (empty($p_descrip) || empty($precio)) {
                header("Location: view.php?alert=4");
                exit();
            }

            // Verificar si ya existe un producto con la misma descripción, tipo y unidad de medida
            $verificarProducto = mysqli_query($mysqli, "SELECT * FROM producto WHERE p_descrip = '$p_descrip' AND cod_tipo_prod = $tipo_producto AND id_u_medida = $u_medida");
            $existe = mysqli_fetch_assoc($verificarProducto);

            if (!$existe) {
                // No hay un producto existente
                $query = mysqli_query($mysqli, "INSERT INTO producto (cod_producto, cod_tipo_prod, id_u_medida, p_descrip, precio)
                VALUES ($codigo, $tipo_producto, $u_medida, '$p_descrip', $precio)") or die('Error' . mysqli_error($mysqli));

                if ($query) {
                    header("Location: view.php?alert=1");
                } else {
                    header("Location: view.php?alert=4");
                }
            } else {
                // Ya existe un producto con la misma descripción, tipo y unidad de medida
                header("Location: view.php?alert=5");
            }
        }
    } elseif ($_GET['act'] == 'update') {
        if (isset($_POST['Guardar'])) {
            if (isset($_POST['codigo'])) {
                $codigo = $_POST['codigo'];
                $tipo_producto = $_POST['tipo_producto'];
                $u_medida = $_POST['u_medida'];
                $p_descrip = trim($_POST['p_descrip']);
                $precio = trim($_POST['precio']);

                if (empty($p_descrip) || empty($precio)) {
                    header("Location: view.php?alert=4");
                    exit();
                }
                // Verificar si ya existe otro producto con la misma descripción, tipo y unidad de medida
                $verificarProducto = mysqli_query($mysqli, "SELECT * FROM producto WHERE p_descrip = '$p_descrip' AND cod_tipo_prod = $tipo_producto AND id_u_medida = $u_medida AND cod_producto <> $codigo");
                $existe = mysqli_fetch_assoc($verificarProducto);

                if (!$existe) {
                    // No hay otro producto existente con la misma descripción, tipo y unidad de medida
                    $query = mysqli_query($mysqli, "UPDATE producto SET p_descrip = '$p_descrip',
                                                                        cod_tipo_prod = $tipo_producto,
                                                                        id_u_medida = $u_medida,
                                                                        precio = $precio
                                                                        WHERE cod_producto = $codigo")
                        or die('Error' . mysqli_error($mysqli));

                    if ($query) {
                        header("Location: view.php?alert=2");
                    } else {
                        header("Location: view.php?alert=4");
                    }
                } else {
                    // Ya existe otro producto con la misma descripción, tipo y unidad de medida
                    header("Location: view.php?alert=5");
                }
            }
        }
    } elseif ($_GET['act'] == 'delete') {
        if (isset($_GET['cod_producto'])) {
            $codigo = $_GET['cod_producto'];

            $query = mysqli_query($mysqli, "DELETE FROM producto
                                            WHERE cod_producto = $codigo")
                or die('Error' . mysqli_error($mysqli));
            if ($query) {
                header("Location: view.php?alert=3");
            } else {
                header("Location: view.php?alert=4");
            }
        }
    }
}
