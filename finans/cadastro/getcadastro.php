<?php
session_start();

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';
$confirmar = $_POST['confirmar'] ?? '';

// Validação básica
if (empty($nome) || empty($email) || empty($senha)) {
  $_SESSION['form_error'] = 'Todos os campos são obrigatórios.';
  $_SESSION['form_data'] = $_POST;
  header('Location: setCadastro.php');
  exit;
}

if ($senha !== $confirmar) {
  $_SESSION['form_error'] = 'As senhas não coincidem.';
  $_SESSION['form_data'] = $_POST;
  header('Location: setCadastro.php');
  exit;
}

// Simula um banco de dados em sessão
if (!isset($_SESSION['usuarios'])) {
  $_SESSION['usuarios'] = [];
}

// Verifica se o email já foi cadastrado
foreach ($_SESSION['usuarios'] as $usuario) {
  if ($usuario['email'] === $email) {
    $_SESSION['form_error'] = 'Email já cadastrado.';
    $_SESSION['form_data'] = $_POST;
    header('Location: setCadastro.php');
    exit;
  }
}

// Salva o usuário na sessão
$_SESSION['usuarios'][] = [
  'nome' => $nome,
  'email' => $email,
  'senha' => $senha
];

$_SESSION['form_success'] = 'Cadastro concluído com sucesso!';
header('Location: setCadastro.php');
exit;
