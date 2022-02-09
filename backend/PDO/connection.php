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
        $criarHistorico = "CREATE TABLE IF NOT EXISTS `$historicoDB` (
            id int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            idUser int(10) NOT NULL,
            retirada int(100) DEFAULT NULL,
            devolvida int(100) DEFAULT NULL,
            qntCartaoPerdido int(100) DEFAULT 0,
            dataRetirada varchar(20) DEFAULT NULL,
            horaRetirada varchar(20) DEFAULT NULL,
            dataDevolvida varchar(20) DEFAULT NULL,
            horaDevolvida varchar(20) DEFAULT NULL,
            createAt TIMESTAMP NULL,
            updateAt TIMESTAMP NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
                $criarEstoque = "CREATE TABLE IF NOT EXISTS `$estoqueDB` (
                    quantidade int(10)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    
        $criarCampoData = "ALTER TABLE `$historicoDB` 
        ADD COLUMN IF NOT EXISTS `createAt` TIMESTAMP NULL AFTER `horaDevolvida`;";
        $criarCampoDate = "ALTER TABLE `$historicoDB`
        ADD COLUMN IF NOT EXISTS `updateAt` TIMESTAMP NULL AFTER `createAt`;";
        $criarQntEncontrado = "ALTER TABLE `$usuariosDB`
        ADD COLUMN IF NOT EXISTS `qntTotalEncontrado` INT(100) DEFAULT 0 AFTER `qntTotalPerdido`;";

        $pdo->query($criarUsuarios);
        $pdo->query($criarHistorico);
        $pdo->query($criarEstoque);
        $pdo->query($criarCampoData);
        $pdo->query($criarCampoDate);
        $pdo->query($criarQntEncontrado);

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