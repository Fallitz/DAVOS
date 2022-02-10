<?php                      
   
    require_once('../../../../PDO/connection.php');
    require_once('../../../../models/error.php');
    require_once('../../../../models/util.php');
   
    if($_DELETE){
        
        $ok = false;
        $statuscode = 500;
        $typePost = isset($_DELETE["typePost"]) ? intval($_DELETE["typePost"]) : "";
        
        if($typePost == 1)
        {
            $id = isset($_DELETE["id"]) ? strval($_DELETE["id"]) : "";

            $selectUser = $pdo->prepare( "SELECT id, email FROM `$usuariosDB` WHERE id = :id;");
            $selectUser->bindParam(':id', $id);
            $selectUser->execute();
            $resultUser = $selectUser-> rowCount();
            if($resultUser > 0){
                foreach ($selectUser as $row) {  
                    $idUser = $row['id'];
                    $email = $row['email'];
                    $deleteUser = $pdo->prepare( "DELETE FROM `$usuariosDB` WHERE id = :id and email = :email;");
                    $deleteUser->bindParam(':id', $idUser);
                    $deleteUser->bindParam(':email', $email);
                    $deleteUser->execute();

                    $messages = 'Usuário deletado com sucesso';
                    $ok = true;   
                    $statuscode = 200; 
                }

            }else{
            
                $messages = 'Conta não encontrada';
                $ok = false;   
                $statuscode = 404;   

            }

            header('HTTP/1.1 '.$statuscode);
            echo json_encode(
                array(
                    'ok' => $ok,
                    'messages' => $messages
                )
            );

        }else{
            returnErro404(); 
        }
    }else{
       returnErro404(); 
    }
    $pdo = null;
    exit();
?>