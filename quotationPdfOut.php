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
    	$this->Cell(0,5,'MN AL FALAH SDN BHD (886261-X)',0,1,'C');
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
        $this->Cell(0,5,'MN AL Falah Sdn Bhd (886261-X)',0,1);
        $this->Cell(0,5,'D-11-3A, Plaza Paragon Point 11,',0,1);
        $this->Cell(0,5,'Jalan Medan Pusat Bandar 5,',0,1);
        $this->Cell(0,5,'Seksyen 9,43650 Bandar Baru Bangi,',0,1);
        $this->Cell(0,5,'Selangor.',0,1);
        $this->Cell(0,5,' ',0,1);
        
    }
    
    function mnFalahAddressWithReference($quotationDate,$quotationRef)
    {
        $this->SetFont('Times','',12);
        $this->Cell(130,7,'MN AL Falah Sdn Bhd (886261-X)',0);
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
                        $startDate,$endDate,$mileage,$adminFee,$gst,$totalAmount,$subTotalAmount,$intervalDays,$feeFor,
                        $physiotherapy,$quotationSummary,$additionalCharge,
                        $nurseVisit,$doktorVisit,$physioDays,$nurseVisitDays,$doctorVisitDays,$reasonAdditionalCharge) {
    
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
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'RM380 X '.$doctorVisitDays.' days : RM'.($doctorVisitDays*380),'R');
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
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'1st Session: RM250','R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	$this->Cell($firstColumnSize,$lineSpace,'First Visit, Assesment, Dressing','L');
        	$this->Cell(4,$lineSpace,' ','R');
        	if(($nurseVisitDays-1) > 0) {    
        	    $this->Cell(0,$lineSpace,'Subsequent Visits RM220 X '.($nurseVisitDays-1).' days: RM'.(($nurseVisitDays-1)*220),'R');
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
        	$this->Cell($firstColumnSize,$lineSpace,'a) '.$hourPerDay.'-hour care @ ('.$hourPerDay.' X RM'.($basicCharge/$hourPerDay).') x '.$intervalDays.' days','L');
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'a) '.$hourPerDay.'-hour care @ RM'.$basicCharge*$intervalDays,'R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	//just a space
        	$this->Cell($firstColumnSize,$lineSpaceEmptyLine,' ','L');
        	$this->Cell(4,$lineSpaceEmptyLine,' ','R');$this->Cell(0,$lineSpaceEmptyLine,' ','R');
        	$this->Ln();
        	
        	// b) Mileage @ RM300.00(+gst)
        	//$this->SetFont('','BI');
        	$this->Cell($firstColumnSize,$lineSpace,'b) Mileage @ RM'.$mileage.' x '.$intervalDays.' days','L');
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'b) Mileage @ RM'.$mileage*$intervalDays,'R');
        	$this->SetFont('Times','',12);
        	$this->Ln();

        	//c) Admin Fees @ RM200.00(+gst)/pa
        	$this->Cell($firstColumnSize,$lineSpace,'c) Admin Fees @ RM'.$adminFee,'L');
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'c) Admin Fees @ RM'.$adminFee,'R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	
        	
        	//e) Additional Charge  - .$reasonAdditionalCharge
        	if($additionalCharge > 0) {
            	$this->Cell($firstColumnSize,$lineSpace,'d) '.$reasonAdditionalCharge,'L');
            	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'d) '.$reasonAdditionalCharge.' @ RM'.$additionalCharge,'R');
            	$this->SetFont('Times','',12);
            	$this->Ln();
            	
            	$this->Cell($firstColumnSize,$lineSpace,'e) SubTotal','L');
            	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'e) SubTotal @ RM'.$subTotalAmount,'R');
            	$this->SetFont('Times','',12);
            	$this->Ln();
            	
            	$this->Cell($firstColumnSize,$lineSpace,'f) GST','L');
            	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'f) GST @ RM'.$gst,'R');
            	$this->SetFont('Times','',12);
            	$this->Ln();    
        	} else {
        	    
        	    $this->Cell($firstColumnSize,$lineSpace,'d) SubTotal','L');
            	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'d) SubTotal @ RM'.$subTotalAmount,'R');
            	$this->SetFont('Times','',12);
            	$this->Ln();
            	
        	    //d) gst
            	$this->Cell($firstColumnSize,$lineSpace,'e) GST','L');
            	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'e) GST @ RM'.$gst,'R');
            	$this->SetFont('Times','',12);
            	$this->Ln();
        	}
        	
        	
        	//space separation
        	$this->spaceSeparation($firstColumnSize,$lineSpaceEmptyLine);
        	
        	
        	// TOTAL @ RM 3,730
        	$this->Cell($firstColumnSize,$lineSpace,' ','L');
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'TOTAL @ RM'.$totalAmount,'R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	// Additional RM 100 for Weekend & Public Holidays
        	$this->Cell($firstColumnSize,$lineSpace,'Additional RM100 for Weekend','L');
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
        	$this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'1st Session: RM250','R');
        	$this->SetFont('Times','',12);
        	$this->Ln();
        	
        	//PHYSIOTHERAPY - Subsequent Visits:
        	// 22/8/2016 3:49PM  :Subsequent tukar lah kan?. .dari RM180--> RM180 juga. .tak tukar
        	$this->SetFont('','B');
        	$this->Cell($firstColumnSize,$lineSpace,'Physiotherapy','L');
        	$this->SetFont('Times','',12);
        	if(($physioDays-1) > 0) {
        	    $this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'Subsequent Visits RM180 X '.($physioDays-1).' days: RM'.($physioDays-1)*180,'R');
        	} else {
        	    $this->Cell(4,$lineSpace,' ','R');$this->Cell(0,$lineSpace,'Subsequent Visits: RM180','R');
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
        $this->Cell(10,5,' ' ,0);  $this->Cell(10,5,' ' ,0);  $this->Cell(10,5,$no,0); $this->MultiCell(0,5,$sentence,0);
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
    
        $lineSpace = 7;
        $this->SetFont('','U'); //underline
        $this->Cell(0,10,'Definition',0,1,'C',false); //center
    	$this->Ln(4);
        $this->SetFont('Times','',12); //remove the under line
        $this->Cell(0,$lineSpace,'"we", "us", "our" refer to MN Al Falah Sdn Bhd (Company No. 886261-X).',' ');
        $this->Ln();
        $this->Cell(0,$lineSpace,'"client" refers to the person who is requesting for the service.',' ');
        $this->Ln();
        $this->Cell(0,$lineSpace,'"patient" refers to the person receiving the service, who may or may not be the same person as the client.',' ');
        $this->Ln();
        
        $this->SetFont('','U'); //underline
        $this->Cell(0,10,'The Service',0,1,'C',false); //center
    	$this->Ln(4);
        $this->SetFont('Times','',12); //remove the under line
        
    	$this->termAndConditionAlign1('1.','The nurse, caregiver, companion, physiotherapist and/or any other healthcare personnel or person providing the service (hereinafter referred to as the "Personnel") is an independent contractor. The Personnel is NOT our employee, staff or agent.');
        $this->termAndConditionAlign1('2.','We are a platform to facilitate the patient towards getting the appropriate and suitable Personnel based on the patient\'s conditions and requirements and also based on information that the client provides to us.');
        $this->termAndConditionAlign1('3.','The type of services ("service") by the Personnel for the patient consist of either one or more of the following (as the case may be):-');
        $this->SetFont('','I'); // italics
        $this->termAndConditionAlign1('  ','Nursing; Caregiving; Physiotherapy; Occupational therapy; Speech therapy; Companion; Temporary nanny / babysitting; Post-natal / confinement caretaking');
        $this->SetFont('Times','',12); //remove the italics
        
        $this->termAndConditionAlign1('  ','The Personnel\'s service is restricted only to the specified type service as agreed between the client and us.');
        
        $this->termAndConditionAlign1('4.','We exercise job rotation amongst the Personnel. The Personnel are assigned according to their availability and roster. Accordingly, we have the absolute discretion to determine the appropriate Personnel for the client / patient based on suitability and availability.');
        $this->termAndConditionAlign1('5.','We do not guarantee the availability of any or a specific Personnel for any date, time and location which the client seeks for the service to be provided.');
        $this->termAndConditionAlign1('6.','If the assigned Personnel is unavailable for an appointment which had already been confirmed, we will provide the next available and suitable Personnel (“replacement Personnel”) based on the information and requirement that the client originally provided. The replacement Personnel shall be arranged at a later date, if no replacement can be secured for the original appointment date. The client shall have no claims whatsoever against us in such situation.');
        $this->termAndConditionAlign1('7.','We do provide certain assets and/or equipments for rental / lease (subject to availability). The rental fee for any assets and/or equipment is on a monthly basis and shall not be refunded if returned by the client prior to the expiry of the agreed period of lease.  Repair / replacement costs shall be borne by the client if the leased assets and/or equipment are damaged during the period of use.');
        
        $this->SetFont('','U'); //underline
        $this->Cell(0,10,'The Fees',0,1,'C',false); //center
    	$this->Ln(4);
        $this->SetFont('Times','',12); //remove the under line
        
        $this->termAndConditionAlign1('8.','Our schedule of fees for the service is as per the quotation. All the quoted figures in the quotation are in Malaysian Ringgit (RM). After-hours and weekend rates / charges may differ, unless expressly stated otherwise in the quotation.');
        $this->termAndConditionAlign1('9.','The fees include free telephone consultation with our own appointed medical doctor during reasonable hours, subject to his/her schedule and availability.');
        $this->termAndConditionAlign1('10.','The fees do not include: use of items and materials such as (but not limited to) glucometer, consumable items, diapers, use of wound dressing sets and materials, catheters and NG tubes, drugs (medications), and/or any other special procedure which is beyond the scope of the basic general care. Such items and materials shall be charged separately.');
        $this->termAndConditionAlign1('11.','Any other professional services including but not limited to Doctor’s House Call, are not part of the quotation (unless expressly stated otherwise  in the quotation). Separate charges shall apply based on such professional’s and/or the doctor’s prevailing service rate.');
        $this->termAndConditionAlign1('12.','For any request by the client on any additional criteria or specific criteria of a Personnel, we reserve the right to impose surcharge of up to RM180 per request.');
        $this->termAndConditionAlign1('13.','For any request by the client for a change of address or location, whether before or during the period of service, shall be subject to an additional surcharge of up to RM180.00. We have the absolute discretion to change the Personnel and to re-arrange the appointment schedule (based on Personnel availability) in such a situation.');
        $this->termAndConditionAlign1('14.','Payment terms:');
        
        $this->termAndConditionAlign2('a)','Payment must be made in full BEFORE the start of service; and before the start of the next period of service (for recurring service).');
        $this->termAndConditionAlign2('b)','If no payment is received prior to the date scheduled for commencement of the service, we have the right to withhold service without notice until payment is made.');
        $this->termAndConditionAlign2('c)','Nevertheless, we may in our absolute discretion arrange for the service to be provided prior to receiving payment (or upon part payment), but without prejudice to our rights to claim for the payment of services rendered.');
        $this->termAndConditionAlign2('d)','In the event that the service has been commenced despite no prior full payment, we shall be entitled to claim for payment for the full period of service even if the client cancels or terminate the service before the expiry of the service period.');
        $this->termAndConditionAlign2('e)','If no payment is received within three (3) working days after the Letter of Acceptance (below) is signed, we have the right to terminate the service, without prejudice to our rights to claim for any sums or charges due to us (if any) including the relevant administrative charges.');
        $this->termAndConditionAlign2('f)','f)	If the quotation specifies rest day (for the Personnel), the client shall pay the rate for such day which shall be determined by us (not part of the fees stated in the quotation), if the Personnel carries out his/her duty on such rest day.');
        
        
        $this->termAndConditionAlign1('15.','All payments shall be made directly to our designated bank account as specified below via ATM deposit, internet banking or via cheque.  We generally do not accept any payment in cash, save and except with our prior written consent to such arrangement. In the event that we agree to accept cash payment, such payment must NOT be given to the Personnel assigned to the patient.  Our management will assign the authorised person to collect such cash payment from the client whereby an additional charge between RM20 to RM40 shall apply (for logistics, depending on location).  The client shall then notify us (at accounts@mnalfalah.com.my) of such cash payment handed over to our authorised person.');
        $this->termAndConditionAlign1('16.','If the payment made are not in accordance with the above, it shall be deemed that we have not received the payment.');
        
        $this->termAndConditionAlign1('17.','Upon the Letter of Acceptance signed by or on behalf of the client, and upon our receipt of payment, we shall commence search and identify the suitable Personnel for the patient. In the event that we are not able to procure such Personnel, we shall notify the client accordingly and shall refund the payment made (if any) within five (5) working days upon such notification.');
        $this->termAndConditionAlign1('18.','The client and/or patient SHALL NOT give any tips, gifts or any form of remuneration or payment to the Personnel without our prior written consent');
        $this->termAndConditionAlign1('19.','The Personnel is prohibited from receiving or soliciting payment from the client or patient. The Personnel is also prohibited from receiving offers, or soliciting for, duties directly with the client, during or after the cessation of the service. If the Personnel does any of such act, the client shall immediately notify our Callcentre.');
        $this->termAndConditionAlign1('20.','Any enquiries, financial transactions or any changes to the service, must be communicated directly with the Callcentre, and not through the Personnel assigned to the patient.');
        $this->termAndConditionAlign1('21.','Subject to our rights and discretion to exercise Clause 23 below, upon the client’s agreement and/or acknowledgement to the quotation and the terms and conditions herein (whether verbally, text message or in writing), for any cancellation of service by the client or patient for whatever reason (whether before or during or after the commencement of service), we reserve the right to charge, set-off and/or claim (as the case may be) from the client a fee of 30% of the total service fee. In addition to that, the administrative charges and the applicable taxes shall remain payable by the client in full. The balance (if any) will be refunded accordingly.  For avoidance of doubt, such refund (if any) is only applicable in the event that we decide not to exercise our rights in Clause 23 below.');
        $this->termAndConditionAlign1('22.','If there is a need to change the type of service or any request for a change of Personnel after a particular Personnel had been assigned to the client / patient, the client shall submit the request in writing (letter or email) for our consideration, and subject to Personnel availability. A surcharge of RM180 is applicable.');
        
	$this->SetFont('','U'); //underline
        $this->Cell(0,10,'Refund',0,1,'C',false); //center
    	$this->Ln(4);
        $this->SetFont('Times','',12); //remove the under line



	$this->termAndConditionAlign1('23.','All payments made are non-refundable. For avoidance of doubt, there shall be no refunds whatsoever for any early termination or any cancellation of the service (whether or not the service has started or otherwise). Any refund is subject to our sole discretion and subject to any such terms as we may impose.');
        $this->termAndConditionAlign1('24.','In the event of death of a patient / client (as the case may be) before the end of the service period, any request for a partial refund requires the following:');
        
        $this->termAndConditionAlign2('a)','Letter from the client: via email or send by hand.');
        $this->termAndConditionAlign2('b)','Death certificate (certified true copy).');
        
        $this->termAndConditionAlign1(' ','Partial refund is calculated as follows: ');
        
        $this->termAndConditionAlign3('(i)','The amount of  balance of the incomplete service period, or 30% of the total fees paid, whichever is lesser;');
        $this->termAndConditionAlign3('(ii)','Service rates are reverted to the standard rates applicable (if discount package rate was applied);');
        $this->termAndConditionAlign3('(iii)','No refund for administrative charges;');
        $this->termAndConditionAlign3('(iv)','No refund for mileage / logistics fees;');
        $this->termAndConditionAlign3('(v)','No refund on the GST imposed.');
        
        $this->SetFont('','U'); //underline
        $this->Cell(0,10,'Disclaimer',0,1,'C',false); //center
    	$this->Ln(4);
        $this->SetFont('Times','',12); //remove the under line
        
        $this->termAndConditionAlign1('25.','We have the right to suspend or terminate the service with immediate effect in the event that there occurs any incident, or complaint by the Personnel, which in our sole opinion may jeopardize or put the Personnel\'s safety, security and/or welfare at risk');
        $this->termAndConditionAlign1('26.','We shall not be liable for any of the Personnel\'s act, omission, advise, negligence or default. We shall not be responsible or liable for any external agreement or arrangement between the Personnel and the client / patient.');
        $this->termAndConditionAlign1('27.','The client hereby acknowledges that at no point in time is the Personnel prescribing anything, and that all information, advice, suggestions and/or recommendations ("advice") provided by the Personnel is merely his/her own personal advice and therefore it is at the client / patient own risk and discretion with which the client / patient follows the advice given.');
        $this->termAndConditionAlign1('28.','The client may and is recommended to contact and consult our own certified medical doctor for any medical-related advice and consultation.');
        $this->termAndConditionAlign1('29.','The client agrees and acknowledges that it is the client\'s responsibility to disclose all medical conditions (pre-existing or otherwise) at the time of requesting / applying for the service, and to also inform us of any conditions or changes relating to the patient\'s health, injuries and/or allergies, whether present and/or ongoing.');
        $this->termAndConditionAlign1('30.','The client acknowledges and represents to us that the patient has duly and/or had sufficient opportunity to consult the patient\'s own doctors and/or medical consultants before accepting the service.');
        $this->termAndConditionAlign1('31.','We shall not be liable for any complications, injuries, adverse reactions, loss and damage which the patient may suffer arising from the service. ');
        $this->termAndConditionAlign1('32.','The client shall solely be responsible for the security of the client\'s / patient\'s valuables and personal belongings including but not limited to that at the location / premise in which the service is provided.');
        
        $this->SetFont('','U'); //underline
        $this->Cell(0,10,'Others',0,1,'C',false); //center
    	$this->Ln(4);
        $this->SetFont('Times','',12); //remove the under line
        
        $this->termAndConditionAlign1('33.','The client shall ensure a safe and suitable environment for the service to be rendered at the assigned location / premise.');
        $this->termAndConditionAlign1('34.','If the client and the patient are different persons, the client shall be liable and fully responsible to ensure that the patient abide to the terms and conditions herein. The act and/or conduct of the patient shall be deemed that of the client.');
        $this->termAndConditionAlign1('35.','The client shall at all times indemnify and keep us indemnified against all action, liabilities, proceedings, claims, demands, costs and expenses (including legal costs on solicitor-client basis) in respect of or arising out of the service whether expressed pursuant to these terms and conditions or implied by any law for the time being in force or any other relation that may arise hereto.');
        $this->termAndConditionAlign1('36.','Save as expressly provided for in these terms and conditions or any other agreement between us and the client, all client information is strictly confidential and shall only be used in connection of the service envisaged herein. ');
        $this->termAndConditionAlign1('37.','We reserve the right to amend or vary these terms and conditions from time to time at our absolute discretion.');
        $this->termAndConditionAlign1('38.','The client shall not assign or transfer any rights, obligations or benefits under these terms and conditions to any other party save with our express written consent.');
        $this->termAndConditionAlign1('39.','No right of ours under the terms and conditions herein shall be deemed waived unless made and confirmed in writing by us specifically waiving such right. Any waiver by us shall be without prejudice to our rights and remedies in respect of any other breach of the terms and conditions herein by the client.');
        $this->termAndConditionAlign1('40.','No failure or delay on our part in exercising or omission to exercise any right, power, privilege or remedy accruing to us under the terms and conditions herein upon any default or breach on the client\'s part shall impair any such right, power, privilege or remedy or be construed as a waiver thereof or an acquiescence in such default or breach; nor shall any of our action in respect of any default or any acquiescence in such default, affect or impair any of our right, power, privilege or remedy in respect of any other antecedent or subsequent default or breach by the client.');
        $this->termAndConditionAlign1('41.','The quotation and the terms and conditions herein shall constitute the whole of the terms agreed between us and the client in respect of the subject matter herein and supercedes all prior representations, agreements, statements and understandings, whether verbal or in writing.  ');
        $this->termAndConditionAlign1('42.','The client hereby irrevocably consents and permits us and the attending Personnel to collect, access, process and utilise the client\'s and the patient\'s personal data (including but not limited to medical report and records) for the purpose of and/or in connection with the service herein. We are committed to the protection of the client\'s and patient\'s personal data and compliance of all applicable personal data protection laws and regulations in Malaysia.');
        $this->termAndConditionAlign1('43.','If any provision under these terms and conditions is held invalid, unenforceable or illegal for any reason, the remaining of the provisions of the terms and conditions herein shall remain otherwise in full force apart from such provision which shall be deemed deleted.');
        $this->termAndConditionAlign1('44.','We may at any time issue any notice, or modify or amend or vary the terms and conditions herein ("variation") by posting a copy of such notice or variation on our website (www.mnalfalah.com.my) or by email or by post. The client shall be deemed to have acknowledged receipt, understood and agreed to any such notice or variation by the client\'s decision to continue using the service following the date in which the notice or the variation is posted on the website or sent via email or sent by post.');
        $this->termAndConditionAlign1('45.','These terms and conditions shall be subjected to and construed in accordance with the laws of Malaysia and parties hereby submit to the exclusive jurisdiction of the courts in Malaysia.');
        $this->termAndConditionAlign1('46.','The client shall be deemed to have read and agreed to the quotation and the terms and conditions herein, upon payment (or any part payment, as the case may be) or upon the start of the service, notwithstanding whether the Letter of Acceptance below is signed or otherwise.');
        $this->termAndConditionAlign1('47.','The client and/or patient is strictly prohibited from any direct dealing or any external arrangement for the service (“Direct Dealing”) with any of the Personnel for or in connection with the service or any other similar arrangements, without our prior written consent. Upon discovery of any such Direct Dealing, we reserve the right to claim for the full amount for such service (including but not limited to the administrative charges and the applicable taxes) as if it is arranged by us, notwithstanding any payment made by the client to the Personnel in relation to the Direct Dealing.');

    }
    
    function paymentInfo(){
        $this->SetTextColor(0,0,0); // black
        $this->SetFillColor(255,255,255);//white
        // Line break
    	$this->Ln();
    	$this->Cell(0,10,'Payment can be made by cheque, ATM deposit or internet banking  to:','LRT');
        // Line break
    	$this->Ln();
    	$this->SetFont('','B');
    	$this->Cell(0,5,'NORSHINAH BINTI KAMARUDIN.','LR');  //old 'MN AL FALAH SDN. BHD.' (17/2/2017 4:12PM)
    	// Times 12
    	$this->SetFont('Times','',12);
    	$this->Ln();
    	$this->Cell(0,5,'- MAYBANK Account no.: 16405-2293-903','LR');  // old 562834-611-406 (17/2/2017 4:12PM)
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
    //$quotations->subTotalAmount
    $pdf->chargePage('CHARGES FOR HOME NURSING SERVICE',$patientName,$quotations->patientData->ic,$quotations->patientData->address,
                     $quotations->hourPerDay,$quotations->basicCharge,$quotations->startDate,$quotations->endDate,$quotations->mileage,
                     $quotations->adminFee,$quotations->gst,$quotations->totalAmount,$quotations->subTotalAmount,$totalDays,$quotations->feeFor,
                     $quotations->physiotherapy,$quotationSummary,$quotations->additionalCharge,
                     $quotations->nurseVisit,$quotations->doktorVisit,$quotations->physioDays,$quotations->nurseVisitDays,
                     $quotations->doctorVisitDays,$quotations->reasonAdditionalCharge);
    
    $pdf->termAndCondition($quotations->quotationNo,$quotations->quotationDate,$patientName,$customerName,'termAndCondition.txt');
    
    $pdf->paymentInfo();
    
    $pdf->loaPage($patientName);
    
    $pdf->Output();
?>