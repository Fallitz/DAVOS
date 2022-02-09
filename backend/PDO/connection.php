<?php
    date_default_timezone_set("America/Sao_Paulo");
    include_once dirname(__FILE__).'/../../config.php';
    try {
        
        $pdo = new PDO("mysql:dbname=$db; host=$host", "$user", "$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $criarUsuarios = "CREATE TABLE IF NOT EXISTS `$usuariosDB` (
            uui varchar(32) NOT NULL PRIMARY KEY,
            nome varchar(150) DEFAULT NULL,
            phone varchar(20) DEFAULT NULL,
            email varchar(150) DEFAULT NULL,
            price int(10) DEFAULT NULL,
            password varchar(150) DEFAULT NULL,
            status int(1) DEFAULT NULL,
            note varchar(150) DEFAULT NULL,
            createAt varchar(20) DEFAULT NULL,
            updateAt varchar(20) DEFAULT NULL)
        ";
    
        $pdo->query($criarUsuarios);
        

    } catch (PDOException $e) {
        returnErro500($e);
        exit();    
    } catch (Exception $e) {
        echo "Erro genérico: ".$e->getMessage();
        exit();
    }

    function returnErro500($e){
        header('HTTP/1.1 500');
        echo json_encode(
            array(
                'ok' => false,
                'messages' => "Servidor indisponível no momento." . $e
            )
        );
    }
?>