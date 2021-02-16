<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class monthly_employee_loan extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        // if($this->session->userdata('right_monthly_employee_loan_view') == 0 || $this->session->userdata('right_monthly_employee_loan_view') == null) {
        //     redirect('../Dashboard');
        // }
        $this->load->library('excel');
        $this->load->model('Employee_model');
        $this->load->model('SchedEmployee_model');
        $this->load->model('RefSchedPay_model');
        $this->load->model('SchedRefShift_model');
        $this->load->model('RefPayPeriod_model');
        $this->load->model('SchedDTR_model');
        $this->load->model('RefBranch_model');
        $this->load->model('PayrollReports_model');
        $this->load->model('RefDeductionSetup_model');

    }
    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_rights'] = $this->load->view('template/elements/rights', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['loader'] = $this->load->view('template/elements/loader', '', TRUE);
        $data['loaderscript'] = $this->load->view('template/elements/loaderscript', '', TRUE);
        $data['title'] = 'Monthly Employee Loan';

        $data['employees'] = $this->Employee_model->getEmplist();

        $this->load->view('monthly_employee_loan_view', $data);
    }


    function layout($transaction=null,$filter_value=null,$filter_value2=null,$filter_value3=null,$type=null){

        switch($transaction){

            case 'export_employee_monthly_loan':

            $year = $filter_value;        
            $employee_id = $filter_value2;

            $employee = $this->Employee_model->get_list($employee_id)[0];
            $items=$this->PayrollReports_model->employee_loan($employee_id,$year);
            
            $excel=$this->excel;

            $excel->setActiveSheetIndex(0);

            $employee_name = $employee->last_name.', '.$employee->first_name.' '.$employee->middle_name;

            $excel->getActiveSheet()->setTitle($year);
            $excel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->setCellValue('A1',$employee_name)
                                    ->setCellValue('A2','FOR THE YEAR '.$year);
     

            $bouble_bottom = array(
              'borders' => array(               
                'bottom' => array(
                  'style' => PHPExcel_Style_Border::BORDER_DOUBLE
                )
              )
            );                                                                        

            $rowCount1 = 3;
            $column1 = 'A';

            $excel->getActiveSheet()->getColumnDimension('A')->setWidth('30');
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth('12');
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth('12');
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth('12');
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth('12');
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth('12');
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth('12');
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth('12');
            $excel->getActiveSheet()->getColumnDimension('I')->setWidth('12');
            $excel->getActiveSheet()->getColumnDimension('J')->setWidth('12');
            $excel->getActiveSheet()->getColumnDimension('K')->setWidth('12');
            $excel->getActiveSheet()->getColumnDimension('L')->setWidth('12');
            $excel->getActiveSheet()->getColumnDimension('M')->setWidth('12');
            $excel->getActiveSheet()->getColumnDimension('N')->setWidth('12');

            foreach($items[0] as $key => $value)
            {

                $excel->getActiveSheet()->setCellValue($column1.$rowCount1, $key); 
                $excel->getActiveSheet()->getStyle($column1.$rowCount1)->getFont()->setBold(TRUE);

                $excel->getActiveSheet()
                        ->getStyle($column1.$rowCount1)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $column1++;
            }
                                                              
            //end of adding column names 
            //start foreach loop to get data

            $rowCount = 4;

            foreach($items as $key => $values) 
            {
             //start of printing column names as names of MySQL fields 
             $column = 'A';

             foreach($values as $value) 
             {

                $excel->getActiveSheet()->setCellValue($column.$rowCount, $value);
                $excel->getActiveSheet()->getStyle($column.$rowCount)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 

             $column++; 

             } 

             $rowCount++;

            }

            // $rowCount2 = $rowCount;
            // $column2 = 'A';
            // $lastrow = count($items) + 5;

            // $excel->getActiveSheet()->getStyle($column.$rowCount.':'.$column.$lastrow)->getFont()->setBold(TRUE);

            // $excel->getActiveSheet()->setCellValue('AH31', $column.$rowCount); 

            // foreach($items[0] as $key => $value)
            // {

            //     if($column2 == "M"){
            //         $excel->getActiveSheet()->setCellValue($column2.$rowCount2, 'Total'); 
            //     }else if($column2 == "N"){
            //         $excel->getActiveSheet()->setCellValue($column2.$rowCount2, "=SUM(".$column2."6:".$column2.$lastrow.")"); 

            //     $excel->getActiveSheet()->getStyle($column2.$rowCount2)->getNumberFormat()->setFormatCode('_(* #,##0.00_);_(* (#,##0.00);_(* "-"??_);_(@_)'); 
            //     }

            //     $excel->getActiveSheet()->getStyle($column2.$rowCount2)->getFont()->setBold(TRUE);
                
            //     $column2++;
            // }



            $filename = $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name." Loans -  (".$year.")";


            // Redirect output to a client’s web browser (Excel2007)
            ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename='."".$filename.".xlsx".'');
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

            break;

        }
    }
}
