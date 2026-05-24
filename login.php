<?php


require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

if (isAuthenticated()) {
    redirect('dashboard.php');
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $senha = (string) ($_POST['senha'] ?? '');

    if ($email === '' || $senha === '') {
        $error = 'Informe e-mail e senha.';
    } else {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT id, nome, email, senha FROM usuarios WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, (string) $usuario['senha'])) {
            $_SESSION['usuario_id'] = (int) $usuario['id'];
            $_SESSION['usuario_nome'] = (string) $usuario['nome'];
            $_SESSION['usuario_email'] = (string) $usuario['email'];

            redirect('dashboard.php');
        }

        $error = 'Credenciais inválidas.';
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistema de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= e(base_path('assets/css/style.css')); ?>">
</head>
<body class="bg-light">
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h1 class="h4 mb-3 text-center">Acesso ao Sistema</h1>

                    <?php if ($error !== ''): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= e($error); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= e(base_path('login.php')); ?>" novalidate>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= e($email); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" id="senha" name="senha" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>

                    <p class="small text-muted mt-3 mb-0 text-center">
                        Usuário padrão: admin@admin.com / 123456
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
