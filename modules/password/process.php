<?php 
session_start();

require "../../config/database.php";


//Para evitar que ingrese con el URL sin iniciar sesión
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
    exit();
}else{
    if($_POST){
        if($_SESSION['id_user']){
            $old_pass = md5(mysqli_real_escape_string($mysqli, trim($_POST['old_pass'])));
            $new_pass = md5(mysqli_real_escape_string($mysqli, trim($_POST['new_pass'])));
            $retype_pass = md5(mysqli_real_escape_string($mysqli, trim($_POST['retype_pass'])));

            $id_user = $_SESSION['id_user'];

            $sql = mysqli_query($mysqli, "SELECT password FROM usuarios WHERE id_user=$id_user") 
            or die('error'.mysqli_error($mysqli));

            $data = mysqli_fetch_assoc($sql); //se guarda en un array la consulta

            if($old_pass != $data['password']){
                header("Location: view.php?alert=1");
            }else{
                if($new_pass != $retype_pass){
                    header("Location: view.php?alert=2");
                }else{ //UPDATE PASSWORD
                    $query = mysqli_query ($mysqli,"UPDATE usuarios SET password = '$new_pass' WHERE id_user = $id_user ")
                                            or die('error'.mysqli_error($mysqli));
                    
                    if($query){
                        header("Location: view.php?alert=3");
                    }
                }
            }
        }
    }
}

?>