<?php                      
   
    require_once('../../../PDO/connection.php');
    require_once('../../../models/error.php');

    if($_GET){
        $messages = "";
        $ok = false;
        $typePost = intval(isset($_GET["typePost"])) ? intval($_GET["typePost"]) : "";
        if(intval($_GET["typePost"]) == 5){
            $selectUser = $pdo->prepare( "SELECT * FROM `$estoqueDB`;");
            $selectUser->execute();
            $resultUser = $selectUser-> rowCount();
            if($resultUser > 0){
                foreach ($selectUser as $row) {  
                    $estoqueqnt = $row['quantidade'];
                }
                $messages = $estoqueqnt;
                $ok = true;    
            }else{
                $messages = "Erro";   
            }      
            echo json_encode(
                array(
                    'ok' => $ok,
                    'messages' => $messages
                )
            );
        }      
    }
    else if ($_POST){
        $ok = false;
        $typePost = intval(isset($_POST["typePost"])) ? intval($_POST["typePost"]) : "";
        $quantidade =  strval(isset($_POST["quantidade"])) ? strval($_POST["quantidade"]) : -1;
        if($typePost == 6 && strval($_POST["quantidade"]) >= 0){
            try{
                $selectUser = $pdo->prepare(" UPDATE `estoque` SET `quantidade`=$quantidade WHERE 1;");
                $selectUser->execute();
                $rowCount = $selectUser -> rowCount();
                if($rowCount > 0){
                    $ok = true;
                    echo json_encode(
                        array(
                            'ok' => $ok,
                            'messages' => "Valor de estoque alterado com sucesso."
                        )
                    );
                }else{
                    New Exception;
                }

            }catch( Exception $e){
                echo json_encode(
                    array(
                        'ok' => $ok,
                        'messages' => "Erro ao alterar valor de estoque."
                    )
                );
            }
          
        } else{
            echo json_encode(
                array(
                    'ok' => $ok,
                    'messages' => "Valor de estoque inválido."
                )
            );
        }    
    }else{
        returnErro404(); 
    }
    $pdo = null;
    exit();

?>