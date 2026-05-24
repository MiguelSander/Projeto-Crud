<?php


require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

requireAuth();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('produtos/index.php');
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);

if ($id === false) {
    setFlash('danger', 'Produto inválido.');
    redirect('produtos/index.php');
}

$pdo = getConnection();
$stmt = $pdo->prepare('DELETE FROM produtos WHERE id = :id');
$stmt->execute([':id' => (int) $id]);

if ($stmt->rowCount() > 0) {
    setFlash('success', 'Produto excluído com sucesso.');
} else {
    setFlash('warning', 'Produto não encontrado para exclusão.');
}

redirect('produtos/index.php');
