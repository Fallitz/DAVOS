<?php
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'registerPage':
                register();
                break;
            case 'insert':
                insert();
                break;
            case 'select':
                select();
                break;
        }
    }

    function select() {
        echo "The select function is called.";
        exit;
    }

    function insert() {
        echo "The insert function is called.";
        exit;
    }

    function register() {
        $data =  
        '<div class="registerForm" id="registerForm">'.
            '<input id="nomeUser" class="card-text2" placeholder="Nome" value=""/>'.
            '<input id="emailUser" class="card-text2" placeholder="Email" value=""/>'.
            '<input id="passwordUser" type="password" class="card-text2" placeholder="Senha" value=""/>'.
            '<input id="phoneUser" class="card-text2" placeholder="Telefone" value=""/>'.
            '<input id="priceUser" class="card-text2" placeholder="Preço" value=""/>'.
            '<input id="noteUser" class="card-text2" placeholder="Observação" value=""/>'.
            '<button id="SalvarUser" class="btn btn-primary">Salvar</button>'.
            '<button id="CancelarUser" class="btn btn-primary">Cancelar</button>'.
        ' </div> ';

        echo json_encode(
            array(
                "type" => "register",
                "data" => $data
            )
        );
            
        exit;
    }
?>