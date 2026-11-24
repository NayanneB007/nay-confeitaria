// Mostra uma mensagem quando a pessoa clica no botão de boas-vindas.
const botaoBoasVindas = document.getElementById("boasVindas");
if (botaoBoasVindas) {
  botaoBoasVindas.addEventListener("click", function () {
    alert("Seja bem-vinda à Nay Confeitaria! 🍰");
  });
}

// Exemplo simples de login para praticar. Não usa banco de dados.
const formulario = document.getElementById("loginForm");
if (formulario) {
  formulario.addEventListener("submit", function (evento) {
    evento.preventDefault();
    const mensagem = document.getElementById("mensagem");
    mensagem.textContent = "Login de demonstração realizado!";
  });
}
