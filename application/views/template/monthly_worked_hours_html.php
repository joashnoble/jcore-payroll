<style>
	td, th {
		padding: 7px;
	}
	th{
		border: 1px solid gray!important;
	}
/*	.tablepaytotals{
		border-bottom: .5px solid gray !important;
		padding-bottom: 5px !important;
		padding-top: 5px !important;
		text-align: center;
	}*/
	.tablepay{
		font-size: 14pt !important;
		text-align: center;
	}
	tbody td{
		border-bottom: 1px solid gray!important;
	}
	.leftbrdr{
		border-left: 1px solid gray!important;
	}
	.rightbrdr{
		border-right: 1px solid gray!important;
	}
</style>
<div style="height:450px; margin: 20px;">
	<div style="font-size: 11pt;">
		<?php include 'template_header.php';?>
		<hr>
		Monthly Worked Hours<br />
		<?php echo $month.' '.$year; ?>
	</div>
	<table class="tablepayroll" width="100%" style="font-size: 10pt!important;">
		<thead>
			<tr>
				<th colspan="13">
					<center>
						MONTHLY LABOR COST
					</center>
				</th>
			</tr>
			<tr>
				<th></th>
				<th></th>
				<th><center>TOTAL</center></th>
				<th></th>
				<th><center>TOTAL</center></th>
				<th></th>
				<th><center>TOTAL</center></th>
				<th></th>
				<th colspan="4"><center>HOLIDAY</center></th>
				<th>TOTAL</th>
			</tr>
			<tr>
				<th>#</th>
				<th>EMPLOYEE</th>
				<th>REGULAR HOURS</th>
				<th align="right">AMOUNT</th>
				<th>OVERTIME</th>
				<th align="right">AMOUNT</th>
				<th>ND</th>
				<th align="right">AMOUNT</th>
				<th>REGULAR HOLIDAY</th>
				<th align="right">AMOUNT</th>
				<th>SPECIAL HOLIDAY</th>
				<th align="right">AMOUNT</th>
				<th align="right">COST</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i = 1;
				$total = 0;
				$total_cost = 0;
				if (count($mwh) > 0){
				foreach ($mwh as $row) {
					$total_cost = $row->total_reg_amt + $row->total_ot_amt + $row->total_nd_amt + $row->total_reg_hol_amt + $row->total_spe_hol_amt;
					$total += $row->total_reg_amt + $row->total_ot_amt + $row->total_nd_amt + $row->total_reg_hol_amt + $row->total_spe_hol_amt;
					?>
				<tr>
					<td class="leftbrdr"><?php echo $i++.'.'; ?></td>
					<td><?php echo $row->employee; ?></td>
					<td align="right"><?php echo number_format($row->total_reg,2); ?></td>
					<td align="right"><?php echo number_format($row->total_reg_amt,2); ?></td>
					<td align="right"><?php echo number_format($row->total_ot,2); ?></td>
					<td align="right"><?php echo number_format($row->total_ot_amt,2); ?></td>
					<td align="right"><?php echo number_format($row->total_nd,2); ?></td>
					<td align="right"><?php echo number_format($row->total_nd_amt,2); ?></td>
					<td align="right"><?php echo number_format($row->total_reg_hol,2); ?></td>
					<td align="right"><?php echo number_format($row->total_reg_hol_amt,2); ?></td>
					<td align="right"><?php echo number_format($row->total_spe_hol,2); ?></td>
					<td align="right"><?php echo number_format($row->total_spe_hol_amt,2); ?></td>
					<td align="right" class="rightbrdr"><b><?php echo number_format($total_cost,2);?></b></td>
				</tr>
			<?php }
					echo '<tr>';
					echo '<td colspan="12" align="right" style="border-top: 1px solid gray;">Total</td>';
					echo '<td align="right" style="border-top: 1px solid gray;"><b>'.number_format($total,2).'</b></td>';
					echo '</tr>';

					}else{ ?>
					<td colspan="14" class="leftbrdr rightbrdr">
						<center>
							<span style="font-size: 12pt;">No Result</span>
						</center>
					</td>
			<?php }?>
		</tbody>
		</table>
	</div>
</div>
