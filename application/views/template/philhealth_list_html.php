<div style="margin: 20px;">
	<div style="font-size: 11pt;">
	<?php include 'template_header.php';?>

		<strong>
			<?php 
				if ($month == "All"){
					echo "Philhealth Report for All Months";
				}else{
					echo "Philhealth Report for the Month of ".$month;
				}
			?>
			<br />
			Year: <?php echo $year; ?><br />
			Branch : <?php echo $branch; ?>
		</strong>
		<hr>
		</br >
	</div>
<table class="table" style="width:100%;">
		<thead class="thead-inverse">
			<tr>
				<th width="5%">#</th>
				<?php if ($month == "All"){?>
				<th width="10%">Month</th>
				<?php }?>
				<th width="10%">Ecode</th>
				<th width="20%">Name</th>
				<th width="15%">PhilHealth No.</th>
				<th width="15%" style="text-align: right;">Employee</th>
				<th width="15%" style="text-align: right;">Employer</th>
				<th width="15%" style="text-align: right;">Total</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total_philhealth=0;
			$total_employee=0;
			$total_employer=0;
			$count=1;
			if(count($phil_health_report)!=0 || count($phil_health_report)!=null){
				foreach($phil_health_report as $row){
					$total_philhealth+=$row->employee+$row->employer;
					$total_employee+=$row->employee;
					$total_employer+=$row->employer;
					if ($row->employee != 0){
				 ?>
					<tr>
					<td><?php echo $count; ?></td>
					<?php if ($month == "All"){?>
					<td><?php echo $row->periodmonth; ?></td>
					<?php }?>
					<td><?php echo $row->ecode; ?></td>
					<td><?php echo $row->full_name; ?></td>
					<td><?php echo $row->phil_health; ?></td>
					<td align="right"><?php echo number_format($row->employee,2); ?></td>
					<td align="right"><?php echo number_format($row->employer,2); ?></td>
					<td align="right"><?php echo number_format($row->employee+$row->employer,2); ?></td>
				</tr>
	 		<?php
	 			$count++;
			}}}
	 			else{ ?>

	 				<?php if ($month =="All"){
	 				echo '<tr><td style="font-size:14pt;" colspan="8"><center>No Result</center></td></tr>';
	 				}else{
	 				echo '<tr><td style="font-size:14pt;" colspan="7"><center>No Result</center></td></tr>';
	 				}} ?>
	 			<tr>
	 				<?php if ($month =="All"){?>
						<td style="border-bottom:2px solid #95a5a6; border-bottom: 1px solid #95a5a6 !important;" colspan="8" ></td>
					<?php }else{?>
						<td style="border-bottom:2px solid #95a5a6; border-bottom: 1px solid #95a5a6 !important;" colspan="7" ></td>
					<?php }?>	
	 			</tr>
	 			<tr>
	 				<?php if ($month =="All"){?>
	 					<td style="text-align:right;font-weight:bold;" colspan="5">Total:</td>
	 				<?php }else{?>
	 					<td style="text-align:right;font-weight:bold;" colspan="4">Total:</td>
	 				<?php }?>
	 				<td align="right" style="font-weight:bold;color:#27ae60;"><?php echo number_format($total_employee,2);?></td>
	 				<td align="right" style="font-weight:bold;color:#27ae60;"><?php echo number_format($total_employer,2);?></td>
	 				<td align="right" style="font-weight:bold;color:#27ae60;"><?php echo number_format($total_philhealth,2);?></td>
	 			</tr>
		</tbody>


</table>
</div>
