<div style="margin: 20px;">
	<div style="font-size: 11pt;">
		<?php include 'template_header.php';?>

		<strong>

			<?php 

				if ($month == "All"){
					echo "SSS Report for All Months";
				}else{
					echo "SSS Report for the Month of ".$month;
				}

			?>
			<br />
			Year : <?php echo $year; ?> <br />
			Branch : <?php echo $branch; ?> <br />
		</strong>
		<hr>
		<br />
	</div>
<table class="table" style="width:100%;">
		<thead class="thead-inverse">
			<tr>
				<th>#</th>
				<?php if ($month == "All"){?>
				<th style="text-align:left;">Month</th>
				<?php } ?>
				<th style="text-align:left;">Ecode</th>
				<th style="text-align:left;">Name</th>
				<th style="text-align:left;">SSS No.</th>
				<th style="text-align:right;">Employee</th>
				<th style="text-align:right;">Employer</th>
				<th style="text-align:right;">EC</th>
				<th style="text-align:right;">Total</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total_actual_sss_employee=0;
			$total_actual_sss_employer=0;
			$total_actual_sss_ec=0;
			$grand_total = 0;
			$row_total = 0;
			$count=1;
			if(count($sss_report)!=0 || count($sss_report)!=null){
				foreach($sss_report as $row){
					if ($row->actual_sss_employee != 0){

					$row_total = $row->actual_sss_employee + $row->actual_sss_employer + $row->actual_sss_ec;
				 ?>
					<tr>
					<td><?php echo $count; ?></td>
					<?php if ($month == "All"){?>
					<td><?php echo $row->periodmonth; ?></td>
					<?php } ?>
					<td><?php echo $row->ecode; ?></td>
					<td><?php echo $row->full_name; ?></td>
					<td><?php echo $row->sss; ?></td>
					<td style="text-align: right;"><?php echo number_format($row->actual_sss_employee,2); ?></td>
					<td style="text-align: right;"><?php echo number_format($row->actual_sss_employer,2); ?></td>
					<td style="text-align: right;"><?php echo number_format($row->actual_sss_ec,2); ?></td>
					<td style="text-align: right;"><?php echo number_format($row->actual_sss_total,2); ?></td>
				</tr>
	 		<?php
					$total_actual_sss_employee+=$row->actual_sss_employee;
	 				$total_actual_sss_employer+=$row->actual_sss_employer;
	 				$total_actual_sss_ec+=$row->actual_sss_ec;
					$grand_total+=$row_total;
	 				$count++;
	 			}}}
	 			else{ ?>
	 				<?php if ($month == "All"){?>
	 					<tr><td style="text-align:center;font-size:14pt;" colspan="9"><center>No Result</center></td></tr>
	 				<?php }else{?>
	 					<tr><td style="text-align:center;font-size:14pt;" colspan="8"><center>No Result</center></td></tr>
	 				<?php }?>
	 			<?php
	 			} ?>
	 			<tr>
	 				<?php if ($month == "All"){?>
	 					<td style="border-bottom: 1px solid #95a5a6 !important;" colspan="9"></td>
	 				<?php }else{?>
	 					<td style="border-bottom: 1px solid #95a5a6 !important;" colspan="8"></td>
	 				<?php }?>
	 			</tr>
	 			<tr>
	 				<?php if ($month == "All"){?>
	 					<td colspan="4"></td>
	 				<?php }else{?>
	 					<td colspan="3"></td>
	 				<?php }?>
	 				<td style="text-align:right;font-weight:bold;">Total:</td>
	 				<td style="font-weight:bold;color:#27ae60; text-align: right;"><?php echo number_format($total_actual_sss_employee,2);?></td>
	 				<td style="font-weight:bold;color:#27ae60; text-align: right;"><?php echo number_format($total_actual_sss_employer,2);?></td>
	 				<td style="font-weight:bold;color:#27ae60; text-align: right;"><?php echo number_format($total_actual_sss_ec,2);?></td>
					<td style="font-weight:bold;color:#27ae60; text-align: right;"><?php echo number_format($grand_total,2);?></td>
	 			</tr>
		</tbody>


</table>
</div>
