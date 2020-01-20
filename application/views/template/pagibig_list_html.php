<div style="margin: 20px;">
	<div style="font-size: 11pt;">
		<?php include 'template_header.php';?>

		<strong>
			<?php 
				if ($month == "All"){
					echo "Pag-Ibig Report for All Months";
				}else{
					echo "Pag-Ibig Report for Month of ".$month;
				}
			?>
			<br />
			Year: <?php echo $year; ?> <br />
			Branch : <?php echo $branch; ?></strong>
		<hr>
		<br />
	</div>
<table class="table" style="width:100%;">
		<thead class="thead-inverse">
			<tr>
				<th width="5%">#</th>
				<?php if ($month == "All"){?>
					<th width="10%">Month</th>
				<?php }?>
				<th width="10%">Ecode</th>
				<th width="30%">Name</th>
				<th width="25%">Pag-Ibig No.</th>
				<th width="5%">Contribution</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total_pagibig=0;
			$count=1;
			if(count($pagibig_list)!=0 || count($pagibig_list)!=null){
				foreach($pagibig_list as $row){
					$total_pagibig+=$row->employee;
					if ($row->employee != 0){
				 ?>
					<tr>
					<td><?php echo $count; ?></td>
					<?php if ($month == "All"){?>
						<td><?php echo $row->periodmonth; ?></td>
					<?php }?>
					<td><?php echo $row->ecode; ?></td>
					<td><?php echo $row->full_name; ?></td>
					<td><?php echo $row->pag_ibig; ?></td>
					<td align="right"><?php echo number_format($row->employee,2); ?></td>
				</tr>
	 		<?php
	 			$count++;
				}}}
	 			else{ 
	 				if ($month == "All"){
	 					echo '<tr><td colspan="6" style="font-size:14pt;"><center>No Result</center></td></tr>';
	 				}else{
	 					echo '<tr><td colspan="5" style="font-size:14pt;"><center>No Result</center></td></tr>';
	 				}
	 			} ?>

	 			<?php if ($month == "All"){?>
		 			<tr>
						<td style="border-bottom: 1px solid #95a5a6 !important;" colspan="6"></td>
		 			</tr>
	 			<?php }else{?>
		 			<tr>
						<td style="border-bottom: 1px solid #95a5a6 !important;" colspan="5"></td>
		 			</tr>
	 			<?php }?>
	 			<tr>
	 				<?php if ($month == "All"){?>
						<td style="text-align:right;font-weight:bold;" colspan="5">Total:</td>
					<?php }else{?>
						<td style="text-align:right;font-weight:bold;" colspan="4">Total:</td>
					<?php }?>
	 				<td align="right" style="font-weight:bold;color:#27ae60;"><?php echo number_format($total_pagibig,2);?></td>
	 			</tr>
		</tbody>
</table>
</div>
