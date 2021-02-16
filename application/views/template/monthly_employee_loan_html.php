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
			Monthly Employee Loan Report<br />
			<?php echo $employee->ecode.' - '.$employee->last_name.', '.$employee->first_name.' '.$employee->middle_name; ?><br />
				FOR THE YEAR <?php echo $year; ?>
		</strong>
	</div>
	<br />
	<table class="tablepayroll" width="100%" style="font-size: 10pt!important;">
		<thead>
			<tr>
				<th style="border-bottom: 1px solid black!important;">Loan</th>
				<th style="border-bottom: 1px solid black!important;text-align: right">JAN</th>
				<th style="border-bottom: 1px solid black!important;text-align: right">FEB</th>
				<th style="border-bottom: 1px solid black!important;text-align: right">MAR</th>
				<th style="border-bottom: 1px solid black!important;text-align: right">APR</th>
				<th style="border-bottom: 1px solid black!important;text-align: right">MAY</th>
				<th style="border-bottom: 1px solid black!important;text-align: right">JUN</th>
				<th style="border-bottom: 1px solid black!important;text-align: right">JUL</th>
				<th style="border-bottom: 1px solid black!important;text-align: right">AUG</th>
				<th style="border-bottom: 1px solid black!important;text-align: right">SEP</th>
				<th style="border-bottom: 1px solid black!important;text-align: right">OCT</th>
				<th style="border-bottom: 1px solid black!important;text-align: right">NOV</th>
				<th style="border-bottom: 1px solid black!important;text-align: right">DEC</th>
				<th style="border-bottom: 1px solid black!important;text-align: right">Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				if(count($loans) > 0){
				$grand_total = 0;
				foreach($loans as $loan){?>
				<tr>
					<td>
						<?php echo $loan->deduction_desc; ?>
					</td>
				<?php 
						$total_amount = 0;

						for ($i=1; $i <= 12; $i++) {

						$this->db->where('el.employee_id', $loan->employee_id);
				 		$this->db->where('rpp.pay_period_year', $loan->pay_period_year);
				 		$this->db->where('rd.deduction_id', $loan->deduction_id);
				 		$this->db->where('rpp.month_id', $i);

					 	$this->db->select('rpp.month_id,
								rd.deduction_id,
								rd.deduction_desc,
								SUM(psd.deduction_amount) as loan_deduction');
						
						$this->db->from('pay_slip ps');

						$this->db->join('daily_time_record dtr','dtr.dtr_id = ps.dtr_id');
						$this->db->join('employee_list el','el.employee_id = dtr.employee_id');
						$this->db->join('refpayperiod rpp','rpp.pay_period_id = dtr.pay_period_id');
						$this->db->join('pay_slip_deductions psd','psd.pay_slip_id = ps.pay_slip_id');
						$this->db->join('refdeduction rd','rd.deduction_id = psd.deduction_id');

						$this->db->group_by("psd.deduction_id, rpp.month_id");
						$query = $this->db->get();
				?>

					<?php 
						if($query->num_rows() != 0){
							foreach($query->result() as $row){

							$total_amount+=$row->loan_deduction;
					?>

						<td align="right">
							<?php echo number_format($row->loan_deduction,2); ?>					
						</td>

					<?php }}else{?>
						<td align="right">0.00</td>
					<?php }?>

			<?php }?>

					<td align="right">
						<?php echo number_format($total_amount,2); ?>	
					</td>

				</tr>
			<?php 
				$grand_total+=$total_amount;
			}?>
				<tr align="right">
					<td colspan="13">
						<strong>TOTAL : </strong>
					</td>
					<td>
						<strong>
							<?php echo number_format($grand_total,2); ?>
						</strong>
					</td>
				</tr>
			<?php }else{?>
			<td colspan="14">
				<center>
					<span style="font-size: 12pt;">No Result</span>
				</center>
			</td>
			<?php } ?>
		</tbody>
		</table>
	</div>
</div>
