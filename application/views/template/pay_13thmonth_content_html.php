<style>
    table#tbl_print{
	border-collapse: collapse;
	width: 100%;
	max-width: 100%;
	border-spacing: 0;
	font-family: calibri;
	page-break-inside:avoid;
  	}
  .theader-right{
    vertical-align: baseline;
    width: 200px;
    border: 1px solid black;
    font-size: 12pt;
  }
  .ttitle{
    font-weight: bold;
    padding-left: 10px;
    font-size: 11pt;
    border-top: 1px solid black;
    border-left: 1px solid black;
    border-bottom: 1px solid black;
  }
  .theader{
    padding-left: 10px;
    padding-top: 3px;
    padding-bottom: 3px;
    border-left: 1px solid black;
    border-right: 1px solid black;
    font-size: 9pt;
  }
  .theader-bottom{
    padding-left: 10px;
    padding-bottom: 3px;
    border-left: 1px solid black;
    border-bottom: 1px solid black;
    border-right: 1px solid black;
    font-size: 9pt;
  }
  .title-td-first{
    font-weight: 500;
    font-size: 9pt;
    border-left: 1px solid black;
    padding-left: 10px;
    white-space:nowrap;
  }
  .title-td-top{
    font-weight: 500;
    font-size: 9pt;
    border-left: 1px solid black;
    padding-left: 10px;
    white-space:nowrap;
  }
  .title-td{
    font-weight: 500;
    padding-left: 10px;
    font-size: 9pt;
    white-space:nowrap;
  }
  .result-td{
    font-weight: 500;
    border-right: 1px solid black;
    font-size: 9pt;
    padding-right: 10px;
    text-align: right;
    white-space:nowrap;
  }
  .result-td-top{
    font-weight: 500;
    border-right: 1px solid black;
    padding-top: 5px;
    font-size: 9pt;
    padding-right: 10px;
    text-align: right;
    white-space:nowrap;
  }
  .result-total-td{
    border-top: 1px dashed black;
    border-bottom: 1px solid black;
    border-left: 1px solid black;    
    border-right: 1px solid black;
    font-size: 9pt;
    padding-right: 10px;
    padding-left: 10px;
  }
  .result-title-td{
    font-weight: bold;
    font-size: 9pt;
    border-left: 1px solid black;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
    padding-top: 5px;
    padding-bottom: 5px;
    padding-left: 10px;
  }
  .info-right{
    padding: 10px;
    font-size: 9pt!important;
  }
  .title-margin{
    margin-top: 20px;
  }
  .title-margin-bottom{
    margin-top: 40px;
  }
  	.PaySlip{
  		width:100%;
  	}
</style>
<div class="PaySlip">
	<table width="100%" id="tbl_print" style="border-collapse: collapse;">
		<tr>
			<td colspan="2" class="" style="font-weight: bold;font-size: 11pt;border: 1px solid black;padding: 10px;">
				<?php echo $data->branch; ?>
			</td>
		</tr>
		<tr>
			<td class="theader"><strong>13TH MONTH NO #:</strong> <?php echo $data->emp_13thmonth_no; ?></td>
			<td class="theader"><strong>NAME OF PROJECT / DEPARTMENT:</strong> <?php echo $data->department; ?></td>
		</tr>
		<tr>
			<td class="theader"><strong>NAME:</strong> <?php echo $data->fullname; ?></td>
			<td class="theader"><strong>PERIOD COVERED:</strong> <?php echo $data->year; ?></td>
		</tr>
		<tr>
			<td class="title-td-first" style="padding: 10px;font-size: 12pt;border-top: 1px solid black;">13TH MONTH PAY : </td>
			<td class="result-td-top" style="padding: 10px;font-size: 12pt;border-top: 1px solid black;"><center><b><?php echo number_format($data->grand_13thmonth_pay,2); ?></b></center></td>
		</tr>			

		<tr>
			<td class="result-total-td">

				<strong>13TH MONTH NO #:</strong>
				<?php echo $data->emp_13thmonth_no;?> <br />

				<strong style="margin-top: 10px!important;">NAME :</strong>
				<?php echo $data->fullname; ?><br />

				<strong style="margin-top: 10px!important;">NAME OF PROJECT/DEPARTMENT : </strong>

				<?php echo $data->department; ?>	<br />
				<strong style="margin-top: 10px!important;">PERIOD COVERED : </strong>
				<?php echo $data->year; ?>			

			</td>
			<td class="result-total-td">
				<center>
					<br>
					I acknowledge that i receive the amount
					<hr>
					and have no further claims for the services rendered<br><br><br>
					<strong>Employee Signature</strong>
				</center>
			</td>	
	</table>
</div>
