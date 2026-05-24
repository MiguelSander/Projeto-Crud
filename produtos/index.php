<?php


require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

requireAuth();

$pdo = getConnection();
$stmt = $pdo->query('SELECT id, nome, preco, estoque, criado_em FROM produtos ORDER BY id DESC');
$produtos = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Produtos</h1>
    <a href="<?= e(base_path('produtos/create.php')); ?>" class="btn btn-success">Novo Produto</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Data de Cadastro</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($produtos) === 0): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">Nenhum produto cadastrado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?= e($produto['id']); ?></td>
                            <td><?= e($produto['nome']); ?></td>
                            <td>R$ <?= e(number_format((float) $produto['preco'], 2, ',', '.')); ?></td>
                            <td><?= e($produto['estoque']); ?></td>
                            <td>
                                <?php
                                $dataCadastro = date_create((string) $produto['criado_em']);
                                echo e($dataCadastro ? $dataCadastro->format('d/m/Y H:i') : (string) $produto['criado_em']);
                                ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= e(base_path('produtos/edit.php?id=' . (int) $produto['id'])); ?>" class="btn btn-sm btn-primary">Editar</a>
                                <form method="post" action="<?= e(base_path('produtos/delete.php')); ?>" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                    <input type="hidden" name="id" value="<?= e($produto['id']); ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
