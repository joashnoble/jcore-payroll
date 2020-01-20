<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MonthlyWorkedHours extends CORE_Controller
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
        $data['title'] = 'Monthly Worked Hours';

        $this->load->view('monthly_worked_hours_view', $data);
    }


    function layout($transaction=null,$filter_value=null,$filter_value2=null,$type=null){

        switch($transaction){

            case 'export_monthly_worked_hours':
            $excel=$this->excel;

            $excel->setActiveSheetIndex(0);
            $transaction=$this->PayrollReports_model->get_monthly_worked_hours($filter_value,$filter_value2);

            $month = "";

            if ($filter_value2 == 1){
                $month='January';
            }else if ($filter_value2 == 2){
                $month='February'; 
            }else if ($filter_value2 == 3){
                $month='March';
            }else if ($filter_value2 == 4){
                $month='April';
            }else if ($filter_value2 == 5){
                $month='May';
            }else if ($filter_value2 == 6){
                $month='June';
            }else if ($filter_value2 == 7){
                $month='July';
            }else if ($filter_value2 == 8){
                $month='August';
            }else if ($filter_value2 == 9){
                $month='September';
            }else if ($filter_value2 == 10){
                $month='October';
            }else if ($filter_value2 == 11){
                $month='November';
            }else if ($filter_value2 == 12){
                $month='December';
            }

            //name the worksheet
            // $excel->getActiveSheet()->setTitle("Monthly Worked Hours (".$month."-".$filter_value.")");
            $excel->getActiveSheet()->setTitle($month."-".$filter_value);

            $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->setCellValue('A1',"Monthly Worked Hours")
                ->setCellValue('A2',$month.' - '.$filter_value);

            $excel->getActiveSheet()->mergeCells('A3:M3');
            $excel->getActiveSheet()->mergeCells('A1:M1');
            $excel->getActiveSheet()->mergeCells('A2:M2');
            $excel->getActiveSheet()->mergeCells('I4:L4');

            $excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth('30');
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth('15');
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth('15');
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth('15');
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth('15');
            $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');
            $excel->getActiveSheet()->getColumnDimension('J')->setWidth('15');
            $excel->getActiveSheet()->getColumnDimension('K')->setWidth('20');
            $excel->getActiveSheet()->getColumnDimension('L')->setWidth('15');
            $excel->getActiveSheet()->getColumnDimension('M')->setWidth('15');

            $excel->getActiveSheet()
                ->getStyle('A3')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getActiveSheet()
                ->getStyle('C4')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getActiveSheet()
                ->getStyle('E4')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getActiveSheet()
                ->getStyle('G4')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getActiveSheet()
                ->getStyle('I4')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getActiveSheet()
                ->getStyle('M4')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $excel->getActiveSheet()
                ->getStyle('C5')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()
                ->getStyle('D5')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()
                ->getStyle('E5')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()
                ->getStyle('F5')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()
                ->getStyle('G5')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()
                ->getStyle('H5')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()
                ->getStyle('I5')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()
                ->getStyle('J5')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()
                ->getStyle('K5')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()
                ->getStyle('L5')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $excel->getActiveSheet()
                ->getStyle('M5')
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            //create headers
            $excel->getActiveSheet()->getStyle('A3:M5')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->setCellValue('A3', 'MONTHLY LABOR COST')
                                    ->setCellValue('C4', 'TOTAL')
                                    ->setCellValue('E4', 'TOTAL')
                                    ->setCellValue('G4', 'TOTAL')
                                    ->setCellValue('I4', 'HOLIDAY')
                                    ->setCellValue('M4', 'TOTAL')
                                    ->setCellValue('A5', '#')
                                    ->setCellValue('B5', 'EMPLOYEE')
                                    ->setCellValue('C5', 'REGULAR HOURS')
                                    ->setCellValue('D5', 'AMOUNT')
                                    ->setCellValue('E5', 'OVERTIME')
                                    ->setCellValue('F5', 'AMOUNT')
                                    ->setCellValue('G5', 'ND')
                                    ->setCellValue('H5', 'AMOUNT')
                                    ->setCellValue('I5', 'REGULAR HOLIDAY')
                                    ->setCellValue('J5', 'AMOUNT')
                                    ->setCellValue('K5', 'SPECIAL HOLIDAY')
                                    ->setCellValue('L5', 'AMOUNT')
                                    ->setCellValue('M5', 'COST');
            $rows=array();
            $i=6;
            $a=1;
            $total = 0;
            $total_cost = 0;
            if(count($transaction) > 0){
            foreach($transaction as $x){

                $total_cost = $x->total_reg_amt + $x->total_ot_amt + $x->total_nd_amt + $x->total_reg_hol_amt + $x->total_spe_hol_amt;
                $total += $x->total_reg_amt + $x->total_ot_amt + $x->total_nd_amt + $x->total_reg_hol_amt + $x->total_spe_hol_amt;

               
                $excel->getActiveSheet()->getStyle('C'.$i.':'.'M'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                $excel->getActiveSheet()
                    ->getStyle('C'.$i.':'.'M'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('A'.$i,$a);
                $excel->getActiveSheet()->setCellValue('B'.$i,$x->employee);
                $excel->getActiveSheet()->setCellValue('C'.$i,number_format($x->total_reg,2));
                $excel->getActiveSheet()->setCellValue('D'.$i,number_format($x->total_reg_amt,2));
                $excel->getActiveSheet()->setCellValue('E'.$i,number_format($x->total_ot,2));
                $excel->getActiveSheet()->setCellValue('F'.$i,number_format($x->total_ot_amt,2));                
                $excel->getActiveSheet()->setCellValue('G'.$i,number_format($x->total_nd,2));
                $excel->getActiveSheet()->setCellValue('H'.$i,number_format($x->total_nd_amt,2));
                $excel->getActiveSheet()->setCellValue('I'.$i,number_format($x->total_reg_hol,2));
                $excel->getActiveSheet()->setCellValue('J'.$i,number_format($x->total_reg_hol_amt,2));
                $excel->getActiveSheet()->setCellValue('K'.$i,number_format($x->total_spe_hol,2));
                $excel->getActiveSheet()->setCellValue('L'.$i,number_format($x->total_spe_hol_amt,2));
                $excel->getActiveSheet()->setCellValue('M'.$i,number_format($total_cost,2));

                $i++; 
                $a++;

            }}else{
                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'L'.$i);
                $excel->getActiveSheet()->setCellValue('A'.$i,'No Result');
                $excel->getActiveSheet()
                    ->getStyle('A'.$i)
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }

            $excel->getActiveSheet()->mergeCells('A'.$i.':'.'L'.$i);

            $filename = "Monthly Worked Hours (".$month.' - '.$filter_value.")";
            $excel->getActiveSheet()->setCellValue('A'.$i,'Total');
            $excel->getActiveSheet()
                ->getStyle('A'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $excel->getActiveSheet()->setCellValue('M'.$i,number_format($total,2));
            $excel->getActiveSheet()
                ->getStyle('M'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

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
