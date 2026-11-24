# Relatório da Sprint 01 — Nay-Confeitaria

**Projeto/sistema:** Nay-Confeitaria  
**Versão do código:** 1.1.0  
**Escopo:** gestão de usuários com PHP e MySQL.

## Diagnóstico inicial
O ZIP recebido continha páginas HTML, CSS e JavaScript estáticos. Não foram encontrados arquivos PHP, conexão com MySQL ou script SQL. O login e o painel existentes eram demonstrativos.

## Implementação acrescentada
- Banco com `usuarios`, `setores`, `perfis` e `auditoria_usuarios`.
- Chaves primárias e estrangeiras.
- PDO com tratamento de falha.
- Formulário com validação no navegador e no PHP.
- INSERT preparado e restrição UNIQUE para e-mail.
- Listagem e pesquisa com SELECT.
- JOIN entre as três tabelas de referência.
- Confirmação antes de exclusão.
- Baixa lógica via POST e token CSRF.
- Auditoria de cadastro e baixa.

## Arquivos adicionados
`conexao.php`, `funcoes.php`, `usuarios.php`, `cadastrar_usuario.php`, `salvar_usuario.php`, `excluir_usuario.php`, `banco/nay_confeitaria.sql`, `README.md` e este relatório.

## Consultas relacionadas
A listagem utiliza INNER JOIN:
- `usuarios.setor_id = setores.id`
- `usuarios.perfil_id = perfis.id`

As chaves estrangeiras garantem que o usuário esteja associado a referências existentes.

## Testes
Os testes T01 a T12 estão descritos em `TESTES_SPRINT.md`. Eles precisam ser executados no XAMPP local. Não declarar os testes como aprovados antes de executá-los e registrar evidências.

## Pendências conhecidas
- Login permanece demonstrativo; autenticação e permissões não fazem parte desta sprint.
- Auditoria registra o autor como `Sistema` porque não existe sessão de usuário autenticado.
- Execução e evidências no ambiente local dependem da importação do SQL e dos testes pelo aluno.
