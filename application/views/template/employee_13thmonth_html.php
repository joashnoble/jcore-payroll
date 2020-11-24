<div style="margin: 20px;">
    <div style="font-size: 11pt;">
        <?php include 'template_header.php';?>
        <strong>
            13th Month Pay <br />
            Year : <?php echo $yearfilter; ?><br />
            <hr><br />
        </strong>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th style="text-align: left;" width="2%"></th>
                <th style="text-align: left;" width="28%">Employee Name</th>
                <!-- <th style="text-align: center;">Reg Pay</th> -->
                <!-- <th style="text-align: right;" width="5%">Salary Retro</th> -->
                <th style="text-align: right;" width="15%">Total Reg Pay</th>

                <th style="text-align: right;" width="15%">Days w/ Pay</th>

                <!-- <th style="text-align: right;" width="13%">Absences</th> -->
                <th style="text-align: right;" width="15%">Total</th>
                <th style="text-align: right;" width="15%">Accumulated <br />13th Month Pay</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count=1;
            $grand_total_retro=0;
            $grand_total_reg_pay=0;
            $grand_total_days_w_pay_amt=0;
            $grand_total_total_days_wout_pay_amt=0;
            $grand_total=0;
            $grand_total_13thmonth=0;

                foreach($get13thmonth_pay as $row){
                    $grand_total_retro += $row->retro;
                    $grand_total_reg_pay += $row->total_13thmonth;
                    $grand_total_days_w_pay_amt += $row->dayswithpayamt;
                    $grand_total_total_days_wout_pay_amt += $row->total_days_wout_pay_amt;
                    $grand_total += (($row->total_13thmonth+$row->retro+$row->dayswithpayamt)-($row->total_days_wout_pay_amt));
                    $grand_total_13thmonth += ((($row->total_13thmonth+$row->retro+$row->dayswithpayamt)-($row->total_days_wout_pay_amt))/$factor);
                ?>
            <tr>
                <td style="text-align: left;"><?php echo $count; ?>.</td>
                <td style="text-align: left;"><?php echo $row->fullname; ?></td>
                <!-- <td style="text-align: center;"><?php echo number_format($row->for_13th_month,2); ?></td> -->
                <!-- <td style="text-align: right;"><?php echo number_format($row->retro,2); ?></td> -->
                <td style="text-align: right;"><?php echo number_format($row->total_13thmonth,2); ?></td>

                <td align="right"><?php echo number_format($row->dayswithpayamt,2); ?></td>

                <!-- <td style="text-align: right;"><?php echo number_format($row->total_days_wout_pay_amt,2); ?></td> -->
                <td style="text-align: right;"><?php echo number_format(($row->total_13thmonth+$row->retro+$row->dayswithpayamt)-($row->total_days_wout_pay_amt),2); ?></td>
                <td style="text-align: right;"><?php echo number_format(((($row->total_13thmonth+$row->retro+$row->dayswithpayamt)-($row->total_days_wout_pay_amt))/$factor),2); ?></td>
            </tr>
            <?php
                $count++;
            }
            ?>
            <tr>
                <td colspan="6"><hr style="border-top: 1px solid black!important;"></td>
            </tr>
            <tr>
                <td></td>
                <td align="right"><strong>Total:</center></td>
                <!-- <td align="right"><b><?php echo number_format($grand_total_retro,2);?></b></td> -->
                <td align="right"><b><?php echo number_format($grand_total_reg_pay,2);?></b></td>
                <td align="right"><b><?php echo number_format($grand_total_days_w_pay_amt,2);?></b></td>                
                <!-- <td align="right"><b><?php echo number_format($grand_total_total_days_wout_pay_amt,2);?></b></td> -->
                <td align="right"><b><?php echo number_format($grand_total,2);?></b></td>
                <td align="right"><b><?php echo number_format($grand_total_13thmonth,2);?></b></td>
            </tr>
        </tbody>

    </table>

</div>
