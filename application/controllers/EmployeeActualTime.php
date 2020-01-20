<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeeActualTime extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        if($this->session->userdata('right_employeeactual_view') == 0 || $this->session->userdata('right_employeeactual_view') == null) {
            redirect('../Dashboard');
        }
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
        $this->load->model('SchedEmployee_model');
        $this->load->model('RefPayPeriod_model');

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
        $data['payperiod'] = $this->RefPayPeriod_model->get_list('refpayperiod.is_deleted=0','refpayperiod.*',null,'pay_period_start DESC');
        $data['employee'] = $this->Employee_model->get_list('employee_list.is_deleted=0','employee_list.employee_id,CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name, employee_list.ecode',null,'full_name ASC');
        $data['title'] = 'Employee Schedule Report';

        $this->load->view('employee_actual_time_view', $data);
    }


    function schedule($transaction=null,$filter_value=null,$filter_value2=null,$type=null){

        switch($transaction){

            case 'emp_actual_time':
              $getcompany=$this->GeneralSettings_model->get_list(
              null,
              'company_setup.*'
              );
              $data['company']=$getcompany[0];
              $data['emp_info']=$this->Employee_model->get_list(
                            'employee_list.employee_id='.$filter_value,
                            'employee_list.*,CONCAT(employee_list.first_name," ",employee_list.middle_name," ",employee_list.last_name) as full_name
                            ,ref_branch.branch,ref_department.department',
                            array(
                                array('emp_rates_duties','emp_rates_duties.emp_rates_duties_id=employee_list.emp_rates_duties_id','left'),
                                array('ref_branch','ref_branch.ref_branch_id=emp_rates_duties.ref_branch_id','left'),
                                array('ref_department','ref_department.ref_department_id=emp_rates_duties.ref_department_id','left'),
                                )
                            );

              $data['payperiod']=$this->RefPayPeriod_model->get_list(
                            'pay_period_id='.$filter_value2,
                            'CONCAT(pay_period_start," ~ ",pay_period_end) as pay_period'
              );

              $data['emp_sched_report']=$this->SchedEmployee_model->get_list(
                  'schedule_employee.is_deleted=0 AND schedule_employee.employee_id='.$filter_value.' AND schedule_employee.pay_period_id='.$filter_value2.' ',
                  'schedule_employee.*,sched_refpay.schedpay,sched_refshift.shift,CONCAT(employee_list.first_name," ",employee_list.middle_name," ",employee_list.last_name) as full_name, employee_list.ecode,ref_day_type.daytype,
                        COALESCE(TIMESTAMPDIFF(MINUTE, schedule_employee.time_in, schedule_employee.clock_in)) as perlate',
                  array(
                      array('sched_refpay','sched_refpay.sched_refpay_id=schedule_employee.sched_refpay_id','left'),
                      array('sched_refshift','sched_refshift.sched_refshift_id=schedule_employee.sched_refshift_id','left'),
                      array('employee_list','employee_list.employee_id=schedule_employee.employee_id','left'),
                      array('ref_day_type','ref_day_type.ref_day_type_id=schedule_employee.ref_day_type_id','left'),
                      ),
                  'schedule_employee.date ASC'
                  );

                echo $this->load->view('template/employee_actual_time_html',$data,TRUE);
            break;
        }
    }

}
