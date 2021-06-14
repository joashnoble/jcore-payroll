<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PayrollHistory extends CORE_Controller
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
        $this->load->model('Payslip_OtherEarning_model');
        $this->load->model('PayrollReports_model');
        $this->load->model('RefPayPeriod_model');
        $this->load->model('RefYearSetup_model');
        $this->load->model('RefFactorFile_model');
        $this->load->model('Emp_13thmonth_model');
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
        $data['ref_branch']=$this->RefBranch_model->get_list(array('ref_branch.is_deleted'=>FALSE));
        $data['ref_department']=$this->RefDepartment_model->get_list(array('ref_department.is_deleted'=>FALSE));
        $data['title'] = 'Pay Slip';

        $this->load->view('pay_slip_view', $data);
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $pay_period_id = $this->input->post('pay_period_id', TRUE);
                $ref_department_id = $this->input->post('ref_department_id', TRUE);
                $ref_branch_id = $this->input->post('ref_branch_id', TRUE);
                $space=" ";
                $test="";
                if($ref_department_id=="all" AND $ref_branch_id=="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'employee_list.is_deleted'=>FALSE);
                }
                if($ref_department_id=="all" AND $ref_branch_id!="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'emp_rates_duties.ref_branch_id'=>$ref_branch_id,'employee_list.is_deleted'=>FALSE);

                }
                if($ref_department_id!="all" AND $ref_branch_id=="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'emp_rates_duties.ref_department_id'=>$ref_department_id,'employee_list.is_deleted'=>FALSE);

                }
                if($ref_department_id!="all" AND $ref_branch_id!="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'emp_rates_duties.ref_department_id'=>$ref_department_id,'emp_rates_duties.ref_branch_id'=>$ref_branch_id,'employee_list.is_deleted'=>FALSE);

                }
                $response['data']=$this->Payslip_model->get_list(
                    $test,
                    'pay_slip.net_pay,pay_slip.pay_slip_id,employee_list.*,CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name',
                    array(
                        array('daily_time_record','daily_time_record.dtr_id=pay_slip.dtr_id','left'),
                         array('employee_list','employee_list.employee_id=daily_time_record.employee_id','left'),
                         array('emp_rates_duties','emp_rates_duties.emp_rates_duties_id=employee_list.emp_rates_duties_id','left'),
                         )
                    );
                echo json_encode($response);

                break;
        }
    }


    function layout($layout=null,$filter_value=null,$filter_value2=null,$filter_value3=null,$type=null,$filter_value4=null){




        switch($layout){
            //****************************************************
            case 'employeee-payroll-history': //
                        //show only inside grid with menu button

                        $getpayrollregsummary=$this->PayrollReports_model->get_employee_history($filter_value,$filter_value2,$filter_value3);
                        // if($filter_value!="all" AND $filter_value2!="all"){
                        //     /*echo json_encode($getpayrollregsummary);*/
                        // }

                        // if($filter_value!="all" AND $filter_value2=="all"){
                        //     $getpayrollregsummary=$this->PayrollReports_model->get_employee_history_filter_employee($filter_value,$filter_value3);
                        // }
                        // if($filter_value=="all" AND $filter_value2=="all"){
                        //     $getpayrollregsummary=$this->PayrollReports_model->get_employee_history_wofilter($filter_value3);
                        // }

                        /*echo json_encode($getpayrollregsummary);*/
                        /*$getpayrollregsummary=$this->Payslip_model->get_list(
                        null,
                        'pay_slip.*,refpayperiod.pay_period_start,refpayperiod.pay_period_end',
                        array(
                             array('daily_time_record','daily_time_record.dtr_id=pay_slip.dtr_id','left'),
                             array('refpayperiod','refpayperiod.pay_period_id=daily_time_record.pay_period_id','left'),
                             )
                        );*/
                        /*//GET SALARY ADJUSTMENTS
                        $getadjustment=$this->Payslip_OtherEarning_model->get_list(
                        array('pay_slip_other_earnings.earnings_id'=>2),
                        'SUM(earnings_amount) as total_adjustment_amount'
                        );
                         //GET OTHER PAY/EARNING
                        $getotherpay=$this->Payslip_OtherEarning_model->get_list(
                        'pay_slip_other_earnings.earnings_id!=2',
                        'SUM(earnings_amount) as total_other_pay'
                        );
                         //TOTAL SSS DEDUCTION GET
                        $gettotalsssdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=1 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_sss_deduct'
                        );

                        //TOTAL PHILHEALTH GET
                        $gettotalphilhealthdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=2 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_philhealth_deduct'
                        );
                        //TOTAL PHILHEALTH GET
                        $gettotalpagibigdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=3 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_pagibig_deduct'
                        );

                        $gettotalwithholdingdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=4 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_withholdingtax_deduct'
                        );
                        //get total sss loan
                        $gettotalsssloandeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=5 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_sss_loan'
                        );
                        //get total pagibig loan
                        $gettotalpagibigloandeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=6 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_pagibig_loan'
                        );
                        //COOP LOAN DEDUCTION GET
                        $gettotalcooploandeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=8 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_coop_loan'
                        );
                        //COOP CONTRIBUTION DEDUCTION GET
                        $gettotalcoopcontributiondeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=9 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_coop_contribution'
                        );
                        //OTHER DEDUCTION GET
                        $gettotalotherdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id!=1  AND deduction_id!=2  AND deduction_id!=3  AND deduction_id!=4
                         AND deduction_id!=5  AND deduction_id!=6  AND deduction_id!=7  AND deduction_id!=8  AND deduction_id!=9 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_other_deduction'
                        );*/

                       /*echo json_encode($gettotalotherdeduction);*/

                        /*echo json_encode($getpayrollregsummary);*/
                        if($filter_value3!="all"){
                            $getbranch=$this->RefBranch_model->get_list(
                            $filter_value3,
                            'ref_branch.branch'
                            );
                            $get_branch = $getbranch[0]->branch;
                        }
                        else{
                            $get_branch = "All";
                        }

                        $data['payroll_register_summary']=$getpayrollregsummary;
                        $data['get_branch']=$get_branch;
                        $getcompany=$this->GeneralSettings_model->get_list(
                        null,
                        'company_setup.*'
                        );
                        $data['company']=$getcompany[0];

                        /*$data['total_adjustment_amount']=$getadjustment[0];
                        $data['total_other_pay']=$getotherpay[0];
                        $data['total_sss_deduct']=$gettotalsssdeduction[0];
                        $data['total_philhealth_deduct']=$gettotalphilhealthdeduction[0];
                        $data['total_pagibig_deduct']=$gettotalpagibigdeduction[0];
                        $data['total_withholdingtax_deduct']=$gettotalwithholdingdeduction[0];
                        $data['total_sss_loan']=$gettotalsssloandeduction[0];
                        $data['total_pagibig_loan']=$gettotalpagibigloandeduction[0];
                        $data['total_coop_loan']=$gettotalcooploandeduction[0];
                        $data['total_coop_contribution']=$gettotalcoopcontributiondeduction[0];
                        $data['total_other_deduction']=$gettotalotherdeduction[0];*/
                            echo $this->load->view('template/employee_payroll_history_html',$data,TRUE);

            break;

            case 'employeee-payroll-register':

                $department = $filter_value;
                $branch = $filter_value3;
                $pay_period = $filter_value2;
                $getpayrollregister=$this->PayrollReports_model->get_payroll_register($department,$branch,$pay_period,$type);

                if($branch!="All"){
                    $getbranch=$this->RefBranch_model->get_list(
                    $branch,
                    'ref_branch.branch'
                    );
                    $get_branch = $getbranch[0]->branch;
                }
                else{
                    $get_branch = "All";
                }

                if($department !="All"){
                    $getdepartment=$this->RefDepartment_model->get_list(
                    $department,
                    'ref_department.department'
                    );
                    $get_department = $getdepartment[0]->department;
                }
                else{
                    $get_department = "All";
                }

                $m_period = $this->RefPayPeriod_model;

                $payperiod = $m_period->getpayperioddesc($pay_period);

                $data['payroll_register']=$getpayrollregister;
                $data['get_branch']=$get_branch;
                $data['get_department']=$get_department;
                $data['pay_period']=$payperiod[0];

                $getcompany=$this->GeneralSettings_model->get_list(
                null,
                'company_setup.*'
                );
                $data['company']=$getcompany[0];

                if ($type != "cash"){
                    echo $this->load->view('template/payroll_register_html',$data,TRUE);
                }else{
                    echo $this->load->view('template/payroll_register_cash_html',$data,TRUE);
                }


            break;

            case 'export-employeee-payroll-register':
                $excel = $this->excel;
                $department = $filter_value;
                $branch = $filter_value3;
                $pay_period = $filter_value2;
                $getpayrollregister=$this->PayrollReports_model->get_payroll_register($department,$branch,$pay_period,$type);

                if($branch!="All"){
                    $getbranch=$this->RefBranch_model->get_list(
                    $branch,
                    'ref_branch.branch'
                    );
                    $get_branch = $getbranch[0]->branch;
                }
                else{
                    $get_branch = "All";
                }

                if($department !="All"){
                    $getdepartment=$this->RefDepartment_model->get_list(
                    $department,
                    'ref_department.department'
                    );
                    $get_department = $getdepartment[0]->department;
                }
                else{
                    $get_department = "All";
                }

                $m_period = $this->RefPayPeriod_model;

                $payperiod = $m_period->getpayperioddesc($pay_period);

                $pay_period=$payperiod[0]->pay_period;

                $getcompany=$this->GeneralSettings_model->get_list(
                null,
                'company_setup.*'
                );
                $company=$getcompany[0];

                $excel->setActiveSheetIndex(0);
                        //name the worksheet

                        $end = "";

                        if ($type == "non-cash"){
                            $excel->getActiveSheet()->setTitle("PAYROLL REGISTER REPORT");
                            $end = "C";
                        }else{
                            $excel->getActiveSheet()->setTitle("PAYROLL REGISTER CASH REPORT");
                            $end = "B";
                        }
    
                        $excel->getActiveSheet()->mergeCells('A1:'.$end.'1');
                        $excel->getActiveSheet()->mergeCells('A2:'.$end.'2');
                        $excel->getActiveSheet()->mergeCells('A3:'.$end.'3');
                        $excel->getActiveSheet()->mergeCells('A4:'.$end.'4');

                        $excel->getActiveSheet()->setCellValue('A1',$company->company_name)
                                                ->setCellValue('A2',$company->address)
                                                ->setCellValue('A3',$company->contact_no)
                                                ->setCellValue('A4',$company->email_address);

                        $excel->getActiveSheet()->mergeCells('A5:'.$end.'5');

                        $excel->getActiveSheet()->getStyle('A6'.':'.'A8')->getFont()->setBold(TRUE);

                        $excel->getActiveSheet()->mergeCells('A6:'.$end.'6');
                        $excel->getActiveSheet()->mergeCells('A7:'.$end.'7');
                        $excel->getActiveSheet()->mergeCells('A8:'.$end.'8');

                        $excel->getActiveSheet()->setCellValue('A6','Pay Period : '.$pay_period)
                                                ->setCellValue('A7','Branch : '.$get_branch)
                                                ->setCellValue('A8','Department : '.$get_department);
                        $excel->getActiveSheet()->mergeCells('A9:'.$end.'9');

                        $excel->getActiveSheet()->getStyle('A10:'.$end.'10')->getFont()->setBold(TRUE);

                        

                        if ($type == "non-cash"){
                            $excel->getActiveSheet()->getColumnDimension('A')->setWidth('35');
                            $excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
                            $excel->getActiveSheet()->getColumnDimension('C')->setWidth('15');
                        }else{
                            $excel->getActiveSheet()->getColumnDimension('A')->setWidth('35');
                            $excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
                        }
                        
                        $excel->getActiveSheet()
                                ->getStyle($end.'10')
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        if ($type == "non-cash"){
                            $excel->getActiveSheet()->setCellValue('A10','Employee');
                            $excel->getActiveSheet()->setCellValue('B10','Account #');
                            $excel->getActiveSheet()->setCellValue('C10','Net Pay');
                        }else{
                            $excel->getActiveSheet()->setCellValue('A10','Employee');
                            $excel->getActiveSheet()->setCellValue('B10','Net Pay');
                        }

                        $i = 11;
                        $grandtotal=0;

                        if(count($getpayrollregister)!=0 || count($getpayrollregister)!=null){

                            foreach($getpayrollregister as $row){

                                $net_pay = $netpay=$row->gross_pay-($row->days_wout_pay_amt+$row->minutes_late_amt+$row->minutes_undertime_amt+$row->sss_deduction+$row->philhealth_deduction+$row->pagibig_deduction+$row->wtax_deduction+$row->sssloan_deduction+$row->pagibigloan_deduction+$row->coopcontribution_deduction+$row->cooploan_deduction+$row->cashadvance_deduction+$row->calamityloan_deduction+$row->other_deductions);

                                $grandtotal+=$net_pay;

                                $excel->getActiveSheet()
                                        ->getStyle($end.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                                $excel->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                                
                                $excel->getActiveSheet()->getStyle($end.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                                if ($type == "non-cash"){
                                    $excel->getActiveSheet()->setCellValue('A'.$i,$row->fullname);
                                    $excel->getActiveSheet()->setCellValue('B'.$i,$row->bank_account);
                                    $excel->getActiveSheet()->setCellValue('C'.$i,number_format($row->net_pay,2));
                                }else{
                                    $excel->getActiveSheet()->setCellValue('A'.$i,$row->fullname);
                                    $excel->getActiveSheet()->setCellValue('B'.$i,number_format($row->net_pay,2));
                                }
                                    $i++;
                            }}
                            else{ 

                                    $excel->getActiveSheet()
                                            ->getStyle('A'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                                    $excel->getActiveSheet()->mergeCells('A'.$i.':'.$end.$i);
                                    $excel->getActiveSheet()->setCellValue('A'.$i,'No Result');
                                    $i++;
                            }

                            $i++;

                                $excel->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


                                $excel->getActiveSheet()
                                        ->getStyle($end.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


                                if ($type == "non-cash"){
                                    $excel->getActiveSheet()->mergeCells('A'.$i.':B'.$i);
                                    $excel->getActiveSheet()->getStyle('A'.$i.':'.$end.$i)->getFont()->setBold(TRUE);
                                }else{
                                    $excel->getActiveSheet()->getStyle('A'.$i.':'.$end.$i)->getFont()->setBold(TRUE);
                                }

                                $excel->getActiveSheet()->setCellValue('A'.$i,'Total: ');
                                $excel->getActiveSheet()->getStyle($end.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                   
                                $excel->getActiveSheet()->setCellValue($end.$i,number_format($grandtotal,2));

                                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

                                $filename="";

                                if ($type == "non-cash"){
                                    $filename = "Payroll Register with Account (".$pay_period.")";
                                }else{
                                    $filename = "Payroll Register Cash (".$pay_period.")";
                                }

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

            case 'employeee-monthly-salary': //

                        $filter2 = explode('~',$filter_value2);
                        $filter_value2 = $filter2[0];
                        $filter_year = $filter2[1];
                        //show only inside grid with menu button
                           
                        $getpayrollregsummary=$this->PayrollReports_model->get_monthly_salary_history($filter_value,$filter_value2,$filter_value3,$filter_year);

                        // if($filter_value!="all" AND $filter_value2!="all"){

                        //     /*echo json_encode($getpayrollregsummary);*/
                        // }



                        // if($filter_value!="all" AND $filter_value2=="all"){
                        //   echo 3;
                        //     $getpayrollregsummary=$this->PayrollReports_model->get_monthly_salary_filter_employee($filter_value,$filter_value3,$filter_year);
                        // }
                        // if($filter_value=="all" AND $filter_value2=="all"){
                        //   echo 4;
                        //     $getpayrollregsummary=$this->PayrollReports_model->get_monthly_salary_wofilter($filter_value3,$filter_year);
                        // }

                        /*echo json_encode($getpayrollregsummary);*/
                        /*$getpayrollregsummary=$this->Payslip_model->get_list(
                        null,
                        'pay_slip.*,refpayperiod.pay_period_start,refpayperiod.pay_period_end',
                        array(
                             array('daily_time_record','daily_time_record.dtr_id=pay_slip.dtr_id','left'),
                             array('refpayperiod','refpayperiod.pay_period_id=daily_time_record.pay_period_id','left'),
                             )
                        );*/
                        /*//GET SALARY ADJUSTMENTS
                        $getadjustment=$this->Payslip_OtherEarning_model->get_list(
                        array('pay_slip_other_earnings.earnings_id'=>2),
                        'SUM(earnings_amount) as total_adjustment_amount'
                        );
                         //GET OTHER PAY/EARNING
                        $getotherpay=$this->Payslip_OtherEarning_model->get_list(
                        'pay_slip_other_earnings.earnings_id!=2',
                        'SUM(earnings_amount) as total_other_pay'
                        );
                         //TOTAL SSS DEDUCTION GET
                        $gettotalsssdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=1 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_sss_deduct'
                        );

                        //TOTAL PHILHEALTH GET
                        $gettotalphilhealthdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=2 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_philhealth_deduct'
                        );
                        //TOTAL PHILHEALTH GET
                        $gettotalpagibigdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=3 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_pagibig_deduct'
                        );

                        $gettotalwithholdingdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=4 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_withholdingtax_deduct'
                        );
                        //get total sss loan
                        $gettotalsssloandeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=5 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_sss_loan'
                        );
                        //get total pagibig loan
                        $gettotalpagibigloandeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=6 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_pagibig_loan'
                        );
                        //COOP LOAN DEDUCTION GET
                        $gettotalcooploandeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=8 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_coop_loan'
                        );
                        //COOP CONTRIBUTION DEDUCTION GET
                        $gettotalcoopcontributiondeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=9 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_coop_contribution'
                        );
                        //OTHER DEDUCTION GET
                        $gettotalotherdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id!=1  AND deduction_id!=2  AND deduction_id!=3  AND deduction_id!=4
                         AND deduction_id!=5  AND deduction_id!=6  AND deduction_id!=7  AND deduction_id!=8  AND deduction_id!=9 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_other_deduction'
                        );*/

                       /*echo json_encode($gettotalotherdeduction);*/

                        /*echo json_encode($getpayrollregsummary);*/
                        if($filter_value3!="all"){
                            $getbranch=$this->RefBranch_model->get_list(
                            $filter_value3,
                            'ref_branch.branch'
                            );
                            $get_branch = $getbranch[0]->branch;
                        }
                        else{
                            $get_branch = "All";
                        }

                        $data['payroll_register_summary']=$getpayrollregsummary;
                        $data['get_branch']=$get_branch;
                        $data['month']=$filter_value2;
                        $getcompany=$this->GeneralSettings_model->get_list(
                        null,
                        'company_setup.*'
                        );
                        $data['company']=$getcompany[0];



                        /*$data['total_adjustment_amount']=$getadjustment[0];
                        $data['total_other_pay']=$getotherpay[0];
                        $data['total_sss_deduct']=$gettotalsssdeduction[0];
                        $data['total_philhealth_deduct']=$gettotalphilhealthdeduction[0];
                        $data['total_pagibig_deduct']=$gettotalpagibigdeduction[0];
                        $data['total_withholdingtax_deduct']=$gettotalwithholdingdeduction[0];
                        $data['total_sss_loan']=$gettotalsssloandeduction[0];
                        $data['total_pagibig_loan']=$gettotalpagibigloandeduction[0];
                        $data['total_coop_loan']=$gettotalcooploandeduction[0];
                        $data['total_coop_contribution']=$gettotalcoopcontributiondeduction[0];
                        $data['total_other_deduction']=$gettotalotherdeduction[0];*/
                            echo $this->load->view('template/employee_monthly_salary_html',$data,TRUE);

                        break;


            case 'employee_payroll_summary': //

                    $ref_department_id = $filter_value;
                    $pay_period_id = $filter_value2;

                    $data['payroll']=$this->PayrollReports_model->get_payroll_summary($pay_period_id,$ref_department_id);
                    $data['period']=$this->RefPayPeriod_model->getperiod($pay_period_id);

                    $data['transactions']=$this->RefPayPeriod_model->get_payroll_transaction($pay_period_id,$ref_department_id);
                    $data['departments'] = $this->RefDepartment_model->get_department_payslip($pay_period_id,$ref_department_id);


                    $data['company']=$this->GeneralSettings_model->get_list()[0];
                    $data['factor']=$this->RefFactorFile_model->get_list()[0];

                    echo $this->load->view('template/employee_payroll_summary_html',$data,TRUE);
                    break;

    case 'export_employee_payroll_summary_detailed':

            $ref_department_id = $filter_value;
            $pay_period_id = $filter_value2;

            $payroll=$this->PayrollReports_model->get_payroll_summary($pay_period_id,$ref_department_id);
            $period=$this->RefPayPeriod_model->getperiod($pay_period_id);
            $transactions=$this->RefPayPeriod_model->get_payroll_transaction($pay_period_id,$ref_department_id);
            $departments = $this->RefDepartment_model->get_department_payslip($pay_period_id,$ref_department_id);
            $company=$this->GeneralSettings_model->get_list()[0];
            $factor=$this->RefFactorFile_model->get_list()[0];

            if($filter_value!=="all"){
                $getdepartment=$this->RefDepartment_model->get_list(
                $filter_value,
                'ref_department.department'
                );
                $get_department = $getdepartment[0]->department;
            }
            else{
                $get_department = "All";
            }

            if($filter_value2!=0){
                $period=$this->RefPayPeriod_model->getperiod($filter_value2);
                $get_period = $period[0]->period;
            }
            else{
                $get_period = "";
            }

            $excel = $this->excel;
            $excel->setActiveSheetIndex(0);
            $excel->getActiveSheet()->setTitle("PAYROLL SUMMARY");

            $excel->getActiveSheet()->mergeCells('A1:O1');
            $excel->getActiveSheet()->mergeCells('A2:O2');
            $excel->getActiveSheet()->mergeCells('A3:O3');
            $excel->getActiveSheet()->mergeCells('A4:O4');

            $excel->getActiveSheet()->setCellValue('A1',$company->company_name)
                                    ->setCellValue('A2',$company->address)
                                    ->setCellValue('A3',$company->contact_no)
                                    ->setCellValue('A4',$company->email_address);

            $excel->getActiveSheet()->mergeCells('A5:O5');

            $excel->getActiveSheet()->getStyle('A6'.':'.'O7')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->mergeCells('A6:O6');
            $excel->getActiveSheet()->mergeCells('A7:O7');

            $excel->getActiveSheet()->setCellValue('A6','Pay Period : '.$get_period)
                                    ->setCellValue('A7','Department : '.$get_department);

            $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
            $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');
            $excel->getActiveSheet()->getColumnDimension('J')->setWidth('20');
            $excel->getActiveSheet()->getColumnDimension('K')->setWidth('15');
            $excel->getActiveSheet()->getColumnDimension('L')->setWidth('15');
            $excel->getActiveSheet()->getColumnDimension('M')->setWidth('15');
            $excel->getActiveSheet()->getColumnDimension('N')->setWidth('15');
            $excel->getActiveSheet()->getColumnDimension('O')->setWidth('15');

            $excel->getActiveSheet()->getStyle('A9:O9')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->getStyle('A10:O10')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->getStyle('A11:O11')->getFont()->setBold(TRUE);

            $excel->getActiveSheet()
                    ->getStyle('B9:O9')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $excel->getActiveSheet()
                    ->getStyle('B10:O10')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $excel->getActiveSheet()
                    ->getStyle('A11')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $excel->getActiveSheet()
                    ->getStyle('B11:O11')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);                                                       

            $excel->getActiveSheet()->setCellValue('A9','');
            $excel->getActiveSheet()->setCellValue('B9','Basic Pay');
            $excel->getActiveSheet()->setCellValue('C9','Legal Hol ('.number_format($factor->regular_holiday,2).')');
            $excel->getActiveSheet()->setCellValue('D9','Spcl Hol ('.number_format($factor->spe_holiday,2).')');
            $excel->getActiveSheet()->setCellValue('E9','Reg Hol OT ('.number_format($factor->regular_holiday_ot,2).')');
            $excel->getActiveSheet()->setCellValue('F9','Days w/ Pay');
            $excel->getActiveSheet()->setCellValue('G9','Absences');
            $excel->getActiveSheet()->setCellValue('H9','Grosspay');
            $excel->getActiveSheet()->setCellValue('I9','SSS Prem');
            $excel->getActiveSheet()->setCellValue('J9','EE (MPF)');
            $excel->getActiveSheet()->setCellValue('K9','SSS Loan');
            $excel->getActiveSheet()->setCellValue('L9','COOP Loan');
            $excel->getActiveSheet()->setCellValue('M9','COOP Contribution');
            $excel->getActiveSheet()->setCellValue('N9','Total Deduction');
            $excel->getActiveSheet()->setCellValue('O9','NetPay');

            $excel->getActiveSheet()->setCellValue('A10','');
            $excel->getActiveSheet()->setCellValue('B10','Basic Allowance');
            $excel->getActiveSheet()->setCellValue('C10','Night Diff ('.number_format($factor->night_shift,2).')');
            $excel->getActiveSheet()->setCellValue('D10','Rest Day ('.number_format($factor->day_off,2).')');
            $excel->getActiveSheet()->setCellValue('E10','Spcl Hol OT ('.number_format($factor->spe_holiday_ot,2).')');
            $excel->getActiveSheet()->setCellValue('F10','Other Earnings');
            $excel->getActiveSheet()->setCellValue('G10','Excess Break');
            $excel->getActiveSheet()->setCellValue('H10','');
            $excel->getActiveSheet()->setCellValue('I10','Philhealth');
            $excel->getActiveSheet()->setCellValue('J10','');
            $excel->getActiveSheet()->setCellValue('K10','Pagibig Loan');
            $excel->getActiveSheet()->setCellValue('L10','Calamity Loan');
            $excel->getActiveSheet()->setCellValue('M10','Advances');
            $excel->getActiveSheet()->setCellValue('N10','');
            $excel->getActiveSheet()->setCellValue('O10','');

            $excel->getActiveSheet()->setCellValue('A11','Name');
            $excel->getActiveSheet()->setCellValue('B11','');
            $excel->getActiveSheet()->setCellValue('C11','Sun Pay ('.number_format($factor->sunday,2).')');
            $excel->getActiveSheet()->setCellValue('D11','Reg OT ('.number_format($factor->regular_ot,2).')');
            $excel->getActiveSheet()->setCellValue('E11','Adjustment');
            $excel->getActiveSheet()->setCellValue('F11','Tardiness');
            $excel->getActiveSheet()->setCellValue('G11','Undertime');
            $excel->getActiveSheet()->setCellValue('H11','');
            $excel->getActiveSheet()->setCellValue('I11','Pagibig');
            $excel->getActiveSheet()->setCellValue('J11','');
            $excel->getActiveSheet()->setCellValue('K11','WTAX');
            $excel->getActiveSheet()->setCellValue('L11','HDMF Loan');
            $excel->getActiveSheet()->setCellValue('M11','Other Deduct');
            $excel->getActiveSheet()->setCellValue('N11','');
            $excel->getActiveSheet()->setCellValue('O11','');

            $i = 12;
            $count=1;
            $grand_reg_pay=0;
            $grand_reg_hol_pay=0;
            $grand_spe_hol_pay=0;
            $grand_ot_reg_hol_amt=0;
            $grand_days_with_pay_amt=0;
            $grand_days_wout_pay_amt=0;
            $grand_gross_pay=0;
            $grand_sss_deduction=0;
            $grand_sss_ee_mpf=0;
            $grand_sssloan_deduction=0;
            $grand_cooploan_deduction=0;
            $grand_coopcontribution_deduction=0;
            $grand_total_deductions=0;
            $grand_net_pay=0;
            $grand_allowance=0;
            $grand_nsd_pay=0;
            $grand_day_off_pay=0;
            $grand_ot_spe_hol_amt=0;
            $grand_other_earnings=0;
            $grand_minutes_excess_break_amt=0;
            $grand_philhealth_deduction=0;
            $grand_pagibigloan_deduction=0;
            $grand_calamityloan_deduction=0;
            $grand_cashadvance_deduction=0;
            $grand_sun_pay=0;
            $grand_ot_reg_amt=0;
            $grand_adjustment=0;
            $grand_minutes_late_amt=0;
            $grand_minutes_undertime_amt=0;
            $grand_pagibig_deduction=0;
            $grand_wtax_deduction=0;
            $grand_hdmfloan_deduction=0;
            $grand_other_deductions=0;

            foreach($transactions as $transaction){
                if ($transaction->count > 0){
                    $excel->getActiveSheet()->mergeCells('A'.$i.':O'.$i);
                    $excel->getActiveSheet()
                            ->getStyle('A'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'd3d3d3')
                            )
                        )
                    );

                    $excel->getActiveSheet()->setCellValue('A'.$i,$transaction->transaction_type);
                    $i++;

                    $sub_reg_pay=0;
                    $sub_reg_hol_pay=0;
                    $sub_spe_hol_pay=0;
                    $sub_ot_reg_hol_amt=0;
                    $sub_days_with_pay_amt=0;
                    $sub_days_wout_pay_amt=0;
                    $sub_gross_pay=0;
                    $sub_sss_deduction=0;
                    $sub_sss_ee_mpf=0;
                    $sub_sssloan_deduction=0;
                    $sub_cooploan_deduction=0;
                    $sub_coopcontribution_deduction=0;
                    $sub_total_deductions=0;
                    $sub_net_pay=0;
                    $sub_allowance=0;
                    $sub_nsd_pay=0;
                    $sub_day_off_pay=0;
                    $sub_ot_spe_hol_amt=0;
                    $sub_other_earnings=0;
                    $sub_minutes_excess_break_amt=0;
                    $sub_philhealth_deduction=0;
                    $sub_pagibigloan_deduction=0;
                    $sub_calamityloan_deduction=0;
                    $sub_cashadvance_deduction=0;
                    $sub_sun_pay=0;
                    $sub_ot_reg_amt=0;
                    $sub_adjustment=0;
                    $sub_minutes_late_amt=0;
                    $sub_minutes_undertime_amt=0;
                    $sub_pagibig_deduction=0;
                    $sub_wtax_deduction=0;
                    $sub_hdmfloan_deduction=0;
                    $sub_other_deductions=0;

                    foreach($departments as $department){
                        if ($department->type == $transaction->type){

                        $excel->getActiveSheet()->mergeCells('A'.$i.':O'.$i);
                        $excel->getActiveSheet()
                                ->getStyle('A'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);
                        $excel->getActiveSheet()->setCellValue('A'.$i,$department->department);
                        $i++;

                        $reg_pay=0;
                        $reg_hol_pay=0;
                        $spe_hol_pay=0;
                        $ot_reg_hol_amt=0;
                        $days_with_pay_amt=0;
                        $days_wout_pay_amt=0;
                        $gross_pay=0;
                        $sss_deduction=0;
                        $sss_ee_mpf=0;
                        $sssloan_deduction=0;
                        $cooploan_deduction=0;
                        $coopcontribution_deduction=0;
                        $total_deductions=0;
                        $net_pay=0;
                        $allowance=0;
                        $nsd_pay=0;
                        $day_off_pay=0;
                        $ot_spe_hol_amt=0;
                        $other_earnings=0;
                        $minutes_excess_break_amt=0;
                        $philhealth_deduction=0;
                        $pagibigloan_deduction=0;
                        $calamityloan_deduction=0;
                        $cashadvance_deduction=0;
                        $sun_pay=0;
                        $ot_reg_amt=0;
                        $adjustment=0;
                        $minutes_late_amt=0;
                        $minutes_undertime_amt=0;
                        $pagibig_deduction=0;
                        $wtax_deduction=0;
                        $hdmfloan_deduction=0;
                        $other_deductions=0;

                        foreach($payroll as $row){

                            if(($row->ref_department_id == $department->ref_department_id) AND ($row->bank_account_isprocess == $transaction->type)){

                                $reg_pay += $row->reg_pay;
                                $reg_hol_pay += $row->reg_hol_pay;
                                $spe_hol_pay += $row->spe_hol_pay;
                                $ot_reg_hol_amt += $row->ot_reg_reg_hol_amt+$row->ot_sun_reg_hol_amt;
                                $days_with_pay_amt += $row->days_with_pay_amt;
                                $days_wout_pay_amt += $row->days_wout_pay_amt;
                                $gross_pay += $row->gross_pay;
                                $sss_deduction += $row->sss_deduction;
                                $sss_ee_mpf += $row->sss_ee_mpf;
                                $sssloan_deduction += $row->sssloan_deduction;
                                $cooploan_deduction += $row->cooploan_deduction;
                                $coopcontribution_deduction += $row->coopcontribution_deduction;
                                $total_deductions += $row->total_deductions;
                                $net_pay += $row->net_pay;  
                                $allowance += $row->allowance;
                                $nsd_pay += $row->reg_nsd_pay+$row->sun_nsd_pay;
                                $day_off_pay += $row->day_off_pay;
                                $ot_spe_hol_amt += $row->ot_reg_spe_hol_amt+$row->ot_sun_spe_hol_amt;
                                $other_earnings += $row->other_earnings;
                                $minutes_excess_break_amt += $row->minutes_excess_break_amt;
                                $philhealth_deduction += $row->philhealth_deduction;
                                $pagibigloan_deduction += $row->pagibigloan_deduction;
                                $calamityloan_deduction += $row->calamityloan_deduction;
                                $cashadvance_deduction += $row->cashadvance_deduction;
                                $sun_pay += $row->sun_pay;
                                $ot_reg_amt += $row->ot_reg_amt+$row->ot_sun_amt;
                                $adjustment += $row->adjustment;
                                $minutes_late_amt += $row->minutes_late_amt;
                                $minutes_undertime_amt += $row->minutes_undertime_amt;
                                $pagibig_deduction += $row->pagibig_deduction;
                                $wtax_deduction += $row->wtax_deduction;
                                $hdmfloan_deduction += $row->hdmfloan_deduction;
                                $other_deductions += $row->other_deductions;

                                $excel->getActiveSheet()->getStyle('B'.$i.':O'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                                $excel->getActiveSheet()->setCellValue('A'.$i,$count.' '.$row->fullname);
                                $excel->getActiveSheet()->setCellValue('B'.$i,$row->reg_pay);
                                $excel->getActiveSheet()->setCellValue('C'.$i,$row->reg_hol_pay);
                                $excel->getActiveSheet()->setCellValue('D'.$i,$row->spe_hol_pay);
                                $excel->getActiveSheet()->setCellValue('E'.$i,$row->ot_reg_reg_hol_amt+$row->ot_sun_reg_hol_amt);
                                $excel->getActiveSheet()->setCellValue('F'.$i,$row->days_with_pay_amt);
                                $excel->getActiveSheet()->setCellValue('G'.$i,$row->days_wout_pay_amt);
                                $excel->getActiveSheet()->setCellValue('H'.$i,$row->gross_pay);
                                $excel->getActiveSheet()->setCellValue('I'.$i,$row->sss_deduction);
                                $excel->getActiveSheet()->setCellValue('J'.$i,$row->sss_ee_mpf);
                                $excel->getActiveSheet()->setCellValue('K'.$i,$row->sssloan_deduction);
                                $excel->getActiveSheet()->setCellValue('L'.$i,$row->cooploan_deduction);
                                $excel->getActiveSheet()->setCellValue('M'.$i,$row->coopcontribution_deduction);
                                $excel->getActiveSheet()->setCellValue('N'.$i,$row->total_deductions);
                                $excel->getActiveSheet()->setCellValue('O'.$i,$row->net_pay);

                                $i++;

                                $excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                                $excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                                $excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                                $excel->getActiveSheet()->getStyle('K'.$i.':M'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

                                $excel->getActiveSheet()->setCellValue('A'.$i,'');
                                $excel->getActiveSheet()->setCellValue('B'.$i,$row->allowance);
                                $excel->getActiveSheet()->setCellValue('C'.$i,$row->reg_nsd_pay+$row->sun_nsd_pay);
                                $excel->getActiveSheet()->setCellValue('D'.$i,$row->day_off_pay);
                                $excel->getActiveSheet()->setCellValue('E'.$i,$row->ot_reg_spe_hol_amt+$row->ot_sun_spe_hol_amt);
                                $excel->getActiveSheet()->setCellValue('F'.$i,$row->other_earnings);
                                $excel->getActiveSheet()->setCellValue('G'.$i,$row->minutes_excess_break_amt);
                                $excel->getActiveSheet()->setCellValue('H'.$i,'');
                                $excel->getActiveSheet()->setCellValue('I'.$i,$row->philhealth_deduction);
                                $excel->getActiveSheet()->setCellValue('J'.$i,'');
                                $excel->getActiveSheet()->setCellValue('K'.$i,$row->pagibigloan_deduction);
                                $excel->getActiveSheet()->setCellValue('L'.$i,$row->calamityloan_deduction);
                                $excel->getActiveSheet()->setCellValue('M'.$i,$row->cashadvance_deduction);
                                $excel->getActiveSheet()->setCellValue('N'.$i,'');
                                $excel->getActiveSheet()->setCellValue('O'.$i,'');

                                $i++;

                                $excel->getActiveSheet()->getStyle('C'.$i.':G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                                $excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                                $excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                                $excel->getActiveSheet()->getStyle('K'.$i.':M'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

                                $excel->getActiveSheet()->setCellValue('A'.$i,'');
                                $excel->getActiveSheet()->setCellValue('B'.$i,'');
                                $excel->getActiveSheet()->setCellValue('C'.$i,$row->sun_pay);
                                $excel->getActiveSheet()->setCellValue('D'.$i,$row->ot_reg_amt+$row->ot_sun_amt);
                                $excel->getActiveSheet()->setCellValue('E'.$i,$row->adjustment);
                                $excel->getActiveSheet()->setCellValue('F'.$i,$row->minutes_late_amt);
                                $excel->getActiveSheet()->setCellValue('G'.$i,$row->minutes_undertime_amt);
                                $excel->getActiveSheet()->setCellValue('H'.$i,'');
                                $excel->getActiveSheet()->setCellValue('I'.$i,$row->pagibig_deduction);
                                $excel->getActiveSheet()->setCellValue('J'.$i,'');
                                $excel->getActiveSheet()->setCellValue('K'.$i,$row->wtax_deduction);
                                $excel->getActiveSheet()->setCellValue('L'.$i,$row->hdmfloan_deduction);
                                $excel->getActiveSheet()->setCellValue('M'.$i,$row->other_deductions);
                                $excel->getActiveSheet()->setCellValue('N'.$i,'');
                                $excel->getActiveSheet()->setCellValue('O'.$i,'');
                                $i++; $count++;
                            }
                        }

                        $sub_reg_pay += $reg_pay;
                        $sub_reg_hol_pay += $reg_hol_pay;
                        $sub_spe_hol_pay += $spe_hol_pay;
                        $sub_ot_reg_hol_amt += $ot_reg_hol_amt;
                        $sub_days_with_pay_amt += $days_with_pay_amt;
                        $sub_days_wout_pay_amt += $days_wout_pay_amt;
                        $sub_gross_pay += $gross_pay;
                        $sub_sss_deduction += $sss_deduction;
                        $sub_sss_ee_mpf += $sss_ee_mpf;
                        $sub_sssloan_deduction += $sssloan_deduction;
                        $sub_cooploan_deduction += $cooploan_deduction;
                        $sub_coopcontribution_deduction += $coopcontribution_deduction;
                        $sub_total_deductions += $total_deductions;
                        $sub_net_pay += $net_pay;
                        $sub_allowance += $allowance;
                        $sub_nsd_pay += $nsd_pay;
                        $sub_day_off_pay += $day_off_pay;
                        $sub_ot_spe_hol_amt += $ot_spe_hol_amt;
                        $sub_other_earnings += $other_earnings;
                        $sub_minutes_excess_break_amt += $minutes_excess_break_amt;
                        $sub_philhealth_deduction += $philhealth_deduction;
                        $sub_pagibigloan_deduction += $pagibigloan_deduction;
                        $sub_calamityloan_deduction += $calamityloan_deduction;
                        $sub_cashadvance_deduction += $cashadvance_deduction;
                        $sub_sun_pay += $sun_pay;
                        $sub_ot_reg_amt += $ot_reg_amt;
                        $sub_adjustment += $adjustment;
                        $sub_minutes_late_amt += $minutes_late_amt;
                        $sub_minutes_undertime_amt += $minutes_undertime_amt;
                        $sub_pagibig_deduction += $pagibig_deduction;
                        $sub_wtax_deduction += $wtax_deduction;
                        $sub_hdmfloan_deduction += $hdmfloan_deduction;
                        $sub_other_deductions += $other_deductions;

                        $excel->getActiveSheet()->getStyle('B'.$i.':O'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                        $border_top_thin = array(
                          'borders' => array(
                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
                          ),
                        );
                        $excel->getActiveSheet()->getStyle('B'.$i.':O'.$i)->applyFromArray($border_top_thin);

                        $excel->getActiveSheet()->setCellValue('A'.$i,'DEPT TOTAL');
                        $excel->getActiveSheet()->setCellValue('B'.$i,$reg_pay);
                        $excel->getActiveSheet()->setCellValue('C'.$i,$reg_hol_pay);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$spe_hol_pay);
                        $excel->getActiveSheet()->setCellValue('E'.$i,$ot_reg_hol_amt);
                        $excel->getActiveSheet()->setCellValue('F'.$i,$days_with_pay_amt);
                        $excel->getActiveSheet()->setCellValue('G'.$i,$days_wout_pay_amt);
                        $excel->getActiveSheet()->setCellValue('H'.$i,$gross_pay);
                        $excel->getActiveSheet()->setCellValue('I'.$i,$sss_deduction);
                        $excel->getActiveSheet()->setCellValue('J'.$i,$sss_ee_mpf);
                        $excel->getActiveSheet()->setCellValue('K'.$i,$sssloan_deduction);
                        $excel->getActiveSheet()->setCellValue('L'.$i,$cooploan_deduction);
                        $excel->getActiveSheet()->setCellValue('M'.$i,$coopcontribution_deduction);
                        $excel->getActiveSheet()->setCellValue('N'.$i,$total_deductions);
                        $excel->getActiveSheet()->setCellValue('O'.$i,$net_pay);

                        $i++;

                        $excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                        $excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                        $excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                        $excel->getActiveSheet()->getStyle('K'.$i.':M'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

                        $excel->getActiveSheet()->setCellValue('A'.$i,'');
                        $excel->getActiveSheet()->setCellValue('B'.$i,$allowance);
                        $excel->getActiveSheet()->setCellValue('C'.$i,$nsd_pay);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$day_off_pay);
                        $excel->getActiveSheet()->setCellValue('E'.$i,$ot_spe_hol_amt);
                        $excel->getActiveSheet()->setCellValue('F'.$i,$other_earnings);
                        $excel->getActiveSheet()->setCellValue('G'.$i,$minutes_excess_break_amt);
                        $excel->getActiveSheet()->setCellValue('H'.$i,'');
                        $excel->getActiveSheet()->setCellValue('I'.$i,$philhealth_deduction);
                        $excel->getActiveSheet()->setCellValue('J'.$i,'');
                        $excel->getActiveSheet()->setCellValue('K'.$i,$pagibigloan_deduction);
                        $excel->getActiveSheet()->setCellValue('L'.$i,$calamityloan_deduction);
                        $excel->getActiveSheet()->setCellValue('M'.$i,$cashadvance_deduction);
                        $excel->getActiveSheet()->setCellValue('N'.$i,'');
                        $excel->getActiveSheet()->setCellValue('O'.$i,'');

                        $i++;

                        $excel->getActiveSheet()->getStyle('C'.$i.':G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                        $excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                        $excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                        $excel->getActiveSheet()->getStyle('K'.$i.':M'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

                        $excel->getActiveSheet()->setCellValue('A'.$i,'');
                        $excel->getActiveSheet()->setCellValue('B'.$i,'');
                        $excel->getActiveSheet()->setCellValue('C'.$i,$sun_pay);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$ot_reg_amt);
                        $excel->getActiveSheet()->setCellValue('E'.$i,$adjustment);
                        $excel->getActiveSheet()->setCellValue('F'.$i,$minutes_late_amt);
                        $excel->getActiveSheet()->setCellValue('G'.$i,$minutes_undertime_amt);
                        $excel->getActiveSheet()->setCellValue('H'.$i,'');
                        $excel->getActiveSheet()->setCellValue('I'.$i,$pagibig_deduction);
                        $excel->getActiveSheet()->setCellValue('J'.$i,'');
                        $excel->getActiveSheet()->setCellValue('K'.$i,$wtax_deduction);
                        $excel->getActiveSheet()->setCellValue('L'.$i,$hdmfloan_deduction);
                        $excel->getActiveSheet()->setCellValue('M'.$i,$other_deductions);
                        $excel->getActiveSheet()->setCellValue('N'.$i,'');
                        $excel->getActiveSheet()->setCellValue('O'.$i,'');

                        $i++;


                    }
                }

                $excel->getActiveSheet()->getStyle('B'.$i.':O'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                $border_top_thick = array(
                  'borders' => array(
                    'top' => array('style' => PHPExcel_Style_Border::BORDER_THICK)
                  ),
                );
                $excel->getActiveSheet()->getStyle('B'.$i.':O'.$i)->applyFromArray($border_top_thick);

                $excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A'.$i,'TOTAL '.$transaction->transaction_type);
                $excel->getActiveSheet()->setCellValue('B'.$i,$sub_reg_pay);
                $excel->getActiveSheet()->setCellValue('C'.$i,$sub_reg_hol_pay);
                $excel->getActiveSheet()->setCellValue('D'.$i,$sub_spe_hol_pay);
                $excel->getActiveSheet()->setCellValue('E'.$i,$sub_ot_reg_hol_amt);
                $excel->getActiveSheet()->setCellValue('F'.$i,$sub_days_with_pay_amt);
                $excel->getActiveSheet()->setCellValue('G'.$i,$sub_days_wout_pay_amt);
                $excel->getActiveSheet()->setCellValue('H'.$i,$sub_gross_pay);
                $excel->getActiveSheet()->setCellValue('I'.$i,$sub_sss_deduction);
                $excel->getActiveSheet()->setCellValue('J'.$i,$sub_sss_ee_mpf);
                $excel->getActiveSheet()->setCellValue('K'.$i,$sub_sssloan_deduction);
                $excel->getActiveSheet()->setCellValue('L'.$i,$sub_cooploan_deduction);
                $excel->getActiveSheet()->setCellValue('M'.$i,$sub_coopcontribution_deduction);
                $excel->getActiveSheet()->setCellValue('N'.$i,$sub_total_deductions);
                $excel->getActiveSheet()->setCellValue('O'.$i,$sub_net_pay);

                $i++;

                $excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                $excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                $excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                $excel->getActiveSheet()->getStyle('K'.$i.':M'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

                $excel->getActiveSheet()->setCellValue('A'.$i,'');
                $excel->getActiveSheet()->setCellValue('B'.$i,$sub_allowance);
                $excel->getActiveSheet()->setCellValue('C'.$i,$sub_nsd_pay);
                $excel->getActiveSheet()->setCellValue('D'.$i,$sub_day_off_pay);
                $excel->getActiveSheet()->setCellValue('E'.$i,$sub_ot_spe_hol_amt);
                $excel->getActiveSheet()->setCellValue('F'.$i,$sub_other_earnings);
                $excel->getActiveSheet()->setCellValue('G'.$i,$sub_minutes_excess_break_amt);
                $excel->getActiveSheet()->setCellValue('H'.$i,'');
                $excel->getActiveSheet()->setCellValue('I'.$i,$sub_philhealth_deduction);
                $excel->getActiveSheet()->setCellValue('J'.$i,'');
                $excel->getActiveSheet()->setCellValue('K'.$i,$sub_pagibigloan_deduction);
                $excel->getActiveSheet()->setCellValue('L'.$i,$sub_calamityloan_deduction);
                $excel->getActiveSheet()->setCellValue('M'.$i,$sub_cashadvance_deduction);
                $excel->getActiveSheet()->setCellValue('N'.$i,'');
                $excel->getActiveSheet()->setCellValue('O'.$i,'');

                $i++;

                $excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('C'.$i.':G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                $excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                $excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                $excel->getActiveSheet()->getStyle('K'.$i.':M'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

                $excel->getActiveSheet()->setCellValue('A'.$i,'');
                $excel->getActiveSheet()->setCellValue('B'.$i,'');
                $excel->getActiveSheet()->setCellValue('C'.$i,$sub_sun_pay);
                $excel->getActiveSheet()->setCellValue('D'.$i,$sub_ot_reg_amt);
                $excel->getActiveSheet()->setCellValue('E'.$i,$sub_adjustment);
                $excel->getActiveSheet()->setCellValue('F'.$i,$sub_minutes_late_amt);
                $excel->getActiveSheet()->setCellValue('G'.$i,$sub_minutes_undertime_amt);
                $excel->getActiveSheet()->setCellValue('H'.$i,'');
                $excel->getActiveSheet()->setCellValue('I'.$i,$sub_pagibig_deduction);
                $excel->getActiveSheet()->setCellValue('J'.$i,'');
                $excel->getActiveSheet()->setCellValue('K'.$i,$sub_wtax_deduction);
                $excel->getActiveSheet()->setCellValue('L'.$i,$sub_hdmfloan_deduction);
                $excel->getActiveSheet()->setCellValue('M'.$i,$sub_other_deductions);
                $excel->getActiveSheet()->setCellValue('N'.$i,'');
                $excel->getActiveSheet()->setCellValue('O'.$i,'');

                $i++;
                $i++;

            }

            $grand_reg_pay += $sub_reg_pay;
            $grand_reg_hol_pay += $sub_reg_hol_pay;
            $grand_spe_hol_pay += $sub_spe_hol_pay;
            $grand_ot_reg_hol_amt += $sub_ot_reg_hol_amt;
            $grand_days_with_pay_amt += $sub_days_with_pay_amt;
            $grand_days_wout_pay_amt += $sub_days_wout_pay_amt;
            $grand_gross_pay += $sub_gross_pay;
            $grand_sss_deduction += $sub_sss_deduction;
            $grand_sss_ee_mpf += $sub_sss_ee_mpf;
            $grand_sssloan_deduction += $sub_sssloan_deduction;
            $grand_cooploan_deduction += $sub_cooploan_deduction;
            $grand_coopcontribution_deduction += $sub_coopcontribution_deduction;
            $grand_total_deductions += $sub_total_deductions;
            $grand_net_pay += $sub_net_pay;
            $grand_allowance += $sub_allowance;
            $grand_nsd_pay += $sub_nsd_pay;
            $grand_day_off_pay += $sub_day_off_pay;
            $grand_ot_spe_hol_amt += $sub_ot_spe_hol_amt;
            $grand_other_earnings += $sub_other_earnings;
            $grand_minutes_excess_break_amt += $sub_minutes_excess_break_amt;
            $grand_philhealth_deduction += $sub_philhealth_deduction;
            $grand_pagibigloan_deduction += $sub_pagibigloan_deduction;
            $grand_calamityloan_deduction += $sub_calamityloan_deduction;
            $grand_cashadvance_deduction += $sub_cashadvance_deduction;
            $grand_sun_pay += $sub_sun_pay;
            $grand_ot_reg_amt += $sub_ot_reg_amt;
            $grand_adjustment += $sub_adjustment;
            $grand_minutes_late_amt += $sub_minutes_late_amt;
            $grand_minutes_undertime_amt += $sub_minutes_undertime_amt;
            $grand_pagibig_deduction += $sub_pagibig_deduction;
            $grand_wtax_deduction += $sub_wtax_deduction;
            $grand_hdmfloan_deduction += $sub_hdmfloan_deduction;
            $grand_other_deductions += $sub_other_deductions;

        }

        if(count($payroll)>0){

                $excel->getActiveSheet()->mergeCells('A'.$i.':O'.$i);
                $excel->getActiveSheet()
                        ->getStyle('A'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel->getActiveSheet()->getStyle('A'.$i)->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray(
                    array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'd3d3d3')
                        )
                    )
                );

                $excel->getActiveSheet()->setCellValue('A'.$i,'GRAND TOTAL');

                $i++;

                $excel->getActiveSheet()->getStyle('B'.$i.':O'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                $excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A'.$i,'');
                $excel->getActiveSheet()->setCellValue('B'.$i,$grand_reg_pay);
                $excel->getActiveSheet()->setCellValue('C'.$i,$grand_reg_hol_pay);
                $excel->getActiveSheet()->setCellValue('D'.$i,$grand_spe_hol_pay);
                $excel->getActiveSheet()->setCellValue('E'.$i,$grand_ot_reg_hol_amt);
                $excel->getActiveSheet()->setCellValue('F'.$i,$grand_days_with_pay_amt);
                $excel->getActiveSheet()->setCellValue('G'.$i,$grand_days_wout_pay_amt);
                $excel->getActiveSheet()->setCellValue('H'.$i,$grand_gross_pay);
                $excel->getActiveSheet()->setCellValue('I'.$i,$grand_sss_deduction);
                $excel->getActiveSheet()->setCellValue('J'.$i,$grand_sss_ee_mpf);
                $excel->getActiveSheet()->setCellValue('K'.$i,$grand_sssloan_deduction);
                $excel->getActiveSheet()->setCellValue('L'.$i,$grand_cooploan_deduction);
                $excel->getActiveSheet()->setCellValue('M'.$i,$grand_coopcontribution_deduction);
                $excel->getActiveSheet()->setCellValue('N'.$i,$grand_total_deductions);
                $excel->getActiveSheet()->setCellValue('O'.$i,$grand_net_pay);

                $i++;

                $excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                $excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                $excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                $excel->getActiveSheet()->getStyle('K'.$i.':M'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

                $excel->getActiveSheet()->setCellValue('A'.$i,'');
                $excel->getActiveSheet()->setCellValue('B'.$i,$grand_allowance);
                $excel->getActiveSheet()->setCellValue('C'.$i,$grand_nsd_pay);
                $excel->getActiveSheet()->setCellValue('D'.$i,$grand_day_off_pay);
                $excel->getActiveSheet()->setCellValue('E'.$i,$grand_ot_spe_hol_amt);
                $excel->getActiveSheet()->setCellValue('F'.$i,$grand_other_earnings);
                $excel->getActiveSheet()->setCellValue('G'.$i,$grand_minutes_excess_break_amt);
                $excel->getActiveSheet()->setCellValue('H'.$i,'');
                $excel->getActiveSheet()->setCellValue('I'.$i,$grand_philhealth_deduction);
                $excel->getActiveSheet()->setCellValue('J'.$i,'');
                $excel->getActiveSheet()->setCellValue('K'.$i,$grand_pagibigloan_deduction);
                $excel->getActiveSheet()->setCellValue('L'.$i,$grand_calamityloan_deduction);
                $excel->getActiveSheet()->setCellValue('M'.$i,$grand_cashadvance_deduction);
                $excel->getActiveSheet()->setCellValue('N'.$i,'');
                $excel->getActiveSheet()->setCellValue('O'.$i,'');

                $i++;

                $excel->getActiveSheet()->getStyle('A'.$i.':O'.$i)->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->getStyle('C'.$i.':G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                $excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                $excel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');  
                $excel->getActiveSheet()->getStyle('K'.$i.':M'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

                $excel->getActiveSheet()->setCellValue('A'.$i,'');
                $excel->getActiveSheet()->setCellValue('B'.$i,'');
                $excel->getActiveSheet()->setCellValue('C'.$i,$grand_sun_pay);
                $excel->getActiveSheet()->setCellValue('D'.$i,$grand_ot_reg_amt);
                $excel->getActiveSheet()->setCellValue('E'.$i,$grand_adjustment);
                $excel->getActiveSheet()->setCellValue('F'.$i,$grand_minutes_late_amt);
                $excel->getActiveSheet()->setCellValue('G'.$i,$grand_minutes_undertime_amt);
                $excel->getActiveSheet()->setCellValue('H'.$i,'');
                $excel->getActiveSheet()->setCellValue('I'.$i,$grand_pagibig_deduction);
                $excel->getActiveSheet()->setCellValue('J'.$i,'');
                $excel->getActiveSheet()->setCellValue('K'.$i,$grand_wtax_deduction);
                $excel->getActiveSheet()->setCellValue('L'.$i,$grand_hdmfloan_deduction);
                $excel->getActiveSheet()->setCellValue('M'.$i,$grand_other_deductions);
                $excel->getActiveSheet()->setCellValue('N'.$i,'');
                $excel->getActiveSheet()->setCellValue('O'.$i,'');

                $i++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $filename="PAYROLL SUMMARY - (".$get_period.")";

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

            case 'export_employee_payroll_summary':
                    $excel = $this->excel;
                    if($filter_value!=='all' AND $filter_value2!==0){
                        $where="WHERE erd.active_rates_duties=1 AND dtr.pay_period_id=".$filter_value2." AND erd.ref_department_id=".$filter_value."";
                    }
                    else if($filter_value2 == 0 AND $filter_value=='all'){
                        $where="WHERE erd.active_rates_duties=1 AND dtr.pay_period_id=".$filter_value2."";
                    }
                    else if($filter_value2 != 0 AND $filter_value =='all'){
                        $where="WHERE erd.active_rates_duties=1 AND dtr.pay_period_id=".$filter_value2."";
                    }
                    else if($filter_value2 == 0 AND $filter_value !=='all'){
                        $where="WHERE erd.active_rates_duties=1 AND dtr.pay_period_id=".$filter_value2."";
                    }
                    $getpayrollregsummary=$this->PayrollReports_model->get_payroll_summary($where);

                    if($filter_value!=="all"){
                        $getdepartment=$this->RefDepartment_model->get_list(
                        $filter_value,
                        'ref_department.department'
                        );
                        $get_department = $getdepartment[0]->department;
                    }
                    else{
                        $get_department = "All";
                    }

                    if($filter_value2!=0){
                        $period=$this->RefPayPeriod_model->getperiod($filter_value2);
                        $get_period = $period[0]->period;
                    }
                    else{
                        $get_period = "";
                    }

                    $getcompany=$this->GeneralSettings_model->get_list(
                    null,
                    'company_setup.*'
                    );
                    $company=$getcompany[0];

                    $excel->setActiveSheetIndex(0);
                    $excel->getActiveSheet()->setTitle("PAYROLL SUMMARY");

                    $excel->getActiveSheet()->mergeCells('A1:AM1');
                    $excel->getActiveSheet()->mergeCells('A2:AM2');
                    $excel->getActiveSheet()->mergeCells('A3:AM3');
                    $excel->getActiveSheet()->mergeCells('A4:AM4');

                    $excel->getActiveSheet()->setCellValue('A1',$company->company_name)
                                            ->setCellValue('A2',$company->address)
                                            ->setCellValue('A3',$company->contact_no)
                                            ->setCellValue('A4',$company->email_address);

                    $excel->getActiveSheet()->mergeCells('A5:AM5');

                    $excel->getActiveSheet()->getStyle('A6'.':'.'AM7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A6:AM6');
                    $excel->getActiveSheet()->mergeCells('A7:AM7');

                    $excel->getActiveSheet()->setCellValue('A6','Pay Period : '.$get_period)
                                            ->setCellValue('A7','Department : '.$get_department);
                    
                    $excel->getActiveSheet()->getStyle('A9:AM9')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('35');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('J')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('K')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('L')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('M')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('N')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('O')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('P')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('Q')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('R')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('S')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('T')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('U')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('V')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('W')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('X')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('Y')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('Z')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('AA')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('AB')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('AC')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('AD')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('AE')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('AF')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('AG')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('AH')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('AI')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('AJ')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('AK')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('AL')->setWidth('15');
                    $excel->getActiveSheet()->getColumnDimension('AM')->setWidth('15');

                    $excel->getActiveSheet()
                            ->getStyle('C9:AM9')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A9','#');
                    $excel->getActiveSheet()->setCellValue('B9','Employee Name');
                    $excel->getActiveSheet()->setCellValue('C9','Regular (Hrs)');
                    $excel->getActiveSheet()->setCellValue('D9','Basic Pay');
                    $excel->getActiveSheet()->setCellValue('E9','Regular Holiday (Hrs)');
                    $excel->getActiveSheet()->setCellValue('F9','Regular Holiday Pay');
                    $excel->getActiveSheet()->setCellValue('G9','Special Holiday (Hrs)');
                    $excel->getActiveSheet()->setCellValue('H9','Special Holiday Pay');
                    $excel->getActiveSheet()->setCellValue('I9','Overtime (Hrs)');
                    $excel->getActiveSheet()->setCellValue('J9','Overtime Pay');
                    $excel->getActiveSheet()->setCellValue('K9','NSD (Hrs)');
                    $excel->getActiveSheet()->setCellValue('L9','NSD Pay');
                    $excel->getActiveSheet()->setCellValue('M9','Rest Day (Hrs)');
                    $excel->getActiveSheet()->setCellValue('N9','Rest Day Pay');
                    $excel->getActiveSheet()->setCellValue('O9','W/ Pay (Hrs)');
                    $excel->getActiveSheet()->setCellValue('P9','Days W/ Pay');
                    $excel->getActiveSheet()->setCellValue('Q9','Meal/Allowance');
                    $excel->getActiveSheet()->setCellValue('R9','Adjustment');
                    $excel->getActiveSheet()->setCellValue('S9','Other Earnings');
                    $excel->getActiveSheet()->setCellValue('T9','Gross Pay');
                    $excel->getActiveSheet()->setCellValue('U9','Absences (Hrs)');
                    $excel->getActiveSheet()->setCellValue('V9','Absences');
                    $excel->getActiveSheet()->setCellValue('W9','Late (Minutes)');
                    $excel->getActiveSheet()->setCellValue('X9','Late');
                    $excel->getActiveSheet()->setCellValue('Y9','Undertime (Minutes)');
                    $excel->getActiveSheet()->setCellValue('Z9','Undertime');
                    $excel->getActiveSheet()->setCellValue('AA9','Excess Break (Minutes)');
                    $excel->getActiveSheet()->setCellValue('AB9','Excess Break');
                    $excel->getActiveSheet()->setCellValue('AC9','SSS Deduct');
                    $excel->getActiveSheet()->setCellValue('AD9','Philhealth Deduct');
                    $excel->getActiveSheet()->setCellValue('AE9','Pagibig');
                    $excel->getActiveSheet()->setCellValue('AF9','W/Tax');
                    $excel->getActiveSheet()->setCellValue('AG9','SSS Loan');
                    $excel->getActiveSheet()->setCellValue('AH9','Pagibig Loan');
                    $excel->getActiveSheet()->setCellValue('AI9','Cash Advance (Reg)');
                    $excel->getActiveSheet()->setCellValue('AJ9','Calamity Loan');
                    $excel->getActiveSheet()->setCellValue('AK9','Other Deduct');
                    $excel->getActiveSheet()->setCellValue('AL9','Total Deductions');
                    $excel->getActiveSheet()->setCellValue('AM9','Net Pay');

                    $basic_pay=0;
                    $reg_holiday=0;
                    $spe_holiday=0;
                    $overtime=0;
                    $nsd_pay=0;
                    $day_off_pay=0;
                    $s_mealallowance=0;
                    $s_adjustment=0;
                    $s_other_earnings=0;
                    $days_wpay=0;
                    $absences=0;
                    $late=0;
                    $undertime=0;
                    $excess_break=0;
                    $sss_deduction=0;
                    $philhealth_deduction=0;
                    $pagibig_deduction=0;
                    $wtax_deduction=0;
                    $sssloan_deduction=0;
                    $pagibigloan_deduction=0;
                    $cashadvance_deduction=0;
                    $calamityloan_deduction=0;
                    $s_otherdeduct=0;
                    $s_deductions=0;
                    $s_gross_pay=0;
                    $salaries_wages=0;

                    $i = 10;
                    $a = 1;
                    if(count($getpayrollregsummary)!=0 || count($getpayrollregsummary)!=null){

                        foreach($getpayrollregsummary as $row){


                            $excel->getActiveSheet()
                                    ->getStyle('C'.$i.':AM'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()
                                    ->getStyle('A'.$i.':B'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                            
                            $excel->getActiveSheet()->getStyle('C'.$i.':AI'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                            $ot_hrs = $row->ot_reg+$row->ot_reg_reg_hol+$row->ot_reg_spe_hol+$row->ot_sun+$row->ot_sun_reg_hol+$row->ot_sun_spe_hol;
                            $nsd_hrs = $row->nsd_reg+$row->nsd_reg_reg_hol+$row->nsd_reg_spe_hol+$row->nsd_sun+$row->nsd_sun_reg_hol+$row->nsd_sun_spe_hol;

                            $basic_pay += $row->reg_pay;
                            $reg_holiday += $row->reg_hol_pay;
                            $spe_holiday += $row->spe_hol_pay;
                            $overtime += $row->reg_ot_pay+$row->sun_ot_pay;
                            $nsd_pay += $row->reg_nsd_pay+$row->sun_nsd_pay;
                            $day_off_pay += $row->day_off_pay;
                            $s_mealallowance += $row->allowance;
                            $s_adjustment += $row->adjustment;
                            $s_other_earnings += $row->other_earnings;
                            $days_wpay += $row->days_with_pay_amt;
                            $absences += $row->days_wout_pay_amt;
                            $late += $row->minutes_late_amt;
                            $undertime += $row->minutes_undertime_amt;
                            $excess_break += $row->minutes_excess_break_amt;
                            $sss_deduction += $row->sss_deduction;
                            $philhealth_deduction += $row->philhealth_deduction;
                            $pagibig_deduction += $row->pagibig_deduction;
                            $wtax_deduction += $row->wtax_deduction;
                            $sssloan_deduction += $row->sssloan_deduction;
                            $pagibigloan_deduction += $row->pagibigloan_deduction;
                            $cashadvance_deduction += $row->cashadvance_deduction;
                            $calamityloan_deduction += $row->calamityloan_deduction;
                            $s_otherdeduct += $row->other_deductions;
                            $s_deductions += $row->total_deductions;
                            $s_gross_pay += $row->gross_pay;
                            $salaries_wages += $row->net_pay;

                            $excel->getActiveSheet()->setCellValue('A'.$i,$a);
                            $excel->getActiveSheet()->setCellValue('B'.$i,$row->fullname);
                            $excel->getActiveSheet()->setCellValue('C'.$i,number_format($row->reg,2));
                            $excel->getActiveSheet()->setCellValue('D'.$i,number_format($row->reg_pay,2));
                            $excel->getActiveSheet()->setCellValue('E'.$i,number_format($row->reg_hol,2));
                            $excel->getActiveSheet()->setCellValue('F'.$i,number_format($row->reg_hol_pay,2));
                            $excel->getActiveSheet()->setCellValue('G'.$i,number_format($row->spe_hol,2));
                            $excel->getActiveSheet()->setCellValue('H'.$i,number_format($row->spe_hol_pay,2));
                            $excel->getActiveSheet()->setCellValue('I'.$i,number_format($ot_hrs,2));
                            $excel->getActiveSheet()->setCellValue('J'.$i,number_format($row->reg_ot_pay+$row->sun_ot_pay,2));
                            $excel->getActiveSheet()->setCellValue('K'.$i,number_format($nsd_hrs,2));
                            $excel->getActiveSheet()->setCellValue('L'.$i,number_format($row->reg_nsd_pay+$row->sun_nsd_pay,2));
                            $excel->getActiveSheet()->setCellValue('M'.$i,number_format($row->day_off,2));
                            $excel->getActiveSheet()->setCellValue('N'.$i,number_format($row->day_off_pay,2));
                            $excel->getActiveSheet()->setCellValue('O'.$i,number_format($row->days_with_pay,2));
                            $excel->getActiveSheet()->setCellValue('P'.$i,number_format($row->days_with_pay_amt,2));
                            $excel->getActiveSheet()->setCellValue('Q'.$i,number_format($row->allowance,2));
                            $excel->getActiveSheet()->setCellValue('R'.$i,number_format($row->adjustment,2));
                            $excel->getActiveSheet()->setCellValue('S'.$i,number_format($row->other_earnings,2));
                            $excel->getActiveSheet()->setCellValue('T'.$i,number_format($row->gross_pay,2));
                            $excel->getActiveSheet()->setCellValue('U'.$i,number_format($row->days_wout_pay,2));
                            $excel->getActiveSheet()->setCellValue('V'.$i,number_format($row->days_wout_pay_amt,2));
                            $excel->getActiveSheet()->setCellValue('W'.$i,number_format($row->minutes_late,2));
                            $excel->getActiveSheet()->setCellValue('X'.$i,number_format($row->minutes_late_amt,2));
                            $excel->getActiveSheet()->setCellValue('Y'.$i,number_format($row->minutes_undertime,2));
                            $excel->getActiveSheet()->setCellValue('Z'.$i,number_format($row->minutes_undertime_amt,2));  
                            $excel->getActiveSheet()->setCellValue('AA'.$i,number_format($row->minutes_excess_break,2));
                            $excel->getActiveSheet()->setCellValue('AB'.$i,number_format($row->minutes_excess_break_amt,2));
                            $excel->getActiveSheet()->setCellValue('AC'.$i,number_format($row->sss_deduction,2));
                            $excel->getActiveSheet()->setCellValue('AD'.$i,number_format($row->philhealth_deduction,2));
                            $excel->getActiveSheet()->setCellValue('AE'.$i,number_format($row->pagibig_deduction,2));
                            $excel->getActiveSheet()->setCellValue('AF'.$i,number_format($row->wtax_deduction,2));
                            $excel->getActiveSheet()->setCellValue('AG'.$i,number_format($row->sssloan_deduction,2));
                            $excel->getActiveSheet()->setCellValue('AH'.$i,number_format($row->pagibigloan_deduction,2));
                            $excel->getActiveSheet()->setCellValue('AI'.$i,number_format($row->cashadvance_deduction,2));
                            $excel->getActiveSheet()->setCellValue('AJ'.$i,number_format($row->calamityloan_deduction,2));
                            $excel->getActiveSheet()->setCellValue('AK'.$i,number_format($row->other_deductions,2));
                            $excel->getActiveSheet()->setCellValue('AL'.$i,number_format($row->total_deductions,2));
                            $excel->getActiveSheet()->setCellValue('AM'.$i,number_format($row->net_pay,2));

                            $i++;
                            $a++;

                            }

                        }else{
                                $excel->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                                $excel->getActiveSheet()->mergeCells('A'.$i.':AM'.$i);
                                $excel->getActiveSheet()->setCellValue('A'.$i,'No Result');
                                $i++;
                        }

                            $pan_1 = $i+1;
                            $pan_2 = $i+2;
                            $pan_3 = $i+3;
                            $pan_4 = $i+4;
                            $pan_5 = $i+5;

                            $excel->getActiveSheet()->setCellValue('B'.$pan_1,'Basic Pay: ');
                            $excel->getActiveSheet()->setCellValue('B'.$pan_2,'Regular Holiday: ');
                            $excel->getActiveSheet()->setCellValue('B'.$pan_3,'Special Holiday: ');
                            $excel->getActiveSheet()->setCellValue('B'.$pan_4,'Overtime: ');
                            $excel->getActiveSheet()->setCellValue('B'.$pan_5,'NSD Pay: ');

                            $excel->getActiveSheet()->setCellValue('D'.$pan_1,'Day Off Pay: ');
                            $excel->getActiveSheet()->setCellValue('D'.$pan_2,'Meal/Allowance: ');
                            $excel->getActiveSheet()->setCellValue('D'.$pan_3,'Adjustment: ');
                            $excel->getActiveSheet()->setCellValue('D'.$pan_4,'Other Earnings: ');
                            $excel->getActiveSheet()->setCellValue('D'.$pan_5,'Days W/ Pay: ');

                            $excel->getActiveSheet()->setCellValue('F'.$pan_1,'Absences: ');
                            $excel->getActiveSheet()->setCellValue('F'.$pan_2,'Late: ');
                            $excel->getActiveSheet()->setCellValue('F'.$pan_3,'SSS: ');
                            $excel->getActiveSheet()->setCellValue('F'.$pan_4,'Philhealth: ');
                            $excel->getActiveSheet()->setCellValue('F'.$pan_5,'Pagibig: ');

                            $excel->getActiveSheet()->setCellValue('H'.$pan_1,'Wtax: ');
                            $excel->getActiveSheet()->setCellValue('H'.$pan_2,'SSS Loan: ');
                            $excel->getActiveSheet()->setCellValue('H'.$pan_3,'Pagibig Loan: ');
                            $excel->getActiveSheet()->setCellValue('H'.$pan_4,'Cash Advance: ');
                            $excel->getActiveSheet()->setCellValue('H'.$pan_5,'Undertime: ');

                            $excel->getActiveSheet()->setCellValue('J'.$pan_1,'Excess Break: ');
                            $excel->getActiveSheet()->setCellValue('J'.$pan_2,'Other Deduct: ');
                            $excel->getActiveSheet()->setCellValue('J'.$pan_3,'Total Gross Pay: ');
                            $excel->getActiveSheet()->setCellValue('J'.$pan_4,'Total Deduction: ');
                            $excel->getActiveSheet()->setCellValue('J'.$pan_5,'Salaries & Wages: ');
  
                            $excel->getActiveSheet()->getStyle('C'.$pan_1.':C'.$pan_5)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 
                            $excel->getActiveSheet()->getStyle('E'.$pan_1.':E'.$pan_5)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 
                            $excel->getActiveSheet()->getStyle('G'.$pan_1.':G'.$pan_5)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 
                            $excel->getActiveSheet()->getStyle('I'.$pan_1.':I'.$pan_5)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 
                            $excel->getActiveSheet()->getStyle('K'.$pan_1.':K'.$pan_5)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                            $excel->getActiveSheet()->getStyle('B'.$pan_1.':B'.$pan_5)->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()->getStyle('D'.$pan_1.':D'.$pan_5)->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()->getStyle('F'.$pan_1.':F'.$pan_5)->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()->getStyle('H'.$pan_1.':H'.$pan_5)->getFont()->setBold(TRUE);
                            $excel->getActiveSheet()->getStyle('J'.$pan_1.':J'.$pan_5)->getFont()->setBold(TRUE);

                            $excel->getActiveSheet()
                                    ->getStyle('C'.$pan_1.':C'.$pan_5)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                            $excel->getActiveSheet()
                                    ->getStyle('E'.$pan_1.':E'.$pan_5)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                            $excel->getActiveSheet()
                                    ->getStyle('G'.$pan_1.':G'.$pan_5)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);  
                            $excel->getActiveSheet()
                                    ->getStyle('I'.$pan_1.':I'.$pan_5)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 
                            $excel->getActiveSheet()
                                    ->getStyle('K'.$pan_1.':K'.$pan_5)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);                                   

                            $excel->getActiveSheet()->setCellValue('C'.$pan_1,number_format($basic_pay,2));
                            $excel->getActiveSheet()->setCellValue('C'.$pan_2,number_format($reg_holiday,2));
                            $excel->getActiveSheet()->setCellValue('C'.$pan_3,number_format($spe_holiday,2));
                            $excel->getActiveSheet()->setCellValue('C'.$pan_4,number_format($overtime,2));
                            $excel->getActiveSheet()->setCellValue('C'.$pan_5,number_format($nsd_pay,2));

                            $excel->getActiveSheet()->setCellValue('E'.$pan_1,number_format($day_off_pay,2));
                            $excel->getActiveSheet()->setCellValue('E'.$pan_2,number_format($s_mealallowance,2));
                            $excel->getActiveSheet()->setCellValue('E'.$pan_3,number_format($s_adjustment,2));
                            $excel->getActiveSheet()->setCellValue('E'.$pan_4,number_format($s_other_earnings,2));
                            $excel->getActiveSheet()->setCellValue('E'.$pan_5,number_format($days_wpay,2));

                            $excel->getActiveSheet()->setCellValue('G'.$pan_1,number_format($absences,2));
                            $excel->getActiveSheet()->setCellValue('G'.$pan_2,number_format($late,2));
                            $excel->getActiveSheet()->setCellValue('G'.$pan_3,number_format($sss_deduction,2));
                            $excel->getActiveSheet()->setCellValue('G'.$pan_4,number_format($philhealth_deduction,2));
                            $excel->getActiveSheet()->setCellValue('G'.$pan_5,number_format($pagibig_deduction,2));

                            $excel->getActiveSheet()->setCellValue('I'.$pan_1,number_format($wtax_deduction,2));
                            $excel->getActiveSheet()->setCellValue('I'.$pan_2,number_format($sssloan_deduction,2));
                            $excel->getActiveSheet()->setCellValue('I'.$pan_3,number_format($pagibigloan_deduction,2));
                            $excel->getActiveSheet()->setCellValue('I'.$pan_4,number_format($cashadvance_deduction,2));
                            $excel->getActiveSheet()->setCellValue('I'.$pan_5,number_format($undertime,2));

                            $excel->getActiveSheet()->setCellValue('K'.$pan_1,number_format($excess_break,2));
                            $excel->getActiveSheet()->setCellValue('K'.$pan_2,number_format($s_otherdeduct,2));
                            $excel->getActiveSheet()->setCellValue('K'.$pan_3,number_format($s_gross_pay,2));
                            $excel->getActiveSheet()->setCellValue('K'.$pan_4,number_format($s_deductions,2));
                            $excel->getActiveSheet()->setCellValue('K'.$pan_5,number_format($salaries_wages,2));

                            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

                            $filename="PAYROLL SUMMARY - (".$get_period.")";

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

            case 'employeee-yearly-salary': //

                            $getpayrollregsummary=$this->PayrollReports_model->get_yearly_salary_history($filter_value,$filter_value2,$filter_value3);
                        //show only inside grid with menu button
                        // if($filter_value!="all" AND $filter_value2!="all"){
                        //     /*echo json_encode($getpayrollregsummary);*/
                        // }
                        // if($filter_value=="all" AND $filter_value2!="all"){
                        //     $getpayrollregsummary=$this->PayrollReports_model->get_yearly_salary_filter_year($filter_value2,$filter_value3);
                        // }
                        // if($filter_value!="all" AND $filter_value2=="all"){
                        //     $getpayrollregsummary=$this->PayrollReports_model->get_yearly_salary_filter_employee($filter_value,$filter_value3);
                        // }
                        // if($filter_value=="all" AND $filter_value2=="all"){
                        //     $getpayrollregsummary=$this->PayrollReports_model->get_yearly_salary_wofilter($filter_value3);
                        // }

                        /*echo json_encode($getpayrollregsummary);*/
                        /*$getpayrollregsummary=$this->Payslip_model->get_list(
                        null,
                        'pay_slip.*,refpayperiod.pay_period_start,refpayperiod.pay_period_end',
                        array(
                             array('daily_time_record','daily_time_record.dtr_id=pay_slip.dtr_id','left'),
                             array('refpayperiod','refpayperiod.pay_period_id=daily_time_record.pay_period_id','left'),
                             )
                        );*/
                        /*//GET SALARY ADJUSTMENTS
                        $getadjustment=$this->Payslip_OtherEarning_model->get_list(
                        array('pay_slip_other_earnings.earnings_id'=>2),
                        'SUM(earnings_amount) as total_adjustment_amount'
                        );
                         //GET OTHER PAY/EARNING
                        $getotherpay=$this->Payslip_OtherEarning_model->get_list(
                        'pay_slip_other_earnings.earnings_id!=2',
                        'SUM(earnings_amount) as total_other_pay'
                        );
                         //TOTAL SSS DEDUCTION GET
                        $gettotalsssdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=1 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_sss_deduct'
                        );

                        //TOTAL PHILHEALTH GET
                        $gettotalphilhealthdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=2 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_philhealth_deduct'
                        );
                        //TOTAL PHILHEALTH GET
                        $gettotalpagibigdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=3 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_pagibig_deduct'
                        );

                        $gettotalwithholdingdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=4 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_withholdingtax_deduct'
                        );
                        //get total sss loan
                        $gettotalsssloandeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=5 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_sss_loan'
                        );
                        //get total pagibig loan
                        $gettotalpagibigloandeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=6 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_pagibig_loan'
                        );
                        //COOP LOAN DEDUCTION GET
                        $gettotalcooploandeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=8 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_coop_loan'
                        );
                        //COOP CONTRIBUTION DEDUCTION GET
                        $gettotalcoopcontributiondeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=9 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_coop_contribution'
                        );
                        //OTHER DEDUCTION GET
                        $gettotalotherdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id!=1  AND deduction_id!=2  AND deduction_id!=3  AND deduction_id!=4
                         AND deduction_id!=5  AND deduction_id!=6  AND deduction_id!=7  AND deduction_id!=8  AND deduction_id!=9 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_other_deduction'
                        );*/

                       /*echo json_encode($gettotalotherdeduction);*/

                        /*echo json_encode($getpayrollregsummary);*/
                        if($filter_value3!="all"){
                            $getbranch=$this->RefBranch_model->get_list(
                            $filter_value3,
                            'ref_branch.branch'
                            );
                            $get_branch = $getbranch[0]->branch;
                        }
                        else{
                            $get_branch = "All";
                        }

                        $data['payroll_register_summary']=$getpayrollregsummary;
                        $data['get_branch']=$get_branch;
                        $data['yearly']=$filter_value2;
                        $getcompany=$this->GeneralSettings_model->get_list(
                        null,
                        'company_setup.*'
                        );
                        $data['company']=$getcompany[0];



                        /*$data['total_adjustment_amount']=$getadjustment[0];
                        $data['total_other_pay']=$getotherpay[0];
                        $data['total_sss_deduct']=$gettotalsssdeduction[0];
                        $data['total_philhealth_deduct']=$gettotalphilhealthdeduction[0];
                        $data['total_pagibig_deduct']=$gettotalpagibigdeduction[0];
                        $data['total_withholdingtax_deduct']=$gettotalwithholdingdeduction[0];
                        $data['total_sss_loan']=$gettotalsssloandeduction[0];
                        $data['total_pagibig_loan']=$gettotalpagibigloandeduction[0];
                        $data['total_coop_loan']=$gettotalcooploandeduction[0];
                        $data['total_coop_contribution']=$gettotalcoopcontributiondeduction[0];
                        $data['total_other_deduction']=$gettotalotherdeduction[0];*/
                            echo $this->load->view('template/employee_yearly_salary_html',$data,TRUE);

                        break;

                     case 'check-13thmonth-pay': //
                        
                        $year = $filter_value2;
                        $m_13thmonth = $this->Emp_13thmonth_model;

                        $response['data'] = $this->Emp_13thmonth_model->get_13thmonth_processed($year);
                        echo json_encode($response);

                        break;

                     case 'employeee-13thmonth-pay': //
                        //show only inside grid with menu button

                        $year = $filter_value2;
                        
                        $m_13thmonth = $this->Emp_13thmonth_model;

                        $check_year = $m_13thmonth->get_13thmonth_processed($year);

                        $year_setup = $this->RefYearSetup_model->getYearSetup($year);
                        $start_13thmonth_date = ''; $end_13thmonth_date = ''; $factor = 0;

                        if (count($year_setup) > 0){
                            $start_13thmonth_date = $year_setup[0]->start_13thmonth_date;
                            $end_13thmonth_date = $year_setup[0]->end_13thmonth_date;
                            $factor = $year_setup[0]->factor_setup;
                        }else{
                            $start_13thmonth_date = '01-01-'.$year;
                            $end_13thmonth_date = '12-31-'.$year;
                            $factor = 12;
                        }

                        if (count($check_year) > 0){
                            $get13thmonth_pay=$m_13thmonth->get_13thmonth_processed($year);

                        }else{

                            if($filter_value!="all" AND $year!="all"){
                                $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay($filter_value,$year,$filter_value3,$start_13thmonth_date,$end_13thmonth_date);
                                /*echo json_encode($getpayrollregsummary);*/
                            }
                            if($filter_value=="all" AND $year!="all"){
                                $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay_year_filter($year,$filter_value3,$start_13thmonth_date,$end_13thmonth_date);
                            }
                            if($filter_value!="all" AND $year=="all"){
                                $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay_employee_filter($filter_value,$filter_value3,$start_13thmonth_date,$end_13thmonth_date);
                            }
                            if($filter_value=="all" AND $year=="all"){
                                $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay_wofilter($filter_value3,$start_13thmonth_date,$end_13thmonth_date);
                            }
                        }

                        /*echo json_encode($getpayrollregsummary);*/
                        /*$getpayrollregsummary=$this->Payslip_model->get_list(
                        null,
                        'pay_slip.*,refpayperiod.pay_period_start,refpayperiod.pay_period_end',
                        array(
                             array('daily_time_record','daily_time_record.dtr_id=pay_slip.dtr_id','left'),
                             array('refpayperiod','refpayperiod.pay_period_id=daily_time_record.pay_period_id','left'),
                             )
                        );*/
                        /*//GET SALARY ADJUSTMENTS
                        $getadjustment=$this->Payslip_OtherEarning_model->get_list(
                        array('pay_slip_other_earnings.earnings_id'=>2),
                        'SUM(earnings_amount) as total_adjustment_amount'
                        );
                         //GET OTHER PAY/EARNING
                        $getotherpay=$this->Payslip_OtherEarning_model->get_list(
                        'pay_slip_other_earnings.earnings_id!=2',
                        'SUM(earnings_amount) as total_other_pay'
                        );
                         //TOTAL SSS DEDUCTION GET
                        $gettotalsssdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=1 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_sss_deduct'
                        );

                        //TOTAL PHILHEALTH GET
                        $gettotalphilhealthdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=2 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_philhealth_deduct'
                        );
                        //TOTAL PHILHEALTH GET
                        $gettotalpagibigdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=3 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_pagibig_deduct'
                        );

                        $gettotalwithholdingdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=4 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_withholdingtax_deduct'
                        );
                        //get total sss loan
                        $gettotalsssloandeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=5 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_sss_loan'
                        );
                        //get total pagibig loan
                        $gettotalpagibigloandeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=6 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_pagibig_loan'
                        );
                        //COOP LOAN DEDUCTION GET
                        $gettotalcooploandeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=8 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_coop_loan'
                        );
                        //COOP CONTRIBUTION DEDUCTION GET
                        $gettotalcoopcontributiondeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id=9 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_coop_contribution'
                        );
                        //OTHER DEDUCTION GET
                        $gettotalotherdeduction=$this->PaySlip_deduction_model->get_list(
                        'deduction_id!=1  AND deduction_id!=2  AND deduction_id!=3  AND deduction_id!=4
                         AND deduction_id!=5  AND deduction_id!=6  AND deduction_id!=7  AND deduction_id!=8  AND deduction_id!=9 AND active_deduct=TRUE',
                        'SUM(deduction_amount) as total_other_deduction'
                        );*/

                       /*echo json_encode($gettotalotherdeduction);*/

                        /*echo json_encode($getpayrollregsummary);*/
                        if($filter_value3!="all"){
                            $getbranch=$this->RefBranch_model->get_list(
                            $filter_value3,
                            'ref_branch.branch'
                            );
                            $get_branch = $getbranch[0]->branch;
                        }
                        else{
                            $get_branch = "All";
                        }

                        $data['get13thmonth_pay']=$get13thmonth_pay;
                        $data['get_branch']=$get_branch;
                        $data['yearfilter']=$year;
                        $data['factor']=$factor;
                        $getcompany=$this->GeneralSettings_model->get_list(
                        null,
                        'company_setup.*'
                        );
                        $data['company']=$getcompany[0];


                        /*$data['total_adjustment_amount']=$getadjustment[0];
                        $data['total_other_pay']=$getotherpay[0];
                        $data['total_sss_deduct']=$gettotalsssdeduction[0];
                        $data['total_philhealth_deduct']=$gettotalphilhealthdeduction[0];
                        $data['total_pagibig_deduct']=$gettotalpagibigdeduction[0];
                        $data['total_withholdingtax_deduct']=$gettotalwithholdingdeduction[0];
                        $data['total_sss_loan']=$gettotalsssloandeduction[0];
                        $data['total_pagibig_loan']=$gettotalpagibigloandeduction[0];
                        $data['total_coop_loan']=$gettotalcooploandeduction[0];
                        $data['total_coop_contribution']=$gettotalcoopcontributiondeduction[0];
                        $data['total_other_deduction']=$gettotalotherdeduction[0];*/
                        echo $this->load->view('template/employee_13thmonth_html',$data,TRUE);

                        break;


                case 'employee-13thmonth-pay-register': //

                        $payment = $filter_value;
                        $year = $filter_value2;
                        $branch = $filter_value3;
                        $department = $type;
                        $status = $filter_value4;

                        $m_13thmonth = $this->Emp_13thmonth_model;

                        $year_setup = $this->RefYearSetup_model->getYearSetup($year);
                        $start_13thmonth_date = ''; $end_13thmonth_date = ''; $factor = 0;

                        if (count($year_setup) > 0){
                            $start_13thmonth_date = $year_setup[0]->start_13thmonth_date;
                            $end_13thmonth_date = $year_setup[0]->end_13thmonth_date;
                            $factor = $year_setup[0]->factor_setup;
                        }else{
                            $start_13thmonth_date = '01-01-'.$year;
                            $end_13thmonth_date = '12-31-'.$year;
                            $factor = 12;
                        }

                        $get13thmonth_pay=$m_13thmonth->get_13thmonth_processed($year,$branch,$department,null,$status);

                        if($branch!="all"){
                            $getbranch=$this->RefBranch_model->get_list($branch,'ref_branch.branch');
                            $get_branch = $getbranch[0]->branch;
                        }
                        else{
                            $get_branch = "All";
                        }

                        if($department!="all"){
                            $getdepartment=$this->RefDepartment_model->get_list($department,'ref_department.department');
                            $get_department = $getdepartment[0]->department;
                        }
                        else{
                            $get_department = "All";
                        }

                        $data['get13thmonth_pay']=$get13thmonth_pay;
                        $data['get_branch']=$get_branch;
                        $data['get_department']=$get_department;
                        $data['yearfilter']=$year;
                        $data['factor']=$factor;

                        $getcompany=$this->GeneralSettings_model->get_list(null,'company_setup.*'
                        );
                        $data['company']=$getcompany[0];

                        if ($payment == 1){
                            echo $this->load->view('template/employee_13thmonth_cash_register_html',$data,TRUE);
                        }else{
                            echo $this->load->view('template/employee_13thmonth_check_register_html',$data,TRUE);
                        }

                        break;
                        

            // case 'export_employee_13thmonth_pay':
            //         $excel = $this->excel;

            //         $year = $filter_value2;
            //         $year_setup = $this->RefYearSetup_model->getYearSetup($year);
            //         $start_13thmonth_date = ''; $end_13thmonth_date = ''; $factor = 0;

            //         if (count($year_setup) > 0){
            //             $start_13thmonth_date = $year_setup[0]->start_13thmonth_date;
            //             $end_13thmonth_date = $year_setup[0]->end_13thmonth_date;
            //             $factor = $year_setup[0]->factor_setup;
            //         }else{
            //             $start_13thmonth_date = '01-01-'.$year;
            //             $end_13thmonth_date = '12-31-'.$year;
            //             $factor = 12;
            //         }

            //         if($filter_value!="all" AND $year!="all"){
            //             $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay($filter_value,$year,$filter_value3,$start_13thmonth_date,$end_13thmonth_date);
            //             /*echo json_encode($getpayrollregsummary);*/
            //         }
            //         if($filter_value=="all" AND $year!="all"){
            //             $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay_year_filter($year,$filter_value3,$start_13thmonth_date,$end_13thmonth_date);
            //         }
            //         if($filter_value!="all" AND $year=="all"){
            //             $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay_employee_filter($filter_value,$filter_value3);
            //         }
            //         if($filter_value=="all" AND $year=="all"){
            //             $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay_wofilter($filter_value3);
            //         }
                    
            //         if($filter_value3!="all"){
            //             $getbranch=$this->RefBranch_model->get_list(
            //             $filter_value3,
            //             'ref_branch.branch'
            //             );
            //             $branch = $getbranch[0]->branch;
            //         }
            //         else{
            //             $branch = "All";
            //         }

            //         $getcompany=$this->GeneralSettings_model->get_list(
            //         null,
            //         'company_setup.*'
            //         );
            //         $company=$getcompany[0];

            //         $excel->setActiveSheetIndex(0);
            //         $excel->getActiveSheet()->setTitle("13TH MONTH ".$year);

            //         $excel->getActiveSheet()->mergeCells('A1:G1');
            //         $excel->getActiveSheet()->mergeCells('A2:G2');
            //         $excel->getActiveSheet()->mergeCells('A3:G3');
            //         $excel->getActiveSheet()->mergeCells('A4:G4');

            //         $excel->getActiveSheet()->setCellValue('A1',$company->company_name)
            //                                 ->setCellValue('A2',$company->address)
            //                                 ->setCellValue('A3',$company->contact_no)
            //                                 ->setCellValue('A4',$company->email_address);

            //         $excel->getActiveSheet()->mergeCells('A5:G5');

            //         $excel->getActiveSheet()->getStyle('A6'.':'.'G7')->getFont()->setBold(TRUE);
            //         $excel->getActiveSheet()->mergeCells('A6:G6');
            //         $excel->getActiveSheet()->mergeCells('A7:G7');

            //         $excel->getActiveSheet()->setCellValue('A6','13th Month Pay')
            //                                 ->setCellValue('A7','Branch : '.$branch)
            //                                 ->setCellValue('A8','Year : '.$year);
                    
            //         $excel->getActiveSheet()->getStyle('A10:G10')->getFont()->setBold(TRUE);

            //         $excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
            //         $excel->getActiveSheet()->getColumnDimension('B')->setWidth('35');
            //         $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
            //         $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
            //         $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
            //         $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
            //         $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');

            //         $excel->getActiveSheet()
            //                 ->getStyle('C10:G10')
            //                 ->getAlignment()
            //                 ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            //         $excel->getActiveSheet()->setCellValue('A10','#');
            //         $excel->getActiveSheet()->setCellValue('B10','Employee Name');
            //         $excel->getActiveSheet()->setCellValue('C10','Salary Retro');
            //         $excel->getActiveSheet()->setCellValue('D10','Total Reg Pay');
            //         $excel->getActiveSheet()->setCellValue('E10','Absences');
            //         $excel->getActiveSheet()->setCellValue('F10','Total');
            //         $excel->getActiveSheet()->setCellValue('G10','Accumulated 13th Month Pay');

            //         $grand_total_retro=0;
            //         $grand_total_reg_pay=0;
            //         $grand_total_total_days_wout_pay_amt=0;
            //         $grand_total=0;
            //         $grand_total_13thmonth=0;

            //         $i = 11;
            //         $a = 1;
            //         if(count($get13thmonth_pay)!=0 || count($get13thmonth_pay)!=null){

            //             foreach($get13thmonth_pay as $row){


            //                 $excel->getActiveSheet()
            //                         ->getStyle('C'.$i.':G'.$i)
            //                         ->getAlignment()
            //                         ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            //                 $excel->getActiveSheet()
            //                         ->getStyle('A'.$i.':B'.$i)
            //                         ->getAlignment()
            //                         ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                            
            //                 $excel->getActiveSheet()->getStyle('C'.$i.':G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

            //                 $grand_total_retro += $row->retro;
            //                 $grand_total_reg_pay += $row->total_13thmonth;
            //                 $grand_total_total_days_wout_pay_amt += $row->total_days_wout_pay_amt;
            //                 $grand_total += (($row->total_13thmonth+$row->retro)-($row->total_days_wout_pay_amt));
            //                 $grand_total_13thmonth += ($row->total_13thmonth/$factor);

            //                 $excel->getActiveSheet()->setCellValue('A'.$i,$a);
            //                 $excel->getActiveSheet()->setCellValue('B'.$i,$row->fullname);
            //                 $excel->getActiveSheet()->setCellValue('C'.$i,number_format($row->retro,2));
            //                 $excel->getActiveSheet()->setCellValue('D'.$i,number_format($row->total_13thmonth,2));
            //                 $excel->getActiveSheet()->setCellValue('E'.$i,number_format($row->total_days_wout_pay_amt,2));
            //                 $excel->getActiveSheet()->setCellValue('F'.$i,number_format(($row->total_13thmonth+$row->retro)-($row->total_days_wout_pay_amt),2));
            //                 $excel->getActiveSheet()->setCellValue('G'.$i,number_format(($row->total_13thmonth/$factor),2));

            //                 $i++;
            //                 $a++;

            //                 }

            //                 $excel->getActiveSheet()
            //                         ->getStyle('B'.$i.':G'.$i)
            //                         ->getAlignment()
            //                         ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            //                 $excel->getActiveSheet()->getStyle('C'.$i.':G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 
            //                 $excel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFont()->setBold(TRUE);

            //                 $excel->getActiveSheet()->setCellValue('B'.$i,'Total : ');
            //                 $excel->getActiveSheet()->setCellValue('C'.$i,number_format($grand_total_retro,2));
            //                 $excel->getActiveSheet()->setCellValue('D'.$i,number_format($grand_total_reg_pay,2));
            //                 $excel->getActiveSheet()->setCellValue('E'.$i,number_format($grand_total_total_days_wout_pay_amt,2));
            //                 $excel->getActiveSheet()->setCellValue('F'.$i,number_format($grand_total,2));
            //                 $excel->getActiveSheet()->setCellValue('G'.$i,number_format($grand_total_13thmonth,2));

            //             }else{
            //                     $excel->getActiveSheet()
            //                             ->getStyle('A'.$i)
            //                             ->getAlignment()
            //                             ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

            //                     $excel->getActiveSheet()->mergeCells('A'.$i.':G'.$i);
            //                     $excel->getActiveSheet()->setCellValue('A'.$i,'No Result');
            //                     $i++;
            //             }




            //                 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

            //                 $filename="EMPLOYEE 13TH MONTH PAY - (".$year.")";

            //                 header('Content-Disposition: attachment;filename='."".$filename.".xlsx".'');
            //                 header('Cache-Control: max-age=0');
            //                 // If you're serving to IE 9, then the following may be needed
            //                 header('Cache-Control: max-age=1');

            //                 // If you're serving to IE over SSL, then the following may be needed
            //                 header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            //                 header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            //                 header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            //                 header ('Pragma: public'); // HTTP/1.0

            //                 $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            //                 $objWriter->save('php://output');

            //     break;
                case 'export_employee_13thmonth_pay':
                    $excel = $this->excel;

                    $year = $filter_value2;
                
                    $m_13thmonth = $this->Emp_13thmonth_model;

                    $check_year = $m_13thmonth->get_13thmonth_processed($year);

                    $year_setup = $this->RefYearSetup_model->getYearSetup($year);
                    $start_13thmonth_date = ''; $end_13thmonth_date = ''; $factor = 0;

                    if (count($year_setup) > 0){
                        $start_13thmonth_date = $year_setup[0]->start_13thmonth_date;
                        $end_13thmonth_date = $year_setup[0]->end_13thmonth_date;
                        $factor = $year_setup[0]->factor_setup;
                    }else{
                        $start_13thmonth_date = '01-01-'.$year;
                        $end_13thmonth_date = '12-31-'.$year;
                        $factor = 12;
                    }

                    if (count($check_year) > 0){
                        $get13thmonth_pay=$m_13thmonth->get_13thmonth_processed($year);

                    }else{

                        if($filter_value!="all" AND $year!="all"){
                            $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay($filter_value,$year,$filter_value3,$start_13thmonth_date,$end_13thmonth_date);
                            /*echo json_encode($getpayrollregsummary);*/
                        }
                        if($filter_value=="all" AND $year!="all"){
                            $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay_year_filter($year,$filter_value3,$start_13thmonth_date,$end_13thmonth_date);
                        }
                        if($filter_value!="all" AND $year=="all"){
                            $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay_employee_filter($filter_value,$filter_value3,$start_13thmonth_date,$end_13thmonth_date);
                        }
                        if($filter_value=="all" AND $year=="all"){
                            $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay_wofilter($filter_value3,$start_13thmonth_date,$end_13thmonth_date);
                        }
                    }

                    if($filter_value3!="all"){
                        $getbranch=$this->RefBranch_model->get_list(
                        $filter_value3,
                        'ref_branch.branch'
                        );
                        $branch = $getbranch[0]->branch;
                    }
                    else{
                        $branch = "All";
                    }

                    $getcompany=$this->GeneralSettings_model->get_list(
                    null,
                    'company_setup.*'
                    );
                    $company=$getcompany[0];

                    $excel->setActiveSheetIndex(0);
                    $excel->getActiveSheet()->setTitle("13TH MONTH ".$year);

                    $excel->getActiveSheet()->mergeCells('A1:H1');
                    $excel->getActiveSheet()->mergeCells('A2:H2');
                    $excel->getActiveSheet()->mergeCells('A3:H3');
                    $excel->getActiveSheet()->mergeCells('A4:H4');

                    $excel->getActiveSheet()->setCellValue('A1',$company->company_name)
                                            ->setCellValue('A2',$company->address)
                                            ->setCellValue('A3',$company->contact_no)
                                            ->setCellValue('A4',$company->email_address);

                    $excel->getActiveSheet()->mergeCells('A5:H5');

                    $excel->getActiveSheet()->getStyle('A6'.':'.'F7')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A6:F6');
                    $excel->getActiveSheet()->mergeCells('A7:F7');

                    $excel->getActiveSheet()->setCellValue('A6','13th Month Pay')
                                            ->setCellValue('A7','Branch : '.$branch)
                                            ->setCellValue('A8','Year : '.$year);
                    
                    $excel->getActiveSheet()->getStyle('A10:F10')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('5');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('35');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');

                    $excel->getActiveSheet()
                            ->getStyle('C10:F10')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A10','#');
                    $excel->getActiveSheet()->setCellValue('B10','Employee Name');
                    $excel->getActiveSheet()->setCellValue('C10','Total Reg Pay');
                    $excel->getActiveSheet()->setCellValue('D10','Days w/ Pay');
                    $excel->getActiveSheet()->setCellValue('E10','Total');
                    $excel->getActiveSheet()->setCellValue('F10','Accumulated 13th Month Pay');

                    $grand_total_reg_pay=0;
                    $grand_total_total_days_w_pay_amt=0;
                    $grand_total=0;
                    $grand_total_13thmonth=0;

                    $i = 11;
                    $a = 1;
                    if(count($get13thmonth_pay)!=0 || count($get13thmonth_pay)!=null){

                        foreach($get13thmonth_pay as $row){


                            $excel->getActiveSheet()
                                    ->getStyle('C'.$i.':F'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()
                                    ->getStyle('A'.$i.':B'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                            
                            $excel->getActiveSheet()->getStyle('C'.$i.':G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                            $grand_total_reg_pay += $row->total_13thmonth;
                            $grand_total_total_days_w_pay_amt += $row->dayswithpayamt;
                            $grand_total += (($row->total_13thmonth+$row->retro+$row->dayswithpayamt)-($row->total_days_wout_pay_amt));
                            $grand_total_13thmonth += ((($row->total_13thmonth+$row->retro+$row->dayswithpayamt)-($row->total_days_wout_pay_amt))/$factor);


                            $excel->getActiveSheet()->setCellValue('A'.$i,$a);
                            $excel->getActiveSheet()->setCellValue('B'.$i,$row->fullname);
                            $excel->getActiveSheet()->setCellValue('C'.$i,number_format($row->total_13thmonth,2));
                            $excel->getActiveSheet()->setCellValue('D'.$i,number_format($row->dayswithpayamt,2));
                            $excel->getActiveSheet()->setCellValue('E'.$i,number_format((($row->total_13thmonth+$row->retro+$row->dayswithpayamt)-($row->total_days_wout_pay_amt)),2));
                            $excel->getActiveSheet()->setCellValue('F'.$i,number_format(((($row->total_13thmonth+$row->retro+$row->dayswithpayamt)-($row->total_days_wout_pay_amt))/$factor),2));

                            $i++;
                            $a++;

                            }

                            $excel->getActiveSheet()
                                    ->getStyle('B'.$i.':F'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->getStyle('C'.$i.':F'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 
                            $excel->getActiveSheet()->getStyle('A'.$i.':F'.$i)->getFont()->setBold(TRUE);

                            $excel->getActiveSheet()->setCellValue('B'.$i,'Total : ');
                            $excel->getActiveSheet()->setCellValue('C'.$i,number_format($grand_total_reg_pay,2));
                            $excel->getActiveSheet()->setCellValue('D'.$i,number_format($grand_total_total_days_w_pay_amt,2));
                            $excel->getActiveSheet()->setCellValue('E'.$i,number_format($grand_total,2));
                            $excel->getActiveSheet()->setCellValue('F'.$i,number_format($grand_total_13thmonth,2));

                        }else{
                                $excel->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                                $excel->getActiveSheet()->mergeCells('A'.$i.':F'.$i);
                                $excel->getActiveSheet()->setCellValue('A'.$i,'No Result');
                                $i++;
                        }




                            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

                            $filename="EMPLOYEE 13TH MONTH PAY - (".$year.")";

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
                
                case 'export_employee_13thmonth_pay_cash_register':
                    $excel = $this->excel;
                    
                    $payment = $filter_value;
                    $year = $filter_value2;
                    $branch = $filter_value3;
                    $department = $type;
                    $status = $filter_value4;

                    $m_13thmonth = $this->Emp_13thmonth_model;

                    $year_setup = $this->RefYearSetup_model->getYearSetup($year);
                    $start_13thmonth_date = ''; $end_13thmonth_date = ''; $factor = 0;

                    if (count($year_setup) > 0){
                        $start_13thmonth_date = $year_setup[0]->start_13thmonth_date;
                        $end_13thmonth_date = $year_setup[0]->end_13thmonth_date;
                        $factor = $year_setup[0]->factor_setup;
                    }else{
                        $start_13thmonth_date = '01-01-'.$year;
                        $end_13thmonth_date = '12-31-'.$year;
                        $factor = 12;
                    }

                    $get13thmonth_pay=$m_13thmonth->get_13thmonth_processed($year,$branch,$department,null,$status);

                    if($branch!="all"){
                        $getbranch=$this->RefBranch_model->get_list($branch,'ref_branch.branch');
                        $get_branch = $getbranch[0]->branch;
                    }
                    else{
                        $get_branch = "All";
                    }

                    if($department!="all"){
                        $getdepartment=$this->RefDepartment_model->get_list($department,'ref_department.department');
                        $get_department = $getdepartment[0]->department;
                    }
                    else{
                        $get_department = "All";
                    }

                    $getcompany=$this->GeneralSettings_model->get_list(
                    null,
                    'company_setup.*'
                    );
                    $company=$getcompany[0];

                    $excel->setActiveSheetIndex(0);
                    $excel->getActiveSheet()->setTitle("13TH MONTH PAY ".$year);

                    $excel->getActiveSheet()->mergeCells('A1:C1');
                    $excel->getActiveSheet()->mergeCells('A2:C2');
                    $excel->getActiveSheet()->mergeCells('A3:C3');
                    $excel->getActiveSheet()->mergeCells('A4:C4');

                    $excel->getActiveSheet()->setCellValue('A1',$company->company_name)
                                            ->setCellValue('A2',$company->address)
                                            ->setCellValue('A3',$company->contact_no)
                                            ->setCellValue('A4',$company->email_address);

                    $excel->getActiveSheet()->mergeCells('A5:C5');

                    $excel->getActiveSheet()->getStyle('A6'.':'.'C11')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A6:C6');
                    $excel->getActiveSheet()->mergeCells('A7:C7');
                    $excel->getActiveSheet()->mergeCells('A8:C8');
                    $excel->getActiveSheet()->mergeCells('A9:C9');
                    $excel->getActiveSheet()->mergeCells('A10:C10');
                    $excel->getActiveSheet()->mergeCells('A11:C11');

                    $excel->getActiveSheet()->setCellValue('A6','13th Month Pay')
                                            ->setCellValue('A7','Year : '.$year)
                                            ->setCellValue('A8','Branch : '.$get_branch)
                                            ->setCellValue('A9','Department : '.$get_department)
                                            ->setCellValue('A10','Payment Type : Cash')
                                            ->setCellValue('A11','Date : '.date('m/d/Y'));
                    
                    $excel->getActiveSheet()->getStyle('A13:C13')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('35');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');

                    $excel->getActiveSheet()
                            ->getStyle('C13')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A13','ECODE');
                    $excel->getActiveSheet()->setCellValue('B13','Employee Name');
                    $excel->getActiveSheet()->setCellValue('C13','Accumulated 13TH Month Pay');

                    $grand_total_13thmonth=0;

                    $i = 14;
                    $a = 1;
                    if(count($get13thmonth_pay)!=0 || count($get13thmonth_pay)!=null){

                        foreach($get13thmonth_pay as $row){

                            if($row->bank_account_isprocess == 0){

                            $excel->getActiveSheet()
                                    ->getStyle('A'.$i.':B'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                            $excel->getActiveSheet()
                                    ->getStyle('C'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);                                    
                            
                            $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                            $total_13thmonth = ((($row->total_13thmonth+$row->retro+$row->dayswithpayamt)-($row->total_days_wout_pay_amt))/$factor);
                            $grand_total_13thmonth += $total_13thmonth;


                            $excel->getActiveSheet()->setCellValue('A'.$i,$row->ecode);
                            $excel->getActiveSheet()->setCellValue('B'.$i,$row->fullname);
                            $excel->getActiveSheet()->setCellValue('C'.$i,number_format($total_13thmonth,2));

                            $i++;
                            $a++;

                            }}

                            $excel->getActiveSheet()
                                    ->getStyle('A'.$i.':C'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->getStyle('C'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 
                            $excel->getActiveSheet()->getStyle('A'.$i.':C'.$i)->getFont()->setBold(TRUE);

                            $excel->getActiveSheet()->setCellValue('B'.$i,'Total : ');
                            $excel->getActiveSheet()->setCellValue('C'.$i,number_format($grand_total_13thmonth,2));

                        }else{
                                $excel->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                                $excel->getActiveSheet()->mergeCells('A'.$i.':C'.$i);
                                $excel->getActiveSheet()->setCellValue('A'.$i,'No Result');
                                $i++;
                        }




                            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

                            $filename="EMPLOYEE 13TH MONTH PAY - Cash (".$year.")";

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

                case 'export_employee_13thmonth_pay_check_register':
                    $excel = $this->excel;
                    
                    $payment = $filter_value;
                    $year = $filter_value2;
                    $branch = $filter_value3;
                    $department = $type;
                    $status = $filter_value4;

                    $m_13thmonth = $this->Emp_13thmonth_model;

                    $year_setup = $this->RefYearSetup_model->getYearSetup($year);
                    $start_13thmonth_date = ''; $end_13thmonth_date = ''; $factor = 0;

                    if (count($year_setup) > 0){
                        $start_13thmonth_date = $year_setup[0]->start_13thmonth_date;
                        $end_13thmonth_date = $year_setup[0]->end_13thmonth_date;
                        $factor = $year_setup[0]->factor_setup;
                    }else{
                        $start_13thmonth_date = '01-01-'.$year;
                        $end_13thmonth_date = '12-31-'.$year;
                        $factor = 12;
                    }

                    $get13thmonth_pay=$m_13thmonth->get_13thmonth_processed($year,$branch,$department,null,$status);
                        
                    if($branch!="all"){
                        $getbranch=$this->RefBranch_model->get_list($branch,'ref_branch.branch');
                        $get_branch = $getbranch[0]->branch;
                    }
                    else{
                        $get_branch = "All";
                    }

                    if($department!="all"){
                        $getdepartment=$this->RefDepartment_model->get_list($department,'ref_department.department');
                        $get_department = $getdepartment[0]->department;
                    }
                    else{
                        $get_department = "All";
                    }

                    $getcompany=$this->GeneralSettings_model->get_list(
                    null,
                    'company_setup.*'
                    );
                    $company=$getcompany[0];

                    $excel->setActiveSheetIndex(0);
                    $excel->getActiveSheet()->setTitle("13TH MONTH PAY ".$year);

                    $excel->getActiveSheet()->mergeCells('A1:D1');
                    $excel->getActiveSheet()->mergeCells('A2:D2');
                    $excel->getActiveSheet()->mergeCells('A3:D3');
                    $excel->getActiveSheet()->mergeCells('A4:D4');

                    $excel->getActiveSheet()->setCellValue('A1',$company->company_name)
                                            ->setCellValue('A2',$company->address)
                                            ->setCellValue('A3',$company->contact_no)
                                            ->setCellValue('A4',$company->email_address);

                    $excel->getActiveSheet()->mergeCells('A5:D5');

                    $excel->getActiveSheet()->getStyle('A6'.':'.'D11')->getFont()->setBold(TRUE);
                    $excel->getActiveSheet()->mergeCells('A6:D6');
                    $excel->getActiveSheet()->mergeCells('A7:D7');
                    $excel->getActiveSheet()->mergeCells('A8:D8');
                    $excel->getActiveSheet()->mergeCells('A9:D9');
                    $excel->getActiveSheet()->mergeCells('A10:D10');
                    $excel->getActiveSheet()->mergeCells('A11:D11');

                    $excel->getActiveSheet()->setCellValue('A6','13th Month Pay')
                                            ->setCellValue('A7','Year : '.$year)
                                            ->setCellValue('A8','Branch : '.$get_branch)
                                            ->setCellValue('A9','Department : '.$get_department)
                                            ->setCellValue('A10','Payment Type : Bank')
                                            ->setCellValue('A11','Date : '.date('m/d/Y'));
                    
                    $excel->getActiveSheet()->getStyle('A13:D13')->getFont()->setBold(TRUE);

                    $excel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
                    $excel->getActiveSheet()->getColumnDimension('B')->setWidth('35');
                    $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                    $excel->getActiveSheet()->getColumnDimension('D')->setWidth('30');

                    $excel->getActiveSheet()
                            ->getStyle('D13')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $excel->getActiveSheet()->setCellValue('A13','ECODE');
                    $excel->getActiveSheet()->setCellValue('B13','Employee Name');
                    $excel->getActiveSheet()->setCellValue('C13','Bank Account #');
                    $excel->getActiveSheet()->setCellValue('D13','Accumulated 13TH Month Pay');

                    $grand_total_13thmonth=0;

                    $i = 14;
                    $a = 1;
                    if(count($get13thmonth_pay)!=0 || count($get13thmonth_pay)!=null){

                        foreach($get13thmonth_pay as $row){

                            if($row->bank_account_isprocess == 1){

                            $excel->getActiveSheet()
                                    ->getStyle('A'.$i.':C'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                            $excel->getActiveSheet()
                                    ->getStyle('D'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);                                    
                            
                            $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                            $total_13thmonth = ((($row->total_13thmonth+$row->retro+$row->dayswithpayamt)-($row->total_days_wout_pay_amt))/$factor);
                            $grand_total_13thmonth += $total_13thmonth;


                            $excel->getActiveSheet()->setCellValue('A'.$i,$row->ecode);
                            $excel->getActiveSheet()->setCellValue('B'.$i,$row->fullname);
                            $excel->getActiveSheet()->setCellValue('C'.$i,$row->bank_account);
                            $excel->getActiveSheet()->setCellValue('D'.$i,number_format($total_13thmonth,2));

                            $i++;
                            $a++;

                            }}

                            $excel->getActiveSheet()
                                    ->getStyle('A'.$i.':D'.$i)
                                    ->getAlignment()
                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 
                            $excel->getActiveSheet()->getStyle('A'.$i.':D'.$i)->getFont()->setBold(TRUE);

                            $excel->getActiveSheet()->setCellValue('C'.$i,'Total : ');
                            $excel->getActiveSheet()->setCellValue('D'.$i,number_format($grand_total_13thmonth,2));

                        }else{
                                $excel->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  

                                $excel->getActiveSheet()->mergeCells('A'.$i.':D'.$i);
                                $excel->getActiveSheet()->setCellValue('A'.$i,'No Result');
                                $i++;
                        }




                            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

                            $filename="EMPLOYEE 13TH MONTH PAY - Bank (".$year.")";

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

                        case 'employee-compensation':

                            $year = $filter_value2;
                            $year_setup = $this->RefYearSetup_model->getYearSetup($year);
                            $start_13thmonth_date = ''; $end_13thmonth_date = ''; $factor = 0;

                            if (count($year_setup) > 0){
                                $factor = $year_setup[0]->factor_setup;
                            }else{
                                $factor = 12;
                            }

                            $data['employee_compensation']=$this->PayrollReports_model->get_employee_compensation($filter_value,$filter_value2,$factor);
                            $data['employeename']=$this->Employee_model->get_list(
                            $filter_value,
                            'CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name,ecode'
                            );
                            $data['date']=$filter_value2;
                            $getcompany=$this->GeneralSettings_model->get_list(
                            null,
                            'company_setup.*'
                            );
                            $data['company']=$getcompany[0];

                            echo $this->load->view('template/employee_compensation_html',$data,TRUE);
                            // echo json_encode($data);
                        break;

                        case 'employee-deduction-history':
                            $data['employee_deduction']=$this->PayrollReports_model->get_employee_deduction_history($filter_value,$filter_value2);
                            $data['employeename']=$this->Employee_model->get_list(
                            $filter_value,
                            'CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name,ecode'
                            );
                            $data['date']=$filter_value2;
                            $getcompany=$this->GeneralSettings_model->get_list(
                            null,
                            'company_setup.*'
                            );
                            $data['company']=$getcompany[0];
                            echo $this->load->view('template/employee_deduction_history_html',$data,TRUE);
                            // echo json_encode($data);
                        break;

                        case 'date':
                            date_default_timezone_set("Asia/Taipei");
                            echo "The time is " .date("Y/m/d");
                        break;

        }
    }
}
