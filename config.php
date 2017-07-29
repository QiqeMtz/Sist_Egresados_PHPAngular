<?php
/*
  Clase para configurar la conexion con la base de datos en Mysql
*/

  define('DB_HOST', 'localhost');
  define('DB_NAME', 'escuela');
  define('DB_USERNAME', 'root');
  define('DB_PASSWORD', '1111');

  $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
  if (mysqli_connect_errno()) {
    # code...
    echo("Error al intentar conectar con la base de datos, el mensaje de error es: ". mysqli_connect_error());
    exit();
  }
 ?>
