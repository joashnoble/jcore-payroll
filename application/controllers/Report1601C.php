<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report1601C extends CORE_Controller
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
        $data['title'] = '1601C Report';

        $this->load->view('1601C_report_view', $data);
    }


    function layout($transaction=null,$filter_value=null,$filter_value2=null,$type=null){

        switch($transaction){

            case 'export_1601C':
            $excel=$this->excel;

            $excel->setActiveSheetIndex(0);
            $transaction=$this->PayrollReports_model->get_1601C_list($filter_value,$filter_value2);

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
            $excel->getActiveSheet()->setTitle("1601C");

            $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->setCellValue('A1',"Schedule of taxes withheld (1601C)")
                ->setCellValue('A2',$month.' '.$filter_value);

            $excel->getActiveSheet()->mergeCells('A1:U1');
            $excel->getActiveSheet()->mergeCells('A2:U2');

            //create headers
            $excel->getActiveSheet()->getStyle('A4:T4')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->setCellValue('A4', '#')
                                    ->setCellValue('B4', 'ID No.')
                                    ->setCellValue('C4', 'Surname')
                                    ->setCellValue('D4', 'Given Name')
                                    ->setCellValue('E4', 'Middle Name')
                                    ->setCellValue('F4', 'TIN No.')
                                    ->setCellValue('G4', '+Holiday')
                                    ->setCellValue('H4', 'Actual Basic Pay')
                                    ->setCellValue('I4', '/day')
                                    ->setCellValue('J4', 'Gross Tax')
                                    ->setCellValue('K4', 'Gross Pay')
                                    ->setCellValue('L4', 'HDMFeR')
                                    ->setCellValue('M4', 'HDMFee')
                                    ->setCellValue('N4', 'SSSeR')
                                    ->setCellValue('O4', 'SSSeC')
                                    ->setCellValue('P4', 'SSSeE')
                                    ->setCellValue('Q4', 'PHICeR')
                                    ->setCellValue('R4', 'PHICeE')
                                    ->setCellValue('S4', 'Compensation')
                                    ->setCellValue('T4', 'Salary')
                                    ->setCellValue('U4', 'Withheld');
            $rows=array();
            $i=1;
            foreach($transaction as $x){

                $excel->getActiveSheet()->getStyle('G'.$i.':'.'U'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                $rows[]=array(
                    $i,
                    $x->id_number,
                    $x->last_name,
                    $x->first_name,
                    $x->middle_name,
                    $x->tin,
                    $x->holiday_pay,
                    $x->actual_basic_pay,
                    $x->per_day_pay,
                    $x->reg_pay,
                    $x->gross_pay,
                    $x->hdmf,
                    $x->hdmf,
                    $x->sss_employer,
                    $x->sss_employer_contribution,
                    $x->sss_employee,
                    $x->phic,
                    $x->phic,
                    ($x->sss_employee+$x->phic+$x->hdmf),
                    ($x->gross_pay-($x->sss_employee+$x->phic+$x->hdmf)),
                    $x->wtax
                );

                $i++;

            }

            $styleArray = array(
                'font'  => array(
                    'bold'  => true,
                    'color' => array('rgb' => 'FFFFF'),
                    'size'  => 10,
                    'name'  => 'Tahoma'
                ));

            $excel->getActiveSheet()->fromArray($rows,NULL,'A5');
            //autofit column
            foreach(range('A','U') as $columnID)
            {
                $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(TRUE);
            }

            $filename = "1601C ".$month.' '.$filter_value;

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
