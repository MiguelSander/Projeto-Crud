<?php


require_once __DIR__ . '/../includes/auth.php';

requireAuth();

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

require_once __DIR__ . '/../includes/header.php';
?>
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h4 mb-3">Cadastrar Produto</h1>

                <?php if ($errors): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= e($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= e(base_path('produtos/store.php')); ?>" novalidate>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome *</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= e($old['nome'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="4"><?= e($old['descricao'] ?? ''); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="preco" class="form-label">Preço *</label>
                            <input type="text" class="form-control" id="preco" name="preco" value="<?= e($old['preco'] ?? ''); ?>" required>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label for="estoque" class="form-label">Estoque *</label>
                            <input type="number" class="form-control" id="estoque" name="estoque" value="<?= e($old['estoque'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Salvar</button>
                        <a href="<?= e(base_path('produtos/index.php')); ?>" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
