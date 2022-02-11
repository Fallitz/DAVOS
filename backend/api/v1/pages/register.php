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
            '<input class="card-text2" placeholder="Nome" value=""/>'.
            '<input class="card-text2" placeholder="Email" value=""/>'.
            '<input type="password" class="card-text2" placeholder="Senha" value=""/>'.
            '<input class="card-text2" placeholder="Telefone" value=""/>'.
            '<input class="card-text2" placeholder="Preço" value=""/>'.
            '<input class="card-text2" placeholder="Observação" value=""/>'.
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