<?php
include_once __DIR__.'/database.php';

$pregunta = file_get_contents('php://input');
$data = array(
    'status'  => 'error',
    'message' => 'Error al insertar la pregunta'
);

if(!empty($pregunta)) {
    $jsonOBJ = json_decode($pregunta);

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if(json_last_error() === JSON_ERROR_NONE) {
        $sql = "UPDATE reactivos SET area = '{$jsonOBJ->area}', definicion = '{$jsonOBJ->definicion}', base = '{$jsonOBJ->base}', imagen = '{$jsonOBJ->imagen}' WHERE id = {$id}";

        if ($conexion->query($sql)) {
            foreach ($jsonOBJ->opciones as $opcion) {
                $esta_correcta = ($opcion->valor === 'correcta') ? 1 : 0;

                $sql_respuesta = "UPDATE respuestas SET texto_opcion = '{$opcion->texto}',esta_correcta = $esta_correcta, justificacion = '{$opcion->argumentacion}' WHERE id_reactivo = {$id}";

                if (!$conexion->query($sql_respuesta)) {
                    $data['message'] = "ERROR al insertar respuesta: " . mysqli_error($conexion);
                }
            }
        } else {
            $data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($conexion);
        }
    } else {
        $data['message'] = "El formato del JSON no es válido: " . json_last_error_msg();
    }

    $conexion->close();
}

echo json_encode($data, JSON_PRETTY_PRINT);