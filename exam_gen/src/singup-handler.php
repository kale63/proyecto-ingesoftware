<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'student'; 

    $checkStmt = $conexion->prepare("SELECT id FROM usuarios WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "<script>
                alert('El nombre de usuario ya está en uso. Intenta con otro.');
                window.location.href = '../screens/register.php';
              </script>";
        $checkStmt->close();
        exit;
    }
    $checkStmt->close();

    $stmt = $conexion->prepare("INSERT INTO usuarios (username, password, rol) VALUES (?, ?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("sss", $username, $password, $role);

        if ($stmt->execute()) {
            echo "<script>
                    alert('¡Registro exitoso!');
                    window.location.href = '../screens/index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Ocurrió un error al registrar. Por favor, inténtalo de nuevo.');
                    window.location.href = '../screens/register.php';
                  </script>";
        }
        $stmt->close();
    } else {
        echo "<script>
                alert('Error al preparar la consulta.');
                window.location.href = '../screens/register.php';
              </script>";
    }

    $conexion->close();
}
?>
