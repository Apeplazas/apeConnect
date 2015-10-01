<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 *  ======================================= 
 *  Author     : Muhammad Surya Ikhsanudin 
 *  License    : Protected 
 *  Email      : mutofiyah@gmail.com 
 *   
 *  Dilarang merubah, mengganti dan mendistribusikan 
 *  ulang tanpa sepengetahuan Author 
 *  ======================================= 
 */  
require_once APPPATH."/third_party/pdf/fpdf.php";
 
class pdf extends FPDF { 
    public function __construct() { 
        parent::__construct(); 
    }
	
	function Header(){
		// Logo
		$this->Image(DIRGRAPHICS.'ape_logo.png',10,8);
		// Arial bold 15
		$this->SetFont('Arial','B',15);
		// Salto de línea
		$this->Ln(20);
	}
	
	function Footer()
	{
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Número de página
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function FancyTable($header, $data){
		
		// Colores, ancho de línea y fuente en negrita
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
		// Cabecera
		$w = array(40, 35, 45, 40, 35, 45, 40, 35, 45, 40);
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		$this->Ln();
		// Restauración de colores y fuentes
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Datos
		$fill = false;
		foreach($data as $row)
		{
			$this->Cell($w[0],5,$row[0],'LR',0,'L',$fill);
			$this->Cell($w[1],5,$row[1],'LR',0,'L',$fill);
			$this->Cell($w[2],5,$row[2],'LR',0,'L',$fill);
			$this->Cell($w[3],5,number_format($row[3]),'LR',0,'R',$fill);
			$this->Cell($w[4],5,number_format($row[4]),'LR',0,'R',$fill);
			$this->Cell($w[5],5,number_format($row[5]),'LR',0,'R',$fill);
			$this->Cell($w[6],5,number_format($row[6]),'LR',0,'R',$fill);
			$this->Cell($w[7],5,number_format($row[7]),'LR',0,'R',$fill);
			$this->Cell($w[8],5,number_format($row[8]),'LR',0,'R',$fill);
			$this->Cell($w[9],5,number_format($row[9]),'LR',0,'R',$fill);
			$this->Ln();
			$fill = !$fill;
		}
		// Línea de cierre
		$this->Cell(array_sum($w),0,'','T');
		
	}
	
}