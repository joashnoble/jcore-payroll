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
                        <li><a href="Employee13thMonthPay">Employee 13 Month Pay</a></li>
                    </ol>

                    <div class="container-fluid">

                        <div id="div_2316_list">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color:#2c3e50 !important;margin-top:2px;">
                                     <center><h2 style="color:white;font-weight:300;">Employee 13 Month Pay</h2></center>
                                </div>
                                <div class="panel-body table-responsive">
                                    <div style="margin: 20px;">
                                      <div class="row">
                                          <div class="col-md-3">
                                              <label style="font-weight: bold;" for="inputEmail1">Pay Period Year :</label>
                                              <select class="form-control" name="payperiod_filter" id="payperiod_filter" data-error-msg="Pay Period Filter is required" required>
                                                <?php $minyear=2013; $maxyear=2100;
                                                    while($minyear!=$maxyear){ ?>
                                                        <option value="<?php echo $minyear; ?>">
                                                          <?php echo $minyear; ?>
                                                        </option>
                                                        <?php echo $minyear++; ?>
                                                <?php } ?>
                                              </select>
                                          </div>
                                          <div class="col-md-3">
                                            <div class="hidden">
                                              <label style="font-weight: bold;" for="inputEmail1">Branch:</label>
                                              <select class="form-control" name="branch_filter_list" id="branch_filter_list" data-error-msg="Branch Filter is required" required>
                                              <?php
                                                  foreach($branch as $branch){ ?>
                                                      <option value="<?php echo $branch->ref_branch_id; ?>">
                                                          <?php echo $branch->branch; ?>
                                                      </option>
                                                         <?php } ?>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="col-md-3">
                                            <div class="hidden">
                                              <label style="font-weight: bold;" for="inputEmail1">Employee :</label>
                                              <select class="form-control" name="employee_filter" id="employee_filter" data-error-msg="Employee Filter is required" required>
                                                <option value="all">All</option>
                                                <?php
                                                    foreach($employee as $employees)
                                                    { ?>
                                                    <option value="<?php echo $employees->employee_id; ?>">
                                                      <?php echo $employees->full_name; ?>
                                                    </option>
                                                <?php } ?>
                                                ?>
                                              </select>                                                
                                            </div>
                                          </div>
                                          <div class="col-md-3">
                                            <button type="button" class="btn btn-default col-sm-12" id="print_13month_pay" style="width: 49%;">
                                                <i class="fa fa-print"></i> Print
                                            </button>
                                            
                                            <button type="button" class="btn btn-default col-sm-12" id="export_13month_pay" style="width: 49%;margin-left: 4px;">
                                                <i class="fa fa-file-excel-o"></i> Export
                                            </button>

                                            <br/>
                                            <div id="process_panel"></div>

                                          </div>
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

<div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title"><span id="modal_mode"> </span>Process 13th Month of year <year id="year"></year></h4>
            </div>

            <div class="modal-body">

                <img src="assets/img/question_mark.png" style="width: 50px; position: absolute;margin-left: 30px;"> 
                <p id="modal-body-message" style="font-size: 12pt;width: 80%;font-weight: normal!important;margin-left: 100px; font-weight: 400;margin-top: 10px;">Are you sure you want to continue processing the 13th Month?</p><br/>
                <center><span style="color: red;"><b>Note :</b><i> Once the Year is processed you cannot reprocess the 13th Month for that specific year.</i></span></center>
            </div>

            <div class="modal-footer">
                <button id="btn_process" type="button" class="btn btn-success" data-dismiss="modal">Process</button>
                <button id="btn_close" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<?php echo $_rights; ?>
<script>

