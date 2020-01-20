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



    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">              <!-- iCheck -->
    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/_all.css" rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->

    <link href="assets/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <link href="assets/plugins/select2/select2.min.css" rel="stylesheet">


    <?php echo $_switcher_settings; ?>
    <?php echo $_def_js_files; ?>

<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>

<!-- Date range use moment.js same as full calendar plugin -->

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
                        <li><a href="EmployeeLedgers">Employee Ledgers</a></li>
                    </ol>

                    <div class="container-fluid">

                        <div id="div_2316_list">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color:#2c3e50 !important;margin-top:2px;">
                                     <center><h2 style="color:white;font-weight:300;">Employee Ledgers</h2></center>
                                     <a href="pdf/employee_ledger.pdf" target="_blank"><i class="fa fa-question-circle help" style="color: white!important; font-size: 15pt!important;float: right;margin-top: 15px!important;" data-toggle="tooltip" data-placement="top" title="Help"></i></a>
                                </div>
                                <div class="panel-body table-responsive">
                                    <div style="margin: 20px;">
                                      <div class="row">
                                        <div class="col-md-3">
                                            <label style="font-weight: bold;" for="inputEmail1">Employee :</label>
                                            <select class="form-control" name="employee_filter" id="employee_filter" data-error-msg="Employee Filter is required" required>
                                              <?php
                                                  foreach($employee as $employees)
                                                  { ?>
                                                  <option value="<?php echo $employees->employee_id; ?>">
                                                    <?php echo $employees->full_name; ?>
                                                  </option>
                                              <?php } ?>
                                            </select> <br />
                                            <button type="button" class="btn col-sm-12 form-control" id="print_employee_ledger" style="background-color:#27ae60; color:white;margin-top: 10px;">
                                                <i class="fa fa-print"></i> PRINT
                                            </button>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-weight: bold;" for="inputEmail1">Loan Type :</label>
                                            <select class="form-control" name="sss_loan_filter" id="sss_loan_filter" data-error-msg="Loan is required" required>
                                              <?php
                                                  $deduction_loan = $this->db->query('SELECT deduction_id,deduction_desc FROM refdeduction WHERE deduction_id!=1
                                                  AND deduction_id!=2 AND deduction_id!=3 AND deduction_id!=4');
                                                  foreach($deduction_loan->result() as $loans){ ?>
                                                      <option value="<?php echo $loans->deduction_id; ?>">
                                                        <?php echo $loans->deduction_desc; ?>
                                                      </option>
                                              <?php } ?>
                                            </select>
                                        </div>    
                                        <div class="col-md-3">
                                            <label style="font-weight: bold;" for="inputEmail1">Period Start :</label>
                                            <div class="input-group">
                                                <input type="text" id="date_from" name="date_from" class="date-picker form-control" value="01/01/<?php echo date("Y"); ?>">
                                                 <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                 </span>
                                            </div>
                                        </div>    
                                        <div class="col-md-3">
                                            <label style="font-weight: bold;" for="inputEmail1">Period End :</label>
                                            <div class="input-group">
                                                <input type="text" id="date_to" name="date_to" class="date-picker form-control" value="<?php echo date("m/d/Y"); ?>">
                                                 <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                 </span>
                                            </div>
                                        </div>                 
                                      </div>
<!--                                       <div class="row">
                                        
                                        <div class="col-md-4">
                                            <label class="label label-success" style="font-size: 9pt!important;">Active Deduction</label>
                                            <h4>Loan Amount : <totalloanamount id="totalloanamount"style="color:#27ae60;"></totalloanamount></h4>
                                            <h4>Deduct Per Pay : <deductperpay id="deductperpay" style="color:#c0392b;"></deductperpay></h4>
                                            <h4>Loan Balance : <loanbalance id="loanbalance" style="color:#2980b9;"></loanbalance></h4>
                                        </div>     
                                      </div> -->
                                    </div>
                                  </div>
                                    <hr>
                                    <div id="p_preview" style="overflow: scroll;">
                                    </div>
                                </div>

                                <div class="panel-footer"></div>
                            </div> <!--panel default -->
                        </div>

                    </div><!-- .container-fluid -->
                </div> <!-- #page-content -->
            </div><!--static content -->

        </div><!--content wrapper -->
    </div><!--static layout -->
</div> <!--wrapper -->

<?php echo $_rights; ?>
<script>

$(document).ready(function(){
    var _employee;
    var _sss_loan;

    _employee=$("#employee_filter").select2({
        /*dropdownParent: $("#modal_create_schedule"),*/
        placeholder: "Select Employee",
        allowClear: false
    });
    _employee.select2('val', '');

    _sss_loan=$("#sss_loan_filter").select2({
        /*dropdownParent: $("#modal_create_schedule"),*/
        placeholder: "Select SSS Loan",
        allowClear: false
    });
    _sss_loan.select2('val', '');


    var format_date = function(date){

        var formattedDate = new Date(date);
        var d = formattedDate.getDate();
        var m =  formattedDate.getMonth();
        m += 1;  // JavaScript months are 0-11
        var y = formattedDate.getFullYear();
        return date = y+'-'+m+'-'+d;

    };

    var process_ledger = function(){

    filter_employee_loan = $('#employee_filter').val();
    filter_loan_type = $('#sss_loan_filter').val();

    period_start = format_date($('#date_from').val());
    period_end = format_date($('#date_to').val());

    //Load Page Loan Amount
    $.ajax({
        "dataType":"html",
        "type":"POST",
        "url":"PayrollReports/payrollreports/payroll-loan-amount-get/"+filter_employee_loan+"/"+filter_loan_type,
        beforeSend : function(){
                    $('#p_preview').html("<center><img src='assets/img/loader/preloaderimg.gif'><h3>Loading...</h3></center>");
                },
            }).done(function(response){
                var json = JSON.parse(response);
                /*alert(json.total_loan_amount);*/
                $('#totalloanamount').text(accounting.formatNumber(json.total_loan_amount,2));
                $('#deductperpay').text(accounting.formatNumber(json.deduction_per_pay_amount,2));
                $('#loanbalance').text(accounting.formatNumber(json.balance,2));
            });

    //Load Page Employee Ledger Table
    $.ajax({
        "dataType":"html",
        "type":"POST",
        "url":"PayrollReports/payrollreports/payroll-employee-ledger/"+filter_employee_loan+"/"+filter_loan_type+"/"+period_start+"/"+period_end,
        beforeSend : function(){
                    $('#p_preview').html("<center><img src='assets/img/loader/preloaderimg.gif'><h3>Loading...</h3></center>");
                },
            }).done(function(response){
                $('#p_preview').html(response);
            });

    };

    process_ledger();

    //Employee Ledger Table (Employee Filter change)
    $("#employee_filter").change(function(){
      process_ledger();
    });

    //Employee Ledger Table (SSS Loan Filter change)
    $("#sss_loan_filter").change(function(){
      process_ledger();
    });

    $("#date_from").change(function(){
      process_ledger();
    });    

    $("#date_to").change(function(){
      process_ledger();
    });    


    $('#print_employee_ledger').click(function(event){
            showinitializeprint();
            var currentURL = window.location.href;
            var output = currentURL.match(/^(.*)\/[^/]*$/)[1];
            output = output+"/assets/css/css_special_files.css";
            $("#p_preview").printThis({
                debug: false,
                importCSS: true,
                importStyle: false,
                printContainer: false,
                printDelay: 1000,
                loadCSS: output,
                formValues:true
            });
            setTimeout(function() {
                 $.unblockUI();
            }, 1000);
    });


    var showNotification=function(obj){
        PNotify.removeAll();
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
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

    var clearFields=function(f){
        $('input,textarea',f).val('');
        $(f).find('input:first').focus();
        $("input:checkbox").prop('checked',false);
    };

    $('.date-picker').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true

    });


});

</script>
</body>

</html>
