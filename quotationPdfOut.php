<?php
  require_once 'fpdf/fpdf.php';
  require_once 'users.php';
  require_once 'userTypes.php';
  require_once 'contacts.php';
  require_once 'contactTypes.php';
  require_once 'quotations.php';
  require_once 'quotationNotes.php';
  require_once 'class/importFieldManager.php';

class PDF extends FPDF
{
    // Page header
    function Header()
    {
    	// Logo
    	$this->Image('logo.png',140,0,60);
    	// Arial bold 15
    	$this->SetFont('Arial','B',15);
    	// Move to the right
    	$this->Cell(80);
    	// Titlemilea
    	//$this->Cell(30,10,'Title',1,0,'C');
    	// Line break
    	$this->Ln(20);
    }
    
    // Page footer
    function Footer()
    {
    	// Position at 1.5 cm from bottom
    	$this->SetY(-20);
    	// Arial italic 8
    	$this->SetFont('Arial','I',8);
    	$this->SetTextColor(255,0,128); // pink
    	$this->Cell(0,5,'MN AL FALAH SDN BHD (88261-X)',0,1,'C');
    	$this->Cell(0,5,'D-11-3A, Plaza Paragon Point II, Jalan Medan Pusat Bandar 5, Seksyen 9, 43650 Bandar Baru Bangi Selangor, Malaysia',0,1,'C');
    	$this->Cell(0,5,'tel +6 03 8926 0044 mobile +6 012 2526 499 fax +6 03 8926 4873 www.mnalfalah.com.my',0,1,'C');
    	// Page number
    	// Arial bold 12
    	$this->SetFont('Arial','B',8);
    	$this->SetTextColor(0,0,0); // black
    	$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'R');
    }
    
    function mnFalahAddress()
    {
        $this->SetFont('Times','',12);
        $this->Cell(0,5,'MN AL Falah Sdn Bhd (8862661-X)',0,1);
        $this->Cell(0,5,'D-11-3A, Plaza Paragon Point 11,',0,1);
        $this->Cell(0,5,'Jalan Medan Pusat Bandar 5,',0,1);
        $this->Cell(0,5,'Seksyen 9,43650 Bandar Baru Bangi,',0,1);
        $this->Cell(0,5,'Selangor.',0,1);
        $this->Cell(0,5,' ',0,1);
        
    }
    
    function mnFalahAddressWithReference($quotationDate,$quotationRef)
    {
        $this->SetFont('Times','',12);
        $this->Cell(130,7,'MN AL Falah Sdn Bhd (8862661-X)',0);
        $this->Cell(20,7,'Date','TLRB');$this->Cell(30,7,$quotationDate,'TLRB');
        $this->Ln();
        
        $this->Cell(130,7,'D-11-3A, Plaza Paragon Point 11,',0);
        $this->Cell(20,7,'Quotation','TLRB');$this->Cell(30,7,$quotationRef,'TLRB');
        $this->Ln();
        
        $this->Cell(100,7,'Jalan Medan Pusat Bandar 5,',0,1);
        $this->Cell(100,7,'Seksyen 9,43650 Bandar Baru Bangi,',0,1);
        $this->Cell(100,7,'Selangor.',0,1);
        $this->Cell(0,7,' ',0,1);
        
    }
    
    function letterFirstPage($customerName,$customerAddress,$patientName,$userName,$quotationDate) {
        
        $this->AddPage();
        
        $newQuotationdate=date_create($quotationDate);
        $formatedDate = date_format($newQuotationdate,"jS F, Y");
        
        $this->SetTextColor(0,0,0);
        $this->SetFont('');
        $this->SetFont('Times','',12);
        $this->Cell(0,10,$formatedDate,0,1);
        $this->Cell(0,10,'Dear '.$customerName.',',0,1); //.$quotations->customerData->firstName.' '.$quotations->customerData->lastName,0,1);
        $this->Cell(0,10,' ',0,1);  // just a space
        
        $this->SetFont('Times','B',16);
        $this->SetFont('','U');
        $this->Cell(0,10,'Home Nursing Service for '.$patientName.'.',0,1);
        $this->SetFont('');
        $this->SetFont('Times','',12);
        
        $this->MultiCell(0,10,'Thank you for your enquiry with regards to Home Nursing service for patient '.$patientName.'.',0,1);
        $this->MultiCell(0,10,'Please find attached of our Quotation with the Terms & Conditions, for your kind perusal and further action.',0,1);
        $this->MultiCell(0,10,'We wish to provide our utmost care and comfort for your loved one.',0,1);
        
        $this->MultiCell(0,5,'Please do not hesitate to contact us if you wish to discuss further or to negotiate to suit your budget. We look forward to hear from you soon.',0,1);
        
        
        
        $this->Cell(0,20,'Yours sincerely,',0,1);
        $this->Cell(0,20,'Thank you and kind regards',0,1);
        $this->Cell(0,5,$userName,0,1);
        $this->Cell(0,5,'CEO',0,1);
        //$this->SetTextColor(128,0,255); // merah
        $this->SetTextColor(255,0,128); // pink
        $this->Cell(0,5,'MN AL FALAH SDN BHD (www.mnalfalah.com.my)',0,1);
        $this->Cell(0,5,'Call Centre: +6 03 8926 0044 / +6 012 252 6499',0,1);
        $this->SetTextColor(0,0,0);
        $this->mnFalahAddress();
        
    
    }  // function letterFirstPage()
    
    function quotationPage($quotationNo,$quotationDate,$customerName,$customerAddress,$customerEmail,$customerContact,
                           $patientName,$requestNote,$quotationSummary,$feeFor,$patientAddress,$patientIC) {
        
        $quotationRef = substr($quotationDate,0,4).'/'.$quotationNo;
        $this->AddPage();
        
        //$this->Cell(0,10,'Quotation  ID='.$quotations->id,0,1);
        $this->SetFont('Times','B',16);
        $this->Cell(0,10,'QUOTATION('.$quotationRef.')',0,1,'C');
        $this->SetFont('Times','',12);
        
        $this->mnFalahAddressWithReference($quotationDate,$quotationRef);
        
        $this->chapterUnique('Our unique features in serving you better','unique.txt');
    
        /*
        $this->Cell(0,10,'Date	: '.'2016-08-02',0,1); //$quotations->quotationDate,0,1);
        $this->Cell(0,10,'For the attention of	: Velawani Menach',0,1); //.$quotations->customerData->firstName.' '.$quotations->customerData->lastName,0,1);
        $this->Cell(0,10,'Address	: No 14, Jln 4/3, Seksyen 20, Shah Alam',0,1); //.$quotations->customerData->address.' '.$quotations->customerData->city.' '.$quotations->customerData->postcode.' '.$quotations->customerData->state,0,1);
        $this->Cell(0,10,'Email	: Velawan@gmail.com',0,1); // .$quotations->customerData->email,0,1);
        $this->Cell(0,10,'Telefon Number	: 0122250716',0,1); //.$quotations->customerData->mobile.' '.$quotations->customerData->office.' '.$quotations->customerData->home.' ',0,1);
        $this->Cell(0,10,'For patient : Weerayah',0,1); //.$quotations->patientData->firstName.' '.$quotations->patientData->lastName,0,1);
        $this->Cell(0,10,'Your request	: 1. Daily Cleaning twice for dad',0,1);
        */
        $this->Ln(20);
        // Colors of frame, background and text
    	$this->SetDrawColor(0,0,0);
    	$this->SetFillColor(128,128,128);  //Kelabu : #C0C0C0 : 192,192, 192
    	$this->SetTextColor(0,0,0); // Hitam : 0000000
    	// Thickness of frame (1 mm)
    	//$this->SetLineWidth(1);
        $this->Cell(0,10,'DETAIL OF CUSTOMER','TBLR',0,'C',true);
        
        //$this->SetDrawColor(0,0,0);
    	//$this->SetFillColor(255,255,255);  //Putih: #FFFFFF  : 255,255,255
    	//$this->SetTextColor(0,0,0); // Hitam : 0000000
        //$this->SetLineWidth(0.5);
        
        $newQuotationdate=date_create($quotationDate);
        $formatedDate = date_format($newQuotationdate,"jS F, Y");
        
        $this->Ln();
        $this->Cell(80,7,'Date','TBLR');$this->Cell(0,7,$formatedDate,'TBLR');
        $this->Ln();
        $this->Cell(80,7,'For the attention of','TBLR'); $this->Cell(0,7,$customerName,'TBLR');
        $this->Ln();
        $this->Cell(80,7,'Address','TBLR'); $this->Cell(0,7,$customerAddress,'TBLR');
        $this->Ln();
        $this->Cell(80,7,'Email','TBLR'); $this->Cell(0,7,$customerEmail,'TBLR');
        $this->Ln();
        $this->Cell(80,7,'Telephone','TBLR'); $this->Cell(0,7,$customerContact,'TBLR');
        $this->Ln();
        $this->Cell(80,7,'Requirements','TBLR'); $this->Cell(0,7,$feeFor,'TBLR');
        $this->Ln();
        $this->Cell(80,7,'Patient Name','TBLR'); $this->Cell(0,7,$patientName,'TBLR');
        $this->Ln();
        $this->Cell(80,7,'Patient IC','TBLR'); $this->Cell(0,7,$patientIC,'TBLR');
        $this->Ln();
        $this->Cell(80,7,'Patient Address','TBLR'); $this->Cell(0,7,$patientAddress,'TBLR');
        $this->Ln();
        
        // special case for request note ...
            // Wrap at 50 characters
            $x = 50;
            $lines = explode("\n", wordwrap($requestNote, $x));
            $thefirstLine=true;
            foreach($lines as $eachLine)
            {
                if($thefirstLine) {
                    $this->Cell(80,7,'Your request','LR'); $this->Cell(0,7,$eachLine,'LR');
                    $this->Ln();
                    $thefirstLine=false;
                } else {
                    $this->Cell(80,7,' ','LR'); $this->Cell(0,7,$eachLine,'LR');
                    $this->Ln();
                }
            }

        //$this->SetTextColor(128,0,255); // merah - bukan ni
        $this->Cell(80,7,'Timing','TBLR');$this->MultiCell(0,7,$quotationSummary,'TBLR');
        $this->Ln();
        /*
        //$this->SetTextColor(255,255,255); // putih
        $this->SetTextColor(255,0,0); // merah
        $this->Cell(80,7,' ','TBLR'); $this->MultiCell(0,7,'** 24-hour care involves 2 caregivers taking shifts to look after the patient','TBLR');
        $this->Ln();
        //$this->SetTextColor(0,0,0); // hitam
        $this->Cell(80,7,' ','TBLR'); $this->MultiCell(0,7,'** Stay-in caregiver rate is similar to a 12-hour caregiver service rate','TBLR');
        $this->Ln();
        */
    
    }  //function quotationPage() {
    
    
    function chapterUnique($title,$file)
    {
        
        $this->SetTextColor(0,0,0); // black
        $this->SetFillColor(255,255,255);//white
        $this->SetLineWidth(1);
        
        // Line break
    	$this->Ln();
        // Mention in italics
    	$this->SetFont('','B');
    	$this->Cell(0,5,$title,'LRT');
    		// Line break
    	$this->Ln();
    
    	// Read text file
    	$txt = file_get_contents($file);
    	// Times 12
    	$this->SetFont('Times','',12);
    	// Output justified text
    	$this->MultiCell(0,10,$txt,'LR');// 1st parameter is the size of box. If 0, means it will occupies to whole page width
    	                              // 2nd parameter is the space between text lines. If 5 - very close, if 10, is much distance betweeen lines
    	                              // 4th parameter is the border. If 0 - no border. If 1 - there is a border
    	                              // OR 'LRT' - Left, Right, Top
    	// Line break
    	//$this->Ln();
    	$this->Cell(0,5,' ','LRB');
    	
    	$this->SetLineWidth(0.5);
    
    }
     
    function chapterBody($file)
    {
    	// Read text file
    	$txt = file_get_contents($file);
    	// Times 12
    	$this->SetFont('Times','',12);
    	// Output justified text
    	$this->MultiCell(0,5,$txt);
    	// Line break
    	$this->Ln();
    	// Mention in italics
    	$this->SetFont('','I');
    	$this->Cell(0,5,'(end of excerpt)');
    }
    function chapterTitle($label,$alignment)
    {
    	// Title
    	//$this->SetFont('Arial','',12);
    	//$this->SetFillColor(200,220,255);
    	$this->SetFont('Times','BU',12); // set as bold
    	$this->Cell(0,6,"$label",0,1,$alignment,true);
    	$this->Ln(4);
    	// Save ordinate
    	//$this->y0 = $this->GetY();
    	$this->SetFont('Times','',12);  // reset the bold
    }
    
    	
    function spaceSeparation($firstColumnSize,$lineSpaceEmptyLine) {
        
        $this->Cell($firstColumnSize,$lineSpaceEmptyLine,' ','L');
    	$this->Cell(4,$lineSpaceEmptyLine,' ','R');$this->Cell(0,$lineSpaceEmptyLine,' ','R');
    	$this->Ln();
    	
    }	
    function lineSeparation($firstColumnSize,$lineSpaceEmptyLine) {
        
        $this->Cell($firstColumnSize,$lineSpaceEmptyLine,' ','LB');
    	$this->Cell(4,$lineSpaceEmptyLine,' ','RB');$this->Cell(0,$lineSpaceEmptyLine,' ','RB');
    	$this->Ln();
    	
    	// add another line
    	$this->Cell($firstColumnSize,$lineSpaceEmptyLine,' ','L');
    	$this->Cell(4,$lineSpaceEmptyLine,' ','R');$this->Cell(0,$lineSpaceEmptyLine,' ','R');
    	$this->Ln();
    	
    }
    
    function chargePage($title,$patientName, $patientIC, $patientAddress,$hourPerDay,$basicCharge,
                        $startDate,$endDate,$mileage,$adminFee,$gst,$totalAmount,$intervalDays,$feeFor,
                        $physiotherapy,$quotationSummary,$additionalCharge,
                        $nurseVisit,$doktorVisit,$physioDays,$nurseVisitDays,$doctorVisitDays) {
    
        $this->SetTextColor(0,0,0); // hitam
        $this->AddPage();
        
        $this->chapterTitle($title,'C');
        
        $this->Cell(40,7,'For patient',0); $this->Cell(4,7,':',0); $this->Cell(100,7,$patientName,0);
        $this->Ln();
        $this->Cell(40,7,'IC',0); $this->Cell(4,7,':',0); $this->Cell(100,7,$patientIC,0);
        $this->Ln();
        $this->Cell(40,7,'Address',0); $this->Cell(4,7,':',0); $this->Cell(100,7,$patientAddress,0);
        $this->Ln();
        
        //1st column size 
        $firstColumnSize = 70;
        $lineSpace = 7;
        $lineSpaceEmptyLine = 5;
        
        
        //top line
        $this->Ln();
    	$this->SetFont('Times','',12);
    	$this->Cell($firstColumnSize,$lineSpace,' ','LT');
    	$this->Cell(4,$lineSpace,' ','TR');$this->Cell(0,$lineSpace,' ','TR');
    	$this->Ln();
    	
        if($doktorVisit === 'yes') {
        	//Doctor - 1st Session: RM 380
        	$this->SetFont('','B');
        	$this->Cell($firstColumnSize,$lineSpace,'Doctor House call','L');
        	$this->SetFont('Times','',12);
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'RM380 X '.$doctorVisitDays.' days : RM '.($doctorVisitDays*380),'R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
            //*Upon request
        	$this->Cell($firstColumnSize,$lineSpace,' ','L');
        	$this->SetFont('Times','',12);
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'*Upon request','R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	//line separation
    	    $this->lineSeparation($firstColumnSize,$lineSpaceEmptyLine);

    	}
    	
    	if($nurseVisit === 'yes') {
        	$this->SetFont('','B');
        	$this->Cell($firstColumnSize,$lineSpace,'FIRST VISIT BY NURSE','L');
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'1st Session: RM 250','R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	$this->Cell($firstColumnSize,$lineSpace,'First Visit, Assesment, Dressing','L');
        	$this->Cell(4,$lineSpace,' ','R');
        	if(($nurseVisitDays-1) > 0) {    
        	    $this->Cell(0,$lineSpace,'Subsequent Visits RM220 X '.($nurseVisitDays-1).' days: RM '.(($nurseVisitDays-1)*220),'R');
        	} else {
        	    $this->Cell(0,$lineSpace,'Subsequent Visits RM220','R');
        	}
        	$this->Ln();
        
            //*Upon request
        	$this->Cell($firstColumnSize,$lineSpace,'& Recommendation','L');
        	$this->SetFont('Times','',12);
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'*Upon request','R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	//line separation
    	    $this->lineSeparation($firstColumnSize,$lineSpaceEmptyLine);

    	}
    	
    	if($intervalDays > 0) {
    	
        	// the title
            
            $titleFeeFor = strtoupper($feeFor.' SERVICE');
        	$this->SetFont('','BU');
        	$this->Cell($firstColumnSize,$lineSpace,$titleFeeFor,'L');
        	$this->SetFont('Times','',12);
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,strtoupper($quotationSummary),'R');
        	$this->Ln();
        	
        	/* Let me put this -- on the next column... because it is too long
        	//(MON – FRI) X 20 DAYS / MONTH
        	$this->SetFont('','BI');
        	$this->Cell($firstColumnSize,$lineSpace,strtoupper($quotationSummary),'L');
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,' ','R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	*/
        	//just a space
        	$this->Cell($firstColumnSize,$lineSpaceEmptyLine,' ','L');
        	$this->Cell(4,$lineSpaceEmptyLine,' ','R');$this->Cell(0,$lineSpaceEmptyLine,' ','R');
        	$this->Ln();
        	
        	
        	//a) 08-hour care @ RM 160 x 20 days
        	$this->SetFont('','BI');
        	$this->Cell($firstColumnSize,$lineSpace,'a) '.$hourPerDay.'-hour care @ RM '.$basicCharge.' x '.$intervalDays.' days','L');
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'a) '.$hourPerDay.'-hour care @ RM '.$basicCharge*$intervalDays,'R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	//just a space
        	$this->Cell($firstColumnSize,$lineSpaceEmptyLine,' ','L');
        	$this->Cell(4,$lineSpaceEmptyLine,' ','R');$this->Cell(0,$lineSpaceEmptyLine,' ','R');
        	$this->Ln();
        	
        	// b) Mileage @ RM300.00(+gst)
        	//$this->SetFont('','BI');
        	$this->Cell($firstColumnSize,$lineSpace,'b) Mileage @ RM'.$mileage.' x '.$intervalDays.' days','L');
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'b) Mileage @ RM '.$mileage*$intervalDays,'R');
        	$this->SetFont('Times','',12);
        	$this->Ln();

        	//c) Admin Fees @ RM200.00(+gst)/pa
        	$this->Cell($firstColumnSize,$lineSpace,'c) Admin Fees @ RM'.$adminFee,'L');
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'c) Admin Fees @ RM '.$adminFee,'R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	//d) gst
        	$this->Cell($firstColumnSize,$lineSpace,'d) GST for Admin Fees and Mileage','L');
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'d) GST @ RM '.$gst,'R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	//e) Additional Charge
        	if($additionalCharge > 0) {
            	$this->Cell($firstColumnSize,$lineSpace,'e) Additional Charge','L');
            	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'e) Additional Charge @ RM '.$additionalCharge,'R');
            	$this->SetFont('Times','',12);
            	$this->Ln();    
        	}
        	
        	
        	//space separation
        	$this->spaceSeparation($firstColumnSize,$lineSpaceEmptyLine);
        	
        	
        	// TOTAL @ RM 3,730
        	$this->Cell($firstColumnSize,$lineSpace,' ','L');
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'TOTAL @ RM '.$totalAmount,'R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	// Additional RM 100 for Weekend & Public Holidays
        	$this->Cell($firstColumnSize,$lineSpace,'Additional RM 100 for Weekend','L');
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,' ','R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	$this->Cell($firstColumnSize,$lineSpace,'& Public Holidays','L');
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,' ','R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	//line separation
        	$this->lineSeparation($firstColumnSize,$lineSpaceEmptyLine);
        	
        }
    	    	
    	if($physiotherapy === 'yes') {
        	//PHYSIOTHERAPY - 1st Session: RM 230
        	// 22/8/2016 3:49PM : RM230 --> RM250
        	$this->Cell($firstColumnSize,$lineSpace,' ','L');
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'1st Session: RM 250','R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	//PHYSIOTHERAPY - Subsequent Visits:
        	// 22/8/2016 3:49PM  :Subsequent tukar lah kan?. .dari RM180--> RM180 juga. .tak tukar
        	$this->SetFont('','B');
        	$this->Cell($firstColumnSize,$lineSpace,'Physiotherapy','L');
        	$this->SetFont('Times','',12);
        	if(($physioDays-1) > 0) {
        	    $this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'Subsequent Visits RM 180 X '.($physioDays-1).' days: RM'.($physioDays-1)*180,'R');
        	} else {
        	    $this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'Subsequent Visits: RM 180','R');
        	}
        	
        	$this->SetFont('Times','',12);
        	$this->Ln();
        
            //*Upon request
        	$this->Cell($firstColumnSize,$lineSpace,' ','L');
        	$this->SetFont('Times','',12);
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'*Upon request','R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	//line separation
    	    $this->lineSeparation($firstColumnSize,$lineSpaceEmptyLine);

    	}
    	
    	//(as per market price)
    	$this->SetFont('','B');
    	$this->Cell($firstColumnSize,$lineSpace,'Additional Equipment','L');
    	$this->SetFont('Times','',12);
    	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'(as per market price)','R');
    	$this->SetFont('Times','',12);
    	$this->Ln();
    	
    	//ADDITIONAL EQUIPMENT
    	$this->Cell($firstColumnSize,$lineSpace,' ','L');
    	$this->SetFont('Times','',12);
    	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'*Upon request','R');
    	$this->SetFont('Times','',12);
    	$this->Ln();
    	
    	//line separation
    	$this->lineSeparation($firstColumnSize,$lineSpaceEmptyLine);
    	
    	//TOTAL FEES at start of service
    	$this->SetFont('','B');
    	$this->Cell($firstColumnSize,$lineSpace,'TOTAL FEES at start of service','LB');
    	$this->Cell(4,$lineSpace,' ','RB');$this->Cell(0,$lineSpace,'RM'.$totalAmount,'RB');
    	$this->SetFont('Times','',12);
    	$this->Ln();
    	
    	
    	//The Company reserves the right to amend and/ or change the rates offered, according to current economic situation and government compliance.
    	$this->Cell(4,$lineSpace,'   -',' ');
    	$this->SetFont('Times','',12);
    	$this->Cell(4,$lineSpace,' ',' ');$this->MultiCell(0,$lineSpace,'The Company reserves the right to amend and/ or change the rates offered, according to current economic situation and government compliance.',' ');
    	$this->SetFont('Times','',12);
    	//$this->Ln();
    	
    	//Special rates are offered for long-term care services (3 months or more).
    	$this->Cell(4,$lineSpace,'   -',' ');
    	$this->SetFont('Times','',12);
    	$this->Cell(4,$lineSpace,' ',' ');$this->MultiCell(0,$lineSpace,'Special rates are offered for long-term care services (3 months or more).',' ');
    	$this->SetFont('Times','',12);
    	//$this->Ln();
    	
    	//***Negotiation is welcomed.
    	$this->Cell(4,$lineSpace,'   -',' ');
    	$this->SetFont('Times','',12);
    	$this->Cell(4,$lineSpace,' ',' ');$this->MultiCell(0,$lineSpace,'***Negotiation is welcomed.',' ');
    	$this->SetFont('Times','',12);
    	$this->Ln();
    	
    	//Terms and Conditions- please refer to the attached appendix 1
    	$this->Cell(0,$lineSpace,'Terms and Conditions- please refer to the attached appendix 1',' ');
    
    }
    
    function termAndConditionAlign1($no, $sentence) {
        $this->Cell(10,5,$no,0); $this->MultiCell(0,5,$sentence,0);
        $this->Ln();
    }
    
    function termAndConditionAlign2($no, $sentence) {
        $this->Cell(10,5,' ' ,0);  $this->Cell(5,5,$no,0); $this->MultiCell(0,5,$sentence,0);
        $this->Ln();
    }
    
    function termAndConditionAlign3($no, $sentence) {
        $this->Cell(10,5,' ' ,0);  $this->Cell(10,5,' ' ,0);  $this->Cell(5,5,$no,0); $this->MultiCell(0,5,$sentence,0);
        $this->Ln();
    }
    function termAndCondition($quotationNo,$quotationDate,$patientName,$clientName,$file)
    {
        $this->SetTextColor(0,0,0); // hitam
        $this->AddPage();
        
        $quotationRef = substr($quotationDate,0,4).'/'.$quotationNo;
        
        $this->chapterTitle('APPENDIX 1 (TO BE READ WITH QUOTATION ('.$quotationRef.'): TERMS AND CONDITIONS','L');
        
        $this->Cell(40,7,'For patient',0); $this->Cell(4,7,':',0); $this->Cell(100,7,$patientName,0);
        $this->Ln();
        $this->Cell(40,7,'Atention to',0); $this->Cell(4,7,':',0); $this->Cell(100,7,$clientName,0);
        $this->Ln();
        $this->Cell(40,7,'Date',0); $this->Cell(4,7,':',0); $this->Cell(100,7,$quotationDate,0);
        $this->Ln();
    
        $this->SetFont('','B');
        $this->Cell(0,10,'Terms and Conditions- please refer to the attached Quotation ('.$quotationRef.')',0,1);
        $this->SetFont('Times','',12);
        // Read text file
    	//$txt = file_get_contents($file);
    	// Output justified text
    	//$this->MultiCell(0,5,$txt,0);
    	
    	$this->termAndConditionAlign1('1.','Above is the schedule of fees for our Company’s "NURSING & GENERAL HOME CARE SERVICES".');
        $this->termAndConditionAlign1('2.','The above-said fees include direct consultation with medical specialist and/or Nursing Sister during reasonable hours. Consultation with the medical specialist is subject to his/her schedule.');
        $this->termAndConditionAlign1('3.','The above-said fees do not include: additional use of items such as glucometer (bedside glucose); consumable items, disposable napkins, use of wound dressing sets and materials, catheters and NG tubes, drugs (medications), and/or any other special procedure which is beyond the scope of the basic general care; mileage and logistics; and extra charges during gazetted public holidays.');
        $this->termAndConditionAlign1('4.','Any other professional home and nursing services such as Physiotherapy, Occupational or Speech Therapist or Doctor’s House Call, are not included in the above quotation. Separate charges shall apply based on the therapist’s and doctor’s prevailing service rate.');
        $this->termAndConditionAlign1('5.','The rate of fees above is applicable, subject to the following terms:');
        
        $this->termAndConditionAlign2('a)','Payment must be made in full BEFORE the start of service; and before the start of the next period of service (for recurring service);');
        $this->termAndConditionAlign2('b)','No refund after the start of service, notwithstanding that the client cancels or terminate the service thereafter;');
        $this->termAndConditionAlign2('c)','If no payment is received prior to the date scheduled for commencement of the service, the Company has the right to withhold service without notice until payment is made.');
        $this->termAndConditionAlign2('d)','Notwithstanding, the Company may in its absolute discretion provides the service prior to receiving payment, but without prejudice to its rights to claim for the payment of services rendered.');
        $this->termAndConditionAlign2('e)','In the event that the service has been commenced despite no prior payment, the Company shall be entitled to claim for payment for the full period of service even if the client cancels or terminate the service before the expiry of the said period.');
        $this->termAndConditionAlign2('f)','If no payment is received one (1) week after the Company’s Quotation is signed, Company has the right to terminate the service contract, without prejudice to the Company’s rights to claim for any sums or charges due to the Company (if any).');
        $this->termAndConditionAlign2('g)','If the quotation specifies rest day (for staff), the client shall pay the standard rate (#) (not part of the monthly fees stated above), if the care provider / personnel carries out his/her duty on a rest day.');
        $this->termAndConditionAlign2('h)','This rate of fees is only applicable for a minimum of THREE (3) month contract. Rates may differ thereafter.');
        
        $this->termAndConditionAlign1('6.','After-hours and weekend rates differ.');
        $this->termAndConditionAlign1('7.','Upon the relevant quotation agreed to and signed by or on behalf of the client, and upon the Company’s receipt of payment, the Company shall within three (3) working days identify the appropriate care provider / personnel for the client.');
        $this->termAndConditionAlign1('8.','Any enquiries, financial transactions or any changes to the services, must be communicated directly with the Call Centre, and not the care provider/personnel assigned to the client.');
        $this->termAndConditionAlign1('9.','The Company exercises job rotation amongst our nurses, caregivers and companions. Such personnel are assigned according to availability and roster. Accordingly, the Company has the absolute discretion to determine the appropriate care giver / personnel for the client.');
        $this->termAndConditionAlign1('10.','Payment is only deemed to have been accepted by the Company upon clearance and/or actual receipt of such monies into the Company’s designated bank account(s). The client must send or deliver the hardcopy of the payment slip to the Company’s office as proof of payment, with the name of the patient and client written on the payment slip.');
        //$this->termAndConditionAlign1('11.','Proof of payment is accepted only when hardcopy of payment slip is received by the office of MN Al Falah. Please insert name of patient on the payment slip');
        $this->termAndConditionAlign1('11.','For any additional and/or special request from the client (which are not stated under the current terms of service), extra charges (surcharge) will apply. The surcharge will be specified or as decided by the Management of the Company.');
        $this->termAndConditionAlign1('12.','Any request from client for a change of address or location during the period of service shall be subject to an additional surcharge of RM 180.00. The Company has the absolute discretion to change the care giver / personnel in such a situation.');
        $this->termAndConditionAlign1('13.','Upon agreement to the Company’s Quotation (whether verbally or in writing), any cancellation before the start of service, an administrative fee of 30% over the total cost will be charged to the client.');
        $this->termAndConditionAlign1('14.','If there is a need to change the type of service or request for a change of care giver / personnel; the client shall submit the request in writing for the Company’s consideration.');
        $this->termAndConditionAlign1('15.','The Company has the right to suspend or terminate the service with immediate effect in the event that there occurs any incident, or complaint by the personnel / care giver, which in the sole opinion of the Company may jeopardize or put the care giver / personnel’s safety, security and/or welfare at risk. ');
        $this->termAndConditionAlign1('16.','All payments made are non-refundable. Except as provided expressly herein, there shall be no refunds whatsoever for any early termination or cancellation of the service contract. Any refund is subject to the Company’s sole and absolute discretion and subject to any such terms as the Company may impose.');
        $this->termAndConditionAlign1('17.','In the event of death of a patient / client (as the case may be) before the end of the service period, any request for a partial refund requires the following:');
        
        $this->termAndConditionAlign2('a)','Letter from the client: via email or send by hand.');
        $this->termAndConditionAlign2('b)','Death  certificate.');
        $this->termAndConditionAlign2('c)','Partial refund is calculated as follows: ');
        
        $this->termAndConditionAlign3('i','the amount of  balance of the incomplete service period, or 30% of the total fees paid, whichever is lesser.');
        $this->termAndConditionAlign3('ii','service rates are reverted to the standard rates applicable (if discount package rate was applied).');
        $this->termAndConditionAlign3('iii','no refund for Administrative fees.');
        $this->termAndConditionAlign3('iv','no refund for mileage / logistics fees.');
        
        $this->termAndConditionAlign1('18.','The rental fee for any assets and/or equipments are on monthly basis and shall not be refunded if returned by the client during the month of use.');
        $this->termAndConditionAlign1('19.','Repair costs shall be borne by the client if leased assets and/or equipments are damaged during the period of use.');
        
    }
    
    function paymentInfo(){
        $this->SetTextColor(0,0,0); // black
        $this->SetFillColor(255,255,255);//white
        // Line break
    	$this->Ln();
    	$this->Cell(0,10,'Payment can be made by cheque, cash (to bank) or direct bank-in to:','LRT');
        // Line break
    	$this->Ln();
    	$this->SetFont('','B');
    	$this->Cell(0,5,'MN AL FALAH SDN. BHD.','LR');
    	// Times 12
    	$this->SetFont('Times','',12);
    	$this->Ln();
    	$this->Cell(0,5,'- MAYBANK Account no.: 562834-611-406','LR');
    	$this->Ln();
    	$this->Cell(0,5,'- Kindly submit the proof of payment to accounts@mnalfalah.com.my','LRB');
    
    }
    
    function tobeInserted($fieldName) {
        $this->Ln();
        $this->Cell(50,12,$fieldName,0); $this->Cell(4,12,' : ',0); 
        //$this->Cell(0,12,'_______________________________________________________',0);
        $this->Cell(0,12,' ','B'); // Just the line at the bottom        
    }
    
    function loaPage($patientName){

        $this->SetTextColor(0,0,0); // hitam
        $this->AddPage();
        
        $this->chapterTitle('LETTER OF ACCEPTANCE','C');
        
        $this->Cell(40,7,'(KINDLY SIGN AND',0); $this->Cell(4,7,':',0); $this->Cell(100,7,'1) TRANSMIT THIS PAGE TO 012 – 2526 499; OR',0);
        $this->Ln();
        $this->Cell(40,7,' ',0); $this->Cell(4,7,':',0); $this->Cell(100,7,'2) SCAN AND EMAIL TO info@mnalfalah.com.my)',0);
        $this->Ln();
        $this->Cell(40,10,'For patient',0); $this->Cell(4,10,':',0); $this->Cell(100,10,$patientName,0);
        $this->Ln();
        
        $ihereby = 'I hereby agree to the above quotation, terms and conditions, dated  ____________  and will accept the service to be provided by MN Al Falah Sdn. Bhd. beginning ____________ (Date).';
        $this->MultiCell(0,10,$ihereby,0);
        
        $this->tobeInserted('Name (Client/Representative)');
        $this->tobeInserted('Date');
        $this->tobeInserted('Time');
        $this->tobeInserted('Signature');
        $this->tobeInserted('Name (Witness)');
        $this->tobeInserted('Date');
        $this->tobeInserted('Time');
        $this->tobeInserted('Signature');
        
        $this->Ln();
        $this->Ln();
        $ifGotProblem = 'If our personnel do not deliver quality services, our company will get a replacement staff at no extra charge.';
        //$this->Cell(10,5,'*',0,1,'C'); // this will occupied the whole line
        $this->Cell(10,5,'    *',' '); // this will use one specific cell size .. to see it $this->Cell(10,5,'*','LRTB');
        $this->MultiCell(0,5,$ifGotProblem,' ');
        $this->Ln();
        $this->Cell(0,10,' ','T'); // Just the line at the top
        $this->Ln();
        
        $this->SetFont('Times','BU',12); //set it bold and underline
        $this->Cell(0,6,'Office use only',0,1,'L',true);
        $this->SetFont('Times','',12);  // reset the bold
        
        $this->tobeInserted('Date received');
        $this->tobeInserted('Person who received');
        $this->tobeInserted('Signature');
        
    }
}

    $quotations = new Quotations();      
    //initialize fields of user object with the columns retrieved from the query
    $quotations->id = $_REQUEST['id'];
    $quotations->selectById();
    
    $customerName = $quotations->customerData->firstName.' '.$quotations->customerData->lastName;
    $customerAddress = $quotations->customerData->address.' '.$quotations->customerData->city.' '.$quotations->customerData->postcode.' '.$quotations->customerData->state;
    $patientName = $quotations->patientData->firstName.' '.$quotations->patientData->lastName;
    
    //$datetime1 = new DateTime($quotations->startDate);
    //$datetime2 = new DateTime($quotations->endDate);
    //$interval = $datetime1->diff($datetime2);
    //$totalDays = $interval->days + 1; //if start and end the same date - it considered as 1 day
    
    $totalDays = $quotations->chargeDays;
    
    $requestNote ='';
    foreach($quotations->noteListData as $quotationNote) {
        $requestNote = $requestNote.$quotationNote->note.' ';
    }
      
    // Instanciation of inherited class
    $pdf = new PDF();
    $pdf->AliasNbPages();
    
    $pdf->letterFirstPage($customerName,$customerAddress,$patientName,'Dr. Norshinah Kamarudin',$quotations->quotationDate);//$customerName,$customerAddress,$patientName,$userName
    
    
    if($totalDays < 20 ) {
        $quotationSummary = $quotations->hourPerDay.'-hour care / '.$quotations->dayPerWeek.' days a week';
    } else {
        $quotationSummary = $quotations->hourPerDay.'-hour care / '.$quotations->dayPerWeek.' days a week / '.$totalDays.' days a month';
    }
    
    $pdf->quotationPage($quotations->quotationNo,$quotations->quotationDate,$customerName,$customerAddress,$quotations->customerData->email,
                        $quotations->customerData->mobile,$patientName,$requestNote,$quotationSummary,
                        $quotations->feeFor,$quotations->patientData->address,$quotations->patientData->ic);// $quotationDate,$customerName,$customerAddress,$customerEmail,$customerContact,$patientName,$requestNote,$quotationSummary
    
    $pdf->chargePage('CHARGES FOR HOME NURSING SERVICE',$patientName,$quotations->patientData->ic,$quotations->patientData->address,
                     $quotations->hourPerDay,$quotations->basicCharge,$quotations->startDate,$quotations->endDate,$quotations->mileage,
                     $quotations->adminFee,$quotations->gst,$quotations->totalAmount,$totalDays,$quotations->feeFor,
                     $quotations->physiotherapy,$quotationSummary,$quotations->additionalCharge,
                     $quotations->nurseVisit,$quotations->doktorVisit,$quotations->physioDays,$quotations->nurseVisitDays,$quotations->doctorVisitDays);
    
    $pdf->termAndCondition($quotations->quotationNo,$quotations->quotationDate,$patientName,$customerName,'termAndCondition.txt');
    
    $pdf->paymentInfo();
    
    $pdf->loaPage($patientName);
    
    $pdf->Output();
?>
