<?php


require_once __DIR__ . '/auth.php';

$flash = getFlash();
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= e(base_path('assets/css/style.css')); ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= e(base_path('dashboard.php')); ?>">Sistema Produtos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= e(base_path('dashboard.php')); ?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= e(base_path('produtos/index.php')); ?>">Produtos</a>
                </li>
            </ul>
            <div class="d-flex">
                <a class="btn btn-outline-light btn-sm" href="<?= e(base_path('logout.php')); ?>">Sair</a>
            </div>
        </div>
    </div>
</nav>
<main class="container">
    <?php if ($flash !== null): ?>
        <div class="alert alert-<?= e($flash['type']); ?>" role="alert">
            <?= e($flash['message']); ?>
        </div>
    <?php endif; ?>
