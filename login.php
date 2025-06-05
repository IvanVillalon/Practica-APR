<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - APR NONTUELA</title>
    <link rel="stylesheet" href="estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .login-container {
            background-color: #e3edf7;
            padding: 2rem 3rem;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.7);
            width: 100%;
            max-width: 400px;
            margin: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-container h2 {
            margin-bottom: 1.5rem;
            font-weight: 700;
            color: #3a60ae;
            text-align: center;
            padding: 1rem 1rem;
        }
        label {
            font-weight: 600;
            color: #3a60ae;
            display: block;
            
        }
        input[type="text"], input[type="password"] {
            border-radius: 6px;
            border: 1px solid #ced4da;
            box-shadow: 0 0 5px rgba(58, 96, 174, 0.5);
            outline: none;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            margin-bottom: 1rem;
            width: 100%;
            box-sizing: border-box;


        }
        button {
            background-color: #3a60ae;
            border: none;
            color: white;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        button:hover {
            background-color: #2b4584;
            transform: scale(1.05);

        }

        .PIE{
            
            text-align: center;
            margin-top: 2rem;
            color:#ced4da;
            opacity: 0.85;
            font-size: 0.9rem;
            border-radius: 3px;
            
        }
        .PIE img {
            max-width: 100px;
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto 0.5rem auto;
        }
        
        @media (max-width: 950px) {
        .login-container {
    max-width: 90%;
    padding: 1.5rem;
    border-radius: 10px;
  }

  .login-container h2 {
    font-size: 1.5rem;
  }

  input[type="text"],
  input[type="password"] {
    font-size: 1rem;
    padding: 0.5rem;
  }

  .PIE img {
    max-width: 70px;
  }
        }

       
    </style>
</head>
<body>
    <div class="login-container"><?php
session_start();
if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?= $_SESSION['error']; ?>
    </div>
<?php
    unset($_SESSION['error']); // Borrar el mensaje para que no se muestre otra vez
endif;
?><h2>Iniciar Sesión</h2>

  <form action="validar_login.php" method="post" autocomplete="off">
  <label for="usuario">Usuario:</label>
  <input type="text" id="usuario" name="usuario" required autofocus>

  <label for="password">Contraseña:</label>
  <input type="password" id="password" name="password" required>

  <button type="submit">Iniciar sesión</button>
</form>


<div class="PIE">
  <img src="LOGO.png" alt="Logo APR Nontuela">
  <p>APR NONTUELA</p>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
