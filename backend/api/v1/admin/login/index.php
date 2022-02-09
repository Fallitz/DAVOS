<?php                      
   
   require_once('../../../../PDO/connection.php');
   require_once('../../../../models/error.php');
   require_once('../../../../../config.php');

    if($_POST){
        $messages = "";
        $ok = false;
        $typePost = intval(isset($_POST["typePost"])) ? intval($_POST["typePost"]) : "";
        if($typePost == 3) //Login de administradores
        {
            $loginAdmin = isset($_POST["loginAdminUser"]) ? strval($_POST["loginAdminUser"]) : "";
            $pwdAdmin = isset($_POST["pwdAdminUser"]) ? strval($_POST["pwdAdminUser"]) : "";
            if($loginAdmin == $adminLogin && $pwdAdmin == $adminPassword){
                $messages = 'Logado com sucesso';
                $ok = true;   
            }else{
                //header('HTTP/1.1 401');
                $messages = "Login e/ou senha incorretos!";
                $ok = false; 
            }
            echo json_encode(
                array(
                    'ok' => $ok,
                    'messages' => $messages
                )
            );   
        } 
    }else{
        returnErro404(); 
    }
    $pdo = null;
    exit();
?>