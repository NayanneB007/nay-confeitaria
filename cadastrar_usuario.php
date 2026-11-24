<?php
require_once 'conexao.php';
require_once 'funcoes.php';
$setores = $pdo->query("SELECT id, nome FROM setores WHERE ativo = 1 ORDER BY nome")->fetchAll();
$perfis = $pdo->query("SELECT id, nome FROM perfis WHERE ativo = 1 ORDER BY nome")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastrar usuário | Nay-Confeitaria</title><link rel="stylesheet" href="style.css"></head>
<body><header><h1>Nay-Confeitaria</h1><nav><a href="index.html">Início</a><a href="usuarios.php">Usuários</a></nav></header>
<main class="container"><h2>Novo usuário</h2><?php mostrar_mensagem(); ?>
<form action="salvar_usuario.php" method="post" id="usuarioForm">
<input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
<label for="nome">Nome completo *</label><input id="nome" name="nome" maxlength="120" required>
<label for="email">E-mail *</label><input id="email" name="email" type="email" maxlength="160" required>
<label for="setor_id">Setor *</label><select id="setor_id" name="setor_id" required><option value="">Selecione</option>
<?php foreach ($setores as $s): ?><option value="<?= (int)$s['id'] ?>"><?= e($s['nome']) ?></option><?php endforeach; ?>
</select>
<label for="perfil_id">Perfil *</label><select id="perfil_id" name="perfil_id" required><option value="">Selecione</option>
<?php foreach ($perfis as $p): ?><option value="<?= (int)$p['id'] ?>"><?= e($p['nome']) ?></option><?php endforeach; ?>
</select>
<button type="submit">Salvar usuário</button> <a href="usuarios.php">Cancelar</a>
</form>
<p>* Campos obrigatórios. Os dados também serão validados no servidor.</p>
</main></body></html>
