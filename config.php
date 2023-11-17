<?php
$host="localhost";
$user="root";
$password="";
$db="trabajo integrador";
$conexion= new mysqli($host,$user,$password,$db);
if($conexion->connect_errno){
echo "falla de conexion en la base de datos";
}
?>