<?php
session_start();
require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
} else {
    if ($_GET['act'] == 'insert') {
        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
            $u_descrip = trim($_POST['u_descrip']);

            if (empty($u_descrip)) {
                header("Location: view.php?alert=4");
                exit();
            }

            // Verificar si la descripción ya existe
            $validacionDescrip = mysqli_query($mysqli, "SELECT * FROM u_medida WHERE u_descrip = '$u_descrip'");
            $existe = mysqli_fetch_assoc($validacionDescrip);

            if (!$existe) {
                // La descripción no existe, proceder con la inserción
                $query = mysqli_query($mysqli, "INSERT INTO u_medida (id_u_medida, u_descrip)
                VALUES ($codigo, '$u_descrip')") or die('Error' . mysqli_error($mysqli));

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
                $u_descrip = trim($_POST['u_descrip']);

            if (empty($u_descrip)) {
                header("Location: view.php?alert=4");
                exit();
            }

                // Verificar si la descripción ya existe, excluyendo el registro actual
                $validacionDescrip = mysqli_query($mysqli, "SELECT * FROM u_medida WHERE u_descrip = '$u_descrip' AND id_u_medida <> $codigo");
                $existe = mysqli_fetch_assoc($validacionDescrip);

                if (!$existe) {
                    // La descripción no existe, proceder con la actualización
                    $query = mysqli_query($mysqli, "UPDATE u_medida SET u_descrip = '$u_descrip'
                                                        WHERE id_u_medida = $codigo")
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
        if (isset($_GET['id_u_medida'])) {
            $codigo = $_GET['id_u_medida'];

            $query = mysqli_query($mysqli, "DELETE FROM u_medida
                                            WHERE id_u_medida = $codigo")
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

?>