<?php
require_once 'conexao.php';
require_once 'funcoes.php';

$busca = trim($_GET['busca'] ?? '');
$sql = "SELECT u.id, u.nome, u.email, u.status, u.criado_em,
               s.nome AS setor, p.nome AS perfil
        FROM usuarios u
        INNER JOIN setores s ON s.id = u.setor_id
        INNER JOIN perfis p ON p.id = u.perfil_id
        WHERE u.status = 'Ativo'";
$params = [];
if ($busca !== '') {
    $sql .= " AND (u.nome LIKE :nome OR u.email LIKE :email)";
    $params[':nome'] = "%$busca%";
    $params[':email'] = "%$busca%";
}
$sql .= " ORDER BY u.nome";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$usuarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Usuários | Nay-Confeitaria</title><link rel="stylesheet" href="style.css">
</head>
<body>
<header><h1>Nay-Confeitaria</h1><nav><a href="index.html">Início</a><a href="dashboard.html">Painel</a><a href="usuarios.php">Usuários</a><a href="produtos.html">Produtos</a></nav></header>
<main class="container">
<h2>Gestão de usuários</h2>
<?php mostrar_mensagem(); ?>
<p><a class="botao-link" href="cadastrar_usuario.php">Cadastrar usuário</a></p>
<form method="get" class="busca">
<label for="busca">Pesquisar por nome ou e-mail</label>
<input id="busca" name="busca" type="search" value="<?= e($busca) ?>" placeholder="Digite nome ou e-mail">
<button type="submit">Pesquisar</button>
<a href="usuarios.php">Limpar</a>
</form>
<?php if (!$usuarios): ?>
<p>Nenhum usuário ativo encontrado.</p>
<?php else: ?>
<div class="tabela-responsiva"><table>
<thead><tr><th>Nome</th><th>E-mail</th><th>Setor</th><th>Perfil</th><th>Cadastro</th><th>Ação</th></tr></thead>
<tbody>
<?php foreach ($usuarios as $u): ?>
<tr>
<td><?= e($u['nome']) ?></td><td><?= e($u['email']) ?></td>
<td><?= e($u['setor']) ?></td><td><?= e($u['perfil']) ?></td>
<td><?= e(date('d/m/Y H:i', strtotime($u['criado_em']))) ?></td>
<td><a href="excluir_usuario.php?id=<?= (int)$u['id'] ?>">Excluir</a></td>
</tr>
<?php endforeach; ?>
</tbody></table></div>
<?php endif; ?>
</main>
</body></html>
