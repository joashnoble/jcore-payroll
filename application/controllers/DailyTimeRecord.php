<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DailyTimeRecord extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Employee_model');
        $this->load->model('RatesDuties_model');
        $this->load->model('Entitlement_model');
        $this->load->model('Employee_model');
        $this->load->model('RefYearSetup_model');
        $this->load->model('Leavefiled_model');
        $this->load->model('DailyTimeRecord_model');
        $this->load->model('Dtr_Deductions_model');
        $this->load->model('SchedEmployee_model');
        $this->load->model('RefPayPeriod_model');
        $this->load->model('RefDeductionSetup_model');

    }

    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigationforemployee', '', TRUE);
        $data['title'] = 'Daily Time Record Filed';

        $this->load->view('', $data);
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $response['data']=$this->DailyTimeRecord_model->get_list(
                    array('daily_time_record.is_deleted'=>FALSE),
                    'daily_time_record.*,employee_list.*',
                    array(
                         array('employee_list','employee_list.employee_id=daily_time_record.employee_id','left'),
                        )
                    );
                echo json_encode($response);
            break;

            case 'getdtrlist':
                $pay_period_id = $this->input->post('pay_period_id', TRUE);
                $ref_department_id = $this->input->post('ref_department_id', TRUE);
                $ref_branch_id = $this->input->post('ref_branch_id', TRUE);
                $space=" ";
                $test="";

                if($ref_department_id=="all" AND $ref_branch_id=="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'employee_list.is_deleted'=>FALSE,'employee_list.status="Active"');
                }
                if($ref_department_id=="all" AND $ref_branch_id!="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'emp_rates_duties.ref_branch_id'=>$ref_branch_id,'employee_list.is_deleted'=>FALSE,'employee_list.status="Active"');

                }
                if($ref_department_id!="all" AND $ref_branch_id=="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'emp_rates_duties.ref_department_id'=>$ref_department_id,'employee_list.is_deleted'=>FALSE);

                }
                if($ref_department_id!="all" AND $ref_branch_id!="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'emp_rates_duties.ref_department_id'=>$ref_department_id,'emp_rates_duties.ref_branch_id'=>$ref_branch_id,'employee_list.is_deleted'=>FALSE);

                }
                
                $response['data']=$this->DailyTimeRecord_model->get_list(
                    $test,
                    'daily_time_record.*,employee_list.*,CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name,ref_department.department',
                    array(
                         array('employee_list','employee_list.employee_id=daily_time_record.employee_id','left'),
                         array('emp_rates_duties','emp_rates_duties.emp_rates_duties_id=employee_list.emp_rates_duties_id','left'),
                         array('ref_department','ref_department.ref_department_id=emp_rates_duties.ref_department_id','left'),
                        ),
                        'full_name ASC'
                    );
                echo json_encode($response);
            break;

            case 'dtristoprocess':
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
                $response['data']=$this->DailyTimeRecord_model->get_list(
                    $test,
                    'daily_time_record.*,employee_list.*,CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name,ref_department.department',
                    array(
                         array('employee_list','employee_list.employee_id=daily_time_record.employee_id','left'),
                         array('emp_rates_duties','emp_rates_duties.emp_rates_duties_id=employee_list.emp_rates_duties_id','left'),
                         array('ref_department','ref_department.ref_department_id=emp_rates_duties.ref_department_id','left'),
                         array('ref_branch','ref_branch.ref_branch_id=emp_rates_duties.ref_branch_id','left'),
                         //array('pay_slip','pay_slip.dtr_id=daily_time_record.dtr_id','left'),
                        )
                    );
                echo json_encode($response);
                break;

