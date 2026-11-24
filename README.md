# Nay-Confeitaria — Sprint 01

## Requisitos
- XAMPP com Apache e MySQL ativos.
- PHP 8 ou superior recomendado, com PDO MySQL habilitado.
- Navegador atualizado.

## Instalação
1. Extraia a pasta `nay-confeitaria` para `C:\xampp\htdocs\`.
2. Abra o XAMPP e inicie Apache e MySQL.
3. Acesse `http://localhost/phpmyadmin`.
4. Importe o arquivo `banco/nay_confeitaria.sql`.
5. Confira usuário e senha do MySQL em `conexao.php`. No XAMPP padrão, normalmente usuário `root` e senha vazia.
6. Acesse `http://localhost/nay-confeitaria/usuarios.php`.

## Módulo implementado
- Cadastro de usuário com validação no servidor.
- Consultas preparadas com PDO.
- E-mail único no banco.
- Listagem de usuários ativos e busca por nome/e-mail.
- JOIN real entre usuários, setores e perfis.
- Exclusão lógica (status Baixa), somente via POST, com token CSRF e confirmação.
- Registro de cadastro e baixa em `auditoria_usuarios`.
- Mensagens de erro sem expor SQL ou detalhes internos.

## Estrutura
- `conexao.php`: conexão PDO.
- `funcoes.php`: sessão, escape HTML, CSRF e mensagens.
- `cadastrar_usuario.php`: formulário e listas reais de setor/perfil.
- `salvar_usuario.php`: validação e INSERT.
- `usuarios.php`: SELECT, JOIN, listagem e pesquisa.
- `excluir_usuario.php`: confirmação e baixa lógica.
- `banco/nay_confeitaria.sql`: estrutura e dados fictícios.

## Observações importantes
- O ZIP original continha páginas HTML estáticas e não tinha PHP nem arquivo SQL. Os arquivos originais foram mantidos nesta atualização, e o módulo administrativo foi acrescentado.
- `login.html` continua sendo apenas uma tela demonstrativa; esta sprint não implementa autenticação, redefinição de senha ou controle de permissões.
- O campo `autor` da auditoria está como `Sistema`, pois o projeto original não possui autenticação real.
- Antes de usar em produção, implemente autenticação e autorização adequadas. Não utilize dados pessoais reais nos testes.

## Roteiro de execução
1. Importe o SQL.
2. Abra `usuarios.php`.
3. Cadastre um usuário com e-mail ainda não utilizado.
4. Atualize a listagem e confirme que o cadastro permanece.
5. Pesquise pelo nome e pelo e-mail.
6. Confira os nomes de setor e perfil exibidos pelo JOIN.
7. Teste e-mail repetido, campo vazio e IDs inválidos.
8. Abra Excluir e escolha Cancelar; o usuário deve continuar ativo.
9. Repita e confirme; o usuário deve receber status Baixa e sumir da listagem ativa.
10. Confira a tabela `auditoria_usuarios`.

## Versão
1.1.0 — módulo de gestão de usuários da Sprint 01.
