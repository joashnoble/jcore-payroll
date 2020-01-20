<div style="margin: 20px;">
    <div style="font-size: 11pt;">
        <?php include 'template_header.php';?>

            <table style="border-collapse: collapse;border:0px!important;" width="100%">
                <tr>
                    <td style=""><b>13TH MONTH PAY</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        Year : <?php echo $yearfilter; ?>
                    </td>
                    <td align="right">Date : <?php echo date('m/d/Y'); ?></td>
                </tr>
                <tr>
                    <td>
                        Branch : <?php echo $get_branch; ?>
                    </td>
                    <td align="right">Payment : Bank</td>
                </tr>
                <tr>
                    <td>Department : <?php echo $get_department; ?></td>
                    <td></td>
                </tr>
            </table>
            <hr /><br />
    </div>
    <table class="table">
        <thead>
            <tr>
                <th style="text-align: left;" width="5%">#</th>
                <th style="text-align: left;" width="10%">ECODE</th>
                <th style="text-align: left;" width="30%">Employee Name</th>
                <th style="text-align: left;" width="10%">Bank Account #</th>
                <th style="text-align: right;" width="25%">Accumulated 13th Month Pay</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count=1;
            $grand_total_13thmonth=0;

                foreach($get13thmonth_pay as $row){

                    if($row->bank_account_isprocess == 1){

                    $total_13thmonth = ((($row->total_13thmonth+$row->retro+$row->dayswithpayamt)-($row->total_days_wout_pay_amt))/$factor);
                    $grand_total_13thmonth += $total_13thmonth;
                ?>
            <tr>
                <td style="text-align: left;"><?php echo $count; ?>.</td>
                <td style="text-align: left;"><?php echo $row->ecode; ?></td>
                <td style="text-align: left;"><?php echo $row->fullname; ?></td>
                <td style="text-align: left;"><?php echo $row->bank_account; ?></td>
                <td style="text-align: right;"><?php echo number_format($total_13thmonth,2); ?></td>
            </tr>
            <?php
                $count++;
            }}
            ?>
            <tr>
                <td colspan="5"><hr style="border-top: 1px solid black!important;"></td>
            </tr>
            <tr>
                <td align="right" colspan="5"><b>Total : <?php echo number_format($grand_total_13thmonth,2);?></b></td>
            </tr>
        </tbody>

    </table>

</div>
