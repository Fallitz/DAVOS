<?php                      
   
    require_once('../../../../PDO/connection.php');
    require_once('../../../../models/error.php');
   
    if($_POST){

        $messages = "";
        $ok = false;
        
        $typePost = intval(isset($_POST["typePost"])) ? intval($_POST["typePost"]) : "";

        if($typePost == 0) // 0 é consulta de usuário
        {
            $matricula = intval(isset($_POST["codUser"])) ? intval($_POST["codUser"]) : "";
            
            $idUser = null;
            $nomeUser = null;
            $matriculaUser = null;
            $qntTotalPerdido = null;
            $dataCreate = null;
            $horaCreate = null;
            $idHistorico = null;
            $idUserHistorico = null;
            $retirada = null;
            $devolvida = null;
            $qntCartaoPerdido = null;
            $dataRetirado = null;
            $horaRetirado = null;
            $debug = null;

            if(strlen($matricula) == 10){
           
                $selectUser = $pdo->prepare( "SELECT * FROM `$usuariosDB` WHERE matricula = $matricula;");
                $selectUser->execute();
                $resultUser = $selectUser-> rowCount();

                if($resultUser > 0){

                    $messages = 'Colaborador logado com sucesso';
                    $ok = true;
                    $dataDB = 1 . date("dmY");
                    $horaDB = 1 . date("His");

                    foreach ($selectUser as $row) {  

                        $idUser = $row['id'];
                        $nomeUser = strval($row['nome']);
                        $matriculaUser = $row['matricula'];
                      //  $matri = explode(1000, $matriculaUser, 2);
                        $qntTotalPerdido = $row['qntTotalPerdido'];
                        $dataCreate = $row['dataCriacao'];
                        $horaCreate = $row['horaCriacao'];

                    }         

                    //Verificará o historico do usuario que já foi encontrado
                    $selectHistorico = $pdo->prepare("SELECT * FROM `$historicoDB` WHERE idUser = $idUser and devolvida IS NULL");
                    $selectHistorico->execute();
                    $resultHistorico = $selectHistorico-> rowCount();

                    if ($resultHistorico > 0) {

                        $selectHistoricoCheck = $pdo->prepare("SELECT * FROM `$historicoDB` WHERE idUser = $idUser and devolvida IS NULL and retirada IS NULL;");
                        $selectHistoricoCheck->execute();
                        $resultUserHistorico = $selectHistoricoCheck-> rowCount();

                        if($resultUserHistorico > 0){
                            foreach ($selectHistoricoCheck as $row) {  
                                $idHistorico = $row['id'];
                                $idUserHistorico = $row['idUser'];
                                $retirada = $row['retirada'];
                                $devolvida = $row['devolvida'];
                                $qntCartaoPerdido = $row['qntCartaoPerdido'];
                            }         
                           // $debug = "Foi encontrado um historico zerado";
                        }
                        else{

                            foreach ($selectHistorico as $row) {  
                                $idHistorico = $row['id'];
                                $idUserHistorico = $row['idUser'];
                                $retirada = $row['retirada'];
                                $devolvida = $row['devolvida'];
                                $dataRetirado = $row['dataRetirada'];
                                $horaRetirado = $row['horaRetirada'];
                                $qntCartaoPerdido = $row['qntCartaoPerdido'];
                            } 
                            
                            //$debug = "Foi encontrado um historico com cartões retirados";
                            
                        }

                        
                    }else{
                        
                        $salvarHistorico = "INSERT INTO `$historicoDB` (
                            idUser
                        )VALUES($idUser);";

                        $pdo->query($salvarHistorico);

                        $selectHistoricoCheck = $pdo->prepare("SELECT * FROM `$historicoDB` WHERE idUser = $idUser and devolvida IS NULL and retirada IS NULL;");
                        $selectHistoricoCheck->execute();
                        $resultUserHistorico = $selectHistoricoCheck-> rowCount();

                    
                        foreach ($selectHistoricoCheck as $row) {  
                            $idHistorico = $row['id'];
                            $idUserHistorico = $row['idUser'];
                            $retirada = $row['retirada'];
                            $devolvida = $row['devolvida'];
                            $qntCartaoPerdido = $row['qntCartaoPerdido'];
                        }  

                       // $debug = "FOI CRIADO UM HISTORICO ZERADO";
                            
                    }  

                    echo json_encode(
                        array(
                            'ok' => $ok,
                            'messages' => $messages,
                            'usuario' => [
                                'idUser' => $idUser,
                                'nomeUser' => $nomeUser,
                                'matriculaUser' => $matriculaUser,
                                'qntTotalPerdido' => $qntTotalPerdido,
                                'dataCreate' => $dataCreate,
                                'horaCreate' => $horaCreate
                            ],
                            'historico' => [
                                'id' => $idHistorico,
                                'idUser' => $idUserHistorico ,
                                'retirada' => $retirada,
                                'dataRetirado' => $dataRetirado,
                                'horaRetirado' => $horaRetirado//,
                               // 'debug' => $debug
                            ]
                           
                        )
                    );
                        
                }else{

                    $messages = 'Colaborador não cadastrado';
                    $ok = false;

                    echo json_encode(
                        array(
                            'ok' => $ok,
                            'messages' => $messages                           
                        )
                    );

                }
            } else{
                $messages = "Código de colaborador inválido";
                $ok = false;

                echo json_encode(
                    array(
                        'ok' => $ok,
                        'messages' => $messages                           
                    )
                );
            }
   
        }  
       
    }else{
        returnErro404(); 
    }
   
    $pdo = null;
    exit();
?>