<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmployeeClearance extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        if($this->session->userdata('user_id') == FALSE) {
            redirect('../login');
        }
        if($this->session->userdata('right_employeeclearance_view') == 0 || $this->session->userdata('right_employeeclearance_view') == null) {
            redirect('../Dashboard');
        }

        $this->validate_session();
        $this->load->model('RefYearSetup_model');
        $this->load->model('Employee_model');
        $this->load->model('RatesDuties_model');
        $this->load->model('Ref_Emptype_model');
        $this->load->model('RefDepartment_model');
        $this->load->model('RefPosition_model');
        $this->load->model('RefBranch_model');
        $this->load->model('RefSection_model');
        $this->load->model('RefReligion_model');
        $this->load->model('RefCourse_model');
        $this->load->model('RefRelationship_model');
        $this->load->model('RefLeave_model');
        $this->load->model('RefCertificate_model');
        $this->load->model('RefAction_model');
        $this->load->model('RefDiscipline_model');
        $this->load->model('RefCompensation_model');
        $this->load->model('RefPayment_model');
        $this->load->model('RefSSS_Contribution_model');
        $this->load->model('RefPhilHealth_Contribution_model');
        $this->load->model('RefGroup_model');
        $this->load->model('RefEarningSetup_model');
        $this->load->model('RefEarningType_model');
        $this->load->model('RefPayPeriod_model');
        $this->load->model('Employee_clearance_model');
        $this->load->model('RefClearanceReason_model');
        $this->load->model('Payslip_model');
        $this->load->model('PayrollReports_model');
        $this->load->model('GeneralSettings_model');
        $this->load->model('Employee_clearance_deduction_model');
        $this->load->model('Emp_resignation_model');
        $this->load->model('Emp_13thmonth_model');
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

        $data['employee_list']=$this->Employee_model->getEmplistBy(
                    array('employee_list.status !="Inactive" AND employee_list.is_deleted = 0'),
                    'employee_list.*,CONCAT(employee_list.first_name," ",employee_list.middle_name," ",employee_list.last_name) as full_name
                    ,ref_branch.branch,ref_department.department,emp_rates_duties.*,ref_position.position',
                    array(
                        array('emp_rates_duties','emp_rates_duties.emp_rates_duties_id=employee_list.emp_rates_duties_id','left'),
                        array('ref_branch','ref_branch.ref_branch_id=emp_rates_duties.ref_branch_id','left'),
                        array('ref_department','ref_department.ref_department_id=emp_rates_duties.ref_department_id','left'),
                        array('ref_position','ref_position.ref_position_id=emp_rates_duties.ref_position_id','left'),
                        ),
                   'full_name ASC'
                    );
        $data['employee_clearance']=$this->Employee_model->getEmplist();
        $data['clearance_reason'] = $this->RefClearanceReason_model->get_list(array('ref_clearance_reason.is_deleted'=>FALSE));

        $data['title'] = 'Employee Clearance';

        $this->load->view('employee_clearance_view', $data);
    }

    function transaction($txn = null, $filter_value = null) {
        switch ($txn) {
            case 'list':
	            $response['data']=$this->Employee_clearance_model->get_clearance_list(null);
                echo json_encode($response);
            break;

            case 'last_payroll':
                $employee_id = $this->input->post('employee_id', TRUE);
                $pay_slip = $this->Payslip_model->get_last_payroll($employee_id);
                $pay_slip_id = $pay_slip[0]->pay_slip_id;
                $response['data']=$this->Payslip_model->get_list($pay_slip_id);
                echo json_encode($response);
            break;

            case 'get13thmonth':
                $m_13thmonth = $this->Emp_13thmonth_model;
                $employee_id = $this->input->post('employee_id', TRUE);
                $year = date('Y');

                $year_setup = $this->RefYearSetup_model->getYearSetup($year);
                $start_13thmonth_date = ''; $end_13thmonth_date = ''; $factor = 0;

                if (count($year_setup) > 0){
                    $start_13thmonth_date = $year_setup[0]->start_13thmonth_date;
                    $end_13thmonth_date = $year_setup[0]->end_13thmonth_date;
                    $factor = $year_setup[0]->factor_setup;
                }else{
                    $start_13thmonth_date = $year.'-01-01';
                    $end_13thmonth_date = $year.'-12-31';
                    $factor = 12;
                }

                $response['data']=$m_13thmonth->get_13thmonth($year,'all','all',$employee_id,$start_13thmonth_date,$end_13thmonth_date,$factor);
                // $response['data']=$this->PayrollReports_model->get_accumulated_13thmonthpay($employee_id);

                echo json_encode($response);
            break;

            case 'print_emp_clearance':

                $getcompany=$this->GeneralSettings_model->get_list(
                null,
                'company_setup.*'
                );
                $data['company']=$getcompany[0];

                $data['clearance']=$this->Employee_clearance_model->get_clearance_list($filter_value);
                $data['clearance_deduction']=$this->Employee_clearance_deduction_model->get_clearance_deduction($filter_value);

                echo $this->load->view('template/employee_clearance_html',$data,TRUE);
            break;

            case 'getDeductions':
                $employee_clearance_id = $this->input->post('employee_clearance_id', TRUE);
                $response['data']=$this->Employee_clearance_deduction_model->get_clearance_deduction($employee_clearance_id);
                echo json_encode($response);
            break;

            case 'getEmpInfo':
                $employee_id = $this->input->post('employee_id', TRUE);
                $response['data']=$this->Employee_clearance_model->get_employee_info($employee_id);
                echo json_encode($response);
            break;

            case 'getAllemployees':
                $response['data']=$this->Employee_model->getEmplist();
                echo json_encode($response);
            break;

            case 'create':
                $m_clearance = $this->Employee_clearance_model;
                $m_clearance_deduction = $this->Employee_clearance_deduction_model;
                $m_resignation = $this->Emp_resignation_model;

                $currentDate = date('Y-m-d H:i:s');
                $employee_id = $this->input->post('employee_id', TRUE);
                $accumulated_13thmonth_pay = $this->input->post('accumulated_13thmonth_pay', TRUE);
                $additional_pay = $this->input->post('additional_pay', TRUE);
                $total_due_date = $this->input->post('total_due_date', TRUE);
                $no_of_leave = $this->input->post('no_of_leave', TRUE);
                $leave_pay = $this->input->post('leave_pay', TRUE);
                $total_leave = $this->input->post('total_leave', TRUE);
                $tax_refund = $this->input->post('tax_refund', TRUE);
                $last_payroll = $this->input->post('last_payroll', TRUE);
                $net_total = $this->input->post('net_total', TRUE);
                $date_cleared = date('Y-m-d', strtotime($this->input->post('date_cleared', TRUE)));
                $cleared_by = $this->input->post('cleared_by', TRUE);
                $grand_total = $this->input->post('grand_total', TRUE);
                $clearance_reason_id = $this->input->post('clearance_reason_id', TRUE);
                $deduction_description = $this->input->post('deduction_description', TRUE);
                $deduction_amount = $this->input->post('deduction_amount', TRUE);
                $include_last_pay = $this->input->post('include_last_pay', TRUE);
                $payslip_no = $this->input->post('payslip_no', TRUE);
                $reason_of_leave = $this->input->post('reason_of_leave', TRUE);

                $m_clearance->employee_id = $employee_id;
                $m_clearance->accumulated_13thmonth_pay = $this->get_numeric_value($accumulated_13thmonth_pay);
                $m_clearance->additional_pay = $this->get_numeric_value($additional_pay);
                $m_clearance->total_due_date = $this->get_numeric_value($total_due_date);
                $m_clearance->no_of_leave = $no_of_leave;
                $m_clearance->leave_pay = $this->get_numeric_value($leave_pay);
                $m_clearance->total_leave = $this->get_numeric_value($total_leave);
                $m_clearance->tax_refund = $this->get_numeric_value($tax_refund);
                $m_clearance->last_payroll = $this->get_numeric_value($last_payroll);
                $m_clearance->net_total = $this->get_numeric_value($net_total);
                $m_clearance->date_cleared = $date_cleared;
                $m_clearance->cleared_by = $cleared_by;
                $m_clearance->grand_total = $this->get_numeric_value($grand_total);
                $m_clearance->clearance_reason_id = $clearance_reason_id;
                $m_clearance->include_last_pay = $include_last_pay;
                $m_clearance->created_by = $this->session->user_id;
                $m_clearance->date_created = $currentDate;
                $m_clearance->payslip_no = $payslip_no;
                $m_clearance->save();

                $employee_clearance_id = $m_clearance->last_insert_id();

                for ($i=0;$i<count($deduction_description);$i++) { 
                     $m_clearance_deduction->employee_clearance_id = $employee_clearance_id;
                     $m_clearance_deduction->deduction_description = $deduction_description[$i];
                     $m_clearance_deduction->deduction_amount = $this->get_numeric_value($deduction_amount[$i]);
                     $m_clearance_deduction->save();
                 } 

                $m_resignation->employee_id = $employee_id;
                $m_resignation->employee_clearance_id = $employee_clearance_id;
                $m_resignation->reason_of_leave = $reason_of_leave;
                $m_resignation->approved_by = $cleared_by;
                $m_resignation->date_created = $currentDate;
                $m_resignation->created_by = $this->session->user_id;
                $m_resignation->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Employee Clearance successfully created.';

                $response['row_added'] = $this->Employee_clearance_model->get_clearance_list($employee_clearance_id);
                echo json_encode($response);
            break;

            case 'finalize':
                $m_clearance = $this->Employee_clearance_model;
                $m_employee = $this->Employee_model;
                $m_resignation = $this->Emp_resignation_model;

                $employee_clearance_id=$this->input->post('employee_clearance_id',TRUE);
                $employee_id=$this->input->post('employee_id',TRUE);
                $clearance = $this->Employee_clearance_model->get_clearance_list($employee_clearance_id);

                $m_clearance->clearance_status=1;

                if($m_clearance->modify($employee_clearance_id)){

                        $m_employee->date_end = date('Y-m-d',strtotime($clearance[0]->date_cleared));
                        $m_employee->clearance_reason = $clearance[0]->clearance_reason_id;
                        $m_employee->status = 'Inactive';
                        $m_employee->modify($employee_id);

                        $emp_resignation = $this->Emp_resignation_model->getEmpResignationID($employee_clearance_id);

                        if (count($emp_resignation) > 0){
                            $emp_resignation_id = $emp_resignation[0]->emp_resignation_id;

                            $m_resignation->is_cleared = 1;
                            $m_resignation->modify($emp_resignation_id);
                        }

                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Employee Clearance successfully finalized.';
                    }

                $response['row_updated'] = $this->Employee_clearance_model->get_clearance_list($employee_clearance_id);
                echo json_encode($response);
            break;

            case 'delete':
                $m_clearance = $this->Employee_clearance_model;
                $m_clearance_deduction = $this->Employee_clearance_deduction_model;

                $employee_clearance_id=$this->input->post('employee_clearance_id',TRUE);

                $chck_status = $this->Employee_clearance_model->get_clearance_list($employee_clearance_id);

                if ($chck_status[0]->clearance_status == "Finalized"){
                    $response['title']='Error!';
                    $response['stat']='error';
                    $response['msg']='Sorry clearance is already finalized.';
                }else{
                    $m_clearance->is_deleted=1;
                    $m_clearance->date_deleted = date("Y-m-d H:i:s");
                    $m_clearance->deleted_by = $this->session->user_id;

                    if($m_clearance->modify($employee_clearance_id)){
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Clearance successfully deleted.';
                    }
                }

                echo json_encode($response);
            break;

            case 'update':
                $m_clearance = $this->Employee_clearance_model;
                $m_clearance_deduction = $this->Employee_clearance_deduction_model;

                $employee_clearance_id = $this->input->post('employee_clearance_id', TRUE);
                $currentDate = date('Y-m-d H:i:s');
                $employee_id = $this->input->post('employee_id', TRUE);
                $accumulated_13thmonth_pay = $this->input->post('accumulated_13thmonth_pay', TRUE);
                $additional_pay = $this->input->post('additional_pay', TRUE);
                $total_due_date = $this->input->post('total_due_date', TRUE);
                $no_of_leave = $this->input->post('no_of_leave', TRUE);
                $leave_pay = $this->input->post('leave_pay', TRUE);
                $total_leave = $this->input->post('total_leave', TRUE);
                $tax_refund = $this->input->post('tax_refund', TRUE);
                $last_payroll = $this->input->post('last_payroll', TRUE);
                $net_total = $this->input->post('net_total', TRUE);
                $date_cleared = date('Y-m-d', strtotime($this->input->post('date_cleared', TRUE)));
                $cleared_by = $this->input->post('cleared_by', TRUE);
                $grand_total = $this->input->post('grand_total', TRUE);
                $clearance_reason_id = $this->input->post('clearance_reason_id', TRUE);
                $deduction_description = $this->input->post('deduction_description', TRUE);
                $deduction_amount = $this->input->post('deduction_amount', TRUE);
                $include_last_pay = $this->input->post('include_last_pay', TRUE);
                $payslip_no = $this->input->post('payslip_no', TRUE);

                $m_clearance->accumulated_13thmonth_pay = $this->get_numeric_value($accumulated_13thmonth_pay);
                $m_clearance->additional_pay = $this->get_numeric_value($additional_pay);
                $m_clearance->total_due_date = $this->get_numeric_value($total_due_date);
                $m_clearance->no_of_leave = $no_of_leave;
                $m_clearance->leave_pay = $this->get_numeric_value($leave_pay);
                $m_clearance->total_leave = $this->get_numeric_value($total_leave);
                $m_clearance->tax_refund = $this->get_numeric_value($tax_refund);
                $m_clearance->last_payroll = $this->get_numeric_value($last_payroll);
                $m_clearance->net_total = $this->get_numeric_value($net_total);
                $m_clearance->date_cleared = $date_cleared;
                $m_clearance->cleared_by = $cleared_by;
                $m_clearance->grand_total = $this->get_numeric_value($grand_total);
                $m_clearance->clearance_reason_id = $clearance_reason_id;
                $m_clearance->include_last_pay = $include_last_pay;
                $m_clearance->created_by = $this->session->user_id;
                $m_clearance->date_created = $currentDate;
                $m_clearance->payslip_no = $payslip_no;
                $m_clearance->modify($employee_clearance_id);

                $m_clearance_deduction->delete_via_fk($employee_clearance_id);

                for ($i=0;$i<count($deduction_description);$i++) { 
                     $m_clearance_deduction->employee_clearance_id = $employee_clearance_id;
                     $m_clearance_deduction->deduction_description = $deduction_description[$i];
                     $m_clearance_deduction->deduction_amount = $this->get_numeric_value($deduction_amount[$i]);
                     $m_clearance_deduction->save();
                 } 

                $response['title']='Success';
                $response['stat']='success';
                $response['msg']='Employee Clearance information successfully updated.';
                $response['row_updated'] = $this->Employee_clearance_model->get_clearance_list($employee_clearance_id);
                echo json_encode($response);

                break;

        }
    }
}
