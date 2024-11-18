<?php
include_once __DIR__.'/../src/database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$question = null;
if ($id > 0) {
    $sql = "SELECT * FROM reactivos WHERE id = {$id} AND eliminado = 0";
    $result = $conexion->query($sql);
    if ($result) {
        $question = $result->fetch_assoc();
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reactivo</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand">Editar Reactivo</a>
        </div>
    </nav>

    <div class="container mt-5">
        <form action="save-edit.php" method="POST" id="edit-question" class="needs-validation" novalidate>
            <input type="hidden" name="id" value="<?php echo $question['id']; ?>">

            <!-- Área -->
            <div class="mb-3">
                <label for="area" class="form-label">Área</label>
                <input type="text" id="area" name="area" class="form-control" value="<?php echo htmlspecialchars($question['area']); ?>" required>
                <div class="invalid-feedback">Por favor, completa este campo.</div>
            </div>

            <!-- Definición Operacional -->
            <div class="mb-3">
                <label for="definicion" class="form-label">Definición Operacional</label>
                <textarea id="definicion" name="definicion" class="form-control" rows="3" required><?php echo htmlspecialchars($question['definicion']); ?></textarea>
                <div class="invalid-feedback">Por favor, completa este campo.</div>
            </div>

            <!-- Base de Reactivo -->
            <div class="mb-3">
                <label for="base" class="form-label">Base de Reactivo</label>
                <textarea id="base" name="base" class="form-control" rows="3" required><?php echo htmlspecialchars($question['base']); ?></textarea>
                <div class="invalid-feedback">Por favor, completa este campo.</div>
            </div>

            <!-- Imagen
            <div class="mb-3">
                <label for="imageUpload" class="form-label">Subir Imagen</label>
                <input type="file" id="imageUpload" name="imageUpload" class="form-control" accept="image/*">
                <div class="form-text">(OPCIONAL) Elige una imagen.</div>
            </div> -->

            <!-- Opciones de Respuesta -->
            <h5 class="mt-4">Opciones de Respuesta</h5>
            <div class="row g-3">
                <?php
                $optionsSql = "SELECT * FROM respuestas WHERE id_reactivo = {$id}";
                $optionsResult = $conexion->query($optionsSql);
                if ($optionsResult) {
                    while ($option = $optionsResult->fetch_assoc()) {
                        echo '<div class="col-md-6">';
                        echo '<input type="text" name="opcion_' . $option['id_opcion'] . '" class="form-control mb-2" value="' . htmlspecialchars($option['texto_opcion']) . '" required>';
                        echo '<select name="op' . $option['id_opcion'] . '_value" class="form-select mb-2" required>';
                        echo '<option value="incorrecta"' . ($option['esta_correcta'] ? '' : ' selected') . '>Incorrecta</option>';
                        echo '<option value="correcta"' . ($option['esta_correcta'] ? ' selected' : '') . '>Correcta</option>';
                        echo '</select>';
                        echo '<textarea id="arg_' . $option['id_opcion'] . '" name="arg_' . $option['id_opcion'] . '" class="form-control" required>' . htmlspecialchars($option['justificacion']) . '</textarea>';
                        echo '</div>';
                    }
                }
                ?>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Guardar Cambios</button>
        </form>
    </div>

    <script src="../src/app.js" defer></script>
</body>
</html>
