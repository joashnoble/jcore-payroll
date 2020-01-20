<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RegularDeduction extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        if($this->session->userdata('user_id') == FALSE) {
            redirect('../login');
        }
        if($this->session->userdata('right_regdeduction_view') == 0 || $this->session->userdata('right_regdeduction_view') == null) {
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
        $this->load->model('RefReligion_model');
        $this->load->model('RefCourse_model');
        $this->load->model('RefRelationship_model');
        $this->load->model('RefLeave_model');
        $this->load->model('RefCertificate_model');
        $this->load->model('RefAction_model');
        $this->load->model('RefDiscipline_model');
        $this->load->model('RefCompensation_model');
        $this->load->model('RefYearSetup_model');
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
        $this->load->model('RefDeductionType_model');
        $this->load->model('RefDeductionSetup_model');
        $this->load->model('Regular_Deduction_model');
        $this->load->model('Reg_deduction_cycle_model');
        $this->load->model('Status_model');

    }

    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['_rights'] = $this->load->view('template/elements/rights', '', TRUE);
        $data['title'] = 'Regular Deduction';
        $data['loader'] = $this->load->view('template/elements/loader', '', TRUE);
        $data['loaderscript'] = $this->load->view('template/elements/loaderscript', '', TRUE);

        $data['employee_list']=$this->Employee_model->get_employee_list();
        $data['refdeduction']=$this->RefDeductionSetup_model->get_list('refdeduction.is_deleted=0 AND refdeduction.deduction_id!=1 AND refdeduction.deduction_id!=2 AND refdeduction.deduction_id!=3 AND refdeduction.deduction_id!=4',
              'refdeduction.deduction_id,refdeduction.deduction_desc',
              array(
                      array('refdeductiontype','refdeductiontype.deduction_type_id=refdeduction.deduction_type_id','left')
                  ));
        $data['refdeductiontype']=$this->RefDeductionType_model->get_list(array('refdeductiontype.is_deleted'=>FALSE));
        $data['new_deductions_regular']=$this->Regular_Deduction_model->get_list(array('new_deductions_regular.is_deleted'=>FALSE,));
        $data['refpayperiod']=$this->RefPayPeriod_model->get_list_for_deduction(0,0);
        $data['status']=$this->Status_model->get_list();
        $this->load->view('regulardeduction_view', $data);
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
              $response['data'] = $this->Regular_Deduction_model->get_regular_deduction();
              echo json_encode($response);

            break;

            case 'getrefpayperiod':
              $response['data'] = $this->RefPayPeriod_model->get_list_for_deduction(0,0);
              echo json_encode($response);
            break;

            case 'create':
                $m_deduction_regular = $this->Regular_Deduction_model;
                $m_reg_deduction_cycle=$this->Reg_deduction_cycle_model;
                $m_rpp = $this->RefPayPeriod_model;

                $user_id=$this->session->user_id;
                $employee_id = $this->input->post('employee_id', TRUE);
                $deduction_id = $this->input->post('deduction_id', TRUE);
                $this->load->library('form_validation');
                $this->load->helper('security');
                $this->load->helper(array('form', 'url'));
                $this->form_validation->set_rules('employee_id', 'Employee Name', 'required');

                $deduction_status_id = $this->input->post('deduction_status_id', TRUE);

                if ($this->form_validation->run() == TRUE)
                { 

                  if ($deduction_status_id == 1){ // Active
                    $loancheck = count($m_deduction_regular->checkifloanexists_1($employee_id,$deduction_id));
                  }else{
                    $loancheck = 0;
                  }

                  if($loancheck==0 || $loancheck==null){
                      $deduction_total_amount = $this->input->post('deduction_total_amount', TRUE);
                      $deduction_per_pay_amount = $this->input->post('deduction_per_pay_amount', TRUE);

                      $m_deduction_regular->employee_id = $this->input->post('employee_id', TRUE);
                      $m_deduction_regular->deduction_id = $this->input->post('deduction_id', TRUE);
                      $m_deduction_regular->deduction_cycle = $this->input->post('deduction_cycle', TRUE);
                      $m_deduction_regular->deduction_total_amount = $this->get_numeric_value($deduction_total_amount);
                      $m_deduction_regular->loan_total_amount = $this->get_numeric_value($deduction_total_amount);
                      $m_deduction_regular->deduction_per_pay_amount = $this->get_numeric_value($deduction_per_pay_amount);
                      $m_deduction_regular->deduction_regular_remarks = $this->input->post('deduction_regular_remarks', TRUE);
                      $m_deduction_regular->starting_date = date('Y-m-d', strtotime($this->input->post('starting_date', TRUE)));
                      $m_deduction_regular->ending_date = date('Y-m-d', strtotime($this->input->post('ending_date', TRUE)));
                      $m_deduction_regular->deduction_status_id = $this->input->post('deduction_status_id', TRUE);
                      $m_deduction_regular->date_created = date("Y-m-d H:i:s");
                      $m_deduction_regular->created_by = $this->session->user_id;
                      $m_deduction_regular->save();

                      $deduction_regular_id = $m_deduction_regular->last_insert_id();

                      $starting_date = date('Y-m-d', strtotime($this->input->post('starting_date', TRUE)));
                      $ending_date = date('Y-m-d', strtotime($this->input->post('ending_date', TRUE)));
                      $refpayperiod = $this->input->post('refpayperiod', TRUE);

                      $get_rpp = $m_rpp->get_all_rpp($starting_date,$ending_date);
                      for($i=0;$i<count($get_rpp);$i++){
                        $m_reg_deduction_cycle->deduction_regular_id = $deduction_regular_id;
                        $m_reg_deduction_cycle->pay_period_id = $get_rpp[$i]->pay_period_id;
                        $m_reg_deduction_cycle->save();
                      }

                      // for($i=0;$i<count($refpayperiod);$i++){
                      //     $m_reg_deduction_cycle->deduction_regular_id = $deduction_regular_id;
                      //     $m_reg_deduction_cycle->pay_period_id = $refpayperiod[$i];
                      //     $m_reg_deduction_cycle->save();
                      // }

                      $response['title'] = 'Success!';
                      $response['stat'] = 'success';
                      $response['msg'] = 'Deduction Regular information successfully created.';

                      $response['row_added'] = $this->Regular_Deduction_model->get_regular_deduction($deduction_regular_id);
                      echo json_encode($response);
                  }
                  else{
                      $response['title'] = 'Failure!';
                      $response['stat'] = 'error';
                      $response['msg'] = 'Active Loan/Deduction already Exist.';
                      echo json_encode($response);
                  }
                }
                else{
                  $response['title'] = 'Error!';
                  $response['stat'] = 'error';
                  $response['msg'] = validation_errors();
                }
            break;

            case 'delete':
                $m_deduction_regular=$this->Regular_Deduction_model;

                $deduction_regular_id=$this->input->post('deduction_regular_id',TRUE);
                $loan_status = $m_deduction_regular->verify_loan_status($deduction_regular_id);
                if($loan_status==0 || $loan_status==null){
                    $m_deduction_regular->is_deleted=1;
                    $m_deduction_regular->date_deleted = date("Y-m-d H:i:s");
                    $m_deduction_regular->deleted_by = $this->session->user_id;
                    if($m_deduction_regular->modify($deduction_regular_id)){
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Deduction Regular information successfully deleted.';

                        echo json_encode($response);
                    }
                }
                else{
                    $response['title']='Failure!';
                        $response['stat']='error';
                        $response['msg']='Cannot be deleted, Deduction Already Processed!.';

                        echo json_encode($response);
                }
                
            break;

            case 'getpayperiod':
                // $employee_id = $this->input->post('employee_id', TRUE);
                // $deduction_id = $this->input->post('deduction_id', TRUE);
                $response['data'] = $this->RefPayPeriod_model->get_list_for_deduction(0,0);
                echo json_encode($response);
            break;

            case 'getDeductionCycle':
                $deduction_regular_id = $this->input->post('deduction_regular_id',TRUE);
                $response['data'] = $this->Reg_deduction_cycle_model->getDeductionCycle($deduction_regular_id);
                echo json_encode($response);
            break;

            case 'update':
                $m_deduction_regular=$this->Regular_Deduction_model;
                $m_reg_deduction_cycle=$this->Reg_deduction_cycle_model;
                $m_rpp = $this->RefPayPeriod_model;
                $m_employee=$this->Employee_model;

                $deduction_regular_id=$this->input->post('deduction_regular_id',TRUE);
                $deduction_status_id=$this->input->post('deduction_status_id', TRUE); 
                $loan_employee = $m_deduction_regular->getloanemployee($deduction_regular_id);
                $employee_id = $loan_employee[0]->employee_id;
                $deduction_id = $loan_employee[0]->deduction_id;
                $full_name = $loan_employee[0]->full_name;
                $deduction_desc = $loan_employee[0]->deduction_desc;

                if ($deduction_status_id == 1){ // Active

                    $loancheck = count($m_deduction_regular->checkifloanexists_1($employee_id,$deduction_id,$deduction_regular_id));
                    
                    if($loancheck!=0){

                      $response['title'] = 'Error!';
                      $response['stat'] = 'error';
                      $response['msg'] = 'There still an active '.$deduction_desc.' for '.$full_name.'.';
                      echo json_encode($response);
                      exit();

                    }
                }

                $deduction_total_amount = $this->input->post('deduction_total_amount', TRUE);
                $deduction_per_pay_amount = $this->input->post('deduction_per_pay_amount', TRUE);

                $refpayperiod = $this->input->post('refpayperiod', TRUE);

                $m_deduction_regular->deduction_cycle = $this->input->post('deduction_cycle', TRUE);
                $m_deduction_regular->deduction_total_amount = $this->get_numeric_value($deduction_total_amount);
                $m_deduction_regular->loan_total_amount = $this->get_numeric_value($deduction_total_amount);
                $m_deduction_regular->deduction_per_pay_amount = $this->get_numeric_value($deduction_per_pay_amount);
                $m_deduction_regular->deduction_regular_remarks = $this->input->post('deduction_regular_remarks', TRUE);
                $m_deduction_regular->starting_date = date('Y-m-d', strtotime($this->input->post('starting_date', TRUE)));
                $m_deduction_regular->ending_date = date('Y-m-d', strtotime($this->input->post('ending_date', TRUE)));    
                $m_deduction_regular->deduction_status_id = $this->input->post('deduction_status_id', TRUE);                
                $m_deduction_regular->date_modified = date("Y-m-d H:i:s");
                $m_deduction_regular->modified_by = $this->session->user_id;
                $m_deduction_regular->modify($deduction_regular_id);

                $m_reg_deduction_cycle->delete_via_fk($deduction_regular_id);

                $starting_date = date('Y-m-d', strtotime($this->input->post('starting_date', TRUE)));
                $ending_date = date('Y-m-d', strtotime($this->input->post('ending_date', TRUE)));
                $refpayperiod = $this->input->post('refpayperiod', TRUE);

                $get_rpp = $m_rpp->get_all_rpp($starting_date,$ending_date);
                for($i=0;$i<count($get_rpp);$i++){
                  $m_reg_deduction_cycle->deduction_regular_id = $deduction_regular_id;
                  $m_reg_deduction_cycle->pay_period_id = $get_rpp[$i]->pay_period_id;
                  $m_reg_deduction_cycle->save();
                }

                $response['title']='Success';
                $response['stat']='success';
                $response['msg'] = $full_name."'s ".$deduction_desc." successfully updated";
                $response['row_updated'] = $this->Regular_Deduction_model->get_regular_deduction($deduction_regular_id);

                echo json_encode($response);
            break;

        }
    }
}
