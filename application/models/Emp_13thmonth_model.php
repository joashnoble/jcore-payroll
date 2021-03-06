<?php

class Emp_13thmonth_model extends CORE_Model {
    protected  $table="emp_13thmonth";
    protected  $pk_id="emp_13thmonth_id";
    protected  $fk_id="year";

    function __construct() {
        parent::__construct();
    }


   function get_13thmonth_processed($year=null,$branch='all',$department='all',$emp_13thmonth_id=null,$status=null){
         $query = $this->db->query("SELECT 
			    emp_13thmonth.*,
			    CONCAT(el.last_name,', ',el.first_name,' ',el.middle_name) as fullname,
			    el.bank_account_isprocess, 
			    el.bank_account,
			    el.ecode,
			    el.email_address,
			    branch.*,
			    department.*
			FROM
			    emp_13thmonth
			    LEFT JOIN employee_list el ON el.employee_id = emp_13thmonth.employee_id
			    LEFT JOIN emp_rates_duties erd ON erd.emp_rates_duties_id = el.emp_rates_duties_id
			    LEFT JOIN ref_branch branch ON branch.ref_branch_id = erd.ref_branch_id
			    LEFT JOIN ref_department department ON department.ref_department_id = erd.ref_department_id
			    WHERE el.is_deleted = FALSE
			    AND erd.active_rates_duties = TRUE
			    ".($year==null?"":" AND emp_13thmonth.year = '".$year."'")."
			    ".($branch=='all'?"":" AND erd.ref_branch_id = '".$branch."'")."
			    ".($department=='all'?"":" AND erd.ref_department_id = '".$department."'")." 
			    ".($emp_13thmonth_id==null?"":" AND emp_13thmonth.emp_13thmonth_id = '".$emp_13thmonth_id."'")." 
                ".($status==1?' AND el.status="Active" AND el.is_retired="0"':'')."
                ".($status==2?' AND (el.status="Inactive" OR el.is_retired=1)':'')."
			    GROUP BY el.employee_id
			    ORDER BY el.last_name");
		return $query->result();
     }

}
?>