$(document).ready(function(){
    var _branch;
    var _payperiod;
    var _employee;
    var d = new Date();

    _branch=$("#branch_filter_list").select2({
        /*dropdownParent: $("#modal_create_schedule"),*/
        placeholder: "Select Branch",
        allowClear: false
    });

    _branch.select2('val', '');

    _payperiod=$("#payperiod_filter").select2({
        /*dropdownParent: $("#modal_create_schedule"),*/
        placeholder: "Select Period",
        allowClear: false
    });

    _payperiod.select2('val', '');

    _employee=$("#employee_filter").select2({
        /*dropdownParent: $("#modal_create_schedule"),*/
        placeholder: "Select Employee",
        allowClear: false
    });

    _employee.select2('val', '');
    $('#payperiod_filter').val(d.getFullYear()).trigger("change")

    var refresh_process_ele = function(){
        $('#btn_process_13thmonth').click(function(){
            var year = $('#payperiod_filter').val();
            $('#year').html(year);
            $('#modal_confirmation').modal('show');
        });
    };

    var get_13thmonth_pay = function(){
        filter_pay_period = $('#payperiod_filter').val();
        filter_branch = $('#branch_filter_list').val();
        filter_employee = $('#employee_filter').val();

        // Check year if processed
        $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"PayrollHistory/layout/check-13thmonth-pay/"+filter_employee+"/"+filter_pay_period+"/"+filter_branch+"",
                }).done(function(response){
                    $('#process_panel').html("");

                    var rows = response.data;

                    if (rows.length <= 0){
                        $('#process_panel').append('<button type="button" class="btn btn-info col-sm-12" id="btn_process_13thmonth" style="margin-top: 5px;"><i class="fa fa-cog"></i> Process</button>');
                        refresh_process_ele();
                    }else{
                        $('#process_panel').append('<label class="label label-default" style="width: 100%;font-size: 12pt;padding: 5px;margin-top: 10px;"><span class="fa fa-check-circle"></span> <i>Processed</i></label>');
                    }
            });

        $.ajax({
            "dataType":"html",
            "type":"POST",
            "url":"PayrollHistory/layout/employeee-13thmonth-pay/"+filter_employee+"/"+filter_pay_period+"/"+filter_branch+"",
            beforeSend : function(){
                        $('#p_preview').html("<center><img src='assets/img/loader/preloaderimg.gif'><h3>Loading...</h3></center>");
                    },
                }).done(function(response){
                    $('#p_preview').html(response);
            });
    };


    get_13thmonth_pay();

    $("#branch_filter_list").change(function(){
        get_13thmonth_pay();
    });

    $("#payperiod_filter").change(function(){
        get_13thmonth_pay();
    });

    $("#employee_filter").change(function(){
        get_13thmonth_pay();
    });
        
    $('#export_13month_pay').on('click', function() {
        filter_pay_period = $('#payperiod_filter').val();
        filter_branch = $('#branch_filter_list').val();
        filter_employee = $('#employee_filter').val();
        window.open("PayrollHistory/layout/export_employee_13thmonth_pay/"+filter_employee+"/"+filter_pay_period+"/"+filter_branch+"","_self");
    });

    $('#print_13month_pay').click(function(event){
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

    $('#btn_process').click(function(){

        process13thmonth().done(function(response){
            showNotification(response);

            if(response.stat == "success"){
                get_13thmonth_pay();
            }

            $.unblockUI();
        });

    });

    var process13thmonth=function(){
        var _data=$('#').serializeArray();
        _data.push({name : "year" ,value : $('#payperiod_filter').val()});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Employee13thMonthPay/schedule/process_13thmonth",
            "data":_data,
            "beforeSend": showSpinningProgressLoading()
        });
    };    

    var showNotification=function(obj){
        PNotify.removeAll();
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };

    var showSpinningProgressLoading=function(e){
        $.blockUI({ message: '<img src="assets/img/gears.svg"/><br><h4 style="color:#ecf0f1;">Please wait...<br> Processing 13th Month</h4>',
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
      format: "yyyy",
      startView: "year",
      minViewMode: "year",
      autoclose: true
    });

});

</script>
</body>

</html>
