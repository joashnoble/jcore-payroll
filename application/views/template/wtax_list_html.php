<div style="margin: 20px;">
	<div style="font-size: 11pt;">
		<?php include 'template_header.php';?>
		<strong>
			<?php 
				if ($month == "All"){
					echo "WTAX Report for All Months";
				}else{
					echo "WTAX Report for Month of ".$month;
				}
			?>
			<br />
			Year: <?php echo $year; ?> <br />
			Branch : <?php echo $branch; ?>
		</strong>
		<hr>
		</br/>
	</div>
	<table class="table" style="width:100%;">
			<thead class="thead-inverse">
				<tr>
					<th width="1%">#</th>
					<?php if ($month == "All"){?>
						<th width="10%">Month</th>
					<?php }?>
					<th width="10%">Ecode</th>
					<th width="20%">Name</th>
					<th width="10%">TIN #.</th>
					<th width="10%" style="text-align: right;">Taxable Amount</th>
					<th width="10%" style="text-align: right;">Deduction/Tax Shield</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$total_wtax=0;
				$count=1;
				if(count($wtax_report)!=0 || count($wtax_report)!=null){
					foreach($wtax_report as $row){
						$total_wtax+=$row->wtax_employee;
						if ($row->wtax_employee != 0){
					 ?>
						<tr>
						<td><?php echo $count; ?>.</td>
						<?php if ($month == "All"){?>
							<td><?php echo $row->periodmonth; ?></td>
						<?php }?>
						<td><?php echo $row->ecode; ?></td>
						<td><?php echo $row->full_name; ?></td>
						<td><?php echo $row->tin; ?></td>
						<td align="right"><?php echo number_format($row->taxable_amount,2); ?></td>
						<td align="right"><?php echo number_format($row->wtax_employee,2); ?></td>
					</tr>
		 		<?php
		 			$count++;
					} } }
		 			else{ 
		 				if ($month == "All"){
		 					echo '<tr><td style="text-align:center;font-size:14pt;" colspan="7"><center>No Result</center></td></tr>';
		 				}else{
		 					echo '<tr><td style="text-align:center;font-size:14pt;" colspan="6"><center>No Result</center></td></tr>';
		 				}} ?>
		 			<tr>
		 				<?php if($month == "All"){?>
							<td style="border-bottom: 1px solid #95a5a6 !important;" colspan="7"></td>
		 				<?php }else{?>
							<td style="border-bottom: 1px solid #95a5a6 !important;" colspan="6"></td>
		 				<?php }?>
		 			</tr>
		 			<tr>
						<?php if($month == "All"){?>
							<td style="text-align:right;font-weight:bold;" colspan="6">Total:</td>
						<?php }else{?>
							<td style="text-align:right;font-weight:bold;" colspan="5">Total:</td>
						<?php }?>
		 				<td align="right" style="font-weight:bold;color:#27ae60;"><?php echo number_format($total_wtax,2);?></td>
		 			</tr>
			</tbody>


	</table>
	</div>
</div>
