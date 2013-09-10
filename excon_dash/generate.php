<?php 

require_once("inc/_initialize.php"); 
require_once('fpdf/fpdf.php');

header("Content-type: application/pdf; charset=utf-8");
class PDF_appform extends FPDF {

	public $display_unit;
	

	function __construct($orientation ='P' ,$unit='pt' ,$format='Letter',$margin=40,$un="")
	{
		$this->FPDF($orientation, $unit, $format);
		$this->SetTopMargin($margin);
		$this->SetLeftMargin($margin);
		$this->SetRightMargin($margin);
		$this->display_unit=$un;

		$this->SetAutoPageBreak(true,$margin);
		$this->header=1;
	}

	function setUnit($du=""){
		$this->display_unit = $du;
		//echo $this->display_unit;
		//die();
	}

	 function getUnit(){
	 	return $this->display_unit;
	 }

	function Header(){

		if($this->header == 1)
		{	
			switch($this->display_unit)
			{
				case "A": //AREVALO
					$this->SetFont('Arial','B',10);
					$this->SetFillColor(255,255,255);
					$this->SetTextColor(0);
					$this->Cell(0, 20, "JOHN B. LACSON FOUNDATION MARITIME UNIVERSITY (AREVALO), INC.",0, 1, 'C', true);
					$this->SetFont('Arial','B',10);
					$this->Cell(0,5,"(Formerly Iloilo Maritime Academy)",0,1,'C',true);
					$this->SetFont('Arial','',10);
					$this->Cell(0,25,utf8_decode("Sto. Niño Sur, Arevalo, Iloilo City"),0,1,'C');
				 	$this->SetY(120);
					$this->SetFont('Arial','B',10);
					$this->Cell(0,5,"PERSONNEL RECRUITMENT REQUISITION FORM",0,1,'C',true);	 
					$this->Image('images/bv.png',500,35,90,60);		
					$this->Image('images/arevalo.png',35,25,80,80);	
				break;
				
				case "B": //BACOLOD
					$this->SetFont('Arial','B',10);
					$this->SetFillColor(255,255,255);
					$this->SetTextColor(0);
					$this->Cell(0, 20, "JOHN B. LACSON COLLEGES FOUNDATION (BACOLOD), INC.",0, 1, 'C', true);
					$this->SetFont('Arial','B',10);
					$this->Cell(0,5,"(Formerly Iloilo Maritime Academy)",0,1,'C',true);
					$this->SetFont('Arial','',10);
					$this->Cell(0,25,"Alijis, Bacolod City",0,1,'C');
				 	$this->SetY(120);
					$this->SetFont('Arial','B',10);
					$this->Cell(0,5,"PERSONNEL RECRUITMENT REQUISITION FORM",0,1,'C',true);	 
					$this->Image('images/bv.png',500,35,90,60);		
					$this->Image('images/bacolod.png',35,25,80,80);
				break;	

				case "M": //MOLO
					$this->SetFont('Arial','B',10);
					$this->SetFillColor(255,255,255);
					$this->SetTextColor(0);
					$this->Cell(0, 20, "JOHN B. LACSON FOUNDATION MARITIME UNIVERSITY - MOLO",0, 1, 'C', true);
					$this->SetFont('Arial','B',10);
					$this->Cell(0,5,"(Formerly Iloilo Maritime Academy)",0,1,'C',true);
					$this->SetFont('Arial','',10);
					$this->Cell(0,25,"M.H. del Pilar St., Molo, Ioilo City",0,1,'C');
				 	$this->SetY(120);
					$this->SetFont('Arial','B',10);
					$this->Cell(0,5,"PERSONNEL RECRUITMENT REQUISITION FORM",0,1,'C',true);	 
					$this->Image('images/bv.png',500,35,90,60);		
					$this->Image('images/molo.png',35,25,80,80);
				break;		

				case "S": //SYSTEM
					$this->SetFont('Arial','B',10);
					$this->SetFillColor(255,255,255);
					$this->SetTextColor(0);
					$this->Cell(0, 20, "JOHN B. LACSON FOUNDATION MARITIME UNIVERSITY",0, 1, 'C', true);
					$this->SetFont('Arial','B',10);
					$this->Cell(0,5,"(Formerly Iloilo Maritime Academy)",0,1,'C',true);
					$this->SetFont('Arial','',10);
					$this->Cell(0,25,"M.H. del Pilar St., Molo, Ioilo City",0,1,'C');
				 	$this->SetY(120);
					$this->SetFont('Arial','B',10);
					$this->Cell(0,5,"PERSONNEL RECRUITMENT REQUISITION FORM",0,1,'C',true);	 
					$this->Image('images/bv.png',500,35,90,60);		
					$this->Image('images/system.png',35,25,80,80);
				break;		

				case "T": //TRAINING CENTER
					$this->SetFont('Arial','B',10);
					$this->SetFillColor(255,255,255);
					$this->SetTextColor(0);
					$this->Cell(0, 20, "JOHN B. LACSON COLLEGES FOUNDATION - TRAINING CENTER",0, 1, 'C', true);
					$this->SetFont('Arial','B',10);
					$this->Cell(0,5,"(Formerly Iloilo Maritime Academy)",0,1,'C',true);
					$this->SetFont('Arial','',10);
					$this->Cell(0,25,"M.H. del Pilar St., Molo, Ioilo City",0,1,'C');
				 	$this->SetY(120);
					$this->SetFont('Arial','B',10);
					$this->Cell(0,5,"PERSONNEL RECRUITMENT REQUISITION FORM",0,1,'C',true);	 
					$this->Image('images/bv.png',500,35,90,60);		
					$this->Image('images/tc.png',35,25,80,80);
				break;	
			}


			//$this->Cell(0,8,"UNIT" . $this->display_unit);

			
		}

	}

