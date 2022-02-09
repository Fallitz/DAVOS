<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-441-dist-css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="icon" href="../assets/images/icon.png">
    <title>DAVOS LEARN - Register</title>
</head>
<body onkeypress="showChar(event);">
    <div class="container-fluid">
        <div class="row">
            <div class="container-interface">                
                <div class="content" id="content">
                    <div class="header">
                        <img class="logo" id="logo" src="../assets/images/logo2.png"></img>     
                        <div class="header-right">
                            <a href="/davos/" target="_self" id="home" onclick="openHome()">Home</a>
                            <a id="register" href="/davos/register" target="_self" onclick="openCadastro()">Register</a>
                            <a class="active" id="admin" href="/davos/admin" target="_self" onclick="openAdmin()">Admin</a>      
                        </div>
                    </div>
                    <div class="content_page" id="content_page">
                        <!–- ADMIN -–>
                        <div class="adminpage" id="adminpage">
                            
                        </div>                       
                    </div>
                    <div class="footer_page">
                        <label class="credito">DESENVOLVIDO POR: EDENILSON SOUZA</label>
                    </div>
                </div>
                <div class="msgErrors">
                    <div class="msgBox" id="msgBox">
                        <img class="imgError" id="imgMsgBox" src="../assets/images/atencao.png" alt="">
                        <div class="msg" id="msg"></div>
                        <div class="closeMsg">
                            <img class="imgClose" id="imgClose" src="../assets/images/closeMsg.png" onclick="closeError()" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <script src="assets/js/script.js"></script>
    <script type="text/javascript" src="assets/js/jquery-350min.js"></script>
</body>
</html>
