<?php                      
   
    require_once('../../../../PDO/connection.php');
    require_once('../../../../models/error.php');
   
    if($_POST){

        $messages = "";
        $ok = false;
        
        $typePost = intval(isset($_POST["typePost"])) ? intval($_POST["typePost"]) : "";
       
       
        if($typePost == 2) //Adicionar valores no historico
        {
            $matricula = isset($_POST["codUser"]) ? intval($_POST["codUser"]) : null;
            $retirado = isset($_POST["qntRetirado"]) ? intval($_POST["qntRetirado"]) : null;
            $devolvido = isset($_POST["qntDevolvido"]) ? intval($_POST["qntDevolvido"]) : null;
            $idUserHistorico = isset($_POST["idUser"]) ? intval($_POST["idUser"]) : null;
            $idHistorico = isset($_POST["idHistorico"]) ? intval($_POST["idHistorico"]) : null;
            $dataRetirado = isset($_POST["dataRetirado"]) ? intval($_POST["dataRetirado"]) : null;

            $idUser = null;
            $qntTotalPerdido = null;
            $qntCartaoPerdido = null;
            $perdidos = false;
            $debug = null;

            if(strlen($matricula) == 10){

                if($devolvido < 0){
                    $devolvido = null;
                }

                if($retirado != null && $retirado > 0){
                    
                    $selectUser = $pdo->prepare( "SELECT id, qntTotalPerdido, qntTotalEncontrado FROM `$usuariosDB` WHERE matricula = $matricula and id = $idUserHistorico;");
                    $selectUser->execute();
                    $resultUser = $selectUser-> rowCount();
                    if($resultUser > 0){
                        $dataDB = 1 . date("dmY");
                        $horaDB = 1 . date("His");
                        $ok = true;
                        foreach ($selectUser as $row) {  
                            $idUser = intval($row['id']);
                            $qntTotalPerdido = intval($row['qntTotalPerdido']);
                            $qntTotalEncontrado = intval($row['qntTotalEncontrado']);
                        }
                        if($retirado != null && $devolvido == null){
                            try{
                                $selectEstoque = $pdo->prepare( "SELECT * FROM `$estoqueDB`;");
                                $selectEstoque->execute();
                                $resultEstoque = $selectEstoque-> rowCount();

                                $estoqueqnte = null;

                                if($resultEstoque > 0){
                                    foreach ($selectEstoque as $row) {  
                                        $estoqueqnte = $row['quantidade'];
                                    }
                                    if(($estoqueqnte - $retirado) >= 0){
                                    
                                        $updateRetirado = $pdo->prepare("UPDATE `$historicoDB` SET retirada = $retirado, dataRetirada = $dataDB, horaRetirada = $horaDB, createAt = now() WHERE id = $idHistorico and idUser = $idUserHistorico and retirada IS NULL and devolvida IS NULL;");
                                        $updateRetirado->execute();
                                        $rowCount = $updateRetirado -> rowCount();
                                        if($rowCount > 0){
                                            $messages = $retirado . ' cartões foram retirados';
                                            $updateEstoque = $pdo->prepare("UPDATE `$estoqueDB` SET quantidade = $estoqueqnte - $retirado;");
                                            $updateEstoque->execute();
                                        }else{
                                            $messages = "Erro";
                                        }   
                                    }else{
                                        $ok = false;
                                        $messages = "Estoque insuficiente.";
                                    }
                                    
                                } else{
                                    throw new Exception();
                                }

                            }catch (Exception $e){
                                $ok = false;
                                $messages = returnErro403();
                            }
                        }else{
                            if($devolvido != null && $retirado != null)
                            {                       
                                try{
                                    $updateDevolvido = $pdo->prepare("UPDATE `$historicoDB` SET devolvida = $devolvido, dataDevolvida = $dataDB, horaDevolvida = $horaDB, updateAt = now() WHERE id = $idHistorico and idUser = $idUserHistorico and dataRetirada = $dataRetirado and devolvida IS NULL and retirada = $retirado;");
                                    $updateDevolvido->execute();
                                    $rowCount = $updateDevolvido -> rowCount();
                                    if($rowCount > 0){
                                     
                                        $qntCartaoPerdido = $retirado - $devolvido;
                                        
                                        $updatePerdidos = $pdo->prepare("UPDATE `$historicoDB` SET qntCartaoPerdido = $qntCartaoPerdido WHERE id = $idHistorico and idUser = $idUserHistorico and devolvida < retirada;");
                                        $updatePerdidos->execute();
                                        $rowCount = $updatePerdidos -> rowCount();
                                        if($rowCount > 0){
                                            
                                            $messages = $qntCartaoPerdido . ' cartões foram perdidos';
                                            if($qntCartaoPerdido == 1){
                                                $messages = $qntCartaoPerdido . ' cartão foi perdido';
                                            }
                                            $perdidos = true;
                                            $qntTotalPerdido += $qntCartaoPerdido;
                                            $updateTotalPerdidos = $pdo->prepare("UPDATE `$usuariosDB` SET qntTotalPerdido = $qntTotalPerdido WHERE matricula = $matricula and id = $idUserHistorico;");
                                            $updateTotalPerdidos->execute();


                                        }else{
                                            $messages = 'Todos cartões foram devolvidos';
                                        }
                                        /*
                                        if ($devolvido > $retirado){
                                            $qntCartãoEncontrado = $devolvido - $retirado;
                                            $updateEncontrado = $pdo->prepare("SELECT * FROM `$historicoDB` WHERE id = $idHistorico and idUser = $idUserHistorico and devolvida > retirada;");
                                            $updateEncontrado->execute();
                                            $rowCountEncontrado = $updateEncontrado -> rowCount();
                                            if($rowCountEncontrado > 0){
                                                
                                                $messages = $qntCartaoPerdido . ' cartões foram perdidos';
                                                if($qntCartaoPerdido == 1){
                                                    $messages = $qntCartaoPerdido . ' cartão foi perdido';
                                                }
                                                $perdidos = true;
                                                $qntTotalEncontrado += $qntCartaoPerdido;
                                                $updateTotalPerdidos = $pdo->prepare("UPDATE `$usuariosDB` SET qntTotalEncontrado = $qntTotalEncontrado WHERE matricula = $matricula and id = $idUserHistorico;");
                                                $updateTotalPerdidos->execute();


                                            }else{
                                                $messages = 'Todos cartões foram devolvidos';
                                            }
                                        }*/

                                        $selectEstoque = $pdo->prepare( "SELECT * FROM `$estoqueDB`;");
                                        $selectEstoque->execute();
                                        $resultEstoque = $selectEstoque-> rowCount();
                                        $estoqueqnte = null;
                                        if($resultEstoque > 0){
                                            foreach ($selectEstoque as $row) {  
                                                $estoqueqnte = $row['quantidade'];
                                            }
                                            $updateEstoque = $pdo->prepare("UPDATE `$estoqueDB` SET quantidade = $estoqueqnte + $devolvido;");
                                            $updateEstoque->execute();
                                        }else{
                                            $messages = "Erro";
                                        }   

                                    }else{
                                        throw new Exception();
                                    }
                                }catch (Exception $e){
                                    $ok = false;
                                    $messages = returnErro403();
                                }

                            }else{
                                $ok = false;
                                $messages = returnErro403();
                            }
                        } 
                    }else{
                        $ok = false;
                        $messages = returnErro401();
                    }
                }else{
                    $messages = returnErro403();
                    $ok = false;
                }

                if($ok == true){
                    echo json_encode(
                        array(
                            'ok' => $ok,
                            'messages' => $messages,
                            'usuario' => [
                                'idUser' => $idUser,
                                'qntTotalPerdido' => $qntTotalPerdido
                            ],
                            'historico' => [
                                'id' => $idHistorico,
                                'idUser' => $idUserHistorico,
                                'retirada' => $retirado,
                                'devolvida' => $devolvido,
                                'qntCartaoPerdido' => $qntCartaoPerdido,
                                'perdeu' => $perdidos
                            ]
                        )
                    );
                }else{
                    returnErro($ok, $messages);
                }
                
            } else{
                header('HTTP/1.1 400');
                $messages = "Código de colaborador inválido";
                returnErro($ok, $messages); 
            }               
        }    
        

    }else{
        returnErro404(); 
    }
    $pdo = null;
    exit();
?>