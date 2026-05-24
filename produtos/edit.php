<?php


require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';

requireAuth();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    setFlash('danger', 'Produto inválido.');
    redirect('produtos/index.php');
}

$pdo = getConnection();
$stmt = $pdo->prepare('SELECT id, nome, descricao, preco, estoque FROM produtos WHERE id = :id LIMIT 1');
$stmt->execute([':id' => $id]);
$produto = $stmt->fetch();

if (!$produto) {
    setFlash('danger', 'Produto não encontrado.');
    redirect('produtos/index.php');
}

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

$produtoForm = [
    'id' => $produto['id'],
    'nome' => $old['nome'] ?? $produto['nome'],
    'descricao' => $old['descricao'] ?? $produto['descricao'],
    'preco' => $old['preco'] ?? (string) $produto['preco'],
    'estoque' => $old['estoque'] ?? (string) $produto['estoque'],
];

require_once __DIR__ . '/../includes/header.php';
?>
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h4 mb-3">Editar Produto #<?= e($produtoForm['id']); ?></h1>

                <?php if ($errors): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= e($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= e(base_path('produtos/update.php')); ?>" novalidate>
                    <input type="hidden" name="id" value="<?= e($produtoForm['id']); ?>">

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome *</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= e($produtoForm['nome']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="4"><?= e($produtoForm['descricao']); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="preco" class="form-label">Preço *</label>
                            <input type="text" class="form-control" id="preco" name="preco" value="<?= e($produtoForm['preco']); ?>" required>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label for="estoque" class="form-label">Estoque *</label>
                            <input type="number" class="form-control" id="estoque" name="estoque" value="<?= e($produtoForm['estoque']); ?>" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                        <a href="<?= e(base_path('produtos/index.php')); ?>" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
