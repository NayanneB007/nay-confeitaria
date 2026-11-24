<?php
// Conexão central com MySQL usando PDO.
$host = 'localhost';
$banco = 'nay_confeitaria';
$usuario = 'root';
$senha = ''; // Ajuste somente se seu MySQL tiver senha.

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    error_log('Falha de conexão com o banco: ' . $e->getMessage());
    http_response_code(500);
    exit('Não foi possível conectar ao banco de dados. Confira o XAMPP e o arquivo conexao.php.');
}
