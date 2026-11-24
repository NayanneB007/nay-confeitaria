<?php
require_once 'conexao.php';
require_once 'funcoes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validar_csrf();
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$id) {
        mensagem('erro', 'Identificação de usuário inválida.');
        redirecionar('usuarios.php');
    }

    try {
        $pdo->beginTransaction();
        $consulta = $pdo->prepare("SELECT id, nome FROM usuarios WHERE id = :id AND status = 'Ativo' FOR UPDATE");
        $consulta->execute([':id' => $id]);
        $alvo = $consulta->fetch();

        if (!$alvo) {
            $pdo->rollBack();
            mensagem('erro', 'Usuário não encontrado ou já está inativo.');
            redirecionar('usuarios.php');
        }

        $baixa = $pdo->prepare("UPDATE usuarios SET status = 'Baixa', baixado_em = NOW(), atualizado_em = NOW() WHERE id = :id AND status = 'Ativo'");
        $baixa->execute([':id' => $id]);

        $audit = $pdo->prepare(
            "INSERT INTO auditoria_usuarios (usuario_alvo_id, acao, autor, data_hora, resultado)
             VALUES (:alvo, 'BAIXA', 'Sistema', NOW(), 'SUCESSO')"
        );
        $audit->execute([':alvo' => $id]);
        $pdo->commit();
        mensagem('sucesso', 'Usuário ' . $alvo['nome'] . ' foi marcado como Baixa.');
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        error_log('Erro na baixa de usuário: ' . $e->getMessage());
        mensagem('erro', 'Não foi possível concluir a operação.');
    }
    redirecionar('usuarios.php');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    mensagem('erro', 'Identificação inválida.');
    redirecionar('usuarios.php');
}
$stmt = $pdo->prepare("SELECT id, nome, email FROM usuarios WHERE id = :id AND status = 'Ativo'");
$stmt->execute([':id' => $id]);
$alvo = $stmt->fetch();
if (!$alvo) {
    mensagem('erro', 'Usuário não encontrado ou já está inativo.');
    redirecionar('usuarios.php');
}
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirmar exclusão | Nay-Confeitaria</title><link rel="stylesheet" href="style.css"></head>
<body><main class="container"><h1>Confirmar exclusão</h1>
<p>Deseja realmente marcar este usuário como Baixa?</p>
<div class="card"><strong><?= e($alvo['nome']) ?></strong><br><?= e($alvo['email']) ?><br>ID: <?= (int)$alvo['id'] ?></div>
<p>O registro será mantido no banco para preservar o histórico, mas deixará de aparecer na lista de usuários ativos.</p>
<form method="post" action="excluir_usuario.php">
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<input type="hidden" name="id" value="<?= (int)$alvo['id'] ?>">
<button type="submit">Confirmar</button>
<a class="botao-link secundario" href="usuarios.php">Cancelar</a>
</form></main></body></html>
