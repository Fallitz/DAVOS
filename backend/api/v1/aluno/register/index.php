<?php                      
   
    require_once('../../../../PDO/connection.php');
    require_once('../../../../models/error.php');
   
    if($_POST){
        
        $messages = "";
        $ok = false;
        $statuscode = 500;
        $typePost = intval(isset($_POST["typePost"])) ? intval($_POST["typePost"]) : "";
        
        if($typePost == 1)
        {
            $email = isset($_POST["email"]) ? strval($_POST["email"]) : "";
            $selectUser = $pdo->prepare( "SELECT email FROM `$usuariosDB` WHERE email = :email;");
            $selectUser->bindParam(':email', $email);
            $selectUser->execute();
            $resultUser = $selectUser-> rowCount();
            if($resultUser > 0){
                $messages = 'Email já cadastrado';
                $ok = false;   
                $statuscode = 403;   
            }else{
               
                $nome = isset($_POST["name"]) ? strval($_POST["name"]) : exit;
                $phone = isset($_POST["phone"]) ? strval($_POST["phone"]) : exit;
                $price = isset($_POST["price"]) ? intval($_POST["price"]) : exit;
                $password = isset($_POST["password"]) ? strval($_POST["password"]) : exit;
                $note = isset($_POST["note"]) ? strval($_POST["note"]) : exit;
                $createAt = date("Y-m-d H:i:s");
                $updateAt = date("Y-m-d H:i:s");
                $status = 1;
                $uuid = uniqid(rand(), true);

                $hash = "";
                if(isset($_POST["price"])){
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                }

                $sql = "INSERT INTO $usuariosDB (id, nome, phone, email, price, password, status, note, createAt, updateAt) VALUES (:uuid, :nome, :phone, :email, :price, :password, :status, :note, :createAt, :updateAt)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':uuid', $uuid);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':password', $hash);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':note', $note);
                $stmt->bindParam(':createAt', $createAt);
                $stmt->bindParam(':updateAt', $updateAt);
                $stmt->execute();

                $messages = 'Email cadastrado com sucesso';
                $ok = true;   
                $statuscode = 200; 

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