# Matriz de testes — T01 a T12

Execute os testes após importar `banco/nay_confeitaria.sql`. Registre resultado real, data e evidência no documento impresso.

| ID | Cenário | Resultado esperado |
|---|---|---|
| T01 | Cadastrar nome, e-mail, setor e perfil válidos | Um registro é gravado e aparece na lista |
| T02 | Enviar e-mail inválido ou campo obrigatório vazio | Cadastro recusado; nenhum registro novo |
| T03 | Repetir e-mail já cadastrado | Banco impede duplicidade e mostra aviso |
| T04 | Enviar ID de setor ou perfil inexistente | Validação do servidor bloqueia o cadastro |
| T05 | Pesquisar nome/e-mail existente e inexistente | Retorna correspondências ou mensagem de lista vazia |
| T06 | Consultar usuário pela listagem com JOIN | Exibe setor e perfil associados corretamente |
| T07 | Alterar nome de setor no banco de teste | Listagem passa a mostrar o novo nome sem duplicar usuário |
| T08 | Abrir exclusão e clicar em Cancelar | Nenhuma alteração no banco |
| T09 | Confirmar exclusão | Status vira Baixa; some dos ativos; auditoria é criada |
| T10 | Tentar acessar exclusão por GET ou com token CSRF inválido | Operação não é realizada |
| T11 | Tentar confirmar novamente usuário já baixado | Operação controlada; não cria baixa duplicada |
| T12 | Inserir texto com caracteres especiais no formulário | Texto é tratado como dado; não altera consulta SQL |

## Registro do aluno
Para cada teste, anote: resultado esperado, resultado real, aprovado/reprovado, data e arquivo/captura de evidência.
