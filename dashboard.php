<?php


require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

requireAuth();

$pdo = getConnection();
$stmt = $pdo->query('SELECT COUNT(*) AS total FROM produtos');
$totalProdutos = (int) ($stmt->fetch()['total'] ?? 0);

require_once __DIR__ . '/includes/header.php';
?>
<div class="row g-4">
    <div class="col-12">
        <div class="p-4 bg-white border rounded-3 shadow-sm">
            <h1 class="h3">Bem-vindo, <?= e($_SESSION['usuario_nome'] ?? 'Usuário'); ?>!</h1>
            <p class="mb-0 text-muted">Gerencie os produtos cadastrados no sistema.</p>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h2 class="h6 text-uppercase text-muted">Total de Produtos</h2>
                <p class="display-6 mb-3"><?= e($totalProdutos); ?></p>
                <a href="<?= e(base_path('produtos/index.php')); ?>" class="btn btn-primary">Ver Produtos</a>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
