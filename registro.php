<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $usuario = trim($_POST["usuario"]);
  $clave = $_POST["clave"];

  if (empty($usuario) || empty($clave)) {
    die("❌ Usuario y contraseña requeridos.");
  }

  $archivo = "data/usuarios.json";
  $usuarios = [];

  if (file_exists($archivo)) {
    $json = file_get_contents($archivo);
    $usuarios = json_decode($json, true) ?? [];
  }

  foreach ($usuarios as $u) {
    if ($u["usuario"] === $usuario) {
      die("❌ Ese nombre de usuario ya existe.");
    }
  }

  $nuevoUsuario = [
    "usuario" => $usuario,
    "contrasena" => password_hash($clave, PASSWORD_DEFAULT),
    "rol" => "usuario"
  ];

  $usuarios[] = $nuevoUsuario;
  file_put_contents($archivo, json_encode($usuarios, JSON_PRETTY_PRINT));

  header("Location: index.php?registro=ok");
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color:#FFF8DC;">
  <div class="login-container">
    <h2>Crear una cuenta 🐾</h2>
    <form method="POST" action="registro.php">
      <label>Usuario:</label>
      <input type="text" name="usuario" required>

      <label>Contraseña:</label>
      <input type="password" name="clave" required>

      <button type="submit">Registrarse</button>
    </form>

    <p>¿Ya tienes una cuenta? <a href="index.php">Inicia sesión</a></p>
  </div>
</body>
</html>
