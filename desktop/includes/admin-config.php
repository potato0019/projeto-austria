
<?php

// Configurações administrativas

define('ADMIN_USER', 'admin');

// Hash correto da senha Austria@2026
define('ADMIN_PASSWORD', '$2y$10$iXdqBv.5woOPZdRe/N97euZ4geslIR/JIibYhpIMM/QUdegsDmf5y');

// Iniciar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
