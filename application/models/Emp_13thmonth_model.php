<?php

class Emp_13thmonth_model extends CORE_Model {
    protected  $table="emp_13thmonth";
    protected  $pk_id="emp_13thmonth_id";
    protected  $fk_id="year";

    function __construct() {
        parent::__construct();
    }

    function get_employee_branch($employee_id){
    	$query = $this->db->query("SELECT 
		   ref_branch_id
		FROM
		    employee_list elist
		    LEFT JOIN emp_rates_duties rates ON rates.emp_rates_duties_id = elist.emp_rates_duties_id
		    WHERE elist.employee_id = $employee_id");
		return $query->result();	
	}

	function get_last_batch($year){
		$query = $this->db->query("SELECT 
		    (CASE
		        WHEN main.batch_id > 1 THEN 2
		        ELSE 1
		    END) AS batch_id
		FROM
		    (SELECT 
		        COALESCE(MAX(batch_id), 0) + 1 AS batch_id
		    FROM
		        emp_13thmonth
		    WHERE
		        year = $year) AS main");
		return $query->result();
	}

	function get_13thmonth($year=null,$branch_id='all',$department_id='all',$employee_id=null,$start_date,$end_date,$factor=12,$status='All'){
		$query = $this->db->query("SELECT 
			    x.*,
                ((x.total_13thmonth+x.retro +x.dayswithpayamt) - x.total_days_wout_pay_amt) AS total_reg_days_pay
			FROM
			    (SELECT 
					main.employee_id,
                    main.fullname,
					(total_13thmonth - pro_total_13thmonth) as total_13thmonth,
                    (retro - pro_retro) as retro,
                    (dayswithpayamt - pro_dayswithpayamt) as dayswithpayamt,
                    (for_13th_month - pro_for_13th_month) as for_13th_month,
                    (total_days_wout_pay_amt - pro_total_days_wout_pay_amt) as total_days_wout_pay_amt,
                    (grand_13thmonth_pay - pro_13thmonth_pay) AS balance
			    FROM
			        (SELECT 
			        ps.*,
			            CONCAT(el.last_name, ', ', el.first_name, ' ', el.middle_name) AS fullname,
			            SUM(ps.reg_pay) AS total_reg,
			            erd.salary_reg_rates,
			            SUM(dtr.reg_amt) AS total_reg_amt,
			            SUM(erd.salary_reg_rates) AS total_basic_pay,
			            SUM(dtr.for_13th_month) as for_13th_month,
			            SUM(dtr.for_13th_month) AS total_13thmonth,
			            SUM(ps.days_with_pay_amt) AS dayswithpayamt,
			            SUM(ps.days_wout_pay_amt) AS total_days_wout_pay_amt,
			            SUM(ps.minutes_late_amt) AS total_minutes_late_amt,
			            COALESCE(SUM(salary_retro.earnings_amount), 0) AS retro,
			            el.employee_id,
			            ((SUM(dtr.for_13th_month) + COALESCE(SUM(salary_retro.earnings_amount), 0) + SUM(ps.days_with_pay_amt)) - SUM(ps.days_wout_pay_amt)) AS total_reg_days_pay,
			            ROUND(((((SUM(dtr.for_13th_month) + COALESCE(SUM(salary_retro.earnings_amount), 0) + SUM(ps.days_with_pay_amt)) - SUM(ps.days_wout_pay_amt))) / 12),2) AS grand_13thmonth_pay,
			            

			            COALESCE((SELECT 
			                    SUM(emp_13thmonth.for_13th_month) AS pro_for_13th_month
			                FROM
			                    emp_13thmonth
			                WHERE
			                    emp_13thmonth.employee_id = dtr.employee_id
			                        AND emp_13thmonth.year = rpp.pay_period_year
			                GROUP BY emp_13thmonth.employee_id), 0) AS pro_for_13th_month,

			            COALESCE((SELECT 
			                    SUM(emp_13thmonth.retro) AS pro_retro
			                FROM
			                    emp_13thmonth
			                WHERE
			                    emp_13thmonth.employee_id = dtr.employee_id
			                        AND emp_13thmonth.year = rpp.pay_period_year
			                GROUP BY emp_13thmonth.employee_id), 0) AS pro_retro,  

			            COALESCE((SELECT 
			                    SUM(emp_13thmonth.dayswithpayamt) AS pro_dayswithpayamt
			                FROM
			                    emp_13thmonth
			                WHERE
			                    emp_13thmonth.employee_id = dtr.employee_id
			                        AND emp_13thmonth.year = rpp.pay_period_year
			                GROUP BY emp_13thmonth.employee_id), 0) AS pro_dayswithpayamt, 

			            COALESCE((SELECT 
			                    SUM(emp_13thmonth.total_13thmonth) AS pro_total_13thmonth
			                FROM
			                    emp_13thmonth
			                WHERE
			                    emp_13thmonth.employee_id = dtr.employee_id
			                        AND emp_13thmonth.year = rpp.pay_period_year
			                GROUP BY emp_13thmonth.employee_id), 0) AS pro_total_13thmonth, 			                 
			            COALESCE((SELECT 
			                    SUM(emp_13thmonth.grand_13thmonth_pay) AS pro_13thmonth_pay
			                FROM
			                    emp_13thmonth
			                WHERE
			                    emp_13thmonth.employee_id = dtr.employee_id
			                        AND emp_13thmonth.year = rpp.pay_period_year
			                GROUP BY emp_13thmonth.employee_id), 0) AS pro_13thmonth_pay,
						
                        COALESCE((SELECT 
			                    SUM(emp_13thmonth.total_days_wout_pay_amt) AS pro_total_days_wout_pay_amt
			                FROM
			                    emp_13thmonth
			                WHERE
			                    emp_13thmonth.employee_id = dtr.employee_id
			                        AND emp_13thmonth.year = rpp.pay_period_year
			                GROUP BY emp_13thmonth.employee_id), 0) AS pro_total_days_wout_pay_amt
						
					
								
			    FROM
			        pay_slip AS ps
			    LEFT JOIN daily_time_record AS dtr ON ps.dtr_id = dtr.dtr_id
			    LEFT JOIN employee_list AS el ON dtr.employee_id = el.employee_id
			    LEFT JOIN emp_rates_duties AS erd ON el.employee_id = erd.employee_id
			    LEFT JOIN refpayperiod AS rpp ON dtr.pay_period_id = rpp.pay_period_id
			    LEFT JOIN (SELECT 
			        pay_slip_id, (earnings_amount) AS earnings_amount
			    FROM
			        pay_slip_other_earnings
			    WHERE
			        earnings_id = 7) AS salary_retro ON ps.pay_slip_id = salary_retro.pay_slip_id
			    WHERE
			        el.is_deleted = 0
			            AND rpp.pay_period_year = $year
			            AND erd.active_rates_duties = 1
			            AND el.employee_id NOT IN (SELECT DISTINCT employee_clearance.employee_id FROM employee_clearance WHERE employee_clearance.is_deleted=0) 
						".($employee_id==null?"":" AND dtr.employee_id = '".$employee_id."'")." 
			            ".($branch_id=='all'?"":" AND erd.ref_branch_id = '".$branch_id."'")." 
			            ".($department_id=='all'?"":" AND erd.ref_department_id = '".$department_id."'")."
			            ".($status=='Active'?" AND (el.status = '".$status."' OR el.is_retired = 0)":"")."
			            ".($status=='Inactive'?" AND (el.status = '".$status."' OR el.is_retired = 1)":"")."
			            GROUP BY el.employee_id
			            ORDER BY el.last_name ASC) AS main) AS x
			WHERE
			    x.balance > 0");
		return $query->result();
	}

   function get_13thmonth_processed($year=null,$branch='all',$department='all',$emp_13thmonth_id=null,$employee_id=null,$batch_id=null,$status=null){
         $query = $this->db->query("SELECT 
			    emp_13thmonth.*,
			    CONCAT(el.last_name,', ',el.first_name,' ',el.middle_name) as fullname,
			    el.bank_account_isprocess, 
			    el.bank_account,
			    el.ecode,
			    el.email_address,
			    branch.*,
			    department.*,
			    (emp_13thmonth.total_13thmonth + emp_13thmonth.dayswithpayamt) as total_reg_days_pay
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
			    ".($employee_id==null?"":" AND emp_13thmonth.employee_id = '".$employee_id."'")." 
			    ".($batch_id==null?"":" AND emp_13thmonth.batch_id = '".$batch_id."'")." 
			    ".($status==1?" AND el.status='Active' AND el.is_retired=0":"")."
                ".($status==2?" AND (el.status='Inactive' OR el.is_retired=1)":"")."
			    GROUP BY el.employee_id
			    ORDER BY el.last_name");
		return $query->result();
     }

   function get_13thmonth_allprocessed($year=null,$branch='all',$department='all',$emp_13thmonth_id=null,$employee_id=null,$batch_id=null,$status=null){
         $query = $this->db->query("SELECT 
		    emp_13thmonth.emp_13thmonth_no,
		    emp_13thmonth.year,
		    SUM(emp_13thmonth.for_13th_month) as for_13th_month,
		    SUM(emp_13thmonth.retro) as retro,
		    SUM(emp_13thmonth.dayswithpayamt) as dayswithpayamt,
		    SUM(emp_13thmonth.total_13thmonth) as total_13thmonth,
		    SUM(emp_13thmonth.total_days_wout_pay_amt) as total_days_wout_pay_amt,
		    SUM(emp_13thmonth.grand_13thmonth_pay) as grand_13thmonth_pay,
		    (SUM(emp_13thmonth.total_13thmonth) + SUM(emp_13thmonth.dayswithpayamt)) AS total_reg_days_pay,
		    CONCAT(el.last_name,
		            ', ',
		            el.first_name,
		            ' ',
		            el.middle_name) AS fullname,
		    el.bank_account_isprocess,
		    el.bank_account,
		    el.ecode,
		    el.email_address,
		    branch.*,
		    department.*
		FROM
		    emp_13thmonth
		        LEFT JOIN
		    employee_list el ON el.employee_id = emp_13thmonth.employee_id
		        LEFT JOIN
		    emp_rates_duties erd ON erd.emp_rates_duties_id = el.emp_rates_duties_id
		        LEFT JOIN
		    ref_branch branch ON branch.ref_branch_id = erd.ref_branch_id
		        LEFT JOIN
		    ref_department department ON department.ref_department_id = erd.ref_department_id
		WHERE
		    el.is_deleted = FALSE
		        AND erd.active_rates_duties = TRUE
			    ".($year==null?"":" AND emp_13thmonth.year = '".$year."'")."
			    ".($branch=='all'?"":" AND erd.ref_branch_id = '".$branch."'")."
			    ".($department=='all'?"":" AND erd.ref_department_id = '".$department."'")." 
			    ".($emp_13thmonth_id==null?"":" AND emp_13thmonth.emp_13thmonth_id = '".$emp_13thmonth_id."'")." 
			    ".($employee_id==null?"":" AND emp_13thmonth.employee_id = '".$employee_id."'")." 
			    ".($status==1?" AND el.status='Active' AND el.is_retired=0":"")."
                ".($status==2?" AND (el.status='Inactive' OR el.is_retired=1)":"")."
			    GROUP BY el.employee_id, emp_13thmonth.year
			    ORDER BY el.last_name");
		return $query->result();
     }


}
?>