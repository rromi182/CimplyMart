<?php 
session_start();
require "../../config/database.php";

//Para evitar que ingrese con el URL sin iniciar sesión
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
    exit();
}
else{
    if($_GET['act']=='update'){
        if(isset($_POST['Guardar'])){
            if(isset($_POST['id_user'])){
                $id_user      = mysqli_real_escape_string($mysqli, trim($_POST['id_user']));
                $username     = mysqli_real_escape_string($mysqli, trim($_POST['username']));
                $name_user    = mysqli_real_escape_string($mysqli, trim($_POST['name_user']));
                $email        = mysqli_real_escape_string($mysqli, trim($_POST['email']));
                $telefono     = mysqli_real_escape_string($mysqli, trim($_POST['telefono']));

                $name_file    = $_FILES['foto']['name'];  
                $tamano_file    = $_FILES['foto']['size'];
                $type_file    = $_FILES['foto']['type'];   
                $tmp_file    = $_FILES['foto']['tmp_name'];   

                $allowed_extensions = array('jpg','jpeg','png');

                $path_file  ="../../images/user/".$name_file;

                $file = explode(".",$name_file);
                $extension = array_pop($file);

                if(empty($_FILES['foto']['name'])){
                    $query = mysqli_query($mysqli, "UPDATE usuarios SET username    = '$username',
                                                                        name_user   = '$name_user',
                                                                        email       = '$email',
                                                                        telefono    = '$telefono'
                                                                    WHERE id_user   = '$id_user'")
                                                                    or die('Error'.mysqli_error($mysqli));
                    if($query){
                        header("Location: view.php?alert=1");
                    }
                }
                else{
                    if(in_array($extension, $allowed_extensions)){
                        if($tamano_file <=1000000){
                            if(move_uploaded_file($tmp_file, $path_file)){
                                $query = mysqli_query($mysqli, "UPDATE usuarios SET username    = '$username',
                                                                        name_user   = '$name_user',
                                                                        email       = '$email',
                                                                        telefono    = '$telefono',
                                                                        foto        = '$name_file'
                                                                    WHERE id_user   = '$id_user'")
                                                                            or die('Error'.mysqli_error($mysqli));
                                if($query){
                                    header("Location: view.php?alert=1");
                                }
                            } else{
                                header("Location: view.php?alert=2");
                            }
                        } else{
                            header("Location: view.php?alert=3");
                        }
                    }  else{
                        header("Location: view.php?alert=4");
                    }
                }
            }
        }
    }
}

?>