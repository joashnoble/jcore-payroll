<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeePayrollRegister extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        if($this->session->userdata('right_payroll_register_waccount_view') == 0 || $this->session->userdata('right_payroll_register_waccount_view') == null) {
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

        $data['branch'] = $this->RefBranch_model->get_list('is_deleted = 0');
        $data['department'] = $this->RefDepartment_model->get_list('is_deleted = 0');
        $data['employee'] = $this->Employee_model->get_list('employee_list.is_deleted=0','employee_list.employee_id,CONCAT(employee_list.first_name," ",middle_name," ",employee_list.last_name) as full_name',null,'full_name ASC');
        $data['title'] = 'Employee Payroll Register';

        $this->load->view('payroll_register_view', $data);
    }


    function schedule($transaction=null,$filter_value=null,$filter_value2=null,$type=null){




        switch($transaction){

          

        }


    }


}
