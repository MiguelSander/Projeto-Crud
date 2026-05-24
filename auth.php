<?php


if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        static $base = null;

        if ($base === null) {
            $projectRoot = realpath(__DIR__ . '/..');
            $documentRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath((string) $_SERVER['DOCUMENT_ROOT']) : false;

            if ($projectRoot !== false && $documentRoot !== false && substr($projectRoot, 0, strlen($documentRoot)) === $documentRoot) {
                $base = str_replace('\\', '/', substr($projectRoot, strlen($documentRoot)));
                $base = '/' . trim($base, '/');
                if ($base === '/') {
                    $base = '';
                }
            } else {
                $base = '';
            }
        }

        $path = ltrim($path, '/');

        if ($path === '') {
            return $base === '' ? '/' : $base;
        }

        return ($base === '' ? '' : $base) . '/' . $path;
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): void
    {
        header('Location: ' . base_path($path));
        exit;
    }
}

if (!function_exists('isAuthenticated')) {
    function isAuthenticated(): bool
    {
        return isset($_SESSION['usuario_id']);
    }
}

if (!function_exists('requireAuth')) {
    function requireAuth(): void
    {
        if (!isAuthenticated()) {
            redirect('login.php');
        }
    }
}

if (!function_exists('e')) {
    function e(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('setFlash')) {
    function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message,
        ];
    }
}

if (!function_exists('getFlash')) {
    function getFlash(): ?array
    {
        if (!isset($_SESSION['flash'])) {
            return null;
        }

        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);

        return $flash;
    }
}
