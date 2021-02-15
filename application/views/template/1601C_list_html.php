<style>
	td, th {
		padding: 7px;
	}
	.tablepaytotals{
		border-bottom: .5px solid gray !important;
		padding-bottom: 5px !important;
		padding-top: 5px !important;
		text-align: center;
	}
	.tablepay{
		font-size: 14pt !important;
		text-align: center;
	}
</style>
<div style="height:450px; margin: 20px;">
	<div style="font-size: 11pt;">
		<?php include 'template_header.php';?>
		<hr>
		Schedule of taxes withheld (1601C)<br />
		<?php echo $month.' '.$year; ?>
	</div>
	<table class="tablepayroll" width="100%" style="font-size: 9pt!important;">
		<thead>
			<tr>
				<th>#</th>
				<th>ID No.</th>
				<th>Sur Name</th>
				<th>Given Name</th>
				<th>Middle Name</th>
				<th>TIN No.</th>
				<th style="text-align: right;">+Holiday</th>
				<th style="text-align: right;">Actual Basic Pay</th>
				<th style="text-align: right;">/day</th>
				<th style="text-align: right;">Gross Tax</th>
				<th style="text-align: right;">Gross Pay</th>
				<th style="text-align: right;">HDMFeR</th>
				<th style="text-align: right;">HDMFee</th>
				<th style="text-align: right;">SSSeR</th>
				<th style="text-align: right;">SSSeC</th>
				<th style="text-align: right;">SSSeE</th>
				<th style="text-align: right;">PHICeR</th>
				<th style="text-align: right;">PHICeE</th>
				<th style="text-align: right;">Compensation</th>
				<th style="text-align: right;">Salary</th>
				<th style="text-align: right;">Withheld</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i = 1;
				if (count($report1601C) > 0){
				foreach ($report1601C as $row) {?>
				<tr>
					<td><?php echo $i++.'.'; ?></td>
					<td><?php echo $row->id_number; ?></td>
					<td><?php echo $row->last_name; ?></td>
					<td><?php echo $row->first_name; ?></td>
					<td><?php echo $row->middle_name; ?></td>
					<td><?php echo $row->tin; ?></td>
					<td align="right"><?php echo number_format($row->holiday_pay,2); ?></td>
					<td align="right"><?php echo number_format($row->actual_basic_pay,2); ?></td>
					<td align="right"><?php echo number_format($row->per_day_pay,2); ?></td>
					<td align="right"><?php echo number_format($row->reg_pay,2); ?></td>
					<td align="right"><?php echo number_format($row->gross_pay,2); ?></td>
					<td align="right"><?php echo number_format($row->hdmf,2); ?></td>
					<td align="right"><?php echo number_format($row->hdmf,2); ?></td>
					<td align="right"><?php echo number_format($row->sss_employer,2); ?></td>
					<td align="right"><?php echo number_format($row->sss_employer_contribution,2); ?></td>
					<td align="right"><?php echo number_format($row->sss_employee,2); ?></td>
					<td align="right"><?php echo number_format($row->phic,2); ?></td>
					<td align="right"><?php echo number_format($row->phic,2); ?></td>
					<td align="right"><?php echo number_format(($row->sss_employee+$row->phic+$row->hdmf),2); ?></td>
					<td align="right"><?php echo number_format(($row->gross_pay-($row->sss_employee+$row->phic+$row->hdmf)),2); ?></td>
					<td align="right"><?php echo number_format($row->wtax,2);?></td>
				</tr>
			<?php }}else{ ?>
					<td colspan="20">
						<center>
							<span style="font-size: 12pt;">No Result</span>
						</center>
					</td>
			<?php }?>
		</tbody>
		</table>
	</div>
</div>
