estoque();
var inputs = {
  error: function (input) {
    document.getElementById(`${input}`).style.borderWidth = "2px";
    document.getElementById(`${input}`).style.borderColor = "red";
  },
  ok: function (input) {
    document.getElementById(`${input}`).style.borderWidth = "0px";
    document.getElementById(`${input}`).style.borderColor = "white";
  },
};
var functions = {
  disable_all() {
    document.getElementById("wFormUserLogin").style.display = "none";
    document.getElementById("wformUserRetirada").style.display = "none";
    document.getElementById("pageRelatorio").style.display = "none";
    document.getElementById("formConfirm").style.display = "none";
    // document.getElementById("formConfirmEstoque").style.display = "none";
    document.getElementById("wFormUserSignUp").style.display = "none";
    document.getElementById("wFormUserAdmin").style.display = "none";
    document.getElementById("pageAdmin").style.display = "none";
    document.getElementById("areaButtonAdmin").style.display = "flex";
    document.getElementById("areaAdminFuncoes").style.display = "none";
    document.getElementById("adminHist").style.display = "none";
    document.getElementById("adminEstoque").style.display = "none";
    document.getElementById("pageRelatorioAdmin").style.display = "none";
    document.getElementById("containerMenu").style.display = "none";
  },
};
var screens = {
  enable(screen) {
    functions.disable_all();
    document.getElementById(`${screen}`).style.display = "flex";
  },
  consulta() {
    functions.disable_all();
    document.getElementById("wFormUserLogin").style.display = "flex";
  },
};
/*=================================== FORMULARIO DE LEITURA DE CÓDIGO PARA CONSULTA ===================================*/
document.getElementById("inputCodigoUser").focus();
const formConsulta = {
  codUser: document.getElementById("inputCodigoUser"),
  submit: document.getElementById("buttonConsultar"),
  msg: document.getElementById("msg"),
};
formConsulta.codUser.addEventListener("keyup", function (event) {
  if (event.key == "Enter") {
    clickConsulta();
  } else if (event.key == "q") {
    formConsulta.codUser.value = "";
    logo.click();
    document.getElementById("inputCodigoUser").focus();
  }
});
formConsulta.submit.addEventListener("click", () => {
  clickConsulta();
});
let responseObjectConsulta = null;
function clickConsulta() {
  if (
    !formConsulta.codUser.value ||
    formConsulta.codUser.value == null ||
    formConsulta.codUser.value == ""
  ) {
    inputs.error("inputCodigoUser");
    msgError("Erro campo vazio");
    formConsulta.codUser.value = "";
    document.getElementById("inputCodigoUser").focus();
  } else {
    inputs.ok("inputCodigoUser");
    let userMatricula = formConsulta.codUser.value;
    if (userMatricula.length == 6 || userMatricula.length == 9) {
      userMatricula = parseInt(userMatricula) + 1000000000;
      formConsulta.codUser.value = userMatricula;
    }
    const response = makeRequest(
      "post",
      "backend/api/v1/usuario/consulta/",
      `typePost=0&codUser=${userMatricula}`
    );
    response
      .then((data) => {
        handleResponseConsulta(data);
      })
      .catch((err) => console.error(err));
  }
}
function handleResponseConsulta(resObject) {
  if (resObject.ok) {
    screens.enable("wformUserRetirada");
    responseObjectConsulta = resObject;
    var retirado = document.getElementById("qntRetirado");
    var devolvido = document.getElementById("qntDevolvido");
    if (resObject.historico.retirada == null) {
      document.getElementById("horariosForm").style.display = "none";
      devolvido.disabled = true;
      devolvido.style.backgroundColor = "#a7a7a7";
      devolvido.style.opacity = "0.5";
      retirado.disabled = false;
      retirado.style.display = "flex";
      retirado.focus();
    } else {
      devolvido.disabled = false;
      devolvido.style.backgroundColor = "white";
      devolvido.style.opacity = "1";
      document.getElementById("horariosForm").style.display = "flex";
      retirado.disabled = true;
      retirado.style.display = "none";
      retirado.value = resObject.historico.retirada;
      var qntRetiradoView = document.getElementById("qntRetiradoView");
      qntRetiradoView.value = retirado.value;
      qntRetiradoView.style.color = "black";
      qntRetiradoView.style.textAlign = "center";
      var dataRetirado = document.getElementById("dataRetirado");
      dataRetirado.style.color = "black";
      dataRetirado.style.textAlign = "center";
      var dataBruto = resObject.historico.dataRetirado.split("");
      var dataModificado =
        dataBruto[1] +
        dataBruto[2] +
        "/" +
        dataBruto[3] +
        dataBruto[4] +
        "/" +
        dataBruto[7] +
        dataBruto[8];
      dataRetirado.value = dataModificado;
      var horaBruto = resObject.historico.horaRetirado.split("");
      var horaModificado =
        horaBruto[1] + horaBruto[2] + ":" + horaBruto[3] + horaBruto[4];
      var horaRetirado = document.getElementById("horaRetirado");
      horaRetirado.style.color = "black";
      horaRetirado.style.textAlign = "center";
      horaRetirado.value = horaModificado;
      devolvido.focus();
    }
    document.getElementById("infoNome").value = resObject.usuario.nomeUser;
    document.getElementById("infoMatricula").value =
      resObject.usuario.matriculaUser - 1000000000;
    document.getElementById("infoQuantidadePerdido").value =
      resObject.usuario.qntTotalPerdido;
  } else {
    inputs.error("inputCodigoUser");
    msgError(resObject.messages);
    formConsulta.codUser.value = "";
    formConsulta.codUser.focus();
  }
}
/*=================================== FORMULARIO DE CADASTRO DE NOVOS USUARIOS ===================================*/
const formCadastro = {
  codUser: document.getElementById("CodigoUserSignup"),
  nomeUser: document.getElementById("inputNomeoUser"),
  submit: document.getElementById("buttonCadastrar"),
  msg: document.getElementById("msg"),
};
formCadastro.submit.addEventListener("click", () => {
  if (formCadastro.codUser.value == "" || formCadastro.codUser.value == null) {
    document.getElementById("CodigoUserSignup").style.borderWidth = "2px";
    document.getElementById("CodigoUserSignup").style.borderColor = "red";
    msgError("Erro campo vazio");
  } else {
    document.getElementById("CodigoUserSignup").style.borderColor = "white";
    if (
      formCadastro.nomeUser.value == "" ||
      formCadastro.nomeUser.value == null
    ) {
      document.getElementById("inputNomeoUser").style.borderWidth = "2px";
      document.getElementById("inputNomeoUser").style.borderColor = "red";
      msgError("Erro campo vazio");
    } else {
      document.getElementById("inputNomeoUser").style.borderColor = "white";
      const response = makeRequest(
        "post",
        "backend/api/v1/usuario/cadastro/",
        `typePost=1&codUser=${formCadastro.codUser.value}&nomeUser=${formCadastro.nomeUser.value}`
      );
      response
        .then((data) => {
          handleResponseCadastro(data);
        })
        .catch((err) => console.error(err));
    }
  }
});
function handleResponseCadastro(resObject) {
  if (resObject.ok) {
    msgSucesso(resObject.messages);
    goHome();
  } else {
    document.getElementById("inputCodigoUser").style.borderWidth = "2px";
    document.getElementById("inputCodigoUser").style.borderColor = "red";
    msgError(resObject.messages);
  }
}
/*=================================== FORMULARIO DE INFORMAÇÔES DE USER E ATUALIZAÇÃO DE RETIRADA E DEVOLUÇÕES ===================================*/
const formSalvarDados = {
  codUser: formConsulta.codUser,
  qntRetirado: document.getElementById("qntRetirado"),
  qntDevolvido: document.getElementById("qntDevolvido"),
  submit: document.getElementById("buttonConfirmarCartao"),
  submitSalvar: document.getElementById("buttonRegistrarCartao"),
  cancel: document.getElementById("buttonCancelCartao"),
  msg: document.getElementById("msg"),
};

