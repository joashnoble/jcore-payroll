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

    <?php echo $_def_js_files; ?>
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
            text-align: left;
            width: 100%;
        }

    </style>

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
                        <li><a href="UserGroups">User Groups</a></li>
                    </ol>

                    <div class="container-fluid">

                        <div id="div_product_list">
                            <div class="panel panel-default">
                                        <button class="btn right_usergroup_create"  id="btn_new" style="width:185px;background-color:#2ecc71;color:white;" title="Create New Leave" >
                                        <i class="fa fa-file"></i> New User Group</button>
                                        <div class="panel-heading" style="background-color:#2c3e50 !important;margin-top:2px;">
                                             <center><h2 style="color:white;font-weight:300;">User Group List</h2></center>
                                        </div>
                                    <div class="panel-body table-responsive" style="padding-top:8px;">
                                        <table id="tbl_user_groups" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>User Group</th>
                                                    <th>Description</th>
                                                    <th><center>Action</center></th>
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
                    <div class="modal-content"><!---content--->
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
                    </div><!---content---->
                </div>
                </div>
            </div><!---modal-->
            <div id="modal_create_rights" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#2ecc71;">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"> </span>User Group : <transaction class="transaction_type"></transaction></h4>
                        </div>

                        <div class="modal-body">
                            <form id="frm_user_group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="usergroup">
                                            <label class="col-sm-4 inlinecustomlabel-sm" for="inputEmail1">User Group Name :</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-file-text"></i>
                                                    </span>
                                                    <input type="text" id="user_group" name="user_group" class="form-control" placeholder="User Group Name" data-error-msg="Password is required!" required>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="description">
                                            <label class="col-sm-4 inlinecustomlabel-sm" for="inputEmail1">Description :</label>
                                            <div class="col-sm-8">
                                                    <textarea name="user_group_desc" class="form-control" data-error-msg="Description is required!" required></textarea>

                                            </div>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <center><h3 class="box-title" style="font-weight:bold;">User Rights / Permissions</h3></center>

                                  <div class="form-group">
                                      <label class="col-sm-4 inlinecustomlabel-sm" for="inputEmail1">Allow :</label>
                                      <div class="col-sm-8" id="toggleevent">
                                        <input class="checkorno" type="checkbox" id="toggle-two" data-width="100%">

                                      </div>
                                  </div>

                            <div class="panel-group" id="accordion">

                                <div class="panel panel-default" style="margin:0px;">
                                  <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #2ecc71;">
                                    <h4 class="panel-title">
                                      <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#accordion" href="#payroll">Payroll</a>
                                    </h4>
                                  </div>
                                  <div id="payroll" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                        <select class="form-control" name="right_payrollparent_view" >
                                                            <option value="0">Off</option>
                                                            <option value="1">On</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#dailytimerecord"> - Daily Time Record</a>
                                            </h4>
                                          </div>
                                          <div id="dailytimerecord" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_dtr_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Create :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_dtr_create" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Edit :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_dtr_edit" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#processpayroll"> - Process Payroll</a>
                                            </h4>
                                          </div>
                                          <div id="processpayroll" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_processpayroll_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Processing :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_processpayroll_process" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightpayslip"> - Payslip</a>
                                            </h4>
                                          </div>
                                          <div id="rightpayslip" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_payslip_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
