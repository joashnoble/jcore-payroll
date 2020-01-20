<?php

class PaySlip_earning_model extends CORE_Model {
    protected  $table="pay_slip_other_earnings";
    protected  $pk_id="pay_slip_other_earnings_id";

    function __construct() {
        parent::__construct();
    }

    function get_payslip_earnings($pay_slip_id=null,$pay_period_id=null){
        $query = $this->db->query("SELECT 
				psoe.pay_slip_other_earnings_id,
			    psoe.pay_slip_id,
			    psoe.earnings_id,
			    SUM(psoe.earnings_amount) as earnings_amount,
			    roe.earnings_desc,
			    dtr.employee_id
			FROM
			    pay_slip_other_earnings psoe
			    LEFT JOIN refotherearnings roe ON roe.earnings_id = psoe.earnings_id
			    LEFT JOIN pay_slip ps ON ps.pay_slip_id = psoe.pay_slip_id
			    LEFT JOIN daily_time_record dtr ON dtr.dtr_id = ps.dtr_id
				    WHERE psoe.earnings_amount > 0 
				    ".($pay_slip_id==null?"":" AND psoe.pay_slip_id = $pay_slip_id")."
				    ".($pay_period_id==null?"":" AND dtr.pay_period_id = $pay_period_id")."
				    GROUP BY dtr.employee_id, psoe.earnings_id 
				    ORDER BY psoe.earnings_id ASC");
        		return $query->result();
    }

}
?>