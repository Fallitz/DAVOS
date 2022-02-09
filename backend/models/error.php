<?php
    function returnErro($status, $msg){
        echo json_encode(
            array(
                'ok' => $status,
                'messages' => $msg
            )
        );
    }
    function returnErro403(){
        header('HTTP/1.1 403');
        return "Ação não autorizada.";
    }
    function returnErro401(){
        header('HTTP/1.1 401');
        return "Usuário não autorizado.";
    }
    function returnErro404(){
        header('HTTP/1.1 404');
    }
?>