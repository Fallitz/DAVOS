<?php                      
   
    require_once('../../../../PDO/connection.php');
    require_once('../../../../models/error.php');
     
    $selectUser = $pdo->prepare( "SELECT * FROM `$usuariosDB`;");
    $selectUser->bindParam(':email', $email);
    $selectUser->execute();
    $resultUser = $selectUser-> rowCount();

    if($resultUser > 0){
        foreach ($selectUser as $row) {  

            $idUser = $row['id'];
            $nameUser = $row['nome'];
            $emailUser = $row['email'];
            $phoneUser = $row['phone'];
            $priceUser = $row['price'];
            $noteUser = $row['note'];
            $createAtUser = $row['createAt'];
            $updateAtUser = $row['updateAt']; 
            $statusUser = $row['status'];

            $data[] = array(
                'id' => $idUser,
                'nome' => $nameUser,
                'email' => $emailUser,
                'phone' => $phoneUser,
                'price' => $priceUser,
                'note' => $noteUser,
                'createAt' => $createAtUser,
                'updateAt' => $updateAtUser,
                'status' => $statusUser
            );

        } 

        $messages = 'Usuários listados com sucesso';
        $ok = true;   
        $statuscode = 200;   

        header('HTTP/1.1 '.$statuscode);
        echo json_encode(
            array(
                'ok' => $ok,
                'messages' => $messages,
                'data' => $data
            )
        );

    }else{

        $messages = 'Nenhum usuário encontrado';
        $ok = false;   
        $statuscode = 404;   

        header('HTTP/1.1 '.$statuscode);
        echo json_encode(
            array(
                'ok' => $ok,
                'messages' => $messages
            )
        );

    }

    $pdo = null;
    exit();

?>