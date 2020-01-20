<?php

class Emp_resignation_model extends CORE_Model {
    protected  $table="emp_resignation_form";
    protected  $pk_id="emp_resignation_id";
    protected  $fk_id="employee_id";

    function __construct() {
        parent::__construct();
    }

    function getEmpResignationID($employee_clearance_id) {
        $query = $this->db->query("SELECT emp_resignation_id FROM emp_resignation_form WHERE employee_clearance_id=".$employee_clearance_id);
		return $query->result();
    }


}
?>
