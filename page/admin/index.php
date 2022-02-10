<!doctype html>
<html lang="pt-BR">
<script Language=JavaScript>
    var loc = window.location.href+'';
    if (loc.indexOf('http://')==0){
        window.location.href = loc.replace('http://','https://');
    }
</script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap-441-dist-css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
    <link rel="icon" href="./../../assets/images/icon.png">
   
    <title>DAVOS LEARN - Admin</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="container-interface">                
                <div class="content" id="content">
                    <div class="header">
                        <img class="logo" id="logo" src="./../../assets/images/logo2.png"></img>     
                        <div class="header-right">
                            <a href="/" target="_self" id="home" onclick="openHome()">Home</a>
                            <a id="register" href="/page/register" target="_self" onclick="openCadastro()">Register</a>
                            <a class="active" id="admin" href="/page/admin" target="_self" onclick="openAdmin()">Admin</a>      
                        </div>
                    </div>
                    <div class="content_page" id="content_page">
                        <!–- ADMIN -–>
                        <div class="adminpage" id="adminpage">
                            <div class="admin-header">
                                <button class="btn btn-primary">Create</button>
                            </div>
                            <div class="admin-content">
                                <div class="admin-content-left">
                                    <div class="card-deck">
                                        <div class="column">
                                            <div class="card">
                                                <div class="card-body">
                                                    <input class="card-text" placeholder="Nome" value="" disabled/>
                                                    <input class="card-text" placeholder="Email" value="" disabled/>
                                                    <input class="card-text" placeholder="Telefone" value="" disabled/>
                                                    <input class="card-text" placeholder="Preço" value="" disabled/>
                                                    <input class="card-text" placeholder="Observação" value="" disabled/>
                                                    <input class="card-text" placeholder="Status" value="" disabled/>
                                                    <a class="btn btn-primary">Edit</a>
                                                    <a class="btn btn-primary">X</a>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <input class="card-text" placeholder="Nome" value="Edenilson Souza Santana" disabled/>
                                                    <input class="card-text" placeholder="Email" value="Edenilson.sza@gmail.com" disabled/>
                                                    <input class="card-text" placeholder="Telefone" value="(79)9 9988-9371" disabled/>
                                                    <input class="card-text" placeholder="Preço" value="R$ 120,00" disabled/>
                                                    <input class="card-text" placeholder="Observação" value="" disabled/>
                                                    <input class="card-text" placeholder="Status" value="Ativo" disabled/>
                                                    <a class="btn btn-primary">Edit</a>
                                                    <a class="btn btn-primary">X</a>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <input class="card-text" placeholder="Nome" value="Edenilson Souza Santana" disabled/>
                                                    <input class="card-text" placeholder="Email" value="Edenilson.sza@gmail.com" disabled/>
                                                    <input class="card-text" placeholder="Telefone" value="(79)9 9988-9371" disabled/>
                                                    <input class="card-text" placeholder="Preço" value="R$ 120,00" disabled/>
                                                    <input class="card-text" placeholder="Observação" value="" disabled/>
                                                    <input class="card-text" placeholder="Status" value="Ativo" disabled/>
                                                    <a class="btn btn-primary">Edit</a>
                                                    <a class="btn btn-primary">X</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>                       
                    </div>
                    <div class="footer_page">
                        <label class="credito">DESENVOLVIDO POR: EDENILSON SOUZA</label>
                    </div>
                </div>
                <div class="msgErrors">
                    <div class="msgBox" id="msgBox">
                        <img class="imgError" id="imgMsgBox" src="./../../assets/images/atencao.png" alt="">
                        <div class="msg" id="msg"></div>
                        <div class="closeMsg">
                            <img class="imgClose" id="imgClose" src="./../../assets/images/closeMsg.png" onclick="closeError()" alt="">
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
