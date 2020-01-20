<!DOCTYPE html>

<html lang="en">

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


    <link href="assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
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
            text-align: right;
            width:100% !important;
        }

        .odd{
            background-color:#eeeeee !important;
        }
        .lblchck{
            margin-right: 5px;
            cursor: pointer;
        }
        .cursor{
            cursor: pointer;
            font-size: 11pt;
        }

        .cursor:hover{
            background: #FFF59D;
        }

        #deduction_cycle_row{
            height: 300px;
            max-height: 300px;
            min-height: 300px;
            overflow-y: scroll;
        }
        .chckbx{
            width:20px;
            height:20px;
        }
        #tbl_deduction_regular_list td:nth-child(6),#tbl_deduction_regular_list td:nth-child(7),#tbl_deduction_regular_list td:nth-child(8){
            text-align: right;
        }    
        #deduction_view_cycle_row{
            font-size: 12pt;
            max-height: 300px!important;
            overflow: auto;
        }    
        hr.hr_row{
            padding: 5px!important;
            margin: 5px!important;
            border-top: 1px solid lightgray;
        }
    </style>

<script type="text/javascript">
    // $(window).load(function(){
    //     setTimeout(function() {
    //         $('#loading').fadeOut( 400, "linear" );
    //     }, 300);
    // });
</script>
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
<script src="assets/js/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>

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

<?php echo $loaderscript; ?>
</head>

<body class="animated-content">
<?php echo $loader; ?>
<?php echo $_top_navigation; ?>

<div id="wrapper">
    <div id="layout-static">

        <?php echo $_side_bar_navigation;?>

        <div class="static-content-wrapper white-bg">
            <div class="static-content" >
                <div class="page-content">

                    <ol class="breadcrumb" style="margin-bottom:0px;">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li><a href="RegularDeduction">Deduction Regular</a></li>
                    </ol>

                    <div class="container-fluid">

                        <div id="div_product_list">
                            <div class="panel panel-default">
                                        <button class="btn right_regdeduction_create"  id="btn_new" style="width:240px;background-color:#2ecc71;color:white;" title="Create New Deduction Regular" >
                                        <i class="fa fa-file"></i> New Deduction Regular</button>
                                        <div class="panel-heading" style="background-color:#2c3e50 !important;margin-top:2px;">
                                             <center><h2 style="color:white;font-weight:300;">Deduction Regular</h2></center>
                                        </div>
                                    <div class="panel-body table-responsive" style="padding:0px;">
                                        <table id="tbl_deduction_regular_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Period</th>
                                                    <th>ECode</th>
                                                    <th>Full Name</th>
                                                    <th>Description</th>
                                                    <th>Type</th>
                                                    <th style="text-align: right;">Beg. Balance</th>
                                                    <th style="text-align: right;">Deduct Per Pay</th>
                                                    <th style="text-align: right;">Balance</th>
                                                    <th>Starting Date</th>
                                                    <th>Ending Date</th>
                                                    <th>Remarks</th>
                                                    <th>Status</th>
                                                    <th style="width: 60px;"><center>Action</center></th>
                                                    <th>ID</th>
                                                 </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>

                                <div class="panel-footer"></div>
                            </div> <!--panel default -->

                        </div> <!--rates and duties list -->
                    </div><!-- .container-fluid -->
                </div> <!-- #page-content -->
            </div><!--static content -->

        </div><!--content wrapper -->
    </div><!--static layout -->
