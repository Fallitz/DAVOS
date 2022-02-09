/*=================================== FUNÇÕES DAS MENSAGENS QUE APARECEM PARA O USUARIO ===================================*/
var delayInMilliseconds = 3000; //3 segundos para fechar a mensagem
function msgSucesso(msg, tempo) {
  var messageCadastro = document.getElementById("msgBox");
  document.getElementById("imgMsgBox").style.display = "none";
  messageCadastro.style.display = "flex";
  messageCadastro.style.backgroundColor = "#009E61";
  formConsulta.msg.innerHTML = msg;
  setTimeout(
    function () {
      document.getElementById("msgBox").style.display = "none";
    },
    tempo ? tempo : delayInMilliseconds
  );
}

function msgError(msg, tempo) {
  var messageCadastro = document.getElementById("msgBox");
  document.getElementById("imgMsgBox").style.display = "flex";
  messageCadastro.style.display = "flex";
  messageCadastro.style.backgroundColor = "#ff6600";
  formConsulta.msg.innerHTML = msg;
  setTimeout(
    function () {
      document.getElementById("msgBox").style.display = "none";
    },
    tempo ? tempo : delayInMilliseconds
  );
}
