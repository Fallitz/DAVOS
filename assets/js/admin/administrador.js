

/*=================================== FORMULARIO DE LOGIN DE ADMINISTRADORES ===================================*/
const formAdmin = {
  loginAdmin: document.getElementById("adminLogin"),
  senhaAdmin: document.getElementById("adminPwd"),
  submit: document.getElementById("buttonLoginAdmin"),
  msg: document.getElementById("msg"),
};

formAdmin.submit.addEventListener("click", () => {
  requestLoginAdmin();
});
formAdmin.loginAdmin.addEventListener("keyup", function (event) {
  if (event.key === "Enter") {
    formAdmin.senhaAdmin.focus();
  } else if (event.key === "Escape") {
    goHome();
  }
});
formAdmin.senhaAdmin.addEventListener("keyup", function (event) {
  if (event.key === "Enter") {
    requestLoginAdmin();
  } else if (event.key === "Escape") {
    goHome();
  }
});

function requestLoginAdmin() {
  if (formAdmin.loginAdmin.value == "" || formAdmin.loginAdmin.value == null) {
    formAdmin.loginAdmin.style.borderWidth = "2px";
    formAdmin.loginAdmin.style.borderColor = "red";
    msgError("Erro campo vazio");
  } else {
    formAdmin.loginAdmin.style.borderColor = "white";
    if (
      formAdmin.senhaAdmin.value == "" ||
      formAdmin.senhaAdmin.value == null
    ) {
      formAdmin.senhaAdmin.style.borderWidth = "2px";
      formAdmin.senhaAdmin.style.borderColor = "red";
      msgError("Erro campo vazio");
    } else {
      formAdmin.senhaAdmin.style.borderColor = "white";
      const response = makeRequest(
        "post",
        "backend/api/v1/admin/login/",
        `typePost=3&loginAdminUser=${formAdmin.loginAdmin.value}&pwdAdminUser=${formAdmin.senhaAdmin.value}`
      );
      response
        .then((data) => {
          handleResponseLoginAdmin(data);
        })
        .catch((err) => console.error(err));
    }
  }
}

function handleResponseLoginAdmin(resObject) {
  if (resObject.ok) {
    formAdmin.loginAdmin.style.borderColor = "white";
    formAdmin.senhaAdmin.style.borderColor = "white";
    msgSucesso(resObject.messages);
    screens.enable("pageAdmin");
    document.getElementById("adminLogin").value = "";
    document.getElementById("adminPwd").value = "";
    document.getElementById("adminLogin").style.borderColor = "white";
    document.getElementById("adminPwd").style.borderColor = "white";
  } else {
    formAdmin.loginAdmin.style.borderWidth = "2px";
    formAdmin.loginAdmin.style.borderColor = "red";
    formAdmin.senhaAdmin.style.borderWidth = "2px";
    formAdmin.senhaAdmin.style.borderColor = "red";
    msgError(resObject.messages);
  }
}

/*================================================ HISTORICO ADMIN =============================================== */
function openHistorico() {
  document.getElementById("areaButtonAdmin").style.display = "none";
  document.getElementById("areaAdminFuncoes").style.display = "flex";
  document.getElementById("adminHist").style.display = "flex";
  var d = new Date();
  var month = d.getMonth() + 1;
  var day = d.getDate();
  var _hoje =
    d.getFullYear() +
    "-" +
    (month < 10 ? "0" : "") +
    month +
    "-" +
    (day < 10 ? "0" : "") +
    day;
  document.getElementById("inputDataHistorico").value = _hoje;
  document.getElementById("inputButtonHistorico").click();
}
/*=================================== CARREGAMENTO DO HISTORICO DO PAINEL ADMIN ===================================*/
const formDateAdmin = {
  DateSearchAdminUser: document.getElementById("inputDataHistorico"),
  submit: document.getElementById("inputButtonHistorico"),
  msg: document.getElementById("msg"),
};
formDateAdmin.submit.addEventListener("click", () => {
  const response = makeRequest(
    "post",
    "backend/api/v1/admin/historico/",
    `typePost=4&DateSearchAdminUser=${formDateAdmin.DateSearchAdminUser.value}`
  );
  response
    .then((data) => {
      handleResponseplanilhaAdmin(data);
    })
    .catch((err) => console.error(err));
});
function handleResponseplanilhaAdmin(resObject) {
  if (resObject.ok) {
    document.getElementById("planilhaAdminHistorico").innerHTML =
      resObject.table;
  } else {
    document.getElementById("planilhaAdminHistorico").innerHTML =
      "Algo deu errado, atualize a tabela novamente.";
  }
}

