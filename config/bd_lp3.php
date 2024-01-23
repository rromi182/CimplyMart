<?php

$servidor="localhost:50";
$baseDeDatos="examen_lp3";
$usuario="root";
$contrasenia="";

try{

  $conexion = new PDO("mysql:localhost=$servidor;dbname=$baseDeDatos",$usuario,$contrasenia);
  

}  catch(Exception $ex) {
         
        echo $ex->getMessage();

    
    
    }
?>