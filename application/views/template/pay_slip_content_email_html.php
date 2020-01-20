<div class="PaySlip" style="width: 100%;">
	<table style="border-collapse: collapse;width: 100%;max-width: 100%;border-spacing: 0;font-family: calibri;page-break-inside:avoid;">
		<tr>
			<td colspan="6" class="ttitle" style="font-weight: bold;padding-left: 10px;font-size: 11pt;border-top: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black;"><?php echo $payslip->branch; ?></td>
			<td rowspan="21" class="theader-right" style="vertical-align: baseline!important;width: 200px!important;border: 1px solid black!important;font-size: 10pt;!important">
				<div class="info-right" style="margin-top: 20px!important;padding: 20px!important;text-align: center!important;font-size: 9pt!important;">
					<center>
						<strong>Payslip No:</strong>
						<p><?php echo $payslip->payslip_no;?></p>
						<br />

						<strong>NAME:</strong>
						<p><?php echo $payslip->full_name; ?></p>
						<br />

						<p class="title-margin" style="margin-top: 20px;"><strong>NAME OF PROJECT/DEPARTMENT: </strong></p>
						<p><?php echo $payslip->department."/<br>".$payslip->group_desc; ?></p>
						<br />

						<p class="title-margin" style="margin-top: 20px;"><strong>PAY TYPE</strong></p>
						<p><?php echo $payslip->payment_type; ?></p>
						<br />

						<p class="title-margin" style="margin-top: 20px;"><strong>PERIOD COVERED</strong></p>
						<p><?php echo date("m-d-Y", strtotime($payslip->pay_period_start))." ~ ".date("m-d-Y", strtotime($payslip->pay_period_end)); ?></p>
						<br />
						<p class="title-margin" style="margin-top: 20px;">I acknowledge that i receive the amount</p>
						<hr>
						<p>and have no further claims for the services rendered</p>

						<br />
						<p class="title-margin-bottom" style="margin-top: 40px;"><strong>Employee Signature</strong></p>
					</center>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="6" class="theader" style="padding-left: 10px;border-left: 1px solid black;font-size: 8pt;"><strong>Payslip No:</strong> <?php echo $payslip->payslip_no; ?></td>
		</tr>
		<tr>
			<td colspan="6" class="theader" style="padding-left: 10px;border-left: 1px solid black;font-size: 8pt;"><strong>NAME:</strong> <?php echo $payslip->full_name; ?></td>
		</tr>
		<tr>
			<td colspan="6" class="theader" style="padding-left: 10px;border-left: 1px solid black;font-size: 8pt;"><strong>NAME OF PROJECT / DEPARTMENT:</strong> <?php echo $payslip->department; ?> </td>
		</tr>
		<tr>
			<td colspan="6" class="" style="padding-left: 10px;border-left: 1px solid black;font-size: 8pt;"><strong>PAY TYPE:</strong> <?php echo $payslip->payment_type; ?></td>
		</tr>
		<tr>
			<td colspan="6" class="theader-bottom" style="padding-left: 10px;border-left: 1px solid black;border-bottom: 1px solid black;font-size: 8pt;"><strong>PERIOD COVERED:</strong>
				<?php echo date("m-d-Y", strtotime($payslip->pay_period_start))." ~ ".date("m-d-Y", strtotime($payslip->pay_period_end)); ?></td>
		</tr>
		<tr>
			<td class="title-td-first" style="font-weight: 500;font-size: 8pt;border-left: 1px solid black;padding-left: 10px;white-space:nowrap;">Basic Pay: </td>
			<td class="result-td-top" style="font-weight: 500;border-right: 1px solid black;padding-top: 5px;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->reg_pay,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">SSS Premium: </td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($total_sss_deduct->total_sss_deduct,2); ?></td>
	<!-- 		<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Year to Date</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"></td> -->
			<!-- <td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">YTD SALARY</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"></td> -->
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">YTD W/TAX:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"></td>
		</tr>
		<tr>
			<td class="title-td-first" style="font-weight: 500;font-size: 8pt;border-left: 1px solid black;padding-left: 10px;white-space:nowrap;">Sunday Pay: </td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->sun_pay,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Philhealth:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($total_philhealth_deduct->total_philhealth_deduct,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Overtime Hours</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"></td>
		</tr>
		<tr>
			<td class="title-td-first" style="font-weight: 500;font-size: 8pt;border-left: 1px solid black;padding-left: 10px;white-space:nowrap;">Salary Adjustments</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($earning_salary_adjustment->total_earnings_salary_adjustments,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Pag-ibig:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($total_pagibig_deduct->total_pagibig_deduct,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Regular Hours:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->reg,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first" style="font-weight: 500;font-size: 8pt;border-left: 1px solid black;padding-left: 10px;white-space:nowrap;">Allowance:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($earning_total_allowance->total_allowance,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Withholding Tax:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($total_withholdingtax_deduct->total_withholdingtax_deduct,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Sundays:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->sun,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first" style="font-weight: 500;font-size: 8pt;border-left: 1px solid black;padding-left: 10px;white-space:nowrap;">E.COLA:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->cola_pay,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">SSS Loan:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($total_sss_loan->total_sss_loan,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Regular OT Hours:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->ot_reg + $payslip->ot_reg_reg_hol + $payslip->ot_reg_spe_hol,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first" style="font-weight: 500;font-size: 8pt;border-left: 1px solid black;padding-left: 10px;white-space:nowrap;">Other Income:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($other_earnings->total_other_earnings,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Pag-ibig Loan:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($total_pagibig_loan->total_pagibig_loan,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Sunday OT Hours:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->ot_sun + $payslip->ot_sun_reg_hol + $payslip->ot_sun_spe_hol,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first" style="font-weight: 500;font-size: 8pt;border-left: 1px solid black;padding-left: 10px;white-space:nowrap;">Total Regular OT:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->reg_ot_pay,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Cash Advance:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($total_cash_advance->total_cash_advance,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Special Holiday Hours:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->spe_hol+$payslip->sun_spe_hol,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first" style="font-weight: 500;font-size: 8pt;border-left: 1px solid black;padding-left: 10px;white-space:nowrap;">Total Sunday OT:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->sun_ot_pay,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Minutes Late:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->minutes_late_amt,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Legal Holiday Hours:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->reg_hol+$payslip->sun_reg_hol,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first" style="font-weight: 500;font-size: 8pt;border-left: 1px solid black;padding-left: 10px;white-space:nowrap;">Total Special Holiday:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->spe_hol_pay,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Minutes Undertime:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->minutes_undertime_amt,2); ?></td>	
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">NSD Reg Hours:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->nsd_reg+$payslip->nsd_reg_reg_hol+$payslip->nsd_reg_spe_hol,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first" style="font-weight: 500;font-size: 8pt;border-left: 1px solid black;padding-left: 10px;white-space:nowrap;">Total Legal Holiday:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->reg_hol_pay,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Minutes Excess Break:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->minutes_excess_break_amt,2); ?></td>		
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">NSD Sun Hours:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->nsd_sun+$payslip->nsd_sun_reg_hol+$payslip->nsd_sun_spe_hol,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first" style="font-weight: 500;font-size: 8pt;border-left: 1px solid black;padding-left: 10px;white-space:nowrap;">NSD Reg:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->reg_nsd_pay,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Calamity Loan:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($total_calamity_loan->total_calamity_loan,2); ?></td>	
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Total Late (Minutes)</td>
  			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->minutes_late,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first" style="font-weight: 500;font-size: 8pt;border-left: 1px solid black;padding-left: 10px;white-space:nowrap;">NSD Sunday:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->sun_nsd_pay,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Others:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($total_other_deduction->total_other_deduction,2); ?></td>
  			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Total Undertime (Minutes)</td>
  			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->minutes_undertime,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first" style="font-weight: 500;font-size: 8pt;border-left: 1px solid black;padding-left: 10px;white-space:nowrap;">Days W/Pay:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->days_with_pay_amt,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Days W/O Pay:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->days_wout_pay_amt,2); ?></td>
			<!-- <td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">COOP Loan:--</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($total_coop_loan->total_coop_loan,2); ?></td> -->
  			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Total Excess Break (Minutes)</td>
  			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->minutes_excess_break,2); ?></td>
		</tr>
		<tr>
			<td class="title-td-first" style="font-weight: 500;font-size: 8pt;border-left: 1px solid black;padding-left: 10px;white-space:nowrap;">Rest Day Pay:</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->day_off_pay,2); ?></td>
			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;"><!-- COOP Contribution: -->--</td>
			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><!-- <?php echo number_format($total_coop_contribution->total_coop_contribution,2); ?> --></td>
  			<td class="title-td" style="font-weight: 500;padding-left: 10px;font-size: 8pt;white-space:nowrap;">Rest Day Hours</td>
  			<td class="result-td" style="font-weight: 500;border-right: 1px solid black;font-size: 8pt;padding-right: 10px;text-align: right;white-space:nowrap;"><?php echo number_format($payslip->day_off,2) ?></td>
		</tr>
		<tr>
			<td class="result-title-td" style="font-weight: bold;font-size: 8pt;border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 5px;padding-bottom: 5px;padding-left: 10px;">Gross Pay: </td>
			<td class="result-total-td" style="color: #1A237E;font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;font-size: 9pt;text-align: right;padding-right: 10px;">
				<?php echo number_format($payslip->gross_pay,2); ?>
			</td>
			<td class="result-title-td" style="font-weight: bold;font-size: 8pt;border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 5px;padding-bottom: 5px;padding-left: 10px;">Deductions: </td>
			<td class="result-total-td" style="color: #d50000;font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;font-size: 9pt;text-align: right;padding-right: 10px;">
				<?php echo number_format($total_sss_deduct->total_sss_deduct+$total_philhealth_deduct->total_philhealth_deduct+$total_pagibig_deduct->total_pagibig_deduct+$total_withholdingtax_deduct->total_withholdingtax_deduct+$total_sss_loan->total_sss_loan+$total_pagibig_loan->total_pagibig_loan+$total_cash_advance->total_cash_advance+$total_coop_loan->total_coop_loan+$total_coop_contribution->total_coop_contribution+$total_calamity_loan->total_calamity_loan+$total_other_deduction->total_other_deduction+$payslip->days_wout_pay_amt+$payslip->minutes_late_amt+$payslip->minutes_undertime_amt+$payslip->minutes_excess_break_amt,2); ?>
			</td>
			<td class="result-title-td" style="font-weight: bold;font-size: 8pt;border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 5px;padding-bottom: 5px;padding-left: 10px;">Net: </td>
			<td class="result-total-td" style="color: #1B5E20;font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;font-size: 9pt;text-align: right;padding-right: 10px;">
				<?php echo number_format($payslip->net_pay,2); ?>
			</td>
		</tr>
	</table>
</div>
