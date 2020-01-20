<?php

class RefDepartment_model extends CORE_Model {
    protected  $table="ref_department";
    protected  $pk_id="ref_department_id";
    protected  $tabletocheck="emp_rates_duties";

    function __construct() {
        parent::__construct();
    }

    function checkifused($ref_department_id,$table='ref_department') {
    	$query = $this->db->query('SELECT * FROM '.$table.'
    		 INNER JOIN emp_rates_duties ON ref_department.ref_department_id=emp_rates_duties.ref_department_id
    		 WHERE ref_department.ref_department_id='.$ref_department_id.' LIMIT 1
    		');
            return $query->result();
    }

    function get_department_payslip($pay_period_id,$ref_department_id='all'){
        $query = $this->db->query("SELECT
                DISTINCT(rd.ref_department_id) as ref_department_id,
                rd.department,
                el.bank_account_isprocess as type
            FROM
                pay_slip ps
                LEFT JOIN daily_time_record dtr ON dtr.dtr_id = ps.dtr_id
                LEFT JOIN employee_list el ON el.employee_id = dtr.employee_id
                LEFT JOIN emp_rates_duties erd ON erd.emp_rates_duties_id = el.emp_rates_duties_id
                LEFT JOIN ref_department rd ON rd.ref_department_id = erd.ref_department_id
                WHERE dtr.pay_period_id = $pay_period_id
                ".($ref_department_id=='all'?"":" AND erd.ref_department_id=$ref_department_id")."
                GROUP BY el.bank_account_isprocess, rd.ref_department_id
                ORDER BY rd.department ASC");
        return $query->result();

    }

}
?>