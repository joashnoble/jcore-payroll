<?php

class PaySlip_deduction_model extends CORE_Model {
    protected  $table="pay_slip_deductions";
    protected  $pk_id="pay_slip_deduction_id";

    function __construct() {
        parent::__construct();
    }

    function get_payslip_deductions($pay_slip_id=null,$pay_period_id=null){
        $query = $this->db->query("SELECT 
			    psd.pay_slip_id,
			    psd.pay_slip_deduction_id,
			    rd.deduction_id,
			    rd.deduction_desc,
			    rd.deduction_type_id,
			    psd.deduction_amount,
			    dtr.employee_id
			FROM
			    pay_slip_deductions psd
			    LEFT JOIN refdeduction rd ON rd.deduction_id = psd.deduction_id
			    LEFT JOIN pay_slip ps ON ps.pay_slip_id = psd.pay_slip_id
			    LEFT JOIN daily_time_record dtr ON dtr.dtr_id = ps.dtr_id
				    WHERE active_deduct=TRUE
				    AND psd.deduction_amount > 0
				    ".($pay_slip_id==null?"":" AND psd.pay_slip_id = $pay_slip_id")."
				    ".($pay_period_id==null?"":" AND dtr.pay_period_id = $pay_period_id")."
				    GROUP BY dtr.employee_id, psd.deduction_id
				    ORDER BY rd.deduction_type_id ASC, rd.deduction_id ASC");
        		return $query->result();
    }

}
?>