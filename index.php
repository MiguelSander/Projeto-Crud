<?php


require_once __DIR__ . '/includes/auth.php';

if (isAuthenticated()) {
    redirect('dashboard.php');
}

redirect('login.php');
