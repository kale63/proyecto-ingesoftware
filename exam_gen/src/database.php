<?php
    $conexion = @mysqli_connect(
        'localhost',
        'root',
        '',
        'examen_practica'
    );

    if(!$conexion) {
        die('Base de datos NO conectada!');
    }
?>