formSalvarDados.submit.addEventListener("click", () => {
  salvarDados();
});
formSalvarDados.submit.addEventListener("keyup", function (event) {
  if (event.key === "Enter") {
    salvarDados();
  }
});
formSalvarDados.cancel.addEventListener("click", () => {
  closeConfirm();
});

formSalvarDados.qntRetirado.addEventListener("keyup", function (event) {
  if (event.key === "Enter") {
    openConfirm();
  } else if (event.key === "Escape") {
    goHome();
  }
});
formSalvarDados.qntDevolvido.addEventListener("keyup", function (event) {
  if (event.key === "Enter") {
    openConfirm();
  } else if (event.key === "Escape") {
    goHome();
  }
});
formSalvarDados.submitSalvar.addEventListener("click", () => {
  openConfirm();
});

formSalvarDados.submitSalvar.addEventListener("keyup", function (event) {
  if (event.key === "Enter") {
    openConfirm();
  }
});
function salvarDados() {
  if (
    formSalvarDados.codUser.value == "" ||
    formSalvarDados.codUser.value == null
  ) {
    msgError(resObject.messages);
  } else {
    let userMatricula = formSalvarDados.codUser.value;
    if (userMatricula.length == 6 || userMatricula.length == 9) {
      userMatricula = parseInt(userMatricula) + 1000000000;
      formSalvarDados.codUser.value = userMatricula;
    }
    let requestDados = new XMLHttpRequest();
    requestDados.onload = () => {
      let responseObjectDados = null;
      try {
        responseObjectDados = JSON.parse(requestDados.responseText);
      } catch (e) {
        console.error("Cloud not parse JSON!");
      }
      if (responseObjectDados) {
        handleResponseSalvar(responseObjectDados);
      }
    };
    if (qntRetirado.disabled) {
      const response = makeRequest(
        "post",
        "backend/api/v1/usuario/historico/",
        `typePost=2&codUser=${formSalvarDados.codUser.value}&idUser=${responseObjectConsulta.usuario.idUser}&idHistorico=${responseObjectConsulta.historico.id}&qntRetirado=${formSalvarDados.qntRetirado.value}&qntDevolvido=${formSalvarDados.qntDevolvido.value}&dataRetirado=${responseObjectConsulta.historico.dataRetirado}`
      );
      response
        .then((data) => {
          handleResponseSalvar(data);
        })
        .catch((err) => console.error(err));
    } else {
      const response = makeRequest(
        "post",
        "backend/api/v1/usuario/historico/",
        `typePost=2&codUser=${formSalvarDados.codUser.value}&idUser=${responseObjectConsulta.usuario.idUser}&idHistorico=${responseObjectConsulta.historico.id}&qntRetirado=${formSalvarDados.qntRetirado.value}`
      );
      response
        .then((data) => {
          handleResponseSalvar(data);
        })
        .catch((err) => console.error(err));
    }
  }
}
function handleResponseSalvar(resObject) {
  if (resObject.ok) {
    document.getElementById("infoUser").style.opacity = "1";
    document.getElementById("divisor").style.opacity = "1";
    document.getElementById("formUserRetirada").style.opacity = "1";
    document.getElementById("inputCodigoUser").focus();
    document.getElementById("inputCodigoUser").value = null;
    if (resObject.historico.perdeu) {
      msgError(resObject.messages, 7000);
    } else {
      msgSucesso(resObject.messages, 5000);
    }
    goHome();
    estoque();
  } else {
    msgError(resObject.messages);
  }
}
function openConfirm() {
  if (
    (formSalvarDados.qntRetirado.value &&
      formSalvarDados.qntDevolvido.disabled == true) ||
    (formSalvarDados.qntDevolvido.value &&
      formSalvarDados.qntRetirado.disabled == true)
  ) {
    document.getElementById("formConfirm").style.display = "flex";
    document.getElementById("infoUser").style.opacity = "0.3";
    document.getElementById("divisor").style.opacity = "0.3";
    document.getElementById("formUserRetirada").style.opacity = "0.3";
    formSalvarDados.submit.focus();
  } else {
    msgError("Preencha os campos vazios");
    document.getElementById("wformUserRetirada").style.opacity = "1";
  }
}
function closeConfirm() {
  document.getElementById("formConfirm").style.display = "none";
  document.getElementById("formConfirmEstoque").style.display = "none";
  document.getElementById("infoUser").style.opacity = "1";
  document.getElementById("divisor").style.opacity = "1";
  document.getElementById("formUserRetirada").style.opacity = "1";
}

