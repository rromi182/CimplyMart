<?php 

session_start();
require_once "../../config/database.php";

if(empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=alert=3>";
}
else {
    if($_GET['act']=='insert'){
        if(isset($_POST['Guardar'])){
            $codigo = $_POST['codigo'];
            $departamento = $_POST['departamento'];
            $descrip_ciudad = $_POST['descrip_ciudad'];

            $query = mysqli_query($mysqli, "INSERT INTO ciudad (cod_ciudad, id_departamento, descrip_ciudad)
            VALUES ($codigo, $departamento, '$descrip_ciudad')") or die('Error'.mysqli_error($mysqli));
            
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
                $departamento = $_POST['departamento'];
                $descrip_ciudad = $_POST['descrip_ciudad'];
                
                $query = mysqli_query($mysqli, "UPDATE ciudad SET descrip_ciudad = '$descrip_ciudad',
                                                                    id_departamento = $departamento
                                                                    WHERE cod_ciudad = $codigo")
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
        if(isset($_GET['cod_ciudad'])){
            $codigo = $_GET['cod_ciudad'];

            $query = mysqli_query($mysqli, "DELETE FROM ciudad
                                            WHERE cod_ciudad = $codigo")
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