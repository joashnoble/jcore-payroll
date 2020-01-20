<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RefClearanceReason extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        if($this->session->userdata('user_id') == FALSE) {
            redirect('../login');
        }
        if($this->session->userdata('right_clearancereason_view') == 0 || $this->session->userdata('right_clearancereason_view') == null) {
            redirect('../Dashboard');
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
        $this->load->model('RefClearanceReason_model');
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
        $data['title'] = 'Clearance Reason';

        $this->load->view('ref_clearance_reason_view', $data);
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
	            $response['data']=$this->RefClearanceReason_model->get_list(array('ref_clearance_reason.is_deleted'=>FALSE,));
                echo json_encode($response);
            break;

            case 'create':
                $m_clearance_reason = $this->RefClearanceReason_model;

                $clearance_description = $this->input->post('clearance_description', TRUE);

                $m_clearance_reason->clearance_description = $clearance_description;
                $m_clearance_reason->date_created = date("Y-m-d H:i:s");
                $m_clearance_reason->created_by = $this->session->user_id;
                $m_clearance_reason->save();

                $clearance_reason_id = $m_clearance_reason->last_insert_id();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Clearance Reason was successfully created.';

                $response['row_added'] = $this->RefClearanceReason_model->get_list($clearance_reason_id);
                echo json_encode($response);

            break;

            case 'delete':
                $m_clearance_reason = $this->RefClearanceReason_model;

                $clearance_reason_id=$this->input->post('clearance_reason_id',TRUE);

                $m_clearance_reason->is_deleted=1;
                $m_clearance_reason->date_deleted = date("Y-m-d H:i:s");
                $m_clearance_reason->deleted_by = $this->session->user_id;
                if($m_clearance_reason->modify($clearance_reason_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Clearance Reason was successfully deleted.';

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_clearance_reason = $this->RefClearanceReason_model;

                $clearance_reason_id=$this->input->post('clearance_reason_id',TRUE);
                $clearance_description = $this->input->post('clearance_description', TRUE);

                $m_clearance_reason->clearance_description = $clearance_description;
                $m_clearance_reason->date_modified = date("Y-m-d H:i:s");
                $m_clearance_reason->modified_by = $this->session->user_id;
                $m_clearance_reason->modify($clearance_reason_id);

                $response['title']='Success';
                $response['stat']='success';
                $response['msg']='Clearance Reason was successfully updated.';
                $response['row_updated']=$this->RefClearanceReason_model->get_list($clearance_reason_id);
                echo json_encode($response);

                break;
        }
    }
}