function openEstoque() {
  document.getElementById("areaButtonAdmin").style.display = "none";
  document.getElementById("adminHist").style.display = "none";
  document.getElementById("areaAdminFuncoes").style.display = "flex";
  document.getElementById("adminEstoque").style.display = "flex";
  document.getElementById("adminEstoqueInput").focus();
}

const formEstoque = {
  estoque: document.getElementById("adminEstoqueInput"),
  estoqueAtual: document.getElementById("estoque").value,
  submitAbriConfirmacao: document.getElementById("inputButtonEstoque"),
  submit: document.getElementById("buttonConfirmarEstoque"),
};
formEstoque.estoque.addEventListener("keyup", function (event) {
  if (event.key === "Enter") {
    document.getElementById("formConfirmEstoque").style.display = "flex";
  }
});
formEstoque.submitAbriConfirmacao.addEventListener("click", () => {
  document.getElementById("formConfirmEstoque").style.display = "flex";
});
formEstoque.submitAbriConfirmacao.addEventListener("keyup", function (event) {
  if (event.key === "Enter") {
    document.getElementById("formConfirmEstoque").style.display = "flex";
  }
});
formEstoque.submit.addEventListener("click", () => {
  salvarEstoque();
  formEstoque.estoque.value = "";
  formEstoque.estoque.focus();
});

formEstoque.submit.addEventListener("keyup", function (event) {
  if (event.key === "Enter") {
    salvarEstoque();
    /*
    formEstoque.estoque.value = "";
    formEstoque.estoque.focus();*/
  }
});

function salvarEstoque() {
  const response = makeRequest(
    "post",
    "backend/api/v1/estoque/",
    `typePost=6&quantidade=${formEstoque.estoque.value}`
  );
  response
    .then((data) => {
      handleResponseEstoque(data);
    })
    .catch((err) => console.error(err));

  function handleResponseEstoque(resObject) {
    if (resObject.ok) {
      msgSucesso(resObject.messages);
      estoque();
      closeConfirm();
    } else {
      msgError(resObject.messages);
    }
  }
}

/*===================================RELATORIO HISTORICO ADMIN==============================*/
document
  .getElementById("imgPDFAdminHistorico")
  .addEventListener("click", () => {
    document.getElementById("pageRelatorioAdmin").style.display = "flex";
  });
document.getElementById("gerarPDFAdmin").addEventListener("click", () => {
  downloadPDFAdminHistorico();
});
function downloadPDFAdminHistorico() {
  var dataDe = document.getElementById("dateRelatorioAdminDe").value;
  var dataAte = document.getElementById("dateRelatorioAdminAte").value;
  let request = new XMLHttpRequest();
  var date = new Date();
  var nameDate =
    date.getDate() +
    "_" +
    (date.getMonth() + 1) +
    "_" +
    date.getFullYear() +
    " - " +
    date.getHours() +
    "_" +
    date.getMinutes() +
    "_" +
    date.getSeconds();
  request.onload = () => {
    let responseObject = null;
    try {
      responseObject = request.response;
    } catch (e) {
      console.error("Cloud not parse JSON!");
    }
    if (responseObject.type == "application/pdf") {
      var fileName = `Relatorio - ${nameDate}`;
      var link = document.createElement("a");
      link.href = window.URL.createObjectURL(responseObject);
      link.download = fileName;
      link.click();
      document.getElementById("pageRelatorioAdmin").style.display = "none";
    } else {
      msgError("Nenhum dado encontrado");
    }
  };
  const dataCadastro = `typePost=6&dateDe=${dataDe}&dateAte=${dataAte}`;
  request.open("post", "backend/api/v1/admin/relatorio/", true);
  request.responseType = "blob";
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  request.send(dataCadastro);
}
