<!DOCTYPE html>

<html lang="en">
<?php echo $loader; ?>
<head>

    <meta charset="utf-8">

    <title>JCORE PAYROLL - <?php echo $title; ?></title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="description" content="Avenxo Admin Theme">
    <meta name="author" content="">
    <?php echo $_def_css_files; ?>

    <link rel="stylesheet" href="assets/plugins/spinner/dist/ladda-themeless.min.css">

    <link type="text/css" href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet"><!-- iCheck -->
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/_all.css" rel="stylesheet"><!-- Custom Checkboxes / iCheck -->
    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">

    <?php echo $_switcher_settings; ?>
    <?php echo $_def_js_files; ?>

    <script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

    <!-- Select2 -->
    <script src="assets/plugins/select2/select2.full.min.js"></script>


    <!-- twitter typehead -->
    <script src="assets/plugins/twittertypehead/handlebars.js"></script>
    <script src="assets/plugins/twittertypehead/bloodhound.min.js"></script>
    <script src="assets/plugins/twittertypehead/typeahead.bundle.min.js"></script>
    <script src="assets/plugins/twittertypehead/typeahead.jquery.min.js"></script>

    <!-- touchspin -->
    <script type="text/javascript" src="assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"></script>

    <!-- numeric formatter -->
    <script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
    <script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>
    <style>
        .toolbar{
            float: left;
        }

        td.details-control {
            background: url('assets/img/Folder_Closed.png') no-repeat center center;
            cursor: pointer;
        }
        tr.details td.details-control {
            background: url('assets/img/Folder_Opened.png') no-repeat center center;
        }
        td.pay_slip_show {
            background: url('assets/img/show.png') no-repeat center center !important;
            cursor: pointer;
        }
        td.details-control1 {
            background: url('assets/img/Folder_Closed.png') no-repeat center center !important;
            cursor: pointer;
        }
        tr.details1 td.details-control1 {
            background: url('assets/img/Folder_Opened.png') no-repeat center center;
        }

        td.details-control2 {
            background: url('assets/img/Folder_Closed.png') no-repeat center center !important;
            cursor: pointer;
        }
        tr.details2 td.details-control2 {
            background: url('assets/img/Folder_Opened.png') no-repeat center center;
        }

        .child_table{
            padding: 5px;
            border: 1px #ff0000 solid;
        }

        .glyphicon.spinning {
            animation: spin 1s infinite linear;
            -webkit-animation: spin2 1s infinite linear;
        }
        .select2-container{
            min-width: 100%;
        }
        @keyframes spin {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1) rotate(360deg); }
        }

        @-webkit-keyframes spin2 {
            from { -webkit-transform: rotate(0deg); }
            to { -webkit-transform: rotate(360deg); }
        }

        .numeric{
            text-align: left;
            width: 100%;
        }
        .numeric{
            text-align: left;
            width: 100%;
        }

        .odd{
            background-color: #eeeeee !important;
        }
        .boldlabel1{
            font-weight:bold;
            font-size: 12px;
        }


    </style>
    <?php echo $loaderscript; ?>

</head>

<body class="animated-content">

<?php echo $_top_navigation; ?>

<div id="wrapper">
    <div id="layout-static">

        <?php echo $_side_bar_navigation;?>

        <div class="static-content-wrapper white-bg">
            <div class="static-content" >
                <div class="page-content">

                    <ol class="breadcrumb" style="margin-bottom:0px;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="PaySlip">Payslip</a></li>
                    </ol>



                    <div id="div_dtr_entry" style="display:none;">
                            <div class="panel panel-default">
                                <button class="btn delete"  id="btn_canceldtr" title="back" >
                                    <span class="glyphicon glyphicon-arrow-left"></span></button>
                                    <button class="btn btn-success" id="print_all" title="Print All" >
                                        <span class="glyphicon glyphicon-print"></span>
                                    </button>
                                    <button class="btn btn-primary" id="send_pay_slip" title="Send Pay Slip" >
                                        <span class="glyphicon glyphicon-envelope"></span>
                                    </button>


                                        <div class="panel-heading" style="background-color:#2c3e50 !important;margin-top:2px;">
                                             <h2 style="color:white;font-weight:300;"> PaySlip </h2>
                                             <a href="pdf/payslip.pdf" target="_blank"><i class="fa fa-question-circle help" style="color: white!important; font-size: 15pt!important;float: right;margin-top: 15px!important;" data-toggle="tooltip" data-placement="top" title="Help"></i></a>
                                             <br>
                                             <left><h5 style="color:white;font-weight:400;line-height:1px;margin-top:2px;"><period id="" class="periodcoveredtext"></period></h5></left>
                                              </div>

                                    <div class="panel-body table-responsive" style="padding-top:5px;">
                                        <table id="tbl_process" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Payslip No</th>
                                                    <th>E-CODE</th>
                                                    <th>Fullname</th>
                                                    <th><center>Net Pay</center></th>
                                                    <th><center>Action</center></th>
                                                 </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>

                                <div class="panel-footer"></div>
                            </div> <!--panel default -->

                        </div> <!--list -->

                    </div><!-- .container-fluid -->
                </div> <!-- #page-content -->
            </div><!--static content -->

        </div><!--content wrapper -->
    </div><!--static layout -->
