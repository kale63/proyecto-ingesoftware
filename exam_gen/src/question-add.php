<?php
include_once __DIR__.'/database.php';

$pregunta = file_get_contents('php://input');
$data = array(
    'status'  => 'error',
    'message' => 'Error al insertar la pregunta'
);

if(!empty($pregunta)) {
    $jsonOBJ = json_decode($pregunta);

    if(json_last_error() === JSON_ERROR_NONE) {
        $sql = "INSERT INTO reactivos (area, definicion, base, imagen) 
                VALUES ('{$jsonOBJ->area}', '{$jsonOBJ->definicion}', '{$jsonOBJ->base}', '{$jsonOBJ->imagen}')";

        if ($conexion->query($sql)) {
            $id_reactivo = $conexion->insert_id;
            $data['status'] = "success";
            $data['message'] = "Pregunta agregada con ID: $id_reactivo";

            foreach ($jsonOBJ->opciones as $opcion) {
                $esta_correcta = ($opcion->valor === 'correcta') ? 1 : 0;
            
                $stmt_respuesta = $conexion->prepare("INSERT INTO respuestas (id_reactivo, texto_opcion, esta_correcta, justificacion) 
                                                      VALUES (?, ?, ?, ?)");
            
                if ($stmt_respuesta) {
                    $stmt_respuesta->bind_param("isis", $id_reactivo, $opcion->texto, $esta_correcta, $opcion->argumentacion);
            
                    if (!$stmt_respuesta->execute()) {
                        $data['message'] = "ERROR al insertar respuesta: " . $stmt_respuesta->error;
                    }
            
                    $stmt_respuesta->close();
                } else {
                    $data['message'] = "Error al preparar la declaración para respuestas.";
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
