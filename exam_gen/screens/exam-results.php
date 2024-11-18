<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados</title>
    <style>
        .exam-title {
            font-size: 2.5rem;
            text-align: center;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        .score-display {
            background-color: #374858FF;
            border-radius: 12px;
            padding: 15px;
            font-size: 1.8rem;
            text-align: center;
            font-weight: 600;
            color: #E6771DFF;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="exam-title my-4">Resultados del Examen</h1>
        <div id="score" class="score-display my-4"></div>
        <div id="results"></div>

        <button class="btn btn-primary my-4" onclick="window.location.href='alumno.php';">Volver</button>
    </div>
    
    <script src="../src/results.js"></script>
</body>
</html>