</div> <!--wrapper -->


            <div id="modal_filter" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#27ae60;">
                            <button type="button" style="color:white;" class="close"  data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:white;"><span id="modal_mode"> Select Pay Period (PaySlip) </h4>
                        </div>

                        <div class="modal-body">
                            <form id="frm_search_dtr">
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group" style="margin-bottom:0px;">
                                    <label class="boldlabel">Year : </label>
                                    <select class="form-control" id="year" data-error-msg="This Field is Required!" required>
                                    <?php $minyear=1990; $maxyear=2500;
                                            while($minyear!=$maxyear){
                                                echo '<option value='.$minyear.'>'.$minyear.'</option>';
                                                $minyear++;
                                            }

                                    ?>
                                        <!-- <option value="0">[ Select Year ]</option>
                                        <option value="2009">2009</option>
                                        <option value="2010">2010</option>
                                        <option value="2011">2011</option>
                                        <option value="2012">2012</option>
                                        <option value="2013">2013</option>
                                        <option value="2014">2014</option>
                                        <option value="2015">2015</option>
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>
                                        <option value="2031">2031</option>
                                        <option value="2032">2032</option>
                                        <option value="2033">2033</option>
                                        <option value="2034">2034</option>
                                        <option value="2035">2035</option>
                                        <option value="2036">2036</option>
                                        <option value="2037">2037</option>
                                        <option value="2038">2038</option> -->
                                    </select>
                                </div>
                              </div>
                              <div class="col-md-8">
                                <div class="form-group" style="margin-bottom:0px;">
                                    <label class="boldlabel">Pay Period : </label>
                                    <select id='pay_period' class='form-control' name='emp_leaves_entitlement_id'>

                                </select>
                                </div>
                              </div>
                            </div><br>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group" style="margin-bottom:0px;">
                                    <label class="boldlabel">Period Start:</label>
                                    <input type="text" class="form-control" id="period_start" name="pay_period_start" placeholder="" data-error-msg="This Field is Required!" disabled >
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group" style="margin-bottom:0px;">
                                    <label class="boldlabel">Period End:</label>
                                    <input type="text" class="form-control" id="period_end" name="pay_period_end" placeholder="" data-error-msg="This Field is Required!" disabled >
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group" style="margin-bottom:2px; !important">
                                          <label class="boldlabel" style="margin-bottom:0px;">Department:</label>
                                          <select class="form-control" id="ref_department_id" name="ref_department_id" id="sel1">
                                            <option value="all">All Departments</option>
                                           <?php
                                                                foreach($ref_department as $row)
                                                                {
                                                                    echo '<option value="'.$row->ref_department_id  .'">'.$row->department.'</option>';
                                                                }
                                                                ?>
                                          </select>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group" style="margin-bottom:2px; !important">
                                          <label class="boldlabel" style="margin-bottom:0px;">Branch:</label>
                                          <select class="form-control" id="ref_branch_id" name="ref_branch_id" id="sel1">
                                            <option value="all">All Branch</option>
                                           <?php
                                                                foreach($ref_branch as $row)
                                                                {
                                                                    echo '<option value="'.$row->ref_branch_id  .'">'.$row->branch.'</option>';
                                                                }
                                                                ?>
                                          </select>
                                </div>
                              </div>
                            </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_select_dtr" type="button" class="btn btn-success">Select</button>
                            <button id="btn_close_dtr" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
                </div>
  <!-- Modal -->
  <div class="modal fade" id="modal_show_payslip" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2980b9;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:white;">Pay Slip Of <payslipname id="payslipof"></payslipname></h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid" id="pay_slip_preview" style="overflow:scroll;width:100%;">
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="print_pay_slip" style="background-color:#27ae60;color:white;" class="btn">PRINT</button>
            <!-- <button type="button" id="download_pay_slip" style="background-color:#27ae60;color:white;" class="btn">Download PDF</button> -->
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


    <div id="modal_email_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Send?</h4>
                </div>

                <div class="modal-body">

                    <img src="assets/img/question_mark.png" style="width: 50px; position: absolute;margin-left: 30px;"> 
                    <p id="modal-body-message" style="font-size: 12pt;width: 80%;font-weight: normal!important;margin-left: 100px; font-weight: 400;margin-top: 10px;">Are you sure you want to send payslip of <emp id="empnameemail"></emp>?</p>
                </div>

                <div class="modal-footer">
                    <button id="btn_yes_email" type="button" class="btn btn-success" data-dismiss="modal">Yes</button>
                    <button id="btn_close" type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_email_all_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Send?</h4>
                </div>

                <div class="modal-body">

                    <img src="assets/img/question_mark.png" style="width: 50px; position: absolute;margin-left: 30px;"> 
                    <p id="modal-body-message" style="font-size: 12pt;width: 80%;font-weight: normal!important;margin-left: 100px; font-weight: 400;margin-top: 10px;">Are you sure you want to send all payslip of the employees?</p>
                    <hr>
                    <small><b style="color: red">Note:</b> If the employee does not have an email address on the HR System. It will not send the payslip of that employee. Make sure that all of the email of the employees on this pay period is encoded in the HR System.</small>
                </div>

                <div class="modal-footer">
                    <button id="btn_yes_email_all" type="button" class="btn btn-success" data-dismiss="modal">Yes</button>
                    <button id="btn_close" type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

