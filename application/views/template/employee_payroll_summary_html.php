	<style>
		.border-bottom{
			border-bottom: 1px solid black;
		}
		.border-top{
			border-top: 1px solid black!important;
		}		
		.tbl_payroll thead > tr th, td{
			text-align: right;
			padding-left: 5px;
			padding-right: 5px;
		}
		.tbl_payroll{
			font-size: 8pt!important;
		}
		.tbl_payroll thead > tr th{
			font-size: 6.5pt!important;
		}
	</style>

		<div style="font-size: 9pt; width: 100%;">
			<div class="temp_header">
			<?php include 'template_header.php';?>
				Payroll Register Summary Detailed <br />
				Period Covered : <?php if(count($period)>0){ echo $period[0]->period; }else{ echo 'N/A'; } ?>
			</div>
		</div>
		<br />
		<table class="tbl_payroll" width="100%">
			<thead>

				<tr>
					<th width="15%"></th>
					<th>Basic Pay</th>
					<th>Legal Hol (<?php echo number_format($factor->regular_holiday,2); ?>)</th>
					<th>Spcl Hol (<?php echo number_format($factor->spe_holiday,2); ?>)</th>
					<th>Reg Hol OT (<?php echo number_format($factor->regular_holiday_ot,2); ?>)</th>
					<th>Days w/ Pay</th>
					<th>Absences</th>
					<th width="7%">Grosspay</th>
					<th width="6%">SSS Prem</th>
					<th>EE (MPF)</th>
					<th>SSS Loan</th>
					<th>COOP Loan</th>
					<th>COOP Contribution</th>
					<th width="7%">Total Deduction</th>
					<th width="7%">NetPay</th>
				</tr>
				<tr>
					<th></th>
					<th>Basic Allowance</th>
					<th>Night Diff (<?php echo number_format($factor->night_shift,2); ?>)</th>
					<th>Rest Day (<?php echo number_format($factor->day_off,2); ?>)</th>
					<th>Spcl Hol OT (<?php echo number_format($factor->spe_holiday_ot,2); ?>)</th>
					<th>Other Earnings</th>
					<th>Excess Break</th>
					<th></th>
					<th>Philhealth</th>
					<th></th>
					<th>Pagibig Loan</th>
					<th>Calamity Loan</th>
					<th>Advances</th>
					<th colspan="2"></th>
				</tr>
				<tr>
					<th class="border-bottom"><center>Name</center></th>
					<th class="border-bottom"></th>
					<th class="border-bottom">Sun Pay (<?php echo number_format($factor->sunday,2); ?>)</th>
					<th class="border-bottom">Reg OT (<?php echo number_format($factor->regular_ot,2); ?>)</th>
					<th class="border-bottom">Adjustment</th>
					<th class="border-bottom">Tardiness</th>
					<th class="border-bottom">Undertime</th>
					<th class="border-bottom"></th>
					<th class="border-bottom">Pagibig</th>
					<th class="border-bottom"></th>
					<th class="border-bottom">Wtax</th>
					<th class="border-bottom">HDMF Loan</th>
					<th class="border-bottom">Other Deduct</th>
					<th class="border-bottom" colspan="2"></th>
				</tr>

			</thead>
			<tbody>
				<?php 
					$count=1;
					$grand_reg_pay=0;
					$grand_reg_hol_pay=0;
					$grand_spe_hol_pay=0;
					$grand_ot_reg_hol_amt=0;
					$grand_days_with_pay_amt=0;
					$grand_days_wout_pay_amt=0;
					$grand_gross_pay=0;
					$grand_sss_deduction=0;
					$grand_sss_ee_mpf=0;
					$grand_sssloan_deduction=0;
					$grand_cooploan_deduction=0;
					$grand_coopcontribution_deduction=0;
					$grand_total_deductions=0;
					$grand_net_pay=0;
					$grand_allowance=0;
					$grand_nsd_pay=0;
					$grand_day_off_pay=0;
					$grand_ot_spe_hol_amt=0;
					$grand_other_earnings=0;
					$grand_minutes_excess_break_amt=0;
					$grand_philhealth_deduction=0;
					$grand_pagibigloan_deduction=0;
					$grand_calamityloan_deduction=0;
					$grand_cashadvance_deduction=0;
					$grand_sun_pay=0;
					$grand_ot_reg_amt=0;
					$grand_adjustment=0;
					$grand_minutes_late_amt=0;
					$grand_minutes_undertime_amt=0;
					$grand_pagibig_deduction=0;
					$grand_wtax_deduction=0;
					$grand_hdmfloan_deduction=0;
					$grand_other_deductions=0;

					foreach($transactions as $transaction){
						if ($transaction->count > 0){
						?>
							<tr>
								<td colspan="15" style="text-align: left;font-size: 9pt!important;background: lightgray!important;">
									<center>
										<b><?php echo $transaction->transaction_type; ?></b>
									</center>
								</td>
							</tr>
					<?php 
					$sub_reg_pay=0;
					$sub_reg_hol_pay=0;
					$sub_spe_hol_pay=0;
					$sub_ot_reg_hol_amt=0;
					$sub_days_with_pay_amt=0;
					$sub_days_wout_pay_amt=0;
					$sub_gross_pay=0;
					$sub_sss_deduction=0;
					$sub_sss_ee_mpf=0;
					$sub_sssloan_deduction=0;
					$sub_cooploan_deduction=0;
					$sub_coopcontribution_deduction=0;
					$sub_total_deductions=0;
					$sub_net_pay=0;
					$sub_allowance=0;
					$sub_nsd_pay=0;
					$sub_day_off_pay=0;
					$sub_ot_spe_hol_amt=0;
					$sub_other_earnings=0;
					$sub_minutes_excess_break_amt=0;
					$sub_philhealth_deduction=0;
					$sub_pagibigloan_deduction=0;
					$sub_calamityloan_deduction=0;
					$sub_cashadvance_deduction=0;
					$sub_sun_pay=0;
					$sub_ot_reg_amt=0;
					$sub_adjustment=0;
					$sub_minutes_late_amt=0;
					$sub_minutes_undertime_amt=0;
					$sub_pagibig_deduction=0;
					$sub_wtax_deduction=0;
					$sub_hdmfloan_deduction=0;
					$sub_other_deductions=0;

					foreach($departments as $department){
						if ($department->type == $transaction->type){
					?>
					<tr>
						<td colspan="14" style="text-align: left;font-size: 9pt!important;">
							<b><?php echo $department->department; ?></b>
						</td>
					</tr>
					<?php
						$reg_pay=0;
						$reg_hol_pay=0;
						$spe_hol_pay=0;
						$ot_reg_hol_amt=0;
						$days_with_pay_amt=0;
						$days_wout_pay_amt=0;
						$gross_pay=0;
						$sss_deduction=0;
						$sss_ee_mpf=0;
						$sssloan_deduction=0;
						$cooploan_deduction=0;
						$coopcontribution_deduction=0;
						$total_deductions=0;
						$net_pay=0;
						$allowance=0;
						$nsd_pay=0;
						$day_off_pay=0;
						$ot_spe_hol_amt=0;
						$other_earnings=0;
						$minutes_excess_break_amt=0;
						$philhealth_deduction=0;
						$pagibigloan_deduction=0;
						$calamityloan_deduction=0;
						$cashadvance_deduction=0;
						$sun_pay=0;
						$ot_reg_amt=0;
						$adjustment=0;
						$minutes_late_amt=0;
						$minutes_undertime_amt=0;
						$pagibig_deduction=0;
						$wtax_deduction=0;
						$hdmfloan_deduction=0;
						$other_deductions=0;

						foreach($payroll as $row){

						if(($row->ref_department_id == $department->ref_department_id) AND ($row->bank_account_isprocess == $transaction->type)){ ?>
						<?php  // SUB PER DEPARTMENT

								$reg_pay += $row->reg_pay;
								$reg_hol_pay += $row->reg_hol_pay;
								$spe_hol_pay += $row->spe_hol_pay;
								$ot_reg_hol_amt += $row->ot_reg_reg_hol_amt+$row->ot_sun_reg_hol_amt;
								$days_with_pay_amt += $row->days_with_pay_amt;
								$days_wout_pay_amt += $row->days_wout_pay_amt;
								$gross_pay += $row->gross_pay;
								$sss_deduction += $row->sss_deduction;
								$sss_ee_mpf += $row->sss_ee_mpf;
								$sssloan_deduction += $row->sssloan_deduction;
								$cooploan_deduction += $row->cooploan_deduction;
								$coopcontribution_deduction += $row->coopcontribution_deduction;
								$total_deductions += $row->total_deductions;
								$net_pay += $row->net_pay;	
								$allowance += $row->allowance;
								$nsd_pay += $row->reg_nsd_pay+$row->sun_nsd_pay;
								$day_off_pay += $row->day_off_pay;
								$ot_spe_hol_amt += $row->ot_reg_spe_hol_amt+$row->ot_sun_spe_hol_amt;
								$other_earnings += $row->other_earnings;
								$minutes_excess_break_amt += $row->minutes_excess_break_amt;
								$philhealth_deduction += $row->philhealth_deduction;
								$pagibigloan_deduction += $row->pagibigloan_deduction;
								$calamityloan_deduction += $row->calamityloan_deduction;
								$cashadvance_deduction += $row->cashadvance_deduction;
								$sun_pay += $row->sun_pay;
								$ot_reg_amt += $row->ot_reg_amt+$row->ot_sun_amt;
								$adjustment += $row->adjustment;
								$minutes_late_amt += $row->minutes_late_amt;
								$minutes_undertime_amt += $row->minutes_undertime_amt;
								$pagibig_deduction += $row->pagibig_deduction;
								$wtax_deduction += $row->wtax_deduction;
								$hdmfloan_deduction += $row->hdmfloan_deduction;
								$other_deductions += $row->other_deductions;

						?>

						<tr>
							<td rowspan="3" style="text-align: left;" valign="top"><?php echo $count.' '.$row->fullname; ?></td>
							<td><?php echo number_format($row->reg_pay,2);?></td> 
							<td><?php echo number_format($row->reg_hol_pay,2);?></td>
							<td><?php echo number_format($row->spe_hol_pay,2);?></td>
							<td><?php echo number_format($row->ot_reg_reg_hol_amt+$row->ot_sun_reg_hol_amt,2);?></td>
							<td><?php echo number_format($row->days_with_pay_amt,2);?></td>
							<td><?php echo number_format($row->days_wout_pay_amt,2);?></td>
							<td><?php echo number_format($row->gross_pay,2);?></td>
							<td><?php echo number_format($row->sss_deduction,2);?></td>
							<td><?php echo number_format($row->sss_ee_mpf,2);?></td>
							<td><?php echo number_format($row->sssloan_deduction,2);?></td>
							<td><?php echo number_format($row->cooploan_deduction,2);?></td>
							<td><?php echo number_format($row->coopcontribution_deduction,2);?></td>
							<td><?php echo number_format($row->total_deductions,2);?></td>
							<td><?php echo number_format($row->net_pay,2); ?></td>
						</tr>
						<tr>
							<td><?php echo number_format($row->allowance,2);?></td>
							<td><?php echo number_format($row->reg_nsd_pay+$row->sun_nsd_pay,2);?></td>
							<td><?php echo number_format($row->day_off_pay,2);?></td>
							<td><?php echo number_format($row->ot_reg_spe_hol_amt+$row->ot_sun_spe_hol_amt,2);?></td>
							<td><?php echo number_format($row->other_earnings,2);?></td>
							<td><?php echo number_format($row->minutes_excess_break_amt,2);?></td>
							<td></td>
							<td><?php echo number_format($row->philhealth_deduction,2); ?></td>
							<td></td>
							<td><?php echo number_format($row->pagibigloan_deduction,2); ?></td>
							<td><?php echo number_format($row->calamityloan_deduction,2); ?></td>
							<td><?php echo number_format($row->cashadvance_deduction,2); ?></td>
							<td colspan="2"></td>
						</tr>
						<tr>
							<td></td>
							<td><?php echo number_format($row->sun_pay,2); ?></td>
							<td><?php echo number_format($row->ot_reg_amt+$row->ot_sun_amt,2);?></td>
							<td><?php echo number_format($row->adjustment,2);?></td>
							<td><?php echo number_format($row->minutes_late_amt,2); ?></td>
							<td><?php echo number_format($row->minutes_undertime_amt,2); ?></td>
							<td></td>
							<td><?php echo number_format($row->pagibig_deduction,2); ?></td>
							<td></td>
							<td><?php echo number_format($row->wtax_deduction,2); ?></td>
							<td><?php echo number_format($row->hdmfloan_deduction,2); ?></td>
							<td><?php echo number_format($row->other_deductions,2); ?></td>
							<td colspan="2"></td>
						</tr>

					<?php $count++; }

					 // end of if ??>

					<?php }

					$sub_reg_pay += $reg_pay;
					$sub_reg_hol_pay += $reg_hol_pay;
					$sub_spe_hol_pay += $spe_hol_pay;
					$sub_ot_reg_hol_amt += $ot_reg_hol_amt;
					$sub_days_with_pay_amt += $days_with_pay_amt;
					$sub_days_wout_pay_amt += $days_wout_pay_amt;
					$sub_gross_pay += $gross_pay;
					$sub_sss_deduction += $sss_deduction;
					$sub_sss_ee_mpf += $sss_ee_mpf;
					$sub_sssloan_deduction += $sssloan_deduction;
					$sub_cooploan_deduction += $cooploan_deduction;
					$sub_coopcontribution_deduction += $coopcontribution_deduction;
					$sub_total_deductions += $total_deductions;
					$sub_net_pay += $net_pay;
					$sub_allowance += $allowance;
					$sub_nsd_pay += $nsd_pay;
					$sub_day_off_pay += $day_off_pay;
					$sub_ot_spe_hol_amt += $ot_spe_hol_amt;
					$sub_other_earnings += $other_earnings;
					$sub_minutes_excess_break_amt += $minutes_excess_break_amt;
					$sub_philhealth_deduction += $philhealth_deduction;
					$sub_pagibigloan_deduction += $pagibigloan_deduction;
					$sub_calamityloan_deduction += $calamityloan_deduction;
					$sub_cashadvance_deduction += $cashadvance_deduction;
					$sub_sun_pay += $sun_pay;
					$sub_ot_reg_amt += $ot_reg_amt;
					$sub_adjustment += $adjustment;
					$sub_minutes_late_amt += $minutes_late_amt;
					$sub_minutes_undertime_amt += $minutes_undertime_amt;
					$sub_pagibig_deduction += $pagibig_deduction;
					$sub_wtax_deduction += $wtax_deduction;
					$sub_hdmfloan_deduction += $hdmfloan_deduction;
					$sub_other_deductions += $other_deductions;

					 // end of department?>

 						<tr>
							<td></td>
							<td colspan="14"><hr style="border-top: 1px solid black; "></td>
						</tr>
						<tr>
							<td style="text-align: left;font-size: 9pt!important;">DEPT TOTAL</td>
							<td><?php echo number_format($reg_pay,2);?></td> 
							<td><?php echo number_format($reg_hol_pay,2);?></td>
							<td><?php echo number_format($spe_hol_pay,2);?></td>
							<td><?php echo number_format($ot_reg_hol_amt,2);?></td>
							<td><?php echo number_format($days_with_pay_amt,2);?></td>
							<td><?php echo number_format($days_wout_pay_amt,2);?></td>
							<td><?php echo number_format($gross_pay,2);?></td>
							<td><?php echo number_format($sss_deduction,2);?></td>
							<td><?php echo number_format($sss_ee_mpf,2);?></td>
							<td><?php echo number_format($sssloan_deduction,2);?></td>
							<td><?php echo number_format($cooploan_deduction,2);?></td>
							<td><?php echo number_format($coopcontribution_deduction,2);?></td>
							<td><?php echo number_format($total_deductions,2);?></td>
							<td><?php echo number_format($net_pay,2); ?></td>
						</tr>
						<tr>
							<td></td>
							<td><?php echo number_format($allowance,2);?></td>
							<td><?php echo number_format($nsd_pay,2);?></td>
							<td><?php echo number_format($day_off_pay,2);?></td>
							<td><?php echo number_format($ot_spe_hol_amt,2);?></td>
							<td><?php echo number_format($other_earnings,2);?></td>
							<td><?php echo number_format($minutes_excess_break_amt,2);?></td>
							<td></td>
							<td><?php echo number_format($philhealth_deduction,2); ?></td>
							<td></td>
							<td><?php echo number_format($pagibigloan_deduction,2); ?></td>
							<td><?php echo number_format($calamityloan_deduction,2); ?></td>
							<td><?php echo number_format($cashadvance_deduction,2); ?></td>
							<td colspan="2"></td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td><?php echo number_format($sun_pay,2);?></td>
							<td><?php echo number_format($ot_reg_amt,2);?></td>
							<td><?php echo number_format($adjustment,2);?></td>
							<td><?php echo number_format($minutes_late_amt,2); ?></td>
							<td><?php echo number_format($minutes_undertime_amt,2); ?></td>
							<td></td>
							<td><?php echo number_format($pagibig_deduction,2); ?></td>
							<td></td>
							<td><?php echo number_format($wtax_deduction,2); ?></td>
							<td><?php echo number_format($hdmfloan_deduction,2); ?></td>
							<td><?php echo number_format($other_deductions,2); ?></td>
							<td colspan="2"></td>
						</tr>
					<?php }}?>

 						<tr>
							<td></td>
							<td colspan="14"><hr style="border-top: 2px solid black; "></td>
						</tr>
						<tr style="font-weight: bold;">
							<td style="text-align: left;font-size: 9pt!important;">TOTAL <?php echo $transaction->transaction_type; ?></td>
							<td><?php echo number_format($sub_reg_pay,2);?></td> 
							<td><?php echo number_format($sub_reg_hol_pay,2);?></td>
							<td><?php echo number_format($sub_spe_hol_pay,2);?></td>
							<td><?php echo number_format($sub_ot_reg_hol_amt,2);?></td>
							<td><?php echo number_format($sub_days_with_pay_amt,2);?></td>
							<td><?php echo number_format($sub_days_wout_pay_amt,2);?></td>
							<td><?php echo number_format($sub_gross_pay,2);?></td>
							<td><?php echo number_format($sub_sss_deduction,2);?></td>
							<td><?php echo number_format($sub_sss_ee_mpf,2);?></td>
							<td><?php echo number_format($sub_sssloan_deduction,2);?></td>
							<td><?php echo number_format($sub_cooploan_deduction,2);?></td>
							<td><?php echo number_format($sub_coopcontribution_deduction,2);?></td>
							<td><?php echo number_format($sub_total_deductions,2);?></td>
							<td><?php echo number_format($sub_net_pay,2); ?></td>
						</tr>
						<tr style="font-weight: bold;">
							<td></td>
							<td><?php echo number_format($sub_allowance,2);?></td>
							<td><?php echo number_format($sub_nsd_pay,2);?></td>
							<td><?php echo number_format($sub_day_off_pay,2);?></td>
							<td><?php echo number_format($sub_ot_spe_hol_amt,2);?></td>
							<td><?php echo number_format($sub_other_earnings,2);?></td>
							<td><?php echo number_format($sub_minutes_excess_break_amt,2);?></td>
							<td></td>
							<td><?php echo number_format($sub_philhealth_deduction,2); ?></td>
							<td></td>
							<td><?php echo number_format($sub_pagibigloan_deduction,2); ?></td>
							<td><?php echo number_format($sub_calamityloan_deduction,2); ?></td>
							<td><?php echo number_format($sub_cashadvance_deduction,2); ?></td>
							<td colspan="2"></td>
						</tr>
						<tr style="font-weight: bold;">
							<td colspan="2"></td>
							<td><?php echo number_format($sub_sun_pay,2);?></td>
							<td><?php echo number_format($sub_ot_reg_amt,2);?></td>
							<td><?php echo number_format($sub_adjustment,2);?></td>
							<td><?php echo number_format($sub_minutes_late_amt,2); ?></td>
							<td><?php echo number_format($sub_minutes_undertime_amt,2); ?></td>
							<td></td>
							<td><?php echo number_format($sub_pagibig_deduction,2); ?></td>
							<td></td>
							<td><?php echo number_format($sub_wtax_deduction,2); ?></td>
							<td><?php echo number_format($sub_hdmfloan_deduction,2); ?></td>
							<td><?php echo number_format($sub_other_deductions,2); ?></td>
							<td colspan="2"></td>
						</tr>
						<?php }
								$grand_reg_pay += $sub_reg_pay;
								$grand_reg_hol_pay += $sub_reg_hol_pay;
								$grand_spe_hol_pay += $sub_spe_hol_pay;
								$grand_ot_reg_hol_amt += $sub_ot_reg_hol_amt;
								$grand_days_with_pay_amt += $sub_days_with_pay_amt;
								$grand_days_wout_pay_amt += $sub_days_wout_pay_amt;
								$grand_gross_pay += $sub_gross_pay;
								$grand_sss_deduction += $sub_sss_deduction;
								$grand_sss_ee_mpf += $sub_sss_ee_mpf;
								$grand_sssloan_deduction += $sub_sssloan_deduction;
								$grand_cooploan_deduction += $sub_cooploan_deduction;
								$grand_coopcontribution_deduction += $sub_coopcontribution_deduction;
								$grand_total_deductions += $sub_total_deductions;
								$grand_net_pay += $sub_net_pay;
								$grand_allowance += $sub_allowance;
								$grand_nsd_pay += $sub_nsd_pay;
								$grand_day_off_pay += $sub_day_off_pay;
								$grand_ot_spe_hol_amt += $sub_ot_spe_hol_amt;
								$grand_other_earnings += $sub_other_earnings;
								$grand_minutes_excess_break_amt += $sub_minutes_excess_break_amt;
								$grand_philhealth_deduction += $sub_philhealth_deduction;
								$grand_pagibigloan_deduction += $sub_pagibigloan_deduction;
								$grand_calamityloan_deduction += $sub_calamityloan_deduction;
								$grand_cashadvance_deduction += $sub_cashadvance_deduction;
								$grand_sun_pay += $sub_sun_pay;
								$grand_ot_reg_amt += $sub_ot_reg_amt;
								$grand_adjustment += $sub_adjustment;
								$grand_minutes_late_amt += $sub_minutes_late_amt;
								$grand_minutes_undertime_amt += $sub_minutes_undertime_amt;
								$grand_pagibig_deduction += $sub_pagibig_deduction;
								$grand_wtax_deduction += $sub_wtax_deduction;
								$grand_hdmfloan_deduction += $sub_hdmfloan_deduction;
								$grand_other_deductions += $sub_other_deductions;
						} ?>
						<?php if(count($payroll)>0){ ?>
						<tr>
							<td colspan="15">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="15" style="text-align: left;font-size: 9pt!important;background: lightgray!important;"><center><b>GRAND TOTAL</b></center></td>
						</tr>
						<tr style="font-weight: bold;">
							<td></td>
							<td><?php echo number_format($grand_reg_pay,2);?></td> 
							<td><?php echo number_format($grand_reg_hol_pay,2);?></td>
							<td><?php echo number_format($grand_spe_hol_pay,2);?></td>
							<td><?php echo number_format($grand_ot_reg_hol_amt,2);?></td>
							<td><?php echo number_format($grand_days_with_pay_amt,2);?></td>
							<td><?php echo number_format($grand_days_wout_pay_amt,2);?></td>
							<td><?php echo number_format($grand_gross_pay,2);?></td>
							<td><?php echo number_format($grand_sss_deduction,2);?></td>
							<td><?php echo number_format($grand_sss_ee_mpf,2);?></td>
							<td><?php echo number_format($grand_sssloan_deduction,2);?></td>
							<td><?php echo number_format($grand_cooploan_deduction,2);?></td>
							<td><?php echo number_format($grand_coopcontribution_deduction,2);?></td>
							<td><?php echo number_format($grand_total_deductions,2);?></td>
							<td><?php echo number_format($grand_net_pay,2); ?></td>
						</tr>
						<tr style="font-weight: bold;">
							<td></td>
							<td><?php echo number_format($grand_allowance,2);?></td>
							<td><?php echo number_format($grand_nsd_pay,2);?></td>
							<td><?php echo number_format($grand_day_off_pay,2);?></td>
							<td><?php echo number_format($grand_ot_spe_hol_amt,2);?></td>
							<td><?php echo number_format($grand_other_earnings,2);?></td>
							<td><?php echo number_format($grand_minutes_excess_break_amt,2);?></td>
							<td></td>
							<td><?php echo number_format($grand_philhealth_deduction,2); ?></td>
							<td></td>
							<td><?php echo number_format($grand_pagibigloan_deduction,2); ?></td>
							<td><?php echo number_format($grand_calamityloan_deduction,2); ?></td>
							<td><?php echo number_format($grand_cashadvance_deduction,2); ?></td>
							<td colspan="2"></td>
						</tr>
						<tr style="font-weight: bold;">
							<td colspan="2"></td>
							<td><?php echo number_format($grand_sun_pay,2);?></td>
							<td><?php echo number_format($grand_ot_reg_amt,2);?></td>
							<td><?php echo number_format($grand_adjustment,2);?></td>
							<td><?php echo number_format($grand_minutes_late_amt,2); ?></td>
							<td><?php echo number_format($grand_minutes_undertime_amt,2); ?></td>
							<td></td>
							<td><?php echo number_format($grand_pagibig_deduction,2); ?></td>
							<td></td>
							<td><?php echo number_format($grand_wtax_deduction,2); ?></td>
							<td><?php echo number_format($grand_hdmfloan_deduction,2); ?></td>
							<td><?php echo number_format($grand_other_deductions,2); ?></td>
							<td colspan="2"></td>
						</tr>
					<?php }else{?>
						<tr>
							<td colspan="14"><center>No Data Available</center></td>
						</tr>
					<?php } ?>
			</tbody>
		</table>
		<?php if(count($payroll)>0){ ?>
		<br /><br />
		<table class="tbl_payroll" width="100%">
				<tr>
					<th width="25%"></th>
					<th colspan="4"></th>
					<th colspan="2"></th>
					<th width="7%"></th>
					<th colspan="4"></th>
					<th width="7%"></th>
					<th width="7%"></th>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td colspan="4" style="text-align: left;">Prepared by</td>
					<td colspan="4" style="text-align: left;">Checked by</td>
					<td colspan="4" style="text-align: left;">Approved by</td>
				</tr>
				<tr>
					<td colspan="14">&nbsp;</td>
				</tr>				
				<tr>
					<td colspan="2"></td>
					<td colspan="4" style="text-align: left;"><?php echo $this->session->user_fullname; ?></td>
					<td colspan="4" style="text-align: left;"><?php echo $company->checked_by; ?></td>
					<td colspan="4" style="text-align: left;"><?php echo $company->approved_by; ?></td>
				</tr>
		</table>
		<?php } ?>
	</div>