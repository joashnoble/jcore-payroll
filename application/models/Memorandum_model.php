<?php

class Memorandum_model extends CORE_Model {
    protected  $table="emp_memo";
    protected  $pk_id="emp_memo_id";

    function __construct() {
        parent::__construct();
    }

    function get_employee_memos($emp_id){
	$query = $this->db->query('SELECT 
			m_emp.date_memo, m_emp.remarks, rp.disciplinary_action_policy
			FROM emp_memo as m_emp
			LEFT JOIN ref_disciplinary_action_policy as rp ON
				rp.ref_disciplinary_action_policy_id = m_emp.ref_disciplinary_action_policy_id
			WHERE m_emp.employee_id = '.$emp_id.'
			AND m_emp.is_deleted = 0');
    $query->result();
    return $query->result();
	}
}
?>