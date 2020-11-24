<style>
	.tablepayroll td {
		padding: 10px;
	}
	.tablepayroll th{
		padding: 5px;
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
<div style="height:700px; margin: 20px;">
	<div style="font-size: 11pt;">
		<?php include 'template_header.php';?>

		<table width="100%" style="border-collapse: collapse;">
			<tr>
				<td><b>Alpha List of Employee</b></td>
				<td align="right"><b>Year:</b> <?php echo $year; ?></td>
			</tr>
			<tr>
				<td><b><?php echo $company->company_name ?></b></td>
				<td align="right"><b>Status :</b> <?php echo $status; ?></td>
			</tr>
			<tr>
				<td><b>Tin #:</b> <?php echo $company->tin_no ?></td>
				<td></td>
			</tr>
		</table>

	</div>
	<table class="tablepayroll" width="100%" style="font-size: 9pt!important;" cellpadding="5" cellspacing="5">
		<thead>
			<tr>
				<th>#</th>
				<th>Surname</th>
				<th>Firstname</th>
				<th>Middlename</th>
				<th>Tin #</th>
				<th style="text-align: right;">WTAX Whold <br>(Jan - Nov)</th>
				<th style="text-align: right;">13th Month Pay</th>
				<!-- <th style="text-align: right;">Exemption</th> -->
				<th style="text-align: right;">Gross Pay</th>
				<th style="text-align: right;" colspan="3">Deduction (Tax Shield)</th>
				<th style="text-align: right;">Taxable Income</th>
				<th style="text-align: right;">Tax Due December</th>
			</tr>
			<tr>
				<th style="text-align: right;" colspan="8"></th>
				<th style="text-align: right;">SSS</th>
				<th style="text-align: right;">Pilhealth</th>
				<th style="text-align: right;">Pagibig</th>
				<th style="text-align: right;" colspan="2"></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i = 1;
				foreach ($alpha_list as $row) {?>
				<tr>
					<td><?php echo $i++.'.'; ?></td>
					<td><?php echo $row->last_name; ?></td>
					<td><?php echo $row->first_name; ?></td>
					<td><?php echo $row->middle_name; ?></td>
					<td><?php if ($row->tin != ""){echo $row->tin;}else{echo 'N/A';} ?></td>
					<td align="right"><?php echo number_format($row->wtax,2); ?></td>
					<td align="right"><?php echo number_format($row->acc_13thmonth_pay,2); ?></td>
					<!-- <td align="right"><?php echo $row->tax_name; ?></td> -->
					<td align="right"><?php echo number_format($row->yearly_gross,2); ?></td>
					<td align="right"><?php echo number_format($row->yearly_sss,2); ?></td>
					<td align="right"><?php echo number_format($row->yearly_phil,2); ?></td>
					<td align="right"><?php echo number_format($row->yearly_pagibig,2); ?></td>
					<td align="right"><?php echo number_format($row->taxable_income,2); ?></td>
					<td align="right"></td>
				</tr>
			<?php } ?>
		</tbody>
		</table>
	</div>
</div>