	function Footer()
	{
		$this->SetY(-30);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,'"To comply with the national and international standards and strive to exceed stakeholders expectations."',0,0,'C');
	    // Go to 1.5 cm from bottom
	    $this->SetY(-15);
	    // Select Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Print centered page number
	    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
	}


	function PersonnelClassification($personclass="",$position="",$salrange="",$faculty_type=""){
		$this->SetFont('Arial','B',10);
		$this->SetTextColor(0);
		$this->SetFillColor(255,255,255);
		$this->SetY(150);
		$this->Cell(90,13,"I. Personnel Classification",0,1,'',true);
		$this->SetFont('Arial','',10);
		$this->SetLineWidth(1);
		$this->setX(50);
		//Get Pclass (Position Classification)
		switch($personclass)
		{
			case 1:
				$this->Cell(250,13,"Administrative Staff",'',1);
				break;
			case 2:
				$this->Cell(250,13,"Academic Non-Teaching Staff",'',1);
				break;
			case 3:
				$this->Cell(250,13,"Faculty",'',1);
				break;
		}
		

		
		//POSITION 
		$this->setX(50);
		$this->Cell(90,13,"Position:",'');

		$this->setX(100);
		$this->Cell(250,13,$position,'');

		//SALARY
		$this->setX(350);
		$this->Cell(90,13,"Salary Range:",'');
		$this->setX(420);
		$this->Cell(300,13,$salrange,'',1);		

		// IF FACULTY DISPLAY TYPE
		if(strlen($faculty_type) > 0)
		{
			$this->setX(50);

			switch($faculty_type)
			{
				case 1:
					$this->Cell(300,13,"Full-time",'',1);
					break;
				case 2:
					$this->Cell(300,13,"Part-time",'',1);
					break;
				case 3:
					$this->Cell(300,13,"General Education",'',1);
					break;
				case 4:
					$this->Cell(300,13,"Professional",'',1);
					break;
				case 5:
					$this->Cell(300,13,"Training Center",'',1);
					break;
			}
			
		}
		
	}


	function PersonnelCategory($personcat=""){
		$this->SetFont('Arial','B',10);
		$this->SetTextColor(0);
		$this->SetFillColor(255,255,255);
		$this->SetY(210);
		$this->Cell(90,13,"II. Personnel Category ( Need is more than 3 months )",0,1,'',true);
		
		$this->SetFont('Arial','B',10);
		$this->setX(50);
		//Get Pclass (Position Classification)
		switch($personcat)
		{

		}
		
		switch($personcat)
		{
			case 1:
				$this->Cell(200,15,"Probationary" . " - ",'');
				$this->SetFont('Arial','',10);
				$this->MultiCell(0,15,"One who is on trial by an employer during which the employer determines whether or not he is qualified for permanent employment. The position is regular (Plantilla Position) and the employee can only be terminated for just and authorized cause or for failure to meet standards.");
				break;
			case 2:
				$this->Cell(200,15,"Casual" . " - ",'');
				$this->SetFont('Arial','',10);
				$this->MultiCell(0,15,"Short term and work performed is not related to the main line of the business of the employer, after one year, considered regular employee.");
				break;
			case 3:
				$this->Cell(200,15,"Seasonal/Temporary" . " - ",'');
				$this->SetFont('Arial','',10);
				$this->MultiCell(0,15,"Unusual increase in business, hired for purposes of meeting the seasonal or peak demands of the business, after one year, considered a regular employee even if services are not continuous.");
				break;
			case 4:
				$this->Cell(200,15,"Contractual/Daily Paid" . " - ",'');
				$this->SetFont('Arial','',10);
				$this->MultiCell(0,15,"Employment has been fixed for a specific undertaking/project, the completion or termination of which has been determined at the time of the engagement of the employee, work is co-terminus with the undertaking/project. Employer is liable to pay remaining part of contract or separation pay if employee is terminated before the project/contract ends.",'',1);				
				break;
		}
		
	}

	function DepartmentInNeed($department_in_need=""){
		$this->SetFont('Arial','B',10);
		$this->SetTextColor(0);
		$this->SetFillColor(255,255,255);
		$this->SetY(310);
		$this->Cell(100,13,"III. Department/Office in Need",0,1,'',true);
		$this->SetFont('Arial','',10);
		$this->SetX(50);
		
		//INSERT DEPARTMENT
		$this->Cell(200,13,$department_in_need,'',1);
	}

	function MinimumQualification($gender="",$age_min=0,$age_max=0,$educ_attain="",$work_exp="",$other_qual=""){
		$this->SetFont('Arial','B',10);
		$this->SetTextColor(0);
		$this->SetFillColor(255,255,255);
		$this->SetY(350);
		$this->Cell(100,13,"IV. Required Minimum Qualification",0,1,'',true);
		$this->SetFont('Arial','',10);
		$this->SetX(50);
		$this->Cell(50,13,"Gender: ",'');
		
		//INSERT GENDER
		switch($gender)
		{
			case "M":
				$this->Cell(50,13,"Male",'',1);
				break;
			case "F":
				$this->Cell(50,13,"Female",'',1);
				break;
			case "A":
				$this->Cell(50,13,"Any",'',1);
				break;
		}
		
		
		$this->SetX(50);
		$this->Cell(50,18,"Age: ",'');
		$this->Cell(50,18,"Minimum: ",'');
		
		//INSERT MIN AGE
		$this->Cell(50,18,$age_min);

		$this->SetX(200);
		$this->Cell(50,18,"Maximum: ",'');
		
		//INSERT MAX AGE
		$this->Cell(50,18,$age_max,'',1);
		$this->SetX(50);
		$this->Cell(100,18,"Educational Attainment Desired:");

		//INSERT EDUCATIONAL ATTAINMENT
		$this->SetX(200);
		$this->Cell(400,18,$educ_attain,'',1);

		$this->SetX(50);
		$this->Cell(100,18,"Work Experience Desired:");

		//INSERT WORK EXPERIENCE DESIRED
		$this->SetX(200);
		$this->MultiCell(0,18,$work_exp,'',1);

		$this->Setx(50);
		$this->Cell(100,18,"Other Qualification (pls. Specify):");

		//INSERT OTHER QUALIFICATION
		$this->setX(200);
		$this->MultiCell(0,18,$other_qual,'',1);

	}

	function EmploymentHistory($employment_history=""){
		$this->SetFont('Arial','B',10);
		$this->SetTextColor(0);
		$this->SetFillColor(255,255,255);
		$this->SetY(550);
		$this->Cell(300,13,"V. Employment History with JBLF System (For Rehire) ",0,1,'',true);
		$this->SetFont('Arial','',10);
		$this->Setx(50);

		//Insert History of Employment
		$this->MultiCell(0,13,$employment_history,'',1);
	}

	function ExpectedDuration($employment_duration=""){
		$this->SetFont('Arial','B',10);
		$this->SetTextColor(0);
		$this->SetFillColor(255,255,255);
		$this->SetY(670);
		$this->Cell(300,13,"VI. Expected Duration of Employment: ",0,1,'',false);	
		
		$this->SetFont('Arial','',10);
		$this->Setx(50);

		//Insert History of Employment
		$this->Cell(500,13,$employment_duration,'',1);	
	}

	function ReasonForHiring($hiring_reason=""){
		$this->SetFont('Arial','B',10);
		$this->SetTextColor(0);
		$this->SetFillColor(255,255,255);
		$this->SetY(50);
		$this->Cell(300,13,"VII. Reason for Hiring: ",0,1,'',false);	
		
		$this->SetFont('Arial','',10);
		$this->SetX(50);

		//Insert History of Employment
		$this->MultiCell(0,13,$hiring_reason,'',1);			
	}

	function Signatures($myinfo=""){
		$this->SetFont('Arial','',10);
		$this->SetTextColor(0);
		$this->SetFillColor(255,255,255);
		$this->SetY(180);
		$this->Cell(200,13,"Requested by:");
		$this->SetXY(190,190);
		$this->SetFont('Arial','B',10);
		$this->Cell(170,13,"            " .  $myinfo,'B',0,1,'C');
		$this->Image('images/sig.png',200,150,100,60);	

		$this->SetXY(370,190);
		$this->Cell(100,13,"__________________",'',1);
		
		$this->SetFont('Arial','B',10);
		$this->SetXY(220,205);
		$this->Cell(100,13,"Department Head",'');

		$this->SetFont('Arial','',10);
		$this->SetXY(405,205);
		$this->Cell(100,13,"Date",'');



		$this->SetY(250);
		$this->Cell(190,13,"Recommending Approval:");

		$this->SetXY(170,260);
		$this->Cell(150,13,"__________________________________",'');
		$this->SetXY(370,260);
		$this->Cell(100,13,"__________________",'',1);

		$this->SetFont('Arial','B',10);
		$this->SetXY(230,275);
		$this->Cell(100,13,"Administrator",'');

		$this->SetFont('Arial','',10);
		$this->SetXY(405,275);
		$this->Cell(100,13,"Date",'');
	}

	function FinalResult(){

		
		$this->SetFont('Arial','B',14);
		$this->SetTextColor(0);
		$this->SetFillColor(255,255,255);
		$this->SetY(320);
		//Display Result
		$this->Cell(15,14,'','TLBR',0,0,'C');
		$this->SetX(75);
		$this->SetFont('Arial','B',12);
		$this->Cell(0,13,'Approved');
		$this->SetFont('Arial','',10);
		$this->SetXY(370,320);
		$this->Cell(100,13,"__________________",'',1);
		$this->SetXY(405,335);
		$this->Cell(100,13,"Date",'',1);

		$this->Cell(15,14,'','TLBR',0,0,'C');
		$this->SetX(75);
		$this->SetFont('Arial','B',12);
		$this->Cell(0,13,'Disapproved');
		$this->SetFont('Arial','',10);
		$this->SetXY(370,350);
		$this->Cell(100,13,"__________________",'',1);
		$this->SetXY(405,365);
		$this->Cell(100,13,"Date",'',1);
		
	}
}