</div> <!--wrapper -->

            <div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content"><!---content-->
                        <div class="modal-header">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Deletion</h4>
                        </div>

                        <div class="modal-body">
                            <p id="modal-body-message">Are you sure ?</p>
                        </div>

                        <div class="modal-footer">
                            <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                            <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div><!---content-->
                </div>
                </div>
            </div><!---modal-->
            <div id="modal_create_Deduction_Regular" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#2ecc71;">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"> </span>Deduction Regular : <transactmode id="transactmode"></transactmode></h4>
                        </div>

                        <div class="modal-body">
                            <form id="frm_deduction_regular">
                                <div class="container" style="width:100% !important;">
                                    <div class="form-group">
                                        <label class="col-sm-4 inlinecustomlabel" for="inputEmail1">
                                            <i class="red">*</i> Employee :
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="employee_id" id="employee_id" data-error-msg="Please Select Employee" required>
                                            <option value="">[ Select Employee ]</option>
                                           <?php
                                                                foreach($employee_list as $row)
                                                                {
                                                                    echo '<option value="'.$row->employee_id  .'">'.$row->ecode.'&nbsp&nbsp&nbsp&nbsp'.$row->full_name.'</option>';
                                                                }
                                                                ?>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-4 inlinecustomlabel" for="inputPassword1"><i class="red">*</i> Deduction Desc :</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="deduction_id" name="deduction_id" data-error-msg="Deduction Type is Required!" required>
                                            <option value="">[ Select Deduction Type ]</option>
                                            <?php
                                                foreach($refdeduction as $row)
                                                {
                                                    echo '<option value="'. $row->deduction_id  .'">'. $row->deduction_desc .'</option>';
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
<!--                                     <div class="form-group">
                                      <label class="col-sm-4 inlinecustomlabel" for="inputPassword1">Deduction Cycle :</label>
                                        <div class="col-sm-8">
                                        <button type="button" class="btn btn-default" id="btn_deduction_cycle">
                                            <i class="fa fa-cog"></i>
                                        </button>
                                        </div>
                                    </div> -->


                                    <div class="form-group">
                                      <label class="col-sm-4 inlinecustomlabel" for="inputPassword1"><i class="red">*</i> Starting Date :</label>
                                        <div class="col-sm-8">
                                            <input class="form-control date-picker" id="starting_date" name="starting_date" placeholder="Starting Date" data-error-msg="Starting Date is Required!" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-4 inlinecustomlabel" for="inputPassword1"><i class="red">*</i> Ending Date :</label>
                                        <div class="col-sm-8">
                                            <input class="form-control date-picker" id="ending_date" name="ending_date" placeholder="Ending Date" data-error-msg="Ending Date is Required!" required>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                      <label class="col-sm-4 inlinecustomlabel" for="inputPassword1"><i class="red">*</i> Beginning Balance :</label>
                                        <div class="col-sm-8">
                                            <input class="form-control numeric" id="deduction_total_amount" name="deduction_total_amount" placeholder="Beginning Balance" data-error-msg="Beginning Balance is Required!" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-4 inlinecustomlabel" for="inputPassword1"><i class="red">*</i> Deduction Per Pay :</label>
                                        <div class="col-sm-8">
                                           <input class="form-control numeric" id="deduction_per_pay_amount" name="deduction_per_pay_amount" placeholder="Deduction Per Pay" data-error-msg="Deduction Description is Required!" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-4 inlinecustomlabel" for="inputPassword1">Balance :</label>
                                        <div class="col-sm-8">
                                           <input class="form-control numeric" id="balance" name="balance" placeholder="Balance" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-4 inlinecustomlabel" for="inputPassword1">Remarks :</label>
                                        <div class="col-sm-8">
                                           <textarea class="form-control" id="remarks" name="deduction_regular_remarks" rows="3" data-error-msg="Remarks is Required!"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-4 inlinecustomlabel" for="inputPassword1">Status :</label>
                                        <div class="col-sm-8">
                                           <select class="form-control" id="deduction_status_id" name="deduction_status_id" required data-error-msg="Status is Required!">
                                                <?php foreach($status as $status){?>
                                                    <option value="<?php echo $status->status_id; ?>">
                                                        <?php echo $status->status; ?>
                                                    </option>
                                                <?php } ?>
                                           </select>    
                                        </div>
                                    </div>
                                  </form>
                                  <hr>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="btn_create" type="button" class="btn" style="background-color:#2ecc71;color:white;">Save</button>
                            <button id="btn_cancel" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div><!---content-->
                </div>
            </div><!---modal-->

            <div id="modal_deduction_cycle" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content"><!---content-->
                        <div class="modal-header" style="border-bottom: 5px solid lightgray;">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="font-size: 12pt;">
                                Deduction Cycle <employeename id="employeename"></employeename>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <center>
                            <form id="frm_deduction_cycle">
                                <div id="deduction_cycle_row">
                                    <?php foreach($refpayperiod AS $row){?>
                                    <div style="">
                                        <input type="checkbox" name="refpayperiod[]" class="cursor chckbx" id="<?php echo $row->pay_period_id; ?>" value="<?php echo $row->pay_period_id; ?>">
                                        <label for="<?php echo $row->pay_period_id; ?>" class="cursor" style="margin-top: -5px!important;border: 1px solid lightgray;padding: 5px;">
                                            <?php echo $row->payperiod_desc; ?>
                                        </label>
                                    </div>
                                    <?php }?>
                                </div>
                            </form>
                            </center>
                        </div>
                        <div class="modal-footer">
                                 <div class="col-md-12">
                                     <button id="btn_close" style="width: 100%!important;" type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                                 </div>
                        </div>
                    </div><!---content-->
                </div>
                </div>
            </div><!---modal-->

            <div id="modal_view_deduction_cycle" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-sm">
                    <div class="modal-content"><!---content-->
                        <div class="modal-header" style="border-bottom: 5px solid lightgray;">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="font-size: 12pt;">
                                Deduction Cycle <br /><viewemployeename id="viewemployeename"></viewemployeename>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <center>
                                <form id="frm_deduction_cycle">
                                    <div id="deduction_view_cycle_row"></div>
                                </form>
                            </center>
                        </div>
                        <div class="modal-footer">
                             <div class="col-md-12">
                                 <button id="btn_close" style="width: 100%!important;" type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                             </div>
                        </div>
                    </div><!---content-->
                </div>
            </div><!---modal-->

<?php echo $_rights; ?>
<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _selectedEmployee;
    var _selectedEID=0; var _selectedDID=0;

    var initializeControls=function(){
        dt=$('#tbl_deduction_regular_list').DataTable({
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            // "bStateSave": true,
            // "fnStateSave": function (oSettings, oData) {
            //     localStorage.setItem('DataTables_' + window.location.pathname, JSON.stringify(oData));
            // },
            // "fnStateLoad": function (oSettings) {
            //     var data = localStorage.getItem('DataTables_' + window.location.pathname);
            //     return JSON.parse(data);
            // },
            "order": [[ 13, "desc" ]],
            "ajax" : "RegularDeduction/transaction/list",
            "columns": [
                { targets:[0],data: "deduction_cycle",
                    render: function (data, type, full, meta){
                        return '<center><button class="btn btn-default" id="btn_view" name="view_info" data-toggle="tooltip" title="View Deduction Cycle"><i class="fa fa-ellipsis-h"></i></button></center>';
                    }
                },
                { targets:[1],data: "ecode" },
                { targets:[2],data: "full_name" },
                { targets:[3],data: "deduction_desc" },
                { targets:[4],data: "deduction_type_desc" },
                { targets:[5],data: "loan_total_amount",
                    render: function(data, type, full, meta){
                        return accounting.formatNumber(data,2);
                    }
                },
                { targets:[6],data: "deduction_per_pay_amount",
                    render: function(data, type, full, meta){
                        return accounting.formatNumber(data,2);
                    }
                },
                { targets:[7],data: "deduction_total_amount",
                    render: function(data, type, full, meta){
                        return accounting.formatNumber(data,2);
                    }
                },
                { targets:[8],data: "starting_date" },
                { targets:[9],data: "ending_date" },
                { targets:[10],data: "deduction_regular_remarks" },
                {
                    targets:[11], data:null,
                    render: function (data, type, full, meta){

                        if (data.deduction_status_id == 1){
                            return '<center><i class="fa fa-check-circle" style="color: green;"></i></center>';
                        }else{
                            return '<center><i class="fa fa-times-circle" style="color: red;"></i></center>';
                        }

                    }
                },
                {
                    targets:[12],
                    render: function (data, type, full, meta){

                        return '<center>'+right_regdeduction_edit+right_regdeduction_delete+'</center>';
                    }
                },
                { targets:[13],data: "deduction_regular_id",visible:false }
            ],
            language: {
                         searchPlaceholder: "Search Deduction Regular"
                     },
        });

        $('.numeric').autoNumeric('init');
        
        _employees=$("#employee_id").select2({
            dropdownParent: $("#modal_create_Deduction_Regular"),
            placeholder: "Select Employee",
            allowClear: false
        });

        _employees.select2('val', null);

        _deduction=$("#deduction_id").select2({
            dropdownParent: $("#modal_create_Deduction_Regular"),
            placeholder: "Select Deduction",
            allowClear: false
        });

        _deduction.select2('val', null);

    }();


    var bindEventHandlers=(function(){
        var detailRows = [];

        $('#tbl_deduction_regular_list tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );

                row.child( format( row.data() ) ).show();

                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        } );


        $('#tbl_deduction_regular_list tbody').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";
            $('#transactmode').text('Edit');
            $('#modal_create_Deduction_Regular').modal('show');
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.deduction_regular_id;
            _selectedEmployee=data.full_name;

            _selectedEID = data.employee_id;
            _selectedDID = data.deduction_id;

            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value);
                    }
                });
            });

            $('#employee_id').prop({ disabled : true });
            $('#deduction_id').prop({ disabled : true });

            $('#deduction_regular_id').val(data.deduction_regular_id);
            $('#employee_id').val(data.employee_id).trigger("change");

            $('#deduction_id').val(data.deduction_id).trigger("change");
            $('#deduction_cycle').val(data.deduction_cycle);

            $('#deduction_status_id').val(data.deduction_status_id);

            $('#deduction_total_amount').val(Math.round(data.loan_total_amount).toFixed(2)); // Beginning Balance
            $('#balance').val(Math.round(data.deduction_total_amount).toFixed(2)); // Balance
            $('#deduction_per_pay_amount').val(Math.round(data.deduction_per_pay_amount).toFixed(2));

            getDeductionCycle().done(function(response){
                var cycle_row = response.data;
                $.each(cycle_row,function(i,value){

                    $('#'+value.pay_period_id).prop('checked', true);

                });
            });

            // $("#balance").val($("#deduction_total_amount").val()).change();

        });

        $('#tbl_deduction_regular_list tbody').on('click','button[name="view_info"]',function(){

            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.deduction_regular_id;
            _selectedEmployee=data.full_name;

            getDeductionCycle().done(function(response){
                var rows=response.data;                
                $('#modal_view_deduction_cycle').modal('show');
                $('#viewemployeename').text(_selectedEmployee);
                $('#deduction_view_cycle_row').text('');

                if (rows.length > 0){
                     $.each(rows,function(i,value){

                            if (value.status == 1){
                                $('#deduction_view_cycle_row').append('<i class="fa fa-check-circle green" style=""></i> '+value.payperiod+'<hr class="hr_row" />');
                            }else{
                                $('#deduction_view_cycle_row').append('<i class="fa fa-check-circle" style="color: lightgray;"></i> '+value.payperiod+'<hr class="hr_row" />');
                            }

                    });
                }else{
                    $('#deduction_view_cycle_row').text('No deduction cycle set.');
                }
                
            });
        });

        $('#tbl_deduction_regular_list tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.deduction_regular_id;

            $('#modal_confirmation').modal('show');
        });

        $('#btn_yes').click(function(){
            remove_Deduction_Regular().done(function(response){
                showNotification(response);
                if(response.stat=='error'){
                    $.unblockUI();
                    return;
                }
                dt.row(_selectRowObj).remove().draw();
                $.unblockUI();
            });
        });

        $('#btn_deduction_cycle').click(function(){
            
            $('#modal_deduction_cycle').modal('show');
            $('#deduction_view_cycle_row').text('');
            $('#employeename').text('');

            if (_txnMode == "edit"){
                $('#employeename').text('for '+_selectedEmployee);
                $('input[type="checkbox"]').prop('checked', false);

                getDeductionCycle().done(function(response){
                    var cycle_row = response.data;
                    $.each(cycle_row,function(i,value){

                        $('#'+value.pay_period_id).prop('checked', true);

                    });
                });
            }else{
                getPayPeriod().done(function(response){
                    var rows=response.data;                
                    if (rows.length > 0){

                         $.each(rows,function(i,value){
                               $('#deduction_view_cycle_row').append(newRowItem({
                                        pay_period_id : value.pay_period_id,
                                        payperiod_desc : value.payperiod_desc
                               }));
                         });    

                    }else{
                        $('#deduction_view_cycle_row').text('No deduction cycle set.');
                    }
                });
            }
        });

        var newRowItem = function(d){
            return '<div class="">'+
                            '<input type="checkbox" name="refpayperiod[]" class="cursor chckbx" id="'+d.pay_period_id+'" value="'+d.pay_period_id+'">'+
                            '<?php echo $row->payperiod_desc; ?>'+
                            '<label for="'+d.pay_period_id+'" class="cursor" style="margin-top: -5px!important;border: 1px solid lightgray;padding: 5px;">'+d.payperiod_desc+'</label>'
                    '</div>';
        };

        $('input[name="file_upload[]"]').change(function(event){
            var _files=event.target.files;

            $('#div_img_product').hide();
            $('#div_img_loader').show();

            var data=new FormData();
            $.each(_files,function(key,value){
                data.append(key,value);
            });

            console.log(_files);

            $.ajax({
                url : 'Products/transaction/upload',
                type : "POST",
                data : data,
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(response){
                    $('#div_img_loader').hide();
                    $('#div_img_product').show();
                }
            });
        });

        $("#starting_date").on("change", function(){

            var starting_date = $("#starting_date").val();
            var ending_date = $('#ending_date').val();

            if (Date.parse(starting_date) > Date.parse(ending_date)){
                showNotification({title:"Error!",stat:"error",msg:"Starting date must be before ending date."});
                $('#starting_date').val('');
            }

        });

        $("#ending_date").on("change", function(){

            var starting_date = $("#starting_date").val();
            var ending_date = $('#ending_date').val();

            if (Date.parse(starting_date) > Date.parse(ending_date)){
                showNotification({title:"Error!",stat:"error",msg:"Starting date must be before ending date."});
                $('#starting_date').val('');
                $('#ending_date').val('');
            }

        });     

        $('#btn_new').click(function(){
            _txnMode="new";
            $('#transactmode').text('New');            
            clearFields($('#frm_deduction_regular'));

            $('#employee_id').prop({ disabled : false });
            $('#deduction_id').prop({ disabled : false });

            $('#employee_id').select2('val',0);
            $('#deduction_id').select2('val',0);

            $('#starting_date').val('<?php echo date('m/d/Y');?>');
            $('#ending_date').val('<?php echo date('m/d/Y');?>');
            $('#modal_create_Deduction_Regular').modal('show');

        });


        $('#btn_create').click(function(){
            if(validateRequiredFields($('#frm_deduction_regular'))){
                if(_txnMode==="new"){
                    //alert("aw");

                    create_Deduction_Regular().done(function(response){
                        showNotification(response);
                        if(response.stat=='error'){
                             $.unblockUI();
                            return;
                        }else{
                            dt.row.add(response.row_added[0]).draw();
                            clearFields($('#frm_deduction_regular'));
                            $('#modal_create_Deduction_Regular').modal('toggle');
                        }
                    }).always(function(){
                        $.unblockUI();
                    });
                    return;

                }

                else if(_txnMode==="edit"){
                    //alert("update");
                    update_Deduction_Regular().done(function(response){
                        showNotification(response);
                        if(response.stat=='error'){
                             $.unblockUI();
                            return;
                        }else{
                            dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                            $('#modal_create_Deduction_Regular').modal('toggle');
                        }
                       //clearFields($('#frm_deduction_regular'))
                    }).always(function(){
                        $.unblockUI();
                    });
                    return;
                }
            }
            else{}
        });

    })();

    var validateRequiredFields=function(f){
        var stat=true;

        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',f).each(function(){

                if($(this).is('select')){
                if($(this).val()==0 || $(this).val()==null){
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

    var create_Deduction_Regular=function(){
        var _data = $('#frm_deduction_regular, #frm_deduction_cycle').serializeArray();

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"RegularDeduction/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };


    var update_Deduction_Regular=function(){
        var _data=$('#frm_deduction_regular, #frm_deduction_cycle').serializeArray();

        console.log(_data);
        _data.push({name : "deduction_regular_id" ,value : _selectedID});
        //_data.push({name:"is_inventory",value: $('input[name="is_inventory"]').val()});

        //alert($('input[name="is_inventory"]').val());
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"RegularDeduction/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var remove_Deduction_Regular=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"RegularDeduction/transaction/delete",
            "data":{deduction_regular_id : _selectedID},
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var getDeductionCycle=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"RegularDeduction/transaction/getDeductionCycle",
            "data":{deduction_regular_id : _selectedID}
        });
    };

    var getPayPeriod=function(){

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"RegularDeduction/transaction/getpayperiod"
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

    $('.date-picker').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true

    });

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

    var clearFields=function(f){
        $('input,textarea',f).val('');
    };

    $(document).ready(function(){
        $('#deduction_total_amount').keyup(function(){
          $("#balance").val($("#deduction_total_amount").val()).change();
        });
    });

});

</script>
</body>

</html>
