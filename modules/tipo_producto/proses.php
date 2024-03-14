<?php
session_start();
require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
} else {
    if ($_GET['act'] == 'insert') {
        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
            $descripcion = trim($_POST['descripcion']);

            if(empty($descripcion)){
                header("Location: view.php?alert=4");
                exit();
            }

            // Verificar si la descripción ya existe
            $verificarDescrip = mysqli_query($mysqli, "SELECT * FROM tipo_producto WHERE t_p_descrip = '$descripcion'");
            $existe = mysqli_fetch_assoc($verificarDescrip);

            if (!$existe) {
                // La descripción no existe
                $query = mysqli_query($mysqli, "INSERT INTO tipo_producto (cod_tipo_prod, t_p_descrip)
                VALUES ($codigo, '$descripcion')") or die('Error' . mysqli_error($mysqli));

                if ($query) {
                    header("Location: view.php?alert=1");
                } else {
                    header("Location: view.php?alert=4");
                }
            } else {
                // La descripción ya existe
                header("Location: view.php?alert=5");
            }
        }
    } elseif ($_GET['act'] == 'update') {
        if (isset($_POST['Guardar'])) {
            if (isset($_POST['codigo'])) {
                $codigo = $_POST['codigo'];
                $descripcion = trim($_POST['descripcion']);

                if(empty($descripcion)){
                    header("Location: view.php?alert=4");
                    exit();
                }
                // Verificar si la descripción ya existe
                $verificarDescrip = mysqli_query($mysqli, "SELECT * FROM tipo_producto WHERE t_p_descrip = '$descripcion' AND cod_tipo_prod <> $codigo");
                $existe = mysqli_fetch_assoc($verificarDescrip);

                if (!$existe) {
                    // La descripción no existe
                    $query = mysqli_query($mysqli, "UPDATE tipo_producto SET t_p_descrip = '$descripcion'
                                                        WHERE cod_tipo_prod = $codigo")
                        or die('Error' . mysqli_error($mysqli));

                    if ($query) {
                        header("Location: view.php?alert=2");
                    } else {
                        header("Location: view.php?alert=4");
                    }
                } else {
                    // La descripción ya existe
                    header("Location: view.php?alert=5");
                }
            }
        }
    } elseif ($_GET['act'] == 'delete') {
        if (isset($_GET['cod_tipo_prod'])) {
            $codigo = $_GET['cod_tipo_prod'];

            $query = mysqli_query($mysqli, "DELETE FROM tipo_producto
                                            WHERE cod_tipo_prod = $codigo")
                or die('Error' . mysqli_error($mysqli));
            if ($query) {
                header("Location: view.php?alert=3");
            } else {
                header("Location: view.php?alert=4");
            }
        }
    }
}
