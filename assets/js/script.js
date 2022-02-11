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
    document.getElementById("homepage").style.display = "none";
    document.getElementById("registerpage").style.display = "none";
    document.getElementById("adminpage").style.display = "none";
  },
};
var screens = {
  enable(screen, display) {
    functions.disable_all();
    document.getElementById(`${screen}`).style.display = display ?? "flex";
  },
};


/*JS DAVOS*/
var home = document.getElementById("home");
var register = document.getElementById("register");
var admin = document.getElementById("admin");

function openHome(){
  home.classList.add("active");
  register.classList.remove("active");
  admin.classList.remove("active");

  screens.enable("homepage", "block");
}

function openCadastro() {
  register.classList.add("active");
  home.classList.remove("active");
  admin.classList.remove("active");
  screens.enable("register");
}

function openAdmin() {
  admin.classList.add("active");
  home.classList.remove("active");
  register.classList.remove("active");


  screens.enable("wFormUserAdmin");
  document.getElementById("adminLogin").focus();
  document.getElementById("adminLogin").value = "";
  document.getElementById("adminPwd").value = "";
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

