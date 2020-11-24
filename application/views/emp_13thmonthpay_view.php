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
        td.pay_slip_show {
            background: url('assets/img/show.png') no-repeat center center !important;
            cursor: pointer;
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
                        <li><a href="Emp13thMonthPay">13th Month Pay</a></li>
                    </ol>

                    <div class="container-fluid">

                        <div id="div_2316_list">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color:#2c3e50 !important;margin-top:2px;">
                                     <center><h2 style="color:white;font-weight:300;">13th Month Pay</h2></center>
                                </div>
                                <div class="panel-body table-responsive">
                                    <div style="margin: 20px;">
                                      <div class="row">
                                          <div class="col-md-2">
                                              <label style="font-weight: bold;" for="inputEmail1">Pay Period Year :</label>
                                              <select class="form-control" name="payperiod_filter" id="payperiod_filter" data-error-msg="Pay Period is required" required>
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
                                              <label style="font-weight: bold;" for="inputEmail1">Branch:</label>
                                              <select class="form-control" name="branch_filter_list" id="branch_filter_list" data-error-msg="Branch is required" required>
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
                                              <label style="font-weight: bold;" for="inputEmail1">Department :</label>
                                              <select class="form-control" name="department_filter" id="department_filter" data-error-msg="Department is required" required>
                                                <option value="all">All</option>
                                                <?php
                                                    foreach($departments as $department)
                                                    { ?>
                                                    <option value="<?php echo $department->ref_department_id; ?>">
                                                      <?php echo $department->department; ?>
                                                    </option>
                                                <?php } ?>
                                                ?>
                                              </select>   
                                          </div>
                                          <div class="col-md-2">
                                              <label style="font-weight: bold;" for="inputEmail1">Batch :</label>
                                              <select class="form-control" name="batch_filter" id="batch_filter">
                                                <option value="1">Batch 1</option>
                                                <option value="2">Batch 2</option>
                                                ?>
                                              </select>   
                                          </div>
                                          <div class="col-md-3" >
                                            <br>
                                            <button type="button" class="btn btn-success col-sm-12" id="print_all" style="width: 49%;margin-top: 5px;">
                                                <i class="fa fa-print"></i> Print
                                            </button>
                                            <button type="button" class="btn btn-default col-sm-12" id="email_all" style="width: 49%;margin-left: 4px;margin-top: 5px;">
                                                <i class="fa fa-envelope-o"></i> Email
                                            </button>

                                          </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="panel-body table-responsive" style="padding-top:5px;">
                                        <table id="tbl_13thmonth" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>13th Month No</th>
                                                    <th>E-CODE</th>
                                                    <th>Fullname</th>
                                                    <th><center>13th Month Pay</center></th>
                                                    <th><center>Action</center></th>
                                                 </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
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

    <div class="modal fade" id="modal_show_13thmonth" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color:#2980b9;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:white;">13th Month Pay of <month13thpay id="13thmonthof"></month13thpay></h4>
        </div>
        <div class="modal-body">
          <div id="pay_13thmonth_preview" style="overflow:scroll;width:100%;">
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="print_13thmonth" style="background-color:#27ae60;color:white;" class="btn">PRINT</button>
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
                    <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Send</h4>
                </div>

                <div class="modal-body">

                    <img src="assets/img/question_mark.png" style="width: 50px; position: absolute;margin-left: 30px;"> 
                    <p id="modal-body-message" style="font-size: 12pt;width: 80%;font-weight: normal!important;margin-left: 100px; font-weight: 400;margin-top: 10px;">Are you sure you want to send 13th Month of <emp id="empnameemail"></emp>?</p>
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
                    <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Send</h4>
                </div>

                <div class="modal-body">

                    <img src="assets/img/question_mark.png" style="width: 50px; position: absolute;margin-left: 30px;"> 
                    <p id="modal-body-message" style="font-size: 12pt;width: 80%;font-weight: normal!important;margin-left: 100px; font-weight: 400;margin-top: 10px;">Are you sure you want to send all 13th Month of the employees?</p>
                    <hr>
                    <small><b style="color: red">Note:</b> If the employee do not have an email address on the HR System. It will not send the 13th Month of that employee. Make sure that all of the email of the employees on this period is encoded in the HR System.</small>
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
    var _branch;
    var _payperiod;
    var _department;
    var dt;
    var _selectedemp_13thmonth_id;
    var _selectedName;
    var _batch;
    var d = new Date();

    _branch=$("#branch_filter_list").select2({
        placeholder: "Select Branch",
        allowClear: false
    });

    _payperiod=$("#payperiod_filter").select2({
        placeholder: "Select Period",
        allowClear: false
    });

    _payperiod.select2('val', '');

    _department=$("#department_filter").select2({
        placeholder: "Select Department",
        allowClear: false
    });

    _batch=$("#batch_filter").select2({
        placeholder: "Select Batch",
        allowClear: false
    });    

    $('#payperiod_filter').val(d.getFullYear()).trigger("change")


    var initialize_control = function(){

        dt=$('#tbl_13thmonth').DataTable({
            "fnInitComplete": function (oSettings, json) {
                $.unblockUI();
                },
            "aLengthMenu": [[15, 20, 50, -1], [15, 20, 50, "All"]],
            "order": [[ 3, "asc" ]],
            "ajax": {
            "url": "Emp13thMonthPay/schedule/list",
            "type": "POST",
            "bDestroy": true,
            "data": function ( d ) {
                return $.extend( {}, d, {
                    "year": $('#payperiod_filter').val(),
                    "ref_branch_id": $('#branch_filter_list').val(),
                    "ref_department_id": $('#department_filter').val(),
                    "batch_id": $('#batch_filter').val()
                    });
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
                { targets:[1],data: "emp_13thmonth_no", },
                { targets:[2],data: "ecode", },
                { targets:[3],data: "fullname" },
                { targets:[4],data: "grand_13thmonth_pay",
                render: $.fn.dataTable.render.number( ',', '.', 2 )
                },
                {
                    targets:[5],
                    render: function (data, type, full, meta){
                        var right_employee_email='<button class="btn btn-default btn-sm btnemail" name="email_13thmonth" data-toggle="tooltip" data-placement="top" title="Send 13th Month"><i class="fa fa-envelope fa-lg"></i> </button>';

                        return '<center>'+right_employee_email+'</center>';
                    }
                }
            ],
            language: {
                         searchPlaceholder: "Search 13th Month"
                     },
            "rowCallback":function( row, data, index ){

                $(row).find('td').eq(4).attr({
                    "align": "right"
                });
            }

        });

    }();

    $('#tbl_13thmonth tbody').on( 'click', 'tr td.pay_slip_show', function () {
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.emp_13thmonth_id;

            $('#13thmonthof').text(data.fullname);

            $.ajax({
                    "dataType":"html",
                    "type":"POST",
                    "url":"Emp13thMonthPay/schedule/print_13thmonth/"+ _selectedID+"/0/fullview",
                    beforeSend : function(){
                    $('#pay_13thmonth_preview').html("<center><img src='assets/img/loader/preloaderimg.gif'><h3>Loading...</h3></center>");
                },
                }).done(function(response){
                    $('#pay_13thmonth_preview').html(response);
                });

            $('#modal_show_13thmonth').modal('toggle');

        } );

    $("#branch_filter_list").change(function(){
        dt.ajax.reload( null, false );        
    });

    $("#payperiod_filter").change(function(){
        dt.ajax.reload( null, false );   
    });

    $("#department_filter").change(function(){
        dt.ajax.reload( null, false );   
    });

    $("#batch_filter").change(function(){
        dt.ajax.reload( null, false );   
    });     

    $('#tbl_13thmonth tbody').on('click','button[name="email_13thmonth"]',function(){
        _selectRowObj=$(this).closest('tr');
        var data=dt.row(_selectRowObj).data();

        _selectedemp_13thmonth_id=data.emp_13thmonth_id;
        _selectedName = data.fullname;

        $('#empnameemail').text(_selectedName);
        $('#modal_email_confirmation').modal('show');
    });

    $("#print_all").click(function(){

        var year = $('#payperiod_filter').val();
        var ref_branch_id = $('#branch_filter_list').val();
        var ref_department_id = $('#department_filter').val();
        var batch_id = $('#batch_filter').val();

        window.open('Emp13thMonthPay/schedule/print_13thmonth_all/'+year+'/'+ref_branch_id+'/'+ref_department_id+'/'+batch_id,'_blank');
    });    

    $('#email_all').click(function(){
        $('#modal_email_all_confirmation').modal('show');
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

    $('#print_13thmonth').click(function(event){
            showinitializeprint();
            var currentURL = window.location.href;
            var output = currentURL.match(/^(.*)\/[^/]*$/)[1];
            output = output+"/assets/css/css_special_files.css";
            $("#pay_13thmonth_preview").printThis({
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

    $('#btn_yes_email').click(function(){
        showNotification({title:"Sending!",stat:"info",msg:"Please wait for a few seconds."});

        email13thMonth().done(function(response){
            showNotification(response);
            $.unblockUI();
        });
    });

    $('#btn_yes_email_all').click(function(){
        emailAll13thMonth().done(function(response){
            showNotification(response);
        }).always(function(){
            $.unblockUI();
        });
    });    

    var email13thMonth=function(){

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Emp13thMonthPay/schedule/email13thMonth/"+_selectedemp_13thmonth_id,
            "beforeSend": ""
        });
    };

    var emailAll13thMonth=function(){

        var year = $('#payperiod_filter').val();
        var ref_branch_id = $('#branch_filter_list').val();
        var ref_department_id = $('#department_filter').val();
        var batch_id = $('#batch_filter').val();

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Emp13thMonthPay/schedule/emailAll13thMonth/"+year+"/"+ref_branch_id+"/"+ref_department_id+"/"+batch_id,
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
        $.blockUI({ message: '<img src="assets/img/gears.svg"/><br><h4 style="color:#ecf0f1;">Please wait...<br> Sending 13th Month</h4>',
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
