<?php
session_start();
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
  header("Location: dashboard.php");
  exit();
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Control</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      background-color: #FFF8DC;
      font-family: Arial, sans-serif;
    }
    .panel-container {
      max-width: 800px;
      margin: 50px auto;
      padding: 20px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #333;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table, th, td {
      border: 1px solid #ccc;
    }
    th, td {
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #FFD700;
      color: #fff;
    }
    a.back {
      display: block;
      margin-top: 20px;
      text-align: center;
      text-decoration: none;
      background-color: #FFA500;
      color: white;
      padding: 10px;
      border-radius: 8px;
    }
  </style>
</head>
<body>
  <div class="panel-container">
    <h2>📋 Solicitudes de Adopción</h2>
    <?php
    $archivo = "data/solicitudes.json";
    if (file_exists($archivo)) {
      $solicitudes = json_decode(file_get_contents($archivo), true);
      if (!empty($solicitudes)) {
        echo "<table>";
        echo "<tr><th>Usuario</th><th>Animal</th><th>Fecha</th></tr>";
        foreach ($solicitudes as $s) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($s["usuario"]) . "</td>";
          echo "<td>" . htmlspecialchars($s["animal"]) . "</td>";
          echo "<td>" . htmlspecialchars($s["fecha"]) . "</td>";
          echo "</tr>";
        }
        echo "</table>";
      } else {
        echo "<p>No hay solicitudes aún.</p>";
      }
    } else {
      echo "<p>No hay solicitudes aún.</p>";
    }
    ?>
    <a class="back" href="dashboard.php">← Volver al panel</a>
  </div>
</body>
</html>
