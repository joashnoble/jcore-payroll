<style>
    table{
	border-collapse: collapse;
	width: 100%;
	max-width: 100%;
	border-spacing: 0;
	font-family: calibri;
	page-break-inside:avoid;
  	}
  .theader-right{
    vertical-align: baseline;
    width: 200px;
    border: 1px solid black;
    font-size: 10pt;
  }
  .ttitle{
    font-weight: bold;
    padding-left: 10px;
    font-size: 11pt;
    border-top: 1px solid black;
    border-left: 1px solid black;
    border-bottom: 1px solid black;
  }
  .theader{
    padding-left: 10px;
    border-left: 1px solid black;
    font-size: 8pt;
  }
  .theader-bottom{
    padding-left: 10px;
    border-left: 1px solid black;
    border-bottom: 1px solid black;
    font-size: 8pt;
  }
  .title-td-first{
    font-weight: 500;
    font-size: 8pt;
    border-left: 1px solid black;
    padding-left: 10px;
    white-space:nowrap;
  }
  .title-td-top{
    font-weight: 500;
    font-size: 8pt;
    border-left: 1px solid black;
    padding-left: 10px;
    white-space:nowrap;
  }
  .title-td{
    font-weight: 500;
    padding-left: 10px;
    font-size: 8pt;
    white-space:nowrap;
  }
  .result-td{
    font-weight: 500;
    border-right: 1px solid black;
    font-size: 8pt;
    padding-right: 10px;
    text-align: right;
    white-space:nowrap;
  }
  .result-td-top{
    font-weight: 500;
    border-right: 1px solid black;
    padding-top: 5px;
    font-size: 8pt;
    padding-right: 10px;
    text-align: right;
    white-space:nowrap;
  }
  .result-total-td{
    font-weight: bold;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
    border-right: 1px solid black;
    font-size: 9pt;
    text-align: right;
    padding-right: 10px;
  }
  .result-title-td{
    font-weight: bold;
    font-size: 8pt;
    border-left: 1px solid black;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 10px;
  }
  .info-right{
    margin-top: 20px !important;
    padding: 10px;
    text-align: center;
    font-size: 9pt!important;
  }
  .title-margin{
    margin-top: 20px;
  }
  .title-margin-bottom{
    margin-top: 40px;
  }
  	.PaySlip{
  		width:100%;
  	}
