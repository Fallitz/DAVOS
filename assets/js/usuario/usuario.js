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

