<?php

class Employee_clearance_additional_model extends CORE_Model {
    protected  $table="employee_clearance_additional";
    protected  $pk_id="employee_clearance_additional_id";
    protected  $fk_id="employee_clearance_id";

    function __construct() {
        parent::__construct();
    }

    function get_clearance_additional($employee_clearance_id) {
        $query = $this->db->query("SELECT * FROM employee_clearance_additional WHERE employee_clearance_id=".$employee_clearance_id);
        return $query->result();
                          
    }    

    
}
?>