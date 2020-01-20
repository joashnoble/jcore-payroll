<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SchedHolidaySetup extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        if($this->session->userdata('user_id') == FALSE) {
            redirect('../login');
        }
        if($this->session->userdata('right_schedholidaysetup_view') == 0 || $this->session->userdata('right_schedholidaysetup_view') == null) {
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
        $this->load->model('SchedHolidaySetup_model');
        $this->load->model('SchedRefDayType_model');
        $this->load->model('SchedEmployee_model');

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

        $data['ref_daytype']=$this->SchedRefDayType_model->get_list(array('ref_day_type.is_deleted'=>FALSE));
        $data['title'] = 'Holiday Setup';

        $this->load->view('sched_holiday_setup_view', $data);
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $response['data']=$this->SchedHolidaySetup_model->get_list(
                    array('sched_holiday_setup.is_deleted'=>FALSE),
                    'sched_holiday_setup.*,ref_day_type.daytype',
                    array(
                        array('ref_day_type','ref_day_type.ref_day_type_id=sched_holiday_setup.ref_day_type_id','left'),
                        )
                    );
                echo json_encode($response);
                break;

            case 'create':
                $m_ref_day_type = $this->SchedHolidaySetup_model;
                $this->load->library('form_validation');
                $this->load->helper('security');
                $this->form_validation->set_rules('ref_day_type_id', 'Day Type', 'strip_tags|xss_clean|required');
                if ($this->form_validation->run() == TRUE)
                {

                $checkdate = $m_ref_day_type->ifdateexist(date("Y-m-d", strtotime($this->input->post('date', TRUE))));
                if(count($checkdate) > 0){
                  $response['title'] = 'Notice!';
                  $response['stat'] = 'warning';
                  $response['msg'] = 'Sorry, cant add duplicate date.';
                  echo json_encode($response);
                  exit();
                }

                $m_ref_day_type->ref_day_type_id = $this->input->post('ref_day_type_id', TRUE);
                $m_ref_day_type->date = date("Y-m-d", strtotime($this->input->post('date', TRUE)));
                $m_ref_day_type->date_created = date("Y-m-d H:i:s");
                $m_ref_day_type->created_by = $this->session->user_id;
                $m_ref_day_type->save();

                $ref_day_type_id = $m_ref_day_type->last_insert_id();


                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Holiday Setup information successfully created.';

                $response['row_added'] = $this->SchedHolidaySetup_model->get_list(
                  $ref_day_type_id,
                  'sched_holiday_setup.*,ref_day_type.daytype',
                  array(
                      array('ref_day_type','ref_day_type.ref_day_type_id=sched_holiday_setup.ref_day_type_id','left'),
                      )
                  );
               }
                else
                {
                    $response['title'] = 'Error!';
                    $response['stat'] = 'error';
                    $response['msg'] = validation_errors();

                }
                echo json_encode($response);
            break;

            case 'delete':
                $m_ref_day_type=$this->SchedHolidaySetup_model;
                $sched_holiday_setup_id=$this->input->post('sched_holiday_setup_id',TRUE);
                $m_ref_day_type->delete_via_id($sched_holiday_setup_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg'] = 'Holiday Setup information successfully deleted.';
                echo json_encode($response);


            break;

            case 'update':
                $m_ref_day_type=$this->SchedHolidaySetup_model;
                $this->load->library('form_validation');
                $this->load->helper('security');
                $this->form_validation->set_rules('ref_day_type_id', 'Day Type', 'strip_tags|xss_clean|required');
                if ($this->form_validation->run() == TRUE)
                {

                $sched_holiday_setup_id=$this->input->post('sched_holiday_setup_id',TRUE);
                $verify_update=$this->SchedHolidaySetup_model->get_list(
                    $sched_holiday_setup_id,
                    'ref_day_type_id,date'
                    );

                if($verify_update[0]->date==date("Y-m-d", strtotime($this->input->post('date', TRUE))) &&  $verify_update[0]->ref_day_type_id == $this->input->post('ref_day_type_id', TRUE) ){
                    $response['title']='Notice';
                    $response['stat']='warning';
                    $response['msg'] = 'Sorry, cant add duplicate date.';
                    echo json_encode($response);
                    exit();
                }
                else{
                    $m_ref_day_type->ref_day_type_id = $this->input->post('ref_day_type_id', TRUE);
                    $m_ref_day_type->date = date("Y-m-d", strtotime($this->input->post('date', TRUE)));
                    $m_ref_day_type->date_modified = date("Y-m-d H:i:s");
                    $m_ref_day_type->deleted_by = $this->session->user_id;
                    $m_ref_day_type->modify($sched_holiday_setup_id);
                }


                $response['title']='Success';
                $response['stat']='success';
                $response['msg']='Holiday Setup information successfully updated.';
                $response['row_updated']=$this->SchedHolidaySetup_model->get_list(
                  $sched_holiday_setup_id,
                  'sched_holiday_setup.*,ref_day_type.daytype',
                  array(
                      array('ref_day_type','ref_day_type.ref_day_type_id=sched_holiday_setup.ref_day_type_id','left'),
                      )
                  );
                }
                else
                {
                    $response['title'] = 'Error!';
                    $response['stat'] = 'error';
                    $response['msg'] = validation_errors();

                }
                echo json_encode($response);
                break;

            case 'applysetuptoschedule':
                $this->SchedHolidaySetup_model->applysetuptoschedule();
                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Yearly Day type successfully applied.';
                echo json_encode($response);

            break;

        }
    }











}
