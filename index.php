<?php
session_start();

// Generar la pregunta del captcha (por ejemplo: 3 + 5)
$num1 = rand(1, 9);
$num2 = rand(1, 9);
$_SESSION["captcha_resultado"] = $num1 + $num2;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login - Adopta una Mascota</title>
  

<style>
  * {
    box-sizing: border-box;
  }

  body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #FFF3B0;
    height: 100vh;
    background-image: url('img/huellitas.png');
    background-repeat: repeat;
    background-size: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .login-box {
    background-color: white;
    padding: 40px 30px;
    border-radius: 15px;
    box-shadow: 0 0 18px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
    text-align: left;
  }

  .login-box h2 {
    margin-bottom: 25px;
    font-size: 24px;
    color: #333;
    text-align: center;
  }

  input[type="text"],
  input[type="password"] {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 14px;
  }

  button {
    background-color: #FFD700;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 12px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 15px;
  }

  button:hover {
    background-color: #E6BE00;
  }

  .error {
    color: red;
    margin-top: 10px;
  }

  @media (max-height: 600px) {
    body {
      align-items: flex-start;
      padding-top: 30px;
    }
  }
</style>



</head>
<body>
  <div class="login-box">
    <h1>Adopta una Mascota 🐾</h1>

    <?php
    if (isset($_SESSION['error'])) {
      echo "<p class='error'>" . $_SESSION['error'] . "</p>";
      unset($_SESSION['error']);
    }
    ?>

    <form action="login.php" method="POST">
      <label>Usuario:</label>
      <input type="text" name="usuario" required>

      <label>Contraseña:</label>
      <input type="password" name="contrasena" required>

      <label>Captcha: ¿Cuánto es <?php echo "$num1 + $num2"; ?>?</label>
      <input type="number" name="captcha" placeholder="Escribe el resultado" required>

      <button type="submit">Iniciar sesión</button>
    </form>

    <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
  </div>



</body>
</html>
