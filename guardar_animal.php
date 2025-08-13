<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Seguridad al subir imagen
  $permitidos = ['image/jpeg', 'image/png', 'image/gif'];
  $foto = $_FILES['foto'];

  if ($foto['error'] !== UPLOAD_ERR_OK) {
    die("❌ Error al subir la imagen.");
  }

  if (!in_array($foto['type'], $permitidos)) {
    die("❌ Solo se permiten imágenes JPG, PNG o GIF.");
  }
  if ($foto['size'] > 1024 * 1024) { // 1MB en bytes
  die("❌ La imagen no debe pesar más de 1MB.");
}


  // Crear nombre único para evitar sobrescritura
  $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
  $nuevoNombre = uniqid('img_', true) . '.' . $ext;
  $rutaDestino = 'uploads/' . $nuevoNombre;

  // Mover archivo a carpeta uploads
  if (!move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
    die("❌ No se pudo guardar la imagen.");
  }

  // Crear animal nuevo
  $nuevoAnimal = [
    "nombre" => htmlspecialchars($_POST["nombre"]),
    "tipo" => htmlspecialchars($_POST["tipo"]),
    "edad" => htmlspecialchars($_POST["edad"]),
    "descripcion" => htmlspecialchars($_POST["descripcion"]),
    "foto" => $rutaDestino // ruta local a la imagen
  ];

  $archivo = "data/animales.json";
  $animales = [];

  if (file_exists($archivo)) {
    $json = file_get_contents($archivo);
    $animales = json_decode($json, true) ?? [];
  }

  $animales[] = $nuevoAnimal;
  file_put_contents($archivo, json_encode($animales, JSON_PRETTY_PRINT));

  header("Location: dashboard.php?exito=1");
  exit();
} else {
  header("Location: dashboard.php");
  exit();
}