</style>
<div class="PaySlip">
	<table>
		<tr>
			<td colspan="6" class="" style="font-weight: bold;
    font-size: 11pt;
    border-top: 1px solid black;
    border-bottom: 1px solid black;border-left: 1px solid black;padding: 10px;">
				<?php echo $payslip->branch; ?>
			</td>
			<td rowspan="21" class="theader-right" style="border-top: 1px solid black;">
				<div class="info-right">
						<strong>Payslip No:</strong>
						<p><?php echo $payslip->payslip_no;?></p>
						<strong>NAME:</strong>
						<p><?php echo $payslip->full_name; ?></p>
						<p class="title-margin"><strong>NAME OF PROJECT/DEPARTMENT: </strong></p>
						<p><?php echo $payslip->department."/<br>".$payslip->group_desc; ?></p>
						<p class="title-margin"><strong>PAY TYPE</strong></p>
						<p><?php echo $payslip->payment_type; ?></p>
						<p class="title-margin"><strong>PERIOD COVERED</strong></p>
						<p><?php echo date("m-d-Y", strtotime($payslip->pay_period_start))." ~ ".date("m-d-Y", strtotime($payslip->pay_period_end)); ?></p>
						<p class="title-margin">I acknowledge that i receive the amount</p>
						<hr>
						<p>and have no further claims for the services rendered</p>
						<p class="title-margin-bottom"><strong>Employee Signature</strong></p>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="6" class="theader"><strong>Payslip No:</strong> <?php echo $payslip->payslip_no; ?></td>
		</tr>
		<tr>
			<td colspan="6" class="theader"><strong>NAME:</strong> <?php echo $payslip->full_name; ?></td>
		</tr>
		<tr>
			<td colspan="6" class="theader"><strong>NAME OF PROJECT / DEPARTMENT:</strong> <?php echo $payslip->department; ?> </td>
		</tr>
		<tr>
			<td colspan="6" class="theader"><strong>PAY TYPE:</strong> <?php echo $payslip->payment_type; ?></td>
		</tr>
		<tr>
			<td colspan="6" class="theader-bottom"><strong>PERIOD COVERED:</strong>
				<?php echo date("m-d-Y", strtotime($payslip->pay_period_start))." ~ ".date("m-d-Y", strtotime($payslip->pay_period_end)); ?></td>
		</tr>
		<tr>
			<td class="title-td-first">Basic Pay: </td>
			<td class="result-td-top"><?php echo number_format($payslip->reg_pay,2); ?></td>
			<td class="title-td">SSS Premium: </td>
			<td class="result-td"><?php echo number_format($total_sss_deduct->total_sss_deduct,2); ?></td>
			<!-- <td class="title-td">Year to Date</td>
			<td class="result-td"></td> -->
			<!-- <td class="title-td">YTD SALARY</td>
			<td class="result-td"></td> -->			
			<td class="title-td">YTD W/TAX:</td>
			<td class="result-td"></td>
		</tr>
		<tr>
			<td class="title-td-first">Sunday Pay: </td>
			<td class="result-td"><?php echo number_format($payslip->sun_pay,2); ?></td>
			<td class="title-td">Philhealth:</td>
			<td class="result-td"><?php echo number_format($total_philhealth_deduct->total_philhealth_deduct,2); ?></td>
			<td class="title-td">Overtime Hours</td>
			<td class="result-td"></td>
		</tr>
		<tr>
			<td class="title-td-first">Salary Adjustments</td>
			<td class="result-td"><?php echo number_format($earning_salary_adjustment->total_earnings_salary_adjustments,2); ?></td>
			<td class="title-td">Pag-ibig:</td>
			<td class="result-td"><?php echo number_format($total_pagibig_deduct->total_pagibig_deduct,2); ?></td>
			<td class="title-td">Regular Hours:</td>
			<td class="result-td"><?php echo number_format($payslip->reg,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first">Allowance:</td>
			<td class="result-td"><?php echo number_format($earning_total_allowance->total_allowance,2); ?></td>
			<td class="title-td">Withholding Tax:</td>
			<td class="result-td"><?php echo number_format($total_withholdingtax_deduct->total_withholdingtax_deduct,2); ?></td>
			<td class="title-td">Sundays:</td>
			<td class="result-td"><?php echo number_format($payslip->sun,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first">E.COLA:</td>
			<td class="result-td"><?php echo number_format($payslip->cola_pay,2); ?></td>
			<td class="title-td">SSS Loan:</td>
			<td class="result-td"><?php echo number_format($total_sss_loan->total_sss_loan,2); ?></td>
			<td class="title-td">Regular OT Hours:</td>
			<td class="result-td"><?php echo number_format($payslip->ot_reg + $payslip->ot_reg_reg_hol + $payslip->ot_reg_spe_hol,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first">Other Income:</td>
			<td class="result-td"><?php echo number_format($other_earnings->total_other_earnings,2); ?></td>
			<td class="title-td">Pag-ibig Loan:</td>
			<td class="result-td"><?php echo number_format($total_pagibig_loan->total_pagibig_loan,2); ?></td>
			<td class="title-td">Sunday OT Hours:</td>
			<td class="result-td"><?php echo number_format($payslip->ot_sun + $payslip->ot_sun_reg_hol + $payslip->ot_sun_spe_hol,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first">Total Regular OT:</td>
			<td class="result-td"><?php echo number_format($payslip->reg_ot_pay,2); ?></td>
			<td class="title-td">Cash Advance:</td>
			<td class="result-td"><?php echo number_format($total_cash_advance->total_cash_advance,2); ?></td>
			<td class="title-td">Special Holiday Hours:</td>
			<td class="result-td"><?php echo number_format($payslip->spe_hol+$payslip->sun_spe_hol,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first">Total Sunday OT:</td>
			<td class="result-td"><?php echo number_format($payslip->sun_ot_pay,2); ?></td>
			<td class="title-td">Minutes Late:</td>
			<td class="result-td"><?php echo number_format($payslip->minutes_late_amt,2); ?></td>
			<td class="title-td">Legal Holiday Hours:</td>
			<td class="result-td"><?php echo number_format($payslip->reg_hol+$payslip->sun_reg_hol,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first">Total Special Holiday:</td>
			<td class="result-td"><?php echo number_format($payslip->spe_hol_pay,2); ?></td>
			<td class="title-td">Minutes Undertime:</td>
			<td class="result-td"><?php echo number_format($payslip->minutes_undertime_amt,2); ?></td>
			<td class="title-td">NSD Reg Hours:</td>
			<td class="result-td"><?php echo number_format($payslip->nsd_reg+$payslip->nsd_reg_reg_hol+$payslip->nsd_reg_spe_hol,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first">Total Legal Holiday:</td>
			<td class="result-td"><?php echo number_format($payslip->reg_hol_pay,2); ?></td>
			<td class="title-td">Minutes Excess Break:</td>
			<td class="result-td"><?php echo number_format($payslip->minutes_excess_break_amt,2); ?></td>
			<td class="title-td">NSD Sun Hours:</td>
			<td class="result-td"><?php echo number_format($payslip->nsd_sun+$payslip->nsd_sun_reg_hol+$payslip->nsd_sun_spe_hol,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first">NSD Reg:</td>
			<td class="result-td"><?php echo number_format($payslip->reg_nsd_pay,2); ?></td>
			<td class="title-td">Calamity Loan:</td>
			<td class="result-td"><?php echo number_format($total_calamity_loan->total_calamity_loan,2); ?></td>	
			<td class="title-td">Total Late (Minutes)</td>
  			<td class="result-td"><?php echo number_format($payslip->minutes_late,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first">NSD Sunday:</td>
			<td class="result-td"><?php echo number_format($payslip->sun_nsd_pay,2); ?></td>
			<td class="title-td">Others:</td>
			<td class="result-td"><?php echo number_format($total_other_deduction->total_other_deduction,2); ?></td>
  			<td class="title-td">Total Undertime (Minutes)</td>
  			<td class="result-td"><?php echo number_format($payslip->minutes_undertime,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first">Days W/Pay:</td>
			<td class="result-td"><?php echo number_format($payslip->days_with_pay_amt,2); ?></td>
			<td class="title-td">Days W/O Pay:</td>
			<td class="result-td"><?php echo number_format($payslip->days_wout_pay_amt,2); ?></td>
			<!-- <td class="title-td">COOP Loan:</td> -->
			<!-- <td class="result-td"><?php //echo number_format($total_coop_loan->total_coop_loan,2); ?></td> -->
  			<td class="title-td">Total Excess Break (Minutes)</td>
  			<td class="result-td"><?php echo number_format($payslip->minutes_excess_break,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first">Rest Day Pay:</td>
			<td class="result-td"><?php echo number_format($payslip->day_off_pay,2); ?></td>
			<td class="title-td"><!-- COOP Contribution: -->--</td>
			<td class="result-td"><!-- <?php echo number_format($total_coop_contribution->total_coop_contribution,2); ?> --></td>
  			<td class="title-td">Rest Day Hours</td>
  			<td class="result-td"><?php echo number_format($payslip->day_off,2) ?></td>
		</tr>
		<tr>
			<td class="result-title-td">Gross Pay: </td>
			<td class="result-total-td" style="color: #1A237E;">
				<?php echo number_format($payslip->gross_pay,2); ?>
			</td>
			<td class="result-title-td">Deductions: </td>
			<td class="result-total-td" style="color: #d50000;">
				<?php echo number_format($total_sss_deduct->total_sss_deduct+$total_philhealth_deduct->total_philhealth_deduct+$total_pagibig_deduct->total_pagibig_deduct+$total_withholdingtax_deduct->total_withholdingtax_deduct+$total_sss_loan->total_sss_loan+$total_pagibig_loan->total_pagibig_loan+$total_cash_advance->total_cash_advance+$total_coop_loan->total_coop_loan+$total_coop_contribution->total_coop_contribution+$total_calamity_loan->total_calamity_loan+$total_other_deduction->total_other_deduction+$payslip->days_wout_pay_amt+$payslip->minutes_late_amt+$payslip->minutes_undertime_amt+$payslip->minutes_excess_break_amt,2); ?>
			</td>
			<td class="result-title-td">Net: </td>
			<td class="result-total-td" style="color: #1B5E20">
				<?php echo number_format($payslip->net_pay,2); ?>
			</td>
		</tr>
	</table>
</div>
