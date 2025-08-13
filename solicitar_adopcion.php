<?php
session_start();

if (!isset($_SESSION["usuario"])) {
  header("Location: index.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $animal = htmlspecialchars($_POST["animal"]);
  $usuario = $_SESSION["usuario"];
  $fecha = date("Y-m-d H:i:s");

  $nuevaSolicitud = [
    "usuario" => $usuario,
    "animal" => $animal,
    "fecha" => $fecha
  ];

  $archivo = "data/solicitudes.json";
  $solicitudes = [];

  if (file_exists($archivo)) {
    $json = file_get_contents($archivo);
    $solicitudes = json_decode($json, true) ?? [];
  }

  $solicitudes[] = $nuevaSolicitud;
  file_put_contents($archivo, json_encode($solicitudes, JSON_PRETTY_PRINT));

  header("Location: dashboard.php?solicitud=ok");
  exit();
}
?>
