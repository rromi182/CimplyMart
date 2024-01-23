<?php
session_start();
require "../../config/database.php";

//Para evitar que ingrese con el URL sin iniciar sesión
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
    exit();
} else {
    if ($_GET['act'] == 'insert') {
        //traemos los datos del formulario
        $username = mysqli_real_escape_string($mysqli, trim($_POST['username']));
        $name_user = mysqli_real_escape_string($mysqli, trim($_POST['name_user']));
        $password = mysqli_real_escape_string($mysqli, trim($_POST['password']));
        $email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
        $telefono = mysqli_real_escape_string($mysqli, trim($_POST['telefono']));
        $permisos_acceso = mysqli_real_escape_string($mysqli, trim($_POST['permisos_acceso']));

        $query = mysqli_query($mysqli, "INSERT INTO usuarios (username, name_user, password, email, telefono, permisos_acceso)
                                        VALUES ('$username', '$name_user', '$password', '$email', '$telefono', '$permisos_acceso')")
            or die('error' . mysqli_error($mysqli));

        if ($query) {
            header("Location: view.php?alert=1");
        }
    } elseif ($_GET['act'] == 'update') {
        if (isset($_POST['Guardar'])) {
            if (isset($_POST['id_user'])) {
                $id_user = mysqli_real_escape_string($mysqli, trim($_POST['id_user']));
                $username = mysqli_real_escape_string($mysqli, trim($_POST['username']));
                $name_user = mysqli_real_escape_string($mysqli, trim($_POST['name_user']));
                //$password = mysqli_real_escape_string($mysqli, trim($_POST['password']));
                $foto = $_FILES['foto']['name'];
                $email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
                $telefono = mysqli_real_escape_string($mysqli, trim($_POST['telefono']));
                $permisos_acceso = mysqli_real_escape_string($mysqli, trim($_POST['permisos_acceso']));

                //Parametros para insertar una imagen
                $name_file = $_FILES['foto']['name'];
                $size_file = $_FILES['foto']['size'];
                $type_file = $_FILES['foto']['type'];
                $tmp_file = $_FILES['foto']['tmp_name'];

                $allowed_extensions = array('jpg', 'jpeg', 'png');

                //ruta donde irá el archivo subido
                $path_file = "../../images/user/" . $name_file;

                $file = explode(".", $name_file);
                $extension = array_pop($file);

                if (empty($_FILES['foto']['name'])) {
                    $query = mysqli_query($mysqli, "UPDATE usuarios SET username = '$username',
                                                                       name_user = '$name_user',
                                                                       email = '$email',
                                                                       telefono = '$telefono',
                                                                       permisos_acceso = '$permisos_acceso'
                                                                       WHERE id_user = '$id_user'")
                        or die('error' . mysqli_error($mysqli));
                    if ($query) {
                        header("Location: view.php?alert=2");
                    }
                } 
                
                elseif (!empty($_FILES['foto']['name'])) {
                    if (in_array($extension, $allowed_extensions)) {

                        if ($size_file <= 1000000) {
                            if (move_uploaded_file($tmp_file, $path_file)) {
                                $query = mysqli_query($mysqli, "UPDATE usuarios SET username = '$username',
                                                                       name_user = '$name_user',
                                                                       email = '$email',
                                                                       telefono = '$telefono',
                                                                       foto = '$name_file',
                                                                       permisos_acceso = '$permisos_acceso'
                                                                       WHERE id_user = '$id_user'")
                                    or die('error' . mysqli_error($mysqli));
                                if ($query) {
                                    header("Location: view.php?alert=2");
                                }
                            }
                        } else {
                            header("Location: view.php?alert=5");
                        }
                    } else {
                        header("Location: view.php?alert=6");
                    }
                } else {
                    header("Location: view.php?alert=7");
                }
            }
        }
    } 
    
    elseif ($_GET['act'] == 'on') {
        if (isset($_GET['id'])) {
            $id_user = $_GET['id'];
            $status = "activo";
            $intentos = 0;

            $query = mysqli_query($mysqli, "UPDATE usuarios SET status = '$status', intentos = $intentos
                                            WHERE id_user = '$id_user'")
                or die('error' . mysqli_error($mysqli));

            if ($query) {
                header("Location: view.php?alert=3");
            }
        }
    } 
    
    elseif ($_GET['act'] == 'off') {
        if (isset($_GET['id'])) {
            $id_user = $_GET['id'];
            $status = "bloqueado";

            $query = mysqli_query($mysqli, "UPDATE usuarios SET status = '$status' 
                                            WHERE id_user = '$id_user'")
                or die('error' . mysqli_error($mysqli));

            if ($query) {
                header("Location: view.php?alert=4");
            }
        }
    }
}

?>