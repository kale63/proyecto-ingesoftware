<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Reactivos</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  </head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand">Crear un Nuevo Reactivo</a>
        </div>
    </nav>
    
    <div class="container mt-5">
        <form action="" method="POST" id="question-form" class="needs-validation" novalidate>
            <!-- Área -->
            <div class="mb-3">
                <label for="area" class="form-label">Área</label>
                <input type="text" id="area" name="area" class="form-control" placeholder="Ingresa el área" required>
                <div class="invalid-feedback">Por favor, completa este campo.</div>
            </div>

            <!-- Definición Operacional -->
            <div class="mb-3">
                <label for="definicion" class="form-label">Definición Operacional</label>
                <textarea id="definicion" name="definicion" class="form-control" rows="3" placeholder="Escribe la definición" required></textarea>
                <div class="invalid-feedback">Por favor, completa este campo.</div>
            </div>

            <!-- Base de Reactivo -->
            <div class="mb-3">
                <label for="base" class="form-label">Base de Reactivo</label>
                <textarea id="base" name="base" class="form-control" rows="3" placeholder="Escribe la base del reactivo" required></textarea>
                <div class="invalid-feedback">Por favor, completa este campo.</div>
            </div>
            
            <!-- Imagen 
            <div class="mb-3">
                <label for="imageUpload" class="form-label">Subir Imagen</label>
                <input type="file" id="imageUpload" name="imageUpload" class="form-control" accept="image/*">
                <div class="form-text">(OPCIONAL) Elige una imagen.</div>
            </div>-->

            <!-- Opciones de Respuesta -->
            <h5 class="mt-4">Opciones de Respuesta</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="opcion_1" class="form-control mb-2" placeholder="Opción 1" required>
                    <select name="op1_value" class="form-select mb-2" required>
                        <option value="incorrecta">Incorrecta</option>
                        <option option value="correcta">Correcta</option>
                    </select>
                    <textarea id="arg_1" name="arg_1" class="form-control" placeholder="Argumentación" rows="2" required></textarea>
                </div>

                <div class="col-md-6">
                    <input type="text" name="opcion_2" class="form-control mb-2" placeholder="Opción 2" required>
                    <select name="op2_value" class="form-select mb-2" required>
                        <option value="incorrecta">Incorrecta</option>
                        <option value="correcta">Correcta</option>
                    </select>
                    <textarea id="arg_2" name="arg_2" class="form-control" placeholder="Argumentación" rows="2" required></textarea>
                </div>

                <br><br>

                <div class="col-md-6">
                    <input type="text" name="opcion_3" class="form-control mb-2" placeholder="Opción 3" required>
                    <select name="op3_value" class="form-select mb-2" required>
                        <option value="incorrecta">Incorrecta</option>
                        <option value="correcta">Correcta</option>
                    </select>
                    <textarea id="arg_3" name="arg_3" class="form-control" placeholder="Argumentación" rows="2" required></textarea>
                </div>

                <div class="col-md-6">
                    <input type="text" name="opcion_4" class="form-control mb-2" placeholder="Opción 4" required>
                    <select name="op4_value" class="form-select mb-2" required>
                        <option value="incorrecta">Incorrecta</option>
                        <option value="correcta">Correcta</option>
                    </select>
                    <textarea id="arg_4" name="arg_4" class="form-control" placeholder="Argumentación" rows="2" required></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Guardar Reactivo</button>
        </form>
    </div>

    <div id="description"></div>

    <script src="../src/app.js" defer></script>
</body>
</html>
