<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Estudiantes</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Registro de Estudiantes</h2>
        <form id="registrationForm" method="POST" action="../src/singup-handler.php">
            <div class="form-group">
                <label for="username">Crea un nuevo nombre de usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Crea una contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-warning btn-block">Registrarse</button>
        </form>
    </div>
</body>
</html>
