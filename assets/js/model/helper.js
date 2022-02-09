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

function closePage(pageClose, pageOpen) {
  document.getElementById(pageClose).style.display = "none";
  if (pageOpen) {
    document.getElementById(pageOpen).style.display = "flex";
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
