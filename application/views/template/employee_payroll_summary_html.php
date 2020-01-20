	<style>
		td, th {
			padding: 7px;
		}
		.tablepaytotals{
			border-bottom: .5px solid gray !important;
			padding-bottom: 5px !important;
			padding-top: 5px !important;
		}
		.tablepay{
			font-size: 10pt !important;
		}
	</style>
		<div style="font-size: 11pt; width: 100%;">
			<div class="temp_header">
			<?php include 'template_header.php';?>

			<strong>
				Payroll Summary <br />
				Pay Period : <?php  echo $get_period;?>
				</br >
				Department :
				<?php echo $get_department; ?>
			</strong>
			</div>
		</div>
		<table class="tablepayroll">
			<thead>
				<tr>
					<th style="text-align:center;">#</th>
					<th style="text-align:center;">Employee Name</th>

					<th style="">Reg (Hrs) </th>
					<th style="text-align:right;">Basic Pay</th>

					<th>Reg Hol (Hrs)</th>
					<th>Reg Hol Pay</th>

					<th>Spe Hol (Hrs)</th>
					<th>Spe Hol Pay</th>

					<th>OT (Hrs)</th>
					<th>OT Pay</th>

					<th>NSD (Hrs)</th>
					<th style="text-align:right;">NSD Pay</th>

					<th>Rest Day (Hrs)</th>
					<th style="text-align:right;">Rest Day Pay</th>

					<th>W/ Pay (Hrs)</th>
					<th style="text-align:right;">Days W/ Pay</th>

					<th style="text-align:right;">Meal/Allowance</th>
					<th style="text-align:right;">Adjustment</th>
					<th style="text-align:right;">Other Earnings</th>
					<th style="text-align:right;">Gross Pay</th>

					<th>Absences (Hrs)</th>
					<th>Absences</th>

					<th>Late (Minutes)</th>
					<th style="text-align:right;">Late Amt</th>

					<th>Undertime (Minutes)</th>
					<th style="text-align:right;">Undertime Amt</th>

					<th>Excess Break (Minutes)</th>
					<th style="text-align:right;">Excess Break Amt</th>					

					<th style="text-align:right;">SSS Deduct</th>
					<th style="text-align:right;">Phealth Deduct</th>
					<th style="text-align:right;">Pag-Ibig</th>
					<th style="text-align:right;">W/tax</th>
					<th style="text-align:right;">SSS Loan</th>
					<th style="text-align:right;">Pag Ibig Loan</th>
	<!-- 				<th style="text-align:right;">Coop Contri.</th>
					<th style="text-align:right;">Coop Loan</th> -->
					<th style="text-align:right;">Cash Advance(Reg)</th>
					<th style="text-align:right;">Calamity Loan</th>
					<th style="text-align:right;">Other Deduct</th>
					<th style="text-align:right;">Total Deductions</th>
					<th style="text-align:right;">Net Pay</th>
				</tr>
				</tr>
			</thead>
			<tbody>
				<?php
					$basic_pay=0;
					$reg_holiday=0;
					$spe_holiday=0;
					$overtime=0;
					$nsd_pay=0;
					$day_off_pay=0;
					$s_mealallowance=0;
					$s_adjustment=0;
					$s_other_earnings=0;
					$days_wpay=0;
					$absences=0;
					$late=0;
					$undertime=0;
					$excess_break=0;
					$sss_deduction=0;
					$philhealth_deduction=0;
					$pagibig_deduction=0;
					$wtax_deduction=0;
					$sssloan_deduction=0;
					$pagibigloan_deduction=0;
					$cashadvance_deduction=0;
					$calamityloan_deduction=0;
					$s_otherdeduct=0;
					$s_deductions=0;
					$s_gross_pay=0;
					$salaries_wages=0;

					$count=1;
					if (count($payroll_register_summary) != 0){
					foreach($payroll_register_summary as $row){

					$ot_hrs = $row->ot_reg+$row->ot_reg_reg_hol+$row->ot_reg_spe_hol+$row->ot_sun+$row->ot_sun_reg_hol+$row->ot_sun_spe_hol;
					$nsd_hrs = $row->nsd_reg+$row->nsd_reg_reg_hol+$row->nsd_reg_spe_hol+$row->nsd_sun+$row->nsd_sun_reg_hol+$row->nsd_sun_spe_hol;

					?>
				<tr>
					<td align="center"><?php echo $count; ?>.</td>
					<td align="center"><?php echo $row->fullname; ?></td>
					<td align="center"><?php echo number_format($row->reg,2); ?></td>
					<td align="center"><?php echo number_format($row->reg_pay,2); ?></td>

					<td align="center"><?php echo number_format($row->reg_hol,2); ?></td>
					<td align="center"><?php echo number_format($row->reg_hol_pay,2); ?></td>

					<td align="center"><?php echo number_format($row->spe_hol,2); ?></td>
					<td align="center"><?php echo number_format($row->spe_hol_pay,2); ?></td>

					<td align="center"><?php echo number_format($ot_hrs,2); ?></td>
					<td align="center"><?php echo number_format($row->reg_ot_pay+$row->sun_ot_pay,2); ?></td>

					<td align="center"><?php echo number_format($nsd_hrs,2); ?></td>
					<td align="center"><?php echo number_format($row->reg_nsd_pay+$row->sun_nsd_pay,2); ?></td>

					<td align="center"><?php echo number_format($row->day_off,2); ?></td>
					<td align="center"><?php echo number_format($row->day_off_pay,2); ?></td>

					<td align="center"><?php echo number_format($row->days_with_pay,2); ?></td>
					<td align="center"><?php echo number_format($row->days_with_pay_amt,2); ?></td>

					<td align="center"><?php echo $total_mealallowance=$row->allowance; ?></td>
					<td align="center"><?php echo $total_adjustment=$row->adjustment; ?></td>
					<td align="center"><?php echo $total_other_earnings=$row->other_earnings; ?></td>
					<td align="center"><?php echo number_format($row->gross_pay,2); ?></td>
					<td align="center"><?php echo number_format($row->days_wout_pay,2); ?></td>
					<td align="center"><?php echo number_format($row->days_wout_pay_amt,2); ?></td>
					<td align="center"><?php echo number_format($row->minutes_late,2); ?></td>
					<td align="center"><?php echo number_format($row->minutes_late_amt,2); ?></td>
					<td align="center"><?php echo number_format($row->minutes_undertime,2); ?></td>
					<td align="center"><?php echo number_format($row->minutes_undertime_amt,2); ?></td>
					<td align="center"><?php echo number_format($row->minutes_excess_break,2); ?></td>
					<td align="center"><?php echo number_format($row->minutes_excess_break_amt,2); ?></td>
					<td align="center"><?php echo number_format($row->sss_deduction,2); ?></td>
					<td align="center"><?php echo number_format($row->philhealth_deduction,2); ?></td>
					<td align="center"><?php echo number_format($row->pagibig_deduction,2); ?></td>
					<td align="center"><?php echo number_format($row->wtax_deduction,2); ?></td>
					<td align="center"><?php echo number_format($row->sssloan_deduction,2); ?></td>
					<td align="center"><?php echo number_format($row->pagibigloan_deduction,2); ?></td>
					<td align="center"><?php echo number_format($row->cashadvance_deduction,2); ?></td>
					<td align="center"><?php echo number_format($row->calamityloan_deduction,2); ?></td>
	        		<td align="center"><?php echo number_format($row->other_deductions,2); ?></td>
					<td align="center"><?php echo number_format($row->total_deductions,2);?></td>
					<td align="center"><?php echo number_format($row->net_pay,2);?></td>
				</tr>
				<?php
					$basic_pay += $row->reg_pay;
					$reg_holiday += $row->reg_hol_pay;
					$spe_holiday += $row->spe_hol_pay;
					$overtime += $row->reg_ot_pay+$row->sun_ot_pay;
					$nsd_pay += $row->reg_nsd_pay+$row->sun_nsd_pay;
					$day_off_pay += $row->day_off_pay;
					$s_mealallowance += $row->allowance;
					$s_adjustment += $row->adjustment;
					$s_other_earnings += $row->other_earnings;
					$days_wpay += $row->days_with_pay_amt;
					$absences += $row->days_wout_pay_amt;
					$late += $row->minutes_late_amt;
					$undertime += $row->minutes_undertime_amt;
					$excess_break += $row->minutes_excess_break_amt;
					$sss_deduction += $row->sss_deduction;
					$philhealth_deduction += $row->philhealth_deduction;
					$pagibig_deduction += $row->pagibig_deduction;
					$wtax_deduction += $row->wtax_deduction;
					$sssloan_deduction += $row->sssloan_deduction;
					$pagibigloan_deduction += $row->pagibigloan_deduction;
					$cashadvance_deduction += $row->cashadvance_deduction;
					$calamityloan_deduction += $row->calamityloan_deduction;
					$s_otherdeduct += $row->other_deductions;
					$s_deductions += $row->total_deductions;
					$s_gross_pay += $row->gross_pay;
					$salaries_wages += $row->net_pay;
					
					$count++;

				 }} ?>

			</tbody>
		</table>
			<div style="font-size:12pt;margin-top: 20px;" class="summary">
				<table class="tablepay">
					<tr>
						<td class="tablepaytotals" style="font-weight:bold;">Basic Pay:</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($basic_pay,2);?></td>
						<td style="word-wrap: break-word; max-width: 20px; width: 20px;"></td>
						<td class="tablepaytotals" style="font-weight:bold;">Day Off Pay :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($day_off_pay,2); ?></td>
						<td style="word-wrap: break-word; max-width: 20px; width: 20px;"></td>
						<td class="tablepaytotals" style="font-weight:bold;">Absences :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($absences,2); ?></td>
						<td style="word-wrap: break-word; max-width: 20px; width: 20px;"></td>
						<td class="tablepaytotals" style="font-weight:bold;">Wtax :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($wtax_deduction,2); ?></td>
						<td style="word-wrap: break-word; max-width: 20px; width: 20px;"></td>
						<td class="tablepaytotals" style="font-weight:bold;">Excess Break :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($excess_break,2); ?></td>
					</tr>
					<tr>
						<td class="tablepaytotals" style="font-weight:bold;">Regular Holiday:</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($reg_holiday,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">Meal/Allowance :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($s_mealallowance,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">Late :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($late,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">SSS Loan :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($sssloan_deduction,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">Other Deduct :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($s_otherdeduct,2); ?></td>
					</tr>
					<tr>
						<td class="tablepaytotals" style="font-weight:bold;">Special Holiday:</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($spe_holiday,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">Adjustment :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($s_adjustment,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">SSS :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($sss_deduction,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">Pagibig Loan:</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($pagibigloan_deduction,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">Total Gross Pay :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($s_gross_pay,2); ?></td>
					</tr>
					<tr>
						<td class="tablepaytotals" style="font-weight:bold;">Overtime :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($overtime,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">Other Earnings :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($s_other_earnings,2); ?></td>
						<td style="word-wrap: break-word; max-width: 20px; width: 20px;"></td>
						<td class="tablepaytotals" style="font-weight:bold;">Philhealth :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($philhealth_deduction,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">Cash Advance :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($cashadvance_deduction,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">Total Deduction :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($s_deductions,2); ?></td>
					</tr>
					<tr>

						<td class="tablepaytotals" style="font-weight:bold;">NSD Pay :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($nsd_pay,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">Days W/ Pay:</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($days_wpay,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">Pagibig :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($pagibig_deduction,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">Undertime :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($undertime,2); ?></td>
						<td></td>
						<td class="tablepaytotals" style="font-weight:bold;">Salaries &amp; Wages :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($salaries_wages,2); ?></td>
<!-- 						<td class="tablepaytotals" style="font-weight:bold;">Calamity Loan :</td>
						<td class="tablepaytotals" style="text-align: right;"><?php echo number_format($calamityloan_deduction,2); ?></td>	 -->	
					</tr>
				</table>
			</div>
	</div>
