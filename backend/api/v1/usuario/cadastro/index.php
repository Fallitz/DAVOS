<?php                      
   
    require_once('../../../../PDO/connection.php');
    require_once('../../../../models/error.php');
   
    if($_POST){
        $messages = "";
        $ok = false;
        $typePost = intval(isset($_POST["typePost"])) ? intval($_POST["typePost"]) : "";
        if($typePost == 1) // 1 é cadastro de usuário
        {
            $matricula = isset($_POST["codUser"]) ? intval($_POST["codUser"]) : "";
            $nomeUser = isset($_POST["nomeUser"]) ? strval($_POST["nomeUser"]) : "";
            $selectUser = $pdo->prepare( "SELECT nome, id, matricula FROM `$usuariosDB` WHERE matricula = $matricula;");
            $selectUser->execute();
            $resultUser = $selectUser-> rowCount();
            if($resultUser > 0){
                $messages = 'Colaborador já cadastrado';
                $ok = false;      
            }else{
                if(strlen($matricula) == 10){
                    try{ 
                        $dataDB = 1 . date("dmY");
                        $horaDB = 1 . date("His");  
                        $usersSalvar = "INSERT INTO `$usuariosDB` (
                            matricula, nome, dataCriacao, horaCriacao
                        )VALUES( $matricula, '$nomeUser', $dataDB, $horaDB);";
                        $pdo->query($usersSalvar);
                        $selectUserCadastrado = $pdo->prepare( "SELECT * FROM `$usuariosDB` WHERE matricula = $matricula;");
                        $selectUserCadastrado->execute();
                        $resultCadastro = $selectUserCadastrado-> rowCount();
                        if($resultCadastro > 0){
                            $messages = 'Colaborador cadastrado com sucesso';
                            $ok = true;
                        }else{
                            throw new Exception("Erro ao cadastrar colaborador");
                        }
                    }catch (Exception $e) {
                        $messages = $e->getMessage();
                        $ok = false;
                    }
                }
                else{
                    $messages = "Código de colaborador inválido";
                    $ok = false;
                }   
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