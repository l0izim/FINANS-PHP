<?php
session_start();

// Recupera os usuários cadastrados
$usuarios = $_SESSION['usuarios'] ?? [];
$erro = $_SESSION['login_erro'] ?? '';
unset($_SESSION['login_erro']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #000;
      color: #fff;
    }
    .form-container {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      background-color: #111;
      border-radius: 10px;
    }
  </style>
</head>
<body>

<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? '';
  $senha = $_POST['senha'] ?? '';

  foreach ($usuarios as $usuario) {
    if ($usuario['email'] === $email && $usuario['senha'] === $senha) {
      $_SESSION['logado'] = true;
      $_SESSION['usuario'] = $usuario;
      header('Location: ../Home/financias.php');
      exit;
    }
  }

  $_SESSION['login_erro'] = 'Email ou senha incorretos.';
  header('Location: setLogin.php');
  exit;
}
?>

<div class="form-container">
  <h2 class="text-center">Login</h2>

  <?php if (!empty($erro)): ?>
    <div class="alert alert-danger">
      <?= htmlspecialchars($erro) ?>
    </div>
  <?php endif; ?>

  <form action="setLogin.php" method="POST">
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required />
    </div>
    <div class="mb-3">
      <label class="form-label">Senha</label>
      <input type="password" name="senha" class="form-control" required />
    </div>
    <button type="submit" class="btn btn-success w-100">Entrar</button>
  </form>
  <a class="btn btn-primary mt-4" href="../cadastro/setcadastro.php">Cadastrar</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
