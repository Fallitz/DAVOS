<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-441-dist-css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="icon" href="assets/images/icon.png">
    <title>DAVOS LEARN - Home</title>
</head>
<body onkeypress="showChar(event);">
    <div class="container-fluid">
        <div class="row">
            <div class="container-interface">                
                <div class="content" id="content">
                    <div class="header">
                        <img class="logo" id="logo" src="./assets/images/logo2.png"></img>     
                        <div class="header-right">
                            <a class="active" href="/" target="_self" id="home" onclick="openHome()">Home</a>
                            <a id="register" href="/register" target="_self" onclick="openCadastro()">Register</a>
                            <a id="admin" href="/admin" target="_self" onclick="openAdmin()">Admin</a>      
                        </div>
                    </div>
                    <div class="content_page" id="content_page">
                        <!–- HOME -–>             
                        <div class="homepage" id="homepage">
                            <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-1">DAVOS LEARN</h1>
                            <p class="mbr-text pb-3 mbr-fonts-style display-7">Uma empresa especializada em ensino de tecnologias do mundo da programação. Tenha consultoria especializada para levar sua transformação digital ao próximo nível.</p>
                            <div class="mbr-section-btn">
                                <a class="btn btn-md btn-primary display-4" href="/register" target="_self">CRIAR CONTA GRATUITA</a>
                            </div>
                        </div>                 
                    </div>
                    <div class="footer_page">
                        <label class="credito">DESENVOLVIDO POR: EDENILSON SOUZA</label>
                    </div>
                </div>
                <div class="msgErrors">
                    <div class="msgBox" id="msgBox">
                        <img class="imgError" id="imgMsgBox" src="./assets/images/atencao.png" alt="">
                        <div class="msg" id="msg"></div>
                        <div class="closeMsg">
                            <img class="imgClose" id="imgClose" src="./assets/images/closeMsg.png" onclick="closeError()" alt="">
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
