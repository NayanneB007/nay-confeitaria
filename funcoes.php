<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($valor): string {
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validar_csrf(): void {
    $token = $_POST['csrf_token'] ?? '';
    if (!$token || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        exit('Solicitação inválida. Atualize a página e tente novamente.');
    }
}

function mensagem(string $tipo, string $texto): void {
    $_SESSION['mensagem'] = ['tipo' => $tipo, 'texto' => $texto];
}

function mostrar_mensagem(): void {
    if (!empty($_SESSION['mensagem'])) {
        $m = $_SESSION['mensagem'];
        echo '<div class="alerta ' . e($m['tipo']) . '">' . e($m['texto']) . '</div>';
        unset($_SESSION['mensagem']);
    }
}

function redirecionar(string $pagina): void {
    header('Location: ' . $pagina);
    exit;
}
