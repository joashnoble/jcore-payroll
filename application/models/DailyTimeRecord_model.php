<?php

class DailyTimeRecord_model extends CORE_Model {
    protected  $table="daily_time_record";
    protected  $pk_id="dtr_id";

    function __construct() {
        parent::__construct();
    }

    /*function replaceCharsInNumber($num, $chars) {
                     return substr((string) $num, 0, -strlen($chars)) . $chars;
                }*/

    /*function payslip_modify($pay_slip_id){ //if STRING or is ARRAY, just pass it
            $payslip_code_query = $this->db->query('UPDATE pay_slip set pay_slip_code = Payslipcode() WHERE
                                                    pay_slip_id='.$pay_slip_id);
    }

    function payslip_modifyifexist($pay_slip_id,$pay_slip_code){ //if STRING or is ARRAY, just pass it
            $payslip_code_query = $this->db->query('UPDATE pay_slip set pay_slip_code ="'.$pay_slip_code.'" WHERE
                                                    pay_slip_id='.$pay_slip_id);
    }*/
    function get_process_payroll($pay_period_id,$ref_department_id,$ref_branch_id,$status){
        $sql="SELECT 
                dtr.*,
                emp.*,
                CONCAT(emp.first_name,' ',emp.middle_name,' ',emp.last_name) as full_name,
                rd.department,
                rb.branch
            FROM 
            daily_time_record dtr
            LEFT JOIN employee_list emp ON emp.employee_id = dtr.employee_id
            LEFT JOIN emp_rates_duties erd ON erd.emp_rates_duties_id = emp.emp_rates_duties_id
            LEFT JOIN ref_department rd ON rd.ref_department_id = erd.ref_department_id
            LEFT JOIN ref_branch rb ON rb.ref_branch_id = erd.ref_branch_id

            WHERE 
                erd.active_rates_duties = TRUE AND
                emp.is_deleted = FALSE AND
                dtr.is_deleted = FALSE AND
                dtr.pay_period_id = $pay_period_id 
                ".($ref_department_id=='all'?"":" AND erd.ref_department_id=".$ref_department_id)."
                ".($ref_branch_id=='all'?"":" AND erd.ref_branch_id=".$ref_branch_id)."
                ".($status=='all'?"":" AND emp.status='".$status."'")."
            ";
        return $this->db->query($sql)->result();
    }

    function ifexistdtr($employee_id,$pay_period_id) {
        $query = $this->db->query('SELECT dtr_id FROM daily_time_record WHERE employee_id='.$employee_id.' AND pay_period_id='.$pay_period_id.' ');
                            $query->result();

                          return $query->result();
    }

    function getperiodid($dtr_id){
        $query = $this->db->query('SELECT pay_period_id FROM daily_time_record WHERE dtr_id='.$dtr_id);
                            $query->result();
                          return $query->result();
    }

