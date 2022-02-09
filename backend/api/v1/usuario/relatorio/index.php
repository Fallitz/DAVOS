<?php

    require_once('../../../../PDO/connection.php');
    require_once('../../../../models/error.php');
    require_once('../../../../../libs/fpdf183/fpdf.php');

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
                $this->Cell(65);
                $this->Cell(15,10, 'Relatório Colaborador Papa-fila');
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
    
    if(isset($_POST["typePost"]) && $_POST['typePost'] == 3){

        $codColab = isset($_POST["codUser"]) ? intval($_POST["codUser"]) : "";
        $dateDe = isset($_POST["dateDe"]) ? strval($_POST["dateDe"]) : "";
        $dateAte = isset($_POST["dateAte"]) ? strval($_POST["dateAte"]) : "";

        if($codColab != null && $dateDe != null && $dateAte != null){
            $pdf = new PDF();
            $pdf->AddPage('O');
            $pdf->AliasNbPages();
           
            $selectUser = $pdo->prepare( "SELECT * FROM `$usuariosDB` WHERE matricula = $codColab;");
            $selectUser->execute();
            $resultUser = $selectUser-> rowCount();
        
            $idUser=null;
            $nomeUser=null;
            $matriculaUser=null;
            $qntTotalPerdido=null;
        
            if($resultUser > 0){

            
               //header("Content-Description: File Transfer");

                $messages = 'Sucesso';
                $ok = true;
                $dataDB = 1 . date("dmY");
                $horaDB = 1 . date("His");

                foreach ($selectUser as $row) {  
                    $idUser = $row['id'];
                    $nomeUser = strval($row['nome']);
                    $matriculaUser = $row['matricula'] - 1000000000;
                    $qntTotalPerdido = $row['qntTotalPerdido'];
                }

                $selectHistoricoCheck = $pdo->prepare("SELECT * FROM `$historicoDB` WHERE idUser = $idUser and devolvida IS NOT NULL and DATE(updateAt) BETWEEN '$dateDe' AND '$dateAte'");
            
                $selectHistoricoCheck->execute();

                $resultHistorico = $selectHistoricoCheck-> rowCount();

                if($resultHistorico > 0){
        
                    $pdf->Ln(25);
                    $pdf->SetFont('Arial','B',9);
                    $pdf->Cell(15,10, 'Nome:');
                    $pdf->Cell(100,10,$nomeUser,1,0,'C');
                    $pdf->Cell(20);
                    $pdf->Cell(20,10, 'Matrícula:');
                    $pdf->Cell(43,10, $matriculaUser,1,0,'C');
                    $pdf->Cell(20);
                    $pdf->Cell(25,10, 'Total Perdido:');
                    $pdf->Cell(30,10,$qntTotalPerdido,1,0,'C');
                    $pdf->Ln(20);
                
                    $pdf->SetFont('Arial','B',10);
                    $pdf->Cell(39,5,'RECEBIDO',1,0,'C');
                    $pdf->Cell(39,5,'DEVOLVIDO',1,0,'C');
                    $pdf->Cell(78,5,'DATA/HORA RECEBIDO',1,0,'C');
                    $pdf->Cell(78,5,'DATA/HORA DEVOLVIDO',1,0,'C');
                    $pdf->Cell(39,5,'PERDIDO',1,0,'C');
                
                

                    foreach($selectHistoricoCheck as $row) {
                
                        $pdf->SetFont('Arial','B',9);
                        $pdf->Ln();
        
                        if ($row['retirada']-$row['devolvida'] > 0){
                            $pdf->SetTextColor(255,0,0);
                        }
                        if ($row['retirada']-$row['devolvida'] < 0){
                            $pdf->SetTextColor(0,0,255);
                        }
    
                        $total = ($row['retirada']-$row['devolvida']);
                        $totalCell = 0;
                        
                        $pdf->Cell(39,5,$row['retirada'],1,0,'C');
                        $pdf->Cell(39,5,$row['devolvida'],1,0,'C');
                        $pdf->Cell(78,5,$row['createAt'],1,0,'C');
                        $pdf->Cell(78,5,$row['updateAt'],1,0,'C');
                        $pdf->Cell(39,5,$total,1,0,'C');
                        $pdf->SetTextColor(0,0,0);
                        $totalCell += $total;
    
                    }
                    $pdf->Ln();
                    $pdf->Cell(234,5, "TOTAL",1,0,'C');
                    $pdf->Cell(39,5,$totalCell,1,0,'C');
            
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
            
              
            } 
            else{
                header('HTTP/1.1 403');
                returnErro(false, "Colaborador não encontrado.");
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
  
?>