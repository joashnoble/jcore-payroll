<?php

class RefPayPeriod_model extends CORE_Model {
    protected  $table="refpayperiod";
    protected  $pk_id="pay_period_id";

    function __construct() {
        parent::__construct();
    }

    function get_pay_period($year) {
      $query = $this->db->query('SELECT * FROM refpayperiod WHERE extract(YEAR from pay_period_start)='.$year.' AND is_deleted=0 ORDER BY pay_period_start DESC');

                                return $query->result();
                          
    }

    function getpayperioddesc($pay_period_id){
      $query = $this->db->query('SELECT CONCAT(pay_period_start," ~ ",pay_period_end) as pay_period FROM refpayperiod 
      	WHERE pay_period_id='.$pay_period_id.' AND is_deleted=0');
		return $query->result();
    }

    function getpayperiod(){
      $query = $this->db->query("SELECT CONCAT(pay_period_start,' ~ ',pay_period_end) as period, pay_period_id FROM refpayperiod WHERE is_deleted = 0 ORDER BY pay_period_id DESC");
    return $query->result();
    }

    function getperiod($getperiod){
      $query = $this->db->query("SELECT CONCAT(pay_period_start,' ~ ',pay_period_end) as period, pay_period_id FROM refpayperiod WHERE is_deleted = 0 AND pay_period_id=".$getperiod);
    return $query->result();
    }

    

    
}
?>