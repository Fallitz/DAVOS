<?php                      
   
    require_once('../../../../PDO/connection.php');
    require_once('../../../../models/error.php');
    require_once('../../../../models/util.php');
   
    if($_PUT){

        $ok = false;
        $statuscode = 500;
        $typePost = intval(isset($_PUT["typePost"])) ? intval($_PUT["typePost"]) : "";
        
        if($typePost == 1)
        {
            $id = isset($_PUT["id"]) ? $_PUT["id"] : "";
            $selectUser = $pdo->prepare( "SELECT id FROM `$usuariosDB` WHERE id = :id;");
            $selectUser->bindParam(':id', $id);
            $selectUser->execute();
            $resultUser = $selectUser-> rowCount();

            if($resultUser > 0){

                $nome = isset($_PUT["name"]) ? strval($_PUT["name"]) : null;
                $email = isset($_PUT["email"]) ? strval($_PUT["email"]) : null;
                $phone = isset($_PUT["phone"]) ? strval($_PUT["phone"]) : null;
                $price = isset($_PUT["price"]) ? intval($_PUT["price"]) : null;
                $password = isset($_PUT["password"]) ? strval($_PUT["password"]) : null;
                $note = isset($_PUT["note"]) ? strval($_PUT["note"]) : null;
                $status = isset($_PUT["status"]) ? intval($_PUT["status"]) : null;
                $updateAt = date("Y-m-d H:i:s");

                foreach ($selectUser as $row) {  

                    $idUser = $row['id'];
                  
                    if ($nome != null) {
                        $updateName = $pdo->prepare( "UPDATE `$usuariosDB` SET nome = :nome, updateAt=:updateAt WHERE id = :id;");
                        $updateName->bindParam(':nome', $nome);
                        $updateName->bindParam(':updateAt', $updateAt);
                        $updateName->bindParam(':id', $idUser);
                        $updateName->execute();
    
                        $messages[] = 'Nome alterado com sucesso';
                    }

                    if ($email != null) {
                        $selectEmail = $pdo->prepare( "SELECT email FROM `$usuariosDB` WHERE email = :email;");
                        $selectEmail->bindParam(':email', $email);
                        $selectEmail->execute();
                        $resultEmail = $selectEmail-> rowCount();
                        if($resultEmail === 0){
                            $updateEmail = $pdo->prepare( "UPDATE `$usuariosDB` SET email = :email, updateAt=:updateAt WHERE id = :id;");
                            $updateEmail->bindParam(':email', $email);
                            $updateEmail->bindParam(':updateAt', $updateAt);
                            $updateEmail->bindParam(':id', $idUser);
                            $updateEmail->execute();
        
                            $messages[] = 'Email alterado com sucesso';
                        }
    
                    }
                    
                    if ($phone != null) {
                        $updatePhone = $pdo->prepare( "UPDATE `$usuariosDB` SET phone = :phone, updateAt=:updateAt WHERE id = :id;");
                        $updatePhone->bindParam(':phone', $phone);
                        $updatePhone->bindParam(':updateAt', $updateAt);
                        $updatePhone->bindParam(':id', $idUser);
                        $updatePhone->execute();
    
                        $messages[] = 'Telefone alterado com sucesso';
                    }
                    if ($price != null) {
                        $updatePrice = $pdo->prepare( "UPDATE `$usuariosDB` SET price = :price, updateAt=:updateAt WHERE id = :id;");
                        $updatePrice->bindParam(':price', $price);
                        $updatePrice->bindParam(':updateAt', $updateAt);
                        $updatePrice->bindParam(':id', $idUser);
                        $updatePrice->execute();
    
                        $messages[] = 'Preço alterado com sucesso';
                    }
                    if ($note != null) {
                        $updateNote = $pdo->prepare( "UPDATE `$usuariosDB` SET note = :note, updateAt=:updateAt WHERE id = :id;");
                        $updateNote->bindParam(':note', $note);
                        $updateNote->bindParam(':updateAt', $updateAt);
                        $updateNote->bindParam(':id', $idUser);
                        $updateNote->execute();
    
                        $messages[] = 'Nota alterada com sucesso';
                    }
                    if ($password != null) {
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $updatePassword = $pdo->prepare( "UPDATE `$usuariosDB` SET password = :password, updateAt=:updateAt  WHERE id = :id;");
                        $updatePassword->bindParam(':password', $hash);
                        $updatePassword->bindParam(':updateAt', $updateAt);
                        $updatePassword->bindParam(':id', $idUser);
                        $updatePassword->execute();
    
                        $messages[] = 'Senha alterada com sucesso';
                    }
                    if ($status != null) {
                        $updateStatus = $pdo->prepare( "UPDATE `$usuariosDB` SET status = :status, updateAt=:updateAt WHERE id = :id;");
                        $updateStatus->bindParam(':status', $status);
                        $updateStatus->bindParam(':updateAt', $updateAt);
                        $updateStatus->bindParam(':id', $idUser);
                        $updateStatus->execute();
    
                        $messages[] = 'Status alterado com sucesso';
                    }
                }

                $ok = true;   
                $statuscode = 200; 
                
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