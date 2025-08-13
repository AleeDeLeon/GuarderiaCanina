<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nombre = htmlspecialchars($_POST["nombre"]);
  $animal = htmlspecialchars($_POST["animal"]);
  $fecha = $_POST["fecha"];
  $hora = $_POST["hora"];

  // Validación básica
  if (empty($nombre) || empty($animal) || empty($fecha) || empty($hora)) {
    die("❌ Todos los campos son obligatorios.");
  }

  if (strtotime($fecha) < strtotime(date("Y-m-d"))) {
    die("❌ La fecha no puede ser en el pasado.");
  }

  $nuevaCita = [
    "nombre" => $nombre,
    "animal" => $animal,
    "fecha" => $fecha,
    "hora" => $hora
  ];

  $archivo = "data/citas.json";
  $citas = [];

  if (file_exists($archivo)) {
    $json = file_get_contents($archivo);
    $citas = json_decode($json, true) ?? [];
  }

  $citas[] = $nuevaCita;
  file_put_contents($archivo, json_encode($citas, JSON_PRETTY_PRINT));

  header("Location: dashboard.php?cita=ok");
  exit();
} else {
  header("Location: dashboard.php");
  exit();
}
