<?php

$host = 'localhost';
$user = 'userfac';
$password = '0(!8hM1Mz(iz0-St';
$db = 'facturacion';

$conection = @mysqli_connect($host,$user,$password,$db);

if(!$conection){
    echo "error en la conexion";

}