/*
            case 'dtristoprocess':
                $pay_period_id = $this->input->post('pay_period_id', TRUE);
                $ref_department_id = $this->input->post('ref_department_id', TRUE);
                $group_id = $this->input->post('group_id', TRUE);
                $space=" ";
                $test="";
                if($ref_department_id=="all" AND $group_id=="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'employee_list.is_deleted'=>FALSE,'daily_time_record.is_to_process'=>1);
                }
                if($ref_department_id=="all" AND $group_id!="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'emp_rates_duties.group_id'=>$group_id,'employee_list.is_deleted'=>FALSE,'daily_time_record.is_to_process'=>1);

                }
                if($ref_department_id!="all" AND $group_id=="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'emp_rates_duties.ref_department_id'=>$ref_department_id,'employee_list.is_deleted'=>FALSE,'daily_time_record.is_to_process'=>1);

                }
                if($ref_department_id!="all" AND $group_id!="all"){
                $test=array('daily_time_record.pay_period_id'=>$pay_period_id,'daily_time_record.is_deleted'=>FALSE,'emp_rates_duties.active_rates_duties'=>TRUE,'emp_rates_duties.ref_department_id'=>$ref_department_id,'emp_rates_duties.group_id'=>$group_id,'employee_list.is_deleted'=>FALSE,'daily_time_record.is_to_process'=>1);

                }
                $response['data']=$this->DailyTimeRecord_model->get_list(
                    $test,
                    'daily_time_record.*,employee_list.*,CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name,ref_department.department',
                    array(
                         array('employee_list','employee_list.employee_id=daily_time_record.employee_id','left'),
                         array('emp_rates_duties','emp_rates_duties.emp_rates_duties_id=employee_list.emp_rates_duties_id','left'),
                         array('ref_department','ref_department.ref_department_id=emp_rates_duties.ref_department_id','left'),
                        )
                    );
                echo json_encode($response);
                break;
                */

            case 'getdtr':
                $m_daily_time_record = $this->DailyTimeRecord_model;
                $pay_period_id = $this->input->post('pay_period_id', TRUE);;
                $response['data'] = $m_daily_time_record->getwithoutdtr($pay_period_id);

                echo json_encode($response);
                break;



            case 'create':
                $m_daily_time_record = $this->DailyTimeRecord_model;
                $m_dtr_deductions = $this->Dtr_Deductions_model;
                $m_schedules = $this->SchedEmployee_model;

                $user_id=$this->session->user_id;  // get id of current login user
                $employee_id = $this->input->post('employee_id', TRUE);
                $pay_period_id = $this->input->post('pay_period_id', TRUE);

                $per_hour_pay = $m_daily_time_record->get_per_hour_pay($employee_id);
                $salary_reg_rates = $m_daily_time_record->get_salary_pay($employee_id);
                $chck_pay_type = $m_daily_time_record->get_pay_type($employee_id);
                $hour_per_day = $m_daily_time_record->get_hour_per_day($employee_id);

                $chck_reg_holiday = $m_schedules->get_reg_hol_sched($employee_id,$pay_period_id);

                if (count($chck_reg_holiday) > 0){

                $count_reg_hol = $chck_reg_holiday[0]->count_reg_hol;
                $date_reg_hol = $chck_reg_holiday[0]->date;

                $date_before = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date_reg_hol) ) ));
                $chck_before_date = $m_schedules->get_before_date($employee_id,$pay_period_id,$date_before);

                $count_before_date = $chck_before_date[0]->count_before_date;
                }else{
                    $count_reg_hol = 0;
                    $count_before_date = 0;
                }

                $ref_payment_type_id = $chck_pay_type[0]->ref_payment_type_id;
                $salary_rates = $chck_pay_type[0]->salary_reg_rates;

                $factor_file = $m_daily_time_record->get_factorfile();

                $reg = $this->input->post('reg', TRUE);
                $sun = $this->input->post('sun', TRUE);
                $day_off = $this->input->post('day_off', TRUE);
                $reg_hol = $this->input->post('reg_hol', TRUE);
                $spe_hol = $this->input->post('spe_hol', TRUE);
                $sun_reg_hol = $this->input->post('sun_reg_hol', TRUE);
                $sun_spe_hol = $this->input->post('sun_spe_hol', TRUE);
                $days_wout_pay = $this->input->post('days_wout_pay', TRUE);
                $days_with_pay = $this->input->post('days_with_pay', TRUE);
                $minutes_late = $this->input->post('minutes_late', TRUE);
                $minutes_undertime = $this->input->post('minutes_undertime', TRUE);
                $minutes_excess_break = $this->input->post('minutes_excess_break', TRUE);
                $ot_reg = $this->input->post('ot_reg', TRUE);
                $ot_reg_reg_hol = $this->input->post('ot_reg_reg_hol', TRUE);
                $ot_reg_spe_hol = $this->input->post('ot_reg_spe_hol', TRUE);
                $ot_sun = $this->input->post('ot_sun', TRUE);
                $ot_sun_reg_hol = $this->input->post('ot_sun_reg_hol', TRUE);
                $ot_sun_spe_hol = $this->input->post('ot_sun_spe_hol', TRUE);
                $nsd_reg = $this->input->post('nsd_reg', TRUE);
                $nsd_reg_reg_hol = $this->input->post('nsd_reg_reg_hol', TRUE);
                $nsd_reg_spe_hol = $this->input->post('nsd_reg_spe_hol', TRUE);
                $nsd_sun = $this->input->post('nsd_sun', TRUE);
                $nsd_sun_reg_hol = $this->input->post('nsd_sun_reg_hol', TRUE);
                $nsd_sun_spe_hol = $this->input->post('nsd_sun_spe_hol', TRUE);

                $m_daily_time_record->employee_id = $employee_id;
                $m_daily_time_record->pay_period_id = $pay_period_id;

                $m_daily_time_record->reg = $this->get_numeric_value($reg);
                $m_daily_time_record->sun = $this->get_numeric_value($sun);
                $m_daily_time_record->day_off = $this->get_numeric_value($day_off);
                $m_daily_time_record->reg_hol = $this->get_numeric_value($reg_hol);
                $m_daily_time_record->spe_hol = $this->get_numeric_value($spe_hol);
                $m_daily_time_record->sun_reg_hol = $this->get_numeric_value($sun_reg_hol);
                $m_daily_time_record->sun_spe_hol = $this->get_numeric_value($sun_spe_hol);
                $m_daily_time_record->days_wout_pay = $this->get_numeric_value($days_wout_pay);
                $m_daily_time_record->days_with_pay = $this->get_numeric_value($days_with_pay);
                $m_daily_time_record->minutes_late = $this->get_numeric_value($minutes_late);
                $m_daily_time_record->minutes_undertime = $this->get_numeric_value($minutes_undertime);
                $m_daily_time_record->minutes_excess_break = $this->get_numeric_value($minutes_excess_break);
                $m_daily_time_record->ot_reg = $this->get_numeric_value($ot_reg);
                $m_daily_time_record->ot_reg_reg_hol = $this->get_numeric_value($ot_reg_reg_hol);
                $m_daily_time_record->ot_reg_spe_hol = $this->get_numeric_value($ot_reg_spe_hol);
                $m_daily_time_record->ot_sun = $this->get_numeric_value($ot_sun);
                $m_daily_time_record->ot_sun_reg_hol = $this->get_numeric_value($ot_sun_reg_hol);
                $m_daily_time_record->ot_sun_spe_hol = $this->get_numeric_value($ot_sun_spe_hol);

                $m_daily_time_record->nsd_reg = $this->get_numeric_value($nsd_reg);
                $m_daily_time_record->nsd_reg_reg_hol = $this->get_numeric_value($nsd_reg_reg_hol);
                $m_daily_time_record->nsd_reg_spe_hol = $this->get_numeric_value($nsd_reg_spe_hol);
                $m_daily_time_record->nsd_sun = $this->get_numeric_value($nsd_sun);
                $m_daily_time_record->nsd_sun_reg_hol = $this->get_numeric_value($nsd_sun_reg_hol);
                $m_daily_time_record->nsd_sun_spe_hol = $this->get_numeric_value($nsd_sun_spe_hol);

                $m_daily_time_record->reg_amt = $this->get_numeric_value($reg)*$per_hour_pay;
                $m_daily_time_record->for_13th_month = $reg*$per_hour_pay;

                $m_daily_time_record->sun_amt = $this->get_numeric_value($sun)*$per_hour_pay*$factor_file[0]->sunday;
                $m_daily_time_record->day_off_amt = $this->get_numeric_value($day_off)*$per_hour_pay*$factor_file[0]->day_off;

                if ($count_reg_hol == 0 && $count_before_date == 0){
                    $m_daily_time_record->reg_hol_amt = ($this->get_numeric_value($reg_hol)*$per_hour_pay*$factor_file[0]->regular_holiday);
                }
                else if ($count_reg_hol == 1 && $count_before_date == 1){
                    $m_daily_time_record->reg_hol_amt = ($this->get_numeric_value($reg_hol)*$per_hour_pay*$factor_file[0]->regular_holiday);
                }else if ($count_reg_hol == 1 && $count_before_date == 0){
                    $m_daily_time_record->reg_hol_amt = ($this->get_numeric_value($reg_hol)*$per_hour_pay*1);
                }else if ($count_reg_hol == 0 && $count_before_date == 1){
                    $m_daily_time_record->reg_hol_amt = ($this->get_numeric_value($reg_hol)*$per_hour_pay*1);
                }else{
                    $m_daily_time_record->reg_hol_amt = 0.00;
                }
                

                $m_daily_time_record->reg_hol_amt = ($this->get_numeric_value($reg_hol)*$per_hour_pay*$factor_file[0]->regular_holiday);
                $m_daily_time_record->spe_hol_amt = ($this->get_numeric_value($spe_hol)*$per_hour_pay*$factor_file[0]->spe_holiday);
                $m_daily_time_record->sun_reg_hol_amt = $this->get_numeric_value($sun_reg_hol)*$per_hour_pay*$factor_file[0]->sun_regular_holiday;
                $m_daily_time_record->sun_spe_hol_amt = $this->get_numeric_value($sun_spe_hol)*$per_hour_pay*$factor_file[0]->sun_spe_holiday;
                //skipped days w.pay wopay
                $m_daily_time_record->days_wout_pay_amt = ($salary_reg_rates/$hour_per_day)*$this->get_numeric_value($days_wout_pay);
                $m_daily_time_record->days_with_pay_amt = ($salary_reg_rates/$hour_per_day)*$this->get_numeric_value($days_with_pay);
                $m_daily_time_record->minutes_late_amt = ($per_hour_pay/60)*$this->get_numeric_value($minutes_late);
                $m_daily_time_record->minutes_undertime_amt = ($per_hour_pay/60)*$this->get_numeric_value($minutes_undertime);
                $m_daily_time_record->minutes_excess_break_amt = ($per_hour_pay/60)*$this->get_numeric_value($minutes_excess_break);
                $m_daily_time_record->ot_reg_amt = $this->get_numeric_value($ot_reg)*$per_hour_pay*$factor_file[0]->regular_ot;
                $m_daily_time_record->ot_reg_reg_hol_amt = $this->get_numeric_value($ot_reg_reg_hol)*$per_hour_pay*$factor_file[0]->regular_holiday_ot;
                $m_daily_time_record->ot_reg_spe_hol_amt = $this->get_numeric_value($ot_reg_spe_hol)*$per_hour_pay*$factor_file[0]->spe_holiday_ot;
                $m_daily_time_record->ot_sun_amt = $this->get_numeric_value($ot_sun)*$per_hour_pay*$factor_file[0]->sunday_ot;
                $m_daily_time_record->ot_sun_reg_hol_amt = $this->get_numeric_value($ot_sun_reg_hol)*$per_hour_pay*$factor_file[0]->sun_regular_holiday_ot;
                $m_daily_time_record->ot_sun_spe_hol_amt = $this->get_numeric_value($ot_sun_spe_hol)*$per_hour_pay*$factor_file[0]->sun_spe_holiday_ot;
                $m_daily_time_record->nsd_reg_amt = $this->get_numeric_value($nsd_reg)*$per_hour_pay*$factor_file[0]->night_shift;
                $m_daily_time_record->nsd_reg_reg_hol_amt = $this->get_numeric_value($nsd_reg_reg_hol)*$per_hour_pay*$factor_file[0]->night_shift_reg_holiday;
                $m_daily_time_record->nsd_reg_spe_hol_amt = $this->get_numeric_value($nsd_reg_spe_hol)*$per_hour_pay*$factor_file[0]->night_shift_spe_holiday;
                $m_daily_time_record->nsd_sun_amt = $this->get_numeric_value($nsd_sun)*$per_hour_pay*$factor_file[0]->sun_night_shift;
                $m_daily_time_record->nsd_sun_reg_hol_amt = $this->get_numeric_value($nsd_sun_reg_hol)*$per_hour_pay*$factor_file[0]->sun_night_shift_reg_holiday;
                $m_daily_time_record->nsd_sun_spe_hol_amt = $this->get_numeric_value($nsd_sun_spe_hol)*$per_hour_pay*$factor_file[0]->sun_night_shift_spe_holiday;

                $m_daily_time_record->is_to_process = 1;
                $m_daily_time_record->date_created = date("Y-m-d");
                $m_daily_time_record->created_by = $user_id;
                $m_daily_time_record->save();

                $m_dtr_id = $m_daily_time_record->last_insert_id();

                //$m_products->set('quantity','quantity-'.$pos_qty[$i]);
                //$m_products->modify($product_id[$i]);

                $deduction_id=$this->input->post('deduction_id', TRUE);
                $deduction_regular_id=$this->input->post('deduction_regular_id', TRUE);
                $is_deduct=$this->input->post('dtr_deduction_checkbox', TRUE);
                $full_deduct=$this->input->post('dtr_full_deduct_checkbox', TRUE);
                $m_deduction = $this->Dtr_Deductions_model;

                $get_pps = $this->RefPayPeriod_model->get_list($pay_period_id);
                $pay_period_sequence = $get_pps[0]->pay_period_sequence;

                for ($i=0; $i < count($deduction_id); $i++) { 
                    $m_deduction->dtr_id = $m_dtr_id;
                    $m_deduction->deduction_id = $deduction_id[$i];
                    $m_deduction->deduction_regular_id = $deduction_regular_id[$i];
                    $m_deduction->save();
                }


                $this->DailyTimeRecord_model->applyisdeduct($m_dtr_id,$is_deduct);
                $this->DailyTimeRecord_model->applyfulldeduct($m_dtr_id,$full_deduct);

                // for ($d=0; $d < count($is_deduct); $d++) {

                    // $chck_deduction = $this->RefDeductionSetup_model->getalldeduct($employee_id,$pay_period_id,$pay_period_sequence,$is_deduct[$d]);

                    // if ($chck_deduction[0]->is_deduct == 1){
                        // $this->DailyTimeRecord_model->applyisdeduct($m_dtr_id,$is_deduct[$d]);
                    // }

                // }

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Daily Time Record successfully created.';

                $response['row_added'] = $this->DailyTimeRecord_model->get_list(
                   $m_dtr_id,
                    'daily_time_record.*,employee_list.*,CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name,ref_department.department',
                    array(
                         array('employee_list','employee_list.employee_id=daily_time_record.employee_id','left'),
                         array('emp_rates_duties','emp_rates_duties.emp_rates_duties_id=employee_list.emp_rates_duties_id','left'),
                         array('ref_department','ref_department.ref_department_id=emp_rates_duties.ref_department_id','left'),
                        )
                    );
                echo json_encode($response);
                break;

            case 'delete':


                break;

            case 'update':
                $m_daily_time_record = $this->DailyTimeRecord_model;
                $m_dtr_deductions = $this->Dtr_Deductions_model;
                $m_schedules = $this->SchedEmployee_model;
                $m_pay_period = $this->RefPayPeriod_model;

                $user_id=$this->session->user_id;  // get id of current login user
                $employee_id = $this->input->post('employee_id', TRUE);
                // $pay_period_id = $this->input->post('pay_period_id', TRUE);
                $dtr_id = $this->input->post('dtr_id', TRUE);
                $m_dtr_id=$dtr_id;
                $per_hour_pay = $m_daily_time_record->get_per_hour_pay($employee_id);
                $salary_reg_rates = $m_daily_time_record->get_salary_pay($employee_id);
                $chck_pay_type = $m_daily_time_record->get_pay_type($employee_id);
                $hour_per_day = $m_daily_time_record->get_hour_per_day($employee_id);

                $get_pay_period = $m_daily_time_record->getperiodid($dtr_id);
                $pay_period_id = $get_pay_period[0]->pay_period_id;

                $chck_reg_holiday = $m_schedules->get_reg_hol_sched($employee_id,$pay_period_id);

                if (count($chck_reg_holiday) > 0){
                    $count_reg_hol = $chck_reg_holiday[0]->count_reg_hol;
                    $date_reg_hol = $chck_reg_holiday[0]->date;

                    $date_before = date('Y-m-d',(strtotime ( '-1 day' , strtotime ( $date_reg_hol) ) ));

                    $chck_before_date = $m_schedules->get_before_date($employee_id,$pay_period_id,$date_before);

                    $count_before_date = $chck_before_date[0]->count_before_date;
                }else{
                    $count_reg_hol = 0;
                    $count_before_date = 0;
                }

                $ref_payment_type_id = $chck_pay_type[0]->ref_payment_type_id;
                $salary_rates = $chck_pay_type[0]->salary_reg_rates;

                /*$semi_monthly_verify = $m_daily_time_record->get_semi_monthly_pay($employee_id);
                $semi_monthly_pay = $semi_monthly_verify[0]->salary_reg_rates;
                $semi_monthly_pay_type = $semi_monthly_verify[0]->ref_payment_type_id;*/
                // 1 (ONE) is SEMI MONTHLY
                /*echo $semi_monthly_pay;
                echo $semi_monthly_pay_type;*/
                $factor_file = $m_daily_time_record->get_factorfile();

                $reg = $this->input->post('reg', TRUE);
                $sun = $this->input->post('sun', TRUE);
                $day_off = $this->input->post('day_off', TRUE);
                $reg_hol = $this->input->post('reg_hol', TRUE);
                $spe_hol = $this->input->post('spe_hol', TRUE);
                $sun_reg_hol = $this->input->post('sun_reg_hol', TRUE);
                $sun_spe_hol = $this->input->post('sun_spe_hol', TRUE);
                $days_wout_pay = $this->input->post('days_wout_pay', TRUE);
                $days_with_pay = $this->input->post('days_with_pay', TRUE);
                $minutes_late = $this->input->post('minutes_late', TRUE);
                $minutes_undertime = $this->input->post('minutes_undertime', TRUE);
                $minutes_excess_break = $this->input->post('minutes_excess_break', TRUE);
                $ot_reg = $this->input->post('ot_reg', TRUE);
                $ot_reg_reg_hol = $this->input->post('ot_reg_reg_hol', TRUE);
                $ot_reg_spe_hol = $this->input->post('ot_reg_spe_hol', TRUE);
                $ot_sun = $this->input->post('ot_sun', TRUE);
                $ot_sun_reg_hol = $this->input->post('ot_sun_reg_hol', TRUE);
                $ot_sun_spe_hol = $this->input->post('ot_sun_spe_hol', TRUE);
                $nsd_reg = $this->input->post('nsd_reg', TRUE);
                $nsd_reg_reg_hol = $this->input->post('nsd_reg_reg_hol', TRUE);
                $nsd_reg_spe_hol = $this->input->post('nsd_reg_spe_hol', TRUE);
                $nsd_sun = $this->input->post('nsd_sun', TRUE);
                $nsd_sun_reg_hol = $this->input->post('nsd_sun_reg_hol', TRUE);
                $nsd_sun_spe_hol = $this->input->post('nsd_sun_spe_hol', TRUE);

                //$m_daily_time_record->employee_id = $employee_id;
                //$m_daily_time_record->pay_period_id = $pay_period_id;

                /*$m_daily_time_record->reg = $this->get_numeric_value($reg);*/
                $m_daily_time_record->reg = $this->get_numeric_value($reg);
                $m_daily_time_record->sun = $this->get_numeric_value($sun);
                $m_daily_time_record->day_off = $this->get_numeric_value($day_off);
                $m_daily_time_record->reg_hol = $this->get_numeric_value($reg_hol);
                $m_daily_time_record->spe_hol = $this->get_numeric_value($spe_hol);
                $m_daily_time_record->sun_reg_hol = $this->get_numeric_value($sun_reg_hol);
                $m_daily_time_record->sun_spe_hol = $this->get_numeric_value($sun_spe_hol);
                $m_daily_time_record->days_wout_pay = $this->get_numeric_value($days_wout_pay);
                $m_daily_time_record->days_with_pay = $this->get_numeric_value($days_with_pay);
                $m_daily_time_record->minutes_late = $this->get_numeric_value($minutes_late);
                $m_daily_time_record->minutes_undertime = $this->get_numeric_value($minutes_undertime);
                $m_daily_time_record->minutes_excess_break = $this->get_numeric_value($minutes_excess_break);
                $m_daily_time_record->ot_reg = $this->get_numeric_value($ot_reg);
                $m_daily_time_record->ot_reg_reg_hol = $this->get_numeric_value($ot_reg_reg_hol);
                $m_daily_time_record->ot_reg_spe_hol = $this->get_numeric_value($ot_reg_spe_hol);
                $m_daily_time_record->ot_sun = $this->get_numeric_value($ot_sun);
                $m_daily_time_record->ot_sun_reg_hol = $this->get_numeric_value($ot_sun_reg_hol);
                $m_daily_time_record->ot_sun_spe_hol = $this->get_numeric_value($ot_sun_spe_hol);

                $m_daily_time_record->nsd_reg = $this->get_numeric_value($nsd_reg);
                $m_daily_time_record->nsd_reg_reg_hol = $this->get_numeric_value($nsd_reg_reg_hol);
                $m_daily_time_record->nsd_reg_spe_hol = $this->get_numeric_value($nsd_reg_spe_hol);
                $m_daily_time_record->nsd_sun = $this->get_numeric_value($nsd_sun);
                $m_daily_time_record->nsd_sun_reg_hol = $this->get_numeric_value($nsd_sun_reg_hol);
                $m_daily_time_record->nsd_sun_spe_hol = $this->get_numeric_value($nsd_sun_spe_hol);

                $m_daily_time_record->reg_amt = $this->get_numeric_value($reg)*$per_hour_pay;
                $m_daily_time_record->for_13th_month = $reg*$per_hour_pay;

                $m_daily_time_record->sun_amt = $this->get_numeric_value($sun)*$per_hour_pay*$factor_file[0]->sunday;
                $m_daily_time_record->day_off_amt = $this->get_numeric_value($day_off)*$per_hour_pay*$factor_file[0]->day_off;

                if ($count_reg_hol == 0 && $count_before_date == 0){
                    $m_daily_time_record->reg_hol_amt = ($this->get_numeric_value($reg_hol)*$per_hour_pay*$factor_file[0]->regular_holiday);
                }
                else if ($count_reg_hol == 1 && $count_before_date == 1){
                    $m_daily_time_record->reg_hol_amt = ($this->get_numeric_value($reg_hol)*$per_hour_pay*$factor_file[0]->regular_holiday);
                }else if ($count_reg_hol == 1 && $count_before_date == 0){
                    $m_daily_time_record->reg_hol_amt = ($this->get_numeric_value($reg_hol)*$per_hour_pay*1);
                }else if ($count_reg_hol == 0 && $count_before_date == 1){
                    $m_daily_time_record->reg_hol_amt = ($this->get_numeric_value($reg_hol)*$per_hour_pay*1);
                }else{
                    $m_daily_time_record->reg_hol_amt = 0.00;
                }

                $m_daily_time_record->reg_hol_amt = ($this->get_numeric_value($reg_hol)*$per_hour_pay*$factor_file[0]->regular_holiday);

                $m_daily_time_record->spe_hol_amt = ($this->get_numeric_value($spe_hol)*$per_hour_pay*$factor_file[0]->spe_holiday);
                $m_daily_time_record->sun_reg_hol_amt = $this->get_numeric_value($sun_reg_hol)*$per_hour_pay*$factor_file[0]->sun_regular_holiday;
                $m_daily_time_record->sun_spe_hol_amt = $this->get_numeric_value($sun_spe_hol)*$per_hour_pay*$factor_file[0]->sun_spe_holiday;
                //skipped days w.pay wopay
                $m_daily_time_record->days_wout_pay_amt = ($salary_reg_rates/$hour_per_day)*$this->get_numeric_value($days_wout_pay);
                $m_daily_time_record->days_with_pay_amt = ($salary_reg_rates/$hour_per_day)*$this->get_numeric_value($days_with_pay);
                $m_daily_time_record->minutes_late_amt = ($per_hour_pay/60)*$this->get_numeric_value($minutes_late);
                $m_daily_time_record->minutes_undertime_amt = ($per_hour_pay/60)*$this->get_numeric_value($minutes_undertime);
                $m_daily_time_record->minutes_excess_break_amt = ($per_hour_pay/60)*$this->get_numeric_value($minutes_excess_break);
                $m_daily_time_record->ot_reg_amt = $this->get_numeric_value($ot_reg)*$per_hour_pay*$factor_file[0]->regular_ot;
                $m_daily_time_record->ot_reg_reg_hol_amt = $this->get_numeric_value($ot_reg_reg_hol)*$per_hour_pay*$factor_file[0]->regular_holiday_ot;
                $m_daily_time_record->ot_reg_spe_hol_amt = $this->get_numeric_value($ot_reg_spe_hol)*$per_hour_pay*$factor_file[0]->spe_holiday_ot;
                $m_daily_time_record->ot_sun_amt = $this->get_numeric_value($ot_sun)*$per_hour_pay*$factor_file[0]->sunday_ot;
                $m_daily_time_record->ot_sun_reg_hol_amt = $this->get_numeric_value($ot_sun_reg_hol)*$per_hour_pay*$factor_file[0]->sun_regular_holiday_ot;
                $m_daily_time_record->ot_sun_spe_hol_amt = $this->get_numeric_value($ot_sun_spe_hol)*$per_hour_pay*$factor_file[0]->sun_spe_holiday_ot;
                $m_daily_time_record->nsd_reg_amt = $this->get_numeric_value($nsd_reg)*$per_hour_pay*$factor_file[0]->night_shift;
                $m_daily_time_record->nsd_reg_reg_hol_amt = $this->get_numeric_value($nsd_reg_reg_hol)*$per_hour_pay*$factor_file[0]->night_shift_reg_holiday;
                $m_daily_time_record->nsd_reg_spe_hol_amt = $this->get_numeric_value($nsd_reg_spe_hol)*$per_hour_pay*$factor_file[0]->night_shift_spe_holiday;
                $m_daily_time_record->nsd_sun_amt = $this->get_numeric_value($nsd_sun)*$per_hour_pay*$factor_file[0]->sun_night_shift;
                $m_daily_time_record->nsd_sun_reg_hol_amt = $this->get_numeric_value($nsd_sun_reg_hol)*$per_hour_pay*$factor_file[0]->sun_night_shift_reg_holiday;
                $m_daily_time_record->nsd_sun_spe_hol_amt = $this->get_numeric_value($nsd_sun_spe_hol)*$per_hour_pay*$factor_file[0]->sun_night_shift_spe_holiday;

                $m_daily_time_record->is_to_process = 1;
                $m_daily_time_record->date_modified = date("Y-m-d");
                $m_daily_time_record->modified_by = $user_id;
                $m_daily_time_record->modify($dtr_id);

                /*echo "done";
*/
                $m_dtr_deductions=$this->Dtr_Deductions_model;

                $m_dtr_deductions->delete_via_fk($dtr_id); //delete previous items then insert those new

                $deduction_id=$this->input->post('deduction_id', TRUE);
                $deduction_regular_id=$this->input->post('deduction_regular_id', TRUE);
                $is_deduct=$this->input->post('dtr_deduction_checkbox', TRUE);
                $full_deduct=$this->input->post('dtr_full_deduct_checkbox', TRUE);
                $m_deduction = $this->Dtr_Deductions_model;

                $get_pps = $this->RefPayPeriod_model->get_list($pay_period_id);
                $pay_period_sequence = $get_pps[0]->pay_period_sequence;

                for ($i=0; $i < count($deduction_id); $i++) { 
                    $m_deduction->dtr_id = $dtr_id;
                    $m_deduction->deduction_id = $deduction_id[$i];
                    $m_deduction->deduction_regular_id = $deduction_regular_id[$i];
                    $m_deduction->save();
                }

                $this->DailyTimeRecord_model->applyisdeduct($dtr_id,$is_deduct);
                $this->DailyTimeRecord_model->applyfulldeduct($m_dtr_id,$full_deduct);
                // for ($d=0; $d < count($is_deduct); $d++) {

                    // $chck_deduction = $this->RefDeductionSetup_model->getalldeduct($employee_id,$pay_period_id,$pay_period_sequence,$is_deduct[$d]);

                    // if ($chck_deduction[0]->is_deduct == 1){
                        // $this->DailyTimeRecord_model->applyisdeduct($dtr_id,$is_deduct[$d]);
                    // }

                // }

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='DTR successfully Updated.';
                $response['row_updated'] = $this->DailyTimeRecord_model->get_list(
                   $dtr_id,
                    'daily_time_record.*,employee_list.*,CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name,ref_department.department',
                    array(
                         array('employee_list','employee_list.employee_id=daily_time_record.employee_id','left'),
                         array('emp_rates_duties','emp_rates_duties.emp_rates_duties_id=employee_list.emp_rates_duties_id','left'),
                         array('ref_department','ref_department.ref_department_id=emp_rates_duties.ref_department_id','left'),
                        )
                    );
                echo json_encode($response);
                break;

            case 'chckstatus':
              $dtr = $this->DailyTimeRecord_model;
              $employee_id = $this->input->post('employee_id', TRUE);
              $chck_pay_type = $dtr->get_pay_type($employee_id);
              echo json_encode($chck_pay_type);
            break;

             case 'processpayroll':
                $m_daily_time_record=$this->DailyTimeRecord_model;

                $dtr_id = $this->input->post('dtr_id', TRUE);
                //$pay_slip_id = $this->input->post('pay_slip_id', TRUE);
                //$count_pay_slip_id = count($pay_slip_id) - 1;
                //for ($x = 0; $x < $count_pay_slip_id; $x++)
                //{
                //echo $pay_slip_id[$x];
                 //   if($pay_slip_id[$x]==0){
                        if($dtr_id!="")
                        {
                            $status=$this->DailyTimeRecord_model->process_payroll($dtr_id);
                            if($status==true){
                                $response['title']='Success!';
                                $response['stat']='success';
                                $response['msg']='DTR Successfully Processed.';
                            }
                            else{
                                $response['title']='Error!';
                                $response['stat']='error';
                                $response['msg']='DTR Failed to Processed, Please Try Again.';
                            }
                        }
                        else
                        {
                        $response['title']='Error!';
                        $response['stat']='error';
                        $response['msg']='Select Employee Dtr to be Processed.';
                        }
                    //}
                    //else
                    //{
                    //    echo "MODIFY";
                    //    $response['msg']='modify.';

                    //}
                //}
                    echo json_encode($response);
                break;

                case 'transfertodtr':
                    $m_daily_time_record = $this->DailyTimeRecord_model;
                    $m_schedules = $this->SchedEmployee_model;
                    $pay_period_id = $this->input->post('pay_period_id', TRUE);
                  
                    // Prepare for the foreach
                    $employee_id = $this->input->post('employee_id', TRUE);                  
                    $reg = $this->input->post('reg', TRUE);
                    $sun = $this->input->post('sun', TRUE);
                    $day_off = $this->input->post('day_off', TRUE);
                    $reg_hol = $this->input->post('reg_hol', TRUE);
                    $spe_hol = $this->input->post('spe_hol', TRUE);
                    $sun_reg_hol = $this->input->post('sun_reg_hol', TRUE);
                    $sun_spe_hol = $this->input->post('sun_spe_hol', TRUE);
                    $minutes_late = $this->input->post('minutes_late', TRUE);
                    $minutes_undertime = $this->input->post('minutes_undertime', TRUE);
                    $minutes_excess_break = $this->input->post('minutes_excess_break', TRUE);
                    $ot_reg = $this->input->post('ot_reg', TRUE);
                    $ot_reg_reg_hol = $this->input->post('ot_reg_reg_hol', TRUE);
                    $ot_reg_spe_hol = $this->input->post('ot_reg_spe_hol', TRUE);
                    $ot_sun = $this->input->post('ot_sun', TRUE);
                    $ot_sun_reg_hol = $this->input->post('ot_sun_reg_hol', TRUE);
                    $ot_sun_spe_hol = $this->input->post('ot_sun_spe_hol', TRUE);
                    $nsd_reg = $this->input->post('nsd_reg', TRUE);
                    $nsd_reg_reg_hol = $this->input->post('nsd_reg_reg_hol', TRUE);
                    $nsd_reg_spe_hol = $this->input->post('nsd_reg_spe_hol', TRUE);
                    $nsd_sun = $this->input->post('nsd_sun', TRUE);
                    $nsd_sun_reg_hol = $this->input->post('nsd_sun_reg_hol', TRUE);
                    $nsd_sun_spe_hol = $this->input->post('nsd_sun_spe_hol', TRUE);

                    for($i=0;$i<count($employee_id);$i++){

                        // Check Regular Holiday
                        $chck_reg_holiday = $m_schedules->get_reg_hol_sched($employee_id[$i],$pay_period_id);
                        $count_reg_hol = $chck_reg_holiday[0]->count_reg_hol;
                        $date_reg_hol = $chck_reg_holiday[0]->date;
                        $date_before = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($date_reg_hol))));

                        $chck_before_date = $m_schedules->get_before_date($employee_id[$i],$pay_period_id,$date_before);
                        $count_before_date = $chck_before_date[0]->count_before_date;
                        // ## End

                        $per_hour_pay = $m_daily_time_record->get_per_hour_pay($employee_id[$i]);
                        $salary_reg_rates = $m_daily_time_record->get_salary_pay($employee_id[$i]);
                        $chck_pay_type = $m_daily_time_record->get_pay_type($employee_id[$i]);

                        $ref_payment_type_id = $chck_pay_type[0]->ref_payment_type_id;
                        $salary_rates = $chck_pay_type[0]->salary_reg_rates;
                        $factor_file = $m_daily_time_record->get_factorfile();

                        $m_daily_time_record->employee_id = $employee_id[$i];
                        $m_daily_time_record->pay_period_id = $pay_period_id;

                        $m_daily_time_record->reg = $this->get_numeric_value($reg[$i]);
                        $reg_1 = 0;

                        if ($reg[$i] <= 48){
                            $m_daily_time_record->reg = $this->get_numeric_value($reg[$i]);
                        }else{
                            $reg_1 = $reg[$i] - 48; 
                            $m_daily_time_record->reg = 48;
                        }

                        $m_daily_time_record->sun = $this->get_numeric_value($sun[$i]);
                        $m_daily_time_record->day_off = $this->get_numeric_value($day_off[$i]);
                        $m_daily_time_record->reg_hol = $this->get_numeric_value($reg_hol[$i]);
                        $m_daily_time_record->spe_hol = $this->get_numeric_value($spe_hol[$i]);
                        $m_daily_time_record->sun_reg_hol = $this->get_numeric_value($sun_reg_hol[$i]);
                        $m_daily_time_record->sun_spe_hol = $this->get_numeric_value($sun_spe_hol[$i]);
                        $m_daily_time_record->minutes_late = $this->get_numeric_value($minutes_late[$i]);
                        $m_daily_time_record->minutes_undertime = $this->get_numeric_value($minutes_undertime[$i]);
                        $m_daily_time_record->minutes_excess_break = $this->get_numeric_value($minutes_excess_break[$i]);

                        $ot_reg1 = $reg_1 + $ot_reg[$i];
                        $m_daily_time_record->ot_reg = $this->get_numeric_value($ot_reg1);

                        $m_daily_time_record->ot_reg_reg_hol = $this->get_numeric_value($ot_reg_reg_hol[$i]);
                        $m_daily_time_record->ot_reg_spe_hol = $this->get_numeric_value($ot_reg_spe_hol[$i]);
                        $m_daily_time_record->ot_sun = $this->get_numeric_value($ot_sun[$i]);
                        $m_daily_time_record->ot_sun_reg_hol = $this->get_numeric_value($ot_sun_reg_hol[$i]);
                        $m_daily_time_record->ot_sun_spe_hol = $this->get_numeric_value($ot_sun_spe_hol[$i]);
                        $m_daily_time_record->nsd_reg = $this->get_numeric_value($nsd_reg[$i]);
                        $m_daily_time_record->nsd_reg_reg_hol = $this->get_numeric_value($nsd_reg_reg_hol[$i]);
                        $m_daily_time_record->nsd_reg_spe_hol = $this->get_numeric_value($nsd_reg_spe_hol[$i]);
                        $m_daily_time_record->nsd_sun = $this->get_numeric_value($nsd_sun[$i]);
                        $m_daily_time_record->nsd_sun_reg_hol = $this->get_numeric_value($nsd_sun_reg_hol[$i]);
                        $m_daily_time_record->nsd_sun_spe_hol = $this->get_numeric_value($nsd_sun_spe_hol[$i]);

                        $m_daily_time_record->reg_amt = $this->get_numeric_value($reg[$i])*$per_hour_pay;
                        $m_daily_time_record->for_13th_month = $reg[$i]*$per_hour_pay;

                        $m_daily_time_record->sun_amt = $this->get_numeric_value($sun[$i])*$per_hour_pay*$factor_file[0]->sunday;
                        $m_daily_time_record->day_off_amt = $this->get_numeric_value($day_off[$i])*$per_hour_pay*$factor_file[0]->day_off;

                        if ($count_reg_hol == '1' && $count_before_date == '1'){
                            $m_daily_time_record->reg_hol_amt = ($this->get_numeric_value($reg_hol[$i])*$per_hour_pay*$factor_file[0]->regular_holiday);
                        }else if ($count_reg_hol == '1' && $count_before_date == '0'){
                            $m_daily_time_record->reg_hol_amt = ($this->get_numeric_value($reg_hol[$i])*$per_hour_pay*1);
                        }else if ($count_reg_hol == '0' && $count_before_date == '1'){
                            $m_daily_time_record->reg_hol_amt = ($this->get_numeric_value($reg_hol[$i])*$per_hour_pay*1);
                        }else{
                            $m_daily_time_record->reg_hol_amt = 0.00;
                        }

                        $m_daily_time_record->spe_hol_amt = ($this->get_numeric_value($spe_hol[$i])*$per_hour_pay*$factor_file[0]->spe_holiday);

                        $m_daily_time_record->sun_reg_hol_amt = $this->get_numeric_value($sun_reg_hol[$i])*$per_hour_pay*$factor_file[0]->sun_regular_holiday;
                        $m_daily_time_record->sun_spe_hol_amt = $this->get_numeric_value($sun_spe_hol[$i])*$per_hour_pay*$factor_file[0]->sun_spe_holiday;
                        $m_daily_time_record->minutes_late_amt = ($per_hour_pay/60)*$this->get_numeric_value($minutes_late[$i]);
                        $m_daily_time_record->minutes_undertime_amt = ($per_hour_pay/60)*$this->get_numeric_value($minutes_undertime[$i]);
                        $m_daily_time_record->minutes_excess_break_amt = ($per_hour_pay/60)*$this->get_numeric_value($minutes_excess_break[$i]);
                        $m_daily_time_record->ot_reg_amt = $this->get_numeric_value($ot_reg[$i])*$per_hour_pay*$factor_file[0]->regular_ot;
                        $m_daily_time_record->ot_reg_reg_hol_amt = $this->get_numeric_value($ot_reg_reg_hol[$i])*$per_hour_pay*$factor_file[0]->regular_holiday_ot;
                        $m_daily_time_record->ot_reg_spe_hol_amt = $this->get_numeric_value($ot_reg_spe_hol[$i])*$per_hour_pay*$factor_file[0]->spe_holiday_ot;
                        $m_daily_time_record->ot_sun_amt = $this->get_numeric_value($ot_sun[$i])*$per_hour_pay*$factor_file[0]->sunday_ot;
                        $m_daily_time_record->ot_sun_reg_hol_amt = $this->get_numeric_value($ot_sun_reg_hol[$i])*$per_hour_pay*$factor_file[0]->sun_regular_holiday_ot;
                        $m_daily_time_record->ot_sun_spe_hol_amt = $this->get_numeric_value($ot_sun_spe_hol[$i])*$per_hour_pay*$factor_file[0]->sun_spe_holiday_ot;
                        $m_daily_time_record->nsd_reg_amt = $this->get_numeric_value($nsd_reg[$i])*$per_hour_pay*$factor_file[0]->night_shift;
                        $m_daily_time_record->nsd_reg_reg_hol_amt = $this->get_numeric_value($nsd_reg_reg_hol[$i])*$per_hour_pay*$factor_file[0]->night_shift_reg_holiday;
                        $m_daily_time_record->nsd_reg_spe_hol_amt = $this->get_numeric_value($nsd_reg_spe_hol[$i])*$per_hour_pay*$factor_file[0]->night_shift_spe_holiday;
                        $m_daily_time_record->nsd_sun_amt = $this->get_numeric_value($nsd_sun[$i])*$per_hour_pay*$factor_file[0]->sun_night_shift;
                        $m_daily_time_record->nsd_sun_reg_hol_amt = $this->get_numeric_value($nsd_sun_reg_hol[$i])*$per_hour_pay*$factor_file[0]->sun_night_shift_reg_holiday;
                        $m_daily_time_record->nsd_sun_spe_hol_amt = $this->get_numeric_value($nsd_sun_spe_hol[$i])*$per_hour_pay*$factor_file[0]->sun_night_shift_spe_holiday;

                        $m_daily_time_record->is_to_process = 1;
                        $m_daily_time_record->date_modified = date("Y-m-d");
                        $dtr = $m_daily_time_record->ifexistdtr($employee_id[$i],$pay_period_id);

                        if(count($m_daily_time_record->ifexistdtr($employee_id[$i],$pay_period_id))==0){
                            $m_daily_time_record->save($employee_id[$i]);
                        }
                        else{
                            $m_daily_time_record->modify($dtr[0]->dtr_id);

                        }
                    }
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='DTR summary successfully transferred.';
                    echo json_encode($response);
                break;



            case 'test':
            function replaceCharsInNumber($num, $chars) {
               return substr((string) $num, 0, -strlen($chars)) . $chars;
            }

            $format = "000000";
            $temp = replaceCharsInNumber($format, '200'); //5069xxx
            $ecode = $temp .'-'. $today = date("Y");
            echo $ecode;


                break;
                case 'test2':
                $m_yearsetup = $this->RefYearSetup_model;
                $active_year = $m_yearsetup->getactiveyear();
                echo $active_year;
                break;

                case 'test3':
               $sql = 'UPDATE dtr_deductions SET is_deduct=1 WHERE dtr_deduction_id=185 AND deduction_id=8';
                $this->db->query($sql);
                break;

                case 'test4':
                $m_daily_time_record = $this->DailyTimeRecord_model;
                $employee_id = 3;
                $reg = 8;
                $per_hour_pay = $m_daily_time_record->get_per_hour_pay($employee_id,$reg);
                //echo $per_hour_pay."<br>";

                $factor_file = $m_daily_time_record->get_factorfile();
                echo $factor_file[0]->regular_ot;
                echo "<br>";
                echo $factor_file[0]->sunday;
                echo "<br>";
                echo $factor_file[0]->sunday_ot;
                echo "<br>";
                echo $factor_file[0]->regular_holiday;
                echo "<br>";
                echo $factor_file[0]->regular_holiday_ot;
                echo "<br>";
                echo $factor_file[0]->sun_regular_holiday;
                echo "<br>";
                echo $factor_file[0]->sun_regular_holiday_ot;
                echo "<br>";
                echo $factor_file[0]->spe_holiday;
                echo "<br>";
                echo $factor_file[0]->spe_holiday_ot;
                echo "<br>";
                echo $factor_file[0]->sun_spe_holiday;
                echo "<br>";
                echo $factor_file[0]->sun_spe_holiday_ot;
                echo "<br>";
                echo $factor_file[0]->pagibig1;
                echo "<br>";
                echo $factor_file[0]->pagibig2;
                echo "<br>";
                echo $factor_file[0]->night_shift;
                echo "<br>";
                echo $factor_file[0]->sun_night_shift;
                echo "<br>";
                echo $factor_file[0]->night_shift_reg_holiday;
                echo "<br>";
                echo $factor_file[0]->night_shift_spe_holiday;
                echo "<br>";
                echo $factor_file[0]->sun_night_shift_spe_holiday;
                break;

                case 'test5':
                $m_daily_time_record = $this->DailyTimeRecord_model;
                $test = $m_daily_time_record->Wtax_lookup();
                echo json_encode($test);
                break;


        }
    }











}
