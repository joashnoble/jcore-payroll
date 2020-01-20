<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
	table { page-break-inside:auto }

	hr{
		border-bottom: 1px solid #FAFAFA;
	}

	html{
		font-family: calibri;
	}

	input[type="text"]:disabled{
		padding: 4px;
		background-color: #FFF;
		border: 1px solid gray;
		color: black;
	}

	table{
		border-collapse: collapse;
		font-size: 12pt!important;
	}
	table td{
		font-size: 12pt;s
	}
	.numeric{
		text-align: right;
	}
	#tbl_emp_info td{
		padding: 5px;
	}
	#tbl_due td{
		padding: 3px;
	}
</style>
 <script type="text/javascript">
      window.onload = function() {
       window.print();
		window.onfocus=function(){ window.close();}
   }
 </script>
</head>
<body>


<div style="margin: 20px;">
	<div style="font-size: 11pt;">
		<img src="<?php echo $this->session->main_directory.'/'.$company->image_name;?>" style="width: auto; max-width: auto; height: 60px; max-height: 60px; float: left; margin-top: 5px !important;margin-right: 10px;">
		<div style="font-size: 11pt;font-weight: 500;"><?php echo $company->company_name; ?></div>
		<div style="font-size: 8pt;font-weight: 500;margin-top: 0px;"><?php echo $company->address ?></div>
		<div style="font-size: 8pt;font-weight: 500;margin-top: 0px;"><?php echo $company->contact_no ?></div>
		<div style="font-size: 8pt;font-weight: 500;margin-top: 0px;"><?php echo $company->email_address ?></div>

		<br /><br />
		<center>
			<strong style="font-size: 13pt;">
				Employee Clearance / Exit
			</strong>
		</center>
		<hr>
	</div>


<?php foreach($clearance AS $row){?>
		<table width="100%" id="tbl_emp_info">
			<tr>
				<td>Ecode: </td>
				<td><input type="text" value="<?php echo $row->ecode; ?>" disabled></td>
				<td>Name: </td>
				<td colspan="3" width="20%"><input type="text" value="<?php echo $row->full_name; ?>" style="width: 100%;" disabled></td>
			</tr>
			<tr>
				<td>Department: </td>
				<td><input type="text" value="<?php echo $row->department; ?>" disabled></td>
				<td>Position: </td>
				<td><input type="text" value="<?php echo $row->position; ?>" disabled></td>
				<td width="5%">Rate: </td>
				<td width="15%"><input type="text" value="<?php echo number_format($row->salary_reg_rates,2); ?>" disabled></td>
			</tr>
		</table>
		<hr>

		<div class="row">
			<div>
				<table id="tbl_due" width="100%">
					<tr>
						<td><br />13th Month Due: </td>
						<td><br /><input type="text" class="numeric" value="<?php echo number_format($row->accumulated_13thmonth_pay,2); ?>" disabled></td>
						<td>Additional Pay <br /><input type="text" class="numeric" value="<?php echo number_format($row->additional_pay,2); ?>" disabled></td>
						<td>Due to date<br /><input type="text" class="numeric" value="<?php echo number_format($row->total_due_date,2); ?>" disabled></td>
					</tr>
					<tr>
						<td><br />Paid Leave: </td>
						<td>No of Day<br /><input type="text" value="<?php echo number_format($row->no_of_leave,2); ?>" disabled></td>
						<td>Leave Pay <br /><input type="text" class="numeric" value="<?php echo number_format($row->leave_pay,2); ?>" disabled></td>
						<td><br /><input type="text" class="numeric" value="<?php echo number_format($row->total_leave,2); ?>" disabled></td>
					</tr>		
					<tr>
						<td colspan="3">Tax Refund: </td>
						<td><input type="text" class="numeric" value="<?php echo number_format($row->tax_refund,2); ?>" disabled></td>
					</tr>
					<?php if($row->include_last_pay == 1){?>	
					<tr>
						<td colspan="3">Last Payroll ( Payslip No: <?php echo $row->payslip_no; ?> ) </td>
						<td><input type="text" class="numeric" value="<?php echo number_format($row->last_payroll,2); ?>" disabled></td>
					</tr>	
					<?php }?>
					<tr>
						<td colspan="3" align="right" style="padding-right: 10px!important;"><b>Grand Total:</b></td>
						<td><input type="text" class="numeric" value="<?php echo number_format($row->grand_total,2); ?>" disabled></td>
					</tr>	
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<?php if (count($clearance_deduction) > 0){ 

						$total_deduction = 0;
						echo '<tr>';
							echo '<td colspan="2"></td>';
							echo '<td>Deduction</td>';
							echo '<td>Amount</td>';						
						echo '</tr>';
						
						foreach ($clearance_deduction as $drow) {
						$total_deduction += $drow->deduction_amount;

						echo '<tr>';
							echo '<td colspan="2"></td>';
							echo '<td><input type="text" value="'.$drow->deduction_description.'" disabled></td>';
							echo '<td><input type="text" class="numeric" value="'.number_format($drow->deduction_amount,2).'" disabled></td>';
						echo '</tr>';
						}
						echo '<tr>';
							echo '<td colspan="3" align="right" style="padding-right: 10px;">Total Deduction: </td>';
							echo '<td><input type="text" class="numeric" value="'.number_format($total_deduction,2).'" disabled></td>';
						echo '</tr>';
						}else{

					echo '<tr>';
						echo '<td colspan="4"><center>No Deduction</center></td>';
					echo '</tr>';
					}?>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td colspan="3" align="right" style="padding-right: 10px!important;"><i>(Last Pay)</i> <b>Total Net:</b> </td>
						<td><input type="text" class="numeric" value="<?php echo number_format($row->net_total,2); ?>" disabled></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td>Date Cleared: </td>
						<td><input type="text" value="<?php echo $row->date_cleared; ?>" disabled></td>
						<td colspan="2">By: <input type="text" value="<?php echo $row->cleared_by_fullname; ?>" disabled></td>
					</tr>
					<tr>
						<td>Reason: </td>
						<td colspan="3"><input type="text" value="<?php echo $row->clearance_description; ?>" disabled width="100%"></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td style="padding: 20px;">Prepared By:</td>
						<td style="padding: 20px;">_______________________</td>
						<td style="padding: 20px;">Received By:</td>
						<td style="padding: 20px;">_______________________</td>
					</tr>
				</table>
			</div>
		</div>
<?php }?>
</div>

</body>
</html>