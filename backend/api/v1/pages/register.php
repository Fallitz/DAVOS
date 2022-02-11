<?php
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'register':
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
        '<div>'.
            '<input class="card-text2" placeholder="Nome" value=""/>'.
            '<input class="card-text2" placeholder="Email" value=""/>'.
            '<input class="card-text2" placeholder="Telefone" value=""/>'.
            '<input class="card-text2" placeholder="Preço" value=""/>'.
            '<input class="card-text2" placeholder="Observação" value=""/>'.
            '<input class="card-text2" placeholder="Status" value=""/>'.
            '<a class="btn btn-primary">Salvar</a>'.
            '<a class="btn btn-primary">Cancelar</a>'.
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