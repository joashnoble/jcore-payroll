<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MonthlyLoan extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        // if($this->session->userdata('right_1601C_report_view') == 0 || $this->session->userdata('right_1601C_report_view') == null) {
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
        $data['title'] = 'Monthly Loan';

        $this->load->view('monthly_loan_view', $data);
    }


    function layout($transaction=null,$filter_value=null,$filter_value2=null,$filter_value3=null,$type=null){

        switch($transaction){

            case 'export_monthly_loan':

            $year = $filter_value;        
            $month_temp = $filter_value2;
            $loan_id = $filter_value3;

            $getloan = $this->RefDeductionSetup_model->get_list($loan_id);
            $loan_type = $getloan[0]->deduction_desc;
            
            $excel=$this->excel;

            $excel->setActiveSheetIndex(0);
            $transaction=$this->PayrollReports_model->get_monthly_loan($year,$month_temp,$loan_id);

            $month = "";

            if ($month_temp == 1){
                $month='January';
            }else if ($month_temp == 2){
                $month='February'; 
            }else if ($month_temp == 3){
                $month='March';
            }else if ($month_temp == 4){
                $month='April';
            }else if ($month_temp == 5){
                $month='May';
            }else if ($month_temp == 6){
                $month='June';
            }else if ($month_temp == 7){
                $month='July';
            }else if ($month_temp == 8){
                $month='August';
            }else if ($month_temp == 9){
                $month='September';
            }else if ($month_temp == 10){
                $month='October';
            }else if ($month_temp == 11){
                $month='November';
            }else if ($month_temp == 12){
                $month='December';
            }

            //name the worksheet
            // $excel->getActiveSheet()->setTitle("Monthly Worked Hours (".$month."-".$filter_value.")");
            $excel->getActiveSheet()->setTitle($month." ".$year);

            $excel->getActiveSheet()->getStyle('A1:A3')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->setCellValue('A1',"Monthly Loan")
                                    ->setCellValue('A2',$loan_type)
                                    ->setCellValue('A3',$month.' '.$year);

            $excel->getActiveSheet()->mergeCells('A1:D1');
            $excel->getActiveSheet()->mergeCells('A2:D2');
            $excel->getActiveSheet()->mergeCells('A3:D3');

            $excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth('10');
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth('15');


            $excel->getActiveSheet()
                ->getStyle('A5')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getActiveSheet()
                ->getStyle('B5')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getActiveSheet()
                ->getStyle('D5')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


            //create headers
            $excel->getActiveSheet()->getStyle('A5:D5')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->setCellValue('A5', '#')
                                    ->setCellValue('B5', 'Ecode')
                                    ->setCellValue('C5', 'Employee')
                                    ->setCellValue('D5', 'Deduction');

            $rows=array();
            $i=6;
            $a=1;
            $total_deduction = 0;

            if(count($transaction) > 0){
            foreach($transaction as $x){

                $total_deduction += $x->loan_deduction;
                $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                $excel->getActiveSheet()
                    ->getStyle('D'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                    ->getStyle('A'.$i.':'.'B'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $excel->getActiveSheet()->setCellValue('A'.$i,$a);
                $excel->getActiveSheet()->setCellValue('B'.$i,$x->ecode);
                $excel->getActiveSheet()->setCellValue('C'.$i,$x->fullname);
                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($x->loan_deduction,2));

                $i++; 
                $a++;

            }
            $excel->getActiveSheet()->mergeCells('A'.$i.':'.'C'.$i);
            $excel->getActiveSheet()->setCellValue('A'.$i,'Total');
            $excel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

            $excel->getActiveSheet()
                ->getStyle('A'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $excel->getActiveSheet()->setCellValue('D'.$i,number_format($total_deduction,2));
            $excel->getActiveSheet()
                ->getStyle('D'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            }else{
                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'D'.$i);
                $excel->getActiveSheet()->setCellValue('A'.$i,'No Result');
                $excel->getActiveSheet()
                    ->getStyle('A'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }


            $filename = "Monthly Loan (".$month.' - '.$year.")";


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
