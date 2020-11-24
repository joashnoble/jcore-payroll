<?php

class PayrollReports_model extends CORE_Model {
    protected  $table="";
    protected  $pk_id="";

    function __construct() {
        parent::__construct();
    }

    function filter_function_adjustment($filter_value,$filter_value2,$filter_value3) {
                        if($filter_value2=="all" AND $filter_value3=="all"){
                        $filter_salary_adjustment=array('pay_slip_other_earnings.earnings_id'=>2,'daily_time_record.pay_period_id'=>$filter_value,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2=="all" AND $filter_value3!="all"){
                        $filter_salary_adjustment=array('pay_slip_other_earnings.earnings_id'=>2,'daily_time_record.pay_period_id'=>$filter_value,'ref_branch.ref_branch_id'=>$filter_value3,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2!="all" AND $filter_value3=="all"){
                        $filter_salary_adjustment=array('pay_slip_other_earnings.earnings_id'=>2,'daily_time_record.pay_period_id'=>$filter_value,'ref_department.ref_department_id'=>$filter_value2,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2!="all" AND $filter_value3!="all"){
                        $filter_salary_adjustment=array('pay_slip_other_earnings.earnings_id'=>2,'daily_time_record.pay_period_id'=>$filter_value,'ref_department.ref_department_id'=>$filter_value2,'ref_branch.ref_branch_id'=>$filter_value3,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }

                          return $filter_salary_adjustment;
    }

    function filter_function_otherearnings($filter_value,$filter_value2,$filter_value3) {
                        if($filter_value2=="all" AND $filter_value3=="all"){
                        $filter_other_earnings=array('pay_slip_other_earnings.earnings_id!=2','daily_time_record.pay_period_id'=>$filter_value,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2=="all" AND $filter_value3!="all"){
                        $filter_other_earnings=array('pay_slip_other_earnings.earnings_id!=2','daily_time_record.pay_period_id'=>$filter_value,'ref_branch.ref_branch_id'=>$filter_value3,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2!="all" AND $filter_value3=="all"){
                        $filter_other_earnings=array('pay_slip_other_earnings.earnings_id!=2','daily_time_record.pay_period_id'=>$filter_value,'ref_department.ref_department_id'=>$filter_value2,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }
                        if($filter_value2!="all" AND $filter_value3!="all"){
                        $filter_other_earnings=array('pay_slip_other_earnings.earnings_id!=2','daily_time_record.pay_period_id'=>$filter_value,'ref_department.ref_department_id'=>$filter_value2,'ref_branch.ref_branch_id'=>$filter_value3,'emp_rates_duties.active_rates_duties'=>TRUE);
                        }

                          return $filter_other_earnings;
    }

    function filter_function_deduction($deduction_id_filter,$filter_value,$filter_value2,$filter_value3) {
                        if($filter_value2=="all" AND $filter_value3=="all"){
                        $filter_sss=array('pay_slip_deductions.deduction_id'=>$deduction_id_filter,'daily_time_record.pay_period_id'=>$filter_value,'emp_rates_duties.active_rates_duties'=>TRUE,'active_deduct'=>TRUE);
                        }
                        if($filter_value2=="all" AND $filter_value3!="all"){
                        $filter_sss=array('pay_slip_deductions.deduction_id'=>$deduction_id_filter,'daily_time_record.pay_period_id'=>$filter_value,'ref_branch.ref_branch_id'=>$filter_value3,'emp_rates_duties.active_rates_duties'=>TRUE,'active_deduct'=>TRUE);
                        }
                        if($filter_value2!="all" AND $filter_value3=="all"){
                        $filter_sss=array('pay_slip_deductions.deduction_id'=>$deduction_id_filter,'daily_time_record.pay_period_id'=>$filter_value,'ref_department.ref_department_id'=>$filter_value2,'emp_rates_duties.active_rates_duties'=>TRUE,'active_deduct'=>TRUE);
                        }
                        if($filter_value2!="all" AND $filter_value3!="all"){
                        $filter_sss=array('pay_slip_deductions.deduction_id'=>$deduction_id_filter,'daily_time_record.pay_period_id'=>$filter_value,'ref_department.ref_department_id'=>$filter_value2,'ref_branch.ref_branch_id'=>$filter_value3,'emp_rates_duties.active_rates_duties'=>TRUE,'active_deduct'=>TRUE);
                        }

                          return $filter_sss;
    }

    function filter_function_other_deduction($filter_value,$filter_value2,$filter_value3) {
                        if($filter_value2=="all" AND $filter_value3=="all"){
                        $filter_sss=array('pay_slip_deductions.deduction_id!=1','pay_slip_deductions.deduction_id!=2',
                                          'pay_slip_deductions.deduction_id!=3','pay_slip_deductions.deduction_id!=4',
                                          'pay_slip_deductions.deduction_id!=5','pay_slip_deductions.deduction_id!=6',
                                          'pay_slip_deductions.deduction_id!=7','pay_slip_deductions.deduction_id!=8',
                                          'pay_slip_deductions.deduction_id!=9',
                                          'daily_time_record.pay_period_id'=>$filter_value,'emp_rates_duties.active_rates_duties'=>TRUE,'active_deduct'=>TRUE);
                        }
                        if($filter_value2=="all" AND $filter_value3!="all"){
                        $filter_sss=array('pay_slip_deductions.deduction_id'=>$deduction_id_filter,'daily_time_record.pay_period_id'=>$filter_value,'ref_branch.ref_branch_id'=>$filter_value3,'emp_rates_duties.active_rates_duties'=>TRUE,'active_deduct'=>TRUE);
                        }
                        if($filter_value2!="all" AND $filter_value3=="all"){
                        $filter_sss=array('pay_slip_deductions.deduction_id'=>$deduction_id_filter,'daily_time_record.pay_period_id'=>$filter_value,'ref_department.ref_department_id'=>$filter_value2,'emp_rates_duties.active_rates_duties'=>TRUE,'active_deduct'=>TRUE);
                        }
                        if($filter_value2!="all" AND $filter_value3!="all"){
                        $filter_sss=array('pay_slip_deductions.deduction_id'=>$deduction_id_filter,'daily_time_record.pay_period_id'=>$filter_value,'ref_department.ref_department_id'=>$filter_value2,'ref_branch.ref_branch_id'=>$filter_value3,'emp_rates_duties.active_rates_duties'=>TRUE,'active_deduct'=>TRUE);
                        }

                          return $filter_sss;
    }

   function get_1601C_list($year,$month){
         $query = $this->db->query("SELECT
                            a.*,
                            (a.gross_pay - (a.sss_employee+a.hdmf+a.phic)) AS compensation
                        FROM
                        (SELECT 
                            emp.id_number,
                            emp.last_name,
                            emp.first_name,
                            emp.middle_name,
                            emp.tin,
                            (ps.reg_hol_pay + ps.spe_hol_pay) AS holiday_pay,
                            rates.per_day_pay,
                            SUM(ps.reg_pay) AS reg_pay,
                            rates.tax_shield AS gross_pay,
                            (SELECT 
                                    employee
                                FROM
                                    ref_sss_contribution
                                WHERE
                                    ref_sss_contribution_id = (SELECT 
                                            MAX(sss_id)
                                        FROM
                                            pay_slip_deductions
                                                LEFT JOIN
                                            pay_slip ON pay_slip.pay_slip_id = pay_slip_deductions.pay_slip_id
                                                LEFT JOIN
                                            daily_time_record ON daily_time_record.dtr_id = pay_slip.dtr_id
                                                LEFT JOIN
                                            refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
                                                LEFT JOIN
                                            employee_list ON employee_list.employee_id = daily_time_record.employee_id
                                        WHERE
                                            refpayperiod.month_id = $month
                                                AND refpayperiod.pay_period_year = $year
                                                AND deduction_id = 1
                                                AND employee_list.employee_id = emp.employee_id
                                        )) AS sss_employee,
                            (SELECT 
                                    employer
                                FROM
                                    ref_sss_contribution
                                WHERE
                                    ref_sss_contribution_id = (SELECT 
                                            MAX(sss_id)
                                        FROM
                                            pay_slip_deductions
                                                LEFT JOIN
                                            pay_slip ON pay_slip.pay_slip_id = pay_slip_deductions.pay_slip_id
                                                LEFT JOIN
                                            daily_time_record ON daily_time_record.dtr_id = pay_slip.dtr_id
                                                LEFT JOIN
                                            refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
                                                LEFT JOIN
                                            employee_list ON employee_list.employee_id = daily_time_record.employee_id
                                        WHERE
                                            refpayperiod.month_id = $month
                                                AND refpayperiod.pay_period_year = $year
                                                AND deduction_id = 1
                                                AND employee_list.employee_id = emp.employee_id
                                        )) AS sss_employer,
                            (SELECT 
                                    employer_contribution
                                FROM
                                    ref_sss_contribution
                                WHERE
                                    ref_sss_contribution_id = (SELECT 
                                            MAX(sss_id)
                                        FROM
                                            pay_slip_deductions
                                                LEFT JOIN
                                            pay_slip ON pay_slip.pay_slip_id = pay_slip_deductions.pay_slip_id
                                                LEFT JOIN
                                            daily_time_record ON daily_time_record.dtr_id = pay_slip.dtr_id
                                                LEFT JOIN
                                            refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
                                                LEFT JOIN
                                            employee_list ON employee_list.employee_id = daily_time_record.employee_id
                                        WHERE
                                            refpayperiod.month_id = $month
                                                AND refpayperiod.pay_period_year = $year
                                                AND deduction_id = 1
                                                AND employee_list.employee_id = emp.employee_id
                                        )) AS sss_employer_contribution,
                            (CASE
                                WHEN
                                    (SELECT 
                                            SUM(deduction_amount)
                                        FROM
                                            pay_slip_deductions
                                                LEFT JOIN
                                            pay_slip ON pay_slip.pay_slip_id = pay_slip_deductions.pay_slip_id
                                                LEFT JOIN
                                            daily_time_record ON daily_time_record.dtr_id = pay_slip.dtr_id
                                                LEFT JOIN
                                            refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
                                                LEFT JOIN
                                            employee_list ON employee_list.employee_id = daily_time_record.employee_id
                                        WHERE
                                            refpayperiod.month_id = $month
                                                AND refpayperiod.pay_period_year = $year
                                                AND deduction_id = 3
                                                AND employee_list.employee_id = emp.employee_id) > 1
                                THEN
                                    100.00
                                ELSE 0.00
                            END) AS hdmf,
                            (SELECT 
                                    SUM(deduction_amount)
                                FROM
                                    pay_slip_deductions
                                        LEFT JOIN
                                    pay_slip ON pay_slip.pay_slip_id = pay_slip_deductions.pay_slip_id
                                        LEFT JOIN
                                    daily_time_record ON daily_time_record.dtr_id = pay_slip.dtr_id
                                        LEFT JOIN
                                    refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
                                        LEFT JOIN
                                    employee_list ON employee_list.employee_id = daily_time_record.employee_id
                                WHERE
                                    refpayperiod.month_id = $month
                                        AND refpayperiod.pay_period_year = $year
                                        AND deduction_id = 2
                                        AND employee_list.employee_id = emp.employee_id) AS phic,
                            (SELECT
                                     SUM(deduction_amount)
                                 FROM
                                     pay_slip_deductions
                                 LEFT JOIN pay_slip ON pay_slip.pay_slip_id = pay_slip_deductions.pay_slip_id
                                 LEFT JOIN daily_time_record ON daily_time_record.dtr_id = pay_slip.dtr_id
                                 LEFT JOIN refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
                                 LEFT JOIN employee_list ON employee_list.employee_id = daily_time_record.employee_id
                                 WHERE
                                     refpayperiod.month_id = $month
                                         AND refpayperiod.pay_period_year = $year
                                         AND deduction_id = 4
                                         AND employee_list.employee_id = emp.employee_id
                             ) AS wtax
                        FROM
                            pay_slip ps
                                LEFT JOIN
                            daily_time_record dtr ON dtr.dtr_id = ps.dtr_id
                                LEFT JOIN
                            employee_list emp ON emp.employee_id = dtr.employee_id
                                LEFT JOIN
                            emp_rates_duties rates ON rates.emp_rates_duties_id = emp.emp_rates_duties_id
                                LEFT JOIN
                            refpayperiod payperiod ON payperiod.pay_period_id = dtr.pay_period_id
                        WHERE
                            payperiod.month_id = $month
                                AND payperiod.pay_period_year = $year
                        GROUP BY dtr.employee_id
                        ORDER BY emp.last_name ASC
                        ) AS A");
         return $query->result();
         // $query = $this->db->query("SELECT 
         //                    b.*,
         //                    (SELECT (CASE
         //                            WHEN col1_cl > b.compensation THEN (((b.compensation-col1_cl)*(col1_percent))+(col1_amount))
         //                            WHEN b.compensation BETWEEN col2_cl AND col3_cl THEN (((b.compensation-col2_cl)*(col2_percent))+(col2_amount))
         //                            WHEN b.compensation BETWEEN col3_cl AND col4_cl THEN (((b.compensation-col3_cl)*(col3_percent))+(col3_amount))
         //                            WHEN b.compensation BETWEEN col4_cl AND col5_cl THEN (((b.compensation-col4_cl)*(col4_percent))+(col4_amount))
         //                            WHEN b.compensation BETWEEN col5_cl AND col6_cl THEN (((b.compensation-col5_cl)*(col5_percent))+(col5_amount))
         //                            ELSE (((b.compensation-col6_cl)*(col6_percent))+(col6_amount))
         //                        END) as wtax
         //                        FROM ref_payment_type
         //                        WHERE ref_payment_type_id=2) AS wtax
         //                FROM
         //                (SELECT
         //                    a.*,
         //                    (a.gross_pay - (a.sss_employee+a.hdmf+a.phic)) AS compensation
         //                FROM
         //                (SELECT 
         //                    emp.id_number,
         //                    emp.last_name,
         //                    emp.first_name,
         //                    emp.middle_name,
         //                    emp.tin,
         //                    (ps.reg_hol_pay + ps.spe_hol_pay) AS holiday_pay,
         //                    rates.per_day_pay,
         //                    SUM(ps.reg_pay) AS reg_pay,
         //                    rates.tax_shield AS gross_pay,
         //                    (SELECT 
         //                            employee
         //                        FROM
         //                            ref_sss_contribution
         //                        WHERE
         //                            ref_sss_contribution_id = (SELECT 
         //                                    sss_id
         //                                FROM
         //                                    pay_slip_deductions
         //                                        LEFT JOIN
         //                                    pay_slip ON pay_slip.pay_slip_id = pay_slip_deductions.pay_slip_id
         //                                        LEFT JOIN
         //                                    daily_time_record ON daily_time_record.dtr_id = pay_slip.dtr_id
         //                                        LEFT JOIN
         //                                    refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
         //                                        LEFT JOIN
         //                                    employee_list ON employee_list.employee_id = daily_time_record.employee_id
         //                                WHERE
         //                                    refpayperiod.month_id = $month
         //                                        AND refpayperiod.pay_period_year = $year
         //                                        AND deduction_id = 1
         //                                        AND employee_list.employee_id = emp.employee_id
         //                                LIMIT 1)) AS sss_employee,
         //                    (SELECT 
         //                            employer
         //                        FROM
         //                            ref_sss_contribution
         //                        WHERE
         //                            ref_sss_contribution_id = (SELECT 
         //                                    sss_id
         //                                FROM
         //                                    pay_slip_deductions
         //                                        LEFT JOIN
         //                                    pay_slip ON pay_slip.pay_slip_id = pay_slip_deductions.pay_slip_id
         //                                        LEFT JOIN
         //                                    daily_time_record ON daily_time_record.dtr_id = pay_slip.dtr_id
         //                                        LEFT JOIN
         //                                    refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
         //                                        LEFT JOIN
         //                                    employee_list ON employee_list.employee_id = daily_time_record.employee_id
         //                                WHERE
         //                                    refpayperiod.month_id = $month
         //                                        AND refpayperiod.pay_period_year = $year
         //                                        AND deduction_id = 1
         //                                        AND employee_list.employee_id = emp.employee_id
         //                                LIMIT 1)) AS sss_employer,
         //                    (SELECT 
         //                            employer_contribution
         //                        FROM
         //                            ref_sss_contribution
         //                        WHERE
         //                            ref_sss_contribution_id = (SELECT 
         //                                    sss_id
         //                                FROM
         //                                    pay_slip_deductions
         //                                        LEFT JOIN
         //                                    pay_slip ON pay_slip.pay_slip_id = pay_slip_deductions.pay_slip_id
         //                                        LEFT JOIN
         //                                    daily_time_record ON daily_time_record.dtr_id = pay_slip.dtr_id
         //                                        LEFT JOIN
         //                                    refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
         //                                        LEFT JOIN
         //                                    employee_list ON employee_list.employee_id = daily_time_record.employee_id
         //                                WHERE
         //                                    refpayperiod.month_id = $month
         //                                        AND refpayperiod.pay_period_year = $year
         //                                        AND deduction_id = 1
         //                                        AND employee_list.employee_id = emp.employee_id
         //                                LIMIT 1)) AS sss_employer_contribution,
         //                    (CASE
         //                        WHEN
         //                            (SELECT 
         //                                    SUM(deduction_amount)
         //                                FROM
         //                                    pay_slip_deductions
         //                                        LEFT JOIN
         //                                    pay_slip ON pay_slip.pay_slip_id = pay_slip_deductions.pay_slip_id
         //                                        LEFT JOIN
         //                                    daily_time_record ON daily_time_record.dtr_id = pay_slip.dtr_id
         //                                        LEFT JOIN
         //                                    refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
         //                                        LEFT JOIN
         //                                    employee_list ON employee_list.employee_id = daily_time_record.employee_id
         //                                WHERE
         //                                    refpayperiod.month_id = $month
         //                                        AND refpayperiod.pay_period_year = $year
         //                                        AND deduction_id = 3
         //                                        AND employee_list.employee_id = emp.employee_id) > 1
         //                        THEN
         //                            100.00
         //                        ELSE 0.00
         //                    END) AS hdmf,
         //                    (SELECT 
         //                            SUM(deduction_amount)
         //                        FROM
         //                            pay_slip_deductions
         //                                LEFT JOIN
         //                            pay_slip ON pay_slip.pay_slip_id = pay_slip_deductions.pay_slip_id
         //                                LEFT JOIN
         //                            daily_time_record ON daily_time_record.dtr_id = pay_slip.dtr_id
         //                                LEFT JOIN
         //                            refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
         //                                LEFT JOIN
         //                            employee_list ON employee_list.employee_id = daily_time_record.employee_id
         //                        WHERE
         //                            refpayperiod.month_id = $month
         //                                AND refpayperiod.pay_period_year = $year
         //                                AND deduction_id = 2
         //                                AND employee_list.employee_id = emp.employee_id) AS phic,
         //                    (SELECT
         //                             SUM(deduction_amount)
         //                         FROM
         //                             pay_slip_deductions
         //                         LEFT JOIN pay_slip ON pay_slip.pay_slip_id = pay_slip_deductions.pay_slip_id
         //                         LEFT JOIN daily_time_record ON daily_time_record.dtr_id = pay_slip.dtr_id
         //                         LEFT JOIN refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
         //                         LEFT JOIN employee_list ON employee_list.employee_id = daily_time_record.employee_id
         //                         WHERE
         //                             refpayperiod.month_id = $month
         //                                 AND refpayperiod.pay_period_year = $year
         //                                 AND deduction_id = 4
         //                                 AND employee_list.employee_id = emp.employee_id
         //                     ) AS wtax
         //                FROM
         //                    pay_slip ps
         //                        LEFT JOIN
         //                    daily_time_record dtr ON dtr.dtr_id = ps.dtr_id
         //                        LEFT JOIN
         //                    employee_list emp ON emp.employee_id = dtr.employee_id
         //                        LEFT JOIN
         //                    emp_rates_duties rates ON rates.emp_rates_duties_id = emp.emp_rates_duties_id
         //                        LEFT JOIN
         //                    refpayperiod payperiod ON payperiod.pay_period_id = dtr.pay_period_id
         //                WHERE
         //                    payperiod.month_id = $month
         //                        AND payperiod.pay_period_year = $year
         //                GROUP BY dtr.employee_id) AS A) AS B");
    }

     function get_monthly_worked_hours($year,$month){
        $query = $this->db->query("SELECT 
                        CONCAT(emp.last_name,
                                ', ',
                                emp.first_name,
                                ' ',
                                emp.middle_name) AS employee,
                        SUM(dtr.reg) AS total_reg,
                        (SUM(dtr.ot_reg) + SUM(dtr.ot_reg_reg_hol) + SUM(dtr.ot_reg_spe_hol)) AS total_ot,
                        (SUM(dtr.nsd_reg) + SUM(dtr.nsd_reg_reg_hol) + SUM(dtr.nsd_reg_spe_hol)) AS total_nd,
                        SUM(dtr.reg_hol) AS total_reg_hol,
                        SUM(dtr.spe_hol) AS total_spe_hol,
                        SUM(reg_amt) AS total_reg_amt,
                        (SUM(dtr.ot_reg_amt) + SUM(dtr.ot_reg_reg_hol_amt) + SUM(dtr.ot_reg_spe_hol_amt)) AS total_ot_amt,
                        (SUM(dtr.nsd_reg_amt) + SUM(dtr.nsd_reg_reg_hol_amt) + SUM(dtr.nsd_reg_spe_hol_amt)) AS total_nd_amt,
                        SUM(reg_hol_amt) AS total_reg_hol_amt,
                        SUM(spe_hol_amt) AS total_spe_hol_amt
                    FROM
                        pay_slip ps
                            LEFT JOIN
                        daily_time_record dtr ON dtr.dtr_id = ps.dtr_id
                            LEFT JOIN
                        employee_list emp ON emp.employee_id = dtr.employee_id
                            LEFT JOIN
                        refpayperiod rpp ON rpp.pay_period_id = dtr.pay_period_id
                    WHERE
                        emp.is_deleted = 0
                            AND emp.status = 'Active'
                            AND emp.is_retired = 0
                            AND rpp.month_id = $month
                            AND rpp.pay_period_year = $year
                    GROUP BY emp.employee_id
                    ORDER BY emp.last_name ASC");
        return $query->result();
    }

     function get_monthly_loan($year,$month,$loan_id){
        $query = $this->db->query("SELECT 
                        el.ecode,
                        CONCAT(el.last_name,', ',el.first_name,' ',el.middle_name) as fullname,
                        SUM(psd.deduction_amount) as loan_deduction
                    FROM
                        pay_slip ps
                        LEFT JOIN daily_time_record dtr ON dtr.dtr_id = ps.dtr_id
                        LEFT JOIN employee_list el ON el.employee_id = dtr.employee_id
                        LEFT JOIN refpayperiod rpp ON rpp.pay_period_id = dtr.pay_period_id
                        LEFT JOIN pay_slip_deductions psd ON psd.pay_slip_id = ps.pay_slip_id
                        WHERE 
                            el.is_deleted = FALSE
                            AND el.status = 'Active'
                            AND el.is_retired = 0
                            AND rpp.month_id = $month
                            AND rpp.pay_period_year = $year
                            AND psd.deduction_id = $loan_id
                            GROUP BY el.employee_id
                            ORDER BY el.last_name ASC");
        return $query->result();
    }

    function get_payroll_register($department,$branch,$pay_period,$type){
        $query = $this->db->query('SELECT ps.*,CONCAT(el.last_name,", ",el.first_name," ",el.middle_name) as fullname,rpp.pay_period_start,rpp.pay_period_end,el.*,
                                                    psdsss.sss_deduction,psdphil.philhealth_deduction,
                                                    psdpagibig.pagibig_deduction,psdwtax.wtax_deduction,psdsssloan.sssloan_deduction,
                                                    psdpagibigloan.pagibigloan_deduction,psdcooploan.cooploan_deduction,psdcoopcontrib.coopcontribution_deduction,
                                                    psdcashadvance.cashadvance_deduction,COALESCE(ROUND(psoeall.allowance,2),0) as allowance,COALESCE(ROUND(psoea.adjustment,2),0) as adjustment
                                                    ,COALESCE(ROUND(psoec.other_earnings,2),0) as other_earnings,psdcalamityloan.calamityloan_deduction,psod.other_deductions
                                         FROM pay_slip as ps
                                        LEFT JOIN daily_time_record as dtr
                                            ON ps.dtr_id=dtr.dtr_id
                                        LEFT JOIN employee_list as el
                                        ON dtr.employee_id=el.employee_id
                                        LEFT JOIN emp_rates_duties as erd
                                        ON el.employee_id=erd.employee_id
                                        LEFT JOIN refpayperiod as rpp
                                            ON dtr.pay_period_id=rpp.pay_period_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1
                                            GROUP BY pay_slip_id) as psoeall
                                                ON ps.pay_slip_id=psoeall.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=2
                                            GROUP BY pay_slip_id) as psoea
                                                ON ps.pay_slip_id=psoea.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=2
                                            GROUP BY pay_slip_id) as psoec
                                                ON ps.pay_slip_id=psoec.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as sss_deduction FROM pay_slip_deductions WHERE deduction_id=1) as psdsss
                                            ON ps.pay_slip_id=psdsss.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as philhealth_deduction FROM pay_slip_deductions WHERE deduction_id=2) as psdphil
                                            ON ps.pay_slip_id=psdphil.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as pagibig_deduction FROM pay_slip_deductions WHERE deduction_id=3) as psdpagibig
                                            ON ps.pay_slip_id=psdpagibig.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as wtax_deduction FROM pay_slip_deductions WHERE deduction_id=4) as psdwtax
                                            ON ps.pay_slip_id=psdwtax.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as sssloan_deduction FROM pay_slip_deductions WHERE deduction_id=5) as psdsssloan
                                            ON ps.pay_slip_id=psdsssloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as pagibigloan_deduction FROM pay_slip_deductions WHERE deduction_id=6) as psdpagibigloan
                                            ON ps.pay_slip_id=psdpagibigloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as cashadvance_deduction FROM pay_slip_deductions WHERE deduction_id=7) as psdcashadvance
                                            ON ps.pay_slip_id=psdcashadvance.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as cooploan_deduction FROM pay_slip_deductions WHERE deduction_id=8) as psdcooploan
                                            ON ps.pay_slip_id=psdcooploan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=12 OR deduction_id=20) as psdcalamityloan
                                            ON ps.pay_slip_id=psdcalamityloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as other_deductions FROM pay_slip_deductions
                                            LEFT JOIN refdeduction
                                            ON refdeduction.deduction_id=pay_slip_deductions.deduction_id
                                            WHERE refdeduction.deduction_type_id!=1 AND refdeduction.deduction_type_id!=2 AND refdeduction.deduction_type_id!=4 AND active_deduct=TRUE
                                            GROUP BY pay_slip_id) as psod
                                                ON ps.pay_slip_id=psod.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as coopcontribution_deduction FROM pay_slip_deductions WHERE deduction_id=9) as psdcoopcontrib
                                            ON ps.pay_slip_id=psdcoopcontrib.pay_slip_id 
                                        WHERE rpp.pay_period_id='.$pay_period.' 
                                        AND erd.active_rates_duties=1                                   
                                        '.($type != "cash"?' 
                                            AND el.bank_account != ""
                                            AND el.bank_account_isprocess = 1
                                        ':' 
                                            AND el.bank_account_isprocess = 0
                                        ').'
                                        '.($branch != "All"?' AND erd.ref_branch_id='.$branch.'':' ').'
                                        '.($department != "All"?' AND erd.ref_department_id='.$department.'':' ').'
                                        ORDER BY el.last_name ASC');

            return $query->result();
    }

    function get_employee_history($filter_value,$filter_value2,$filter_value3) {
            //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision edited na d na standard
            $query = $this->db->query('SELECT ps.*,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname,rpp.pay_period_start,rpp.pay_period_end,
                                                    psdsss.sss_deduction,psdphil.philhealth_deduction,
                                                    psdpagibig.pagibig_deduction,psdwtax.wtax_deduction,psdsssloan.sssloan_deduction,
                                                    psdpagibigloan.pagibigloan_deduction,psdcooploan.cooploan_deduction,psdcoopcontrib.coopcontribution_deduction,
                                                    psdcashadvance.cashadvance_deduction,COALESCE(ROUND(psoeall.allowance,2),0) as allowance,COALESCE(ROUND(psoea.adjustment,2),0) as adjustment
                                                    ,COALESCE(ROUND(psoec.other_earnings,2),0) as other_earnings,psdcalamityloan.calamityloan_deduction,psod.other_deductions
                                         FROM pay_slip as ps
                                        LEFT JOIN daily_time_record as dtr
                                            ON ps.dtr_id=dtr.dtr_id
                                        LEFT JOIN employee_list as el
                                        ON dtr.employee_id=el.employee_id
                                        LEFT JOIN emp_rates_duties as erd
                                        ON el.employee_id=erd.employee_id
                                        LEFT JOIN refpayperiod as rpp
                                            ON dtr.pay_period_id=rpp.pay_period_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1
                                            GROUP BY pay_slip_id) as psoeall
                                                ON ps.pay_slip_id=psoeall.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=2
                                            GROUP BY pay_slip_id) as psoea
                                                ON ps.pay_slip_id=psoea.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=2
                                            GROUP BY pay_slip_id) as psoec
                                                ON ps.pay_slip_id=psoec.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sss_deduction FROM pay_slip_deductions WHERE deduction_id=1) as psdsss
                                            ON ps.pay_slip_id=psdsss.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as philhealth_deduction FROM pay_slip_deductions WHERE deduction_id=2) as psdphil
                                            ON ps.pay_slip_id=psdphil.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibig_deduction FROM pay_slip_deductions WHERE deduction_id=3) as psdpagibig
                                            ON ps.pay_slip_id=psdpagibig.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as wtax_deduction FROM pay_slip_deductions WHERE deduction_id=4) as psdwtax
                                            ON ps.pay_slip_id=psdwtax.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sssloan_deduction FROM pay_slip_deductions WHERE deduction_id=5) as psdsssloan
                                            ON ps.pay_slip_id=psdsssloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibigloan_deduction FROM pay_slip_deductions WHERE deduction_id=6) as psdpagibigloan
                                            ON ps.pay_slip_id=psdpagibigloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cashadvance_deduction FROM pay_slip_deductions WHERE deduction_id=7) as psdcashadvance
                                            ON ps.pay_slip_id=psdcashadvance.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cooploan_deduction FROM pay_slip_deductions WHERE deduction_id=8) as psdcooploan
                                            ON ps.pay_slip_id=psdcooploan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=12) as psdcalamityloan
                                            ON ps.pay_slip_id=psdcalamityloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as other_deductions FROM pay_slip_deductions
                                            LEFT JOIN refdeduction
                                            ON refdeduction.deduction_id=pay_slip_deductions.deduction_id
                                            WHERE refdeduction.deduction_type_id!=1 AND refdeduction.deduction_type_id!=2 AND refdeduction.deduction_type_id!=4 AND active_deduct=TRUE
                                            GROUP BY pay_slip_id) as psod
                                                ON ps.pay_slip_id=psod.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as coopcontribution_deduction FROM pay_slip_deductions WHERE deduction_id=9) as psdcoopcontrib
                                            ON ps.pay_slip_id=psdcoopcontrib.pay_slip_id WHERE 

                                                rpp.pay_period_id='.$filter_value2.' 
                                                '.($filter_value == "all"?"":" AND dtr.employee_id='".$filter_value."'").'
                                                AND erd.active_rates_duties=1 AND erd.ref_branch_id='.$filter_value3.' 
                                                ORDER BY el.last_name');

            return $query->result();
    }

    function get_employee_history_filter_year($filter_value2,$filter_value3) {
            //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision
            $query = $this->db->query('SELECT ps.*,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname,rpp.pay_period_start,rpp.pay_period_end,
                                                    psdsss.sss_deduction,psdphil.philhealth_deduction,
                                                    psdpagibig.pagibig_deduction,psdwtax.wtax_deduction,psdsssloan.sssloan_deduction,
                                                    psdpagibigloan.pagibigloan_deduction,psdcooploan.cooploan_deduction,psdcoopcontrib.coopcontribution_deduction,
                                                    psdcashadvance.cashadvance_deduction,COALESCE(ROUND(psoeall.allowance,2),0) as allowance,COALESCE(ROUND(psoea.adjustment,2),0) as adjustment
                                                    ,COALESCE(ROUND(psoec.other_earnings,2),0) as other_earnings,psdcalamityloan.calamityloan_deduction,psod.other_deductions
                                         FROM pay_slip as ps
                                        LEFT JOIN daily_time_record as dtr
                                            ON ps.dtr_id=dtr.dtr_id
                                        LEFT JOIN employee_list as el
                                        ON dtr.employee_id=el.employee_id
                                        LEFT JOIN emp_rates_duties as erd
                                        ON el.employee_id=erd.employee_id
                                        LEFT JOIN refpayperiod as rpp
                                            ON dtr.pay_period_id=rpp.pay_period_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1
                                            GROUP BY pay_slip_id) as psoeall
                                                ON ps.pay_slip_id=psoeall.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=2
                                            GROUP BY pay_slip_id) as psoea
                                                ON ps.pay_slip_id=psoea.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=2
                                            GROUP BY pay_slip_id) as psoec
                                                ON ps.pay_slip_id=psoec.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sss_deduction FROM pay_slip_deductions WHERE deduction_id=1) as psdsss
                                            ON ps.pay_slip_id=psdsss.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as philhealth_deduction FROM pay_slip_deductions WHERE deduction_id=2) as psdphil
                                            ON ps.pay_slip_id=psdphil.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibig_deduction FROM pay_slip_deductions WHERE deduction_id=3) as psdpagibig
                                            ON ps.pay_slip_id=psdpagibig.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as wtax_deduction FROM pay_slip_deductions WHERE deduction_id=4) as psdwtax
                                            ON ps.pay_slip_id=psdwtax.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sssloan_deduction FROM pay_slip_deductions WHERE deduction_id=5) as psdsssloan
                                            ON ps.pay_slip_id=psdsssloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibigloan_deduction FROM pay_slip_deductions WHERE deduction_id=6) as psdpagibigloan
                                            ON ps.pay_slip_id=psdpagibigloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cashadvance_deduction FROM pay_slip_deductions WHERE deduction_id=7) as psdcashadvance
                                            ON ps.pay_slip_id=psdcashadvance.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cooploan_deduction FROM pay_slip_deductions WHERE deduction_id=8) as psdcooploan
                                            ON ps.pay_slip_id=psdcooploan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=12) as psdcalamityloan
                                            ON ps.pay_slip_id=psdcalamityloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as other_deductions FROM pay_slip_deductions
                                            LEFT JOIN refdeduction
                                            ON refdeduction.deduction_id=pay_slip_deductions.deduction_id
                                            WHERE refdeduction.deduction_type_id!=1 AND refdeduction.deduction_type_id!=2 AND refdeduction.deduction_type_id!=4 AND active_deduct=TRUE
                                            GROUP BY pay_slip_id) as psod
                                                ON ps.pay_slip_id=psod.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as coopcontribution_deduction FROM pay_slip_deductions WHERE deduction_id=9) as psdcoopcontrib
                                            ON ps.pay_slip_id=psdcoopcontrib.pay_slip_id WHERE rpp.pay_period_id='.$filter_value2.' AND erd.active_rates_duties=1 AND erd.ref_branch_id='.$filter_value3.' 
                                            ORDER BY el.last_name');

            return $query->result();
    }

    // function get_employee_history_filter_employee($filter_value,$filter_value3) {
    //         //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision
    //         $query = $this->db->query('SELECT ps.*,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname,rpp.pay_period_start,rpp.pay_period_end,
    //                                                 psdsss.sss_deduction,psdphil.philhealth_deduction,
    //                                                 psdpagibig.pagibig_deduction,psdwtax.wtax_deduction,psdsssloan.sssloan_deduction,
    //                                                 psdpagibigloan.pagibigloan_deduction,psdcooploan.cooploan_deduction,psdcoopcontrib.coopcontribution_deduction,
    //                                                 psdcashadvance.cashadvance_deduction/*,psdcalamityloan.calamityloan_deduction*/
    //                                      FROM pay_slip as ps
    //                                     LEFT JOIN daily_time_record as dtr
    //                                         ON ps.dtr_id=dtr.dtr_id
    //                                     LEFT JOIN employee_list as el
    //                                     ON dtr.employee_id=el.employee_id
    //                                     LEFT JOIN emp_rates_duties as erd
    //                                     ON el.employee_id=erd.employee_id
    //                                     LEFT JOIN refpayperiod as rpp
    //                                         ON dtr.pay_period_id=rpp.pay_period_id
    //                                    /* LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1) as psoe
    //                                             ON ps.pay_slip_id=psoe.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=6
    //                                         GROUP BY earnings_id) as psoea
    //                                             ON ps.pay_slip_id=psoea.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=6
    //                                         GROUP BY earnings_id) as psoec
    //                                             ON ps.pay_slip_id=psoec.pay_slip_id*/
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sss_deduction FROM pay_slip_deductions WHERE deduction_id=1) as psdsss
    //                                         ON ps.pay_slip_id=psdsss.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as philhealth_deduction FROM pay_slip_deductions WHERE deduction_id=2) as psdphil
    //                                         ON ps.pay_slip_id=psdphil.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibig_deduction FROM pay_slip_deductions WHERE deduction_id=3) as psdpagibig
    //                                         ON ps.pay_slip_id=psdpagibig.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as wtax_deduction FROM pay_slip_deductions WHERE deduction_id=4) as psdwtax
    //                                         ON ps.pay_slip_id=psdwtax.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,deduction_amount as sssloan_deduction FROM pay_slip_deductions WHERE deduction_id=5) as psdsssloan
    //                                         ON ps.pay_slip_id=psdsssloan.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibigloan_deduction FROM pay_slip_deductions WHERE deduction_id=6) as psdpagibigloan
    //                                         ON ps.pay_slip_id=psdpagibigloan.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cashadvance_deduction FROM pay_slip_deductions WHERE deduction_id=7) as psdcashadvance
    //                                         ON ps.pay_slip_id=psdcashadvance.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cooploan_deduction FROM pay_slip_deductions WHERE deduction_id=8) as psdcooploan
    //                                         ON ps.pay_slip_id=psdcooploan.pay_slip_id
    //                                     /*LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=12) as psdcalamityloan
    //                                         ON ps.pay_slip_id=psdcalamityloan.pay_slip_id*/
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as coopcontribution_deduction FROM pay_slip_deductions WHERE deduction_id=9) as psdcoopcontrib
    //                                         ON ps.pay_slip_id=psdcoopcontrib.pay_slip_id WHERE dtr.employee_id='.$filter_value.' AND erd.active_rates_duties=1 AND erd.ref_branch_id='.$filter_value3.' ORDER BY fullname');
    //
    //         return $query->result();
    // }
    //
    // function get_employee_history_wofilter($filter_value3) {
    //         //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision
    //         $query = $this->db->query('SELECT ps.*,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname,rpp.pay_period_start,rpp.pay_period_end,
    //                                                 psdsss.sss_deduction,psdphil.philhealth_deduction,
    //                                                 psdpagibig.pagibig_deduction,psdwtax.wtax_deduction,psdsssloan.sssloan_deduction,
    //                                                 psdpagibigloan.pagibigloan_deduction,psdcooploan.cooploan_deduction,psdcoopcontrib.coopcontribution_deduction,
    //                                                 psdcashadvance.cashadvance_deduction/*,psdcalamityloan.calamityloan_deduction*/
    //                                      FROM pay_slip as ps
    //                                     LEFT JOIN daily_time_record as dtr
    //                                         ON ps.dtr_id=dtr.dtr_id
    //                                     LEFT JOIN employee_list as el
    //                                     ON dtr.employee_id=el.employee_id
    //                                     LEFT JOIN emp_rates_duties as erd
    //                                     ON el.employee_id=erd.employee_id
    //                                     LEFT JOIN refpayperiod as rpp
    //                                         ON dtr.pay_period_id=rpp.pay_period_id
    //                                    /* LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1
    //                                         GROUP BY earnings_id) as psoe
    //                                             ON ps.pay_slip_id=psoe.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=6
    //                                         GROUP BY earnings_id) as psoea
    //                                             ON ps.pay_slip_id=psoea.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=6
    //                                         GROUP BY earnings_id) as psoec
    //                                             ON ps.pay_slip_id=psoec.pay_slip_id*/
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sss_deduction FROM pay_slip_deductions WHERE deduction_id=1) as psdsss
    //                                         ON ps.pay_slip_id=psdsss.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as philhealth_deduction FROM pay_slip_deductions WHERE deduction_id=2) as psdphil
    //                                         ON ps.pay_slip_id=psdphil.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibig_deduction FROM pay_slip_deductions WHERE deduction_id=3) as psdpagibig
    //                                         ON ps.pay_slip_id=psdpagibig.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as wtax_deduction FROM pay_slip_deductions WHERE deduction_id=4) as psdwtax
    //                                         ON ps.pay_slip_id=psdwtax.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sssloan_deduction FROM pay_slip_deductions WHERE deduction_id=5) as psdsssloan
    //                                         ON ps.pay_slip_id=psdsssloan.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibigloan_deduction FROM pay_slip_deductions WHERE deduction_id=6) as psdpagibigloan
    //                                         ON ps.pay_slip_id=psdpagibigloan.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cashadvance_deduction FROM pay_slip_deductions WHERE deduction_id=7) as psdcashadvance
    //                                         ON ps.pay_slip_id=psdcashadvance.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cooploan_deduction FROM pay_slip_deductions WHERE deduction_id=8) as psdcooploan
    //                                         ON ps.pay_slip_id=psdcooploan.pay_slip_id
    //                                         /*LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=12) as psdcalamityloan
    //                                         ON ps.pay_slip_id=psdcalamityloan.pay_slip_id*/
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as coopcontribution_deduction FROM pay_slip_deductions WHERE deduction_id=9) as psdcoopcontrib
    //                                         ON ps.pay_slip_id=psdcoopcontrib.pay_slip_id  WHERE erd.active_rates_duties=1 AND erd.ref_branch_id='.$filter_value3);
    //
    //         return $query->result();
    // }

    function get_monthly_salary_history($filter_value,$filter_value2,$filter_value3,$filter_year) {
            //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision edited na d na standard
            $query = $this->db->query('SELECT ps.*,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname,rpp.pay_period_start,rpp.pay_period_end,
                                                    psdsss.sss_deduction,psdphil.philhealth_deduction,
                                                    psdpagibig.pagibig_deduction,psdwtax.wtax_deduction,psdsssloan.sssloan_deduction,
                                                    psdpagibigloan.pagibigloan_deduction,psdcooploan.cooploan_deduction,psdcoopcontrib.coopcontribution_deduction,
                                                    psdcashadvance.cashadvance_deduction,COALESCE(ROUND(psoeall.allowance,2),0) as allowance,COALESCE(ROUND(psoea.adjustment,2),0) as adjustment
                                                    ,COALESCE(ROUND(psoec.other_earnings,2),0) as other_earnings,psdcalamityloan.calamityloan_deduction,psod.other_deductions
                                         FROM pay_slip as ps
                                        LEFT JOIN daily_time_record as dtr
                                            ON ps.dtr_id=dtr.dtr_id
                                        LEFT JOIN employee_list as el
                                        ON dtr.employee_id=el.employee_id
                                        LEFT JOIN emp_rates_duties as erd
                                        ON el.employee_id=erd.employee_id
                                        LEFT JOIN refpayperiod as rpp
                                            ON dtr.pay_period_id=rpp.pay_period_id
                                        /*LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1) as psoe
                                                ON ps.pay_slip_id=psoe.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=6
                                            GROUP BY earnings_id) as psoea
                                                ON ps.pay_slip_id=psoea.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=6
                                            GROUP BY earnings_id) as psoec
                                                ON ps.pay_slip_id=psoec.pay_slip_id*/
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1
                                            GROUP BY pay_slip_id) as psoeall
                                                ON ps.pay_slip_id=psoeall.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=2
                                            GROUP BY pay_slip_id) as psoea
                                                ON ps.pay_slip_id=psoea.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=2
                                            GROUP BY pay_slip_id) as psoec
                                                ON ps.pay_slip_id=psoec.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sss_deduction FROM pay_slip_deductions WHERE deduction_id=1) as psdsss
                                            ON ps.pay_slip_id=psdsss.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as philhealth_deduction FROM pay_slip_deductions WHERE deduction_id=2) as psdphil
                                            ON ps.pay_slip_id=psdphil.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibig_deduction FROM pay_slip_deductions WHERE deduction_id=3) as psdpagibig
                                            ON ps.pay_slip_id=psdpagibig.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as wtax_deduction FROM pay_slip_deductions WHERE deduction_id=4) as psdwtax
                                            ON ps.pay_slip_id=psdwtax.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sssloan_deduction FROM pay_slip_deductions WHERE deduction_id=5) as psdsssloan
                                            ON ps.pay_slip_id=psdsssloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibigloan_deduction FROM pay_slip_deductions WHERE deduction_id=6) as psdpagibigloan
                                            ON ps.pay_slip_id=psdpagibigloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cashadvance_deduction FROM pay_slip_deductions WHERE deduction_id=7) as psdcashadvance
                                            ON ps.pay_slip_id=psdcashadvance.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cooploan_deduction FROM pay_slip_deductions WHERE deduction_id=8) as psdcooploan
                                            ON ps.pay_slip_id=psdcooploan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=12) as psdcalamityloan
                                            ON ps.pay_slip_id=psdcalamityloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as other_deductions FROM pay_slip_deductions
                                            LEFT JOIN refdeduction
                                            ON refdeduction.deduction_id=pay_slip_deductions.deduction_id
                                            WHERE refdeduction.deduction_type_id!=1 AND refdeduction.deduction_type_id!=2 AND refdeduction.deduction_type_id!=4 AND active_deduct=TRUE
                                            GROUP BY pay_slip_id) as psod
                                                ON ps.pay_slip_id=psod.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as coopcontribution_deduction FROM pay_slip_deductions WHERE deduction_id=9) as psdcoopcontrib
                                            ON ps.pay_slip_id=psdcoopcontrib.pay_slip_id WHERE rpp.month_id='.$filter_value2.' AND 
                                                rpp.pay_period_year='.$filter_year.' 
                                                '.($filter_value == "all"?"":" AND dtr.employee_id='".$filter_value."'").'
                                                AND erd.active_rates_duties=1 AND erd.ref_branch_id='.$filter_value3.' 
                                                ORDER BY el.last_name');

            return $query->result();
    }

         function get_payroll_summary($filter) {
            //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision edited na d na standard
            $query = $this->db->query('SELECT ps.*,dtr.*,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname,rpp.pay_period_start,rpp.pay_period_end,
                                                    psdsss.sss_deduction,psdphil.philhealth_deduction,
                                                    psdpagibig.pagibig_deduction,psdwtax.wtax_deduction,psdsssloan.sssloan_deduction,
                                                    psdpagibigloan.pagibigloan_deduction,psdcooploan.cooploan_deduction,psdcoopcontrib.coopcontribution_deduction,
                                                    psdcashadvance.cashadvance_deduction,COALESCE(ROUND(psoeall.allowance,2),0) as allowance,COALESCE(ROUND(psoea.adjustment,2),0) as adjustment
                                                    ,COALESCE(ROUND(psoec.other_earnings,2),0) as other_earnings,
                                                    pagibig_psdcalamityloan.pagibig_calamityloan_deduction,
                                                    sss_psdcalamityloan.sss_calamityloan_deduction,
                                                    psod.other_deductions
                                         FROM pay_slip as ps
                                        LEFT JOIN daily_time_record as dtr
                                            ON ps.dtr_id=dtr.dtr_id
                                        LEFT JOIN employee_list as el
                                        ON dtr.employee_id=el.employee_id
                                        LEFT JOIN emp_rates_duties as erd
                                        ON el.employee_id=erd.employee_id
                                        LEFT JOIN refpayperiod as rpp
                                            ON dtr.pay_period_id=rpp.pay_period_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1
                                            GROUP BY pay_slip_id) as psoeall
                                                ON ps.pay_slip_id=psoeall.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=2
                                            GROUP BY pay_slip_id) as psoea
                                                ON ps.pay_slip_id=psoea.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=2
                                            GROUP BY pay_slip_id) as psoec
                                                ON ps.pay_slip_id=psoec.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sss_deduction FROM pay_slip_deductions WHERE deduction_id=1) as psdsss
                                            ON ps.pay_slip_id=psdsss.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as philhealth_deduction FROM pay_slip_deductions WHERE deduction_id=2) as psdphil
                                            ON ps.pay_slip_id=psdphil.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibig_deduction FROM pay_slip_deductions WHERE deduction_id=3) as psdpagibig
                                            ON ps.pay_slip_id=psdpagibig.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as wtax_deduction FROM pay_slip_deductions WHERE deduction_id=4) as psdwtax
                                            ON ps.pay_slip_id=psdwtax.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sssloan_deduction FROM pay_slip_deductions WHERE deduction_id=5) as psdsssloan
                                            ON ps.pay_slip_id=psdsssloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibigloan_deduction FROM pay_slip_deductions WHERE deduction_id=6) as psdpagibigloan
                                            ON ps.pay_slip_id=psdpagibigloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cashadvance_deduction FROM pay_slip_deductions WHERE deduction_id=7) as psdcashadvance
                                            ON ps.pay_slip_id=psdcashadvance.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cooploan_deduction FROM pay_slip_deductions WHERE deduction_id=8) as psdcooploan
                                            ON ps.pay_slip_id=psdcooploan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibig_calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=12) as pagibig_psdcalamityloan
                                            ON ps.pay_slip_id=pagibig_psdcalamityloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sss_calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=20) as sss_psdcalamityloan
                                            ON ps.pay_slip_id=sss_psdcalamityloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as other_deductions FROM pay_slip_deductions
                                            LEFT JOIN refdeduction
                                            ON refdeduction.deduction_id=pay_slip_deductions.deduction_id
                                            WHERE refdeduction.deduction_type_id!=1 AND refdeduction.deduction_type_id!=2 AND refdeduction.deduction_type_id!=4 AND refdeduction.deduction_type_id != 8 AND active_deduct=TRUE
                                            GROUP BY pay_slip_id) as psod
                                                ON ps.pay_slip_id=psod.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as coopcontribution_deduction FROM pay_slip_deductions WHERE deduction_id=9) as psdcoopcontrib
                                            ON ps.pay_slip_id=psdcoopcontrib.pay_slip_id 
                                         '.$filter.'
                                          ORDER BY el.last_name');

            return $query->result();
    }

    function get_monthly_salary_filter_year($filter_value2,$filter_value3,$filter_year) {
            //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision
            $query = $this->db->query('SELECT ps.*,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname,rpp.pay_period_start,rpp.pay_period_end,
                                                    psdsss.sss_deduction,psdphil.philhealth_deduction,
                                                    psdpagibig.pagibig_deduction,psdwtax.wtax_deduction,psdsssloan.sssloan_deduction,
                                                    psdpagibigloan.pagibigloan_deduction,psdcooploan.cooploan_deduction,psdcoopcontrib.coopcontribution_deduction,
                                                    psdcashadvance.cashadvance_deduction,COALESCE(ROUND(psoeall.allowance,2),0) as allowance,COALESCE(ROUND(psoea.adjustment,2),0) as adjustment
                                                    ,COALESCE(ROUND(psoec.other_earnings,2),0) as other_earnings,psdcalamityloan.calamityloan_deduction,psod.other_deductions
                                         FROM pay_slip as ps
                                        LEFT JOIN daily_time_record as dtr
                                            ON ps.dtr_id=dtr.dtr_id
                                        LEFT JOIN employee_list as el
                                        ON dtr.employee_id=el.employee_id
                                        LEFT JOIN emp_rates_duties as erd
                                        ON el.employee_id=erd.employee_id
                                        LEFT JOIN refpayperiod as rpp
                                            ON dtr.pay_period_id=rpp.pay_period_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1
                                            GROUP BY pay_slip_id) as psoeall
                                                ON ps.pay_slip_id=psoeall.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=2
                                            GROUP BY pay_slip_id) as psoea
                                                ON ps.pay_slip_id=psoea.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=2
                                            GROUP BY pay_slip_id) as psoec
                                                ON ps.pay_slip_id=psoec.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sss_deduction FROM pay_slip_deductions WHERE deduction_id=1) as psdsss
                                            ON ps.pay_slip_id=psdsss.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as philhealth_deduction FROM pay_slip_deductions WHERE deduction_id=2) as psdphil
                                            ON ps.pay_slip_id=psdphil.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibig_deduction FROM pay_slip_deductions WHERE deduction_id=3) as psdpagibig
                                            ON ps.pay_slip_id=psdpagibig.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as wtax_deduction FROM pay_slip_deductions WHERE deduction_id=4) as psdwtax
                                            ON ps.pay_slip_id=psdwtax.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sssloan_deduction FROM pay_slip_deductions WHERE deduction_id=5) as psdsssloan
                                            ON ps.pay_slip_id=psdsssloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibigloan_deduction FROM pay_slip_deductions WHERE deduction_id=6) as psdpagibigloan
                                            ON ps.pay_slip_id=psdpagibigloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cashadvance_deduction FROM pay_slip_deductions WHERE deduction_id=7) as psdcashadvance
                                            ON ps.pay_slip_id=psdcashadvance.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cooploan_deduction FROM pay_slip_deductions WHERE deduction_id=8) as psdcooploan
                                            ON ps.pay_slip_id=psdcooploan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=12) as psdcalamityloan
                                            ON ps.pay_slip_id=psdcalamityloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as other_deductions FROM pay_slip_deductions
                                            LEFT JOIN refdeduction
                                            ON refdeduction.deduction_id=pay_slip_deductions.deduction_id
                                            WHERE refdeduction.deduction_type_id!=1 AND refdeduction.deduction_type_id!=2 AND refdeduction.deduction_type_id!=4 AND active_deduct=TRUE
                                            GROUP BY pay_slip_id) as psod
                                                ON ps.pay_slip_id=psod.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as coopcontribution_deduction FROM pay_slip_deductions WHERE deduction_id=9) as psdcoopcontrib
                                            ON ps.pay_slip_id=psdcoopcontrib.pay_slip_id WHERE rpp.month_id='.$filter_value2.' AND rpp.pay_period_year='.$filter_year.' AND erd.active_rates_duties=1 AND erd.ref_branch_id='.$filter_value3.'
                                            ORDER BY el.last_name');

            return $query->result();
    }

    // function get_monthly_salary_filter_employee($filter_value,$filter_value3) {
    //         //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision
    //         $query = $this->db->query('SELECT ps.*,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname,rpp.pay_period_start,rpp.pay_period_end,
    //                                                 psdsss.sss_deduction,psdphil.philhealth_deduction,
    //                                                 psdpagibig.pagibig_deduction,psdwtax.wtax_deduction,psdsssloan.sssloan_deduction,
    //                                                 psdpagibigloan.pagibigloan_deduction,psdcooploan.cooploan_deduction,psdcoopcontrib.coopcontribution_deduction,
    //                                                 psdcashadvance.cashadvance_deduction/*,psdcalamityloan.calamityloan_deduction*/
    //                                      FROM pay_slip as ps
    //                                     LEFT JOIN daily_time_record as dtr
    //                                         ON ps.dtr_id=dtr.dtr_id
    //                                     LEFT JOIN employee_list as el
    //                                     ON dtr.employee_id=el.employee_id
    //                                     LEFT JOIN emp_rates_duties as erd
    //                                     ON el.employee_id=erd.employee_id
    //                                     LEFT JOIN refpayperiod as rpp
    //                                         ON dtr.pay_period_id=rpp.pay_period_id
    //                                    /* LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1) as psoe
    //                                             ON ps.pay_slip_id=psoe.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=6
    //                                         GROUP BY earnings_id) as psoea
    //                                             ON ps.pay_slip_id=psoea.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=6
    //                                         GROUP BY earnings_id) as psoec
    //                                             ON ps.pay_slip_id=psoec.pay_slip_id*/
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sss_deduction FROM pay_slip_deductions WHERE deduction_id=1) as psdsss
    //                                         ON ps.pay_slip_id=psdsss.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as philhealth_deduction FROM pay_slip_deductions WHERE deduction_id=2) as psdphil
    //                                         ON ps.pay_slip_id=psdphil.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibig_deduction FROM pay_slip_deductions WHERE deduction_id=3) as psdpagibig
    //                                         ON ps.pay_slip_id=psdpagibig.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as wtax_deduction FROM pay_slip_deductions WHERE deduction_id=4) as psdwtax
    //                                         ON ps.pay_slip_id=psdwtax.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,deduction_amount as sssloan_deduction FROM pay_slip_deductions WHERE deduction_id=5) as psdsssloan
    //                                         ON ps.pay_slip_id=psdsssloan.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibigloan_deduction FROM pay_slip_deductions WHERE deduction_id=6) as psdpagibigloan
    //                                         ON ps.pay_slip_id=psdpagibigloan.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cashadvance_deduction FROM pay_slip_deductions WHERE deduction_id=7) as psdcashadvance
    //                                         ON ps.pay_slip_id=psdcashadvance.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cooploan_deduction FROM pay_slip_deductions WHERE deduction_id=8) as psdcooploan
    //                                         ON ps.pay_slip_id=psdcooploan.pay_slip_id
    //                                     /*LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=12) as psdcalamityloan
    //                                         ON ps.pay_slip_id=psdcalamityloan.pay_slip_id*/
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as coopcontribution_deduction FROM pay_slip_deductions WHERE deduction_id=9) as psdcoopcontrib
    //                                         ON ps.pay_slip_id=psdcoopcontrib.pay_slip_id WHERE dtr.employee_id='.$filter_value.' AND erd.active_rates_duties=1 AND erd.ref_branch_id='.$filter_value3.'ORDER BY fullname');
    //
    //         return $query->result();
    // }
    //
    // function get_monthly_salary_wofilter($filter_value3) {
    //         //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision
    //         $query = $this->db->query('SELECT ps.*,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname,rpp.pay_period_start,rpp.pay_period_end,
    //                                                 psdsss.sss_deduction,psdphil.philhealth_deduction,
    //                                                 psdpagibig.pagibig_deduction,psdwtax.wtax_deduction,psdsssloan.sssloan_deduction,
    //                                                 psdpagibigloan.pagibigloan_deduction,psdcooploan.cooploan_deduction,psdcoopcontrib.coopcontribution_deduction,
    //                                                 psdcashadvance.cashadvance_deduction/*,psdcalamityloan.calamityloan_deduction*/
    //                                      FROM pay_slip as ps
    //                                     LEFT JOIN daily_time_record as dtr
    //                                         ON ps.dtr_id=dtr.dtr_id
    //                                     LEFT JOIN employee_list as el
    //                                     ON dtr.employee_id=el.employee_id
    //                                     LEFT JOIN emp_rates_duties as erd
    //                                     ON el.employee_id=erd.employee_id
    //                                     LEFT JOIN refpayperiod as rpp
    //                                         ON dtr.pay_period_id=rpp.pay_period_id
    //                                    /* LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1
    //                                         GROUP BY earnings_id) as psoe
    //                                             ON ps.pay_slip_id=psoe.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=6
    //                                         GROUP BY earnings_id) as psoea
    //                                             ON ps.pay_slip_id=psoea.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=6
    //                                         GROUP BY earnings_id) as psoec
    //                                             ON ps.pay_slip_id=psoec.pay_slip_id*/
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sss_deduction FROM pay_slip_deductions WHERE deduction_id=1) as psdsss
    //                                         ON ps.pay_slip_id=psdsss.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as philhealth_deduction FROM pay_slip_deductions WHERE deduction_id=2) as psdphil
    //                                         ON ps.pay_slip_id=psdphil.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibig_deduction FROM pay_slip_deductions WHERE deduction_id=3) as psdpagibig
    //                                         ON ps.pay_slip_id=psdpagibig.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as wtax_deduction FROM pay_slip_deductions WHERE deduction_id=4) as psdwtax
    //                                         ON ps.pay_slip_id=psdwtax.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sssloan_deduction FROM pay_slip_deductions WHERE deduction_id=5) as psdsssloan
    //                                         ON ps.pay_slip_id=psdsssloan.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibigloan_deduction FROM pay_slip_deductions WHERE deduction_id=6) as psdpagibigloan
    //                                         ON ps.pay_slip_id=psdpagibigloan.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cashadvance_deduction FROM pay_slip_deductions WHERE deduction_id=7) as psdcashadvance
    //                                         ON ps.pay_slip_id=psdcashadvance.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cooploan_deduction FROM pay_slip_deductions WHERE deduction_id=8) as psdcooploan
    //                                         ON ps.pay_slip_id=psdcooploan.pay_slip_id
    //                                         /*LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=12) as psdcalamityloan
    //                                         ON ps.pay_slip_id=psdcalamityloan.pay_slip_id*/
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as coopcontribution_deduction FROM pay_slip_deductions WHERE deduction_id=9) as psdcoopcontrib
    //                                         ON ps.pay_slip_id=psdcoopcontrib.pay_slip_id  WHERE erd.active_rates_duties=1 AND erd.ref_branch_id='.$filter_value3);
    //
    //         return $query->result();
    // }

    function get_yearly_salary_history($filter_value,$filter_value2,$filter_value3) {

            //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision edited na d na standard
            $query = $this->db->query('SELECT ps.*,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname,rpp.pay_period_start,rpp.pay_period_end,
                                                    psdsss.sss_deduction,psdphil.philhealth_deduction,
                                                    psdpagibig.pagibig_deduction,psdwtax.wtax_deduction,psdsssloan.sssloan_deduction,
                                                    psdpagibigloan.pagibigloan_deduction,psdcooploan.cooploan_deduction,psdcoopcontrib.coopcontribution_deduction,
                                                    psdcashadvance.cashadvance_deduction,COALESCE(ROUND(psoeall.allowance,2),0) as allowance,COALESCE(ROUND(psoea.adjustment,2),0) as adjustment
                                                    ,COALESCE(ROUND(psoec.other_earnings,2),0) as other_earnings,psdcalamityloan.calamityloan_deduction,psod.other_deductions
                                         FROM pay_slip as ps
                                        LEFT JOIN daily_time_record as dtr
                                            ON ps.dtr_id=dtr.dtr_id
                                        LEFT JOIN employee_list as el
                                        ON dtr.employee_id=el.employee_id
                                        LEFT JOIN emp_rates_duties as erd
                                        ON el.employee_id=erd.employee_id
                                        LEFT JOIN refpayperiod as rpp
                                            ON dtr.pay_period_id=rpp.pay_period_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1
                                            GROUP BY pay_slip_id) as psoeall
                                                ON ps.pay_slip_id=psoeall.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=2
                                            GROUP BY pay_slip_id) as psoea
                                                ON ps.pay_slip_id=psoea.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=2
                                            GROUP BY pay_slip_id) as psoec
                                                ON ps.pay_slip_id=psoec.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sss_deduction FROM pay_slip_deductions WHERE deduction_id=1) as psdsss
                                            ON ps.pay_slip_id=psdsss.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as philhealth_deduction FROM pay_slip_deductions WHERE deduction_id=2) as psdphil
                                            ON ps.pay_slip_id=psdphil.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibig_deduction FROM pay_slip_deductions WHERE deduction_id=3) as psdpagibig
                                            ON ps.pay_slip_id=psdpagibig.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as wtax_deduction FROM pay_slip_deductions WHERE deduction_id=4) as psdwtax
                                            ON ps.pay_slip_id=psdwtax.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sssloan_deduction FROM pay_slip_deductions WHERE deduction_id=5) as psdsssloan
                                            ON ps.pay_slip_id=psdsssloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibigloan_deduction FROM pay_slip_deductions WHERE deduction_id=6) as psdpagibigloan
                                            ON ps.pay_slip_id=psdpagibigloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cashadvance_deduction FROM pay_slip_deductions WHERE deduction_id=7) as psdcashadvance
                                            ON ps.pay_slip_id=psdcashadvance.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cooploan_deduction FROM pay_slip_deductions WHERE deduction_id=8) as psdcooploan
                                            ON ps.pay_slip_id=psdcooploan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=12) as psdcalamityloan
                                            ON ps.pay_slip_id=psdcalamityloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as other_deductions FROM pay_slip_deductions
                                            LEFT JOIN refdeduction
                                            ON refdeduction.deduction_id=pay_slip_deductions.deduction_id
                                            WHERE refdeduction.deduction_type_id!=1 AND refdeduction.deduction_type_id!=2 AND refdeduction.deduction_type_id!=4 AND active_deduct=TRUE
                                            GROUP BY pay_slip_id) as psod
                                                ON ps.pay_slip_id=psod.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as coopcontribution_deduction FROM pay_slip_deductions WHERE deduction_id=9) as psdcoopcontrib
                                            ON ps.pay_slip_id=psdcoopcontrib.pay_slip_id WHERE rpp.pay_period_year='.$filter_value2.' 
                                                '.($filter_value == "all"?"":" AND dtr.employee_id='".$filter_value."'").'
                                                AND erd.active_rates_duties=1 AND erd.ref_branch_id='.$filter_value3.'
                                                ORDER BY el.last_name');

            return $query->result();
    }

    function get_yearly_salary_filter_year($filter_value2,$filter_value3) {
            //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision
            $query = $this->db->query('SELECT ps.*,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname,rpp.pay_period_start,rpp.pay_period_end,
                                                    psdsss.sss_deduction,psdphil.philhealth_deduction,
                                                    psdpagibig.pagibig_deduction,psdwtax.wtax_deduction,psdsssloan.sssloan_deduction,
                                                    psdpagibigloan.pagibigloan_deduction,psdcooploan.cooploan_deduction,psdcoopcontrib.coopcontribution_deduction,
                                                    psdcashadvance.cashadvance_deduction,COALESCE(ROUND(psoeall.allowance,2),0) as allowance,COALESCE(ROUND(psoea.adjustment,2),0) as adjustment
                                                    ,COALESCE(ROUND(psoec.other_earnings,2),0) as other_earnings,psdcalamityloan.calamityloan_deduction,psod.other_deductions
                                         FROM pay_slip as ps
                                        LEFT JOIN daily_time_record as dtr
                                            ON ps.dtr_id=dtr.dtr_id
                                        LEFT JOIN employee_list as el
                                        ON dtr.employee_id=el.employee_id
                                        LEFT JOIN emp_rates_duties as erd
                                        ON el.employee_id=erd.employee_id
                                        LEFT JOIN refpayperiod as rpp
                                            ON dtr.pay_period_id=rpp.pay_period_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1
                                            GROUP BY pay_slip_id) as psoeall
                                                ON ps.pay_slip_id=psoeall.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=2
                                            GROUP BY pay_slip_id) as psoea
                                                ON ps.pay_slip_id=psoea.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=2
                                            GROUP BY pay_slip_id) as psoec
                                                ON ps.pay_slip_id=psoec.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sss_deduction FROM pay_slip_deductions WHERE deduction_id=1) as psdsss
                                            ON ps.pay_slip_id=psdsss.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as philhealth_deduction FROM pay_slip_deductions WHERE deduction_id=2) as psdphil
                                            ON ps.pay_slip_id=psdphil.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibig_deduction FROM pay_slip_deductions WHERE deduction_id=3) as psdpagibig
                                            ON ps.pay_slip_id=psdpagibig.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as wtax_deduction FROM pay_slip_deductions WHERE deduction_id=4) as psdwtax
                                            ON ps.pay_slip_id=psdwtax.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sssloan_deduction FROM pay_slip_deductions WHERE deduction_id=5) as psdsssloan
                                            ON ps.pay_slip_id=psdsssloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibigloan_deduction FROM pay_slip_deductions WHERE deduction_id=6) as psdpagibigloan
                                            ON ps.pay_slip_id=psdpagibigloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cashadvance_deduction FROM pay_slip_deductions WHERE deduction_id=7) as psdcashadvance
                                            ON ps.pay_slip_id=psdcashadvance.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cooploan_deduction FROM pay_slip_deductions WHERE deduction_id=8) as psdcooploan
                                            ON ps.pay_slip_id=psdcooploan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=12) as psdcalamityloan
                                            ON ps.pay_slip_id=psdcalamityloan.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,SUM(deduction_amount) as other_deductions FROM pay_slip_deductions
                                            LEFT JOIN refdeduction
                                            ON refdeduction.deduction_id=pay_slip_deductions.deduction_id
                                            WHERE refdeduction.deduction_type_id!=1 AND refdeduction.deduction_type_id!=2 AND refdeduction.deduction_type_id!=4 AND active_deduct=TRUE
                                            GROUP BY pay_slip_id) as psod
                                                ON ps.pay_slip_id=psod.pay_slip_id
                                        LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as coopcontribution_deduction FROM pay_slip_deductions WHERE deduction_id=9) as psdcoopcontrib
                                            ON ps.pay_slip_id=psdcoopcontrib.pay_slip_id WHERE rpp.pay_period_year='.$filter_value2.' AND erd.active_rates_duties=1 AND erd.ref_branch_id='.$filter_value3.'
                                            ORDER BY el.last_name');

            return $query->result();
    }

    // function get_yearly_salary_filter_employee($filter_value,$filter_value3) {
    //         //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision
    //         $query = $this->db->query('SELECT ps.*,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname,rpp.pay_period_start,rpp.pay_period_end,
    //                                                 psdsss.sss_deduction,psdphil.philhealth_deduction,
    //                                                 psdpagibig.pagibig_deduction,psdwtax.wtax_deduction,psdsssloan.sssloan_deduction,
    //                                                 psdpagibigloan.pagibigloan_deduction,psdcooploan.cooploan_deduction,psdcoopcontrib.coopcontribution_deduction,
    //                                                 psdcashadvance.cashadvance_deduction/*,psdcalamityloan.calamityloan_deduction*/
    //                                      FROM pay_slip as ps
    //                                     LEFT JOIN daily_time_record as dtr
    //                                         ON ps.dtr_id=dtr.dtr_id
    //                                     LEFT JOIN employee_list as el
    //                                     ON dtr.employee_id=el.employee_id
    //                                     LEFT JOIN emp_rates_duties as erd
    //                                     ON el.employee_id=erd.employee_id
    //                                     LEFT JOIN refpayperiod as rpp
    //                                         ON dtr.pay_period_id=rpp.pay_period_id
    //                                    /* LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1) as psoe
    //                                             ON ps.pay_slip_id=psoe.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=6
    //                                         GROUP BY earnings_id) as psoea
    //                                             ON ps.pay_slip_id=psoea.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=6
    //                                         GROUP BY earnings_id) as psoec
    //                                             ON ps.pay_slip_id=psoec.pay_slip_id*/
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sss_deduction FROM pay_slip_deductions WHERE deduction_id=1) as psdsss
    //                                         ON ps.pay_slip_id=psdsss.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as philhealth_deduction FROM pay_slip_deductions WHERE deduction_id=2) as psdphil
    //                                         ON ps.pay_slip_id=psdphil.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibig_deduction FROM pay_slip_deductions WHERE deduction_id=3) as psdpagibig
    //                                         ON ps.pay_slip_id=psdpagibig.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as wtax_deduction FROM pay_slip_deductions WHERE deduction_id=4) as psdwtax
    //                                         ON ps.pay_slip_id=psdwtax.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,deduction_amount as sssloan_deduction FROM pay_slip_deductions WHERE deduction_id=5) as psdsssloan
    //                                         ON ps.pay_slip_id=psdsssloan.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibigloan_deduction FROM pay_slip_deductions WHERE deduction_id=6) as psdpagibigloan
    //                                         ON ps.pay_slip_id=psdpagibigloan.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cashadvance_deduction FROM pay_slip_deductions WHERE deduction_id=7) as psdcashadvance
    //                                         ON ps.pay_slip_id=psdcashadvance.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cooploan_deduction FROM pay_slip_deductions WHERE deduction_id=8) as psdcooploan
    //                                         ON ps.pay_slip_id=psdcooploan.pay_slip_id
    //                                     /*LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=12) as psdcalamityloan
    //                                         ON ps.pay_slip_id=psdcalamityloan.pay_slip_id*/
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as coopcontribution_deduction FROM pay_slip_deductions WHERE deduction_id=9) as psdcoopcontrib
    //                                         ON ps.pay_slip_id=psdcoopcontrib.pay_slip_id WHERE dtr.employee_id='.$filter_value.' AND erd.active_rates_duties=1 AND erd.ref_branch_id='.$filter_value3);
    //
    //         return $query->result();
    // }
    //
    // function get_yearly_salary_wofilter($filter_value3) {
    //         //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision
    //         $query = $this->db->query('SELECT ps.*,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname,rpp.pay_period_start,rpp.pay_period_end,
    //                                                 psdsss.sss_deduction,psdphil.philhealth_deduction,
    //                                                 psdpagibig.pagibig_deduction,psdwtax.wtax_deduction,psdsssloan.sssloan_deduction,
    //                                                 psdpagibigloan.pagibigloan_deduction,psdcooploan.cooploan_deduction,psdcoopcontrib.coopcontribution_deduction,
    //                                                 psdcashadvance.cashadvance_deduction/*,psdcalamityloan.calamityloan_deduction*/
    //                                      FROM pay_slip as ps
    //                                     LEFT JOIN daily_time_record as dtr
    //                                         ON ps.dtr_id=dtr.dtr_id
    //                                     LEFT JOIN employee_list as el
    //                                     ON dtr.employee_id=el.employee_id
    //                                     LEFT JOIN emp_rates_duties as erd
    //                                     ON el.employee_id=erd.employee_id
    //                                     LEFT JOIN refpayperiod as rpp
    //                                         ON dtr.pay_period_id=rpp.pay_period_id
    //                                    /* LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as allowance FROM pay_slip_other_earnings WHERE earnings_id=1
    //                                         GROUP BY earnings_id) as psoe
    //                                             ON ps.pay_slip_id=psoe.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as adjustment FROM pay_slip_other_earnings WHERE earnings_id=6
    //                                         GROUP BY earnings_id) as psoea
    //                                             ON ps.pay_slip_id=psoea.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,SUM(earnings_amount) as other_earnings FROM pay_slip_other_earnings WHERE earnings_id!=1 AND earnings_id!=6
    //                                         GROUP BY earnings_id) as psoec
    //                                             ON ps.pay_slip_id=psoec.pay_slip_id*/
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sss_deduction FROM pay_slip_deductions WHERE deduction_id=1) as psdsss
    //                                         ON ps.pay_slip_id=psdsss.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as philhealth_deduction FROM pay_slip_deductions WHERE deduction_id=2) as psdphil
    //                                         ON ps.pay_slip_id=psdphil.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibig_deduction FROM pay_slip_deductions WHERE deduction_id=3) as psdpagibig
    //                                         ON ps.pay_slip_id=psdpagibig.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as wtax_deduction FROM pay_slip_deductions WHERE deduction_id=4) as psdwtax
    //                                         ON ps.pay_slip_id=psdwtax.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as sssloan_deduction FROM pay_slip_deductions WHERE deduction_id=5) as psdsssloan
    //                                         ON ps.pay_slip_id=psdsssloan.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as pagibigloan_deduction FROM pay_slip_deductions WHERE deduction_id=6) as psdpagibigloan
    //                                         ON ps.pay_slip_id=psdpagibigloan.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cashadvance_deduction FROM pay_slip_deductions WHERE deduction_id=7) as psdcashadvance
    //                                         ON ps.pay_slip_id=psdcashadvance.pay_slip_id
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as cooploan_deduction FROM pay_slip_deductions WHERE deduction_id=8) as psdcooploan
    //                                         ON ps.pay_slip_id=psdcooploan.pay_slip_id
    //                                         /*LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as calamityloan_deduction FROM pay_slip_deductions WHERE deduction_id=12) as psdcalamityloan
    //                                         ON ps.pay_slip_id=psdcalamityloan.pay_slip_id*/
    //                                     LEFT JOIN (SELECT pay_slip_id,(deduction_amount) as coopcontribution_deduction FROM pay_slip_deductions WHERE deduction_id=9) as psdcoopcontrib
    //                                         ON ps.pay_slip_id=psdcoopcontrib.pay_slip_id  WHERE erd.active_rates_duties=1 AND erd.ref_branch_id='.$filter_value3);
    //
    //         return $query->result();
    // }

    // function getloan($filter_value,$filter_value2){
    //     $loan = $this->db->query("SELECT 
    //             psd.deduction_regular_id,
    //             psd.deduction_amount,
    //             pay_period_start,
    //             pay_period_end,
    //             CONCAT_WS(' ',emplist.first_name,emplist.middle_name,emplist.last_name) AS fullname
    //         FROM
    //             employee_list AS emplist
    //                 LEFT JOIN
    //             daily_time_record AS dtr ON emplist.employee_id = dtr.employee_id
    //                 LEFT JOIN
    //             refpayperiod AS rpp ON dtr.pay_period_id = rpp.pay_period_id
    //                 LEFT JOIN
    //             pay_slip AS ps ON dtr.dtr_id = ps.dtr_id
    //                 LEFT JOIN
    //             pay_slip_deductions AS psd ON ps.pay_slip_id = psd.pay_slip_id
    //                 LEFT JOIN
    //             new_deductions_regular ndr ON ndr.deduction_regular_id = psd.deduction_regular_id
    //         WHERE
    //             emplist.employee_id = $filter_value
    //                 AND ndr.deduction_id = $filter_value2");
    //     return $loan->result();
    // }

    function getloan($employee_id,$deduction_id,$period_start,$period_end){
        $this->db->query("SET @balance:=0.00;");
        $sql="SELECT 
                main.*,
                CONVERT( (@balance:=@balance + (main.debit - main.credit)) , DECIMAL (20 , 2 )) AS balance
            FROM
                (SELECT 
                    main_debit.*
                FROM
                    (SELECT 
                    DATE_FORMAT(ndr.date_created, '%m-%d-%Y') AS due_date,
                        ndr.loan_total_amount AS debit,
                        0 AS credit
                FROM
                    new_deductions_regular ndr
                WHERE
                    ndr.is_deleted = FALSE
                        AND employee_id = $employee_id
                        AND deduction_id = $deduction_id) AS main_debit UNION ALL SELECT 
                    main_credit.*
                FROM
                    (SELECT 
                    DATE_FORMAT(rpp.pay_period_end, '%m-%d-%Y') AS due_date,
                        0 AS debit,
                        psd.deduction_amount AS credit
                FROM
                    pay_slip_deductions psd
                LEFT JOIN pay_slip ps ON ps.pay_slip_id = psd.pay_slip_id
                LEFT JOIN daily_time_record dtr ON dtr.dtr_id = ps.dtr_id
                LEFT JOIN refpayperiod rpp ON rpp.pay_period_id = dtr.pay_period_id
                WHERE
                    dtr.employee_id = $employee_id
                        AND psd.deduction_id = $deduction_id) AS main_credit) AS main
            WHERE 
            main.due_date BETWEEN '$period_start' AND '$period_end'
            ORDER BY main.due_date ASC

            ";
            return $this->db->query($sql)->result();
    }    

    function getInitialLoan($filter_value,$filter_value2){
        $loan=$this->db->query("SELECT 
            ndr.deduction_regular_id,
            MIN(pay_period_start) AS pay_period_start,
            pay_period_end,
            CONCAT_WS(' ',
                    emplist.first_name,
                    emplist.middle_name,
                    emplist.last_name) AS fullname,
            ndr.loan_total_amount
        FROM
            employee_list AS emplist
                LEFT JOIN
            new_deductions_regular AS ndr ON ndr.employee_id = emplist.employee_id
                LEFT JOIN
            reg_deduction_cycle rdc ON rdc.deduction_regular_id = ndr.deduction_regular_id
                LEFT JOIN
            refpayperiod AS rpp ON rpp.pay_period_id = rdc.pay_period_id
        WHERE
            emplist.employee_id = $filter_value
                AND ndr.deduction_id = $filter_value2");
        return $loan->result();
    }

    function getloanadjustments($deduction_regular_id){
        $loanadjustments = $this->db->query('SELECT CONCAT(emp.first_name," ",emp.middle_name," ",emp.last_name) as fullname,particular,pay_slip_loans_adjustments.date_created,debit_amount,credit_amount,pay_slip_loans_adjustments.deduction_regular_id FROM pay_slip_loans_adjustments
                                LEFT JOIN new_deductions_regular
                                ON new_deductions_regular.deduction_regular_id=pay_slip_loans_adjustments.deduction_regular_id
                                LEFT JOIN employee_list as emp
                                ON emp.employee_id=new_deductions_regular.employee_id
                                WHERE new_deductions_regular.is_deleted=0 AND pay_slip_loans_adjustments.deduction_regular_id='.$deduction_regular_id);
                                    return $loanadjustments->result();
    }

    function getloanamount($filter_value,$filter_value2){
        $loan_temp = $this->db->query("SELECT 
                    new_deductions_regular.deduction_regular_id,
                    new_deductions_regular.loan_total_amount,
                    COALESCE((SUM(psd.deduction_amount)), 0) AS psdamount,
                    new_deductions_regular.deduction_per_pay_amount,
                    COUNT(new_deductions_regular.deduction_regular_id) AS count,
                    ROUND((new_deductions_regular.loan_total_amount - COALESCE((SUM(psd.deduction_amount)), 0)),2) as balance
                FROM
                    new_deductions_regular
                        LEFT JOIN
                    pay_slip_deductions AS psd ON new_deductions_regular.deduction_regular_id = psd.deduction_regular_id
                WHERE
                    new_deductions_regular.employee_id = $filter_value
                        AND is_deleted = 0
                        AND new_deductions_regular.deduction_id = $filter_value2
                        AND new_deductions_regular.deduction_status_id = 1");
        return $loan_temp->result();
    }

     function get_13thmonthpay_wofilter($filter_value3,$start_date,$end_date,$factor=12) {
            //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision
            $query = $this->db->query('SELECT ps.*,CONCAT(el.last_name,", ",el.first_name," ",el.middle_name) as fullname, SUM(ps.reg_pay) as total_reg,erd.salary_reg_rates,SUM(erd.salary_reg_rates) as total_basic_pay,dtr.for_13th_month,SUM(dtr.for_13th_month) as total_13thmonth,SUM(ps.days_with_pay_amt) as dayswithpayamt,SUM(dtr.reg_amt) as total_reg_amt, ((SUM(dtr.for_13th_month) + COALESCE(SUM(salary_retro.earnings_amount),0) + SUM(ps.days_with_pay_amt)) -  SUM(ps.days_wout_pay_amt)) as total_reg_days_pay,
                ((((SUM(dtr.for_13th_month) + COALESCE(SUM(salary_retro.earnings_amount),0) + SUM(ps.days_with_pay_amt)) -  SUM(ps.days_wout_pay_amt))) / '.$factor.') as grand_13thmonth_pay, SUM(ps.days_wout_pay_amt) as total_days_wout_pay_amt,  SUM(ps.minutes_late_amt) as total_minutes_late_amt,COALESCE(SUM(salary_retro.earnings_amount),0) as retro, el.employee_id
                                         FROM pay_slip as ps
                                        LEFT JOIN daily_time_record as dtr
                                            ON ps.dtr_id=dtr.dtr_id
                                        LEFT JOIN employee_list as el
                                        ON dtr.employee_id=el.employee_id
                                        LEFT JOIN emp_rates_duties as erd
                                        ON el.employee_id=erd.employee_id
                                        LEFT JOIN refpayperiod as rpp
                                            ON dtr.pay_period_id=rpp.pay_period_id
                                        LEFT JOIN (SELECT pay_slip_id,(earnings_amount) as earnings_amount FROM pay_slip_other_earnings WHERE earnings_id=7) as salary_retro
                                            ON ps.pay_slip_id=salary_retro.pay_slip_id
                                        WHERE 
                                            el.is_deleted = 0
                                            AND erd.active_rates_duties=1 
                                            AND erd.ref_branch_id='.$filter_value3.'
                                            AND 
                                                ((rpp.pay_period_start BETWEEN "'.$start_date.'" AND "'.$end_date.'") OR 
                                                (rpp.pay_period_end BETWEEN "'.$start_date.'" AND "'.$end_date.'"))                                            
                                        GROUP BY el.employee_id
                                        ORDER BY el.last_name');

            return $query->result();
    }

    function get_13thmonthpay_year_filter($filter_value2,$filter_value3,$start_date,$end_date,$factor=12) {
            //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision
            $query = $this->db->query('SELECT ps.*,CONCAT(el.last_name,", ",el.first_name," ",el.middle_name) as fullname, SUM(ps.reg_pay) as total_reg,erd.salary_reg_rates,SUM(erd.salary_reg_rates) as total_basic_pay,dtr.for_13th_month,SUM(dtr.for_13th_month) as total_13thmonth,SUM(ps.days_with_pay_amt) as dayswithpayamt, SUM(dtr.reg_amt) as total_reg_amt,el.employee_id,
                ((SUM(dtr.for_13th_month) + COALESCE(SUM(salary_retro.earnings_amount),0) + SUM(ps.days_with_pay_amt)) -  SUM(ps.days_wout_pay_amt)) as total_reg_days_pay,
                ((((SUM(dtr.for_13th_month) + COALESCE(SUM(salary_retro.earnings_amount),0) + SUM(ps.days_with_pay_amt)) -  SUM(ps.days_wout_pay_amt))) / '.$factor.') as grand_13thmonth_pay, SUM(ps.days_wout_pay_amt) as total_days_wout_pay_amt,  SUM(ps.minutes_late_amt) as total_minutes_late_amt,COALESCE(SUM(salary_retro.earnings_amount),0) as retro
                                         FROM pay_slip as ps
                                        LEFT JOIN daily_time_record as dtr
                                            ON ps.dtr_id=dtr.dtr_id
                                        LEFT JOIN employee_list as el
                                        ON dtr.employee_id=el.employee_id
                                        LEFT JOIN emp_rates_duties as erd
                                        ON el.employee_id=erd.employee_id
                                        LEFT JOIN refpayperiod as rpp
                                            ON dtr.pay_period_id=rpp.pay_period_id
                                        LEFT JOIN (SELECT pay_slip_id,(earnings_amount) as earnings_amount FROM pay_slip_other_earnings WHERE earnings_id=7) as salary_retro
                                            ON ps.pay_slip_id=salary_retro.pay_slip_id
                                        WHERE el.is_deleted = 0
                                            AND erd.active_rates_duties=1 
                                            AND 
                                                ((rpp.pay_period_start BETWEEN "'.$start_date.'" AND "'.$end_date.'") OR 
                                                (rpp.pay_period_end BETWEEN "'.$start_date.'" AND "'.$end_date.'"))
                                            AND el.status="Active" 
                                            AND el.is_retired="0" AND erd.ref_branch_id='.$filter_value3.'
                                        GROUP BY el.employee_id                   
                                        ORDER BY el.last_name');

            return $query->result();
    }

    function get_13thmonthpay_register_filter($branch,$department,$start_date,$end_date,$status) {
            $query = $this->db->query('SELECT ps.*,CONCAT(el.last_name,", ",el.first_name," ",el.middle_name) as fullname,el.employee_id, el.bank_account_isprocess, el.bank_account,el.ecode, SUM(ps.reg_pay) as total_reg,erd.salary_reg_rates,SUM(erd.salary_reg_rates) as total_basic_pay,dtr.for_13th_month,SUM(dtr.for_13th_month) as total_13thmonth,SUM(ps.days_with_pay_amt) as dayswithpayamt, SUM(dtr.reg_amt) as total_reg_amt,
                                         SUM(ps.days_wout_pay_amt) as total_days_wout_pay_amt,  SUM(ps.minutes_late_amt) as total_minutes_late_amt,COALESCE(SUM(salary_retro.earnings_amount),0) as retro
                                         FROM pay_slip as ps
                                        LEFT JOIN daily_time_record as dtr
                                            ON ps.dtr_id=dtr.dtr_id
                                        LEFT JOIN employee_list as el
                                        ON dtr.employee_id=el.employee_id
                                        LEFT JOIN emp_rates_duties as erd
                                        ON el.employee_id=erd.employee_id
                                        LEFT JOIN refpayperiod as rpp
                                            ON dtr.pay_period_id=rpp.pay_period_id
                                        LEFT JOIN (SELECT pay_slip_id,(earnings_amount) as earnings_amount FROM pay_slip_other_earnings WHERE earnings_id=7) as salary_retro
                                            ON ps.pay_slip_id=salary_retro.pay_slip_id
                                        WHERE el.is_deleted = 0
                                            AND erd.active_rates_duties=1 
                                            AND 
                                                ((rpp.pay_period_start BETWEEN "'.$start_date.'" AND "'.$end_date.'") OR 
                                                (rpp.pay_period_end BETWEEN "'.$start_date.'" AND "'.$end_date.'"))
                                                '.($status==1?' AND el.status="Active" AND el.is_retired="0"':'').'
                                                '.($status==2?' AND (el.status="Inactive" OR el.is_retired=1)':'').'
                                                '.($branch=="all"?'':' AND erd.ref_branch_id='.$branch.'').'
                                                '.($department=="all"?'':' AND erd.ref_department_id='.$department.'').'
                                        GROUP BY el.employee_id                   
                                        ORDER BY el.last_name');

            return $query->result();
    }
    
                                            // AND rpp.pay_period_year='.$filter_value2.' 
    
    function get_13thmonthpay_employee_filter($filter_value,$filter_value3,$start_date,$end_date,$factor=12) {
            //1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision
            $query = $this->db->query('SELECT ps.*,CONCAT(el.last_name,", ",el.first_name," ",el.middle_name) as fullname, SUM(ps.reg_pay) as total_reg,erd.salary_reg_rates,SUM(dtr.reg_amt) as total_reg_amt,SUM(erd.salary_reg_rates) as total_basic_pay,dtr.for_13th_month,SUM(dtr.for_13th_month) as total_13thmonth,SUM(ps.days_with_pay_amt) as dayswithpayamt,SUM(ps.days_wout_pay_amt) as total_days_wout_pay_amt,  SUM(ps.minutes_late_amt) as total_minutes_late_amt,COALESCE(SUM(salary_retro.earnings_amount),0) as retro, el.employee_id,
                ((SUM(dtr.for_13th_month) + COALESCE(SUM(salary_retro.earnings_amount),0) + SUM(ps.days_with_pay_amt)) -  SUM(ps.days_wout_pay_amt)) as total_reg_days_pay,
                ((((SUM(dtr.for_13th_month) + COALESCE(SUM(salary_retro.earnings_amount),0) + SUM(ps.days_with_pay_amt)) -  SUM(ps.days_wout_pay_amt))) / '.$factor.') as grand_13thmonth_pay

                                         FROM pay_slip as ps
                                        LEFT JOIN daily_time_record as dtr
                                            ON ps.dtr_id=dtr.dtr_id
                                        LEFT JOIN employee_list as el
                                        ON dtr.employee_id=el.employee_id
                                        LEFT JOIN emp_rates_duties as erd
                                        ON el.employee_id=erd.employee_id
                                        LEFT JOIN refpayperiod as rpp
                                            ON dtr.pay_period_id=rpp.pay_period_id
                                        LEFT JOIN (SELECT pay_slip_id,(earnings_amount) as earnings_amount FROM pay_slip_other_earnings WHERE earnings_id=7) as salary_retro
                                            ON ps.pay_slip_id=salary_retro.pay_slip_id
                                        WHERE 
                                            el.is_deleted = 0
                                            AND dtr.employee_id='.$filter_value.' 
                                            AND 
                                                ((rpp.pay_period_start BETWEEN "'.$start_date.'" AND "'.$end_date.'") OR 
                                                (rpp.pay_period_end BETWEEN "'.$start_date.'" AND "'.$end_date.'"))
                                            AND erd.active_rates_duties=1 
                                            AND erd.ref_branch_id='.$filter_value3);            

            return $query->result();
    }

    function get_accumulated_13thmonthpay($employee_id) {
            $query = $this->db->query('SELECT ps.*,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname, SUM(ps.reg_pay) as total_reg,SUM(dtr.reg_amt) as total_reg_amt,erd.salary_reg_rates,SUM(erd.salary_reg_rates) as total_basic_pay,dtr.for_13th_month,SUM(dtr.for_13th_month) as total_13thmonth, ROUND((SUM(dtr.for_13th_month)-(SUM(ps.days_wout_pay_amt)+SUM(ps.minutes_late_amt)))/12) as acc_13thmonth_pay,
                                         SUM(ps.days_wout_pay_amt) as total_days_wout_pay_amt,  SUM(ps.minutes_late_amt) as total_minutes_late_amt,COALESCE(SUM(salary_retro.earnings_amount),0) as retro
                                         FROM pay_slip as ps
                                        LEFT JOIN daily_time_record as dtr
                                            ON ps.dtr_id=dtr.dtr_id
                                        LEFT JOIN employee_list as el
                                        ON dtr.employee_id=el.employee_id
                                        LEFT JOIN emp_rates_duties as erd
                                        ON el.employee_id=erd.employee_id
                                        LEFT JOIN refpayperiod as rpp
                                            ON dtr.pay_period_id=rpp.pay_period_id
                                        LEFT JOIN (SELECT pay_slip_id,(earnings_amount) as earnings_amount FROM pay_slip_other_earnings WHERE earnings_id=7) as salary_retro
                                            ON ps.pay_slip_id=salary_retro.pay_slip_id
                                        WHERE 
                                            AND el.is_deleted = 0
                                            AND dtr.employee_id='.$employee_id.'
                                            AND erd.active_rates_duties=1');

            return $query->result();
    }

    function get_13thmonthpay($filter_value,$filter_value2,$filter_value3,$start_date,$end_date,$factor=12) {
            // 1=allowance 2=salary adjustments 3=meal allowance 4=other allowance 5=commision
            $query = $this->db->query("SELECT ps.*,CONCAT(el.last_name,', ',el.first_name,' ',el.middle_name) as fullname, SUM(ps.reg_pay) as total_reg,
                SUM(dtr.reg_amt) as total_reg_amt,el.employee_id,
                ((SUM(dtr.for_13th_month) + COALESCE(SUM(salary_retro.earnings_amount),0) + SUM(ps.days_with_pay_amt)) -  SUM(ps.days_wout_pay_amt)) as total_reg_days_pay,
                ((((SUM(dtr.for_13th_month) + COALESCE(SUM(salary_retro.earnings_amount),0) + SUM(ps.days_with_pay_amt)) -  SUM(ps.days_wout_pay_amt))) / ".$factor.") as grand_13thmonth_pay,
                erd.salary_reg_rates,SUM(erd.salary_reg_rates) as total_basic_pay,
                dtr.for_13th_month,SUM(dtr.for_13th_month) as total_13thmonth,SUM(ps.days_with_pay_amt) as dayswithpayamt,
                                         SUM(ps.days_wout_pay_amt) as total_days_wout_pay_amt, SUM(ps.minutes_late_amt) as total_minutes_late_amt,
                                         COALESCE(SUM(salary_retro.earnings_amount),0) as retro
                                         FROM pay_slip as ps
                                        LEFT JOIN daily_time_record as dtr
                                            ON ps.dtr_id=dtr.dtr_id
                                        LEFT JOIN employee_list as el
                                        ON dtr.employee_id=el.employee_id
                                        LEFT JOIN emp_rates_duties as erd
                                        ON el.employee_id=erd.employee_id
                                        LEFT JOIN refpayperiod as rpp
                                            ON dtr.pay_period_id=rpp.pay_period_id
                                        LEFT JOIN (SELECT pay_slip_id,(earnings_amount) as earnings_amount FROM pay_slip_other_earnings WHERE earnings_id=7) as salary_retro
                                            ON ps.pay_slip_id=salary_retro.pay_slip_id
                                        WHERE dtr.employee_id=".$filter_value." 
                                            AND el.is_deleted = 0
                                            AND 
                                                ((rpp.pay_period_start BETWEEN '".$start_date."' AND '".$end_date."') OR 
                                                (rpp.pay_period_end BETWEEN '".$start_date."' AND '".$end_date."'))
                                            AND erd.active_rates_duties=1 
                                            AND erd.ref_branch_id=".$filter_value3."
                                        GROUP BY el.employee_id
                                        ORDER BY el.last_name");

            return $query->result();
    }

                                            // AND rpp.pay_period_year=".$filter_value2."

    function get_employee_compensation($filter_value,$filter_value2,$factor) {

            $query = $this->db->query("SELECT m.*,SUM(m.reg_pay) as sum_regpay,SUM(m.net_pay) as sum_netpay,
                                       SUM(m.t3rthmonth) as sum_t3rthmonth,SUM(m.total_deductions) as sum_total_deductions
                                       FROM(SELECT
                                          months.month_id,
                                          months.month_name as Month,
                                          ROUND(SUM(reg_pay),2) as reg_pay,ROUND(SUM(net_pay),2) as net_pay,
                                          ROUND(SUM(for_13th_month)/$factor,2) as t3rthmonth,ROUND(SUM(total_deductions),2) as total_deductions
                                     FROM pay_slip
                                    LEFT JOIN daily_time_record ON
                                    daily_time_record.dtr_id=pay_slip.dtr_id
                                    LEFT JOIN refpayperiod ON
                                    refpayperiod.pay_period_id=daily_time_record.pay_period_id
                                    LEFT JOIN months ON
                                    months.month_id = refpayperiod.month_id
                                    WHERE employee_id=".$filter_value." AND
                                    refpayperiod.pay_period_year =  ".$filter_value2."
                                    GROUP BY Month) as m
                                    GROUP BY m.Month
                                    ORDER BY m.month_id ASC
                                      ");

            return $query->result();
    }

    function get_employee_deduction_history($filter_value,$filter_value2) {
            $query = $this->db->query("SELECT m.*,SUM(m.sss) as t_sss,SUM(m.philhealth) as t_philhealth,
                                       SUM(m.pagibig) as t_pagibig,SUM(m.wtax) as t_wtax
                                       FROM(
                                      SELECT 
                                          months.month_id,
                                          months.month_name as Month,
                                          ROUND(SUM(tb_sss.sss),2) as sss,ROUND(SUM(tb_philhealth.philhealth),2) as philhealth,
                                          ROUND(SUM(tb_pagibig.pagibig),2) as pagibig,ROUND(SUM(tb_wtax.wtax),2) as wtax
                                     FROM pay_slip
                                    LEFT JOIN daily_time_record ON
                                    daily_time_record.dtr_id=pay_slip.dtr_id
                                    LEFT JOIN refpayperiod ON
                                    refpayperiod.pay_period_id=daily_time_record.pay_period_id
                                    LEFT JOIN months ON
                                    months.month_id = refpayperiod.month_id
                                    LEFT JOIN
                                    (
                                       SELECT pay_slip_id,deduction_amount as sss FROM pay_slip_deductions
                                        WHERE active_deduct = 1 AND deduction_id=1
                                    ) as tb_sss ON
                                       tb_sss.pay_slip_id=pay_slip.pay_slip_id
                                    LEFT JOIN
                                    (
                                       SELECT pay_slip_id,deduction_amount as philhealth FROM pay_slip_deductions
                                        WHERE active_deduct = 1 AND deduction_id=2
                                    ) as tb_philhealth ON
                                       tb_philhealth.pay_slip_id=pay_slip.pay_slip_id
                                    LEFT JOIN
                                    (
                                       SELECT pay_slip_id,deduction_amount as pagibig FROM pay_slip_deductions
                                        WHERE active_deduct = 1 AND deduction_id=3
                                    ) as tb_pagibig ON
                                       tb_pagibig.pay_slip_id=pay_slip.pay_slip_id
                                    LEFT JOIN
                                    (
                                       SELECT pay_slip_id,deduction_amount as wtax FROM pay_slip_deductions
                                        WHERE active_deduct = 1 AND deduction_id=4
                                    ) as tb_wtax ON
                                       tb_wtax.pay_slip_id=pay_slip.pay_slip_id
                                    WHERE employee_id=".$filter_value." AND
                                    refpayperiod.pay_period_year =  ".$filter_value2."
                                    GROUP BY Month) as m
                                    GROUP BY m.Month
                                    ORDER BY m.month_id ASC
                                      ");

            return $query->result();
    }

    function get_alpha_list($filter_value,$start_date,$end_date,$factor,$status='all') {
            $query = $this->db->query("SELECT
                                        last_name,
                                        first_name,
                                        middle_name,
                                        employee_list.is_deleted,
                                        tin,
                                        getwtax.wtax,
                                        COALESCE(get13thmonth.grand_13thmonth_pay,0) as acc_13thmonth_pay,
                                        reftaxcode.tax_code as tax_name,
                                        ROUND(yearly_gross,2) as yearly_gross,
                                        yearly_sss,
                                        yearly_phil,
                                        yearly_pagibig,
                                        ROUND(yearly_gross - (yearly_sss + yearly_phil + yearly_pagibig),
                                                2) AS taxable_income
                                    FROM
                                        employee_list
                                            LEFT JOIN

                                        (SELECT SUM(emp_13thmonth.grand_13thmonth_pay) as grand_13thmonth_pay, emp_13thmonth.employee_id  FROM emp_13thmonth WHERE year = ".$filter_value." GROUP BY emp_13thmonth.employee_id) AS get13thmonth ON get13thmonth.employee_id = employee_list.employee_id

                                            LEFT JOIN
                                        (SELECT
                                            daily_time_record.employee_id,
                                                ROUND(SUM(pay_slip_deductions.deduction_amount), 2) AS wtax
                                        FROM
                                            daily_time_record
                                        LEFT JOIN refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
                                        LEFT JOIN pay_slip ON pay_slip.dtr_id = daily_time_record.dtr_id
                                        LEFT JOIN pay_slip_deductions ON pay_slip_deductions.pay_slip_id = pay_slip.pay_slip_id
                                        WHERE
                                            pay_slip_deductions.deduction_id = 4
                                                AND refpayperiod.pay_period_year = ".$filter_value."
                                        GROUP BY employee_id) AS getwtax ON getwtax.employee_id = employee_list.employee_id


                                            LEFT JOIN
                                        reftaxcode ON reftaxcode.tax_id = employee_list.tax_code
                                            LEFT JOIN
                                        (SELECT
                                            daily_time_record.employee_id,
                                                ROUND(SUM(pay_slip.reg_pay), 2) AS yearly_gross
                                        FROM
                                            daily_time_record
                                        LEFT JOIN refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
                                        LEFT JOIN pay_slip ON pay_slip.dtr_id = daily_time_record.dtr_id
                                        WHERE
                                          refpayperiod.pay_period_year = ".$filter_value."
                                        GROUP BY employee_id) AS gross ON gross.employee_id = employee_list.employee_id
                                            LEFT JOIN
                                        (SELECT
                                            daily_time_record.employee_id,
                                                ROUND(SUM(pay_slip_deductions.deduction_amount), 2) AS yearly_sss
                                        FROM
                                            daily_time_record
                                        LEFT JOIN refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
                                        LEFT JOIN pay_slip ON pay_slip.dtr_id = daily_time_record.dtr_id
                                        LEFT JOIN pay_slip_deductions ON pay_slip_deductions.pay_slip_id = pay_slip.pay_slip_id
                                        WHERE
                                            pay_slip_deductions.deduction_id = 1
                                                AND refpayperiod.pay_period_year = ".$filter_value."
                                        GROUP BY employee_id) AS getsss ON getsss.employee_id = employee_list.employee_id
                                            LEFT JOIN
                                        (SELECT
                                            daily_time_record.employee_id,
                                                ROUND(SUM(pay_slip_deductions.deduction_amount), 2) AS yearly_phil
                                        FROM
                                            daily_time_record
                                        LEFT JOIN refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
                                        LEFT JOIN pay_slip ON pay_slip.dtr_id = daily_time_record.dtr_id
                                        LEFT JOIN pay_slip_deductions ON pay_slip_deductions.pay_slip_id = pay_slip.pay_slip_id
                                        WHERE
                                            pay_slip_deductions.deduction_id = 2
                                                AND refpayperiod.pay_period_year = ".$filter_value."
                                        GROUP BY employee_id) AS getphil ON getphil.employee_id = employee_list.employee_id
                                            LEFT JOIN
                                        (SELECT
                                            daily_time_record.employee_id,
                                                ROUND(SUM(pay_slip_deductions.deduction_amount), 2) AS yearly_pagibig
                                        FROM
                                            daily_time_record
                                        LEFT JOIN refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
                                        LEFT JOIN pay_slip ON pay_slip.dtr_id = daily_time_record.dtr_id
                                        LEFT JOIN pay_slip_deductions ON pay_slip_deductions.pay_slip_id = pay_slip.pay_slip_id
                                        WHERE
                                            pay_slip_deductions.deduction_id = 3
                                            AND refpayperiod.pay_period_year = ".$filter_value."
                                        GROUP BY employee_id) AS getpagibig ON getpagibig.employee_id = employee_list.employee_id
                                        WHERE 
                                            employee_list.is_deleted = FALSE
                                            ".($status=='all'?"":"")."
                                            ".($status==1?" AND employee_list.status = 'Active' AND employee_list.is_retired = FALSE":"")."
                                            ".($status==2?" AND (employee_list.status = 'Inactive' OR employee_list.is_retired = TRUE)":"")."
                                        ORDER BY employee_list.last_name");

            return $query->result();
    }
}
?>
