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
                        <li><a href="SSSReport">SSS Report</a></li>
                    </ol>

                    <div class="container-fluid">

                        <div id="div_2316_list">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color:#2c3e50 !important;margin-top:2px;">
                                     <center><h2 style="color:white;font-weight:300;">SSS Report </h2></center>
                                </div>
                                <div class="panel-body table-responsive">
                                    <div style="margin: 15px;">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label style="font-weight: bold;" for="inputEmail1">Pay Period Year :</label>
                                            <select class="form-control" name="payperiod_filter" id="payperiod_filter" data-error-msg="Pay Period Filter is required" required>
                                              <?php $minyear=2016; $maxyear=2050;
                                                while($minyear!=$maxyear){
                                                    echo '<option value='.$minyear.'>'.$minyear.'</option>';
                                                    $minyear++;
                                                }
                                              ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label style="font-weight: bold;" for="inputEmail1">Month Filter :</label>
                                            <select class="form-control" name="month_filter" id="month_filter" data-error-msg="Month Filter is required" required>
                                                <!-- <option value="all">All</option> -->
                                                <option value="1" <?php if(date('m')==1){ echo 'selected'; } ?>>January</option>
                                                <option value="2" <?php if(date('m')==2){ echo 'selected'; } ?>>February</option>
                                                <option value="3" <?php if(date('m')==3){ echo 'selected'; } ?>>March</option>
                                                <option value="4" <?php if(date('m')==4){ echo 'selected'; } ?>>April</option>
                                                <option value="5" <?php if(date('m')==5){ echo 'selected'; } ?>>May</option>
                                                <option value="6" <?php if(date('m')==6){ echo 'selected'; } ?>>June</option>
                                                <option value="7" <?php if(date('m')==7){ echo 'selected'; } ?>>July</option>
                                                <option value="8" <?php if(date('m')==8){ echo 'selected'; } ?>>August</option>
                                                <option value="9" <?php if(date('m')==9){ echo 'selected'; } ?>>September</option>
                                                <option value="10" <?php if(date('m')==10){ echo 'selected'; } ?>>October</option>
                                                <option value="11" <?php if(date('m')==11){ echo 'selected'; } ?>>November</option>
                                                <option value="12" <?php if(date('m')==12){ echo 'selected'; } ?>>December</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label style="font-weight: bold;" for="inputEmail1">Branch Filter:</label>
                                            <select class="form-control" name="branch_filter_list" id="branch_filter_list" data-error-msg="Branch Filter is required" required>
                                            <option value="all">All</option>
                                            <?php
                                                foreach($branch as $branch){ ?>
                                                    <option value="<?php echo $branch->ref_branch_id; ?>">
                                                        <?php echo $branch->branch; ?>
                                                    </option>
                                                       <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label style="font-weight: bold;" for="inputEmail1">Type Filter:</label>
                                            <select class="form-control" name="type_filter_list" id="type_filter_list" data-error-msg="Type Filter is required" required>
                                                <option value="1">SSS Deducted</option>
                                                <option value="2">Deduction (ADJ)</option>
                                                <option value="3">SSS Actual Deduction</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn col-sm-12 form-control" id="print_sss_list" style="background-color:#27ae60; color:white;width: 100px;margin-top: 25px;">
                                                <i class="fa fa-print"></i> PRINT
                                            </button>
                                            <button type="button" class="btn col-sm-12 btn-primary form-control" id="export_sss_list" style="color:white;margin-top: 25px;width: auto;margin-left: 5px;">
                                                <i class="fa fa-file-excel-o"></i> EXPORT EXCEL
                                            </button>
                                            <button type="button" class="btn col-sm-12 btn-info form-control" id="email_sss_list" style="color:white;margin-top: 25px; width: 100px;margin-left: 5px;">
                                                <i class="fa fa-envelope"></i> EMAIL
                                            </button>
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


<?php echo $_rights; ?>
<script>

$(document).ready(function(){
    var _branch;
    var _payperiod;
    var _month;
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
    $('#payperiod_filter').val(d.getFullYear()).trigger("change")

    _month=$("#month_filter").select2({
        /*dropdownParent: $("#modal_create_schedule"),*/
        placeholder: "Select Month",
        allowClear: false
    });

    $('#month_filter').val(d.getMonth()+1).trigger("change");

    _type=$("#type_filter_list").select2({
        /*dropdownParent: $("#modal_create_schedule"),*/
        placeholder: "Select Type",
        allowClear: false
    });

    _type.select2('val', '');


    filter_pay_period = $('#payperiod_filter').val();
    filter_branch = $('#branch_filter_list').val();
    filter_month = $('#month_filter').val();
    filter_type = $('#type_filter_list').val();

    $.ajax({
        "dataType":"html",
        "type":"POST",
        "url":"Hris_Reports/reports/sss-list/"+filter_branch+"/"+filter_month+"/"+filter_pay_period+"/"+filter_type,
        beforeSend : function(){
                    $('#p_preview').html("<center><img src='assets/img/loader/preloaderimg.gif'><h3>Loading...</h3></center>");
                },
            }).done(function(response){
                $('#p_preview').html(response);
            });

    $("#branch_filter_list").change(function(){
        filter_pay_period = $('#payperiod_filter').val();
        filter_branch = $('#branch_filter_list').val();
        filter_month = $('#month_filter').val();
        filter_type = $('#type_filter_list').val();
            $.ajax({
            "dataType":"html",
            "type":"POST",
            "url":"Hris_Reports/reports/sss-list/"+filter_branch+"/"+filter_month+"/"+filter_pay_period+"/"+filter_type,
            beforeSend : showSpinningProgressLoading(),
                }).done(function(response){
                    $.unblockUI();
                    $('#p_preview').html(response);
                });
    });

    $("#payperiod_filter").change(function(){
        filter_pay_period = $('#payperiod_filter').val();
        filter_branch = $('#branch_filter_list').val();
        filter_month = $('#month_filter').val();
        filter_type = $('#type_filter_list').val();

            $.ajax({
            "dataType":"html",
            "type":"POST",
            "url":"Hris_Reports/reports/sss-list/"+filter_branch+"/"+filter_month+"/"+filter_pay_period+"/"+filter_type,
            beforeSend : showSpinningProgressLoading(),
                }).done(function(response){
                    $.unblockUI();
                    $('#p_preview').html(response);
                });
    });

        $("#month_filter").change(function(){
        filter_pay_period = $('#payperiod_filter').val();
        filter_branch = $('#branch_filter_list').val();
        filter_month = $('#month_filter').val();
        filter_type = $('#type_filter_list').val();

            $.ajax({
            "dataType":"html",
            "type":"POST",
            "url":"Hris_Reports/reports/sss-list/"+filter_branch+"/"+filter_month+"/"+filter_pay_period+"/"+filter_type,
            beforeSend : showSpinningProgressLoading(),
                }).done(function(response){
                    $.unblockUI();
                    $('#p_preview').html(response);
                });
    });


        $("#type_filter_list").change(function(){
        filter_pay_period = $('#payperiod_filter').val();
        filter_branch = $('#branch_filter_list').val();
        filter_month = $('#month_filter').val();
        filter_type = $('#type_filter_list').val();

            $.ajax({
            "dataType":"html",
            "type":"POST",
            "url":"Hris_Reports/reports/sss-list/"+filter_branch+"/"+filter_month+"/"+filter_pay_period+"/"+filter_type,
            beforeSend : showSpinningProgressLoading(),
                }).done(function(response){
                    $.unblockUI();
                    $('#p_preview').html(response);
                });
    });        

    $('#print_sss_list').click(function(event){
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

 $('#export_sss_list').on('click', function() {
        filter_pay_period = $('#payperiod_filter').val();
        filter_branch = $('#branch_filter_list').val();
        filter_month = $('#month_filter').val();
        filter_type = $('#type_filter_list').val();

        window.open("Hris_Reports/reports/export-sss-list/"+filter_branch+"/"+filter_month+"/"+filter_pay_period+"/"+filter_type,"_self");
    });

    $('#email_sss_list').on('click', function() {
        filter_pay_period = $('#payperiod_filter').val();
        filter_branch = $('#branch_filter_list').val();
        filter_month = $('#month_filter').val();
        filter_type = $('#type_filter_list').val();

        showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

        var btn=$(this);

        $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Hris_Reports/reports/email-sss-list/"+filter_branch+"/"+filter_month+"/"+filter_pay_period+"/"+filter_type,
            "beforeSend": showSpinningProgress(btn)
        }).done(function(response){
            showNotification(response);
            showSpinningProgress(btn);

        });
    });

    var showNotification=function(obj){
        PNotify.removeAll();
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });
    };

    var showSpinningProgress=function(e){
        $(e).toggleClass('disabled');
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
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

    var showinitializeprint=function(e){
        $.blockUI({ message: '<img src="assets/img/gears.svg"/><br><h4 style="color:#ecf0f1;">Initializing Printing...</h4>',
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
