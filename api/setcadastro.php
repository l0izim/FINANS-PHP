<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro</title>
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
    .valid-feedback {
      display: none;
    }
    .is-valid + .valid-feedback {
      display: block;
      color: #1cc88a;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark p-3">
  <div class="container-fluid">
    <span class="navbar-brand">FINANS</span>
      <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item "><a class="nav-link btn btn-outline-primary" href="../index.html">Sair</a></li>
            </ul>
      </div>
  </div>
</nav>

<?php
  session_start();
  $old = $_SESSION['form_data'] ?? ['nome' => '', 'email' => ''];
  $error = $_SESSION['form_error'] ?? '';
  $success = $_SESSION['form_success'] ?? '';
  unset($_SESSION['form_data'], $_SESSION['form_error'], $_SESSION['form_success']);
?>

<div class="form-container">
  <h2 class="text-center">Criar Conta</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($success)): ?>
  <div class="alert alert-success text-center">
    <?= htmlspecialchars($success) ?><br><br>
    <a href="./setLogin.php" class="btn btn-primary mt-2">Ir para Login</a>
  </div>
<?php endif; ?>




  <form action="getCadastro.php" method="POST" id="cadastroForm">
    <div class="mb-3">
      <label class="form-label">Nome</label>
      <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($old['nome']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Senha</label>
      <input type="password" name="senha" id="senha" class="form-control" required>
      <div class="valid-feedback" id="length">Mínimo 8 caracteres</div>
      <div class="valid-feedback" id="uppercase">Letra maiúscula</div>
      <div class="valid-feedback" id="number">Número</div>
    </div>
    <div class="mb-3">
      <label class="form-label">Confirmar Senha</label>
      <input type="password" name="confirmar" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success w-100">Cadastrar</button>
  </form>
  <a class="btn btn-primary mt-4" href="./setLogin.php">Login</a>
</div>

<script>
  const senha = document.getElementById('senha');
  const length = document.getElementById('length');
  const uppercase = document.getElementById('uppercase');
  const number = document.getElementById('number');

  senha.addEventListener('input', () => {
    const value = senha.value;
    value.length >= 8 ? length.classList.add('is-valid') : length.classList.remove('is-valid');
    /[A-Z]/.test(value) ? uppercase.classList.add('is-valid') : uppercase.classList.remove('is-valid');
    /\d/.test(value) ? number.classList.add('is-valid') : number.classList.remove('is-valid');
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