/*===================================RELATORIO DE USUARIOS==============================*/
document.getElementById("imgPDFUser").addEventListener("click", () => {
  document.getElementById("pageRelatorio").style.display = "flex";
});
document.getElementById("gerarPDFUser").addEventListener("click", () => {
  downloadPDFColab();
});
function downloadPDFColab() {
  var dataDe = document.getElementById("dateRelatorioColabDe").value;
  var dataAte = document.getElementById("dateRelatorioColabAte").value;

  if (dataDe != "" && dataAte != "") {
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
      // let responseObjectJson = null;
      try {
        responseObject = request.response;
      } catch (e) {
        console.error("Cloud not parse JSON!");
      }
      if (responseObject.type == "application/pdf") {
        var fileName = `Relatorio - ${
          document.getElementById("infoNome").value
        } - ${nameDate}`;
        var link = document.createElement("a");
        link.href = window.URL.createObjectURL(responseObject);
        link.download = fileName;
        link.click();
        document.getElementById("pageRelatorio").style.display = "none";
      } else {
        msgError("Nenhum dado encontrado");
      }
    };
    const dataCadastro = `typePost=3&codUser=${formConsulta.codUser.value}&dateDe=${dataDe}&dateAte=${dataAte}`;
    request.open("post", "backend/api/v1/usuario/relatorio/", true);
    request.responseType = "blob";
    request.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    request.send(dataCadastro);
  } else {
    msgError("Adicione datas válidas");
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
      formEstoque.estoque.focus();
    } else {
      msgError(resObject.messages);
    }
  }
}

