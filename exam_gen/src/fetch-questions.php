<?php
include_once __DIR__.'/database.php';

header('Content-Type: application/json; charset=utf-8');

$data = array(
    'status' => 'error',
    'message' => 'Error al obtener las preguntas',
    'questions' => []
);

try {
    $sql = "SELECT r.id, r.area, r.definicion, r.base, r.imagen, 
                   GROUP_CONCAT(CONCAT(rs.texto_opcion, '::', rs.esta_correcta, '::', rs.justificacion) SEPARATOR '||') as opciones
            FROM reactivos r
            LEFT JOIN respuestas rs ON r.id = rs.id_reactivo
            WHERE r.eliminado = 0
            GROUP BY r.id";

    $result = $conexion->query($sql);

    if ($result) {
        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $opciones_raw = explode('||', $row['opciones']);
            $opciones = [];
            foreach ($opciones_raw as $opcion) {
                list($texto, $valor, $justificacion) = explode('::', $opcion);
                $opciones[] = [
                    'texto' => $texto,
                    'valor' => $valor,
                    'argumentacion' => $justificacion
                ];
            }

            $questions[] = [
                'id' => $row['id'],
                'area' => $row['area'],
                'definicion' => $row['definicion'],
                'base' => $row['base'],
                'imagen' => $row['imagen'],
                'opciones' => $opciones
            ];
        }

        $data['status'] = 'success';
        $data['message'] = 'Preguntas obtenidas exitosamente';
        $data['questions'] = $questions;
    } else {
        $data['message'] = 'Error al ejecutar la consulta: ' . $conexion->error;
    }

} catch (Exception $e) {
    $data['message'] = 'Exception: ' . $e->getMessage();
}

$conexion->close();

echo json_encode($data, JSON_PRETTY_PRINT);
?>
