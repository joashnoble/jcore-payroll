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


    function layout($layout=null,$filter_value=null,$filter_value2=null,$filter_value3=null,$type=null){




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
                            $excel->getActiveSheet()->getColumnDimension('A')->setWidth('15');
                            $excel->getActiveSheet()->getColumnDimension('B')->setWidth('35');
                            $excel->getActiveSheet()->getColumnDimension('C')->setWidth('10');
                        }else{
                            $excel->getActiveSheet()->getColumnDimension('A')->setWidth('35');
                            $excel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
                        }
                        
                        $excel->getActiveSheet()
                                ->getStyle($end.'10')
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        if ($type == "non-cash"){
                            $excel->getActiveSheet()->setCellValue('A10','Account #');
                            $excel->getActiveSheet()->setCellValue('B10','Employee');
                            $excel->getActiveSheet()->setCellValue('C10','Net Pay');
                        }else{
                            $excel->getActiveSheet()->setCellValue('A10','Employee');
                            $excel->getActiveSheet()->setCellValue('B10','Net Pay');
                        }

                        $i = 11;
                        $grandtotal=0;

                        if(count($getpayrollregister)!=0 || count($getpayrollregister)!=null){

                            foreach($getpayrollregister as $row){

                                $net_pay = $netpay=$row->gross_pay-($row->days_wout_pay_amt+$row->minutes_late_amt+$row->sss_deduction+$row->philhealth_deduction+$row->pagibig_deduction+$row->wtax_deduction+$row->sssloan_deduction+$row->pagibigloan_deduction+$row->coopcontribution_deduction+$row->cooploan_deduction+$row->cashadvance_deduction+$row->calamityloan_deduction+$row->other_deductions);

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
                                    $excel->getActiveSheet()->setCellValue('A'.$i,$row->bank_account);
                                    $excel->getActiveSheet()->setCellValue('B'.$i,$row->fullname);
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

                        //show only inside grid with menu button

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
                        if($filter_value2==null || $filter_value2=='null'){
                            $data['payroll_register_summary']='';
                        }else{
                             $data['payroll_register_summary']=$getpayrollregsummary;

                        }
                        

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
                       
                        $data['get_department']=$get_department;
                        $data['get_period'] = $get_period;

                        $getcompany=$this->GeneralSettings_model->get_list(
                        null,
                        'company_setup.*'
                        );
                        $data['company']=$getcompany[0];

                            echo $this->load->view('template/employee_payroll_summary_html',$data,TRUE);

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

                     case 'employeee-13thmonth-pay': //
                        //show only inside grid with menu button
                        if($filter_value!="all" AND $filter_value2!="all"){
                            $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay($filter_value,$filter_value2,$filter_value3);
                            /*echo json_encode($getpayrollregsummary);*/
                        }
                        if($filter_value=="all" AND $filter_value2!="all"){
                            $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay_year_filter($filter_value2,$filter_value3);
                        }
                        if($filter_value!="all" AND $filter_value2=="all"){
                            $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay_employee_filter($filter_value,$filter_value3);
                        }
                        if($filter_value=="all" AND $filter_value2=="all"){
                            $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay_wofilter($filter_value3);
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
                        $data['yearfilter']=$filter_value2;
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

                        case 'employee-compensation':
                            $data['employee_compensation']=$this->PayrollReports_model->get_employee_compensation($filter_value,$filter_value2);
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