$form = array_map('htmlspecialchars',$_POST);
// $form = iconv('UTF-8','windows-1252',$form);

$pdf = new PDF_appform('P' ,'pt' ,'Letter',40,$form['assign_unit']);
//$pdf->Output($surname.'-'.$fname.'('.$id.')'.'.pdf','D');

// echo $form['assign_unit'];
// die();
//print_r($form);
// echo "<br />";
// foreach($form as $key=>$value)
// {
// 	$f[$key] = $value;
// }
//print_r($f);

// echo $form["personclass"];
// die();


//define variables
// $personclass=$form['personclass'];
// $position=$form['position'];
// $salrange=$form['salrange'];

// $personcat=$form['personcat'];
// $department_in_need=$form['department_in_need'];
// $faculty_type=isset($form['faculty_type']) ? $form['faculty_type'] : "";
// //$faculty_type=$form['faculty_type'];
// $gender=$form['gender'];
// $age_min=$form['age_min'];
// $age_max=$form['age_max'];
// $educ_attain=$form['educ_attain'];
// $work_exp=$form['work_exp'];
// $other_qual=$form['other_qual'];

// $employment_history=$form['employment_history'];
// $employment_duration=$form['employment_duration'];
// $hiring_reason=$form['hiring_reason'];




$pdf->AddPage();
$pdf->SetFont('Arial','',10,'B');
$pdf->header = 0;
//$pdf->setUnit($form['assign_unit']);

