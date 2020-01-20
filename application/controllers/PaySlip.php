<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payslip extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        if($this->session->userdata('user_id') == FALSE) {
            redirect('../login');
        }
        if($this->session->userdata('right_payslip_view') == 0 || $this->session->userdata('right_payslip_view') == null) {
            redirect('../Dashboard');
        }
        else{

        }
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
        $this->load->library('M_pdf');


    }
    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['_rights'] = $this->load->view('template/elements/rights', '', TRUE);
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

                // 'employee_list.is_deleted'=>FALSE
                if($ref_department_id=="all" AND $ref_branch_id=="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE);
                }
                if($ref_department_id=="all" AND $ref_branch_id!="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'emp_rates_duties.ref_branch_id'=>$ref_branch_id);

                }
                if($ref_department_id!="all" AND $ref_branch_id=="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'emp_rates_duties.ref_department_id'=>$ref_department_id);

                }
                if($ref_department_id!="all" AND $ref_branch_id!="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'emp_rates_duties.ref_department_id'=>$ref_department_id,'emp_rates_duties.ref_branch_id'=>$ref_branch_id);

                }
                $response['data']=$this->Payslip_model->get_list(
                    $test,
                    'pay_slip.payslip_no,pay_slip.net_pay,pay_slip.pay_slip_id,employee_list.*,CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name',
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


    function layout($layout=null,$filter_value=null,$filter_value2=null,$type=null){




        switch($layout){
            //****************************************************
            case 'pay-slip': //
                        $getpayslip=$this->Payslip_model->get_list(
                        array('pay_slip.pay_slip_id'=>$filter_value),
                            'pay_slip.*,
                            daily_time_record.*,
                            employee_list.*,
                            refpayperiod.pay_period_start,
                            refpayperiod.pay_period_end,
                            CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name,
                            ref_payment_type.payment_type,
                            ref_department.department,
                            refgroup.group_desc,
                            ref_branch.branch,
                            ref_branch.description',
                        array(
                             array('daily_time_record','daily_time_record.dtr_id=pay_slip.dtr_id','left'),
                             array('employee_list','employee_list.employee_id=daily_time_record.employee_id','left'),
                             array('emp_rates_duties','emp_rates_duties.emp_rates_duties_id=employee_list.emp_rates_duties_id','left'),
                             array('ref_payment_type','ref_payment_type.ref_payment_type_id=emp_rates_duties.ref_payment_type_id','left'),
                             array('ref_department','ref_department.ref_department_id=emp_rates_duties.ref_department_id','left'),
                             array('ref_branch','ref_branch.ref_branch_id=emp_rates_duties.ref_branch_id','left'),
                             array('refgroup','refgroup.group_id=emp_rates_duties.group_id','left'),
                             array('refpayperiod','refpayperiod.pay_period_id=daily_time_record.pay_period_id','left'),
                             )
                        );

                        // DEDUCTIONS & EARNINGS
                        $deductions=$this->PaySlip_deduction_model->get_payslip_deductions($filter_value);
                        $earnings=$this->PaySlip_earning_model->get_payslip_earnings($filter_value);

                        //COMPANY INFO GET
                        $getcompany=$this->GeneralSettings_model->get_list(
                        null,
                        'company_setup.*'
                        );

                        $data['payslip']=$getpayslip[0];
                        $data['deductions']=$deductions;
                        $data['earnings']=$earnings;
                        $data['reg_ot_hrs']=$getpayslip[0]->ot_reg+$getpayslip[0]->ot_reg_reg_hol+$getpayslip[0]->ot_reg_spe_hol;
                        $data['sun_ot_hrs']=$getpayslip[0]->ot_sun+$getpayslip[0]->ot_sun_reg_hol+$getpayslip[0]->ot_sun_spe_hol;
                        $data['spe_hol_hrs']=$getpayslip[0]->spe_hol+$getpayslip[0]->sun_spe_hol;
                        $data['reg_hol_hrs']=$getpayslip[0]->reg_hol+$getpayslip[0]->sun_reg_hol;
                        $data['nsd_reg_hrs']=$getpayslip[0]->nsd_reg+$getpayslip[0]->nsd_reg_reg_hol+$getpayslip[0]->nsd_reg_spe_hol;
                        $data['nsd_sun_hrs']=$getpayslip[0]->nsd_sun+$getpayslip[0]->nsd_sun_reg_hol+$getpayslip[0]->nsd_sun_spe_hol;
                        $data['company']=$getcompany[0];
                        
                        //show only inside grid with menu button
                        if($type=='fullview'||$type==null){
                            echo $this->load->view('template/pay_slip_content_html',$data,TRUE);
                        }

                        //show only inside grid without menu button
                        if($type=='contentview'){
                            echo $this->load->view('template/pay_slip_content_html',$data,TRUE);
                        }

                        //download pdf
                        if($type=='pdf'){
                            $pdfFilePath = $getpayslip[0]->full_name."-".$getpayslip[0]->pay_period_start."-".$getpayslip[0]->pay_period_end.".pdf"; //generate filename base on id
                            $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                            $content=$this->load->view('template/pay_slip_content_html',$data,TRUE); //load the template
                            $pdf->setFooter('{PAGENO}');
                            $pdf->WriteHTML($content);
                            //download it.
                            $pdf->Output($pdfFilePath,"D");
                        }

                        //preview on browser
                        if($type=='preview'){
                            $pdfFilePath = $getpayslip[0]->full_name.".pdf"; //generate filename base on id
                            $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                            $content=$this->load->view('template/pay_slip_content_html',$data,TRUE); //load the template
                            $pdf->setFooter('{PAGENO}');
                            $pdf->WriteHTML($content);
                            //download it.
                            $pdf->SetJS('this.print();');
                            $pdf->Output();
                        }

                        break;


            case 'pay-slip-printall':

                    $pay_period_id = $filter_value;
                    $department_id = $filter_value2;
                    $branch_id = $type;

                    $data["payslips"]=$this->Payslip_model->get_payslip_all($pay_period_id,$department_id,$branch_id);
                    $data["earnings"]=$this->PaySlip_earning_model->get_payslip_earnings(null,$pay_period_id);
                    $data["deductions"]=$this->PaySlip_deduction_model->get_payslip_deductions(null,$pay_period_id);

                    echo $this->load->view('template/pay_slip_content_printall_html',$data,TRUE);
                   break;

            case 'emailPayslip':

                $m_employee = $this->Employee_model;
                $m_general = $this->GeneralSettings_model;

                $getpayslip=$this->Payslip_model->get_list(
                        array('pay_slip.pay_slip_id'=>$filter_value),
                            'pay_slip.*,
                            daily_time_record.*,
                            employee_list.*,
                            CONCAT(DATE_FORMAT(refpayperiod.pay_period_start, "%m/%d/%Y")," ~ ",DATE_FORMAT(refpayperiod.pay_period_end, "%m/%d/%Y")) as payperiod,
                            CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name,
                            ref_payment_type.payment_type,
                            ref_department.department,
                            refgroup.group_desc,
                            ref_branch.branch,
                            ref_branch.description',
                        array(
                             array('daily_time_record','daily_time_record.dtr_id=pay_slip.dtr_id','left'),
                             array('employee_list','employee_list.employee_id=daily_time_record.employee_id','left'),
                             array('emp_rates_duties','emp_rates_duties.emp_rates_duties_id=employee_list.emp_rates_duties_id','left'),
                             array('ref_payment_type','ref_payment_type.ref_payment_type_id=emp_rates_duties.ref_payment_type_id','left'),
                             array('ref_department','ref_department.ref_department_id=emp_rates_duties.ref_department_id','left'),
                             array('ref_branch','ref_branch.ref_branch_id=emp_rates_duties.ref_branch_id','left'),
                             array('refgroup','refgroup.group_id=emp_rates_duties.group_id','left'),
                             array('refpayperiod','refpayperiod.pay_period_id=daily_time_record.pay_period_id','left'),
                             )
                        );

                    // DEDUCTIONS & EARNINGS
                    $deductions=$this->PaySlip_deduction_model->get_payslip_deductions($filter_value);
                    $earnings=$this->PaySlip_earning_model->get_payslip_earnings($filter_value);

                    //COMPANY INFO GET
                    $getcompany=$this->GeneralSettings_model->get_list(
                    null,
                    'company_setup.*'
                    );

                    $data['payslip']=$getpayslip[0];
                    $data['deductions']=$deductions;
                    $data['earnings']=$earnings;
                    $data['reg_ot_hrs']=$getpayslip[0]->ot_reg+$getpayslip[0]->ot_reg_reg_hol+$getpayslip[0]->ot_reg_spe_hol;
                    $data['sun_ot_hrs']=$getpayslip[0]->ot_sun+$getpayslip[0]->ot_sun_reg_hol+$getpayslip[0]->ot_sun_spe_hol;
                    $data['spe_hol_hrs']=$getpayslip[0]->spe_hol+$getpayslip[0]->sun_spe_hol;
                    $data['reg_hol_hrs']=$getpayslip[0]->reg_hol+$getpayslip[0]->sun_reg_hol;
                    $data['nsd_reg_hrs']=$getpayslip[0]->nsd_reg+$getpayslip[0]->nsd_reg_reg_hol+$getpayslip[0]->nsd_reg_spe_hol;
                    $data['nsd_sun_hrs']=$getpayslip[0]->nsd_sun+$getpayslip[0]->nsd_sun_reg_hol+$getpayslip[0]->nsd_sun_spe_hol;
                    $data['company']=$getcompany[0];

                    ## Get Employee Info
                    $email = $getpayslip[0]->email_address;
                    $full_name = $getpayslip[0]->full_name;
                    $pay_period = $getpayslip[0]->payperiod;
                    $grosspay = $getpayslip[0]->gross_pay;
                    $totaldeduction = $getpayslip[0]->total_deductions;
                    $netpay = $getpayslip[0]->net_pay;

                    $subject = 'Payslip of '.$full_name;

                    $email_settings = $m_general->get_list();
                    $company_email = $email_settings[0]->email_address;
                    $company_password = $email_settings[0]->email_password;
                    $company_name = $email_settings[0]->company_name;

                    $year = date('Y');
                    $date = date('m-d-Y');

                    $message = '<div style="width:85%;background:#F5F5F5;padding: 50px;font-family: arial;">
                                    <div style="border: 1px solid #CFD8DC;">
                                        <div style="padding: 20px;background: #fff; font-weight: bold;font-size: 13pt;border-top: 5px solid #263238;">
                                            '.$company_name.'
                                        </div>
                                        <div style="background: #263238; color: #fff;padding: 10px;">
                                            '.$subject.'
                                        </div>
                                        <div style="background: #fff; padding: 15px;">
                                            <p>Good day, '.$full_name.'! <span style="text-align: right;float:right;">'.$date.'</span> </p>
                                            <p style="text-align: justify;">This email contains your payslip from '.$pay_period.' with a gross pay of '.number_format($grosspay,2).', total deduction of '.number_format($totaldeduction,2).' and a total net pay of '.number_format($netpay,2).'. Please see attachment as your reference of your payslip.<br /><br />


                                            If you have any concerns or questions, do not hesitate to contact us. Thank you.
                                        </div>
                                        <div style="background: #F5F5F5;">
                                            <center>
                                                <p style="font-size: 8pt;">Copyright &copy; '.$year.' '.$company_name.'</p>
                                            </center>
                                        </div>
                                    </div>
                                </div>';

                    $file_name=$getpayslip[0]->full_name." (".$getpayslip[0]->payperiod.")";
                    $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                    $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                    $content=$this->load->view('template/pay_slip_content_email_html',$data,TRUE); //load the template
                    $pdf->WriteHTML($content);
                    //download it.
                            
                    $content = $pdf->Output('', 'S');

                    // Set SMTP Configuration
                    $emailConfig = array(
                        'protocol' => 'smtp', 
                        'smtp_host' => 'ssl://smtp.googlemail.com', 
                        'smtp_port' => 465, 
                        'smtp_user' => $company_email,
                        'smtp_pass' => $company_password, 
                        'mailtype' => 'html', 
                        'charset' => 'iso-8859-1'
                    );

                    // Set your email information
                    
                    $from = array(
                        'email' => $company_email,
                        'name' => $company_name
                    );

                    // Load CodeIgniter Email library
                    $this->load->library('email', $emailConfig);
                    // Sometimes you have to set the new line character for better result
                    $this->email->set_newline("\r\n");
                    // Set email preferences
                    $this->email->from($company_email, $company_name);
                    $this->email->to($email);
                    $this->email->subject($subject);
                    $this->email->message($message);
                    $this->email->attach($content, 'attachment', $pdfFilePath , 'application/pdf');
                    $this->email->set_mailtype("html");

                    if (!$this->email->send()) {
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

            break;          

            case 'emailAllPayslip':

                $m_employee = $this->Employee_model;
                $m_general = $this->GeneralSettings_model;

                $pay_period_id = $filter_value;
                $department_id = $filter_value2;
                $branch_id = $type;

                $info = $this->Payslip_model->get_employee_payslip($pay_period_id);
    
                if (count($info) > 0){

                for ($i=0; $i < count($info); $i++) { 
                    
                    $getpayslip=$this->Payslip_model->get_list(
                        array('pay_slip.pay_slip_id'=>$info[$i]->pay_slip_id),
                            'pay_slip.*,
                            daily_time_record.*,
                            employee_list.*,
                            refpayperiod.pay_period_start,
                            refpayperiod.pay_period_end,
                            CONCAT(DATE_FORMAT(refpayperiod.pay_period_start, "%m/%d/%Y")," ~ ",DATE_FORMAT(refpayperiod.pay_period_end, "%m/%d/%Y")) as payperiod,
                            CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name,
                            ref_payment_type.payment_type,
                            ref_department.department,
                            refgroup.group_desc,
                            ref_branch.branch,
                            ref_branch.description',
                        array(
                             array('daily_time_record','daily_time_record.dtr_id=pay_slip.dtr_id','left'),
                             array('employee_list','employee_list.employee_id=daily_time_record.employee_id','left'),
                             array('emp_rates_duties','emp_rates_duties.emp_rates_duties_id=employee_list.emp_rates_duties_id','left'),
                             array('ref_payment_type','ref_payment_type.ref_payment_type_id=emp_rates_duties.ref_payment_type_id','left'),
                             array('ref_department','ref_department.ref_department_id=emp_rates_duties.ref_department_id','left'),
                             array('ref_branch','ref_branch.ref_branch_id=emp_rates_duties.ref_branch_id','left'),
                             array('refgroup','refgroup.group_id=emp_rates_duties.group_id','left'),
                             array('refpayperiod','refpayperiod.pay_period_id=daily_time_record.pay_period_id','left'),
                             )
                        );

                    // DEDUCTIONS & EARNINGS
                    $deductions=$this->PaySlip_deduction_model->get_payslip_deductions($info[$i]->pay_slip_id);
                    $earnings=$this->PaySlip_earning_model->get_payslip_earnings($info[$i]->pay_slip_id);

                    //COMPANY INFO GET
                    $getcompany=$this->GeneralSettings_model->get_list(
                    null,
                    'company_setup.*'
                    );

                    $data['payslip']=$getpayslip[0];
                    $data['deductions']=$deductions;
                    $data['earnings']=$earnings;
                    $data['reg_ot_hrs']=$getpayslip[0]->ot_reg+$getpayslip[0]->ot_reg_reg_hol+$getpayslip[0]->ot_reg_spe_hol;
                    $data['sun_ot_hrs']=$getpayslip[0]->ot_sun+$getpayslip[0]->ot_sun_reg_hol+$getpayslip[0]->ot_sun_spe_hol;
                    $data['spe_hol_hrs']=$getpayslip[0]->spe_hol+$getpayslip[0]->sun_spe_hol;
                    $data['reg_hol_hrs']=$getpayslip[0]->reg_hol+$getpayslip[0]->sun_reg_hol;
                    $data['nsd_reg_hrs']=$getpayslip[0]->nsd_reg+$getpayslip[0]->nsd_reg_reg_hol+$getpayslip[0]->nsd_reg_spe_hol;
                    $data['nsd_sun_hrs']=$getpayslip[0]->nsd_sun+$getpayslip[0]->nsd_sun_reg_hol+$getpayslip[0]->nsd_sun_spe_hol;
                    $data['company']=$getcompany[0];

                    ## Get Employee Info
                    $email = $getpayslip[0]->email_address;
                    $full_name = $getpayslip[0]->full_name;

                    $pay_period = $getpayslip[0]->payperiod;

                    $grosspay = $getpayslip[0]->gross_pay;
                    $totaldeduction = $getpayslip[0]->total_deductions;
                    $netpay = $getpayslip[0]->net_pay;

                    $subject = 'Payslip of '.$full_name;

                    $email_settings = $m_general->get_list();
                    $company_email = $email_settings[0]->email_address;
                    $company_password = $email_settings[0]->email_password;
                    $company_name = $email_settings[0]->company_name;

                    // Set SMTP Configuration
                    $emailConfig = array(
                        'protocol' => 'smtp', 
                        'smtp_host' => 'ssl://smtp.googlemail.com', 
                        'smtp_port' => 465, 
                        'smtp_user' => $company_email,
                        'smtp_pass' => $company_password, 
                        'mailtype' => 'html', 
                        'charset' => 'iso-8859-1'
                    );

                    $year = date('Y');
                    $date = date('m-d-Y');

                    $message = '<div style="width:85%;background:#F5F5F5;padding: 50px;font-family: arial;">
                                    <div style="border: 1px solid #CFD8DC;">
                                        <div style="padding: 20px;background: #fff; font-weight: bold;font-size: 13pt;border-top: 5px solid #263238;">
                                            '.$company_name.'
                                        </div>
                                        <div style="background: #263238; color: #fff;padding: 10px;">
                                            '.$subject.'
                                        </div>
                                        <div style="background: #fff; padding: 15px;">
                                            <p>Good day, '.$full_name.'! <span style="text-align: right;float:right;">'.$date.'</span> </p>
                                            <p style="text-align: justify;">This email contains your payslip from '.$pay_period.' with a gross pay of '.number_format($grosspay,2).', total deduction of '.number_format($totaldeduction,2).' and a total net pay of '.number_format($netpay,2).'. Please see attachment as your reference of your payslip. <br/><br />

                                            If you have any concerns or questions, do not hesitate to contact us. Thank you.
                                        </div>
                                        <div style="background: #F5F5F5;">
                                            <center>
                                                <p style="font-size: 8pt;">Copyright &copy; '.$year.' '.$company_name.'</p>
                                            </center>
                                        </div>
                                    </div>
                                </div>';

                $file_name=$getpayslip[0]->full_name." (".$getpayslip[0]->payperiod.")";
                $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                $content=$this->load->view('template/pay_slip_content_email_html',$data,TRUE); //load the template
                $pdf->WriteHTML($content);
                //download it.
                            
                $content = $pdf->Output('', 'S');

                        // Load CodeIgniter Email library
                        $this->load->library('email', $emailConfig);
                        // Sometimes you have to set the new line character for better result
                        $this->email->set_newline("\r\n");
                        // Set email preferences
                        $this->email->from($company_email, $company_name);
                        $this->email->to($email);
                        $this->email->subject($subject);
                        $this->email->message($message);
                        $this->email->attach($content, 'attachment', $pdfFilePath , 'application/pdf');
                        $this->email->set_mailtype("html");
                        $this->email->send();
                        $this->email->clear(TRUE);

                    }

                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Email Sent successfully.';

                    echo json_encode($response);

                }else{
                    $response['title']='Try Again!';
                    $response['stat']='error';
                    $response['msg']='Cannot send an email. No Email Address found.';
                    echo json_encode($response);
                }
            

            break;                        

            case 'payroll-register-summary': //
                        //show only inside grid with menu button
                        if($filter_value=="all" AND $filter_value2=="all"){
                            $filter_array=null;
                        }
                        if($filter_value=="all" AND $filter_value2!="all"){
                            $filter_array=array('refpayperiod.month_id'=>$filter_value2);
                        }
                        if($filter_value!="all" AND $filter_value2=="all"){
                            $filter_array=array('ref_branch.ref_branch_id'=>$filter_value,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value!="all" AND $filter_value2!="all"){

                        }
                        $getpayrollregsummary=$this->Payslip_model->get_list(
                        $filter_array,
                        'pay_slip.*,SUM(reg_pay) as total_reg_pay,SUM(sun_pay+reg_hol_pay+spe_hol_pay+reg_ot_pay+sun_ot_pay) as total_hol_pay_sunday,
                        SUM(reg_nsd_pay+sun_nsd_pay) as total_nsd_amount,
                        SUM(pay_slip.minutes_late_amt) as total_minutes_late,ref_branch.branch',
                        array(
                             array('daily_time_record','daily_time_record.dtr_id=pay_slip.dtr_id','left'),
                             array('emp_rates_duties','emp_rates_duties.employee_id=daily_time_record.employee_id','left'),
                             array('ref_branch','ref_branch.ref_branch_id=emp_rates_duties.ref_branch_id','left'),
                             array('refpayperiod','refpayperiod.pay_period_id=daily_time_record.pay_period_id','left'),
                             )
                        );
                        /*echo $branch;*/
                        //GET SALARY ADJUSTMENTS
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
                        );

                       /*echo json_encode($gettotalotherdeduction);*/


                        $data['payroll_register_summary']=$getpayrollregsummary[0];
                        $data['total_adjustment_amount']=$getadjustment[0];
                        $data['total_other_pay']=$getotherpay[0];
                        $data['total_sss_deduct']=$gettotalsssdeduction[0];
                        $data['total_philhealth_deduct']=$gettotalphilhealthdeduction[0];
                        $data['total_pagibig_deduct']=$gettotalpagibigdeduction[0];
                        $data['total_withholdingtax_deduct']=$gettotalwithholdingdeduction[0];
                        $data['total_sss_loan']=$gettotalsssloandeduction[0];
                        $data['total_pagibig_loan']=$gettotalpagibigloandeduction[0];
                        $data['total_coop_loan']=$gettotalcooploandeduction[0];
                        $data['total_coop_contribution']=$gettotalcoopcontributiondeduction[0];
                        $data['total_other_deduction']=$gettotalotherdeduction[0];

                        if($type=='fullview'||$type==null){
                            echo $this->load->view('template/payroll_register_summary_html',$data,TRUE);
                            //echo $this->load->view('template/dr_content_menus',$data,TRUE);
                        }

                        //show only inside grid without menu button
                        if($type=='contentview'){
                            echo $this->load->view('template/payroll_register_summary_html',$data,TRUE);
                        }


                        //download pdf
                        if($type=='pdf'){
                            $pdfFilePath = "PR-Summary-".$getpayrollregsummary[0]->branch.".pdf"; //generate filename base on id
                            $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                            $content=$this->load->view('template/payroll_register_summary',$data,TRUE); //load the template
                            $pdf->setFooter('{PAGENO}');
                            $pdf->WriteHTML($content);
                            //download it.
                            $pdf->Output($pdfFilePath,"D");

                        }

                        //preview on browser
                        if($type=='preview'){
                            $pdfFilePath = "PR-Summary-".$getpayrollregsummary[0]->branch.".pdf"; //generate filename base on id
                            $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                            $content=$this->load->view('template/payroll_register_summary',$data,TRUE); //load the template
                            $pdf->setFooter('{PAGENO}');
                            $pdf->WriteHTML($content);
                            //download it.
                            /*$pdf->SetJS('this.print();');*/
                            $pdf->Output();
                        }

              break;

              case 'pay-slip-delete': //
                    $pay_slip_id = $this->input->post('pay_slip_id', TRUE);

                    // echo $pay_slip_id;
                    $this->db->where('pay_slip_id', $pay_slip_id);
                    $this->db->delete('pay_slip');
                    //deleting deductions based on foreign key
                    $this->db->where('pay_slip_id', $pay_slip_id);
                    $this->db->delete('pay_slip_deductions');
                    //deleting earnings based on foreign key
                    $this->db->where('pay_slip_id', $pay_slip_id);
                    $this->db->delete('pay_slip_other_earnings');
              break;

              case 'pay-slip-print-all':
                    $data['payslips']=$this->Payslip_model->get_payslip($filter_value,$filter_value2,$type);
                    echo $this->load->view('template/pay_slip_content_printall_html',$data,TRUE);
              break;

        }
    }
}