    function getwithoutdtr($pay_period_id) {
                        $query = $this->db->query("SELECT 
                    employee_list.*, ref_department.department
                FROM
                    employee_list
                        LEFT JOIN
                    emp_rates_duties ON employee_list.employee_id = emp_rates_duties.employee_id
                        LEFT JOIN
                    ref_department ON emp_rates_duties.ref_department_id = ref_department.ref_department_id
                WHERE
                    employee_list.emp_rates_duties_id != 0
                        AND emp_rates_duties.active_rates_duties = 1
                        AND employee_list.is_retired != 1
                        AND employee_list.status = 'Active'
                        AND employee_list.is_deleted = 0
                        AND employee_list.employee_id NOT IN (SELECT 
                            employee_id
                        FROM
                            daily_time_record
                        WHERE
                            pay_period_id = $pay_period_id)
                ORDER BY first_name ASC");
                $query->result();

                return $query->result();
    }

    // function get_sss_report($filter){
    //     $query = $this->db->query("SELECT 
    //             employee_list.sss,
    //             employee_list.ecode,
    //             CONCAT(employee_list.first_name,
    //                     ' ',
    //                     employee_list.middle_name,
    //                     ' ',
    //                     employee_list.last_name) AS full_name,
    //             ROUND(pay_slip_deductions.sss_deduction_employee, 2) AS sss_deduction_employee,
    //             ROUND(pay_slip_deductions.sss_deduction_employer, 2) AS sss_deduction_employer,
    //             ROUND(pay_slip_deductions.sss_deduction_ec, 2) AS sss_deduction_ec,
    //             daily_time_record.employee_id,
    //             daily_time_record.pay_period_id,
    //             pay_slip.pay_slip_id,
    //             refpayperiod.month_id,
    //             pay_slip_deductions.deduction_amount,
    //             pay_slip_deductions.sss_id,
    //             ref_sss_contribution.employee,
    //             ref_sss_contribution.employer,
    //             ref_sss_contribution.employer_contribution,
    //             ref_sss_contribution.total,
    //             CONCAT(refpayperiod.pay_period_start,
    //                     '~',
    //                     refpayperiod.pay_period_end) AS period
    //         FROM
    //             daily_time_record
    //                 LEFT JOIN
    //             pay_slip ON pay_slip.dtr_id = daily_time_record.dtr_id
    //                 LEFT JOIN
    //             refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
    //                 LEFT JOIN
    //             pay_slip_deductions ON pay_slip_deductions.pay_slip_id = pay_slip.pay_slip_id
    //                 LEFT JOIN
    //             emp_rates_duties ON emp_rates_duties.employee_id = daily_time_record.employee_id
    //                 LEFT JOIN
    //             employee_list ON employee_list.employee_id = daily_time_record.employee_id
    //                 LEFT JOIN
    //             ref_sss_contribution ON ref_sss_contribution.ref_sss_contribution_id = pay_slip_deductions.sss_id
    //         WHERE
    //             $filter
    //         ORDER BY employee_list.first_name ASC");
    //         $query->result();
    //         return $query->result();
    // }

    function change_status_deduct($deduction_regular_id){

        $sql = "UPDATE new_deductions_regular SET deduction_status_id=2 WHERE deduction_regular_id=".$deduction_regular_id;
        $this->db->query($sql);

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



    function get_pagibig_report($filter, $month_id){
        $query = $this->db->query("SELECT z.* FROM (SELECT x.*, 
                (SELECT 
                    SUM(psd1.deduction_amount)
                        FROM
                            pay_slip_deductions psd1
                        LEFT JOIN pay_slip ps1 ON ps1.pay_slip_id = psd1.pay_slip_id
                        LEFT JOIN daily_time_record dtr1 ON dtr1.dtr_id = ps1.dtr_id
                        LEFT JOIN refpayperiod rpp1 ON rpp1.pay_period_id = dtr1.pay_period_id
                        WHERE
                            dtr1.employee_id = x.employee_id
                                AND psd1.deduction_id = 3
                                AND rpp1.month_id = x.month_id
                        AND rpp1.pay_period_year = x.pay_period_year) AS employee
            FROM 
            (SELECT 
                    refpayperiod.month_id,
                    refpayperiod.pay_period_year,
                    refpayperiod.pay_period_end,
                    daily_time_record.employee_id,
                    CONCAT(employee_list.last_name, ', ', employee_list.first_name, ' ', employee_list.middle_name) AS full_name,
                    employee_list.pag_ibig,
                    employee_list.ecode,
                    ref_branch.branch,
                    (CASE
                        WHEN refpayperiod.month_id = 1 THEN 'January'
                        WHEN refpayperiod.month_id = 2 THEN 'February'
                        WHEN refpayperiod.month_id = 3 THEN 'March'
                        WHEN refpayperiod.month_id = 4 THEN 'April'
                        WHEN refpayperiod.month_id = 5 THEN 'May'
                        WHEN refpayperiod.month_id = 6 THEN 'June'
                        WHEN refpayperiod.month_id = 7 THEN 'July'
                        WHEN refpayperiod.month_id = 8 THEN 'August'
                        WHEN refpayperiod.month_id = 9 THEN 'September'
                        WHEN refpayperiod.month_id = 10 THEN 'October'
                        WHEN refpayperiod.month_id = 11 THEN 'November'
                        WHEN refpayperiod.month_id = 12 THEN 'December'
                        ELSE 'All'
                    END) AS periodmonth
            FROM
                pay_slip
            LEFT JOIN daily_time_record ON pay_slip.dtr_id = daily_time_record.dtr_id
            LEFT JOIN employee_list ON employee_list.employee_id = daily_time_record.employee_id
            LEFT JOIN refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
            LEFT JOIN emp_rates_duties ON emp_rates_duties.emp_rates_duties_id = employee_list.emp_rates_duties_id
            LEFT JOIN ref_branch ON ref_branch.ref_branch_id = emp_rates_duties.ref_branch_id
            WHERE
            $filter
            GROUP BY daily_time_record.employee_id, refpayperiod.month_id, refpayperiod.pay_period_year
            ORDER BY refpayperiod.month_id, employee_list.last_name ASC) as x ) as z");
        $query->result();
        return $query->result();
    }


            // ".($month_id=='all'?"":" WHERE z.employee <= z.total_pagibig_deduction")."");

    function get_philhealth_report($filter, $month_id){
        $query = $this->db->query("SELECT 
                        z.*
                    FROM
                        (SELECT 
                            y.*,
                                (y.total_philhealth_deduction) AS employee,
                                (y.total_philhealth_deduction) AS employer
                        FROM
                            (SELECT 
                            x.total_reg_pay,
                                x.total_philhealth_deduction,
                                x.employee_id,
                                x.full_name,
                                x.phil_health,
                                x.ecode,
                                x.periodmonth
                        FROM
                            (SELECT 
                            (CASE
                                    WHEN
                                        emp_rates_duties.philhealth_salary_credit = 0
                                            || NULL
                                    THEN
                                        SUM(reg_pay)
                                    ELSE emp_rates_duties.philhealth_salary_credit
                                END) AS total_reg_pay,
                                (SELECT 
                                        SUM(psd1.deduction_amount)
                                    FROM
                                        pay_slip_deductions psd1
                                    LEFT JOIN pay_slip ps1 ON ps1.pay_slip_id = psd1.pay_slip_id
                                    LEFT JOIN daily_time_record dtr1 ON dtr1.dtr_id = ps1.dtr_id
                                    LEFT JOIN refpayperiod rpp1 ON rpp1.pay_period_id = dtr1.pay_period_id
                                    WHERE
                                        dtr1.employee_id = daily_time_record.employee_id
                                            AND psd1.deduction_id = 2
                                            AND rpp1.month_id = refpayperiod.month_id
                                            AND rpp1.pay_period_year = refpayperiod.pay_period_year) AS total_philhealth_deduction,
                                daily_time_record.employee_id,
                                CONCAT(employee_list.last_name, ', ', employee_list.first_name, ' ', employee_list.middle_name) AS full_name,
                                employee_list.phil_health,
                                employee_list.ecode,
                                ref_branch.branch,
                                (CASE
                                    WHEN refpayperiod.month_id = 1 THEN 'January'
                                    WHEN refpayperiod.month_id = 2 THEN 'February'
                                    WHEN refpayperiod.month_id = 3 THEN 'March'
                                    WHEN refpayperiod.month_id = 4 THEN 'April'
                                    WHEN refpayperiod.month_id = 5 THEN 'May'
                                    WHEN refpayperiod.month_id = 6 THEN 'June'
                                    WHEN refpayperiod.month_id = 7 THEN 'July'
                                    WHEN refpayperiod.month_id = 8 THEN 'August'
                                    WHEN refpayperiod.month_id = 9 THEN 'September'
                                    WHEN refpayperiod.month_id = 10 THEN 'October'
                                    WHEN refpayperiod.month_id = 11 THEN 'November'
                                    WHEN refpayperiod.month_id = 12 THEN 'December'
                                    ELSE 'All'
                                END) AS periodmonth
                        FROM
                            pay_slip
                        LEFT JOIN daily_time_record ON pay_slip.dtr_id = daily_time_record.dtr_id
                        LEFT JOIN employee_list ON employee_list.employee_id = daily_time_record.employee_id
                        LEFT JOIN refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
                        LEFT JOIN emp_rates_duties ON emp_rates_duties.emp_rates_duties_id = employee_list.emp_rates_duties_id
                        LEFT JOIN ref_branch ON ref_branch.ref_branch_id = emp_rates_duties.ref_branch_id
                        WHERE
                            $filter
                        GROUP BY daily_time_record.employee_id , refpayperiod.month_id , refpayperiod.pay_period_year
                        ORDER BY refpayperiod.month_id , employee_list.last_name ASC) AS x) AS y) AS z");
        $query->result();
        return $query->result();
    }

                        // ".($month_id=='all'?"":" WHERE z.employee <= z.total_philhealth_deduction")."");
 function get_sss_report($filter,$month_id){
        $query = $this->db->query("SELECT 
                        z.*,
                        (z.employee - z.actual_sss_employee) as sss_adj
                    FROM
                        (SELECT 
                            y.*,
                                y.total_sss_deduction AS employee,
                                (SELECT rsc.employer FROM ref_sss_contribution rsc WHERE rsc.ref_sss_contribution_id = y.sss_id) AS employer,
                                (SELECT rsc.employer_contribution FROM ref_sss_contribution rsc
                                    WHERE rsc.ref_sss_contribution_id = y.sss_id) AS employer_contribution,
                                (SELECT rsc.sub_total FROM ref_sss_contribution rsc WHERE rsc.ref_sss_contribution_id = y.sss_id) AS sub_total,
                                (SELECT rsc.total FROM ref_sss_contribution rsc WHERE rsc.ref_sss_contribution_id = y.sss_id) AS total,

                                COALESCE((SELECT rsc.employee FROM ref_sss_contribution rsc WHERE y.totalregpay BETWEEN salary_range_from AND salary_range_to AND is_deleted = 0),0) as actual_sss_employee,

                                COALESCE((SELECT rsc.employer FROM ref_sss_contribution rsc WHERE y.totalregpay BETWEEN salary_range_from AND salary_range_to AND is_deleted = 0),0) as actual_sss_employer,

                                COALESCE((SELECT rsc.employer_contribution FROM ref_sss_contribution rsc WHERE y.totalregpay BETWEEN salary_range_from AND salary_range_to AND is_deleted = 0),0) as actual_sss_ec,

                                COALESCE((SELECT rsc.total FROM ref_sss_contribution rsc WHERE y.totalregpay BETWEEN salary_range_from AND salary_range_to AND is_deleted = 0),0) AS actual_sss_total
                        FROM
                            (SELECT 
                            x.pay_slip_id,
                                x.total_sss_deduction,
                                x.sss_id,
                                x.total_reg_pay,
                                x.totalregpay,
                                x.employee_id,
                                x.month_id,
                                x.full_name,
                                x.sss,
                                x.ecode,
                                x.periodmonth
                        FROM
                            (SELECT 
                            pay_slip.pay_slip_id,
                                (CASE
                                    WHEN
                                        emp_rates_duties.sss_phic_salary_credit = 0
                                            || NULL
                                    THEN
                                        SUM(reg_pay)
                                    ELSE emp_rates_duties.sss_phic_salary_credit
                                END) AS total_reg_pay,
                                SUM(reg_pay) as totalregpay,
                                (SELECT 
                                        SUM(psd1.deduction_amount)
                                    FROM
                                        pay_slip_deductions psd1
                                    LEFT JOIN pay_slip ps1 ON ps1.pay_slip_id = psd1.pay_slip_id
                                    LEFT JOIN daily_time_record dtr1 ON dtr1.dtr_id = ps1.dtr_id
                                    LEFT JOIN refpayperiod rpp1 ON rpp1.pay_period_id = dtr1.pay_period_id
                                    WHERE
                                        dtr1.employee_id = daily_time_record.employee_id
                                            AND psd1.deduction_id = 1
                                            AND rpp1.month_id = refpayperiod.month_id
                                            AND rpp1.pay_period_year = refpayperiod.pay_period_year) AS total_sss_deduction,
                                (SELECT 
                                        MAX(psd1.sss_id) as sss_id
                                    FROM
                                        pay_slip_deductions psd1
                                    LEFT JOIN pay_slip ps1 ON ps1.pay_slip_id = psd1.pay_slip_id
                                    LEFT JOIN daily_time_record dtr1 ON dtr1.dtr_id = ps1.dtr_id
                                    LEFT JOIN refpayperiod rpp1 ON rpp1.pay_period_id = dtr1.pay_period_id
                                    WHERE
                                        dtr1.employee_id = daily_time_record.employee_id
                                            AND psd1.deduction_id = 1
                                            AND rpp1.month_id = refpayperiod.month_id
                                            AND rpp1.pay_period_year = refpayperiod.pay_period_year) AS sss_id,
                                refpayperiod.month_id,
                                daily_time_record.employee_id,
                                CONCAT(employee_list.last_name, ', ', employee_list.first_name, ' ', employee_list.middle_name) AS full_name,
                                employee_list.sss,
                                employee_list.ecode,
                                ref_branch.branch,
                                (CASE
                                    WHEN refpayperiod.month_id = 1 THEN 'January'
                                    WHEN refpayperiod.month_id = 2 THEN 'February'
                                    WHEN refpayperiod.month_id = 3 THEN 'March'
                                    WHEN refpayperiod.month_id = 4 THEN 'April'
                                    WHEN refpayperiod.month_id = 5 THEN 'May'
                                    WHEN refpayperiod.month_id = 6 THEN 'June'
                                    WHEN refpayperiod.month_id = 7 THEN 'July'
                                    WHEN refpayperiod.month_id = 8 THEN 'August'
                                    WHEN refpayperiod.month_id = 9 THEN 'September'
                                    WHEN refpayperiod.month_id = 10 THEN 'October'
                                    WHEN refpayperiod.month_id = 11 THEN 'November'
                                    WHEN refpayperiod.month_id = 12 THEN 'December'
                                    ELSE 'All'
                                END) AS periodmonth
                        FROM
                            pay_slip
                        LEFT JOIN daily_time_record ON pay_slip.dtr_id = daily_time_record.dtr_id
                        LEFT JOIN employee_list ON employee_list.employee_id = daily_time_record.employee_id
                        LEFT JOIN refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
                        LEFT JOIN emp_rates_duties ON emp_rates_duties.emp_rates_duties_id = employee_list.emp_rates_duties_id
                        LEFT JOIN ref_branch ON ref_branch.ref_branch_id = emp_rates_duties.ref_branch_id
                        WHERE
                            $filter
                        GROUP BY daily_time_record.employee_id , refpayperiod.month_id , refpayperiod.pay_period_year
                        ORDER BY refpayperiod.month_id , employee_list.last_name ASC) AS x) AS y) AS z");
            $query->result();
            return $query->result();
    }

                        // ".($month_id=='all'?"":" WHERE z.employee <= z.total_sss_deduction")."");
    
    function get_wtax_report($filter){
        $query = $this->db->query("SELECT 
                j.*,
                (SELECT 
                        (CASE
                                WHEN col1_cl > j.total_wdeduction THEN (((j.total_wdeduction - col1_cl) * (col1_percent)) + (col1_amount))
                                WHEN j.total_wdeduction BETWEEN col2_cl AND col3_cl THEN (((j.total_wdeduction - col2_cl) * (col2_percent)) + (col2_amount))
                                WHEN j.total_wdeduction BETWEEN col3_cl AND col4_cl THEN (((j.total_wdeduction - col3_cl) * (col3_percent)) + (col3_amount))
                                WHEN j.total_wdeduction BETWEEN col4_cl AND col5_cl THEN (((j.total_wdeduction - col4_cl) * (col4_percent)) + (col4_amount))
                                WHEN j.total_wdeduction BETWEEN col5_cl AND col6_cl THEN (((j.total_wdeduction - col5_cl) * (col5_percent)) + (col5_amount))
                                ELSE (((j.total_wdeduction - col6_cl) * (col6_percent)) + (col6_amount))
                            END) AS wtax_employee
                    FROM
                        ref_payment_type
                    WHERE
                        ref_payment_type_id = 2) AS wtax_employee
            FROM
                (SELECT 
                    b.*,
                        b.taxable_amount - (b.sss_employee + b.pagibig_employee + philhealth_employee) AS total_wdeduction
                FROM
                    (SELECT 
                    y.*,
                        (SELECT 
                                rsc.employee
                            FROM
                                ref_sss_contribution rsc
                            WHERE
                                y.taxable_amount BETWEEN rsc.salary_range_from AND rsc.salary_range_to) AS sss_employee,
                        '100' AS pagibig_employee,
                        (SELECT 
                                (CASE
                                        WHEN y.taxable_amount <= 10000 THEN rpc.employee
                                        WHEN y.taxable_amount >= 40000 THEN rpc.employee
                                        ELSE ((y.taxable_amount * percentage) / 2)
                                    END) AS employee
                            FROM
                                ref_philhealth_contribution rpc
                            LIMIT 1) AS philhealth_employee
                FROM
                    (SELECT 
                    x.taxable_amount,
                        x.employee_id,
                        x.full_name,
                        x.tin,
                        x.ecode,
                        x.periodmonth
                FROM
                    (SELECT 
                        (CASE 
                            WHEN emp_rates_duties.ref_payment_type_id = 4
                                THEN emp_rates_duties.monthly_based_salary
                            WHEN emp_rates_duties.ref_payment_type_id = 1
                                THEN emp_rates_duties.monthly_based_salary
                            WHEN emp_rates_duties.ref_payment_type_id = 2
                                THEN emp_rates_duties.salary_reg_rates
                            ELSE emp_rates_duties.salary_reg_rates
                        END) AS taxable_amount,
                        daily_time_record.employee_id,
                        CONCAT(employee_list.last_name, ', ', employee_list.first_name, ' ', employee_list.middle_name) AS full_name,
                        employee_list.tin,
                        employee_list.ecode,
                        ref_branch.branch,
                        (CASE
                            WHEN refpayperiod.month_id = 1 THEN 'January'
                            WHEN refpayperiod.month_id = 2 THEN 'February'
                            WHEN refpayperiod.month_id = 3 THEN 'March'
                            WHEN refpayperiod.month_id = 4 THEN 'April'
                            WHEN refpayperiod.month_id = 5 THEN 'May'
                            WHEN refpayperiod.month_id = 6 THEN 'June'
                            WHEN refpayperiod.month_id = 7 THEN 'July'
                            WHEN refpayperiod.month_id = 8 THEN 'August'
                            WHEN refpayperiod.month_id = 9 THEN 'September'
                            WHEN refpayperiod.month_id = 10 THEN 'October'
                            WHEN refpayperiod.month_id = 11 THEN 'November'
                            WHEN refpayperiod.month_id = 12 THEN 'December'
                            ELSE 'All'
                        END) AS periodmonth
                FROM
                    pay_slip
                LEFT JOIN daily_time_record ON pay_slip.dtr_id = daily_time_record.dtr_id
                LEFT JOIN employee_list ON employee_list.employee_id = daily_time_record.employee_id
                LEFT JOIN refpayperiod ON refpayperiod.pay_period_id = daily_time_record.pay_period_id
                LEFT JOIN emp_rates_duties ON emp_rates_duties.emp_rates_duties_id = employee_list.emp_rates_duties_id
                LEFT JOIN ref_branch ON ref_branch.ref_branch_id = emp_rates_duties.ref_branch_id
                WHERE $filter
                GROUP BY daily_time_record.employee_id , refpayperiod.month_id , refpayperiod.pay_period_year
                ORDER BY refpayperiod.month_id , employee_list.last_name ASC) AS x) AS y) AS b) AS j");
        $query->result();
        return $query->result();
    }

     function getwithoutdtrBACKUP($pay_period_id) {
        $query = $this->db->query('SELECT employee_list.*,ref_department.ref_department_id,ref_department.department,
         emp_rates_duties.emp_rates_duties_id FROM employee_list LEFT JOIN emp_rates_duties ON employee_list.employee_id=emp_rates_duties.employee_id
         LEFT JOIN ref_department ON emp_rates_duties.ref_department_id=ref_department.ref_department_id
         WHERE employee_list.employee_id NOT IN(SELECT employee_id FROM daily_time_record WHERE pay_period_id ='.$pay_period_id.')');
                            $query->result();

                          return $query->result();
    }

    function applyisdeduct($m_dtr_id,$is_deduct){
        for($i=0;$i<count($is_deduct);$i++){
                        $sql = 'UPDATE dtr_deductions SET is_deduct=1 WHERE dtr_id='.$m_dtr_id.' AND deduction_id='.$is_deduct[$i];
                        $this->db->query($sql);
                    }
    }

    function applyfulldeduct($m_dtr_id,$full_deduct){
        for($i=0;$i<count($full_deduct);$i++){
                        $sql = 'UPDATE dtr_deductions SET full_deduct=1 WHERE dtr_id='.$m_dtr_id.' AND deduction_id='.$full_deduct[$i];
                        $this->db->query($sql);
                    }
    }    

    function get_per_hour_pay($employee_id) {
      $query = $this->db->query('SELECT * FROM emp_rates_duties
                                WHERE active_rates_duties=1 AND employee_id='.$employee_id);
                                foreach ($query->result() as $row)
                                  {
                                          $per_hour_pay = $row->per_hour_pay;
                                  }
                                  return $per_hour_pay;
    }

    function get_hour_per_day($employee_id) {
      $query = $this->db->query('SELECT * FROM emp_rates_duties
                                WHERE active_rates_duties=1 AND employee_id='.$employee_id);
                                foreach ($query->result() as $row)
                                  {
                                          $hour_per_day = $row->hour_per_day;
                                  }
                                  return $hour_per_day;
    }    

    function get_pay_type($employee_id) {
      $query = $this->db->query('SELECT ref_payment_type_id, salary_reg_rates FROM emp_rates_duties
                                WHERE active_rates_duties=1 AND employee_id='.$employee_id);
                                return $query->result();
    }

    function get_salary_pay($employee_id) {
      $query = $this->db->query('SELECT * FROM emp_rates_duties
                                WHERE active_rates_duties=1 AND employee_id='.$employee_id);
                                foreach ($query->result() as $row)
                                  {
                                          $salary_reg_rates = $row->salary_reg_rates;
                                  }
                                  return $salary_reg_rates;
    }

    function get_semi_monthly_pay($employee_id) {
      $query = $this->db->query('SELECT salary_reg_rates,ref_payment_type_id FROM emp_rates_duties
                                WHERE active_rates_duties=1 AND employee_id='.$employee_id);
                                  return $query->result();
    }

    function get_factorfile() {
      $query2 = $this->db->query('SELECT * FROM reffactorfile');

                                return $query2->result();

    }

    function SSS_lookup_default($salary_reg_rates) {
      $tempsss = $this->db->query('SELECT ref_sss_contribution_id, total, employer as sss_deduction_employer, employer_contribution as sss_deduction_ec, employee as sss_deduction_employee FROM ref_sss_contribution WHERE '.$salary_reg_rates.' BETWEEN salary_range_from AND salary_range_to AND is_deleted = 0');
                                    return $tempsss->result();
    }

    function get_current_deduction($month_id,$pay_period_year,$deduction_id,$employee_id){
        $query = $this->db->query("SELECT 
                        COALESCE(SUM(deduction_amount),0) as deduction,
                        COALESCE(SUM(psd.sss_deduction_employer),0) as sss_deduction_employer,
                        COALESCE(SUM(psd.sss_deduction_ec),0) as sss_deduction_ec
                    FROM
                        pay_slip ps 
                        LEFT JOIN daily_time_record dtr ON dtr.dtr_id = ps.dtr_id 
                        LEFT JOIN refpayperiod rpp ON rpp.pay_period_id = dtr.pay_period_id
                        LEFT JOIN pay_slip_deductions psd ON psd.pay_slip_id = ps.pay_slip_id
                        WHERE
                            rpp.month_id = ".$month_id."
                            AND rpp.pay_period_year = ".$pay_period_year."
                            AND psd.deduction_id = ".$deduction_id."
                            AND employee_id = ".$employee_id);
        return $query->result();
    }


    function verify_half_deduct($verify_amount_value,$ref_payment_type_id_lookup) {
                                    if($ref_payment_type_id_lookup==1){
                                        $sss_employee_deduct_value = $verify_amount_value/2;
                                    }
                                    else{
                                        $sss_employee_deduct_value= $verify_amount_value;
                                    }
                                        return $sss_employee_deduct_value;
    }

    function SSS_lookup_shield($ssslookuptaxshield) {
      $ssstemplookup=$this->db->query('SELECT ref_sss_contribution_id,employee FROM ref_sss_contribution WHERE '.$ssslookuptaxshield.' BETWEEN salary_range_from AND salary_range_to AND is_deleted = 0');
                                        return $ssstemplookup->result();
                                        /*$ssstempreflookup = $ssstemplookup->result();*/
                                        /*return $ssstempreflookup[0]->employee;*/

    }

    function Philhealth_lookup_default($salary_reg_rates) {
      $tempphilhealth = $this->db->query('SELECT 
                            ref_philhealth_contribution_id, 
                            (CASE
                                WHEN '.$salary_reg_rates.' <= 10000 THEN employee
                                WHEN '.$salary_reg_rates.' >= 40000 THEN employee
                                ELSE (('.$salary_reg_rates.'*percentage)/2)
                            END) as employee
                        FROM
                            ref_philhealth_contribution');
                                        return $tempphilhealth->result();
    }

    function Wtax_lookup($total_dtr_amount,$emp_payment_type_id) {

    $semimonthly = $this->db->query('SELECT (CASE
            WHEN col1_cl > '.$total_dtr_amount.' THEN ((('.$total_dtr_amount.'-col1_cl)*(col1_percent))+(col1_amount))
            WHEN '.$total_dtr_amount.' BETWEEN col2_cl AND col3_cl THEN ((('.$total_dtr_amount.'-col2_cl)*(col2_percent))+(col2_amount))
            WHEN '.$total_dtr_amount.' BETWEEN col3_cl AND col4_cl THEN ((('.$total_dtr_amount.'-col3_cl)*(col3_percent))+(col3_amount))
            WHEN '.$total_dtr_amount.' BETWEEN col4_cl AND col5_cl THEN ((('.$total_dtr_amount.'-col4_cl)*(col4_percent))+(col4_amount))
            WHEN '.$total_dtr_amount.' BETWEEN col5_cl AND col6_cl THEN ((('.$total_dtr_amount.'-col5_cl)*(col5_percent))+(col5_amount))
            ELSE ((('.$total_dtr_amount.'-col6_cl)*(col6_percent))+(col6_amount))

        END) as wtax
        FROM ref_payment_type
        WHERE ref_payment_type_id='.$emp_payment_type_id.'');

        foreach($semimonthly->result() as $row)
        {
            $wtax = $row->wtax;
        }
     
        return $wtax;

    }

    function Wtax_lookup_shield($taxshielddeduct,$emp_tax_code) {

    $semimonthly = $this->db->query('SELECT (CASE
            WHEN col1_cl > '.$taxshielddeduct.' THEN ((('.$taxshielddeduct.'-col1_cl)*(col1_percent))+(col1_amount))
            WHEN '.$taxshielddeduct.' BETWEEN col2_cl AND col3_cl THEN ((('.$taxshielddeduct.'-col2_cl)*(col2_percent))+(col2_amount))
            WHEN '.$taxshielddeduct.' BETWEEN col3_cl AND col4_cl THEN ((('.$taxshielddeduct.'-col3_cl)*(col3_percent))+(col3_amount))
            WHEN '.$taxshielddeduct.' BETWEEN col4_cl AND col5_cl THEN ((('.$taxshielddeduct.'-col4_cl)*(col4_percent))+(col4_amount))
            WHEN '.$taxshielddeduct.' BETWEEN col5_cl AND col6_cl THEN ((('.$taxshielddeduct.'-col5_cl)*(col5_percent))+(col5_amount))
            ELSE ((('.$taxshielddeduct.'-col6_cl)*(col6_percent))+(col6_amount))

        END) as wtax
        FROM ref_payment_type
        WHERE ref_payment_type_id='.$emp_payment_type_id.'');

    foreach($semimonthly->result() as $row)
    {
        $wtax = $row->wtax;
    }
                                return $wtax;

    }

    function process_payroll($dtr_id) {
        $j=0;

        foreach($dtr_id as $dtr_process)
        {
            $updateArray[] = array(
            'dtr_id'=>$dtr_id[$j],
            'is_to_process' => 0,
            );
            $j++;
        }

        $processpayroll = $this->db->update_batch('daily_time_record',$updateArray, 'dtr_id');
        
        $i=0;
        //echo count($dtr_id);
                foreach($dtr_id as $dtr)
                              {
                                //echo $dtr_id[$i];
                                //SELECT DTR based on dtr_id
                                $checkifexists = $this->db->query('SELECT dtr_id,pay_slip_id FROM pay_slip WHERE dtr_id='.$dtr);
                                $deleteexist = $checkifexists->result();
                                $exist = 0;
                                //echo json_encode($checkifexists->result());
                                if ($checkifexists->num_rows() != 0) {
                                    $exist = 1;
                                    /*$pay_slip_code = $deleteexist[0]->pay_slip_code;*/
                                    $pay_slip_id_rm = $deleteexist[0]->pay_slip_id;
                                    //deleting current payslip based on last pay slip id
                                    $this->db->where('pay_slip_id', $pay_slip_id_rm);
                                    $this->db->delete('pay_slip');
                                    //deleting deductions based on foreign key
                                    $this->db->where('pay_slip_id', $pay_slip_id_rm);
                                    $this->db->delete('pay_slip_deductions');
                                    //deleting earnings based on foreign key
                                    $this->db->where('pay_slip_id', $pay_slip_id_rm);
                                    $this->db->delete('pay_slip_other_earnings');

                                }
                                  //echo json_encode($checkifexists->result());
                                $this->db->select('daily_time_record.employee_id,
                                        daily_time_record.dtr_id,
                                        daily_time_record.pay_period_id,
                                        sss_phic_salary_credit,
                                        philhealth_salary_credit,
                                        pagibig_salary_credit,
                                        tax_shield,
                                        tax_code,
                                        pay_period_sequence,
                                        emp_rates_duties.salary_reg_rates,
                                        monthly_based_salary,
                                        emp_rates_duties.ref_payment_type_id,
                                        emp_rates_duties.hour_per_day,
                                        reg_amt,
                                        sun_amt,
                                        day_off_amt,
                                        reg_hol_amt,
                                        sun_reg_hol_amt,
                                        sun_reg_hol_amt,
                                        spe_hol_amt,
                                        sun_spe_hol_amt,
                                        days_wout_pay_amt,
                                        days_with_pay_amt,
                                        minutes_late_amt,
                                        minutes_undertime_amt,
                                        minutes_excess_break_amt,
                                        ot_reg_amt,
                                        ot_reg_reg_hol_amt,
                                        ot_reg_spe_hol_amt,
                                        ot_sun_amt,
                                        ot_sun_reg_hol_amt,
                                        ot_sun_spe_hol_amt,
                                        nsd_reg_amt,
                                        nsd_reg_reg_hol_amt,
                                        nsd_reg_spe_hol_amt,
                                        nsd_sun_amt,
                                        nsd_sun_reg_hol_amt,
                                        nsd_sun_spe_hol_amt');

                                $where = $dtr;
                                $this->db->where('dtr_id', $where);
                                $this->db->where('active_rates_duties', 1);
                                $this->db->join('emp_rates_duties', 'emp_rates_duties.employee_id = daily_time_record.employee_id', 'left');
                                $this->db->join('employee_list', 'employee_list.employee_id = emp_rates_duties.employee_id', 'left');
                                $this->db->join('refpayperiod', 'refpayperiod.pay_period_id = daily_time_record.pay_period_id', 'left');
                                $query = $this->db->get('daily_time_record');
                                $processtemp=$query->result();

                                $dtr_id = $processtemp[0]->dtr_id;
                                $payslip_no = date('Y').'00'.$dtr_id;

                                $pay_period_id = $processtemp[0]->pay_period_id;
                                $monthly_based_salary = $processtemp[0]->monthly_based_salary;

                                $get_details_period = $this->db->query('SELECT (TIMESTAMPDIFF(day, pay_period_start, pay_period_end)+1) as no_days, month_id, pay_period_year FROM refpayperiod WHERE pay_period_id = '.$pay_period_id);

                                $perioddetails = $get_details_period->result();

                                $no_days = $perioddetails[0]->no_days;
                                $month_id = $perioddetails[0]->month_id;
                                $pay_period_year = $perioddetails[0]->pay_period_year;

                                $get_count_period = $this->db->query('SELECT COUNT(*) as period_count FROM refpayperiod WHERE is_deleted = 0 AND month_id = '.$month_id.' AND pay_period_year = '.$pay_period_year.' AND (TIMESTAMPDIFF(day, pay_period_start, pay_period_end)+1) ='.$no_days);
                                
                                $period_count = $get_count_period->result();
                                
                                $pcount = $period_count[0]->period_count;
                                
                                //TAX CODE OF EMPLOYEE
                                $ref_payment_type_id = $processtemp[0]->ref_payment_type_id;
                                $emp_tax_code=$processtemp[0]->tax_code;
                                //SALARY REG RATES FOR WTAX LOOKUP

                                $salary_reg_rates = $processtemp[0]->salary_reg_rates;

                                //echo json_encode($processtemp);
                                
                                //PROCESS PAYROLL
                                $reg_pay = $processtemp[0]->reg_amt;
                                $sun_pay = $processtemp[0]->sun_amt;
                                $day_off_pay = $processtemp[0]->day_off_amt;
                                $reg_hol_pay = $processtemp[0]->reg_hol_amt + $processtemp[0]->sun_reg_hol_amt;
                                
                                $spe_hol_pay = $processtemp[0]->spe_hol_amt + $processtemp[0]->sun_spe_hol_amt;

                                $reg_ot_pay = $processtemp[0]->ot_reg_amt + $processtemp[0]->ot_reg_reg_hol_amt + $processtemp[0]->ot_reg_spe_hol_amt;
                                $sun_ot_pay = $processtemp[0]->ot_sun_amt + $processtemp[0]->ot_sun_reg_hol_amt + $processtemp[0]->ot_sun_spe_hol_amt;
                                $reg_nsd_pay = $processtemp[0]->nsd_reg_amt + $processtemp[0]->nsd_reg_reg_hol_amt + $processtemp[0]->nsd_reg_spe_hol_amt;
                                $sun_nsd_pay = $processtemp[0]->nsd_sun_amt + $processtemp[0]->nsd_sun_reg_hol_amt + $processtemp[0]->nsd_sun_spe_hol_amt;
                                //TOTAL DTR AMOUNT
                                $total_dtr_amount=$reg_pay+$sun_pay+$day_off_pay+$reg_hol_pay+$spe_hol_pay+$reg_ot_pay+$sun_ot_pay+$reg_nsd_pay+$sun_nsd_pay;
                                $total_deductions=0;
                                $sssdeduct=0;
                                $sss_deduction_employer = 0;
                                $sss_deduction_ec = 0;
                                $philhealthdeduct=0;
                                $sss_deduction_employee = 0;
                                $ref_payment_type_id_lookup=$processtemp[0]->ref_payment_type_id;
                                $reg_amt = $processtemp[0]->reg_amt;
                                //echo $total_dtr_amount;

                                //GET FACTOR FILE
                                $reffactorfile = $this->db->query('SELECT * FROM reffactorfile');
                                $rff = $reffactorfile->result();

                                //GET SETTINGS OF DEDUCTIONS
                                $deductsettingstemp = $this->db->query('SELECT * FROM system_settings_default_deductions
                                                                        LEFT JOIN dtr_deductions
                                                                        ON system_settings_default_deductions.deduction_id=dtr_deductions.deduction_id
                                                                        WHERE dtr_id='.$dtr);
                                $deductsettings = $deductsettingstemp->result();

                                // SSS 
                                $sss_is_deduct=$deductsettings[0]->is_deduct;
                                // PhilHealth
                                $philhealth_is_deduct=$deductsettings[1]->is_deduct;
                                // Pagibig 
                                $pagibig_is_deduct=$deductsettings[2]->is_deduct;
                                // WTAX
                                $wtax_is_deduct=$deductsettings[3]->is_deduct;

                                // SSS Full Deduct
                                $sss_full_deduct=$deductsettings[0]->full_deduct; 
                                // Philhealth Full Deduct
                                $philhealth_full_deduct=$deductsettings[1]->full_deduct; 
                                // Pagibig Full Deduct
                                $pagibig_full_deduct=$deductsettings[2]->full_deduct;
                                // Wtax Full Deduct
                                $wtax_full_deduct=$deductsettings[3]->full_deduct; 


                                //SSS DEDUCT
                                if($sss_is_deduct==1){

                                    $sss_stat="true";
                                    $sss = 0;
                                    $refsss = 0;
                                    $sssdeduct = 0;
                                    $sss_deduction_employee = 0;
                                    $sss_deduction_employer = 0;
                                    $sss_deduction_ec = 0;
                                    $sss_amount= 0;

                                    if($processtemp[0]->sss_phic_salary_credit == 0.00 || $processtemp[0]->sss_phic_salary_credit == null){
                                        $sss_amount = $monthly_based_salary;
                                    }else{
                                        $sss_amount = $processtemp[0]->sss_phic_salary_credit;
                                    }

                                    $refsss = $this->SSS_lookup_default($sss_amount);
                                    $sss_id=$refsss[0]->ref_sss_contribution_id;
                                    $sss = $refsss[0]->sss_deduction_employee;

                                    $sss_current_deduction = $this->get_current_deduction($month_id,$pay_period_year,1,$processtemp[0]->employee_id);

                                    $sss_c_deduction_amt = $sss_current_deduction[0]->deduction;
                                    $sss_deduction_employer_amt = $sss_current_deduction[0]->sss_deduction_employer;
                                    $sss_deduction_ec_amt = $sss_current_deduction[0]->sss_deduction_ec;

                                    $sss_deduction_complete = $refsss[0]->sss_deduction_employee - $sss_c_deduction_amt;

                                    if ($sss_deduction_complete <= 0){
                                        $sss=0;
                                        $sssdeduct=0;
                                        $sss_stat="false";
                                    }else{

                                        if($sss_full_deduct == 1){
                                            $sssdeduct = ($refsss[0]->sss_deduction_employee - $sss_c_deduction_amt);
                                            $sss_deduction_employee = ($refsss[0]->sss_deduction_employee - $sss_c_deduction_amt);
                                            $sss_deduction_employer = ($refsss[0]->sss_deduction_employer - $sss_deduction_employer_amt);
                                            $sss_deduction_ec = ($refsss[0]->sss_deduction_ec - $sss_deduction_ec_amt);

                                        }else{

                                            if ($ref_payment_type_id == 1){ // Semi-Monthly

                                                $sssdeduct = $refsss[0]->sss_deduction_employee / 2;
                                                $sss_deduction_employee = ($refsss[0]->sss_deduction_employee) / 2;
                                                $sss_deduction_employer = ($refsss[0]->sss_deduction_employer) / 2;
                                                $sss_deduction_ec = ($refsss[0]->sss_deduction_ec) / 2;

                                            }else if ($ref_payment_type_id == 2){ // Monthly

                                                $sssdeduct = $refsss[0]->sss_deduction_employee;
                                                $sss_deduction_employee = $refsss[0]->sss_deduction_employee;
                                                $sss_deduction_employer = $refsss[0]->sss_deduction_employer;
                                                $sss_deduction_ec = $refsss[0]->sss_deduction_ec;

                                            }else if ($ref_payment_type_id == 4){ // Weekly

                                                $sssdeduct = $refsss[0]->sss_deduction_employee / $pcount;
                                                $sss_deduction_employee = ($refsss[0]->sss_deduction_employee) / $pcount;
                                                $sss_deduction_employer = ($refsss[0]->sss_deduction_employer) / $pcount;
                                                $sss_deduction_ec = ($refsss[0]->sss_deduction_ec) / $pcount;

                                            }
                                        }

                                    }

                                }else{
                                    $sss=0;
                                    $sssdeduct=0;
                                    $sss_stat="false";
                                }

                                //PHILHEALTH DEDUCT
                                if($philhealth_is_deduct==1){

                                    $philhealth_stat="true";
                                    $philhealth = 0;
                                    $refphilhealth = 0;
                                    $philhealthdeduct = 0;
                                    $philhealth_amount= 0;

                                    if($processtemp[0]->philhealth_salary_credit == 0.00 || $processtemp[0]->philhealth_salary_credit == null){
                                        $philhealth_amount = $monthly_based_salary;
                                    }else{
                                        $philhealth_amount = $processtemp[0]->philhealth_salary_credit;
                                    }

                                    $refphilhealth = $this->Philhealth_lookup_default($philhealth_amount);
                                    $philhealth_id=$refphilhealth[0]->ref_philhealth_contribution_id;
                                    $philhealth = $refphilhealth[0]->employee;

                                    $phil_current_deduction = $this->get_current_deduction($month_id,$pay_period_year,2,$processtemp[0]->employee_id);

                                    $phil_c_deduction_amt = $phil_current_deduction[0]->deduction;

                                    $phil_deduction_complete = $refphilhealth[0]->employee - $phil_c_deduction_amt;

                                    if ($phil_deduction_complete <= 0){
                                        $philhealth = 0;
                                        $philhealthdeduct=0;
                                        $philhealth_stat="false";
                                    }else{

                                        if($philhealth_full_deduct == 1){

                                            $philhealthdeduct = ($refphilhealth[0]->employee - $phil_c_deduction_amt);

                                        }else{

                                            if ($ref_payment_type_id == 1){ // Semi-Monthly
                                                $philhealthdeduct = ($refphilhealth[0]->employee) / 2;
                                            }else if ($ref_payment_type_id == 2){ // Monthly
                                                $philhealthdeduct = $refphilhealth[0]->employee;
                                            }else if ($ref_payment_type_id == 4){ // Weekly
                                                $philhealthdeduct = ($refphilhealth[0]->employee) / $pcount;
                                            }
                                        }
                                    }

                                }else{
                                    $philhealth = 0;
                                    $philhealthdeduct=0;
                                    $philhealth_stat="false";
                                }

                            //PAGIBIG DEDUCT
                            if($pagibig_is_deduct==1){
                                //PAG IBIG SHIELD CHECK
                                $pagibig_stat="true";
                                $pagibig = $rff[0]->pagibig1;
                                $pagibigdeduct = 0;

                                $pagibig_current_deduction = $this->get_current_deduction($month_id,$pay_period_year,3,$processtemp[0]->employee_id);
                                $pagibig_c_deduction_amt = $pagibig_current_deduction[0]->deduction;

                                $pagibig_deduction_complete = $pagibig - $pagibig_c_deduction_amt;

                                if ($pagibig_deduction_complete <= 0){
                                    $pagibig_stat="false";
                                    $pagibig = 0;
                                    $pagibigdeduct=0;
                                }else{

                                    if($pagibig_full_deduct == 1){
                                        $pagibigdeduct = ($rff[0]->pagibig1) - $pagibig_c_deduction_amt;
                                    }else{
                                        if ($ref_payment_type_id == 1){ // Semi-Monthly
                                            $pagibigdeduct = ($rff[0]->pagibig1) / 2;
                                        }else if ($ref_payment_type_id == 2){ // Monthly
                                            $pagibigdeduct = $rff[0]->pagibig1;
                                        }else if ($ref_payment_type_id == 4){ // Weekly
                                            $pagibigdeduct = ($rff[0]->pagibig1) / $pcount;
                                        }
                                    }
                                }
                            }
                            else{
                                $pagibig_stat="false";
                                $pagibig = 0;
                                $pagibigdeduct=0;
                            }

                            //GET REGULAR EARNINGS
                            $regular_earnings=0;
                            $re=0;
                            $regearningstemp = $this->db->query('SELECT oe_regular_id,earnings_id,oe_regular_amount FROM new_otherearnings_regular WHERE employee_id='.$processtemp[0]->employee_id.' AND oe_cycle='.$processtemp[0]->pay_period_sequence.' AND is_temporary=0 AND is_deleted=0');
                            

                            
                            foreach ($regearningstemp->result() as $row)
                            {
                                    $regular_earnings+=$row->oe_regular_amount;
                                    $oe_regular_id[$re] = $row->oe_regular_id;
                                    $earnings_id[$re] = $row->earnings_id;
                                    $oe_regular_amount[$re] = $row->oe_regular_amount;
                                    $re++;
                            }

                                 //GET TEMPORARY EARNINGS
                                $temporary_earnings=0;
                                $rt=0;
                                $tempearnings = $this->db->query('SELECT oe_regular_id,earnings_id,oe_regular_amount FROM new_otherearnings_regular WHERE employee_id='.$processtemp[0]->employee_id.' AND pay_period_id='.$processtemp[0]->pay_period_id.' AND is_temporary=1 AND is_deleted=0');
                                foreach ($tempearnings->result() as $row)
                                {
                                        $temporary_earnings+=$row->oe_regular_amount;
                                        $oe_regular_id_T[$rt] = $row->oe_regular_id;
                                        $earnings_id_T[$rt] = $row->earnings_id;
                                        $oe_regular_amount_T[$rt] = $row->oe_regular_amount;
                                        $rt++;
                                }

                                 //GET REGULAR DEDUCTIONS
                                $regular_deductions=0;
                                $rd=0;
                                //for cash advance and loans
                                $regulardeductionloans = $this->db->query("SELECT 
                                        new_deductions_regular.deduction_regular_id,
                                        deduction_per_pay_amount,
                                        dtr.dtr_id,
                                        is_deduct,
                                        new_deductions_regular.deduction_id,
                                        dtr.pay_period_id,
                                        dtr.employee_id,
                                        rpp.pay_period_sequence
                                    FROM
                                        daily_time_record dtr
                                            LEFT JOIN
                                        dtr_deductions ON dtr.dtr_id = dtr_deductions.dtr_id
                                            LEFT JOIN
                                        new_deductions_regular ON dtr_deductions.deduction_id = new_deductions_regular.deduction_id
                                            LEFT JOIN
                                        refpayperiod rpp ON rpp.pay_period_id = dtr.pay_period_id
                                            LEFT JOIN
                                        reg_deduction_cycle rdc on rdc.deduction_regular_id = new_deductions_regular.deduction_regular_id
                                    WHERE
                                        new_deductions_regular.employee_id = ".$processtemp[0]->employee_id."
                                            AND rdc.pay_period_id = dtr.pay_period_id
                                            AND dtr.dtr_id = ".$dtr."
                                            AND is_temporary = 0
                                            AND new_deductions_regular.deduction_id != 1
                                            AND new_deductions_regular.deduction_id != 2
                                            AND new_deductions_regular.deduction_id != 3
                                            AND new_deductions_regular.deduction_id != 4
                                            AND new_deductions_regular.is_deleted = 0
                                            AND new_deductions_regular.deduction_status_id=1");

                                foreach ($regulardeductionloans->result() as $row)
                                {
                                    if ($row->is_deduct > 0){

                                        $get_balance = $this->getalldeduct($row->employee_id,$row->pay_period_id,$row->pay_period_sequence,$row->deduction_id);
                                    
                                        if ($get_balance[0]->grand_balance > 0){

                                            if (($get_balance[0]->grand_balance - $row->deduction_per_pay_amount) <= 0){
                                                $this->change_status_deduct($row->deduction_regular_id);
                                            }  

                                            $regular_deductions+=$row->deduction_per_pay_amount;
                                            $deduction_regular_id[$rd] = $row->deduction_regular_id;
                                            $deduction_id[$rd] = $row->deduction_id;
                                            $deduction_per_pay_amount[$rd] = $row->deduction_per_pay_amount;
                                            $isdeduct[$rd] = $row->is_deduct;
                                            $rd++;
                                        }
                                    }
                                }

                                 //GET TEMPORARY DEDUCTIONS
                                $temporary_deductions=0;
                                $td=0;
                                $tempdeduction = $this->db->query("SELECT 
                                            new_deductions_regular.deduction_regular_id,
                                            deduction_per_pay_amount,
                                            daily_time_record.dtr_id,
                                            is_deduct,
                                            new_deductions_regular.deduction_id
                                        FROM
                                            daily_time_record
                                                LEFT JOIN
                                            dtr_deductions ON daily_time_record.dtr_id = dtr_deductions.dtr_id
                                                LEFT JOIN
                                            new_deductions_regular ON dtr_deductions.deduction_id = new_deductions_regular.deduction_id
                                        WHERE
                                            new_deductions_regular.employee_id = ".$processtemp[0]->employee_id."
                                                AND daily_time_record.dtr_id = ".$dtr."
                                                AND new_deductions_regular.pay_period_id = ".$processtemp[0]->pay_period_id."
                                                AND is_temporary = 1
                                                AND new_deductions_regular.deduction_id != 1
                                                AND new_deductions_regular.deduction_id != 2
                                                AND new_deductions_regular.deduction_id != 3
                                                AND new_deductions_regular.deduction_id != 4
                                                AND new_deductions_regular.is_deleted = 0");

                                foreach ($tempdeduction->result() as $row)
                                {
                                    if($row->is_deduct!=0){
                                        $temporary_deductions+=$row->deduction_per_pay_amount;
                                        $deduction_regular_id_T[$td] = $row->deduction_regular_id;
                                        $deduction_id_T[$td] = $row->deduction_id;
                                        $deduction_per_pay_amount_T[$td] = $row->deduction_per_pay_amount;
                                        $isdeduct_T[$td] = $row->is_deduct;
                                        $td++;
                                    }
                                }
                                //echo json_encode($regulardeduction->result());
                                //echo json_encode($tempdeduction->result());
                                //echo $regular_deductions;
                                //echo "<br>";
                                //echo $temporary_deductions;
                                ///echo $temporary_earnings;
                                //echo $regular_earnings;
                                //echo $sssdeduct;
                                //echo $pagibigdeduct;
                                //echo $taxshielddeduct;
                                $gross_pay=$total_dtr_amount+$regular_earnings+$temporary_earnings+$processtemp[0]->days_with_pay_amt;

                                //SALARY REG RATES MINUS DEDUCTIONS SSS/PHIL/PAGIBIG
                                  $sss_phil_pagibig_deductions=$sss+$philhealth+$pagibig;
                                  $wtax_lookup_amount=0;

                                  //WTAX DEDUCT
                                  if($wtax_is_deduct==1){
                                    //WITH HOLDING TAX SHIELD CHECK
                                    $withholdingtax_stat="true";
                                    $withholding_lookup = 0;
                                    $wtax_lookup_amount= 0;

                                    if($processtemp[0]->tax_shield == 0.00 || $processtemp[0]->tax_shield == null){
                                        $wtax_lookup_amount = $gross_pay-$sss_phil_pagibig_deductions;
                                    }else{
                                        $wtax_lookup_amount = $processtemp[0]->tax_shield-$sss_phil_pagibig_deductions;
                                    }

                                        if ($ref_payment_type_id == 4){ // Semi-Monthly
                                            $withholding_lookup = ($this->Wtax_lookup($wtax_lookup_amount,2)) / $pcount;
                                        }else{
                                            $withholding_lookup = $this->Wtax_lookup($wtax_lookup_amount,$ref_payment_type_id);
                                        }
                                  }
                                  else{
                                        $withholding_lookup=0;
                                        $withholdingtax_stat="false";
                                  }

                                $total_deductions=$sssdeduct+$pagibigdeduct+$philhealthdeduct+$withholding_lookup+$regular_deductions+$temporary_deductions+$processtemp[0]->days_wout_pay_amt+$processtemp[0]->minutes_late_amt+$processtemp[0]->minutes_undertime_amt+$processtemp[0]->minutes_excess_break_amt;
                                $net_pay=$gross_pay-$total_deductions;

                                //echo $processtemp[0]->reg_amt;
                                  $data[0] =
                                     array(
                                        'dtr_id' => $dtr,
                                        'payslip_no' => $payslip_no,
                                        'reg_pay' => $reg_pay,
                                        'sun_pay' => $sun_pay,
                                        'day_off_pay' => $day_off_pay,
                                        'reg_hol_pay' => $reg_hol_pay,
                                        'spe_hol_pay' => $spe_hol_pay,
                                        'reg_ot_pay' => $reg_ot_pay,
                                        'sun_ot_pay' => $sun_ot_pay,
                                        'reg_nsd_pay' => $reg_nsd_pay,
                                        'sun_nsd_pay' => $sun_nsd_pay,
                                        'days_wout_pay_amt' => $processtemp[0]->days_wout_pay_amt,
                                        'days_with_pay_amt' => $processtemp[0]->days_with_pay_amt,
                                        'minutes_late_amt' => $processtemp[0]->minutes_late_amt,
                                        'minutes_undertime_amt' => $processtemp[0]->minutes_undertime_amt,
                                        'minutes_excess_break_amt' => $processtemp[0]->minutes_excess_break_amt,
                                        'total_dtr_amount' => $total_dtr_amount,
                                        'gross_pay' => $gross_pay,
                                        'taxable_pay' => $total_dtr_amount,
                                        'total_deductions' => $total_deductions,
                                        'net_pay' => $net_pay,
                                        'date_processed' => date("Y-m-d"),
                                        'processed_by' => $this->session->user_id
                                     );

                                $this->db->insert_batch('pay_slip', $data);
                                //LAST INSERT ID OF PAY SLIP
                                $pay_slip_id=$this->db->insert_id();

                                //CODE TO INSERT TO PAY SLIP EARNINGS
                                /*$format = "000000";
                                $temp = $this->replaceCharsInNumber($format, $pay_slip_id); //5069xxx
                                $pay_slip_code = $temp .'-'. $today = date("Y");*/
                                /*if($exist==1){
                                    $pay_slip_code = $this->payslip_modifyifexist($pay_slip_id,$pay_slip_code);
                                }
                                else{
                                    $pay_slip_code = $this->payslip_modify($pay_slip_id);
                                }*/

                                /*echo $pay_slip_code;*/
                                $z=0;
                                $dataregearnings="";
                                for($z;$re>$z;$z++){
                                    $dataregearnings[] =
                                     array(
                                        'pay_slip_id' => $pay_slip_id,
                                        'earnings_id' => $earnings_id[$z],
                                        'earnings_amount' => $oe_regular_amount[$z],
                                        'oe_regular_id' => $oe_regular_id[$z]
                                     );
                                }
                                $x=0;
                                $datatempearnings="";
                                for($x;$rt>$x;$x++){
                                    $datatempearnings[] =
                                     array(
                                        'pay_slip_id' => $pay_slip_id,
                                        'earnings_id' => $earnings_id_T[$x],
                                        'earnings_amount' => $oe_regular_amount_T[$x],
                                        'oe_regular_id' => $oe_regular_id_T[$x]
                                     );
                                }
                                $z_deduct=0;
                                $dataregdeductions="";
                                for($z_deduct;$rd>$z_deduct;$z_deduct++){
                                    /*$query_reg_deduct = $this->db->query('SELECT (deduction_total_amount) as deduct_balance FROM new_deductions_regular
                                                                WHERE deduction_regular_id='.$deduction_regular_id[$z_deduct]);

                                    $deduct_balance_temp = $query_reg_deduct->row(0);
                                    $deduct_balance_amount[$z_deduct] = $deduct_balance_temp->deduct_balance;*/
                                    /*echo $deduct_balance_amount[$z_deduct];*/
                                    /*$dataregdeductions[] = array();*/
                                    //checking if there is enough balance in loans
                                    /*if($deduct_balance_amount>$deduction_per_pay_amount[$z_deduct]){*/
                                        $dataregdeductions[] =
                                         array(
                                            'pay_slip_id' => $pay_slip_id,
                                            'deduction_id' => $deduction_id[$z_deduct],
                                            'deduction_amount' => $deduction_per_pay_amount[$z_deduct],
                                            'deduction_regular_id' => $deduction_regular_id[$z_deduct],
                                            'active_deduct' => $isdeduct[$z_deduct],
                                         );
                                        /*$newval=$deduct_balance_amount-$deduction_per_pay_amount[$z_deduct];
                                        $updatebalance = array(
                                                'deduction_total_amount' => $newval,
                                                'deduction_total_amount_tempo' => $deduction_per_pay_amount[$z_deduct]
                                        );*/

                                        /*$this->db->where('deduction_regular_id', $deduction_regular_id[$z_deduct]);
                                        $this->db->update('new_deductions_regular', $updatebalance);*/
                                    /*}*/
                                    //if less than or equal do this
                                    /*else{*/
                                        /*$dataregdeductions[] =
                                         array(
                                            'pay_slip_id' => $pay_slip_id,
                                            'deduction_id' => $deduction_id[$z_deduct],
                                            'deduction_amount' => $deduct_balance_amount,
                                            'deduction_regular_id' => $deduction_regular_id[$z_deduct],
                                            'active_deduct' => $isdeduct[$z_deduct],
                                         );
*/
                                         /*$updatebalance = array(
                                                'deduction_total_amount' => 0,
                                                'deduction_total_amount_tempo' => $deduct_balance_amount
                                        );*/

                                        /*$this->db->where('deduction_regular_id', $deduction_regular_id[$z_deduct]);
                                        $this->db->update('new_deductions_regular', $updatebalance);*/
                                    /*}*/

                                }
                                $x_deduct=0;
                                $datatempdeductions="";
                                for($x_deduct;$td>$x_deduct;$x_deduct++){
                                    $datatempdeductions[] =
                                     array(
                                        'pay_slip_id' => $pay_slip_id,
                                        'deduction_id' => $deduction_id_T[$x_deduct],
                                        'deduction_amount' => $deduction_per_pay_amount_T[$x_deduct],
                                        'deduction_regular_id' => $deduction_regular_id_T[$x_deduct],
                                        'active_deduct' => $isdeduct_T[$x_deduct],
                                     );
                                }
                                if($re!=0){
                                  $this->db->insert_batch('pay_slip_other_earnings', $dataregearnings);
                                }
                                else{
                                  //do not insert
                                }
                                if($rt!=0){
                                  $this->db->insert_batch('pay_slip_other_earnings', $datatempearnings);
                                }
                                else{
                                  //do not insert
                                }
                                if($z_deduct!=0){
                                    /*echo "w";*/
                                  $this->db->insert_batch('pay_slip_deductions', $dataregdeductions);
                                 /* $m_products->set('quantity','quantity-'.$invalue);*/
                                    $z_deduct_2=0;
                                    for($z_deduct_2;$rd>$z_deduct_2;$z_deduct_2++){
                                            $pay_slip_deduct_temp = $this->db->query('SELECT ndr.loan_total_amount,deduction_total_amount,pay_slip_deductions.deduction_regular_id,SUM(deduction_amount) as total_loan_deductamount FROM pay_slip_deductions
                                                                        LEFT JOIN new_deductions_regular as ndr
                                                                        ON pay_slip_deductions.deduction_regular_id=ndr.deduction_regular_id
                                                                        WHERE  pay_slip_deductions.pay_slip_id='.$pay_slip_id.' AND pay_slip_deductions.deduction_regular_id='.$deduction_regular_id[$z_deduct_2]);

                                            // $pay_slip_adjustment_temp = $this->db->query('SELECT debit_amount,credit_amount FROM pay_slip_loans_adjustments
                                            //                             WHERE pay_slip_loans_adjustments.deduction_regular_id='.$deduction_regular_id[$z_deduct_2]);

                                            $pay_slip_deduct_filter = $pay_slip_deduct_temp->result();
                                            $loan_total_amount_temp = $pay_slip_deduct_filter[0]->deduction_total_amount;
                                            $total_loan_deductamount = $pay_slip_deduct_filter[0]->total_loan_deductamount;
                                            // $debit_amount = 0;
                                            // $credit_amount = 0;
                                            // foreach($pay_slip_adjustment_temp->result() as $psa){
                                            //     $credit_amount += $psa->credit_amount;
                                            //     $debit_amount += $psa->debit_amount;
                                            // }
                                            /*echo $credit_amount;
                                            echo "<br>";
                                            echo $debit_amount;*/


                                            $loan_total_amount= $loan_total_amount_temp;

                                            /*$deduct_balance_amount = $pay_slip_deduct_filter[0]->deduction_total_amount;*/
                                            /*$newval=$loan_total_amount-$total_loan_deductamount;*/
                                        if($exist==0){
                                          if($loan_total_amount>$total_loan_deductamount){
                                              $newval=$loan_total_amount-$total_loan_deductamount;
                                              /*echo $newval;*/
                                              /*echo "if";*/
                                              $updatebalance = array(
                                                      'deduction_total_amount' => $newval,
                                                      'deduction_total_amount_tempo' => $deduction_per_pay_amount[$z_deduct_2]
                                              );

                                              $this->db->where('deduction_regular_id', $deduction_regular_id[$z_deduct_2]);
                                              $this->db->update('new_deductions_regular', $updatebalance);
                                          }
                                          else{
                                              /*echo "else";*/
                                              $total_loan_balance_temp = $total_loan_deductamount-$loan_total_amount;
                                              $total_loan_balance = abs(($total_loan_balance_temp-$deduction_per_pay_amount[$z_deduct_2]));
                                              /*echo $deduct_balance_amount[$z_deduct_2];*/
                                              $updatebalance = array(
                                              'deduction_total_amount' => 0,
                                              'deduction_total_amount_tempo' => $total_loan_balance
                                              );

                                              $this->db->where('deduction_regular_id', $deduction_regular_id[$z_deduct_2]);
                                              $this->db->update('new_deductions_regular', $updatebalance);

                                              /*echo $total_loan_balance;*/
                                              $updatepayslipdeduct = array(
                                              'deduction_amount' => $total_loan_balance
                                              );

                                              $this->db->where('deduction_regular_id', $deduction_regular_id[$z_deduct_2]);
                                              $this->db->where('pay_slip_id', $pay_slip_id);
                                              $this->db->update('pay_slip_deductions', $updatepayslipdeduct);

                                          }
                                        }
                                        else{
                                          //do not update / do nothing
                                        }
                                    }
                                }
                                else{
                                  //do not insert
                                }
                                if($x_deduct!=0){
                                  $this->db->insert_batch('pay_slip_deductions', $datatempdeductions);
                                }
                                else{
                                  //do not insert
                                }

                                if($sss_stat=="true"){
                                  $data_deductions[0] =
                                     array(
                                        'pay_slip_id' => $pay_slip_id,
                                        'deduction_id' => 1,
                                        'deduction_amount' => $sssdeduct,
                                        'sss_deduction_employer' => $sss_deduction_employer,
                                        'sss_deduction_ec' => $sss_deduction_ec,
                                        'sss_deduction_employee' => $sss_deduction_employee,
                                        'sss_id' => $sss_id,
                                        'active_deduct' => TRUE,
                                     );
                                  $this->db->insert_batch('pay_slip_deductions', $data_deductions);
                                }
                                else{
                                  //insert with false deduct
                                    $data_deductions[0] =
                                     array(
                                        'pay_slip_id' => $pay_slip_id,
                                        'deduction_id' => 1,
                                        'deduction_amount' => $sssdeduct,
                                        'sss_deduction_employer' => $sss_deduction_employer,
                                        'sss_deduction_ec' => $sss_deduction_ec,    
                                        'sss_deduction_employee' => $sss_deduction_employee,
                                        'active_deduct' => FALSE,
                                     );
                                    $this->db->insert_batch('pay_slip_deductions', $data_deductions);
                                }

                                if($philhealth_stat=="true"){
                                  $data_deductions_phil[0] =
                                     array(
                                        'pay_slip_id' => $pay_slip_id,
                                        'deduction_id' => 2,
                                        'deduction_amount' => $philhealthdeduct,
                                        'philhealth_id' => $philhealth_id,
                                        'active_deduct' => TRUE,
                                     );
                                  $this->db->insert_batch('pay_slip_deductions', $data_deductions_phil);
                                }
                                else{
                                  //insert with false deduct
                                    $data_deductions_phil[0] =
                                     array(
                                        'pay_slip_id' => $pay_slip_id,
                                        'deduction_id' => 2,
                                        'deduction_amount' => $philhealthdeduct,
                                        'active_deduct' => FALSE,
                                     );
                                    $this->db->insert_batch('pay_slip_deductions', $data_deductions_phil);

                                }

                                if($pagibig_stat=="true"){
                                  $data_deductions_pagibig[0] =
                                     array(
                                        'pay_slip_id' => $pay_slip_id,
                                        'deduction_id' => 3,
                                        'deduction_amount' => $pagibigdeduct,
                                        'active_deduct' => TRUE,
                                     );
                                  $this->db->insert_batch('pay_slip_deductions', $data_deductions_pagibig);
                                }
                                else{
                                  //insert pagibig with flase deduct
                                    $data_deductions_pagibig[0] =
                                     array(
                                        'pay_slip_id' => $pay_slip_id,
                                        'deduction_id' => 3,
                                        'deduction_amount' => $pagibigdeduct,
                                        'active_deduct' => FALSE,
                                     );
                                    $this->db->insert_batch('pay_slip_deductions', $data_deductions_pagibig);
                                }
                                
                                //WITHHOLDING TAX TRUE
                                if($withholdingtax_stat=="true"){
                                    /*$wtax = $this->Wtax_lookup($total_dtr_amount);*/
                                    /*echo $wtax;*/
                                    /*echo "true";*/
                                  $data_deductions_withholdingtax_e[0] =
                                     array(
                                        'pay_slip_id' => $pay_slip_id,
                                        'deduction_id' => 4,
                                        'deduction_amount' => $withholding_lookup,
                                        'active_deduct' => TRUE,
                                     );
                                    $this->db->insert_batch('pay_slip_deductions', $data_deductions_withholdingtax_e);
                                }
                                else{
                                  //insert WH TAX with false deduct
                                    /*$wtax = $this->Wtax_lookup($total_dtr_amount);*/
                                    /*echo $wtax;*/
                                    $data_deductions_withholdingtax_e[0] =
                                     array(
                                        'pay_slip_id' => $pay_slip_id,
                                        'deduction_id' => 4,
                                        'deduction_amount' => $withholding_lookup,
                                        'active_deduct' => FALSE,
                                     );
                                    $this->db->insert_batch('pay_slip_deductions', $data_deductions_withholdingtax_e);
                                }


                                //echo json_encode($regearningstemp->result());

                                //return true;

                        $i++;
                        }
                    return true;
    }

}
?>
