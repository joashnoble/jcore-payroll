<style>
	td, th {
		padding: 7px;
	}
	.tablepaytotals{
	  border-bottom: .5px solid gray !important;
		padding-bottom: 5px !important;
		padding-top: 5px !important;
	}

</style>
	<div style="font-size: 11pt; width: 100%;">
		<div class="temp_header">
			<?php include 'template_header.php';?>
				<strong>
					Payroll Register <br /></strong>
					Pay Period : <?php echo $pay_period->pay_period; ?> <br />
					Branch : <?php echo $get_branch; ?><br />
					Department : <?php echo $get_department; ?>
					<hr>
			</div>
		</div>
	</div>
	<table class="tablepayroll" width="100%" style="margin: 10px!important;">
		<thead>
			<tr>
				<th style="text-align:right;">#</th>
				<th width="30%">Employee Name</th>
				<th style="text-align:center;">Account #</th>
				<th>Net Pay</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$grandtotal = 0;
				$count=1;
				if(count($payroll_register)!=0 || count($payroll_register)!=null){
				foreach($payroll_register as $row){

					// $netpay=$row->gross_pay-($row->days_wout_pay_amt+$row->minutes_late_amt+$row->minutes_undertime_amt+$row->minutes_excess_break_amt+$row->sss_deduction+$row->philhealth_deduction+$row->pagibig_deduction+$row->wtax_deduction+$row->sssloan_deduction+$row->pagibigloan_deduction+$row->coopcontribution_deduction+$row->cooploan_deduction+$row->cashadvance_deduction+$row->calamityloan_deduction+$row->other_deductions);

					$netpay = $row->net_pay;
					$grandtotal += $netpay;

				?>
			<tr>
				<td align="right"><?php echo $count;?></td>
				<td><?php echo $row->fullname;?></td>
				<td style="text-align:center;"><?php echo $row->bank_account;?></td>
				<td><?php echo number_format($netpay,2);?></td>
			</tr>
			<?php $count++;}
				echo '<tr>';
				echo '<td colspan="3" align="right"><b>Grand Total:</b></td>';
				echo '<td>'.number_format($grandtotal,2).'</td>';
				echo '</tr>';

			}else{?>

				<td colspan="4"><center>No Result</center></td>

			<?php }?>


		</tbody>

	</table>
</div>
