<style>
	td, th {
		padding: 8px;
	}
</style>
<div style="height:450px; margin: 20px;">
	<div style="font-size: 11pt;">
		<?php include 'template_header.php';?>
		<hr>
		<strong>
			Monthly Loan Report<br />
			<?php echo $loan_type; ?><br />
			<?php echo $month.' '.$year; ?>
		</strong>
	</div>
	<br />
	<table class="tablepayroll" width="100%" style="font-size: 10pt!important;">
		<thead>
			<tr>
				<th style="border-bottom: 1px solid black!important;">#</th>
				<th style="border-bottom: 1px solid black!important;">Ecode</th>
				<th style="border-bottom: 1px solid black!important;">Employee</th>
				<th style="border-bottom: 1px solid black!important;" style="text-align: right;">Deduction</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i = 1;
				$total_loan_deduction = 0;
				if (count($loans) > 0){
				foreach ($loans as $row) {
					$total_loan_deduction += $row->loan_deduction;
					?>
				<tr>
					<td style="border-bottom: 1px solid gray!important;"><?php echo $i++.'.'; ?></td>
					<td style="border-bottom: 1px solid gray!important;"><?php echo $row->ecode; ?></td>
					<td style="border-bottom: 1px solid gray!important;"><?php echo $row->fullname; ?></td>
					<td style="border-bottom: 1px solid gray!important;" align="right"><?php echo number_format($row->loan_deduction,2); ?></td>
				</tr>
			<?php }
					echo '<tr>';
					echo '<td colspan="3" align="right"><b>Total</b></td>';
					echo '<td align="right"><b>'.number_format($total_loan_deduction,2).'</b></td>';
					echo '</tr>';

					}else{ ?>
					<td colspan="4">
						<center>
							<span style="font-size: 12pt;">No Result</span>
						</center>
					</td>
			<?php }?>
		</tbody>
		</table>
	</div>
</div>
