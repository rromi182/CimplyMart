<?php
session_start();
require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
} else {
    if ($_GET['act'] == 'insert') {
        if (isset($_POST['Guardar'])) {
            $codigo = $_POST['codigo'];
            $dep_descripcion = trim($_POST['dep_descripcion']);

            if (empty($dep_descripcion)) {
                header("Location: view.php?alert=4");
                exit();
            }

            // Validar la existencia del Depósito
            $validacionDescrip = mysqli_query($mysqli, "SELECT * FROM deposito WHERE descrip = '$dep_descripcion'");
            $existe = mysqli_fetch_assoc($validacionDescrip);

            if (!$existe) {
                $query = mysqli_query($mysqli, "INSERT INTO deposito (cod_deposito, descrip)
                VALUES ($codigo, '$dep_descripcion')") or die('Error' . mysqli_error($mysqli));

                if ($query) {
                    header("Location: view.php?alert=1");
                } else {
                    header("Location: view.php?alert=4");
                }
            } else {
                // Description already exists, handle accordingly
                header("Location: view.php?alert=5");
            }
        }
    } elseif ($_GET['act'] == 'update') {
        if (isset($_POST['Guardar'])) {
            if (isset($_POST['codigo'])) {
                $codigo = $_POST['codigo'];
                $dep_descripcion = $_POST['dep_descripcion'];


                $validacionDescrip = mysqli_query($mysqli, "SELECT * FROM deposito WHERE descrip = '$dep_descripcion' AND cod_deposito <> $codigo");
                $existe = mysqli_fetch_assoc($validacionDescrip);

                if (!$existe) {

                    $query = mysqli_query($mysqli, "UPDATE deposito SET descrip = '$dep_descripcion'
                                                                    WHERE cod_deposito = $codigo")
                        or die('Error' . mysqli_error($mysqli));

                    if ($query) {
                        header("Location: view.php?alert=2");
                    } else {
                        header("Location: view.php?alert=4");
                    }
                } else {
                    header("Location: view.php?alert=5");
                }
            }
        }
    } elseif ($_GET['act'] == 'delete') {
        if (isset($_GET['cod_deposito'])) {
            $codigo = $_GET['cod_deposito'];

            $query = mysqli_query($mysqli, "DELETE FROM deposito
                                            WHERE cod_deposito = $codigo")
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