/*=================================== FUNÇÃO PARA ABRIR O MENU DE ADMINISTRADOR ===================================*/
function openCadastro() {
  screens.enable("wFormUserSignUp");
  document.getElementById("CodigoUserSignup").focus();
}
function openAdmin() {
  screens.enable("wFormUserAdmin");
  document.getElementById("adminLogin").focus();
  document.getElementById("adminLogin").value = "";
  document.getElementById("adminPwd").value = "";
}

var logo = document.getElementById("logo");
logo.addEventListener("click", () => {
  var containermenu = document.getElementById("containerMenu");

  if (containermenu.style.display == "none") {
    containermenu.style.display = "flex";

    containermenu.animate([{ width: "4%" }, { width: "20%" }], {
      duration: 100,
      iterations: 1,
    });
  } else {
    containermenu.style.display = "none";
  }
});

/*=================================== BOTÕES QUE FECHAM AS JANELAS PRINCIPAIS ===================================*/
function goHome() {
  screens.enable("wFormUserLogin");
  document.getElementById("CodigoUserSignup").value = "";
  document.getElementById("CodigoUserSignup").style.borderColor = "white";
  document.getElementById("dateRelatorioColabDe").value = "";
  document.getElementById("dateRelatorioColabAte").value = "";
  document.getElementById("inputNomeoUser").value = "";
  document.getElementById("inputNomeoUser").style.borderColor = "white";
  document.getElementById("qntRetirado").value = "";
  document.getElementById("qntDevolvido").value = "";
  document.getElementById("infoNome").value = "";
  document.getElementById("infoMatricula").value = "";
  document.getElementById("infoQuantidadePerdido").value = "";
  document.getElementById("adminLogin").value = "";
  document.getElementById("adminLogin").style.borderColor = "white";
  document.getElementById("adminPwd").value = "";
  document.getElementById("adminPwd").style.borderColor = "white";
  document.getElementById("inputCodigoUser").value = null;
  document.getElementById("inputCodigoUser").focus();
  inputs.ok("inputCodigoUser");
}
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
function closePage(pageClose, pageOpen) {
  document.getElementById(pageClose).style.display = "none";
  if (pageOpen) {
    document.getElementById(pageOpen).style.display = "flex";
  }
}
function makeRequest(method, url, data) {
  return new Promise(function (resolve, reject) {
    let xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.onload = function () {
      if (this.status >= 200 && this.status < 300) {
        try {
          responseObject = JSON.parse(xhr.responseText);
        } catch (e) {
          console.error("Cloud not parse JSON!");
        }
        if (responseObject) {
          resolve(responseObject);
        }
      } else {
        reject({
          status: this.status,
          statusText: xhr.statusText,
        });
      }
    };
    xhr.onerror = function () {
      reject({
        status: this.status,
        statusText: xhr.statusText,
      });
    };
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(data);
  });
}

