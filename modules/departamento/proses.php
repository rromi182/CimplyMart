<?php 

session_start();
require_once "../../config/database.php";

if(empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=" . $url_base . "/?alert=3'>";
}
else {
    if($_GET['act']=='insert'){
        if(isset($_POST['Guardar'])){
            $codigo = $_POST['codigo'];
            $dep_descripcion = $_POST['dep_descripcion'];

            $query = mysqli_query($mysqli, "INSERT INTO departamento (id_departamento, dep_descripcion)
            VALUES ($codigo, '$dep_descripcion')") or die('Error'.mysqli_error($mysqli));
            
            if($query){
                header("Location: view.php?alert=1");
            } else {
                header("Location: view.php?alert=4");
            }

        }
    }
    elseif($_GET['act']=='update'){
        if(isset($_POST['Guardar'])){
            if(isset($_POST['codigo'])){
                $codigo = $_POST['codigo'];
                $dep_descripcion = $_POST['dep_descripcion'];
                
                $query = mysqli_query($mysqli, "UPDATE departamento SET dep_descripcion = '$dep_descripcion'
                                                                    WHERE id_departamento = $codigo")
                                                                    or die('Error'.mysqli_error($mysqli));

                if($query){
                    header("Location: view.php?alert=2");
                } else {
                header("Location: view.php?alert=4");
                }                                                    
            }
        }

    }
    elseif($_GET['act']=='delete'){
        if(isset($_GET['id_departamento'])){
            $codigo = $_GET['id_departamento'];

            $query = mysqli_query($mysqli, "DELETE FROM departamento
                                            WHERE id_departamento = $codigo")
                                            or die('Error'.mysqli_error($mysqli));
            if($query){
                header("Location: view.php?alert=3");
            } else {
                header("Location: view.php?alert=4");
            }
        }
    }


}

?>