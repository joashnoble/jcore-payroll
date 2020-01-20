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


    <link href="assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

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

        #tbl_clearance_list td.clearance_show {
            cursor: pointer;
        }

        #tbl_clearance_list td.clearance_show:hover {
            color: #0D47A1;
        }

        #tbl_clearance_list td {
            font-weight: 500;
        }    

        #tbl_clearance_list tr:hover {
            color: #0D47A1;
            cursor: pointer;
            font-weight: 500;            
            background: #F5F5F5;
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
            width: 60%;
        }
        #tbl_clearance_form td, #tbl_clearance_dateby td, 
        #tbl_clearance_netotal td, #tbl_clearance_reason td,
        #tbl_clearance_deduction td, #tbl_clearance_cleared td{
            padding: 5px;color: black;
        }
        #tbl_clearance_reason td.td_bold, #tbl_clearance_cleared td.td_bold{
            color: black;font-weight: bold;
        }

        #tbl_clearance_dateby{
            width: 100%;
        }
        .row_clearance_dateby{
            margin-right: 10px;margin-left: 10px;
        }
        #tbl_clearance_deduction th{
            background: #fff; padding: 5px; color: black; border: 1px solid #CFD8DC;
        }
        #tbl_clearance_list td:nth-child(4){
            text-align: right;
        }
        #label_lastpayroll{
            cursor: pointer;
        }
        .red{
            color: red;
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
                        <li><a href="EmployeeClearance">Employee Clearance/Exit</a></li>
                    </ol>

                    <div class="container-fluid">

                        <div id="div_product_list">
                            <div class="panel panel-default">
                                        <button class="btn right_employeeclearance_create"  id="btn_new" style="width:220px;background-color:#2ecc71;color:white;" title="Create New Position" >
                                        <i class="fa fa-file"></i> New Clearance</button>
                                        <div class="panel-heading" style="background-color:#2c3e50 !important;margin-top:2px;">
                                             <center><h2 style="color:white;font-weight:300;"><span class="panel_title"></span></h2></center><br>
                                        </div>
                                    <div class="panel-body table-responsive" style="padding-top:8px;">
                                        <table id="tbl_clearance_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="5%"></th>
                                                    <th>Employee</th>
                                                    <th>Date Cleared</th>
                                                    <th>Net Total</th>
                                                    <th width="10%">Status</th>
                                                    <th><center>Action</center></th>
                                                 </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <div class="row clearance_row" style="margin: 10px;">
                                            <form id="frm_clearance">
                                                <div class="col-md-12" style="margin-bottom: 10px;">
                                                    <div class="form-group">
                                                        <div class="col-md-4">
                                                            <b style="color: black!important;">Name:</b> 
                                                            <div id="employee_panel">
                                                                <select class="form-control" name="employee_id" id="employee_id" data-error-msg="Employee is required.">
                                                                <option value="">[ Select Employee ]</option>
                                                                <?php foreach($employee_clearance as $row) { ?>
                                                                    <option value="<?php echo $row->employee_id;?>" data-position="<?php echo $row->position; ?>" data-dept="<?php echo $row->department; ?>" data-branch="<?php echo $row->branch; ?>" data-ecode="<?php echo $row->ecode; ?>" data-rate="<?php echo $row->salary_reg_rates; ?>"><?php echo $row->full_name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            </div>
                                                            <div id="emp_name_forupdate_panel">
                                                                <input type="text" id="emp_name_forupdate" class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <b style="color: black!important;">Ecode:</b> <input type="text" class="form-control" name="ecode" id="ecode" readonly>
                                                        </div>
                                                        <div class="col-md-2"> 
                                                            <b style="color: black!important;">Department:</b> <input type="text" class="form-control" name="department" id="department" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <b style="color: black!important;">Position:</b> <input type="text" name="position" id="position" class="form-control" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <b style="color: black!important;">Rate:</b> <input type="text" name="rate" id="rate" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="border: 1px solid gray;padding: 10px!important;background: #FAFAFA;">
                                                            <table id="tbl_clearance_form" width="100%">
                                                                <tr>
                                                                    <td width="25%"><br /><b>13th Month Due</b></td>
                                                                    <td><br /><input type="text" class="numeric form-control" name="accumulated_13thmonth_pay" id="accumulated_13thmonth_pay" value="0.00"></td>
                                                                    <td>Add <br /> <input type="text" class="numeric form-control" name="additional_pay" id="additional_pay" value="0.00"></td>
                                                                    <td>Due to Date <br /><input type="text" class="numeric form-control" id="total_due_date" name="total_due_date" readonly value="0.00"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><br /><b>Paid Leave</b></td>
                                                                    <td>No of Day <br /><input type="text" class="form-control" name="no_of_leave" id="no_of_leave" value="0"></td>
                                                                    <td>Total <br /><input type="text" class="numeric form-control" name="leave_pay" id="leave_pay" value="0.00"></td>
                                                                    <td><br /><input type="text" class="numeric form-control" name="total_leave" id="total_leave" readonly value="0.00"></td>
                                                                </tr>   
                                                                <tr>
                                                                    <td><b>Tax - (Refund)</b></td>
                                                                    <td colspan="2"></td>
                                                                    <td><input type="text" class="numeric form-control" name="tax_refund" id="tax_refund" value="0.00"></td>
                                                                </tr>  
                                                                <tr style="background: #F5F5F5;">
                                                                    <td colspan="4">
                                                                        <input type="checkbox" id="chckbox_lastpayroll" style="width: 20px; height: 20px;"> <i id="label_lastpayroll" style="margin-top: 4px!important;position: absolute;margin-left: 5px;">(Include Last Payroll)</i>
                                                                    </td>
                                                                </tr>
                                                                <tr id="last_payroll_panel">
                                                                    <td colspan="3">
                                                                    <b>Last Payroll ( Payslip No: <span id="payslip_no"></span> )</b></td>
                                                                    <td><input type="text" class="numeric form-control" name="last_payroll" id="last_payroll" readonly value="0.00"></td>
                                                                </tr> 
                                                                <tr style="background: #FAFAFA;border: 1px solid #CFD8DC;">
                                                                    <td colspan="3" align="right"><b>Grand Total:</b></td>
                                                                    <td><input type="text" class="numeric form-control" name="grand_total" id="grand_total" readonly value="0.00"></td>
                                                                </tr>                                     
                                                            </table>
                                                        </div>  
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="border: 1px solid gray;padding: 10px!important;background: #FAFAFA;">
                                                            <table id="tbl_clearance_reason" width="100%">
                                                                <tr>
                                                                    <td width="20%" class="td_bold">Date Cleared:</td>
                                                                    <td width="25%"><input type="text" class="date-picker form-control" name="date_cleared" id="date_cleared" required data-error-msg="Date Cleared is required."></td>
                                                                    <td class="td_bold">By:</td>
                                                                    <td>
                                                                        <select class="form-control" name="cleared_by" id="cleared_by" required data-error-msg="Cleared by is required.">
                                                                            <option value="">[ Select Employee ]</option>
                                                                            <?php  foreach($employee_list as $row) { ?>
                                                                                <option value="<?php echo $row->employee_id; ?>"><?php echo $row->full_name; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <table id="tbl_clearance_cleared" width="100%">
                                                                <tr>
                                                                    <td class="td_bold">Reason: </td>
                                                                    <td width="50%">
                                                                        <select class="form-control" name="clearance_reason_id" id="clearance_reason" required data-error-msg="Clearance Reason is required.">
                                                                            <option value="">[ Select Reason ]</option>
                                                                            <option value="newreason">[ Create Clearance Reason ]</option>
                                                                            <?php foreach ($clearance_reason as $row) { ?>
                                                                                <option value="<?php echo $row->clearance_reason_id;?>"><?php echo $row->clearance_description; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <button type="button" class="btn btn-default" id="btn-add-deduction" style="width: 100%;">
                                                                        <i class="fa fa-plus-circle"></i> Add Deduction</button>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <div style="background: #ECEFF1;padding: 10px;min-height: 125px;border: 1px solid #CFD8DC;">
                                                                <table id="tbl_clearance_deduction" width="100%">
                                                                    <thead>
                                                                        <th width="30%">Deduction Description</th>
                                                                        <th width="10%">Amount</th>
                                                                        <th width="5%">Action</th>
                                                                    </tr> 
                                                                    </thead>
                                                                    <tbody>
                                                                   </tbody>
                                                                </table>
                                                            </div>
                                                            <div>
                                                                <table id="tbl_clearance_netotal" width="100%">
                                                                    <tr style="background: #FAFAFA;border: 1px solid #CFD8DC;">
                                                                        <td colspan="3" width="67%" align="right">(Last Pay) <b>Net Total:</b></td>
                                                                        <td><input type="text" name="net_total" id="net_total" class="numeric form-control" readonly value="0.00"></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>

                                <div class="panel-footer">
                                    <div id="footer-panel" style="float: right;margin-right: 20px;">
                                        <button type="button" id="btn_save" class="btn btn-success">Save</button>
                                        <button type="button" class="btn btn-danger" id="btn_cancel_clearance">Cancel</button>
                                    </div>
                                </div>
                            </div> <!--panel default -->

                        </div> <!--rates and duties list -->
                    </div><!-- .container-fluid -->
                </div> <!-- #page-content -->
            </div><!--static content -->

        </div><!--content wrapper -->
    </div><!--static layout -->
</div> <!--wrapper -->

<div id="modal_confirmation" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Deletion <transaction class="transaction_type"></transaction></h4>
            </div>

            <div class="modal-body">
                <p id="modal-body-message">Are you sure?</p>
            </div>

            <div class="modal-footer">
                <button id="btn_yes" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                <button id="btn_close" type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
</div>


<div id="modal_confirm_finalize" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title"><span id="modal_mode"> </span>Confirm Finalize?</h4>
            </div>

            <div class="modal-body">

                <img src="assets/img/question_mark.png" style="width: 50px; position: absolute;margin-left: 30px;"> 
                <p id="modal-body-message" style="font-size: 12pt;width: 80%;font-weight: normal!important;margin-left: 100px; font-weight: 400;margin-top: 10px;">Are you sure to finalize the clearance of <fullname id="emp_full_name"></fullname>?

                    <br /><br />

                <span style="font-size: 10pt;"><b>Note: <i>Once you have finalized the clearance of the employee. You will not be able to update or delete their clearance.</i></b></span>

                </p>
            </div>

            <div class="modal-footer">
                <button id="btn_yes_finalize" type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
                <button id="btn_close_finalize" type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_create_reason" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2ecc71;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"></span> Clearance Reason</h4>
            </div>

            <div class="modal-body">
                <form id="frm_clearance_reason">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group" style="margin-bottom:0px;">
                        <label class="boldlabel"> <span class="red"><b>*</b></span> Description :</label>
                       <input type="text" class="form-control" name="clearance_description" id="clearance_description" placeholder="Clearance Description" required data-error-msg="Description is required!">
                    </div>
                  </div>
                </div><br>
                </form>
            </div>

            <div class="modal-footer">
                <button id="btn_create_reason" type="button" class="btn" style="background-color:#2ecc71;color:white;">Save</button>
                <button id="btn_cancel" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!---content-->
    </div>
</div><!---modal-->
<?php echo $_rights; ?>
<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _isactive=0; var full_name;

    var initializeControls=function(){
        dt=$('#tbl_clearance_list').DataTable({
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "bStateSave": true,
            "ajax" : "EmployeeClearance/transaction/list",
            "columns": [
                {
                    "targets": [0],
                    "class":          "clearance_show",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": "<center><span class='fa fa-print' style='font-size: 18pt;'></span></center>"
                },
                { targets:[1],data: "full_name" },
                { targets:[2],data: "date_cleared" },
                { targets:[3],data: "net_total",
                    render: $.fn.dataTable.render.number( ',', '.', 2, '&#8369; ' )
                },
                { targets:[4],data: null,
                    render: function (data, type, full, meta){

                        if (data.clearance_status == "Finalized"){
                            return '<center><b>'+data.clearance_status+'</b></center>';
                        }else{
                            return '<center>'+right_employeeclearance_finalize+'</center>';
                        }
                    }
                },
                {
                    targets:[5], data: null,
                    render: function (data, type, full, meta){
                        return '<center>'+right_employeeclearance_edit+right_employeeclearance_delete+'</center>';
                    }
                }
            ],

            language: {
                         searchvalue: "Search Clearance"
                     },
            "rowCallback":function( row, data, index ){

            }
        });

        $('.numeric').autoNumeric('init');

        setTimeout(function(){
            $('#footer-panel').hide();
            $('.clearance_row').hide();
        },200);

    }();


    var bindEventHandlers=(function(){
        var detailRows = [];

        $('#tbl_clearance_list tbody').on( 'click', 'tr td.clearance_show', function () {
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.employee_clearance_id;
            window.open('EmployeeClearance/transaction/print_emp_clearance/'+_selectedID+'/','_blank');
        });


        $('#tbl_clearance_list tbody').on('click','button[name="btn_update"]',function(){

            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.employee_clearance_id;
            _clearance_status = data.clearance_status;
            _employee_id = data.employee_id;

            if (_clearance_status == "Finalized"){
                showNotification({title:"Warning!",stat:"error",msg:"Sorry clearance is already finalized."});
            }else{
                _txnMode="edit";
                hide_mode_panel();

                $('input[type=text]').each(function(){
                    var _elem=$(this);
                    $.each(data,function(name,value){
                        if(_elem.attr('name')==name){
                            _elem.val(accounting.formatNumber(value,2));
                        }
                    });
                });

                $('#date_cleared').val(data.date_cleared);

                $('#emp_name_forupdate_panel').show();
                $('#employee_panel').hide();
                $('#employee_id').attr('required', false);

                getEmpInfo(_employee_id).done(function(response){
                    var row = response.data[0];
                    var rowlength = response.data.length;

                    if (rowlength > 0){
                        $('#emp_name_forupdate').val(row.full_name);
                        $('#ecode').val(row.ecode);
                        $('#department').val(row.department); 
                        $('#position').val(row.position);
                        $('#rate').val(row.salary_reg_rates);
                    }

                }).always(function(){
                    $.unblockUI();
                });

                $('#cleared_by').val(data.cleared_by).trigger('change');
                $('#clearance_reason').val(data.clearance_reason_id).trigger('change');

                if (data.include_last_pay == 1){
                    $('#chckbox_lastpayroll').prop('checked', true);
                    $('#last_payroll_panel').show();
                    $('#last_payroll').val(accounting.formatNumber(data.last_payroll,2));

                }else{
                    $('#chckbox_lastpayroll').prop('checked', false);
                    $('#last_payroll_panel').hide();
                }

                getDeductions(_selectedID).done(function(response){
                    var rows=response.data;

                    if (rows.length > 0){

                        $("#tbl_clearance_deduction > tbody").html("");
                        $.each(rows,function(i,value){

                            $('#tbl_clearance_deduction > tbody').append(newRowItemforupdate({
                                deduction_description : value.deduction_description,
                                deduction_amount : value.deduction_amount
                            }));   

                        });
                    }

                }).always(function(){
                    $.unblockUI();
                });


                // $('#no_of_leave').val(data.no_of_leave);
                // $('#accumulated_13thmonth_pay').val(data.accumulated_13thmonth_pay);
                // compute_grand_total();
            }
        });

        $('#tbl_clearance_list tbody').on('click','button[name="btn_finalize"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.employee_clearance_id;
            _selectedEmpID=data.employee_id;
            full_name = data.full_name;
            $('#emp_full_name').text(full_name);
            $('#modal_confirm_finalize').modal('show');
        });

        $('#tbl_clearance_list tbody').on('click','button[name="btn_remove"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.employee_clearance_id;
            _clearance_status = data.clearance_status;

            if (_clearance_status == "Finalized"){
                showNotification({title:"Warning!",stat:"error",msg:"Sorry clearance is already finalized."});
            }else{
                $('#modal_confirmation').modal('show');
            }
        });

        $('#btn_yes').click(function(){
            removeClearance().done(function(response){
                showNotification(response);

                if (response.stat != "Finalized"){
                    dt.row(_selectRowObj).remove().draw();
                }

                $.unblockUI();
            });
        });

        $('#btn_yes_finalize').click(function(){
            finalizeClearance().done(function(response){
                showNotification(response);
                dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                $.unblockUI();
            });
        });

        $('#btn_create_reason').click(function(){

            var btn=$(this);

            if(validateRequiredFields($('#frm_clearance_reason'))){
                var data=$('#frm_clearance_reason').serializeArray();

                $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"RefClearanceReason/transaction/create",
                    "data":data,
                    "beforeSend" : function(){
                        showSpinningProgress(btn);
                    }
                }).done(function(response){
                    showNotification(response);
                    $('#modal_create_reason').modal('hide');

                    var data=response.row_added[0];
                    $('#clearance_reason').append('<option value="'+data.clearance_reason_id+'" selected>'+data.clearance_description+'</option>');
                    $('#clearance_reason').val(data.clearance_reason_id).trigger('change');

                }).always(function(){
                    $.unblockUI();
                });
            }

        });


        $('#btn_new').click(function(){
            _txnMode="new";
            $('#chckbox_lastpayroll').prop('checked', false);
            $('#last_payroll_panel').hide();
            $('#emp_name_forupdate_panel').hide();
            $('#employee_panel').show();
            $('#employee_id').attr('required', true);
            clearFields($('#frm_clearance'));

            getAllemployees().done(function(response){
            var rows=response.data;

                $("#employee_id option").remove();
                $("#employee_id").append('<option value="">[ Select Employee ]</option>');
                $.each(rows,function(i,value){
                   $("#employee_id").append('<option value="'+value.employee_id+'" data-position="'+value.position+'" data-dept="'+value.department+'" data-branch="'+value.branch+'" data-ecode="'+value.ecode+'" data-rate="'+value.salary_reg_rates+'">'+value.full_name+'</option>');
                });
                    $('#employee_id').val("").trigger("change")

            });

            hide_mode_panel();
        });

        $('#btn_cancel_clearance').click(function(){
            show_panel();
        });


        $('#chckbox_lastpayroll').click(function(){
            var stat = $('#chckbox_lastpayroll').is(':checked');
            if(stat == true){
                $('#last_payroll_panel').show(200);
            }else{
                $('#last_payroll_panel').hide(200);
            }

            compute_grand_total();
        });

        $('#label_lastpayroll').click(function(){

            var stat = $('#chckbox_lastpayroll').is(':checked');

            if(stat == false){
                $('#chckbox_lastpayroll').prop('checked', true);
                $('#last_payroll_panel').show(200);
            }else{
                $('#chckbox_lastpayroll').prop('checked', false);
                $('#last_payroll_panel').hide(200);
            }

            compute_grand_total();

        });

        var hide_mode_panel = function(){
            $('#tbl_clearance_list_wrapper').hide();
            $('#btn_new').hide();
            $('#footer-panel').show();
            $('.panel_title').text('New Employee Clearance');
            $('.clearance_row').show();
        };

        var show_panel = function(){
            $('#btn_new').show();
            $('#tbl_clearance_list_wrapper').show();
            $('#footer-panel').hide();
            $('.panel_title').text('Clearance List');
            $('.clearance_row').hide();
        };

        $('#btn_save').click(function(){
            if(validateRequiredFields($('#frm_clearance'))){
                if(_txnMode==="new"){
                    createClearance().done(function(response){
                        showNotification(response);
                        dt.row.add(response.row_added[0]).draw();
                        clearFields($('#frm_clearance'))
                    }).always(function(){
                        show_panel();
                        $.unblockUI();
                    });

                    return;
                }
                if(_txnMode==="edit"){
                    updateClearance().done(function(response){
                        showNotification(response);
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                    }).always(function(){
                        show_panel();
                         $.unblockUI();
                    });
                    return;
                }
            }
        });

        _employeesdt=$("#employee_id").select2({
            placeholder: "Select Employee",
            allowClear: false
        });

        _employeesdt.val(null).trigger("change");

        _clearedby=$("#cleared_by").select2({
            placeholder: "Select Employee",
            allowClear: false
        });

        _clearedby.val(null).trigger("change");

        _clearance_reason=$("#clearance_reason").select2({
            placeholder: "Select Reason",
            allowClear: false
        });

        _clearance_reason.val(null).trigger("change");

        _clearance_reason.on("select2:select", function (e) {
        var i=$(this).select2('val');
                if(i=="newreason"){
                $('#clearance_reason').val("").trigger('change')
                $('#modal_create_reason').modal('show');
                $('#clearance_description').val("");
        }

        });

        $('#date_cleared').val(get_current_date());

        $("#employee_id").change(function() {
            changeemployeedetails();
            get_payroll();
        });

        $('#btn-add-deduction').on('click',function(){
            $('#tbl_clearance_deduction > tbody').append(newRowItem());
            reInitializeNumeric();
        });

        $('#tbl_clearance_deduction tbody').on('click','.remove_deduction',function(){
            var oRow=$('.tbl_clearance_deduction > tbody tr');
            $(this).closest('tr').remove();  
            reInitializeNumeric();
            compute_deduction_amount();
        });

        $('#accumulated_13thmonth_pay').keyup(function(){
            compute_due_to_date();
        });

        $('#additional_pay').keyup(function(){
            compute_due_to_date();
        });

        $('#no_of_leave').keyup(function(){
            compute_pay_leave();
        });

        $('#leave_pay').keyup(function(){
            compute_pay_leave();
        });

        $('#tax_refund').keyup(function(){
            compute_grand_total();
        });

    })();
    
    $('#tbl_clearance_deduction > tbody').on('keyup','.numeric', function(){
        compute_deduction_amount();
    });


    var compute_deduction_amount = function(){

        var grand_total = $('#grand_total').val();
        var net_value =0;
        $('#tbl_clearance_deduction tr td .numeric').each(function() {
            net_value += +parseFloat(accounting.unformat($(this).val()));
        })
          
        var compute_net_total = parseFloat(accounting.unformat(grand_total)) - parseFloat(accounting.unformat(net_value));
        $('#net_total').val(accounting.formatNumber(compute_net_total,2));
    };


    var compute_due_to_date = function(){

        var accumulated_13thmonth_pay=0,
            additional_pay=0;

        var field1 = $('#accumulated_13thmonth_pay').val();
        var field2 = $('#additional_pay').val();

        if (field1 == ""){
            accumulated_13thmonth_pay = 0;
        }else{
            accumulated_13thmonth_pay = field1;
        }

        if (field2 == ""){
            additional_pay = 0;
        }else{
            additional_pay = field2;
        }

        var compute_total_due_date = parseFloat(accounting.unformat(accumulated_13thmonth_pay)) + parseFloat(accounting.unformat(additional_pay));
        $('#total_due_date').val(accounting.formatNumber(compute_total_due_date,2));

        compute_grand_total();
    };

    var compute_pay_leave = function(){

        var no_of_leave=0,
            leave_pay=0;

        var field3 = $('#no_of_leave').val();
        var field4 = $('#leave_pay').val();

        if (field3 == ""){
            no_of_leave = 0;
        }else{
            no_of_leave = field3;
        }

        if (field4 == ""){
            leave_pay = 0;
        }else{
            leave_pay = field4;
        }

        var compute_total_leave = parseFloat(accounting.unformat(no_of_leave)) * parseFloat(accounting.unformat(leave_pay));
        $('#total_leave').val(accounting.formatNumber(compute_total_leave,2));

        compute_grand_total();
    };

    var compute_grand_total = function(){
        var total_due_date = $('#total_due_date').val();
        var total_leave = $('#total_leave').val();
        var tax_refund = $('#tax_refund').val();
        var last_payroll = $('#last_payroll').val();
        var grand_total = 0;
        var stat = $('#chckbox_lastpayroll').is(':checked');

        if (stat == true){
            grand_total = parseFloat(accounting.unformat(total_due_date)) + 
                          parseFloat(accounting.unformat(total_leave)) +
                          parseFloat(accounting.unformat(tax_refund)) +
                          parseFloat(accounting.unformat(last_payroll));

        }else{
            grand_total = parseFloat(accounting.unformat(total_due_date)) + 
                          parseFloat(accounting.unformat(total_leave)) +
                          parseFloat(accounting.unformat(tax_refund));

        }

        $('#grand_total').val(accounting.formatNumber(grand_total,2));

        compute_deduction_amount();
    };

    var reInitializeNumeric=function(){
        $('.numeric').autoNumeric('init');
    };

    var newRowItem=function(d){
    return '<tr>'+
           '<td width="30%"><input type="text" name="deduction_description[]" class="form-control" required data-error-msg="Deduction Description is Required!"></td>'+
           '<td width="10%"><input type="text" name="deduction_amount[]" class="numeric form-control" required data-error-msg="Deduction Amount is Required!" value="0.00"></td>'+
           '<td width="5%">'+
           '<center>'+
           '<button type="button" class="btn btn-danger remove_deduction" style="height: 20px;">'+
           '<i class="fa fa-minus" style="margin-top: -5px!important;position: absolute;margin-left: -5px!important;"></i>'+
           '</button>'+
           '</center>'+
           '</td>'+
           '</tr>';
    };

    var newRowItemforupdate=function(d){
    return '<tr>'+
           '<td width="30%"><input type="text" name="deduction_description[]" value="'+d.deduction_description+'" class="form-control" required data-error-msg="Deduction Description is Required!"></td>'+
           '<td width="10%"><input type="text" name="deduction_amount[]" class="numeric form-control" required data-error-msg="Deduction Amount is Required!" value="'+d.deduction_amount+'"></td>'+
           '<td width="5%">'+
           '<center>'+
           '<button type="button" class="btn btn-danger remove_deduction" style="height: 20px;">'+
           '<i class="fa fa-minus" style="margin-top: -5px!important;position: absolute;margin-left: -5px!important;"></i>'+
           '</button>'+
           '</center>'+
           '</td>'+
           '</tr>';
    };

    var changeemployeedetails =function(){

        var ecode = $('#employee_id option:selected').attr('data-ecode');
        var department = $('#employee_id option:selected').attr('data-dept');
        var position = $('#employee_id option:selected').attr('data-position');
        var rate = $('#employee_id option:selected').attr('data-rate');

        $('#ecode').val(ecode);
        $('#department').val(department); 
        $('#position').val(position);
        $('#rate').val(rate);
    };

    var get_payroll = function(){
        var employee_id = $('#employee_id option:selected').val();
        var parm = 0;

        if (employee_id == ''){
            parm = 0;
        }else{
            parm = employee_id;
        }

        get13thmonth(parm).done(function(response){
            var row = response.data[0];
            var rowlength = response.data.length;
            
                if(rowlength > 0){
                    $('#accumulated_13thmonth_pay').val(accounting.formatNumber(row.acc_13thmonth_pay,2));
                }else{
                    $('#accumulated_13thmonth_pay').val('0.00');
                }

        compute_due_to_date();
        });

        get_payleave(parm).done(function(response){
            var row = response.data[0];
            var rowlength = response.data.length;

                if(rowlength > 0){
                    $('#no_of_leave').val(accounting.formatNumber(row.current_balance));
                }else{
                    $('#no_of_leave').val('0');
                }

        compute_pay_leave();
        });

        last_payroll(parm).done(function(response){
            var row = response.data[0];
            var rowlength = response.data.length;

                if(rowlength > 0){
                    $('#payslip_no').text(row.payslip_no);
                    $('#last_payroll').val(accounting.formatNumber(row.net_pay,2));
                }else{
                    $('#payslip_no').text('');
                    $('#last_payroll').val('0.00');
                }

        }).always(function(){
            $.unblockUI();
        });

        compute_grand_total();
    };

    function get_current_date(){
        var fullDate = new Date()
        //Thu May 19 2011 17:25:38 GMT+1000 {}
         
        //convert month to 2 digits
        var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
         
        var currentDate = twoDigitMonth + "/" + fullDate.getDate() + "/" + fullDate.getFullYear();
        return currentDate;
    };

    var validateRequiredFields=function(f){
        var stat=true;

        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',f).each(function(){

                if($(this).val()==""){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).focus();
                    stat=false;
                    return false;
                }
        });

        return stat;
    };

    var createClearance=function(){
        var _data=$('#frm_clearance').serializeArray();
        _data.push({name : "payslip_no" ,value : $('#payslip_no').text()});
        var stat = $('#chckbox_lastpayroll').is(':checked');
        if (stat == true){
            _data.push({name : "include_last_pay" ,value : '1'});
        }else{
            _data.push({name : "include_last_pay" ,value : '0'});
        }

        var reason_of_leave = $('#clearance_reason option:selected').text();

        _data.push({name : "reason_of_leave" ,value : reason_of_leave});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"EmployeeClearance/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var last_payroll=function(employee_id){
        var _data=$('#').serializeArray();
        _data.push({name : "employee_id" ,value : employee_id});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"EmployeeClearance/transaction/last_payroll",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var get_payleave=function(employee_id){
        var _data=$('#').serializeArray();
        _data.push({name : "employee_id" ,value : employee_id});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Entitlement/transaction/getresult",
            "data":_data
        });
    };

    var get13thmonth=function(employee_id){
        var _data=$('#').serializeArray();
        _data.push({name : "employee_id" ,value : employee_id});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"EmployeeClearance/transaction/get13thmonth",
            "data":_data
        });
    };

    var updateClearance=function(){
        var _data=$('#frm_clearance').serializeArray();
        _data.push({name : "employee_clearance_id" ,value : _selectedID});
        _data.push({name : "payslip_no" ,value : $('#payslip_no').text()});
        var stat = $('#chckbox_lastpayroll').is(':checked');
        if (stat == true){
            _data.push({name : "include_last_pay" ,value : '1'});
        }else{
            _data.push({name : "include_last_pay" ,value : '0'});
        }

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"EmployeeClearance/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var finalizeClearance=function(){
        
        var _data=$('#').serializeArray();
        _data.push({name : "employee_id" ,value : _selectedEmpID});
        _data.push({name : "employee_clearance_id" ,value : _selectedID});

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"EmployeeClearance/transaction/finalize",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var getAllemployees=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"EmployeeClearance/transaction/getAllemployees"
        });
    };

    var getDeductions=function(employee_clearance_id){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"EmployeeClearance/transaction/getDeductions",
            "data":{employee_clearance_id : employee_clearance_id},
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var getEmpInfo=function(employee_id){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"EmployeeClearance/transaction/getEmpInfo",
            "data":{employee_id : employee_id},
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removeClearance=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"EmployeeClearance/transaction/delete",
            "data":{employee_clearance_id : _selectedID},
            "beforeSend": showSpinningProgress($('#btn_save'))
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
        $('#payslip_no').text('');
        $('#employee_id').val("").trigger("change");
        $('#accumulated_13thmonth_pay').val('0.00');
        $('#additional_pay').val('0.00');
        $('#total_due_date').val('0.00');
        $('#no_of_leave').val('0');
        $('#leave_pay').val('0.00');
        $('#total_leave').val('0.00');
        $('#tax_refund').val('0.00');
        $('#last_payroll').val('0.00');
        $('#grand_total').val('0.00');
        $('#date_cleared').val(get_current_date());
        $('#cleared_by').val("").trigger("change");
        $('#clearance_reason').val("").trigger("change");
        $('#net_total').val('0.00');
        $('#tbl_clearance_deduction > tbody').html("");
    };

});

</script>
</body>

</html>
