<?php

class RefDeductionSetup_model extends CORE_Model {
    protected  $table="refdeduction";
    protected  $pk_id="deduction_id";

    function __construct() {
        parent::__construct();
    }

    function getcycleperiod($pay_period_id) {
        $query = $this->db->query('SELECT refpayperiod.pay_period_sequence FROM refpayperiod WHERE pay_period_id='.$pay_period_id
            );
                            $query->result();

                          return $query->result();
    }

    function getalldeduct($employee_id,$pay_period_id,$pay_period_sequence,$deduction_id=null) {
        $query = $this->db->query("SELECT 
                s.*,
                (CASE
                    WHEN s.deduction_id <= 4 THEN s.dd_count
                    ELSE (CASE
                        WHEN s.ndrt_deduction_id > 0 THEN 1
                        ELSE (CASE
                            WHEN
                                s.rdc_count > 0
                            THEN
                                (CASE
                                    WHEN (s.loan_total_amount - s.balance) <= 0 THEN 0
                                    ELSE 1
                                END)
                            ELSE s.rdc_count
                        END)
                    END)
                END) AS is_deduct,
                (CASE 
                    WHEN s.deduction_id <= 3 THEN 1
                    ELSE 0
                END) as full_deduct,
                (s.loan_total_amount - s.balance) as grand_balance
            FROM
                (SELECT 
                    n.*,
                        (SELECT 
                                COALESCE(SUM(deduction_amount), 0)
                            FROM
                                pay_slip_deductions
                            WHERE
                                deduction_regular_id = n.dr_reg_id) AS balance
                FROM
                    (SELECT 
                    d.*, COALESCE(d.dr_id, 0) AS dr_reg_id,
                    
                    COALESCE((SELECT 
                        COALESCE(ndr.loan_total_amount,0) as loan_total_amount
                    FROM
                        new_deductions_regular ndr WHERE ndr.deduction_regular_id = dr_id),0) AS loan_total_amount

                FROM
                    (SELECT 
                    m.*,
                        COALESCE((SELECT 
                                ndr.deduction_regular_id
                            FROM
                                reg_deduction_cycle rdc
                            LEFT JOIN new_deductions_regular ndr ON ndr.deduction_regular_id = rdc.deduction_regular_id
                            WHERE
                                ndr.employee_id = $employee_id
                                    AND rdc.pay_period_id = $pay_period_id
                                    AND ndr.deduction_id = m.deduction_id
                                    AND ndr.deduction_status_id = 1),0) AS dr_id
                FROM
                    (SELECT 
                    refdeduction.*,
                        refdeductiontype.deduction_type_desc,
                        COALESCE(td.ndrt_deduction_id, 0) AS ndrt_deduction_id,
                        (SELECT 
                                COUNT(*)
                            FROM
                                reg_deduction_cycle rdc
                            LEFT JOIN new_deductions_regular ndr ON ndr.deduction_regular_id = rdc.deduction_regular_id
                            WHERE
                                ndr.deduction_id = refdeduction.deduction_id
                                    AND rdc.pay_period_id = $pay_period_id
                                    AND ndr.employee_id = $employee_id) AS rdc_count,
                        (SELECT 
                                COUNT(*)
                            FROM
                                system_settings_default_deductions sd
                            LEFT JOIN default_deduction d ON d.default_id = sd.default_id
                            WHERE
                                sd.deduction_id = refdeduction.deduction_id
                                    AND d.deduction_sequence = $pay_period_sequence) AS dd_count
                FROM
                    refdeduction
                LEFT JOIN refdeductiontype ON refdeduction.deduction_type_id = refdeductiontype.deduction_type_id
                LEFT JOIN (SELECT 
                    ndr_temp.deduction_id AS ndrt_deduction_id
                FROM
                    new_deductions_regular ndr_temp
                WHERE
                    ndr_temp.employee_id = $employee_id
                        AND (ndr_temp.pay_period_id = $pay_period_id
                        OR ndr_temp.deduction_cycle = $pay_period_sequence)
                GROUP BY ndrt_deduction_id) AS td ON refdeduction.deduction_id = td.ndrt_deduction_id
                WHERE
                    refdeduction.is_deleted = 0
                    ".($deduction_id==null?"":" AND refdeduction.deduction_id = $deduction_id")."
                    ) AS m) AS d) AS n) AS s");
                $query->result();
                return $query->result();
    }

    function getalldeductedit($employee_id,$dtr_id) {
        $query = $this->db->query("SELECT 
                    refdeduction.*,
                    refdeductiontype.deduction_Type_id,
                    refdeductiontype.deduction_type_desc,
                    a.deduction_per_pay_amount,
                    a.deduction_regular_id,
                    a.is_deduct,
                    a.full_deduct
                FROM
                    refdeduction
                        LEFT JOIN
                    refdeductiontype ON refdeduction.deduction_type_id = refdeductiontype.deduction_type_id
                        LEFT JOIN
                    (SELECT 
                        dtr_deductions.deduction_id,
                            dtr_deductions.is_deduct,
                            dtr_deductions.full_deduct,
                            dtr_deductions.deduction_regular_id,
                            new_deductions_regular.deduction_per_pay_amount
                    FROM
                        dtr_deductions
                    LEFT JOIN new_deductions_regular ON dtr_deductions.deduction_regular_id = new_deductions_regular.deduction_regular_id
                    WHERE
                        dtr_deductions.dtr_id = $dtr_id
                            AND (new_deductions_regular.employee_id = $employee_id
                            OR is_deduct = 1)) AS a ON refdeduction.deduction_id = a.deduction_id
                WHERE
                    refdeduction.is_deleted = 0");
                            $query->result();

                          return $query->result();
    }
}
?>