/*==================================== ESTOQUE ==================================*/
function estoque() {
  const response = makeRequest("get", "backend/api/v1/estoque/?typePost=5");
  response
    .then((data) => {
      handleResponseEstoque(data);
    })
    .catch((err) => console.error(err));
  function handleResponseEstoque(response) {
    if (response.ok) {
      document.getElementById("estoque").innerHTML = response.messages;
      document.getElementById("labelEstoqueAdmin").innerHTML =
        "Estoque atual: " + response.messages;
    } else {
      document.getElementById("estoque").innerHTML = "ERRO";
      msgError(response.messages);
    }
  }
}

function ApenasLetrasConsulta(e) {
  try {
    if (window.event) {
      var charCode = window.event.keyCode;
    }
    if ((charCode >= 48 && charCode <= 57) || charCode == 13) {
      if (e.shiftKey) {
      }
      return true;
    } else {
      msgError("Tecla não permitida");
      formConsulta.codUser.value = "";
      formConsulta.codUser.focus();
      return false;
    }
  } catch (err) {
    alert(err.Description);
  }
}
function showChar(e) {
  /* alert(
    "Key Pressed: " +
      String.fromCharCode(e.charCode) +
      "\n" +
      "charCode: " +
      e.charCode +
      "\n" +
      "SHIFT key pressed: " +
      e.shiftKey +
      "\n" +
      "ALT key pressed: " +
      e.altKey +
      "\n"
  );*/
  if (e.shiftKey && e.charCode == 33) {
    openCadastro();
  }
  if (e.shiftKey && e.charCode == 64) {
    openAdmin();
  }
}

document.addEventListener("keyup", function (event) {
  if (
    event.key === "Escape" &&
    document.getElementById("pageAdmin").style.display == "flex" &&
    document.getElementById("areaButtonAdmin").style.display == "flex"
  ) {
    goHome();
  } else if (
    event.key === "1" &&
    document.getElementById("pageAdmin").style.display == "flex" &&
    document.getElementById("areaButtonAdmin").style.display == "flex"
  ) {
    openHistorico();
  } else if (
    event.key === "2" &&
    document.getElementById("pageAdmin").style.display == "flex" &&
    document.getElementById("areaButtonAdmin").style.display == "flex"
  ) {
    openHistorico();
  } else if (
    event.key === "3" &&
    document.getElementById("pageAdmin").style.display == "flex" &&
    document.getElementById("areaButtonAdmin").style.display == "flex"
  ) {
    openHistorico();
  } else if (
    event.key === "4" &&
    document.getElementById("pageAdmin").style.display == "flex" &&
    document.getElementById("areaButtonAdmin").style.display == "flex"
  ) {
    openEstoque();
  } else if (
    event.key === "5" &&
    document.getElementById("pageAdmin").style.display == "flex" &&
    document.getElementById("areaButtonAdmin").style.display == "flex"
  ) {
    openHistorico();
  } else if (
    event.key === "Escape" &&
    document.getElementById("formConfirm").style.display == "flex"
  ) {
    closeConfirm();
    var retirado = document.getElementById("qntRetirado");
    var devolvido = document.getElementById("qntDevolvido");
    if (document.getElementById("qntRetirado").disabled == false) {
      retirado.focus();
    } else {
      devolvido.focus();
    }
  } else if (
    event.key === "Escape" &&
    document.getElementById("formConfirmEstoque").style.display == "flex"
  ) {
    closeConfirm();
    document.getElementById("adminEstoqueInput").focus();
  } else if (
    event.key === "Enter" &&
    document.getElementById("formConfirmEstoque").style.display == "flex"
  ) {
    formEstoque.submit.focus();
  } else if (
    event.key === "Escape" &&
    document.getElementById("pageAdmin").style.display == "flex" &&
    document.getElementById("areaButtonAdmin").style.display == "none"
  ) {
    closePage("areaAdminFuncoes", "areaButtonAdmin");
  }
});
