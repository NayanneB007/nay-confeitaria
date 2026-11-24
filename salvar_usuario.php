<?php
require_once 'conexao.php';
require_once 'funcoes.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido.');
}
validar_csrf();

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$setorId = filter_input(INPUT_POST, 'setor_id', FILTER_VALIDATE_INT);
$perfilId = filter_input(INPUT_POST, 'perfil_id', FILTER_VALIDATE_INT);

if ($nome === '' || mb_strlen($nome) > 120) {
    mensagem('erro', 'Informe um nome válido com até 120 caracteres.');
    redirecionar('cadastrar_usuario.php');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 160) {
    mensagem('erro', 'Informe um e-mail válido.');
    redirecionar('cadastrar_usuario.php');
}
if (!$setorId || !$perfilId) {
    mensagem('erro', 'Selecione um setor e um perfil válidos.');
    redirecionar('cadastrar_usuario.php');
}

$referencia = $pdo->prepare(
    "SELECT
       (SELECT COUNT(*) FROM setores WHERE id = :setor AND ativo = 1) AS setor_ok,
       (SELECT COUNT(*) FROM perfis WHERE id = :perfil AND ativo = 1) AS perfil_ok"
);
$referencia->execute([':setor' => $setorId, ':perfil' => $perfilId]);
$validos = $referencia->fetch();
if (!$validos || !$validos['setor_ok'] || !$validos['perfil_ok']) {
    mensagem('erro', 'O setor ou perfil selecionado não existe ou está inativo.');
    redirecionar('cadastrar_usuario.php');
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO usuarios (nome, email, setor_id, perfil_id, status, criado_em, atualizado_em)
         VALUES (:nome, :email, :setor, :perfil, 'Ativo', NOW(), NOW())"
    );
    $stmt->execute([
        ':nome' => $nome, ':email' => mb_strtolower($email),
        ':setor' => $setorId, ':perfil' => $perfilId
    ]);
    $id = (int)$pdo->lastInsertId();

    $audit = $pdo->prepare(
        "INSERT INTO auditoria_usuarios (usuario_alvo_id, acao, autor, data_hora, resultado)
         VALUES (:alvo, 'CADASTRO', 'Sistema', NOW(), 'SUCESSO')"
    );
    $audit->execute([':alvo' => $id]);
    mensagem('sucesso', 'Usuário cadastrado com sucesso.');
    redirecionar('usuarios.php');
} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        mensagem('erro', 'Este e-mail já está cadastrado. Utilize outro e-mail.');
    } else {
        error_log('Erro ao cadastrar usuário: ' . $e->getMessage());
        mensagem('erro', 'Não foi possível salvar o cadastro. Verifique os dados e tente novamente.');
    }
    redirecionar('cadastrar_usuario.php');
}
