<?php
    date_default_timezone_set("America/Sao_Paulo");
    include_once dirname(__FILE__).'/../../config.php';
    try {
        
        $pdo = new PDO("mysql:dbname=$db; host=$host", "$user", "$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $criarUsuarios = "CREATE TABLE IF NOT EXISTS `$usuariosDB` (
            id int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            matricula int(10) DEFAULT NULL,
            nome varchar(150) DEFAULT NULL,
            qntTotalPerdido int(100) DEFAULT 0,
            dataUltimoPerdido int(20) DEFAULT null,
            dataUltimoRetirou int(20) DEFAULT NULL,
            dataCriacao varchar(20) DEFAULT NULL,
            horaCriacao varchar(20) DEFAULT NULL)
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