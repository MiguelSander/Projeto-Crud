<?php


require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

requireAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('produtos/index.php');
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
$nome = trim((string) ($_POST['nome'] ?? ''));
$descricao = trim((string) ($_POST['descricao'] ?? ''));
$precoInput = str_replace(',', '.', trim((string) ($_POST['preco'] ?? '')));
$estoqueInput = trim((string) ($_POST['estoque'] ?? ''));

if ($id === false) {
    setFlash('danger', 'Produto inválido.');
    redirect('produtos/index.php');
}

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

    redirect('produtos/edit.php?id=' . $id);
}

$pdo = getConnection();
$stmt = $pdo->prepare('UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco, estoque = :estoque WHERE id = :id');
$stmt->execute([
    ':nome' => $nome,
    ':descricao' => $descricao === '' ? null : $descricao,
    ':preco' => (float) $precoInput,
    ':estoque' => (int) $estoqueInput,
    ':id' => (int) $id,
]);

setFlash('success', 'Produto atualizado com sucesso.');
redirect('produtos/index.php');