//$pdf->SetAutoPageBreak(false);

//$height_of_cell = 60; //mm

//215.9 mm × 279.4 mm

$page_height = 279.4; //mm 
$bottom_margin = 0;

//Space left on page;
$space_left = $page_height - ($pdf->GetY() + $bottom_margin);

//echo $space_left;

$pdf->SetY(100);

$pdf->SetFont('Arial','');

$pdf->PersonnelClassification($form['personclass'],$form['position'],$form['salrange'],$form['faculty_type']);
$pdf->PersonnelCategory($form['personcat']);
$pdf->DepartmentInNeed($form['department_in_need']);
$pdf->MinimumQualification($form['gender'],$form['age_min'],$form['age_max'],utf8_decode($form['educ_attain']),$form['work_exp'],utf8_decode($form['other_qual']));
$pdf->EmploymentHistory(utf8_decode($form['employment_history']));
$pdf->ExpectedDuration($form['employment_duration']);



$pdf->Addpage();
// $pdf->header = 0;
$pdf->SetFont('Arial','',10,'B');
//$pdf->Image('img/icon.jpg',500,45,60,60);	
$pdf->ReasonForHiring(utf8_decode($form['hiring_reason']));
$pdf->Signatures(utf8_decode($form['myinfo']));
$pdf->FinalResult();
$pdf->Output('Personnel'.'-'.'Recruitement -'.date("F j, Y, g:i a").'.pdf','I');

?>