<!--                                         <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightloanadjustment"> - Loans/Advances Adjustment</a>
                                            </h4>
                                          </div>
                                          <div id="rightloanadjustment" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_loanadjustment_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div> -->
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightdtrverification"> - DTR Verification List</a>
                                            </h4>
                                          </div>
                                          <div id="rightdtrverification" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_dtrverification_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightpayrollhistory"> - Employee Payroll History</a>
                                            </h4>
                                          </div>
                                          <div id="rightpayrollhistory" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_payrollhistory_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightmonthlypayroll"> - Employee Monthly Salary</a>
                                            </h4>
                                          </div>
                                          <div id="rightmonthlypayroll" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_monthlypayroll_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightyearlypayroll"> - Employee Yearly Salary</a>
                                            </h4>
                                          </div>
                                          <div id="rightyearlypayroll" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_yearlypayroll_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightledger"> - Employee Ledgers</a>
                                            </h4>
                                          </div>
                                          <div id="rightledger" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_ledger_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#right13thmonth"> - 13TH Month Pay</a>
                                            </h4>
                                          </div>
                                          <div id="right13thmonth" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_13thmonthpay_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightempcompensation"> - Employee Compensation History</a>
                                            </h4>
                                          </div>
                                          <div id="rightempcompensation" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_employee_compensation_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightempdeducthistory"> - Employee Deduction History</a>
                                            </h4>
                                          </div>
                                          <div id="rightempdeducthistory" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_employee_deduction_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightalphalist"> - Alpha List of Employee</a>
                                            </h4>
                                          </div>
                                          <div id="rightalphalist" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_alphalist_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="panel panel-default" style="margin:0px;">
                                  <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #2ecc71;">
                                    <h4 class="panel-title">
                                      <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#accordion" href="#payrollregister">Payroll Register</a>
                                    </h4>
                                  </div>
                                  <div id="payrollregister" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                        <select class="form-control" name="right_payroll_register_view" >
                                                            <option value="0">Off</option>
                                                            <option value="1">On</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightpayrollregisterwaccount"> - Payroll Register W/ Accounts</a>
                                            </h4>
                                          </div>
                                          <div id="rightpayrollregisterwaccount" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_payroll_register_waccount_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightpayrollregistercash"> - Payroll Register Cash</a>
                                            </h4>
                                          </div>
                                          <div id="rightpayrollregistercash" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_payroll_register_cash_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightpayrollsummary"> - Payroll Summary</a>
                                            </h4>
                                          </div>
                                          <div id="rightpayrollsummary" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_payrollsummary_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="panel panel-default" style="margin:0px;">
                                  <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #2ecc71;">
                                    <h4 class="panel-title">
                                      <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#accordion" href="#payrollreports">Payroll Reports</a>
                                    </h4>
                                  </div>
                                  <div id="payrollreports" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                        <select class="form-control" name="right_payrollreports_view" >
                                                            <option value="0">Off</option>
                                                            <option value="1">On</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightsssreport"> - SSS Report</a>
                                            </h4>
                                          </div>
                                          <div id="rightsssreport" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_sssreport_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightphilhealthreport"> - Philhealth Report</a>
                                            </h4>
                                          </div>
                                          <div id="rightphilhealthreport" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_philhealthreport_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightpagibigreport"> - Pagibig Report</a>
                                            </h4>
                                          </div>
                                          <div id="rightpagibigreport" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_pagibigreport_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightwtax"> - WTAX Report</a>
                                            </h4>
                                          </div>
                                          <div id="rightwtax" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_wtaxreport_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#right2316"> - BIR FORM 2316</a>
                                            </h4>
                                          </div>
                                          <div id="right2316" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_bir2316_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Create :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_bir2316_create" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Edit :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_bir2316_edit" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Delete :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_bir2316_delete" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="panel panel-default" style="margin:0px;">
                                  <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #2ecc71;">
                                    <h4 class="panel-title">
                                      <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#accordion" href="#rightpayrollref">Payroll References</a>
                                    </h4>
                                  </div>
                                  <div id="rightpayrollref" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                        <select class="form-control" name="right_payrollreferenceparent_view" >
                                                            <option value="0">Off</option>
                                                            <option value="1">On</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightclearancereason"> - Clearance Reason</a>
                                            </h4>
                                          </div>
                                          <div id="rightclearancereason" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_clearancereason_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Create :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_clearancereason_create" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Edit :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_clearancereason_edit" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Delete :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_clearancereason_delete" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightpayperiod"> - Pay Period</a>
                                            </h4>
                                          </div>
                                          <div id="rightpayperiod" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_payperiod_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Create :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_payperiod_create" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Edit :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_payperiod_edit" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Delete :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_payperiod_delete" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightearningsetup"> - Earning Setup</a>
                                            </h4>
                                          </div>
                                          <div id="rightearningsetup" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_earningsetup_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Create :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_earningsetup_create" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Edit :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_earningsetup_edit" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Delete :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_earningsetup_delete" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightearningtype"> - Earning Type</a>
                                            </h4>
                                          </div>
                                          <div id="rightearningtype" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_earningtype_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Create :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_earningtype_create" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Edit :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_earningtype_edit" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Delete :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_earningtype_delete" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightdeducttype"> - Deduction Type</a>
                                            </h4>
                                          </div>
                                          <div id="rightdeducttype" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_deductiontype_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Create :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_deductiontype_create" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Edit :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_deductiontype_edit" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Delete :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_deductiontype_delete" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightdeductsetup"> - Deduction Setup</a>
                                            </h4>
                                          </div>
                                          <div id="rightdeductsetup" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_deductionsetup_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Create :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_deductionsetup_create" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Edit :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_deductionsetup_edit" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Delete :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_deductionsetup_delete" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightdeductperiod"> - Deduction Period</a>
                                            </h4>
                                          </div>
                                          <div id="rightdeductperiod" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_deductionperiod_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Create :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_deductionperiod_edit" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#righttaxtable"> - Tax File</a>
                                            </h4>
                                          </div>
                                          <div id="righttaxtable" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_taxtable_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="panel panel-default" style="margin:0px;">
                                      <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #2ecc71;">
                                        <h4 class="panel-title">
                                          <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightemployeeclearance"> Employee Clearance / Exit</a>
                                        </h4>
                                      </div>
                                      <div id="rightemployeeclearance" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                            <select class="form-control" name="right_employeeclearance_view" >
                                                                <option value="0">Off</option>
                                                                <option value="1">On</option>
                                                            </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Create :</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                            <select class="form-control" name="right_employeeclearance_create" >
                                                                <option value="0">Off</option>
                                                                <option value="1">On</option>
                                                            </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Edit :</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                            <select class="form-control" name="right_employeeclearance_edit" >
                                                                <option value="0">Off</option>
                                                                <option value="1">On</option>
                                                            </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Delete :</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                            <select class="form-control" name="right_employeeclearance_delete" >
                                                                <option value="0">Off</option>
                                                                <option value="1">On</option>
                                                            </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Finalize :</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                            <select class="form-control" name="right_employeeclearance_finalize" >
                                                                <option value="0">Off</option>
                                                                <option value="1">On</option>
                                                            </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                </div>
                                <div class="panel panel-default" style="margin:0px;">
                                  <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #2ecc71;">
                                    <h4 class="panel-title">
                                      <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#accordion" href="#rightadmin">Settings</a>
                                    </h4>
                                  </div>
                                  <div id="rightadmin" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                        <select class="form-control" name="right_adminparent_view" >
                                                            <option value="0">Off</option>
                                                            <option value="1">On</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightuseracc"> - User Account</a>
                                            </h4>
                                          </div>
                                          <div id="rightuseracc" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_useracccount_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Create :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_useracccount_create" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Edit :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_useracccount_edit" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Delete :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_useracccount_delete" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightusergroup"> - User Group</a>
                                            </h4>
                                          </div>
                                          <div id="rightusergroup" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_usergroup_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Create :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_usergroup_create" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Edit :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_usergroup_edit" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Delete :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_usergroup_delete" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="panel panel-default" style="margin:0px;">
                                          <div class="panel-heading" style="background-color:white !important;padding:10px;border-bottom:3px solid #d35400;">
                                            <h4 class="panel-title">
                                              <a data-toggle="collapse" style="color:#2c3e50;" data-parent="#subaccordion" href="#rightfactorfile"> - Factor File</a>
                                            </h4>
                                          </div>
                                          <div id="rightfactorfile" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">View :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_reffactorfile_view" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3" style="margin-top:8px;" for="inputEmail1">Edit :</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-cogs" aria-hidden="true"></i></span>
                                                                <select class="form-control" name="right_reffactorfile_edit" >
                                                                    <option value="0">Off</option>
                                                                    <option value="1">On</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>  
                                    </div>
                                  </div>
                                </div>

                            </div>
                            </form>
                    </div>

                        <div class="modal-footer">
                            <button id="btn_create" type="button" class="btn" style="background-color:#2ecc71;color:white;">Save</button>
                            <button id="btn_cancel" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div><!---content---->
                </div>
             </div>
            </div><!---modal-->



