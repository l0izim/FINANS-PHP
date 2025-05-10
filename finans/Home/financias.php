

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #000;
      color: #fff;
    }
    .container {
      margin-top: 30px;
    }
    .bg-dark-card {
      background-color: #111;
    }
    .text-green {
      color: #1cc88a;
    }
    .text-red {
      color: #e74a3b;
    }
    .text-white {
      color: #fff;
    }
  </style>
</head>
<body>
<?php
  session_start();

  if (!isset($_SESSION['usuario'])) {
    header('Location: ../Login/setLogin.php');
    exit;
  }

  if (!isset($_SESSION['transacoes'])) {
    $_SESSION['transacoes'] = [];
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['adicionar'])) {
      $_SESSION['transacoes'][] = [
        'descricao' => $_POST['descricao'],
        'valor' => (float)$_POST['valor'],
        'tipo' => $_POST['tipo']
      ];
    }
    if (isset($_POST['remover'])) {
      unset($_SESSION['transacoes'][$_POST['indice']]);
      $_SESSION['transacoes'] = array_values($_SESSION['transacoes']);
    }
  }

  $entradas = 0;
  $saidas = 0;
  foreach ($_SESSION['transacoes'] as $t) {
    if ($t['tipo'] === 'entrada') {
      $entradas += $t['valor'];
    } else {
      $saidas += $t['valor'];
    }
  }
  $saldo = $entradas - $saidas;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
  <div class="container-fluid">
    <span class="navbar-brand">FINANS</span>
      <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item"><a class="nav-link" href="#">Dasboard</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Estoques</a></li>
              <li class="nav-item"><a class="nav-link" href="#">Cadastros</a></li>
              <li class="nav-item "><a class="nav-link btn btn-outline-primary" href="../index.html">Sair</a></li>
            </ul>
      </div>
  </div>
</nav>


<div class="container">
  <h1 class="text-center mb-4">Dashboard</h1>
  <div class="row text-center mb-4">
    <div class="col-md-4">
      <div class="card bg-dark-card p-3">
        <h5>Entradas</h5>
        <p class="text-green">R$ <?= number_format($entradas, 2, ',', '.') ?></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-dark-card p-3">
        <h5>Saídas</h5>
        <p class="text-red">R$ <?= number_format($saidas, 2, ',', '.') ?></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-dark-card p-3">
        <h5>Saldo</h5>
        <p class="text-white">R$ <?= number_format($saldo, 2, ',', '.') ?></p>
      </div>
    </div>
  </div>

  <form method="POST" class="row g-2 mb-4">
    <div class="col-md-4">
      <input type="text" name="descricao" class="form-control" placeholder="Descrição" required>
    </div>
    <div class="col-md-3">
      <input type="number" step="0.01" name="valor" class="form-control" placeholder="Valor" required>
    </div>
    <div class="col-md-3">
      <select name="tipo" class="form-select" required>
        <option value="entrada">Entrada</option>
        <option value="saida">Saída</option>
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" name="adicionar" class="btn btn-success w-100">Adicionar</button>
    </div>
  </form>

  <table class="table table-dark table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Descrição</th>
        <th>Valor</th>
        <th>Tipo</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($_SESSION['transacoes'])): ?>
        <tr>
          <td colspan="5" class="text-center">Nenhuma transação registrada.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($_SESSION['transacoes'] as $i => $t): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($t['descricao']) ?></td>
            <td>R$ <?= number_format($t['valor'], 2, ',', '.') ?></td>
            <td class="<?= $t['tipo'] === 'entrada' ? 'text-green' : 'text-red' ?>">
              <?= ucfirst($t['tipo']) ?>
            </td>
            <td>
              <form method="POST" class="d-inline">
                <input type="hidden" name="indice" value="<?= $i ?>">
                <button type="submit" name="remover" class="btn btn-sm btn-danger">Excluir</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
