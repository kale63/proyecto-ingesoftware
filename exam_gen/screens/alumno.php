<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'student') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Examen</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <header class="text-center my-4">
        <h1>Generar un Examen de Práctica</h1>
    </header>

    <div class="container">
        <form action="display-exam.php" method="GET" id="generate-questions" class="my-4">
            <label for="question-amount" class="form-label">Número de Preguntas:</label>
            <input type="number" id="question-amount" name="question-amount" min="5" max="10" required class="form-control mb-3">
            <button type="submit" class="btn btn-success w-100">Generar Examen</button> 
        </form>
    </div>

    <script src="../src/app.js" defer></script>
</body>
</html>

