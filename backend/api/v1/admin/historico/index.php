<?php                      
   
   require_once('../../../../PDO/connection.php');
   require_once('../../../../models/error.php');

   if($_POST){
        $messages = "";
        $ok = false;
        $typePost = intval(isset($_POST["typePost"])) ? intval($_POST["typePost"]) : "";

        if($typePost == 4) //Atualiza historico
        {
            try{
                $loginAdmin = isset($_POST["DateSearchAdminUser"]) ? strval($_POST["DateSearchAdminUser"]) : date("Y-m-d");
                
                if($loginAdmin == ""){
                    $loginAdmin = date("Y-m-d");
                }
                        
                $selectUserTeste = $pdo->prepare("SELECT `$usuariosDB`.id AS `IDUsuario`, `$usuariosDB`.nome, `$usuariosDB`.matricula, `$historicoDB`.retirada, `$historicoDB`.devolvida,
                `$historicoDB`.createAt, `$historicoDB`.updateAt
                FROM `$usuariosDB`
                INNER JOIN `$historicoDB`  
                ON `$usuariosDB`.id = `$historicoDB`.idUser
                WHERE `$historicoDB`.retirada <> 'NULL' AND `$historicoDB`.createAt BETWEEN :d AND :d ' 23:59:59'
                ORDER BY `$historicoDB`.createAt;");

                $selectUserTeste2 = $pdo->prepare("SELECT  SUM(`$historicoDB`.retirada) AS TotalRetirada, SUM(`$historicoDB`.devolvida) AS TotalDevolvida
                FROM `$usuariosDB`
                INNER JOIN `$historicoDB`  
                ON `$usuariosDB`.id = `$historicoDB`.idUser
                WHERE `$historicoDB`.retirada <> 'NULL' AND `$historicoDB`.createAt BETWEEN :d AND :d ' 23:59:59'
                ORDER BY `$historicoDB`.createAt;");
                $selectUserTeste->bindValue(":d", $loginAdmin);
                $selectUserTeste->execute();
                $selectUserTeste2->bindValue(":d", $loginAdmin);
                $selectUserTeste2->execute();
                $resultUserTeste = $selectUserTeste-> rowCount();
                if($resultUserTeste > 0){
                    $table = 
                    "<table class='planilhaAdminHistorico' id='planilhaAdminHistorico'>".
                    "<tr>".
                        "<th style='width:40%;'>Nome</th>".
                        "<th style='width:10%;'>Matricula</th>".
                        "<th style='width:5%;'>Qnt Retirada</th>".
                        "<th style='width:5%;'>Qnt Devolução</th>".
                        "<th style='width:15%;'>Data da Retirada</th>".
                        "<th style='width:15%;'>Data da Devolução</th>".
                    "</tr>";
                    foreach ($selectUserTeste as $row) {  
                        if ($row['retirada'] == $row['devolvida']){
                        $table .= 
                        "<tr style='font-weight:bold;'>".
                            "<td>" . $row['nome'] . "</td>".
                            "<td>" . (intval($row['matricula']) - 1000000000) . "</td>".
                            "<td>" . $row['retirada'] . "</td>".
                            "<td>" . $row['devolvida'] . "</td>".
                            "<td>" . $row['createAt'] . "</td>".
                            "<td>" . $row['updateAt']. "</td>".
                        "</tr>" ;
                        }
                        else if( $row['devolvida'] > $row['retirada']){
                            $table .= 
                            "<tr style='color:blue; font-weight:bold;'>".
                                "<td>" . $row['nome'] . "</td>".
                                "<td>" . (intval($row['matricula']) - 1000000000) . "</td>".
                                "<td>" . $row['retirada'] . "</td>".
                                "<td>" . $row['devolvida'] . "</td>".
                                "<td>" . $row['createAt'] . "</td>".
                                "<td>" . $row['updateAt']. "</td>".
                            "</tr>" ;
                        }
                        else{
                            $table .= 
                            "<tr style='color:red; font-weight:bold;' >".
                                "<td>" . $row['nome'] . "</td>".
                                "<td>" . (intval($row['matricula']) - 1000000000) . "</td>".
                                "<td>" . $row['retirada'] . "</td>".
                                "<td>" . $row['devolvida'] . "</td>".
                                "<td>" . $row['createAt'] . "</td>".
                                "<td>" . $row['updateAt']. "</td>".
                            "</tr>" ;
                        }
                    }
                    foreach ($selectUserTeste2 as $row) {
                        $table .= 
                        "<tr>".
                            "<td style='font-weight:bold; border: 1px solid black;'>TOTAL</td>".
                            "<td></td>".
                            "<td>" . $row['TotalRetirada'] . "</td>".
                            "<td>" . $row['TotalDevolvida'] . "</td>".
                            "<td colspan='2'></td>".
                        "</tr>" ;
                    }
                    $table .= 
                        "<tr>".
                            "<td style='font-weight:bold'>TOTAL DE CARTÕES FALTANTES</td>".
                            "<td colspan='5'>" . ($row['TotalRetirada'] - $row['TotalDevolvida']) . "</td>".
                        "</tr>" ;
                    $table .= "</table>";
                    
                    echo json_encode(
                        array(
                            'ok' => true,
                            'table' => $table
                        )
                    );
                }
                else{
                    echo json_encode(
                        array(
                            'ok' => true,
                            'table' => "Nenhum dado encontrado."
                        )
                    );
                }
            }catch (Exception $e){
                echo json_encode(
                    array(
                        'ok' => true,
                        'table' => "Erro na pesquisa. Tente novamente. " . $e->getMessage()
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