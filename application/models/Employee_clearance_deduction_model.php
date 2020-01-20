<?php

class Employee_clearance_deduction_model extends CORE_Model {
    protected  $table="employee_clearance_deduction";
    protected  $pk_id="employee_clearance_deduction_id";
    protected  $fk_id="employee_clearance_id";

    function __construct() {
        parent::__construct();
    }

    function get_clearance_deduction($employee_clearance_id) {
      $query = $this->db->query("SELECT * FROM employee_clearance_deduction WHERE employee_clearance_id=".$employee_clearance_id);
                    return $query->result();
                          
    }    

    
}
?>