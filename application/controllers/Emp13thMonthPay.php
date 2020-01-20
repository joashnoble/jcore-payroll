<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp13thMonthPay extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        if($this->session->userdata('right_13thmonthpay_view') == 0 || $this->session->userdata('right_13thmonthpay_view') == null) {
            redirect('../Dashboard');
        }
        $this->load->model('Employee_model');
        $this->load->model('SchedEmployee_model');
        $this->load->model('RefSchedPay_model');
        $this->load->model('SchedRefShift_model');
        $this->load->model('RefPayPeriod_model');
        $this->load->model('SchedDTR_model');
        $this->load->model('RefBranch_model');
        $this->load->model('RefDepartment_model');
        $this->load->model('PayrollReports_model');
        $this->load->model('Emp_13thmonth_model');
        $this->load->model('RefYearSetup_model');
        $this->load->model('GeneralSettings_model');

        $this->load->library('M_pdf');        
    }
    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['loader'] = $this->load->view('template/elements/loader', '', TRUE);
        $data['loaderscript'] = $this->load->view('template/elements/loaderscript', '', TRUE);
        $data['_rights'] = $this->load->view('template/elements/rights', '', TRUE);
        $data['branch'] = $this->RefBranch_model->get_list('is_deleted = 0');
        $data['departments'] = $this->RefDepartment_model->get_list('is_deleted = 0');
        $data['employee'] = $this->Employee_model->get_list('employee_list.is_deleted=0','employee_list.employee_id,CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name',null,'full_name ASC');
        $data['title'] = '13th Month Pay';

        $this->load->view('emp_13thmonthpay_view', $data);
    }


    function schedule($transaction=null,$filter_value=null,$filter_value2=null,$type=null){




        switch($transaction){

            case 'list':

                $m_13thmonth = $this->Emp_13thmonth_model;

                $year = $this->input->post('year', TRUE);
                $ref_branch_id = $this->input->post('ref_branch_id', TRUE);
                $ref_department_id = $this->input->post('ref_department_id', TRUE);

                $response['data'] = $m_13thmonth->get_13thmonth_processed($year,$ref_branch_id,$ref_department_id);
                echo json_encode($response);
                break;


            case 'print_13thmonth':

                $m_13thmonth = $this->Emp_13thmonth_model;
                $emp_13thmonth_id = $filter_value;

                $data['data'] = $m_13thmonth->get_13thmonth_processed(null,'all','all',$emp_13thmonth_id)[0];

                if($type=='fullview'||$type==null){
                    echo $this->load->view('template/pay_13thmonth_content_html',$data,TRUE);
                }

                break;


            case 'print_13thmonth_all':

                $m_13thmonth = $this->Emp_13thmonth_model;

                $year = $filter_value;
                $ref_branch_id = $filter_value2;
                $ref_department_id = $type;

                $data['data']=$m_13thmonth->get_13thmonth_processed($year,$ref_branch_id,$ref_department_id);

                echo $this->load->view('template/pay_13thmonth_content_all_html',$data,TRUE);
                break;

            case 'process_13thmonth':
                

                $year = $this->input->post('year', TRUE);
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

                $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay_register_filter('all','all',$start_13thmonth_date,$end_13thmonth_date,1);

                if(count($get13thmonth_pay) <= 0){
                    $response['title']='Error!';
                    $response['stat']='error';
                    $response['msg']='There are no available 13th Month Pay to process';
                    echo json_encode($response);                
                    exit();
                }

                for ($i=0; $i < count($get13thmonth_pay); $i++) { 

                    $m_13thmonth->employee_id = $get13thmonth_pay[$i]->employee_id;
                    $m_13thmonth->year = $year;
                    $m_13thmonth->for_13th_month =  $this->get_numeric_value($get13thmonth_pay[$i]->for_13th_month);
                    $m_13thmonth->retro =  $this->get_numeric_value($get13thmonth_pay[$i]->retro);
                    $m_13thmonth->dayswithpayamt =  $this->get_numeric_value($get13thmonth_pay[$i]->dayswithpayamt);
                    $m_13thmonth->total_13thmonth =  $this->get_numeric_value($get13thmonth_pay[$i]->total_13thmonth);
                    $m_13thmonth->total_days_wout_pay_amt =  $this->get_numeric_value($get13thmonth_pay[$i]->total_days_wout_pay_amt);
                    $m_13thmonth->factor =  $this->get_numeric_value($factor);
                    $m_13thmonth->start_date = date('Y-m-d', strtotime($start_13thmonth_date));
                    $m_13thmonth->end_date = date('Y-m-d', strtotime($end_13thmonth_date));
                    $m_13thmonth->save();

                    $emp_13thmonth_id = $m_13thmonth->last_insert_id();

                    $m_13thmonth->emp_13thmonth_no = '00'.date('Y').''.$emp_13thmonth_id;
                    $m_13thmonth->modify($emp_13thmonth_id);
                        
                }

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='13th Month Pay for year '.$year.' was successfully processed.';
                echo json_encode($response);               



                break;


            case 'email13thMonth':

                $m_employee = $this->Employee_model;
                $m_general = $this->GeneralSettings_model;
                $m_13thmonth = $this->Emp_13thmonth_model;

                $emp_13thmonth_id = $filter_value;

                $getcompany=$this->GeneralSettings_model->get_list(
                null,
                'company_setup.*'
                );


                $get13thmonth = $m_13thmonth->get_13thmonth_processed(null,'all','all',$emp_13thmonth_id);
                $data['company']=$getcompany[0];
                $data['data']=$get13thmonth[0];

                ## Get Employee Info
                $email = $get13thmonth[0]->email_address;
                $fullname = $get13thmonth[0]->fullname;
                $pay_period_year = $get13thmonth[0]->year;
                $grand_13thmonth_pay = $get13thmonth[0]->grand_13thmonth_pay;

                $subject = '13th Month of '.$fullname;

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
                                        <p>Good day, '.$fullname.'! <span style="text-align: right;float:right;">'.$date.'</span> </p>
                                        <p style="text-align: justify;">This email contains your 13th Month Pay for the year of '.$pay_period_year.' with a total of '.number_format($grand_13thmonth_pay,2).'. Please see attachment as your reference of your 13th Month Pay. <br>

                                        If you have any concerns or questions, do not hesitate to contact us. Thank you.
                                    </div>
                                    <div style="background: #F5F5F5;">
                                        <center>
                                            <p style="font-size: 8pt;">Copyright &copy; '.$year.' '.$company_name.'</p>
                                        </center>
                                    </div>
                                </div>
                            </div>';

                $file_name='13th_month_pay_'.$fullname." (".$pay_period_year.")";
                $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                $content=$this->load->view('template/pay_13thmonth_content_html',$data,TRUE); //load the template
                $pdf->setFooter('{PAGENO}');
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

            case 'emailAll13thMonth':


                $m_employee = $this->Employee_model;
                $m_general = $this->GeneralSettings_model;
                $m_13thmonth = $this->Emp_13thmonth_model;

                $year = $filter_value;
                $ref_branch_id = $filter_value2;
                $ref_department_id = $type;

                $info = $m_13thmonth->get_13thmonth_processed($year,$ref_branch_id,$ref_department_id);
    
                if (count($info) > 0){

                for ($i=0; $i < count($info); $i++) { 
                    
                    $get13thmonth=$m_13thmonth->get_13thmonth_processed(null,'all','all',$info[$i]->emp_13thmonth_id);

                    $getcompany=$this->GeneralSettings_model->get_list(
                    null,
                    'company_setup.*'
                    );  

                    $data['data']=$get13thmonth[0];
                    $data['company']=$getcompany[0];

                ## Get Employee Info
                $email = $get13thmonth[0]->email_address;
                $fullname = $get13thmonth[0]->fullname;
                $pay_period_year = $get13thmonth[0]->year;
                $grand_13thmonth_pay = $get13thmonth[0]->grand_13thmonth_pay;

                $subject = '13th Month of '.$fullname;

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
                                        <p>Good day, '.$fullname.'! <span style="text-align: right;float:right;">'.$date.'</span> </p>
                                        <p style="text-align: justify;">This email contains your 13th Month Pay for the year of '.$pay_period_year.' with a total of '.number_format($grand_13thmonth_pay,2).'. Please see attachment as your reference of your 13th Month Pay. <br>

                                        If you have any concerns or questions, do not hesitate to contact us. Thank you.
                                    </div>
                                    <div style="background: #F5F5F5;">
                                        <center>
                                            <p style="font-size: 8pt;">Copyright &copy; '.$year.' '.$company_name.'</p>
                                        </center>
                                    </div>
                                </div>
                            </div>';

                $file_name='13th_month_pay_'.$fullname." (".$pay_period_year.")";
                $pdfFilePath = $file_name.".pdf"; //generate filename base on id
                $pdf = $this->m_pdf->load(); //pass the instance of the mpdf class
                $content=$this->load->view('template/pay_13thmonth_content_html',$data,TRUE); //load the template
                $pdf->setFooter('{PAGENO}');
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


        }
    }
}
