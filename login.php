<?php
session_start();

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

$captcha = intval($_POST['captcha']);
if ($captcha !== $_SESSION['captcha_resultado']) {
  $_SESSION['error'] = "Captcha incorrecto.";
  header("Location: index.php");
  exit();
}

// Cargar usuarios desde el archivo JSON
$usuarios = json_decode(file_get_contents("data/usuarios.json"), true);

foreach ($usuarios as $user) {
  if ($user["usuario"] === $usuario && password_verify($contrasena, $user["contrasena"])) {
    $_SESSION["usuario"] = $usuario;
    $_SESSION["rol"] = $user["rol"]; // <-- ESTA LÍNEA SE AGREGA AQUÍ
    header("Location: dashboard.php");
    exit();
  }
}

$_SESSION['error'] = "Usuario o contraseña incorrectos.";
header("Location: index.php");
exit();
?>