<?php echo $_rights; ?>
<script>

$(document).ready(function(){
    var dt; var _txnMode; var _txnModeRate;
    var _selectedDateCovered; var _selectedYear; var _periodstart; var _periodend; var _selectedIDDepartment="all"; var _selectedIDBranch="all";
    var _selectedemprate; var _selectedEmpget; var _pusheddata; var _selectRowObjtempdeduct; var _selectedIDtempdeduct;
    var _selectRowObjProcess; var _selectedID; var _selectRowObj; var _year; var _pay_period; var _refdepartment_id; var _refbranch_id;

    var d = new Date();
    var n = d.getFullYear();

    var getDtr=function(){
                    dt_payslip=$('#tbl_process').DataTable({
            "fnInitComplete": function (oSettings, json) {
                $.unblockUI();
                },
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "order": [[ 2, "asc" ]],
            "ajax": {
            "url": "PaySlip/transaction/list",
            "type": "POST",
            "bDestroy": true,
            "data": function ( d ) {
                return $.extend( {}, d, {
                    "pay_period_id": _selectedYear,//id of pay period
                    "ref_department_id": _selectedIDDepartment,
                    "ref_branch_id": _selectedIDBranch
                    } );
                }
            },
            "columns": [
                {
                    "targets": [0],
                    "class":          "pay_slip_show",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "payslip_no", },
                { targets:[2],data: "ecode", },
                { targets:[3],data: "full_name" },
                { targets:[4],data: "net_pay",
                render: $.fn.dataTable.render.number( ',', '.', 2 )
                },
                {
                    targets:[5],
                    render: function (data, type, full, meta){
                        var right_payslip_delete='<button class="btn btn-default btn-sm btndelete" name="remove_payslip" data-toggle="tooltip" data-placement="top" title="Delete PaySlip"><i class="fa fa-trash"></i> </button>';
                        var right_employee_email='<button class="btn btn-default btn-sm btnemail" name="email_payslip" data-toggle="tooltip" data-placement="top" title="Send Payslip"><i class="fa fa-envelope fa-lg"></i> </button>';

                        return '<center>'+right_employee_email+right_payslip_delete+'</center>';
                    }
                }
            ],
            language: {
                         searchPlaceholder: "Search Employee Process"
                     },
            "rowCallback":function( row, data, index ){

                $(row).find('td').eq(4).attr({
                    "align": "right"
                });
            }

        });

    }

    var initializeControls=function(){

        _year=$("#year").select2({
            dropdownParent: $("#modal_filter"),
            placeholder: "Select Year",
            allowClear: false
        });

        _year.val(n).trigger("change");

        _pay_period=$("#pay_period").select2({
            dropdownParent: $("#modal_filter"),
            placeholder: "Select Pay Period",
            allowClear: false
        });

        _refdepartment_id=$("#ref_department_id").select2({
            dropdownParent: $("#modal_filter"),
            placeholder: "Select Department",
            allowClear: false
        });

        _refbranch_id=$("#ref_branch_id").select2({
            dropdownParent: $("#modal_filter"),
            placeholder: "Select Branch",
            allowClear: false
        });


    }();

    var bindEventHandlers=(function(){
        var detailRows = [];
         var detailRows1 = [];

        $('#year').change(function() {
            _selectedYear=$(this).val();
            //alert(_selectedYear);
            getpayperiod().done(function(response){
                        var show2select="";
                        if(response.data.length==0){
                            $('#pay_period').html("<option>No Result</option>");
                            $('#period_start').val("");
                            $('#period_end').val("");
                            return;
                        }
                        var jsoncount=response.data.length-1;
                         for(var i=0;parseInt(jsoncount)>=i;i++){
                            //alert(response.available_leave[i].leave_type);
                            show2select+='<option value='+response.data[i].pay_period_start+'~'+response.data[i].pay_period_end+'~'+response.data[i].pay_period_id+'>'+response.data[i].pay_period_start+' ~ '+response.data[i].pay_period_end+'</option>';
                         }
                         $('#pay_period').html(show2select);
                         var temppayperiod = $('#pay_period').val();
                        var payperiod = temppayperiod.split(/~/)
                        $('#period_start').val(payperiod[0]);
                        $('#period_end').val(payperiod[1]);
                        _selectedYear=payperiod[2];
                        $('.periodcoveredtext').text('Period Covered : '+payperiod[0]+' ~ '+payperiod[1]);

                        /*alert(data.religion);
                        var arr = [];
                        for (var prop in data) {
                            arr.push(data[prop]);
                        }*/
                        //console.
                    }).always(function(){
                        $.unblockUI();
                        $('.modal_file_leave').modal('show');
                    });


            });

        $('#pay_period').change(function() {
            _payperiod=$(this).val();

            //alert(_yearperiod);
            var payperiod = _payperiod.split(/~/)
            $('#period_start').val(payperiod[0]);
            $('#period_end').val(payperiod[1]);
            _selectedYear=payperiod[2];
            $('.periodcoveredtext').text('Period Covered : '+payperiod[0]+' ~ '+payperiod[1]);
            });

        $('#ref_department_id').change(function() {
            _selectedIDDepartment=$(this).val();
            //alert(_selectedIDDepartment);
            });

        $('#ref_branch_id').change(function() {
            _selectedIDBranch=$(this).val();
            //alert(_selectedIDGroup);
            });

                //CREATE NEW EMPLOYEEE


        $('#btn_dtr').click(function(){
             _selectedYear=2016;
            var d = new Date();
            var n = d.getFullYear();
             $('#year').val(n);
            //alert(_selectedYear);
            getpayperiod().done(function(response){
                        var show2select="";
                        if(response.data.length==0){
                            $('#pay_period').html("<option>No Result</option>");
                            $('#period_start').val("");
                            $('#period_end').val("");
                            return;
                        }
                        var jsoncount=response.data.length-1;
                         for(var i=0;parseInt(jsoncount)>=i;i++){
                            //alert(response.available_leave[i].leave_type);
                            show2select+='<option value='+response.data[i].pay_period_start+'~'+response.data[i].pay_period_end+'~'+response.data[i].pay_period_id+'>'+response.data[i].pay_period_start+' ~ '+response.data[i].pay_period_end+'</option>';
                         }
                         $('#pay_period').html(show2select);
                         var temppayperiod = $('#pay_period').val();
                        var payperiod = temppayperiod.split(/~/)
                        $('#period_start').val(payperiod[0]);
                        $('#period_end').val(payperiod[1]);
                        _selectedYear=payperiod[2];
                        $('.periodcoveredtext').text('Period Covered : '+payperiod[0]+' ~ '+payperiod[1]);

                        /*alert(data.religion);
                        var arr = [];
                        for (var prop in data) {
                            arr.push(data[prop]);
                        }*/
                        //console.
                    }).always(function(){
                        $.unblockUI();
                        $('.modal_file_leave').modal('show');
                    });

            $('#modal_filter').modal('toggle');
            $('#payperiodhere').html("<option>aw</option>"); //noresult for option
        });

        $('#btn_select_dtr').click(function(){
            if(validateRequiredFields($('#frm_search_dtr'))){
            showSpinningProgressLoading();
            //_selectedDateCovered = 'Period Covered: Oct 15, 2016 - Oct 30,2016';
            //$('.periodcoveredtext').text(_selectedDateCovered);
            showdtr();
            getDtr();
            $('#modal_filter').modal('toggle');

        }
        });


        $('#btn_canceldtr').click(function(){
            hidedtr();


            $('#tbl_process').dataTable().fnDestroy();
            $('#tbl_process').fnClearTable();
        });


    })();

    $('#tbl_process tbody').on( 'click', 'tr td.pay_slip_show', function () {
            _selectRowObj=$(this).closest('tr');
            var data=dt_payslip.row(_selectRowObj).data();
            _selectedID=data.pay_slip_id;
            $('#payslipof').text(data.full_name);
            $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"PaySlip/layout/pay-slip/"+ _selectedID+"/0/fullview",
                    beforeSend : function(){
                    $('#pay_slip_preview').html("<center><img src='assets/img/loader/preloaderimg.gif'><h3>Loading...</h3></center>");
                },
                }).done(function(response){
                    $('#pay_slip_preview').html(response);
                });
            //alert(_selectedID);
            $('#modal_show_payslip').modal('toggle');

        } );

    $("#download_pay_slip").click(function(){
            window.location = "PaySlip/layout/pay-slip/"+ _selectedID+"/0/pdf";
        });

    $("#print_all").click(function(){
            window.open('PaySlip/layout/pay-slip-printall/'+_selectedYear+'/'+_selectedIDDepartment+'/'+_selectedIDBranch,'_blank');
    });

    $('#send_pay_slip').click(function(){
        $('#modal_email_all_confirmation').modal('show');
    });

    $('#tbl_process tbody').on('click','button[name="email_payslip"]',function(){
        _selectRowObj=$(this).closest('tr');
        var data=dt_payslip.row(_selectRowObj).data();
        _selectedPayslipID=data.pay_slip_id;
        _selectedName = data.full_name;
        $('#empnameemail').text(_selectedName);
        $('#modal_email_confirmation').modal('show');
    });

    $('#btn_yes_email').click(function(){
        showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

        emailPayslip().done(function(response){
            showNotification(response);
            $.unblockUI();
        });
    });

    $('#btn_yes_email_all').click(function(){
        emailAllPayslip().done(function(response){
            showNotification(response);
        }).always(function(){
            $.unblockUI();
        });
    });

    var emailPayslip=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"PaySlip/layout/emailPayslip/"+_selectedPayslipID,
            "beforeSend": ""
        });
    };

    var emailAllPayslip=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"PaySlip/layout/emailAllPayslip/"+_selectedYear+"/"+_selectedIDDepartment+"/"+_selectedIDBranch,
            "beforeSend": showSpinningProgress()
        });
    };    

    var showSpinningProgress=function(e){
        $.blockUI({ message: '<img src="assets/img/gears.svg"/><br><h4 style="color:#ecf0f1;">Saving Changes...</h4>',
            css: {
            border: 'none',
            padding: '15px',
            backgroundColor: 'none',
            opacity: 1,
            zIndex: 20000,
        } });
        $('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
    };    

    $('#print_pay_slip').click(function(event){
            showinitializeprint();
            var currentURL = window.location.href;
            var output = currentURL.match(/^(.*)\/[^/]*$/)[1];
            output = output+"/assets/css/css_special_files.css";
            $("#pay_slip_preview").printThis({
                debug: false,
                importCSS: true,
                importStyle: false,
                printContainer: false,
                formValues:false,
                printDelay: 1000,
            });
            setTimeout(function() {
                 $.unblockUI();
            }, 1000);

    });

    $('#tbl_process tbody').on('click','button[name="remove_payslip"]',function(){
        _selectRowObj=$(this).closest('tr');
        var data=dt_payslip.row(_selectRowObj).data();
        _selectedID=data.pay_slip_id;
        swal({
        title: "Are you sure?",
        text: "You will not be able to recover this payslip!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel please!",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm){
        if (isConfirm) {
            removePayslip().done(function(response){

          }).always(function(){
            swal("Deleted!", "Payslip has been deleted.", "success");
            dt_payslip.row(_selectRowObj).remove().draw();
            $.unblockUI();
          });
        } else {
          swal("Cancelled", "Payslip is safe :)", "error");
        }
      });
    });

    var removePayslip=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"PaySlip/layout/pay-slip-delete",
            "data":{pay_slip_id : _selectedID},
            "beforeSend": showSpinningProgress($('#'))
        });
    };

    var processPayroll=function(){
        var _data = dt_process_payroll.$('input, select').serialize();
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"DailyTimeRecord/transaction/processpayroll",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save_temp_deduction'))
        });
    };

    var getpayperiod=function(){

        var _data=$('#').serializeArray();
        _data.push({name : "year" ,value : _selectedYear});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"RefPayPeriodSetup/transaction/getpayperiod",
            "data":_data,
            "beforeSend": showSpinningProgressLoading()
        });
    };

    var showdtr=function(){
        $('#div_dtr_entry').show();
    };

    var hidedtr=function(){
        $('#div_dtr_entry').hide();
        $('#modal_filter').modal('toggle');
    };

    var validateRequiredFields=function(f){
        var stat=true;

        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',f).each(function(){

                if($(this).is('select')){
                if($(this).val()==0){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }

                }else{
                if($(this).val()==""){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }
            }




        });

        return stat;
    };

    var showNotification=function(obj){
        PNotify.removeAll();
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };

        $('.date-picker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true

        });

    var showSpinningProgress=function(e){
        $.blockUI({ message: '<img src="assets/img/gears.svg"/><br><h4 style="color:#ecf0f1;">Sending Email...</h4>',
            css: {
            border: 'none',
            padding: '15px',
            backgroundColor: 'none',
            opacity: 1,
            zIndex: 20000,
        } });
        $('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
    };

    var showSpinningProgressLoading=function(e){
        $.blockUI({ message: '<img src="assets/img/gears.svg"/><br><h4 style="color:#ecf0f1;">Loading Data...</h4>',
            css: {
            border: 'none',
            padding: '15px',
            backgroundColor: 'none',
            opacity: 1,
            zIndex: 20000,
        } });
        $('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
    };

    var showSpinningProgressUpload=function(e){
        $.blockUI({ message: '<img src="assets/img/gears.svg"/><br><h4 style="color:#ecf0f1;">Uploading Image...</h4>',
            css: {
            border: 'none',
            padding: '15px',
            backgroundColor: 'none',
            opacity: 1,
            zIndex: 20000,
        } });
        $('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
    };

    var clearFields=function(f){
        $('input,textarea',f).val('');
        $(f).find('input:first').focus();
    };


        var d = new Date();
        var n = d.getFullYear();
        $('#year').val(n);
        _selectedYear=n;
        getpayperiod().done(function(response){
                        var show2select="";
                        if(response.data.length==0){
                            $('#pay_period').html("<option>No Result</option>");
                            $('#period_start').val("");
                            $('#period_end').val("");
                            return;
                        }
                        var jsoncount=response.data.length-1;
                         for(var i=0;parseInt(jsoncount)>=i;i++){
                            //alert(response.available_leave[i].leave_type);
                            show2select+='<option value='+response.data[i].pay_period_start+'~'+response.data[i].pay_period_end+'~'+response.data[i].pay_period_id+'>'+response.data[i].pay_period_start+' ~ '+response.data[i].pay_period_end+'</option>';
                         }
                         $('#pay_period').html(show2select);
                         var temppayperiod = $('#pay_period').val();
                        var payperiod = temppayperiod.split(/~/)
                        $('#period_start').val(payperiod[0]);
                        $('#period_end').val(payperiod[1]);
                        _selectedYear=payperiod[2];
                        $('.periodcoveredtext').text('Period Covered : '+payperiod[0]+' ~ '+payperiod[1]);

                        /*alert(data.religion);
                        var arr = [];
                        for (var prop in data) {
                            arr.push(data[prop]);
                        }*/
                        //console.
                    }).always(function(){
                        $.unblockUI();
                        $('#modal_filter').modal('toggle');
                    });



   /* $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });*/


    // apply input changes, which were done outside the plugin
    //$('input:radio').iCheck('update');

});

</script>
</body>

</html>
