<?php
header('Content-Type: application/json');
include_once __DIR__ . '../database.php';

$responseArray = ['success' => false];
$amount = isset($_GET['amount']) ? (int)$_GET['amount'] : 2; 

$questionsQuery = "SELECT id, base FROM reactivos WHERE eliminado = 0 ORDER BY RAND() LIMIT $amount";
$questionsResult = $conexion->query($questionsQuery);

if ($questionsResult && $questionsResult->num_rows > 0) {
    $questions = [];

    while ($questionRow = $questionsResult->fetch_assoc()) {
        $questionId = $questionRow['id'];
        
        // Fetch options along with justificacion
        $optionsQuery = "SELECT id_opcion, texto_opcion, esta_correcta, justificacion FROM respuestas WHERE id_reactivo = $questionId";
        $optionsResult = $conexion->query($optionsQuery);

        $options = [];
        if ($optionsResult && $optionsResult->num_rows > 0) {
            while ($optionRow = $optionsResult->fetch_assoc()) {
                $options[] = [
                    'id' => $optionRow['id_opcion'],
                    'texto_opcion' => $optionRow['texto_opcion'],
                    'correct' => (int)$optionRow['esta_correcta'],
                    'justificacion' => $optionRow['justificacion']
                ];
            }
        }

        if (!empty($options)) {
            $questions[] = [
                'id' => $questionRow['id'],
                'base' => $questionRow['base'],
                'options' => $options
            ];
        }
    }

    $responseArray = [
        'success' => true,
        'questions' => $questions
    ];
} else {
    $responseArray['message'] = 'No se encontraron preguntas.';
}

$conexion->close();
echo json_encode($responseArray, JSON_PRETTY_PRINT);
?>
