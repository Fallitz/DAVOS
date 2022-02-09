<?php
    require_once('../../../../PDO/connection.php');
    require_once('../../../../models/error.php');
    require_once('../../../../../libs/fpdf183/fpdf.php');

    header("Content-Description: File Transfer");
   
    class PDF extends FPDF
    {
        // Page header
        function Header()
        {  
            if ( $this->PageNo() === 1 ) {
                global $nomeDaFilial;
                $this->Image('../../../../../assets/images/atacadao-logo.png',10, 8,40);
                $this->Ln(3);
                $this->Cell(12);
                $this->SetFont('Arial','B',8);
                $this->Cell(15,10, $nomeDaFilial);
                $this->SetFont('Arial','B',18);
                $this->Cell(48);
                $this->Cell(15,10, 'Relatório Colaboradores - Cartões Papa-fila');
            }
           
        }

        // Page footer
        function Footer()
        {
            $this->SetY(-10);
            $this->SetFont('Arial','I',6);
            $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }
   
    if($_POST){
        if(isset($_POST["typePost"]) && $_POST['typePost'] == 6){

            $dateDe = isset($_POST["dateDe"]) ? strval($_POST["dateDe"]) : "";
            $dateAte = isset($_POST["dateAte"]) ? strval($_POST["dateAte"]) : "";
    
            if($dateDe != null and $dateAte != null){
                $pdf = new PDF();
                $pdf->AddPage('O');
                $pdf->AliasNbPages();      
    
                try{
                
                  
                    
                    $selectHistoricoCheck = $pdo->prepare("SELECT `$usuariosDB`.id AS `IDUsuario`, `$usuariosDB`.nome, `$usuariosDB`.matricula, `$historicoDB`.retirada, `$historicoDB`.devolvida,
                    `$historicoDB`.createAt, `$historicoDB`.updateAt
                    FROM `$usuariosDB`
                    INNER JOIN `$historicoDB` 
                    ON `$usuariosDB`.id = `$historicoDB`.idUser
                    WHERE `$historicoDB`.retirada <> 'NULL' AND `$historicoDB`.createAt BETWEEN :d AND :e ' 23:59:59'
                    ORDER BY `$historicoDB`.createAt;");
                    $selectHistoricoCheck->bindValue(":d", $dateDe);
                    $selectHistoricoCheck->bindValue(":e", $dateAte);
                
                    $selectHistoricoCheck->execute();

                    $resultHistorico = $selectHistoricoCheck-> rowCount();

                    if($resultHistorico > 0){

                        $pdf->Ln(15);
                        $pdf->Cell(171);
                        $pdf->SetFont('Arial','B',9);
                        $pdf->Cell(5,10, 'Período');

                        $dateDeConv = explode("-", $dateDe);
                        $dateDeConv2 = $dateDeConv[2]."/". $dateDeConv[1]."/".$dateDeConv[0];
                        $dateAteConv = explode("-", $dateAte);
                        $dateAteConv2 = $dateAteConv[2]."/". $dateAteConv[1]."/".$dateAteConv[0];
                        
                        $pdf->Cell(8);
                        $pdf->Cell(8,10, 'de:');
                        $pdf->Cell(30,10,$dateDeConv2,1,0,'C');
                        $pdf->Cell(5);
                        $pdf->Cell(8,10, 'até:');
                        $pdf->Cell(30,10, $dateAteConv2,1,0,'C');
                        $pdf->Cell(20);
                    
                        $pdf->Ln(15);
                    
                        $pdf->SetFont('Arial','B',10);
                        $pdf->Cell(62,5,'NOME',1,0,'C');
                        $pdf->Cell(25,5,'MATRICULA',1,0,'C');
                        $pdf->Cell(25,5,'RECEBIDO',1,0,'C');
                        $pdf->Cell(25,5,'DEVOLVIDO',1,0,'C');
                        $pdf->Cell(60,5,'DATA/HORA RECEBIDO',1,0,'C');
                        $pdf->Cell(60,5,'DATA/HORA DEVOLVIDO',1,0,'C');
                        $pdf->Cell(20,5,'PERDIDO',1,0,'C');


                
                        foreach($selectHistoricoCheck as $row) {
                            
                            $pdf->SetFont('Arial','B',9);
                            $pdf->Ln();
            
                            if ($row['retirada']-$row['devolvida'] > 0){
                                $pdf->SetTextColor(255,0,0);
                            }
                            if ($row['retirada']-$row['devolvida'] < 0){
                                $pdf->SetTextColor(0,0,255);
                            }
                            
                            $pdf->Cell(62,5,$row['nome'],1,0,'C');
                            $pdf->Cell(25,5,$row['matricula']-1000000000,1,0,'C');
                            $pdf->Cell(25,5,$row['retirada'],1,0,'C');
                            $pdf->Cell(25,5,$row['devolvida'],1,0,'C');
                            $pdf->Cell(60,5,$row['createAt'],1,0,'C');
                            $pdf->Cell(60,5,$row['updateAt'],1,0,'C');
                            $pdf->Cell(20,5,($row['retirada']-$row['devolvida']),1,0,'C');
                            $pdf->SetTextColor(0,0,0);
                            
                        }
                    
                        $pdf->SetFont('Arial','I',6);
                        $pdf->Ln(30);
                        $pdf->Cell(0,0,'____________________________________                                                                       ____________________________________                                                                       ____________________________________',0, 0, 'C');
                        $pdf->Ln(5);
                        $pdf->Cell(0,0,'Lider Frente de Caixa                                                                                                            Assistente de Informática                                                                                                        Supervisor Administrativo',0, 0, 'C');
                    
                        $nomeDoPdf = "Relatorio.pdf".
            
                        $pdf->Output('I');
                        
                    }else{
                        header('HTTP/1.1 200');
                        echo json_encode(
                            array(
                                'ok' => false,
                                'messages' => "Nenhum dado encontrado.",
                            )
                        );
                    }
            
                }catch(Exception $e){
                    header('HTTP/1.1 400');
                    returnErro(false, "Erro ao emitir relatório.");
                }
            }
            else{
                header('HTTP/1.1 403');
                returnErro(false, "Ação não autorizada.");
            }
        }else{
            header('HTTP/1.1 500');
            returnErro(false, "");
        }
    }
    
    
  
?>