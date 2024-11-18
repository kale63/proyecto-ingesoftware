<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
    <title>Simulación de Examen</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <header class="text-center my-4">
        <h2>Simulación de Examen</h2>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <button class="btn btn-primary btn-block text-center mx-4" type="button" id="previous-question">Anterior</button>
            <button class="btn btn-primary btn-block text-center mx-4" type="button" id="next-question">Siguiente</button>
            <button class="btn btn-primary btn-block text-center mx-4" type="button" id="submit-exam">Terminar examen</button>
            <!--<button class="btn btn-primary btn-block text-center mx-4" type="button" id="help">Ayuda</button>-->
        </div>
    </nav>

    <div class="container">
        <div class="row p-4 justify-content-center">
            <div class="col-md-5 border border-primary p-3 mx-2">
                <p class="text-center">Pregunta</p>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <p class="question" id="question-text">Cargando pregunta...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 border border-primary p-3 mx-2">
                <p class="text-center">Opciones</p>
                <div id="respuestas"></div>
            </div>
        </div>
    </div>

    <script src="../src/app.js" defer></script>
</body>
</html>
