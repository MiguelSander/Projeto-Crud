<?php


require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

requireAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('produtos/index.php');
}

$nome = trim((string) ($_POST['nome'] ?? ''));
$descricao = trim((string) ($_POST['descricao'] ?? ''));
$precoInput = str_replace(',', '.', trim((string) ($_POST['preco'] ?? '')));
$estoqueInput = trim((string) ($_POST['estoque'] ?? ''));

$errors = [];

if ($nome === '') {
    $errors[] = 'O nome do produto é obrigatório.';
}

if ($precoInput === '' || !is_numeric($precoInput)) {
    $errors[] = 'O preço é obrigatório e deve ser numérico.';
}

if ($estoqueInput === '' || filter_var($estoqueInput, FILTER_VALIDATE_INT) === false) {
    $errors[] = 'O estoque é obrigatório e deve ser um número inteiro.';
}

if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = [
        'nome' => $nome,
        'descricao' => $descricao,
        'preco' => (string) ($_POST['preco'] ?? ''),
        'estoque' => $estoqueInput,
    ];

    redirect('produtos/create.php');
}

$pdo = getConnection();
$stmt = $pdo->prepare('INSERT INTO produtos (nome, descricao, preco, estoque) VALUES (:nome, :descricao, :preco, :estoque)');
$stmt->execute([
    ':nome' => $nome,
    ':descricao' => $descricao === '' ? null : $descricao,
    ':preco' => (float) $precoInput,
    ':estoque' => (int) $estoqueInput,
]);

setFlash('success', 'Produto cadastrado com sucesso.');
redirect('produtos/index.php');
