<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Payslip</title>
<style>
  table { page-break-inside:auto }
  thead { display:table-header-group }
  tfoot { display:table-footer-group }  
  .tbl_pay_slips{
  border-collapse: collapse;
  width: 100%;
  max-width: 100%;
  border-spacing: 0;
  font-family: calibri;
  page-break-inside:avoid;
    }
    .tbl_pay_slips td{
      padding: 3px!important;
    }
    .PaySlip{
      width:100%;
    }
  .header{
    font-weight: bold;
    font-size: 8pt;
    border-bottom: 1px solid black;
    padding-top: 10px;padding-bottom: 20px;
  }
  .subheader{
    font-size: 8pt;
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
<?php foreach($payslips as $payslip){?>

<table width="100%" border="1" style="font-size: 8pt!important;" class="tbl_pay_slips">
  <tr>   
    <td colspan="3" valign="top">
      <table class="tbl_pay_slips">
          <tr>
            <td class="header" valign="middle">
              <?php echo $payslip->branch; ?>
            </td>
          </tr>
          <tr>
            <td class="subheader" valign="middle"><strong>Payslip No:</strong> <?php echo $payslip->payslip_no; ?></td>
          </tr>
          <tr>
            <td class="subheader" valign="middle"><strong>NAME:</strong> <?php echo $payslip->full_name; ?></td>
          </tr>
          <tr>
            <td class="subheader" valign="middle"><strong>NAME OF PROJECT / DEPARTMENT:</strong> <?php echo $payslip->department; ?> </td>
          </tr>
          <tr>
            <td class="subheader" valign="middle"><strong>PAY TYPE:</strong> <?php echo $payslip->payment_type; ?></td>
          </tr>
          <tr>
            <td class="subheader" valign="middle"><strong>PERIOD COVERED:</strong>
              <?php echo $payslip->payperiod; ?></td>
          </tr>        
      </table>
    </td>
    <td style="border-bottom: 0px!important;border-top: 0px!important;">
      
            <strong>Payslip No:</strong><br/>
            <?php echo $payslip->payslip_no;?><br/><br/>

            <strong>NAME:</strong><br/>
            <?php echo $payslip->full_name; ?><br/><br/>


            <strong>NAME OF PROJECT/DEPARTMENT: </strong><br/>
            <?php echo $payslip->department."/<br>".$payslip->group_desc; ?>

    </td>
  </tr>
  <tr>
    <td width="25%" valign="top">
      <table cellpadding="3" class="tbl_pay_slips">
        <?php if(number_format($payslip->reg_pay,0) != 0){?>
          <tr>
            <td class="subheader">Basic Pay: </td>
            <td class="subheader" align="right"><?php echo number_format($payslip->reg_pay,2); ?></td>
          </tr>
        <?php }?>
        <?php if(number_format($payslip->sun_pay,0) != 0){?>
          <tr>
            <td class="subheader">Sunday Pay: </td>
            <td class="subheader" align="right"><?php echo number_format($payslip->sun_pay,2); ?></td>
          </tr>
        <?php }?>
        <?php if(number_format($payslip->cola_pay,0) != 0){?>
          <tr>
            <td class="subheader">E.COLA: </td>
            <td class="subheader" align="right"><?php echo number_format($payslip->cola_pay,2); ?></td>
          </tr>
        <?php }?>
        <?php if(number_format($payslip->reg_ot_pay,0) != 0){?>
          <tr>
            <td class="subheader">Total Regular OT: </td>
            <td class="subheader" align="right"><?php echo number_format($payslip->reg_ot_pay,2); ?></td>
          </tr>
        <?php }?>  
        <?php if(number_format($payslip->sun_ot_pay,0) != 0){?>
          <tr>
            <td class="subheader">Total Sunday OT: </td>
            <td class="subheader" align="right"><?php echo number_format($payslip->sun_ot_pay,2); ?></td>
          </tr>
        <?php }?>    
        <?php if(number_format($payslip->spe_hol_pay,0) != 0){?>
          <tr>
            <td class="subheader">Total Special Holiday: </td>
            <td class="subheader" align="right"><?php echo number_format($payslip->spe_hol_pay,2); ?></td>
          </tr>
        <?php }?>    
        <?php if(number_format($payslip->reg_hol_pay,0) != 0){?>
          <tr>
            <td class="subheader">Total Legal Holiday: </td>
            <td class="subheader" align="right"><?php echo number_format($payslip->reg_hol_pay,2); ?></td>
          </tr>
        <?php }?>   
        <?php if(number_format($payslip->reg_nsd_pay,0) != 0){?>
          <tr>
            <td class="subheader">NSD Reg: </td>
            <td class="subheader" align="right"><?php echo number_format($payslip->reg_nsd_pay,2); ?></td>
          </tr>
        <?php }?>   
        <?php if(number_format($payslip->sun_nsd_pay,0) != 0){?>
          <tr>
            <td class="subheader">NSD Sunday: </td>
            <td class="subheader" align="right"><?php echo number_format($payslip->sun_nsd_pay,2); ?></td>
          </tr>
        <?php }?> 
        <?php if(number_format($payslip->days_with_pay_amt,0) != 0){?>
          <tr>
            <td class="subheader">Days w/ pay: </td>
            <td class="subheader" align="right"><?php echo number_format($payslip->days_with_pay_amt,2); ?></td>
          </tr>
        <?php }?> 
        <?php if(number_format($payslip->day_off_pay,0) != 0){?>
          <tr>
            <td class="subheader">Rest Day Pay: </td>
            <td class="subheader" align="right"><?php echo number_format($payslip->day_off_pay,2); ?></td>
          </tr>
        <?php }?> 
        <?php foreach($earnings as $earning){
          if ($earning->employee_id == $payslip->employee_id){
        ?>
          <tr>
            <td class="subheader"><?php echo $earning->earnings_desc; ?> :</td>
            <td class="subheader" align="right"><?php echo number_format($earning->earnings_amount,2); ?></td>
          </tr>
        <?php }}?>
      </table>
    </td>
    <td width="25%" valign="top">
      <table cellpadding="3" class="tbl_pay_slips">
        <?php if(number_format($payslip->total_deductions,0) == 0){ ?>
          <tr>
            <td colspan="2" class="subheader">
              <center>- - - No Deduction - - -</center>
            </td>
          </tr>
        <?php }?>
        <?php foreach($deductions as $deduction){
          if ($deduction->employee_id == $payslip->employee_id){
        ?>
          <tr>
            <td class="subheader"><?php echo $deduction->deduction_desc; ?> :</td>
            <td class="subheader" align="right"><?php echo number_format($deduction->deduction_amount,2); ?></td>
          </tr>
        <?php }}?>
        <?php if(number_format($payslip->minutes_late_amt,0) != 0){?>
        <tr>
          <td class="subheader">Minutes Late:</td>
          <td class="subheader" align="right"><?php echo number_format($payslip->minutes_late_amt,2);?></td>
        </tr>
        <?php }?>
        <?php if(number_format($payslip->minutes_undertime_amt,0) != 0){?>
        <tr>
          <td class="subheader">Minutes Undertime:</td>
          <td class="subheader" align="right"><?php echo number_format($payslip->minutes_undertime_amt,2);?></td>
        </tr>
        <?php }?>
        <?php if(number_format($payslip->minutes_excess_break_amt,0) != 0){?>
        <tr>
          <td class="subheader">Minutes Excess Break:</td>
          <td class="subheader" align="right"><?php echo number_format($payslip->minutes_excess_break_amt,2);?></td>
        </tr>
        <?php }?>
        <?php if(number_format($payslip->days_wout_pay_amt,0) != 0){?>
        <tr>
          <td class="subheader">Days w/o pay:</td>
          <td class="subheader" align="right"><?php echo number_format($payslip->days_wout_pay_amt,2);?></td>
        </tr>
        <?php }?>
      </table>
    </td>
    <td width="25%" valign="top">      
      <table cellpadding="3" class="tbl_pay_slips">
        <?php if(number_format($payslip->reg,0) != 0){?>
        <tr>
          <td class="subheader">Regular Hours:</td>
          <td class="subheader" align="right"><?php echo number_format($payslip->reg,2);?></td>
        </tr>
        <?php }?>
        <?php if(number_format($payslip->sun,0) != 0){?>
        <tr>
          <td class="subheader">Sunday Hours:</td>
          <td class="subheader" align="right"><?php echo number_format($payslip->sun,2);?></td>
        </tr>
        <?php }?>
        <?php if(number_format(($payslip->ot_reg+$payslip->ot_reg_reg_hol+$payslip->ot_reg_spe_hol),0) != 0){?>
        <tr>
          <td class="subheader">Regular OT Hours:</td>
          <td class="subheader" align="right"><?php echo number_format(($payslip->ot_reg+$payslip->ot_reg_reg_hol+$payslip->ot_reg_spe_hol),2);?></td>
        </tr>
        <?php }?>
        <?php if(number_format(($payslip->ot_sun+$payslip->ot_sun_reg_hol+$payslip->ot_sun_spe_hol),0) != 0){?>
        <tr>
          <td class="subheader">Sunday OT Hours:</td>
          <td class="subheader" align="right"><?php echo number_format(($payslip->ot_sun+$payslip->ot_sun_reg_hol+$payslip->ot_sun_spe_hol),2);?></td>
        </tr>
        <?php }?>
        <?php if(number_format(($payslip->spe_hol+$payslip->sun_spe_hol),0) != 0){?>
        <tr>
          <td class="subheader">Special Holiday Hours:</td>
          <td class="subheader" align="right"><?php echo number_format(($payslip->spe_hol+$payslip->sun_spe_hol),2);?></td>
        </tr>
        <?php }?>
        <?php if(number_format(($payslip->reg_hol+$payslip->sun_reg_hol),0) != 0){?>
        <tr>
          <td class="subheader">Legal Holiday Hours:</td>
          <td class="subheader" align="right"><?php echo number_format(($payslip->reg_hol+$payslip->sun_reg_hol),2);?></td>
        </tr>
        <?php }?>
        <?php if(number_format(($payslip->nsd_reg+$payslip->nsd_reg_reg_hol+$payslip->nsd_reg_spe_hol),0) != 0){?>
        <tr>
          <td class="subheader">NSD Reg Hours:</td>
          <td class="subheader" align="right"><?php echo number_format(($payslip->nsd_reg+$payslip->nsd_reg_reg_hol+$payslip->nsd_reg_spe_hol),2);?></td>
        </tr>
        <?php }?>
        <?php if(number_format(($payslip->nsd_sun+$payslip->nsd_sun_reg_hol+$payslip->nsd_sun_spe_hol),0) != 0){?>
        <tr>
          <td class="subheader">NSD Sun Hours:</td>
          <td class="subheader" align="right"><?php echo number_format(($payslip->nsd_sun+$payslip->nsd_sun_reg_hol+$payslip->nsd_sun_spe_hol),2);?></td>
        </tr>
        <?php }?>
        <?php if(number_format($payslip->minutes_late,0) != 0){?>
        <tr>
          <td class="subheader">Total Late (Minutes):</td>
          <td class="subheader" align="right"><?php echo number_format($payslip->minutes_late,2);?></td>
        </tr>
        <?php }?>
        <?php if(number_format($payslip->minutes_undertime,0) != 0){?>
        <tr>
          <td class="subheader">Total Undertime (Minutes):</td>
          <td class="subheader" align="right"><?php echo number_format($payslip->minutes_undertime,2);?></td>
        </tr>
        <?php }?>
        <?php if(number_format($payslip->minutes_excess_break,0) != 0){?>
        <tr>
          <td class="subheader">Total Excess Break (Minutes):</td>
          <td class="subheader" align="right"><?php echo number_format($payslip->minutes_excess_break,2);?></td>
        </tr>
        <?php }?>
        <?php if(number_format($payslip->day_off,0) != 0){?>
        <tr>
          <td class="subheader">Rest Day Hours:</td>
          <td class="subheader" align="right"><?php echo number_format($payslip->day_off,2);?></td>
        </tr>
        <?php }?>
      </table>
    </td>
    <td style="border-bottom: 0px!important;border-top: 0px!important;" valign="top">
            <strong>PAY TYPE</strong><br/>
            <?php echo $payslip->payment_type; ?><br/><br/>

            <strong>PERIOD COVERED</strong><br/>
            <?php echo $payslip->payperiod; ?>
        <center>
            <hr>
            <p>I acknowledge that I received the amount and have no further claims for the services rendered.</p>
        </center>
    </td>
  </tr>
  <tr>
    <td class="result-title-td">Gross Pay: 
      <span style="float: right;margin-right: 3px;color: #1A237E;">
        <?php echo number_format($payslip->gross_pay,2); ?>
      </span>
    </td>
    <td class="result-title-td">Deductions: 
      <span style="float: right;margin-right: 3px;color: #d50000;">
        <?php echo number_format($payslip->total_deductions,2); ?>
      </span>
    </td>
    <td class="result-title-td">Net Pay: 
      <span style="float: right;margin-right: 3px;color: #1B5E20;">
        <?php echo number_format($payslip->net_pay,2); ?>
      </span>
    </td>
    <td style="border-top: 0px!important;">
      <center>
        <strong>Employee Signature</strong>
      </center>
    </td>
  </tr>
</table>

<?php } ?>
</body>