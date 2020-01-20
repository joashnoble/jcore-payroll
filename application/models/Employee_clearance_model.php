<?php

class Employee_clearance_model extends CORE_Model {
    protected  $table="employee_clearance";
    protected  $pk_id="employee_clearance_id";
    protected  $fk_id="employee_id";

    function __construct() {
        parent::__construct();
    }

    function get_clearance_list($employee_clearance_id) {
      $query = $this->db->query("SELECT 
                    employee_clearance.*,
                    employee_clearance.net_total,
                    el.ecode,
                    ref_department.department,
                    ref_position.position,
                    emp_rates_duties.salary_reg_rates,
                    CONCAT(el.first_name,
                            ' ',
                            el.middle_name,
                            ' ',
                            el.last_name) AS full_name,
                    CONCAT(elist.first_name,
                            ' ',
                            elist.middle_name,
                            ' ',
                            elist.last_name) AS cleared_by_fullname,
                    ref_clearance_reason.clearance_description, 
                    DATE_FORMAT(employee_clearance.date_cleared,
                            '%m/%d/%Y') AS date_cleared,
                    (CASE
                      WHEN clearance_status = 1
                      THEN 'Finalized'
                      ELSE 'Pending'
                    END) AS clearance_status
                FROM
                    employee_clearance
                        LEFT JOIN
                    employee_list el ON el.employee_id = employee_clearance.employee_id
                        LEFT JOIN
                    employee_list elist ON elist.employee_id = employee_clearance.cleared_by
                        LEFT JOIN
                    emp_rates_duties ON emp_rates_duties.emp_rates_duties_id = el.emp_rates_duties_id
                        LEFT JOIN
                    ref_branch ON ref_branch.ref_branch_id = emp_rates_duties.ref_branch_id
                        LEFT JOIN
                    ref_department ON ref_department.ref_department_id = emp_rates_duties.ref_department_id
                        LEFT JOIN
                    ref_position ON ref_position.ref_position_id = emp_rates_duties.ref_position_id
                        LEFT JOIN
                    ref_clearance_reason ON ref_clearance_reason.clearance_reason_id = employee_clearance.clearance_reason_id
                    WHERE employee_clearance.is_deleted = 0 
                    ".($employee_clearance_id==null?"":" AND employee_clearance.employee_clearance_id=".$employee_clearance_id."")."
                    ");
                    return $query->result();
                          
    }    

    function get_employee_info($employee_id) {
                  $query = $this->db->query("SELECT 
                employee_list.*,
                CONCAT(employee_list.first_name,
                        ' ',
                        employee_list.middle_name,
                        ' ',
                        employee_list.last_name) AS full_name,
                ref_branch.branch,
                ref_department.department,
                emp_rates_duties.*,
                ref_position.position
            FROM
                employee_list
                    LEFT JOIN
                emp_rates_duties ON emp_rates_duties.emp_rates_duties_id = employee_list.emp_rates_duties_id
                    LEFT JOIN
                ref_branch ON ref_branch.ref_branch_id = emp_rates_duties.ref_branch_id
                    LEFT JOIN
                ref_department ON ref_department.ref_department_id = emp_rates_duties.ref_department_id
                    LEFT JOIN
                ref_position ON ref_position.ref_position_id = emp_rates_duties.ref_position_id
            WHERE
                employee_list.is_deleted = 0
                AND employee_list.employee_id = ".$employee_id."
            ORDER BY full_name ASC");
            return $query->result();
   }
    
}
?>