<?php echo $_switcher_settings; ?>



<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.js"></script>


<!-- Date range use moment.js same as full calendar plugin -->
<script src="assets/plugins/fullcalendar/moment.min.js"></script>
<!-- Data picker -->
<script src="assets/plugins/datapicker/bootstrap-datepicker.js"></script>

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
<link href="assets/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="assets/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

<?php echo $_rights; ?>

<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj; var _ispayable=0; var _isforwardable=0;
    $('#toggle-two').bootstrapToggle({
      on: 'All',
      off: 'Specific'
    });
    $('#toggleevent').click(function(){
      if($('.checkorno').prop("checked") == false){
        // console.log(1);
        $('select').each(function() {
            $(this).val(1);
        });
      }else{
        $('select').each(function() {
            $(this).val(0);
        });
      }
    });
    var initializeControls=function(){
        dt=$('#tbl_user_groups').DataTable({
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('DataTables_' + window.location.pathname, JSON.stringify(oData));
            },
            "ajax" : "UserGroups/transaction/list",
            "columns": [
                { targets:[0],data: "user_group" },
                { targets:[1],data: "user_group_desc" },
                {
                    targets:[2], data: null,
                    render: function (data, type, full, meta){
                        if (data.user_group_id != 1){
                            return '<center>'+right_usergroup_edit+right_usergroup_delete+'</center>';
                        }else{
                            return '';
                        }
                    }
                }

            ],
            language: {
                         searchPlaceholder: "Search Leave"
                     },
            "rowCallback":function( row, data, index ){

                $(row).find('td').eq(10).attr({
                    "align": "right"
                });
            }
        });






        $('.numeric').autoNumeric('init');


    }();


    var bindEventHandlers=(function(){
        var detailRows = [];

        /*$('#tbl_user_groups tbody').on( 'click', 'tr td.details-control', function () {
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
        } );*/

        $('#tbl_user_groups tbody').on( 'click', 'tr td.details-control', function () {
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.user_group_id;
            $('.user_rights_detail').text(data.user_group);
            $('#modal_rights').modal('toggle');
        } );


        $('#tbl_user_groups tbody').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";

            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.user_group_id;
            $('#user_group_id').val(data.user_group_id);
            $('.transaction_type').text('Edit');
            //$('#emp_exemptpagibig').val(data.emp_exemptphilhealth);

           // alert($('input[name="tax_exempt"]').length);
            //$('input[name="tax_exempt"]').val(0);
            //$('input[name="inventory"]').val(data.is_inventory);

            $('input,textarea').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value);
                    }
                });
            });

            $('select').each(function(){
                var _elem=$(this);
                $.each(data,function(name,value){
                    if(_elem.attr('name')==name){
                        _elem.val(value==0 || value==null ? 0 : 1);
                    }
                });
            });

            $('#modal_create_rights').modal('toggle');

            hideRatesduties();
            hideemployeeList();
            showemployeeFields();

        });

        $('#tbl_user_groups tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.user_group_id;

            $('#modal_confirmation').modal('show');
        });

        $('#btn_yes').click(function(){
            removeUserAccount().done(function(response){
                showNotification(response);
                dt.row(_selectRowObj).remove().draw();
                $.unblockUI();
            });
        });

        $('#btn_browse').click(function(event){
                    event.preventDefault();
                    $('input[name="file_upload[]"]').click();
             });

        $('#btn_remove_photo').click(function(event){
                event.preventDefault();
                $('img[name="img_user"]').attr('src','assets/img/anonymous-icon.png');
            });

        $('input[name="file_upload[]"]').change(function(event){
            var _files=event.target.files;

            //$('#div_img_product').hide();
           // $('#div_img_loader').show();
           showSpinningProgressUpload();

            var data=new FormData();
            $.each(_files,function(key,value){
                data.append(key,value);
            });

            console.log(_files);

            $.ajax({
                url : 'Users/transaction/upload',
                type : "POST",
                data : data,
                cache : false,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(response){
                            //console.log(response);
                            //alert(response.path);
                           // $('#div_img_loader').hide();
                           // $('#div_img_user').show();
                            $.unblockUI();
                            $('img[name="img_user"]').attr('src',response.path);

                        }
            });
        });



        $('#btn_new').click(function(){
            _txnMode="new";
            $('.transaction_type').text('New');
            $('#modal_create_rights').modal('show');
            clearFields($('#frm_user_group'));
        });

        $('#btn_create').click(function(){
            if(validateRequiredFields($('#frm_user_group'))){
                if(_txnMode==="new"){
                    //alert("aw");
                    createUserAccount().done(function(response){
                        showNotification(response);
                        dt.row.add(response.row_added[0]).draw();
                        clearFields($('#frm_user_group'))
                    }).always(function(){
                        $('#modal_create_rights').modal('hide');
                        $.unblockUI();
                    });
                    return;
                }
                if(_txnMode==="edit"){
                    //alert("update");
                    updateUserAccount().done(function(response){
                        showNotification(response);
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                    }).always(function(){
                        $('#modal_create_rights').modal('hide');
                        $.unblockUI();
                    });
                    return;
                }
            }
            else{}
        });

        $('#btn_save_rights').click(function(){
            if(validateRequiredFields($('#frm_rights'))){
                    /*alert("aw");*/
                    saveUserRights().done(function(response){
                        showNotification(response);
                        /*dt.row.add(response.row_added[0]).draw();*/
                        /*clearFields($('#frm_user_group'))*/
                    }).always(function(){
                        /*$('#modal_create_rights').modal('hide');*/
                        $.unblockUI();
                    });
                    return;
            }
            else{}
        });


    })();


    var validateRequiredFields=function(f){
        var stat=true;
        var pword=$('#user_pword').val();
        var cpword=$('#user_confirm_pword').val();
        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',f).each(function(){


                if($(this).val()==""){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }
                if(pword!=cpword){
                    showNotification({title:"Error!",stat:"error",msg:"Pasword Doesnt Match"});
                    $('#password').addClass('has-error');
                    $('#confpassword').addClass('has-error');
                    $('#user_confirm_pword').focus();
                    stat=false;
                    return false;
                }




        });

        return stat;
    };

    var createUserAccount=function(){
            var _data=$('#frm_user_group').serializeArray();

            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"UserGroups/transaction/create",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };


    var updateUserAccount=function(){
            var _data=$('#frm_user_group').serializeArray();
            _data.push({name : "user_group_id" ,value : _selectedID});
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"UserGroups/transaction/update",
                "data":_data,
                "beforeSend": showSpinningProgress($('#btn_save'))
            });
        };

    var removeUserAccount=function(){
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"UserGroups/transaction/delete",
                "data":{user_group_id : _selectedID},
                "beforeSend": showSpinningProgress($('#'))
            });
        };

    var saveUserRights=function(){
            var _data=$('#frm_rights').serializeArray();
            _data.push({name : "user_group_id" ,value : _selectedID});
            return $.ajax({
                "dataType":"json",
                "type":"POST",
                "url":"UserGroups/transaction/saverights",
                "data":_data,
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
                $.blockUI({ message: '<img src="assets/img/gears.svg"/><br><h4 style="color:#ecf0f1;">Saving Changes</h4>',
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



    function format ( d ) {
        return '<div class="container-fluid" style="margin:10px;">'+
        '<div class="col-md-12">'+
        '<h3 class="boldlabel"><span class="glyphicon glyphicon-user fa-lg"></span> ' + d.full_name+ '</h3>'+
        '<p>[ Username : '+d.user_name+' ] [ Account Type : '+d.user_group+' ]</p>'+
        '<hr style="height:1px;background-color:black;"></hr>'+
        '</div>'+ //First Row//
        '<div class="row">'+
        '<div class="col-md-3">'+
        '<center><img class="loadingimg" style="margin-top:4px;width:150px;height:150px;" src="'+d.photo_path+'"></img></center>'+
        '</div>'+
        '<div class="col-md-6"><p class="nomargin"><b>Gender</b> : '+d.user_email+'</p>'+
        '<p class="nomargin"><b>Birthdate</b> : '+d.user_mobile+'</p>'+
        '<p class="nomargin"><b>Civil Status</b> : '+d.user_telephone+'</p>'+
        '<p class="nomargin"><b>Blood Type</b> : '+d.user_bdate+'</p>'+
        '<p class="nomargin"><b>Blood Type</b> : '+d.user_address+'</p>'+

        '</div>'+
        '</div>'+
        '<hr style="height:1px;background-color:black;"></hr>'+
        '</div>';
    };



   /* $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });*/


    // apply input changes, which were done outside the plugin
    //$('input:radio').iCheck('update');

});

</script>

</body>
<?php echo $loaderscript; ?>
</html>
