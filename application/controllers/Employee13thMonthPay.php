<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee13thMonthPay extends CORE_Controller
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
        $this->load->model('PayrollReports_model');
        $this->load->model('Emp_13thmonth_model');
        $this->load->model('RefYearSetup_model');

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
        $data['employee'] = $this->Employee_model->get_list('employee_list.is_deleted=0','employee_list.employee_id,CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name',null,'full_name ASC');
        $data['title'] = '13th Month Pay';

        $this->load->view('employee_13thmonthpay_view', $data);
    }


    function schedule($transaction=null,$filter_value=null,$filter_value2=null,$type=null){




        switch($transaction){


            case 'process_13thmonth':
                
                $year = $this->input->post('year', TRUE);
                $employee_id = $this->input->post('employee_id', TRUE);
                $m_13thmonth = $this->Emp_13thmonth_model;

                // if(count($employee_id) <= 0){
                //     $response['title']='Error!';
                //     $response['stat']='error';
                //     $response['msg']='Unable to process! No 13th Month found.';
                //     echo json_encode($response);
                //     exit();
                // }

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

                // $get13thmonth_pay=$this->PayrollReports_model->get_13thmonthpay_register_filter('all','all',$start_13thmonth_date,$end_13thmonth_date,1);
                $get13thmonth_pay=$m_13thmonth->get_13thmonth($year,'all','all',null,$start_13thmonth_date,$end_13thmonth_date,$factor);

                if(count($get13thmonth_pay) <= 0){
                    $response['title']='Error!';
                    $response['stat']='error';
                    $response['msg']='Unable to process! No 13th Month found.';
                    echo json_encode($response);
                    exit();
                }


                // for ($a=0; $a < count($employee_id); $a++) { 
                    
                    for ($i=0; $i < count($get13thmonth_pay); $i++) { 
                            
                        // if($employee_id[$a] == $get13thmonth_pay[$i]->employee_id){

                            $batch = $m_13thmonth->get_last_batch($year);

                            if(count($batch) <= 0){
                                $batch_id = 1;
                            }else{
                                if($batch[0]->batch_id == 1){
                                    $batch_id = 2;
                                }
                                else if($batch[0]->batch_id == 2){
                                    $batch_id = 2;
                                }
                                else{
                                    $batch_id = 1;
                                };
                            }

                            $m_13thmonth->employee_id = $get13thmonth_pay[$i]->employee_id;
                            $m_13thmonth->year = $year;
                            $m_13thmonth->for_13th_month =  $this->get_numeric_value($get13thmonth_pay[$i]->for_13th_month);
                            $m_13thmonth->retro =  $this->get_numeric_value($get13thmonth_pay[$i]->retro);
                            $m_13thmonth->dayswithpayamt =  $this->get_numeric_value($get13thmonth_pay[$i]->dayswithpayamt);
                            $m_13thmonth->total_13thmonth =  $this->get_numeric_value($get13thmonth_pay[$i]->total_13thmonth);
                            $m_13thmonth->total_days_wout_pay_amt =  $this->get_numeric_value($get13thmonth_pay[$i]->total_days_wout_pay_amt);
                            // $m_13thmonth->grand_13thmonth_pay = ((($this->get_numeric_value($get13thmonth_pay[$i]->total_13thmonth) + $this->get_numeric_value($get13thmonth_pay[$i]->retro) + $this->get_numeric_value($get13thmonth_pay[$i]->dayswithpayamt)) - $this->get_numeric_value($get13thmonth_pay[$i]->total_days_wout_pay_amt)) / $this->get_numeric_value($factor));

                            $m_13thmonth->grand_13thmonth_pay = $this->get_numeric_value($get13thmonth_pay[$i]->balance);

                            $m_13thmonth->factor =  $this->get_numeric_value($factor);
                            $m_13thmonth->start_date = date('Y-m-d', strtotime($start_13thmonth_date));
                            $m_13thmonth->end_date = date('Y-m-d', strtotime($end_13thmonth_date));
                            $m_13thmonth->batch_id = $batch_id;
                            $m_13thmonth->processed_date = date('Y-m-d h:i:s');
                            $m_13thmonth->save();

                            $emp_13thmonth_id = $m_13thmonth->last_insert_id();

                            $m_13thmonth->emp_13thmonth_no = '00'.date('Y').''.$emp_13thmonth_id;
                            $m_13thmonth->modify($emp_13thmonth_id);

                        // }

                    }

                // }

                // if(count($get13thmonth_pay) <= 0){
                //     $response['title']='Error!';
                //     $response['stat']='error';
                //     $response['msg']='There are no available 13th Month Pay to process';
                //     echo json_encode($response);                
                //     exit();
                // }

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='13th Month Pay for year '.$year.' was successfully processed.';
                echo json_encode($response);               

                break;


            case 'sched-dtr-detailed': //
                        $data['period_days']=$this->RefPayPeriod_model->get_list('pay_period_id='.$filter_value);

                        $data['employee_schedule']=$this->Employee_model->get_list(
                            'schedule_employee.pay_period_id=10',
                            'schedule_employee.sched_refshift_id,schedule_employee.date,CONCAT(employee_list.first_name," ",employee_list.middle_name," ",employee_list.last_name) as full_name
                            ,ref_branch.branch,ref_department.department',
                            array(
                                array('schedule_employee','schedule_employee.employee_id=employee_list.employee_id','left'),
                                array('emp_rates_duties','emp_rates_duties.emp_rates_duties_id=employee_list.emp_rates_duties_id','left'),
                                array('ref_branch','ref_branch.ref_branch_id=emp_rates_duties.ref_branch_id','left'),
                                array('ref_department','ref_department.ref_department_id=emp_rates_duties.ref_department_id','left'),
                                ),
                           'schedule_employee.date ASC'
                            );

                        /*$data['_pay_period']=$this->RefPayPeriod_model->get_list(
                            $filter_value,
                            'pay_period_start,pay_period_end'
                            );*/

                        $data['schedules'] = $this->SchedDTR_model->getscheddtrdetailed($filter_value,$filter_value2);
                        /*echo json_encode($test['data'][0]->data_serial);*/


                        /*echo json_encode($arr);*/
                        /*echo json_encode($data['employee_schedule']);*/

                        if($type=='fullview'||$type==null){
                            echo $this->load->view('template/scheddtrdetailed_view',$data,TRUE);
                            //echo $this->load->view('template/dr_content_menus',$data,TRUE);
                        }

                        //show only inside grid without menu button
                        if($type=='contentview'){
                            echo $this->load->view('template/scheddtrdetailed_view',$data,TRUE);
                        }


            break;

        }


    }


}
