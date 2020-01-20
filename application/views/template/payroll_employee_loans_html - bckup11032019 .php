<div style="margin: 20px;">
	<div style="font-size: 11pt;">
	<?php include 'template_header.php';?>
	</div>
	<div style="margin-bottom: 20px!important;">
		<div style="float: left;">
			<strong>Employee Ledger</strong><br />
			Employee Name : <?php 
				if (count($initial_loan) > 0){
					foreach ($initial_loan as $row) {
						echo $row->fullname;
					}
				}
			?><br />
			Loan Type : <?php echo $get_type; ?>
		</div>
		<div style="float: right;">
			<?php 
			if (count($loan_amount) > 0){
				foreach ($loan_amount as $row) {
					echo 'Loan Amount : '.number_format($row->loan_total_amount,2).'<br>';
					echo 'Deduct Per Pay : '.number_format($row->deduction_per_pay_amount,2).'<br>';
					echo 'Loan Balance : '.number_format($row->balance,2).'<br>';
				}
			}
			?>
		</div>
			
	</div><br /><br /><br />
	<table class="table" style="width:100%;margin-top: 20px;" cellpadding="5" cellspacing="5">
		<thead class="thead-inverse">
			<tr>
				<th style="width:20%;text-align:left;border-bottom: 1px solid lightgray;">Due Date</th>
				<th style="width:15%;text-align:right;border-bottom: 1px solid lightgray;">Debit</th>
				<th style="width:15%;text-align:right;border-bottom: 1px solid lightgray;">Credit</th>
				<th style="width:20%;text-align:right;border-bottom: 1px solid lightgray;">Balance</th>
			</tr>
		</thead>
		<tbody>
<?php
//total amount of loan]
$loan_amount_total = 0;


	if (count($loans) > 0){
		foreach ($initial_loan as $row) {
			echo "<tr>";
			echo "<td style='border-bottom: 1px solid lightgray!important;'>".$row->pay_period_start."</td>";
			echo "<td align='right' style='border-bottom: 1px solid lightgray!important;'>".number_format($row->loan_total_amount,2)."</td>";
			echo "<td align='right' style='border-bottom: 1px solid lightgray!important;'>0.00</td>";
			echo "<td align='right' style='border-bottom: 1px solid lightgray!important;'>".number_format($row->loan_total_amount,2)."</td>";
			echo "</tr>";
			$loan_amount_total = $row->loan_total_amount;
		}

		 foreach($loans as $result){
		 	echo "<tr>";
		 	echo "<td style='border-bottom: 1px solid lightgray!important;'>".$result->pay_period_end."</td>";
		 	echo "<td align='right' style='border-bottom: 1px solid lightgray!important;'>0.00</td>";
		 	echo "<td align='right' style='border-bottom: 1px solid lightgray!important;'>".number_format($result->deduction_amount,2)."</td>";
		 	echo "<td align='right' style='border-bottom: 1px solid lightgray!important;'>".number_format($loan_amount_total=$loan_amount_total-$result->deduction_amount,2)."</td></tr>";
		 }

	}else{
			echo "<tr>";
			echo "<td colspan='4'><center>No Result</center></td>";
			echo "</tr>";
	}
?>
</tbody>
</table>
</div>
