<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'teacher') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Reactivos</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .button-td {
            width: 150px; 
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis; 
        }
    </style>
</head> 
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Gestor de Reactivos</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="add-questions.php">Agregar Preguntas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="mb-3 d-none"> <!--cambiar visibilidad-->
            <div class="input-group">
                <input type="search" id="searchInput" class="form-control" placeholder="Buscar reactivos">
                <button class="btn btn-primary" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="mt-4">
            <table id="questionsTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="d-none"></th>
                        <th>Área</th>
                        <th>Definición</th>
                        <th>Base</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        
    </div>

    <script src="../src/app.js" defer></script>
</body>
</html>
