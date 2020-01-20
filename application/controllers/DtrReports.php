<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DtrReports extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Employee_model');
        $this->load->model('RatesDuties_model');
        $this->load->model('Ref_Emptype_model');
        $this->load->model('RefDepartment_model');
        $this->load->model('RefPosition_model');
        $this->load->model('RefBranch_model');
        $this->load->model('RefSection_model');
        $this->load->model('TemporaryDeduction_model');
        $this->load->model('RefGroup_model');
        $this->load->model('RefDepartment_model');
        $this->load->model('RefDeductionSetup_model');
        $this->load->model('Payslip_model');
        $this->load->model('GeneralSettings_model');
        $this->load->model('RefOtherEarningRegular_model');
        $this->load->model('PaySlip_earning_model');
        $this->load->model('PaySlip_deduction_model');
        $this->load->model('DailyTimeRecord_model');
        $this->load->model('Users_model');
        $this->load->model('RefPayPeriod_model');
        $this->load->library('excel');

    }
    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['loader'] = $this->load->view('template/elements/loader', '', TRUE);
        $data['loaderscript'] = $this->load->view('template/elements/loaderscript', '', TRUE);
        $data['ref_group']=$this->RefGroup_model->get_list(array('refgroup.is_deleted'=>FALSE));
        $data['ref_department']=$this->RefDepartment_model->get_list(array('ref_department.is_deleted'=>FALSE));
        $data['title'] = 'Pay Slip';

        $this->load->view('pay_slip_view', $data);
    }


    function dtrreports($dtrreports=null,$filter_value=null,$filter_value2=null,$filter_value3=null,$type=null){




        switch($dtrreports){
            //****************************************************
            case 'dtr-verification-list': //
                        if($filter_value2=="all" AND $filter_value3=="all"){
                        $filter=array('daily_time_record.pay_period_id'=>$filter_value,'employee_list.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2=="all" AND $filter_value3!="all"){
                        $filter=array('daily_time_record.pay_period_id'=>$filter_value,'ref_branch.ref_branch_id'=>$filter_value3,'employee_list.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2!="all" AND $filter_value3=="all"){
                        $filter=array('daily_time_record.pay_period_id'=>$filter_value,'ref_department.ref_department_id'=>$filter_value2,'employee_list.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2!="all" AND $filter_value3!="all"){
                        $filter=array('daily_time_record.pay_period_id'=>$filter_value,'ref_department.ref_department_id'=>$filter_value2,'ref_branch.ref_branch_id'=>$filter_value3,'employee_list.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        $data['dtr_verification_list']=$this->DailyTimeRecord_model->get_list(
                        $filter,
                        'daily_time_record.*,employee_list.ecode,CONCAT(employee_list.first_name," ",employee_list.middle_name," ",employee_list.last_name) as full_name',
                        array(
                             array('employee_list','employee_list.employee_id=daily_time_record.employee_id','left'),
                             array('emp_rates_duties','emp_rates_duties.employee_id=employee_list.employee_id','left'),
                             array('ref_department','ref_department.ref_department_id=emp_rates_duties.ref_department_id','left'),
                             array('ref_branch','ref_branch.ref_branch_id=emp_rates_duties.ref_branch_id','left'),
                             ),
                        'employee_list.last_name ASC'
                        );

                        //echo json_encode($data);
                        $getcompany=$this->GeneralSettings_model->get_list(
                        null,
                        'company_setup.*'
                        );

                        $period=$this->RefPayPeriod_model->getperiod($filter_value);
                        $data['pay_period']=$period[0]->period;

                        if($filter_value2=="all"){
                            $data['dept']="All Department";
                        }
                        else{
                        $getdept=$this->RefDepartment_model->get_list(
                        $filter_value2,
                        'ref_department.department,'
                        );
                        $data['dept']=$getdept[0]->department;
                        }
                        if($filter_value3=="all"){
                            $data['branch']="All Branch";
                        }
                        else{
                        $getbranch=$this->RefBranch_model->get_list(
                        $filter_value3,
                        'ref_branch.branch,'
                        );
                        $data['branch']=$getbranch[0]->branch;
                        }
                        //echo $data['dept'];

                        $data['company']=$getcompany[0];
                        //echo json_encode($data);
                        //show only inside grid with menu button
                        if($type=='fullview'||$type==null){
                            echo $this->load->view('template/dtr_verification_list_html',$data,TRUE);
                            //echo $this->load->view('template/dr_content_menus',$data,TRUE);
                        }

                        //show only inside grid without menu button
                        if($type=='contentview'){
                            echo $this->load->view('template/dtr_verification_list_html',$data,TRUE);
                        }


                        //download pdf
                        if($type=='pdf'){
                            $pdfFilePath = "test".".pdf";  //generate filename base on id
                            $pdf = $this->m_pdf->load('A4-L'); //pass the instance of the mpdf class
                            $content=$this->load->view('template/dtr_verification_list',$data,TRUE); //load the template
                            $pdf->setFooter('{PAGENO}');
                            $pdf->WriteHTML($content);
                            //download it.
                            $pdf->Output($pdfFilePath,"D");

                        }

                        //preview on browser
                        if($type=='preview'){
                            $pdfFilePath = "test".".pdf"; //generate filename base on id
                            $pdf = $this->m_pdf->load('A4-L'); //pass the instance of the mpdf class
                            $content=$this->load->view('template/dtr_verification_list',$data,TRUE); //load the template
                            $pdf->setFooter('{PAGENO}');
                            $pdf->WriteHTML($content);
                            //download it.
                            $pdf->SetJS('this.print();');
                            $pdf->Output();
                        }

                        break;

                    case 'export-dtr-verification-list': //
                        $excel = $this->excel;
                        if($filter_value2=="all" AND $filter_value3=="all"){
                        $filter=array('daily_time_record.pay_period_id'=>$filter_value,'employee_list.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2=="all" AND $filter_value3!="all"){
                        $filter=array('daily_time_record.pay_period_id'=>$filter_value,'ref_branch.ref_branch_id'=>$filter_value3,'employee_list.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2!="all" AND $filter_value3=="all"){
                        $filter=array('daily_time_record.pay_period_id'=>$filter_value,'ref_department.ref_department_id'=>$filter_value2,'employee_list.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2!="all" AND $filter_value3!="all"){
                        $filter=array('daily_time_record.pay_period_id'=>$filter_value,'ref_department.ref_department_id'=>$filter_value2,'ref_branch.ref_branch_id'=>$filter_value3,'employee_list.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        $dtr_verification_list=$this->DailyTimeRecord_model->get_list(
                        $filter,
                        'daily_time_record.*,employee_list.ecode,CONCAT(employee_list.first_name," ",employee_list.middle_name," ",employee_list.last_name) as full_name',
                        array(
                             array('employee_list','employee_list.employee_id=daily_time_record.employee_id','left'),
                             array('emp_rates_duties','emp_rates_duties.employee_id=employee_list.employee_id','left'),
                             array('ref_department','ref_department.ref_department_id=emp_rates_duties.ref_department_id','left'),
                             array('ref_branch','ref_branch.ref_branch_id=emp_rates_duties.ref_branch_id','left'),
                             ),
                        'employee_list.last_name ASC'
                        );

                        //echo json_encode($data);
                        $getcompany=$this->GeneralSettings_model->get_list(
                        null,
                        'company_setup.*'
                        );
                        if($filter_value2=="all"){
                            $dept="All Department";
                        }
                        else{
                        $getdept=$this->RefDepartment_model->get_list(
                        $filter_value2,
                        'ref_department.department,'
                        );
                        $dept=$getdept[0]->department;
                        }

                        $period=$this->RefPayPeriod_model->getperiod($filter_value);
                        $pay_period=$period[0]->period;

                        if($filter_value3=="all"){
                            $branch="All Branch";
                        }
                        else{
                        $getbranch=$this->RefBranch_model->get_list(
                        $filter_value3,
                        'ref_branch.branch,'
                        );
                        $branch=$getbranch[0]->branch;
                        }

                        $company=$getcompany[0];

                        //show only inside grid with menu button
                        if($type=='fullview'||$type==null){
                            $excel->setActiveSheetIndex(0);

                            //name the worksheet
                            $excel->getActiveSheet()->setTitle("Verification List Report");

                            $styleArray = array(
                                'font'  => array(
                                    'bold'  => false,
                                    'size'  => 10,
                                    'name'  => 'Verdana'
                                ));


                            $styleArray1 = array(
                                'font'  => array(
                                    'bold'  => false,
                                    'size'  => 10,
                                    'name'  => 'Verdana'
                                ));


                            $excel->getActiveSheet()->setCellValue('A1','Verification List (Per Department / Branch)')
                                                    ->getStyle('A1')->applyFromArray($styleArray);
                            $excel->getActiveSheet()->setCellValue('A2','Pay Period : '.$pay_period)
                                                    ->setCellValue('A3','Department : '.$dept)
                                                    ->setCellValue('A4','Branch : '.$branch)
                                                    ->getStyle('A2:A4')->applyFromArray($styleArray1);

                            $fill_solid_first = array(
                                'fill'  => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => '4FC3F7')
                                )

                            );

                            $fill_solid_second = array(
                                'fill'  => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'ECEFF1')
                                )

                            );

                            $fill_solid_third = array(
                                'fill'  => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'FFEB3B')
                                )

                            );

                            $font_color = array(
                                'font'  => array(
                                        'color' => array('rgb' => '212121')
                                ));

                            $border_all = array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '292929')
                                )
                            ));

                            $border_top = array(
                            'borders' => array(
                                'top' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '292929')
                                )
                            ));

                            $excel->getActiveSheet()->getStyle('A5:Y5')->applyFromArray($fill_solid_first);
                            $excel->getActiveSheet()->getStyle('A5:Y5')->applyFromArray($font_color);
                            $excel->getActiveSheet()->getStyle('A5:Y5')->applyFromArray($border_all);

                            $excel->getActiveSheet()->getStyle('F5'.':'.'Y5')->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                                    ->getStyle('F5:Y5')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->setCellValue('A5','')
                                                    ->getStyle('A5')->applyFromArray($border_all);                                                                            
                            $excel->getActiveSheet()->setCellValue('B5')
                                                    ->mergeCells('B5:F5')
                                                    ->getStyle('B5:F5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('G5','Holidays')
                                                    ->mergeCells('G5:H5')
                                                    ->getStyle('G5:H5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('I5','Sunday Holidays')
                                                    ->mergeCells('I5:J5')
                                                    ->getStyle('I5:J5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('K5','Excused Leave')
                                                    ->mergeCells('K5:L5')
                                                    ->getStyle('K5:L5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('M5','')
                                                    ->getStyle('M5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('N5','Overtime')
                                                    ->mergeCells('N5:S5')
                                                    ->getStyle('N5:S5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('T5','Night Shift Differential')
                                                    ->mergeCells('T5:Y5')
                                                    ->getStyle('T5:Y5')->applyFromArray($border_all);                                                                         

                            $excel->getActiveSheet()->getStyle('A6:Y6')->applyFromArray($fill_solid_second);
                            $excel->getActiveSheet()->getStyle('A6:Y6')->applyFromArray($font_color);
                            $excel->getActiveSheet()->getStyle('A6:Y6')->applyFromArray($border_all);

                            $excel->getActiveSheet()->getStyle('F6'.':'.'Y6')->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                                    ->getStyle('F6:Y6')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->setCellValue('A6','')
                                                    ->getStyle('A6')->applyFromArray($border_all)   
                                                    ->applyFromArray($border_all);                                                           
                            $excel->getActiveSheet()->setCellValue('B6')
                                                    ->mergeCells('B6:F6')
                                                    ->getStyle('B6:F6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('B6:F6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('G6','')
                                                    ->mergeCells('G6:H6')
                                                    ->getStyle('G6:H6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('G6:H6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('I6','')
                                                    ->mergeCells('I6:J6')
                                                    ->getStyle('I6:J6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('I6:J6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('K6','')
                                                    ->mergeCells('K6:L6')
                                                    ->getStyle('K6:L6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('K6:L6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('M6','')
                                                    ->getStyle('M6')->applyFromArray($border_all)
                                                    ->applyFromArray($border_all);                                                                        
                            $excel->getActiveSheet()->setCellValue('N6','Regular')
                                                    ->mergeCells('N6:P6')
                                                    ->getStyle('N6:P6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('N6:P6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('Q6','Sunday')
                                                    ->mergeCells('Q6:S6')
                                                    ->getStyle('Q6:S6')->applyFromArray($border_all); 

                            $excel->getActiveSheet()->getStyle('Q6:S6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('T6','Regular')
                                                    ->mergeCells('T6:V6')
                                                    ->getStyle('T6:V6')->applyFromArray($border_all);     
                            $excel->getActiveSheet()->getStyle('T6:V6')->applyFromArray($border_all);  

                            $excel->getActiveSheet()->setCellValue('W6','Sunday')
                                                    ->mergeCells('W6:Y6')
                                                    ->getStyle('W6:Y6')->applyFromArray($border_all);   
                            $excel->getActiveSheet()->getStyle('W6:Y6')->applyFromArray($border_all);    

                            $excel->getActiveSheet()->getStyle('A7:Y7')->applyFromArray($fill_solid_third);
                            $excel->getActiveSheet()->getStyle('A7:Y7')->applyFromArray($font_color);

                            $excel->getActiveSheet()->getStyle('A7'.':'.'Y7')->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                                    ->getStyle('A7')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('B7')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('D7:Y7')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                            $excel->getActiveSheet()->getColumnDimension('K')->setWidth('10');
                            $excel->getActiveSheet()->getColumnDimension('L')->setWidth('13');
                            $excel->getActiveSheet()->getColumnDimension('M')->setWidth('15');

                            $excel->getActiveSheet()->setCellValue('A7','#')
                                                    ->getStyle('A7')->applyFromArray($border_all)   
                                                    ->applyFromArray($border_all);                                                           
                            $excel->getActiveSheet()->setCellValue('B7','E-CODE')
                                                    ->getStyle('B7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);                                                           
                            $excel->getActiveSheet()->setCellValue('C7','Name')
                                                    ->getStyle('C7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('D7','Reg')
                                                    ->getStyle('D7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('E7','Sun')
                                                    ->getStyle('E7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);

                            $excel->getActiveSheet()->setCellValue('F7','Day Off')
                                                    ->getStyle('F7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all); 

                            $excel->getActiveSheet()->setCellValue('G7','Reg')
                                                    ->getStyle('G7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('H7','Sun')
                                                    ->getStyle('H7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('I7','Reg')
                                                    ->getStyle('I7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('J7','Sun')
                                                    ->getStyle('J7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('K7','W/Pay')
                                                    ->getStyle('K7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('L7','WOUT/Pay')
                                                    ->getStyle('L7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('M7','Minutes Late')
                                                    ->getStyle('M7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('N7','Reg')
                                                    ->getStyle('N7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('O7','Sun Hol')
                                                    ->getStyle('O7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('P7','Spe Hol')
                                                    ->getStyle('P7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('Q7','Reg')
                                                    ->getStyle('Q7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('R7','Sun Hol')
                                                    ->getStyle('R7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('S7','Spe Hol')
                                                    ->getStyle('S7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('T7','Reg')
                                                    ->getStyle('T7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('U7','Sun Hol')
                                                    ->getStyle('U7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('V7','Spe Hol')
                                                    ->getStyle('V7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('W7','Reg')
                                                    ->getStyle('W7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('X7','Sun Hol')
                                                    ->getStyle('X7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('Y7','Spe Hol')
                                                    ->getStyle('Y7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $i = 8;

                            $countresult=0;

                            $count=1;
                            foreach($dtr_verification_list as $verificationlist){

                            $excel->getActiveSheet()
                                    ->getStyle('A'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('B'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('D'.$i.':'.'Y'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->getStyle('D'.$i.':'.'Y'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');    

                            $excel->getActiveSheet()->getStyle('A'.$i.':'.'Y'.$i)->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  

                                $excel->getActiveSheet()->setCellValue('A'.$i,$count);
                                $excel->getActiveSheet()->setCellValue('B'.$i,$verificationlist->ecode);
                                $excel->getActiveSheet()->setCellValue('C'.$i,$verificationlist->full_name);
                                $excel->getActiveSheet()->setCellValue('D'.$i,$verificationlist->reg);
                                $excel->getActiveSheet()->setCellValue('E'.$i,$verificationlist->sun);
                                $excel->getActiveSheet()->setCellValue('F'.$i,$verificationlist->day_off);
                                $excel->getActiveSheet()->setCellValue('G'.$i,$verificationlist->reg_hol);
                                $excel->getActiveSheet()->setCellValue('H'.$i,$verificationlist->spe_hol);
                                $excel->getActiveSheet()->setCellValue('I'.$i,$verificationlist->sun_reg_hol);
                                $excel->getActiveSheet()->setCellValue('J'.$i,$verificationlist->sun_spe_hol);
                                $excel->getActiveSheet()->setCellValue('K'.$i,$verificationlist->days_wout_pay);
                                $excel->getActiveSheet()->setCellValue('L'.$i,$verificationlist->days_with_pay);
                                $excel->getActiveSheet()->setCellValue('M'.$i,$verificationlist->minutes_late);
                                $excel->getActiveSheet()->setCellValue('N'.$i,$verificationlist->ot_reg);
                                $excel->getActiveSheet()->setCellValue('O'.$i,$verificationlist->ot_reg_reg_hol);
                                $excel->getActiveSheet()->setCellValue('P'.$i,$verificationlist->ot_reg_spe_hol);
                                $excel->getActiveSheet()->setCellValue('Q'.$i,$verificationlist->ot_sun);
                                $excel->getActiveSheet()->setCellValue('R'.$i,$verificationlist->ot_sun_reg_hol);
                                $excel->getActiveSheet()->setCellValue('S'.$i,$verificationlist->ot_sun_spe_hol);
                                $excel->getActiveSheet()->setCellValue('T'.$i,$verificationlist->nsd_reg);
                                $excel->getActiveSheet()->setCellValue('U'.$i,$verificationlist->nsd_reg_reg_hol);
                                $excel->getActiveSheet()->setCellValue('V'.$i,$verificationlist->nsd_reg_spe_hol);
                                $excel->getActiveSheet()->setCellValue('W'.$i,$verificationlist->nsd_sun);
                                $excel->getActiveSheet()->setCellValue('X'.$i,$verificationlist->nsd_sun_spe_hol);
                                $excel->getActiveSheet()->setCellValue('Y'.$i,$verificationlist->nsd_reg_spe_hol);

                                $countresult++;

                                $count++;
                                $i++;

                            }       
                            $i++;

                                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'Y'.$i);
                                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Records: '.$countresult)    
                                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                            $i++;
                            $excel->getActiveSheet()->mergeCells('N'.$i.':'.'P'.$i);
                            $excel->getActiveSheet()->mergeCells('R'.$i.':'.'T'.$i);
                            $excel->getActiveSheet()->mergeCells('V'.$i.':'.'X'.$i);
                            $i++;

                                $excel->getActiveSheet()
                                        ->getStyle('N'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                                $excel->getActiveSheet()
                                        ->getStyle('R'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                                $excel->getActiveSheet()
                                        ->getStyle('V'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'M'.$i);

                                $excel->getActiveSheet()->setCellValue('N'.$i,'Prepared By:')
                                                        ->mergeCells('N'.$i.':'.'P'.$i)
                                                        ->getStyle('N'.$i.':'.'P'.$i)->applyFromArray($border_top); 

                                $excel->getActiveSheet()->setCellValue('R'.$i,'Checked By:')
                                                        ->mergeCells('R'.$i.':'.'T'.$i)
                                                        ->getStyle('R'.$i.':'.'T'.$i)->applyFromArray($border_top); 

                                $excel->getActiveSheet()->setCellValue('V'.$i,'Verified By:')
                                                        ->mergeCells('V'.$i.':'.'X'.$i)
                                                        ->getStyle('V'.$i.':'.'X'.$i)->applyFromArray($border_top); 

                            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                            header('Content-Disposition: attachment;filename='."Verification List Report.xlsx".'');
                            header('Cache-Control: max-age=0');
                            // If you're serving to IE 9, then the following may be needed
                            header('Cache-Control: max-age=1');

                            // If you're serving to IE over SSL, then the following may be needed
                            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                            header ('Pragma: public'); // HTTP/1.0

                            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                            $objWriter->save('php://output');
                        }

                        //show only inside grid without menu button
                        if($type=='contentview'){
                            $excel->setActiveSheetIndex(0);

                            //name the worksheet
                            $excel->getActiveSheet()->setTitle("Verification List Report");

                            
                            $styleArray = array(
                                'font'  => array(
                                    'bold'  => false,
                                    'size'  => 10,
                                    'name'  => 'Verdana'
                                ));


                            $styleArray1 = array(
                                'font'  => array(
                                    'bold'  => false,
                                    'size'  => 10,
                                    'name'  => 'Verdana'
                                ));


                            $excel->getActiveSheet()->setCellValue('A1','Verification List (Per Department / Branch)')
                                                    ->getStyle('A1')->applyFromArray($styleArray);
                            $excel->getActiveSheet()->setCellValue('A2','Pay Period : '.$pay_period)
                                                    ->setCellValue('A3','Department : '.$dept)
                                                    ->setCellValue('A4','Branch : '.$branch)
                                                    ->getStyle('A2:A4')->applyFromArray($styleArray1);

                            $fill_solid_first = array(
                                'fill'  => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => '4FC3F7')
                                )

                            );

                            $fill_solid_second = array(
                                'fill'  => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'ECEFF1')
                                )

                            );

                            $fill_solid_third = array(
                                'fill'  => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'FFEB3B')
                                )

                            );

                            $font_color = array(
                                'font'  => array(
                                        'color' => array('rgb' => '212121')
                                ));

                            $border_all = array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '292929')
                                )
                            ));

                            $border_top = array(
                            'borders' => array(
                                'top' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '292929')
                                )
                            ));

                            $excel->getActiveSheet()->getStyle('A5:Y5')->applyFromArray($fill_solid_first);
                            $excel->getActiveSheet()->getStyle('A5:Y5')->applyFromArray($font_color);
                            $excel->getActiveSheet()->getStyle('A5:Y5')->applyFromArray($border_all);

                            $excel->getActiveSheet()->getStyle('F5'.':'.'Y5')->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                                    ->getStyle('F5:Y5')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->setCellValue('A5','')
                                                    ->getStyle('A5')->applyFromArray($border_all);                                                                            
                            $excel->getActiveSheet()->setCellValue('B5')
                                                    ->mergeCells('B5:F5')
                                                    ->getStyle('B5:F5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('G5','Holidays')
                                                    ->mergeCells('G5:H5')
                                                    ->getStyle('G5:H5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('I5','Sunday Holidays')
                                                    ->mergeCells('I5:J5')
                                                    ->getStyle('I5:J5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('K5','Excused Leave')
                                                    ->mergeCells('K5:L5')
                                                    ->getStyle('K5:L5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('M5','')
                                                    ->getStyle('M5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('N5','Overtime')
                                                    ->mergeCells('N5:S5')
                                                    ->getStyle('N5:S5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('T5','Night Shift Differential')
                                                    ->mergeCells('T5:Y5')
                                                    ->getStyle('T5:Y5')->applyFromArray($border_all);                                                                         

                            $excel->getActiveSheet()->getStyle('A6:Y6')->applyFromArray($fill_solid_second);
                            $excel->getActiveSheet()->getStyle('A6:Y6')->applyFromArray($font_color);
                            $excel->getActiveSheet()->getStyle('A6:Y6')->applyFromArray($border_all);

                            $excel->getActiveSheet()->getStyle('F6'.':'.'Y6')->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                                    ->getStyle('F6:Y6')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->setCellValue('A6','')
                                                    ->getStyle('A6')->applyFromArray($border_all)   
                                                    ->applyFromArray($border_all);                                                           
                            $excel->getActiveSheet()->setCellValue('B6')
                                                    ->mergeCells('B6:F6')
                                                    ->getStyle('B6:F6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('B6:F6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('G6','')
                                                    ->mergeCells('G6:H6')
                                                    ->getStyle('G6:H6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('G6:H6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('I6','')
                                                    ->mergeCells('I6:J6')
                                                    ->getStyle('I6:J6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('I6:J6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('K6','')
                                                    ->mergeCells('K6:L6')
                                                    ->getStyle('K6:L6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('K6:L6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('M6','')
                                                    ->getStyle('M6')->applyFromArray($border_all)
                                                    ->applyFromArray($border_all);                                                                        
                            $excel->getActiveSheet()->setCellValue('N6','Regular')
                                                    ->mergeCells('N6:P6')
                                                    ->getStyle('N6:P6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('N6:P6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('Q6','Sunday')
                                                    ->mergeCells('Q6:S6')
                                                    ->getStyle('Q6:S6')->applyFromArray($border_all); 

                            $excel->getActiveSheet()->getStyle('Q6:S6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('T6','Regular')
                                                    ->mergeCells('T6:V6')
                                                    ->getStyle('T6:V6')->applyFromArray($border_all);     
                            $excel->getActiveSheet()->getStyle('T6:V6')->applyFromArray($border_all);  

                            $excel->getActiveSheet()->setCellValue('W6','Sunday')
                                                    ->mergeCells('W6:Y6')
                                                    ->getStyle('W6:Y6')->applyFromArray($border_all);   
                            $excel->getActiveSheet()->getStyle('W6:Y6')->applyFromArray($border_all);    

                            $excel->getActiveSheet()->getStyle('A7:Y7')->applyFromArray($fill_solid_third);
                            $excel->getActiveSheet()->getStyle('A7:Y7')->applyFromArray($font_color);

                            $excel->getActiveSheet()->getStyle('A7'.':'.'Y7')->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                                    ->getStyle('A7')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('B7')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('D7:Y7')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                            $excel->getActiveSheet()->getColumnDimension('K')->setWidth('10');
                            $excel->getActiveSheet()->getColumnDimension('L')->setWidth('13');
                            $excel->getActiveSheet()->getColumnDimension('M')->setWidth('15');

                            $excel->getActiveSheet()->setCellValue('A7','#')
                                                    ->getStyle('A7')->applyFromArray($border_all)   
                                                    ->applyFromArray($border_all);                                                           
                            $excel->getActiveSheet()->setCellValue('B7','E-CODE')
                                                    ->getStyle('B7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);                                                           
                            $excel->getActiveSheet()->setCellValue('C7','Name')
                                                    ->getStyle('C7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('D7','Reg')
                                                    ->getStyle('D7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('E7','Sun')
                                                    ->getStyle('E7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);

                            $excel->getActiveSheet()->setCellValue('F7','Day Off')
                                                    ->getStyle('F7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all); 

                            $excel->getActiveSheet()->setCellValue('G7','Reg')
                                                    ->getStyle('G7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('H7','Sun')
                                                    ->getStyle('H7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('I7','Reg')
                                                    ->getStyle('I7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('J7','Sun')
                                                    ->getStyle('J7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('K7','W/Pay')
                                                    ->getStyle('K7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('L7','WOUT/Pay')
                                                    ->getStyle('L7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('M7','Minutes Late')
                                                    ->getStyle('M7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('N7','Reg')
                                                    ->getStyle('N7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('O7','Sun Hol')
                                                    ->getStyle('O7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('P7','Spe Hol')
                                                    ->getStyle('P7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('Q7','Reg')
                                                    ->getStyle('Q7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('R7','Sun Hol')
                                                    ->getStyle('R7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('S7','Spe Hol')
                                                    ->getStyle('S7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('T7','Reg')
                                                    ->getStyle('T7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('U7','Sun Hol')
                                                    ->getStyle('U7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('V7','Spe Hol')
                                                    ->getStyle('V7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('W7','Reg')
                                                    ->getStyle('W7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('X7','Sun Hol')
                                                    ->getStyle('X7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('Y7','Spe Hol')
                                                    ->getStyle('Y7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $i = 8;

                            $countresult=0;

                            $count=1;
                            foreach($dtr_verification_list as $verificationlist){

                            $excel->getActiveSheet()
                                    ->getStyle('A'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('B'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('D'.$i.':'.'Y'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->getStyle('D'.$i.':'.'Y'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');    

                            $excel->getActiveSheet()->getStyle('A'.$i.':'.'Y'.$i)->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  

                                $excel->getActiveSheet()->setCellValue('A'.$i,$count);
                                $excel->getActiveSheet()->setCellValue('B'.$i,$verificationlist->ecode);
                                $excel->getActiveSheet()->setCellValue('C'.$i,$verificationlist->full_name);
                                $excel->getActiveSheet()->setCellValue('D'.$i,$verificationlist->reg);
                                $excel->getActiveSheet()->setCellValue('E'.$i,$verificationlist->sun);
                                $excel->getActiveSheet()->setCellValue('F'.$i,$verificationlist->day_off);
                                $excel->getActiveSheet()->setCellValue('G'.$i,$verificationlist->reg_hol);
                                $excel->getActiveSheet()->setCellValue('H'.$i,$verificationlist->spe_hol);
                                $excel->getActiveSheet()->setCellValue('I'.$i,$verificationlist->sun_reg_hol);
                                $excel->getActiveSheet()->setCellValue('J'.$i,$verificationlist->sun_spe_hol);
                                $excel->getActiveSheet()->setCellValue('K'.$i,$verificationlist->days_wout_pay);
                                $excel->getActiveSheet()->setCellValue('L'.$i,$verificationlist->days_with_pay);
                                $excel->getActiveSheet()->setCellValue('M'.$i,$verificationlist->minutes_late);
                                $excel->getActiveSheet()->setCellValue('N'.$i,$verificationlist->ot_reg);
                                $excel->getActiveSheet()->setCellValue('O'.$i,$verificationlist->ot_reg_reg_hol);
                                $excel->getActiveSheet()->setCellValue('P'.$i,$verificationlist->ot_reg_spe_hol);
                                $excel->getActiveSheet()->setCellValue('Q'.$i,$verificationlist->ot_sun);
                                $excel->getActiveSheet()->setCellValue('R'.$i,$verificationlist->ot_sun_reg_hol);
                                $excel->getActiveSheet()->setCellValue('S'.$i,$verificationlist->ot_sun_spe_hol);
                                $excel->getActiveSheet()->setCellValue('T'.$i,$verificationlist->nsd_reg);
                                $excel->getActiveSheet()->setCellValue('U'.$i,$verificationlist->nsd_reg_reg_hol);
                                $excel->getActiveSheet()->setCellValue('V'.$i,$verificationlist->nsd_reg_spe_hol);
                                $excel->getActiveSheet()->setCellValue('W'.$i,$verificationlist->nsd_sun);
                                $excel->getActiveSheet()->setCellValue('X'.$i,$verificationlist->nsd_sun_spe_hol);
                                $excel->getActiveSheet()->setCellValue('Y'.$i,$verificationlist->nsd_reg_spe_hol);

                                $countresult++;

                                $count++;
                                $i++;

                            }       
                            $i++;

                                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'Y'.$i);
                                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Records: '.$countresult)    
                                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                            $i++;
                            $excel->getActiveSheet()->mergeCells('N'.$i.':'.'P'.$i);
                            $excel->getActiveSheet()->mergeCells('R'.$i.':'.'T'.$i);
                            $excel->getActiveSheet()->mergeCells('V'.$i.':'.'X'.$i);
                            $i++;

                                $excel->getActiveSheet()
                                        ->getStyle('N'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                                $excel->getActiveSheet()
                                        ->getStyle('R'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                                $excel->getActiveSheet()
                                        ->getStyle('V'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'M'.$i);

                                $excel->getActiveSheet()->setCellValue('N'.$i,'Prepared By:')
                                                        ->mergeCells('N'.$i.':'.'P'.$i)
                                                        ->getStyle('N'.$i.':'.'P'.$i)->applyFromArray($border_top); 

                                $excel->getActiveSheet()->setCellValue('R'.$i,'Checked By:')
                                                        ->mergeCells('R'.$i.':'.'T'.$i)
                                                        ->getStyle('R'.$i.':'.'T'.$i)->applyFromArray($border_top); 

                                $excel->getActiveSheet()->setCellValue('V'.$i,'Verified By:')
                                                        ->mergeCells('V'.$i.':'.'X'.$i)
                                                        ->getStyle('V'.$i.':'.'X'.$i)->applyFromArray($border_top); 

                            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                            header('Content-Disposition: attachment;filename='."Verification List Report.xlsx".'');
                            header('Cache-Control: max-age=0');
                            // If you're serving to IE 9, then the following may be needed
                            header('Cache-Control: max-age=1');

                            // If you're serving to IE over SSL, then the following may be needed
                            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                            header ('Pragma: public'); // HTTP/1.0

                            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                            $objWriter->save('php://output');
                        }

            break;

            case 'email-dtr-verification-list': //
                        $excel = $this->excel;
                        $m_user = $this->Users_model;

                        $id = $this->session->user_id;
                        $email = $m_user->get_email($id);

                        if($filter_value2=="all" AND $filter_value3=="all"){
                        $filter=array('daily_time_record.pay_period_id'=>$filter_value,'employee_list.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2=="all" AND $filter_value3!="all"){
                        $filter=array('daily_time_record.pay_period_id'=>$filter_value,'ref_branch.ref_branch_id'=>$filter_value3,'employee_list.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2!="all" AND $filter_value3=="all"){
                        $filter=array('daily_time_record.pay_period_id'=>$filter_value,'ref_department.ref_department_id'=>$filter_value2,'employee_list.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2!="all" AND $filter_value3!="all"){
                        $filter=array('daily_time_record.pay_period_id'=>$filter_value,'ref_department.ref_department_id'=>$filter_value2,'ref_branch.ref_branch_id'=>$filter_value3,'employee_list.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        $dtr_verification_list=$this->DailyTimeRecord_model->get_list(
                        $filter,
                        'daily_time_record.*,employee_list.ecode,CONCAT(employee_list.first_name," ",employee_list.middle_name," ",employee_list.last_name) as full_name',
                        array(
                             array('employee_list','employee_list.employee_id=daily_time_record.employee_id','left'),
                             array('emp_rates_duties','emp_rates_duties.employee_id=employee_list.employee_id','left'),
                             array('ref_department','ref_department.ref_department_id=emp_rates_duties.ref_department_id','left'),
                             array('ref_branch','ref_branch.ref_branch_id=emp_rates_duties.ref_branch_id','left'),
                             ),
                        'employee_list.last_name ASC'
                        );

                        $period=$this->RefPayPeriod_model->getperiod($filter_value);
                        $pay_period=$period[0]->period;

                        //echo json_encode($data);
                        $getcompany=$this->GeneralSettings_model->get_list(
                        null,
                        'company_setup.*'
                        );
                        if($filter_value2=="all"){
                            $dept="All Department";
                        }
                        else{
                        $getdept=$this->RefDepartment_model->get_list(
                        $filter_value2,
                        'ref_department.department,'
                        );
                        $dept=$getdept[0]->department;
                        }
                        if($filter_value3=="all"){
                            $branch="All Branch";
                        }
                        else{
                        $getbranch=$this->RefBranch_model->get_list(
                        $filter_value3,
                        'ref_branch.branch,'
                        );
                        $branch=$getbranch[0]->branch;
                        }
                        //echo $data['dept'];

                        $company=$getcompany[0];
                        //echo json_encode($data);
                        //show only inside grid with menu button
                        if($type=='fullview'||$type==null){
                            ob_start();
                            $excel->setActiveSheetIndex(0);

                            //name the worksheet
                            $excel->getActiveSheet()->setTitle("Verification List Report");

                            $styleArray = array(
                                'font'  => array(
                                    'bold'  => false,
                                    'size'  => 10,
                                    'name'  => 'Verdana'
                                ));


                            $styleArray1 = array(
                                'font'  => array(
                                    'bold'  => false,
                                    'size'  => 10,
                                    'name'  => 'Verdana'
                                ));


                            $excel->getActiveSheet()->setCellValue('A1','Verification List (Per Department / Branch)')
                                                    ->getStyle('A1')->applyFromArray($styleArray);
                            $excel->getActiveSheet()->setCellValue('A2','Pay Period : '.$pay_period)
                                                    ->setCellValue('A3','Department : '.$dept)
                                                    ->setCellValue('A4','Branch : '.$branch)
                                                    ->getStyle('A2:A4')->applyFromArray($styleArray1);

                            $fill_solid_first = array(
                                'fill'  => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => '4FC3F7')
                                )

                            );

                            $fill_solid_second = array(
                                'fill'  => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'ECEFF1')
                                )

                            );

                            $fill_solid_third = array(
                                'fill'  => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'FFEB3B')
                                )

                            );

                            $font_color = array(
                                'font'  => array(
                                        'color' => array('rgb' => '212121')
                                ));

                            $border_all = array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '292929')
                                )
                            ));

                            $border_top = array(
                            'borders' => array(
                                'top' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '292929')
                                )
                            ));

                            $excel->getActiveSheet()->getStyle('A5:Y5')->applyFromArray($fill_solid_first);
                            $excel->getActiveSheet()->getStyle('A5:Y5')->applyFromArray($font_color);
                            $excel->getActiveSheet()->getStyle('A5:Y5')->applyFromArray($border_all);

                            $excel->getActiveSheet()->getStyle('F5'.':'.'Y5')->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                                    ->getStyle('F5:Y5')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->setCellValue('A5','')
                                                    ->getStyle('A5')->applyFromArray($border_all);                                                                            
                            $excel->getActiveSheet()->setCellValue('B5')
                                                    ->mergeCells('B5:F5')
                                                    ->getStyle('B5:F5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('G5','Holidays')
                                                    ->mergeCells('G5:H5')
                                                    ->getStyle('G5:H5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('I5','Sunday Holidays')
                                                    ->mergeCells('I5:J5')
                                                    ->getStyle('I5:J5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('K5','Excused Leave')
                                                    ->mergeCells('K5:L5')
                                                    ->getStyle('K5:L5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('M5','')
                                                    ->getStyle('M5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('N5','Overtime')
                                                    ->mergeCells('N5:S5')
                                                    ->getStyle('N5:S5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('T5','Night Shift Differential')
                                                    ->mergeCells('T5:Y5')
                                                    ->getStyle('T5:Y5')->applyFromArray($border_all);                                                                         

                            $excel->getActiveSheet()->getStyle('A6:Y6')->applyFromArray($fill_solid_second);
                            $excel->getActiveSheet()->getStyle('A6:Y6')->applyFromArray($font_color);
                            $excel->getActiveSheet()->getStyle('A6:Y6')->applyFromArray($border_all);

                            $excel->getActiveSheet()->getStyle('F6'.':'.'Y6')->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                                    ->getStyle('F6:Y6')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->setCellValue('A6','')
                                                    ->getStyle('A6')->applyFromArray($border_all)   
                                                    ->applyFromArray($border_all);                                                           
                            $excel->getActiveSheet()->setCellValue('B6')
                                                    ->mergeCells('B6:F6')
                                                    ->getStyle('B6:F6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('B6:F6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('G6','')
                                                    ->mergeCells('G6:H6')
                                                    ->getStyle('G6:H6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('G6:H6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('I6','')
                                                    ->mergeCells('I6:J6')
                                                    ->getStyle('I6:J6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('I6:J6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('K6','')
                                                    ->mergeCells('K6:L6')
                                                    ->getStyle('K6:L6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('K6:L6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('M6','')
                                                    ->getStyle('M6')->applyFromArray($border_all)
                                                    ->applyFromArray($border_all);                                                                        
                            $excel->getActiveSheet()->setCellValue('N6','Regular')
                                                    ->mergeCells('N6:P6')
                                                    ->getStyle('N6:P6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('N6:P6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('Q6','Sunday')
                                                    ->mergeCells('Q6:S6')
                                                    ->getStyle('Q6:S6')->applyFromArray($border_all); 

                            $excel->getActiveSheet()->getStyle('Q6:S6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('T6','Regular')
                                                    ->mergeCells('T6:V6')
                                                    ->getStyle('T6:V6')->applyFromArray($border_all);     
                            $excel->getActiveSheet()->getStyle('T6:V6')->applyFromArray($border_all);  

                            $excel->getActiveSheet()->setCellValue('W6','Sunday')
                                                    ->mergeCells('W6:Y6')
                                                    ->getStyle('W6:Y6')->applyFromArray($border_all);   
                            $excel->getActiveSheet()->getStyle('W6:Y6')->applyFromArray($border_all);    

                            $excel->getActiveSheet()->getStyle('A7:Y7')->applyFromArray($fill_solid_third);
                            $excel->getActiveSheet()->getStyle('A7:Y7')->applyFromArray($font_color);

                            $excel->getActiveSheet()->getStyle('A7'.':'.'Y7')->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                                    ->getStyle('A7')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('B7')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('D7:Y7')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                            $excel->getActiveSheet()->getColumnDimension('K')->setWidth('10');
                            $excel->getActiveSheet()->getColumnDimension('L')->setWidth('13');
                            $excel->getActiveSheet()->getColumnDimension('M')->setWidth('15');

                            $excel->getActiveSheet()->setCellValue('A7','#')
                                                    ->getStyle('A7')->applyFromArray($border_all)   
                                                    ->applyFromArray($border_all);                                                           
                            $excel->getActiveSheet()->setCellValue('B7','E-CODE')
                                                    ->getStyle('B7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);                                                           
                            $excel->getActiveSheet()->setCellValue('C7','Name')
                                                    ->getStyle('C7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('D7','Reg')
                                                    ->getStyle('D7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('E7','Sun')
                                                    ->getStyle('E7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);

                            $excel->getActiveSheet()->setCellValue('F7','Day Off')
                                                    ->getStyle('F7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all); 

                            $excel->getActiveSheet()->setCellValue('G7','Reg')
                                                    ->getStyle('G7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('H7','Sun')
                                                    ->getStyle('H7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('I7','Reg')
                                                    ->getStyle('I7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('J7','Sun')
                                                    ->getStyle('J7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('K7','W/Pay')
                                                    ->getStyle('K7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('L7','WOUT/Pay')
                                                    ->getStyle('L7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('M7','Minutes Late')
                                                    ->getStyle('M7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('N7','Reg')
                                                    ->getStyle('N7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('O7','Sun Hol')
                                                    ->getStyle('O7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('P7','Spe Hol')
                                                    ->getStyle('P7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('Q7','Reg')
                                                    ->getStyle('Q7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('R7','Sun Hol')
                                                    ->getStyle('R7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('S7','Spe Hol')
                                                    ->getStyle('S7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('T7','Reg')
                                                    ->getStyle('T7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('U7','Sun Hol')
                                                    ->getStyle('U7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('V7','Spe Hol')
                                                    ->getStyle('V7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('W7','Reg')
                                                    ->getStyle('W7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('X7','Sun Hol')
                                                    ->getStyle('X7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('Y7','Spe Hol')
                                                    ->getStyle('Y7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $i = 8;

                            $countresult=0;

                            $count=1;
                            foreach($dtr_verification_list as $verificationlist){

                            $excel->getActiveSheet()
                                    ->getStyle('A'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('B'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('D'.$i.':'.'Y'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->getStyle('D'.$i.':'.'Y'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');    

                            $excel->getActiveSheet()->getStyle('A'.$i.':'.'Y'.$i)->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  

                                $excel->getActiveSheet()->setCellValue('A'.$i,$count);
                                $excel->getActiveSheet()->setCellValue('B'.$i,$verificationlist->ecode);
                                $excel->getActiveSheet()->setCellValue('C'.$i,$verificationlist->full_name);
                                $excel->getActiveSheet()->setCellValue('D'.$i,$verificationlist->reg);
                                $excel->getActiveSheet()->setCellValue('E'.$i,$verificationlist->sun);
                                $excel->getActiveSheet()->setCellValue('F'.$i,$verificationlist->day_off);
                                $excel->getActiveSheet()->setCellValue('G'.$i,$verificationlist->reg_hol);
                                $excel->getActiveSheet()->setCellValue('H'.$i,$verificationlist->spe_hol);
                                $excel->getActiveSheet()->setCellValue('I'.$i,$verificationlist->sun_reg_hol);
                                $excel->getActiveSheet()->setCellValue('J'.$i,$verificationlist->sun_spe_hol);
                                $excel->getActiveSheet()->setCellValue('K'.$i,$verificationlist->days_wout_pay);
                                $excel->getActiveSheet()->setCellValue('L'.$i,$verificationlist->days_with_pay);
                                $excel->getActiveSheet()->setCellValue('M'.$i,$verificationlist->minutes_late);
                                $excel->getActiveSheet()->setCellValue('N'.$i,$verificationlist->ot_reg);
                                $excel->getActiveSheet()->setCellValue('O'.$i,$verificationlist->ot_reg_reg_hol);
                                $excel->getActiveSheet()->setCellValue('P'.$i,$verificationlist->ot_reg_spe_hol);
                                $excel->getActiveSheet()->setCellValue('Q'.$i,$verificationlist->ot_sun);
                                $excel->getActiveSheet()->setCellValue('R'.$i,$verificationlist->ot_sun_reg_hol);
                                $excel->getActiveSheet()->setCellValue('S'.$i,$verificationlist->ot_sun_spe_hol);
                                $excel->getActiveSheet()->setCellValue('T'.$i,$verificationlist->nsd_reg);
                                $excel->getActiveSheet()->setCellValue('U'.$i,$verificationlist->nsd_reg_reg_hol);
                                $excel->getActiveSheet()->setCellValue('V'.$i,$verificationlist->nsd_reg_spe_hol);
                                $excel->getActiveSheet()->setCellValue('W'.$i,$verificationlist->nsd_sun);
                                $excel->getActiveSheet()->setCellValue('X'.$i,$verificationlist->nsd_sun_spe_hol);
                                $excel->getActiveSheet()->setCellValue('Y'.$i,$verificationlist->nsd_reg_spe_hol);

                                $countresult++;

                                $count++;
                                $i++;

                            }       
                            $i++;

                                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'Y'.$i);
                                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Records: '.$countresult)    
                                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                            $i++;
                            $excel->getActiveSheet()->mergeCells('N'.$i.':'.'P'.$i);
                            $excel->getActiveSheet()->mergeCells('R'.$i.':'.'T'.$i);
                            $excel->getActiveSheet()->mergeCells('V'.$i.':'.'X'.$i);
                            $i++;

                                $excel->getActiveSheet()
                                        ->getStyle('N'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                                $excel->getActiveSheet()
                                        ->getStyle('R'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                                $excel->getActiveSheet()
                                        ->getStyle('V'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'M'.$i);

                                $excel->getActiveSheet()->setCellValue('N'.$i,'Prepared By:')
                                                        ->mergeCells('N'.$i.':'.'P'.$i)
                                                        ->getStyle('N'.$i.':'.'P'.$i)->applyFromArray($border_top); 

                                $excel->getActiveSheet()->setCellValue('R'.$i,'Checked By:')
                                                        ->mergeCells('R'.$i.':'.'T'.$i)
                                                        ->getStyle('R'.$i.':'.'T'.$i)->applyFromArray($border_top); 

                                $excel->getActiveSheet()->setCellValue('V'.$i,'Verified By:')
                                                        ->mergeCells('V'.$i.':'.'X'.$i)
                                                        ->getStyle('V'.$i.':'.'X'.$i)->applyFromArray($border_top); 

                            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                            header('Content-Disposition: attachment;filename='."Verification List Report.xlsx".'');
                            header('Cache-Control: max-age=0');
                            // If you're serving to IE 9, then the following may be needed
                            header('Cache-Control: max-age=1');

                            // If you're serving to IE over SSL, then the following may be needed
                            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                            header ('Pragma: public'); // HTTP/1.0

                            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                            $objWriter->save('php://output');
                            $data = ob_get_clean();

                            $file_name='Verification List Report '.date('Y-m-d h:i:A', now());
                            $excelFilePath = $file_name.".xlsx"; //generate filename base on id
                            //download it.
                            // Set SMTP Configuration
                            $emailConfig = array(
                                'protocol' => 'smtp', 
                                'smtp_host' => 'ssl://smtp.googlemail.com', 
                                'smtp_port' => 465, 
                                'smtp_user' => $getcompany[0]->email_address, 
                                'smtp_pass' => $getcompany[0]->email_password, 
                                'mailtype' => 'html', 
                                'charset' => 'iso-8859-1'
                            );

                            // Set your email information
                            
                            $from = array(
                                'email' => $getcompany[0]->email_address,
                                'name' => $getcompany[0]->company_name
                            );

                            $to = array($email[0]->user_email);
                            $subject = 'Verification List Report';
                          //  $message = 'Type your gmail message here';
                            $message = '<p>To: ' .$email[0]->user_email. '</p></ br>' .'Verification List Report'.'</ br><p>Sent By: '. '<b>'.$getcompany[0]->company_name.'</b>'. '</p></ br>' .date('Y-m-d h:i:A', now());

                            // Load CodeIgniter Email library
                            $this->load->library('email', $emailConfig);
                            // Sometimes you have to set the new line character for better result
                            $this->email->set_newline("\r\n");
                            // Set email preferences
                            $this->email->from($from['email'], $from['name']);
                            $this->email->to($to);
                            $this->email->subject($subject);
                            $this->email->message($message);
                            $this->email->attach($data, 'attachment', $excelFilePath , 'application/ms-excel');
                            $this->email->set_mailtype("html");
                            // Ready to send email and check whether the email was successfully sent
                            if (!$this->email->send()) {
                                // Raise error message
                            $response['title']='Try Again!';
                            $response['stat']='error';
                            $response['msg']='Please check the Email Address of your Account or your Internet Connection.';

                            echo json_encode($response);
                            } else {
                                // Show success notification or other things here
                            $response['title']='Success!';
                            $response['stat']='success';
                            $response['msg']='Email Sent successfully.';

                            echo json_encode($response);
                            }
                        }

                        //show only inside grid without menu button
                        if($type=='contentview'){
                            ob_start();
                            $excel->setActiveSheetIndex(0);

                            //name the worksheet
                            $excel->getActiveSheet()->setTitle("Verification List Report");

                        
                            $styleArray = array(
                                'font'  => array(
                                    'bold'  => false,
                                    'size'  => 10,
                                    'name'  => 'Verdana'
                                ));


                            $styleArray1 = array(
                                'font'  => array(
                                    'bold'  => false,
                                    'size'  => 10,
                                    'name'  => 'Verdana'
                                ));


                            $excel->getActiveSheet()->setCellValue('A1','Verification List (Per Department / Branch)')
                                                    ->getStyle('A1')->applyFromArray($styleArray);
                            $excel->getActiveSheet()->setCellValue('A2','Pay Period : '.$pay_period)
                                                    ->setCellValue('A3','Department : '.$dept)
                                                    ->setCellValue('A4','Branch : '.$branch)
                                                    ->getStyle('A2:A4')->applyFromArray($styleArray1);

                            $fill_solid_first = array(
                                'fill'  => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => '4FC3F7')
                                )

                            );

                            $fill_solid_second = array(
                                'fill'  => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'ECEFF1')
                                )

                            );

                            $fill_solid_third = array(
                                'fill'  => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => 'FFEB3B')
                                )

                            );

                            $font_color = array(
                                'font'  => array(
                                        'color' => array('rgb' => '212121')
                                ));

                            $border_all = array(
                            'borders' => array(
                                'allborders' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '292929')
                                )
                            ));

                            $border_top = array(
                            'borders' => array(
                                'top' => array(
                                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                                    'color' => array('rgb' => '292929')
                                )
                            ));

                            $excel->getActiveSheet()->getStyle('A5:Y5')->applyFromArray($fill_solid_first);
                            $excel->getActiveSheet()->getStyle('A5:Y5')->applyFromArray($font_color);
                            $excel->getActiveSheet()->getStyle('A5:Y5')->applyFromArray($border_all);

                            $excel->getActiveSheet()->getStyle('F5'.':'.'Y5')->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                                    ->getStyle('F5:Y5')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->setCellValue('A5','')
                                                    ->getStyle('A5')->applyFromArray($border_all);                                                                            
                            $excel->getActiveSheet()->setCellValue('B5')
                                                    ->mergeCells('B5:F5')
                                                    ->getStyle('B5:F5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('G5','Holidays')
                                                    ->mergeCells('G5:H5')
                                                    ->getStyle('G5:H5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('I5','Sunday Holidays')
                                                    ->mergeCells('I5:J5')
                                                    ->getStyle('I5:J5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('K5','Excused Leave')
                                                    ->mergeCells('K5:L5')
                                                    ->getStyle('K5:L5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('M5','')
                                                    ->getStyle('M5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('N5','Overtime')
                                                    ->mergeCells('N5:S5')
                                                    ->getStyle('N5:S5')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->setCellValue('T5','Night Shift Differential')
                                                    ->mergeCells('T5:Y5')
                                                    ->getStyle('T5:Y5')->applyFromArray($border_all);                                                                         

                            $excel->getActiveSheet()->getStyle('A6:Y6')->applyFromArray($fill_solid_second);
                            $excel->getActiveSheet()->getStyle('A6:Y6')->applyFromArray($font_color);
                            $excel->getActiveSheet()->getStyle('A6:Y6')->applyFromArray($border_all);

                            $excel->getActiveSheet()->getStyle('F6'.':'.'Y6')->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                                    ->getStyle('F6:Y6')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->setCellValue('A6','')
                                                    ->getStyle('A6')->applyFromArray($border_all)   
                                                    ->applyFromArray($border_all);                                                           
                            $excel->getActiveSheet()->setCellValue('B6')
                                                    ->mergeCells('B6:F6')
                                                    ->getStyle('B6:F6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('B6:F6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('G6','')
                                                    ->mergeCells('G6:H6')
                                                    ->getStyle('G6:H6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('G6:H6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('I6','')
                                                    ->mergeCells('I6:J6')
                                                    ->getStyle('I6:J6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('I6:J6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('K6','')
                                                    ->mergeCells('K6:L6')
                                                    ->getStyle('K6:L6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('K6:L6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('M6','')
                                                    ->getStyle('M6')->applyFromArray($border_all)
                                                    ->applyFromArray($border_all);                                                                        
                            $excel->getActiveSheet()->setCellValue('N6','Regular')
                                                    ->mergeCells('N6:P6')
                                                    ->getStyle('N6:P6')->applyFromArray($border_all);                                                                         
                            $excel->getActiveSheet()->getStyle('N6:P6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('Q6','Sunday')
                                                    ->mergeCells('Q6:S6')
                                                    ->getStyle('Q6:S6')->applyFromArray($border_all); 

                            $excel->getActiveSheet()->getStyle('Q6:S6')->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('T6','Regular')
                                                    ->mergeCells('T6:V6')
                                                    ->getStyle('T6:V6')->applyFromArray($border_all);     
                            $excel->getActiveSheet()->getStyle('T6:V6')->applyFromArray($border_all);  

                            $excel->getActiveSheet()->setCellValue('W6','Sunday')
                                                    ->mergeCells('W6:Y6')
                                                    ->getStyle('W6:Y6')->applyFromArray($border_all);   
                            $excel->getActiveSheet()->getStyle('W6:Y6')->applyFromArray($border_all);    

                            $excel->getActiveSheet()->getStyle('A7:Y7')->applyFromArray($fill_solid_third);
                            $excel->getActiveSheet()->getStyle('A7:Y7')->applyFromArray($font_color);

                            $excel->getActiveSheet()->getStyle('A7'.':'.'Y7')->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()
                                    ->getStyle('A7')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('B7')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('D7:Y7')
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->getColumnDimension('C')->setWidth('40');
                            $excel->getActiveSheet()->getColumnDimension('K')->setWidth('10');
                            $excel->getActiveSheet()->getColumnDimension('L')->setWidth('13');
                            $excel->getActiveSheet()->getColumnDimension('M')->setWidth('15');

                            $excel->getActiveSheet()->setCellValue('A7','#')
                                                    ->getStyle('A7')->applyFromArray($border_all)   
                                                    ->applyFromArray($border_all);                                                           
                            $excel->getActiveSheet()->setCellValue('B7','E-CODE')
                                                    ->getStyle('B7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);                                                           
                            $excel->getActiveSheet()->setCellValue('C7','Name')
                                                    ->getStyle('C7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);    
                            $excel->getActiveSheet()->setCellValue('D7','Reg')
                                                    ->getStyle('D7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('E7','Sun')
                                                    ->getStyle('E7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);

                            $excel->getActiveSheet()->setCellValue('F7','Day Off')
                                                    ->getStyle('F7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all); 

                            $excel->getActiveSheet()->setCellValue('G7','Reg')
                                                    ->getStyle('G7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('H7','Sun')
                                                    ->getStyle('H7')->applyFromArray($border_all)                                                                        
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('I7','Reg')
                                                    ->getStyle('I7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('J7','Sun')
                                                    ->getStyle('J7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('K7','W/Pay')
                                                    ->getStyle('K7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('L7','WOUT/Pay')
                                                    ->getStyle('L7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('M7','Minutes Late')
                                                    ->getStyle('M7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('N7','Reg')
                                                    ->getStyle('N7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('O7','Sun Hol')
                                                    ->getStyle('O7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('P7','Spe Hol')
                                                    ->getStyle('P7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('Q7','Reg')
                                                    ->getStyle('Q7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('R7','Sun Hol')
                                                    ->getStyle('R7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('S7','Spe Hol')
                                                    ->getStyle('S7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('T7','Reg')
                                                    ->getStyle('T7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('U7','Sun Hol')
                                                    ->getStyle('U7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('V7','Spe Hol')
                                                    ->getStyle('V7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('W7','Reg')
                                                    ->getStyle('W7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('X7','Sun Hol')
                                                    ->getStyle('X7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $excel->getActiveSheet()->setCellValue('Y7','Spe Hol')
                                                    ->getStyle('Y7')->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  
                            $i = 8;

                            $countresult=0;

                            $count=1;
                            foreach($dtr_verification_list as $verificationlist){

                            $excel->getActiveSheet()
                                    ->getStyle('A'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('B'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $excel->getActiveSheet()
                                    ->getStyle('D'.$i.':'.'Y'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                            $excel->getActiveSheet()->getStyle('D'.$i.':'.'Y'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');    

                            $excel->getActiveSheet()->getStyle('A'.$i.':'.'Y'.$i)->applyFromArray($border_all) 
                                                    ->applyFromArray($border_all);  

                                $excel->getActiveSheet()->setCellValue('A'.$i,$count);
                                $excel->getActiveSheet()->setCellValue('B'.$i,$verificationlist->ecode);
                                $excel->getActiveSheet()->setCellValue('C'.$i,$verificationlist->full_name);
                                $excel->getActiveSheet()->setCellValue('D'.$i,$verificationlist->reg);
                                $excel->getActiveSheet()->setCellValue('E'.$i,$verificationlist->sun);
                                $excel->getActiveSheet()->setCellValue('F'.$i,$verificationlist->day_off);
                                $excel->getActiveSheet()->setCellValue('G'.$i,$verificationlist->reg_hol);
                                $excel->getActiveSheet()->setCellValue('H'.$i,$verificationlist->spe_hol);
                                $excel->getActiveSheet()->setCellValue('I'.$i,$verificationlist->sun_reg_hol);
                                $excel->getActiveSheet()->setCellValue('J'.$i,$verificationlist->sun_spe_hol);
                                $excel->getActiveSheet()->setCellValue('K'.$i,$verificationlist->days_wout_pay);
                                $excel->getActiveSheet()->setCellValue('L'.$i,$verificationlist->days_with_pay);
                                $excel->getActiveSheet()->setCellValue('M'.$i,$verificationlist->minutes_late);
                                $excel->getActiveSheet()->setCellValue('N'.$i,$verificationlist->ot_reg);
                                $excel->getActiveSheet()->setCellValue('O'.$i,$verificationlist->ot_reg_reg_hol);
                                $excel->getActiveSheet()->setCellValue('P'.$i,$verificationlist->ot_reg_spe_hol);
                                $excel->getActiveSheet()->setCellValue('Q'.$i,$verificationlist->ot_sun);
                                $excel->getActiveSheet()->setCellValue('R'.$i,$verificationlist->ot_sun_reg_hol);
                                $excel->getActiveSheet()->setCellValue('S'.$i,$verificationlist->ot_sun_spe_hol);
                                $excel->getActiveSheet()->setCellValue('T'.$i,$verificationlist->nsd_reg);
                                $excel->getActiveSheet()->setCellValue('U'.$i,$verificationlist->nsd_reg_reg_hol);
                                $excel->getActiveSheet()->setCellValue('V'.$i,$verificationlist->nsd_reg_spe_hol);
                                $excel->getActiveSheet()->setCellValue('W'.$i,$verificationlist->nsd_sun);
                                $excel->getActiveSheet()->setCellValue('X'.$i,$verificationlist->nsd_sun_spe_hol);
                                $excel->getActiveSheet()->setCellValue('Y'.$i,$verificationlist->nsd_reg_spe_hol);

                                $countresult++;

                                $count++;
                                $i++;

                            }       
                            $i++;

                                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'Y'.$i);
                                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Records: '.$countresult)    
                                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                            $i++;
                            $excel->getActiveSheet()->mergeCells('N'.$i.':'.'P'.$i);
                            $excel->getActiveSheet()->mergeCells('R'.$i.':'.'T'.$i);
                            $excel->getActiveSheet()->mergeCells('V'.$i.':'.'X'.$i);
                            $i++;

                                $excel->getActiveSheet()
                                        ->getStyle('N'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                                $excel->getActiveSheet()
                                        ->getStyle('R'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                                $excel->getActiveSheet()
                                        ->getStyle('V'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'M'.$i);

                                $excel->getActiveSheet()->setCellValue('N'.$i,'Prepared By:')
                                                        ->mergeCells('N'.$i.':'.'P'.$i)
                                                        ->getStyle('N'.$i.':'.'P'.$i)->applyFromArray($border_top); 

                                $excel->getActiveSheet()->setCellValue('R'.$i,'Checked By:')
                                                        ->mergeCells('R'.$i.':'.'T'.$i)
                                                        ->getStyle('R'.$i.':'.'T'.$i)->applyFromArray($border_top); 

                                $excel->getActiveSheet()->setCellValue('V'.$i,'Verified By:')
                                                        ->mergeCells('V'.$i.':'.'X'.$i)
                                                        ->getStyle('V'.$i.':'.'X'.$i)->applyFromArray($border_top); 

                            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                            header('Content-Disposition: attachment;filename='."Verification List Report.xlsx".'');
                            header('Cache-Control: max-age=0');
                            // If you're serving to IE 9, then the following may be needed
                            header('Cache-Control: max-age=1');

                            // If you're serving to IE over SSL, then the following may be needed
                            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                            header ('Pragma: public'); // HTTP/1.0

                            $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                            $objWriter->save('php://output');
                            $data = ob_get_clean();

                            $file_name='Verification List Report '.date('Y-m-d h:i:A', now());
                            $excelFilePath = $file_name.".xlsx"; //generate filename base on id
                            //download it.
                            // Set SMTP Configuration
                            $emailConfig = array(
                                'protocol' => 'smtp', 
                                'smtp_host' => 'ssl://smtp.googlemail.com', 
                                'smtp_port' => 465, 
                                'smtp_user' => $getcompany[0]->email_address, 
                                'smtp_pass' => $getcompany[0]->email_password, 
                                'mailtype' => 'html', 
                                'charset' => 'iso-8859-1'
                            );

                            // Set your email information
                            
                            $from = array(
                                'email' => $getcompany[0]->email_address,
                                'name' => $getcompany[0]->company_name
                            );

                            $to = array($email[0]->user_email);
                            $subject = 'Verification List Report';
                          //  $message = 'Type your gmail message here';
                            $message = '<p>To: ' .$email[0]->user_email. '</p></ br>' .'Verification List Report'.'</ br><p>Sent By: '. '<b>'.$getcompany[0]->company_name.'</b>'. '</p></ br>' .date('Y-m-d h:i:A', now());

                            // Load CodeIgniter Email library
                            $this->load->library('email', $emailConfig);
                            // Sometimes you have to set the new line character for better result
                            $this->email->set_newline("\r\n");
                            // Set email preferences
                            $this->email->from($from['email'], $from['name']);
                            $this->email->to($to);
                            $this->email->subject($subject);
                            $this->email->message($message);
                            $this->email->attach($data, 'attachment', $excelFilePath , 'application/ms-excel');
                            $this->email->set_mailtype("html");
                            // Ready to send email and check whether the email was successfully sent
                            if (!$this->email->send()) {
                                // Raise error message
                            $response['title']='Try Again!';
                            $response['stat']='error';
                            $response['msg']='Please check the Email Address of your Account or your Internet Connection.';

                            echo json_encode($response);
                            } else {
                                // Show success notification or other things here
                            $response['title']='Success!';
                            $response['stat']='success';
                            $response['msg']='Email Sent successfully.';

                            echo json_encode($response);
                            }                            
                        }

                        break;


        }
    }


}
