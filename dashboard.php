<?php include("includes/auth.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel - Adopta una Mascota</title>
  
  <style>
  * {
  box-sizing: border-box;
}

body {
  margin: 0;
  padding: 0;
  background-color: #FFF8DC;
  font-family: Arial, sans-serif;
}

.login-container {
  max-width: 1000px;
  margin: 40px auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
  overflow: visible;
}

h1 {
  text-align: center;
  margin-bottom: 25px;
  font-size: 24px;
}

.tab-container {
  margin-top: 10px;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 10px;
}

.tab-button {
  padding: 10px 18px;
  background-color: #FFD700;
  border: none;
  border-radius: 10px;
  color: white;
  font-weight: bold;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.tab-button:hover {
  background-color: #E6BE00;
}

.tab-content {
  margin-top: 25px;
  display: none;
}

.active {
  display: block;
}

.logout-link {
  display: block;
  margin-top: 40px;
  text-align: right;
  text-decoration: none;
  color: #333;
}

.logout-link:hover {
  color: black;
}

table {
  border-collapse: collapse;
  width: 100%;
  margin-top: 20px;
  background-color: white;
}

table, th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #FFD700;
  color: white;
}

.animal-list {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  justify-content: center;
}

.animal-card {
  width: 220px;
  border: 1px solid #ccc;
  padding: 12px;
  border-radius: 10px;
  background-color: #fdfdfd;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  text-align: center;
}

.animal-card img {
  max-width: 100%;
  height: auto;
  border-radius: 8px;
}

form button {
  padding: 8px 14px;
  background-color: #FFA500;
  border: none;
  border-radius: 6px;
  color: white;
  cursor: pointer;
  margin-top: 10px;
  font-size: 14px;
}

form button:hover {
  background-color: #e69500;
}

@media (max-width: 700px) {
  .tab-container {
    flex-direction: column;
    align-items: center;
  }

  .animal-card {
    width: 90%;
  }
}

</style>
</head>
<body>
  <div class="login-container">
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION["usuario"]); ?> 🐶🐱</h1>

   
    <div class="tab-container">
      <button class="tab-button" onclick="showTab('ver')">Ver animales en adopción</button>
      <button class="tab-button" onclick="showTab('dar')">Dar en adopción</button>
      <button class="tab-button" onclick="showTab('citas')">Agendar cita médica</button>
      <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "admin") { ?>
        <button class="tab-button" onclick="showTab('panel')">Panel de control</button>
      <?php } ?>
    </div>

    <div id="ver" class="tab-content active">
      <h2>Animales disponibles 🐾</h2>
      <?php if (isset($_GET['solicitud']) && $_GET['solicitud'] == 'ok') echo "<p style='color:green;'>✅ Solicitud enviada correctamente.</p>"; ?>

      <div class="animal-list">
        <?php
        $animales = json_decode(file_get_contents("data/animales.json"), true);
        if (empty($animales)) {
          echo "<p>No hay animales registrados aún.</p>";
        } else {
          foreach ($animales as $animal) {
            echo "<div class='animal-card'>";
            echo "<img src='" . $animal["foto"] . "' alt='Foto de " . $animal["nombre"] . "'>";
            echo "<h3>" . $animal["nombre"] . "</h3>";
            echo "<p><strong>Tipo:</strong> " . $animal["tipo"] . "</p>";
            echo "<p><strong>Edad:</strong> " . $animal["edad"] . "</p>";
            echo "<p>" . $animal["descripcion"] . "</p>";
            echo "<form action='solicitar_adopcion.php' method='POST'>";
            echo "<input type='hidden' name='animal' value='" . htmlspecialchars($animal["nombre"]) . "'>";
            echo "<button type='submit'>Solicitar adopción</button>";
            echo "</form>";
            echo "</div>";
          }
        }
        ?>
      </div>
    </div>

    <div id="dar" class="tab-content">
      <h2>Dar en adopción</h2>
      <?php if (isset($_GET['exito']) && $_GET['exito'] == '1') echo "<p style='color:green;'>🐾 Animal agregado exitosamente.</p>"; ?>
      <form action="guardar_animal.php" method="POST" enctype="multipart/form-data">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Tipo:</label>
        <select name="tipo" required>
          <option value="">Selecciona uno</option>
          <option value="Perro">Perro</option>
          <option value="Gato">Gato</option>
          <option value="Otro">Otro</option>
        </select>

        <label>Edad:</label>
        <input type="text" name="edad" required placeholder="Ej: 3 meses, 1 año...">

        <label>Descripción:</label>
        <textarea name="descripcion" rows="3" required></textarea>

        <label>Foto del animal:</label>
        <input type="file" name="foto" accept="image/*" required>

        <button type="submit">Agregar animal</button>
      </form>
    </div>

    <div id="citas" class="tab-content">
      <h2>Agendar cita médica</h2>
      <?php if (isset($_GET['cita']) && $_GET['cita'] == 'ok') echo "<p style='color:green;'>✅ Cita agendada correctamente.</p>"; ?>
      <form action="guardar_cita.php" method="POST">
        <label>Tu nombre:</label>
        <input type="text" name="nombre" required>

        <label>Animalito:</label>
        <select name="animal" required>
          <?php
          $animales = json_decode(file_get_contents("data/animales.json"), true);
          if (!empty($animales)) {
            foreach ($animales as $animal) {
              echo "<option value='" . htmlspecialchars($animal['nombre']) . "'>" . htmlspecialchars($animal['nombre']) . "</option>";
            }
          } else {
            echo "<option value=''>No hay animales disponibles</option>";
          }
          ?>
        </select>

        <label>Fecha:</label>
        <input type="date" name="fecha" required min="<?= date('Y-m-d'); ?>">

        <label>Hora:</label>
        <input type="time" name="hora" required>

        <button type="submit">Agendar cita</button>
      </form>

      <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "admin"): ?>
        <h3>Citas agendadas 🗓️</h3>
        <table>
          <tr><th>Nombre</th><th>Animal</th><th>Fecha</th><th>Hora</th></tr>
          <?php
          $citas = json_decode(file_get_contents("data/citas.json"), true) ?? [];
          if (!empty($citas)) {
            foreach ($citas as $cita) {
              echo "<tr><td>" . htmlspecialchars($cita["nombre"]) . "</td><td>" . htmlspecialchars($cita["animal"]) . "</td><td>" . htmlspecialchars($cita["fecha"]) . "</td><td>" . htmlspecialchars($cita["hora"]) . "</td></tr>";
            }
          } else {
            echo "<tr><td colspan='4'>No hay citas agendadas.</td></tr>";
          }
          ?>
        </table>
      <?php endif; ?>
    </div>

    <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "admin") { ?>
    <div id="panel" class="tab-content">
      <h2>Solicitudes de adopción</h2>
      <?php
      $solicitudes = json_decode(file_get_contents("data/solicitudes.json"), true);
      if (empty($solicitudes)) {
        echo "<p>No hay solicitudes registradas aún.</p>";
      } else {
        echo "<table border='1' cellpadding='8' style='background:#fff; border-collapse:collapse;'>";
        echo "<tr><th>Usuario</th><th>Animal</th><th>Fecha</th></tr>";
        foreach ($solicitudes as $s) {
          echo "<tr><td>" . htmlspecialchars($s["usuario"]) . "</td><td>" . htmlspecialchars($s["animal"]) . "</td><td>" . htmlspecialchars($s["fecha"]) . "</td></tr>";
        }
        echo "</table>";
      }
      ?>
    </div>
    <?php } ?>

    <a href="logout.php" class="logout-link">Cerrar sesión</a>
  </div>

  <script>
    function showTab(tabId) {
      document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
      document.getElementById(tabId).classList.add('active');
    }

    window.addEventListener("DOMContentLoaded", () => showTab('ver'));
  </script>
</body>
</html>
