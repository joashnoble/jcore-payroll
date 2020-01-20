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
    <style>
        /* Loading Spinner */
        .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}

    </style>

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
            width: 60%;
        }

        .detail-sorting {
        	background-color:#2980b9 !important;
            color:white;
        }


        .odd{
            background-color:#eeeeee !important;
        }

        .modal-dialog {
        	width:1200px !important;
        }

        .modal-body {
        	width:1200px !important;
        }

        #tbl_view_tax th {
        	text-align:center;
        	font-size:13px !important;
        }

        #tbl_view_tax td {
        	width:10% !important;
        	font-size:14px !important;
        	text-align:center;
        }

        .modal-body h4 {
        	padding-top:0px !important;
        	margin-top:0px !important;
        	padding-bottom:0px !important;
        	margin-bottom:0px !important;
        }

        #tax_content {
        	text-align:left !important;
        	background:#494949 !important;
        	color:#FFF !important;
        }

    </style>

<script type="text/javascript">
    $(window).load(function(){
        setTimeout(function() {
            $('#loading').fadeOut( 400, "linear" );
        }, 300);
    });
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

<body class="animated-content" style="font-family: tahoma;">
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
                        <li><a href="RefWTax">Tax Table</a></li>
                    </ol>

                    <div class="container-fluid">

                        <div id="div_product_list">
                            <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color:#2c3e50 !important;margin-top:5px;margin-left:2px;border-radius:5px;">
                                             <center><h2 style="color:white;font-weight:300;">Tax Table</h2></center>
                                        </div>
                                    <div class="panel-body table-responsive" style="padding-top:8px;">
                                        <table id="tbl_wtax_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Payment Type</th>
                                                 </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>

                                <div class="panel-footer"></div>
                            </div> <!--panel default -->

                        </div> <!--rates and duties list -->

                        <div id="div_product_fields" style="display: none;">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color:#2ecc71 !important;margin-top:5px;border-radius:5px;">
                                             <center><h2 style="color:white;font-weight:bold;">Personal Information</h2></center>
                                        </div>

                                    <div class="panel-body">
                                        <form id="frm_wtax" role="form" class="form-horizontal row-border">
                                                <div class="container-fluid">
                                                    <div class="col-md-9">
                                                        <div class="col-md-10">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">*ID Number</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_idnumber" class="form-control" value="" data-error-msg="ID Number is required!" required>
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">*First Name</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_fname" class="form-control" value="" data-error-msg="First Name is required!" required>
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">*Middle Name</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_mname" class="form-control" value="" data-error-msg="Middle Name is required!" required>
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">*Last Name</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_lname" class="form-control" value="" data-error-msg="Last Name is required!" required>
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Address 1:</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_address1" class="form-control" value="" data-error-msg="Address 1 is required!">
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Address 2:</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_address2" class="form-control" value="" data-error-msg="Address 2 is required!">
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Email Address:</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_email" class="form-control" value="" data-error-msg="Email Address 1 is required!">
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Gender:</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                               <select class="form-control" name="emp_gender" data-error-msg="Gender is required!">
                                                                  <option>Male</option>
                                                                  <option>Female</option>
                                                                </select>
                                                                </div>
                                                          </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                             <label class="control-label boldlabel" style="text-align:left;">Cell No:</label>
                                                        </div>
                                                        <div class="col-md-3.5">
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_cell" class="form-control" value="" data-error-msg="Cell No is required!">
                                                                </div>
                                                          </div>
                                                        </div>

                                                        </div>
                                                        <div class="col-md-10">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Birthdate:</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_birthdate" class="date-picker form-control" value="" placeholder="Birthdate" data-error-msg="Birth Date is required!">
                                                                </div>
                                                          </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                             <label class="control-label boldlabel" style="text-align:left;">Tel No:</label>
                                                        </div>
                                                        <div class="col-md-3.5">
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_phone" class="form-control" value="" data-error-msg="TelePhone Number is required!">
                                                                </div>
                                                          </div>
                                                        </div>

                                                        </div>
                                                        <div class="col-md-10">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Religion:</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <select class="form-control" id="emp_religion" name="emp_religion" data-error-msg="Religion is required!">
                                                                  <option value="1">Roman Catholic</option>
                                                                  <option value="2">Protestant</option>
                                                                  <option value="3">INC</option>
                                                                  <option value="4">Baptist</option>
                                                                  <option value="5">Born-Again</option>
                                                                  <option value="6">Jehova's Witness</option>
                                                                </select>
                                                                </div>
                                                          </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                             <label class="control-label boldlabel" style="text-align:left;">Blood:</label>
                                                        </div>
                                                        <div class="col-md-3.5">
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_bloodtype" class="form-control" value="" data-error-msg="Blood Type is required!">
                                                                </div>
                                                          </div>
                                                        </div>

                                                        </div>
                                                        <div class="col-md-10">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Civil Status:</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <select class="form-control" id="emp_civilstatus" name="emp_civilstatus" data-error-msg="Civil Status is required!">
                                                                  <option>Single</option>
                                                                  <option>Married</option>
                                                                  <option>Divorced</option>
                                                                  <option>Widowed</option>
                                                                  <option>Separated</option>
                                                                </select>
                                                                </div>
                                                          </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                             <label class="control-label boldlabel" style="text-align:left;">Height:</label>
                                                        </div>
                                                        <div class="col-md-3.5">
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_height" class="form-control" value="" data-error-msg="Height is required!">
                                                                </div>
                                                          </div>
                                                        </div>

                                                        </div>
                                                        <div class="col-md-10">
                                                        <div class="col-md-3">

                                                        </div>
                                                        <div class="col-md-4">

                                                        </div>

                                                        <div class="col-md-2">
                                                             <label class="control-label boldlabel" style="text-align:left;">Weight:</label>
                                                        </div>
                                                        <div class="col-md-3.5">
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_weight" class="form-control" value="" data-error-msg="Weight is required!">
                                                                </div>
                                                          </div>
                                                        </div>

                                                        </div>

                                                    </div><!--end of 1st date entry -->

                                                    <div class="col-md-3">

                                                        <div class="col-md-12">
                                                              <label class="control-label boldlabel" style="text-align:left;"><i class="fa fa-user" aria-hidden="true"></i>Employee Image</label>
                                                                <hr style="margin-top:0px !important;height:1px;background-color:black;"></hr>
                                                        </div>
                                                        <div style="width:100%; height:300px;border:2px solid #34495e;border-radius:5px;">
                                                        <center><img src="assets/img/anonymous-icon.png"></img></center>
                                                        <hr style="margin-top:0px !important;height:1px;background-color:black;"></hr>
                                                        <center>
                                                             <button type="button" style="width:150px;margin-bottom:5px;" class="btn btn-primary">Browse Photo</button>
                                                             <button type="button" style="width:150px;" class="btn btn-danger">Remove</button>

                                                    </div>

                                                    </div> <!--end of 1st date entry -->

                                                        <div class="col-md-12">

                                                              <label class="control-label boldlabel" ><i class="fa fa-calendar" aria-hidden="true"></i> Employment Date</label>
                                                        <hr style="margin-top:0px !important;height:1px;background-color:black;">
                                                        </hr>


                                                        </div>
                                                        <div class="col-md-10">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Date Employment:</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                 <input type="text" name="emp_employmentdate" class="date-picker form-control" value="" placeholder="Employment Date" data-error-msg="Employment Date is required!">
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Date Regularization:</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_regularizationdate" class="date-picker form-control" value="" placeholder="Regularization Date" data-error-msg="Regularization Date is required!" disabled>
                                                                </div>
                                                          </div>
                                                        </div>



                                                       <div class="col-md-12">

                                                              <label class="control-label boldlabel" ><i class="fa fa-user" aria-hidden="true"></i> Other Information</label>
                                                        <hr style="margin-top:0px !important;height:1px;background-color:black;">
                                                        </hr>


                                                        </div>
                                                        <!--input1-->
                                                        <div class="col-md-8">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">SSS Number:</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_sss" class="form-control" value="" data-error-msg="SSS is required!">
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <!--input1-->


                                                        <div class="col-md-8">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Phil. Health:</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_philhealth" class="form-control" value="" data-error-msg="Phil. Health is required!">
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Pag Ibig:</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_pagibig" class="form-control" value="" data-error-msg="Pag Ibig is required!">
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">TIN:</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_tin" class="form-control" value="" data-error-msg="Tin is required!">
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Account No.:</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <input type="text" name="emp_accountno" class="form-control" value="" data-error-msg="Account Number is required!">
                                                                </div>
                                                          </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                             <label class="control-label boldlabel" style="text-align:left;">Process?</label>
                                                        </div>
                                                        <div class="col-md-3.5">
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <select class="form-control" id="emp_processaccount" name="emp_processaccount" data-error-msg="Process Account is required!">
                                                                  <option value="0">No</option>
                                                                  <option value="1">Yes</option>
                                                                </select>
                                                                </div>
                                                          </div>
                                                        </div>

                                                        </div>
                                                        <div class="col-md-8">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Tax Code</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <select class="form-control" id="emp_taxcode" name="emp_taxcode" data-error-msg="Tax Code is required!">
                                                                  <option value="0">No</option>
                                                                  <option value="1">Yes</option>
                                                                </select>
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-12">

                                                              <label class="control-label boldlabel" ><i class="fa fa-user" aria-hidden="true"></i> Exemption</label>
                                                        <hr style="margin-top:0px !important;height:1px;background-color:black;">
                                                        </hr>


                                                        </div>
                                                        <div class="col-md-6">
                                                        <div class="col-md-4">
                                                             <label class="control-label boldlabel" style="text-align:left;">SSS :</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <select class="form-control" id="emp_exemptss" name="emp_exemptss" data-error-msg="SSS exempt is required!">
                                                                  <option value="0">No</option>
                                                                  <option value="1">Yes</option>
                                                                </select>
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <div class="col-md-4">
                                                             <label class="control-label boldlabel" style="text-align:left;">Phil Health :</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <select class="form-control" id="emp_exemptpagibig" name="emp_exemptpagibig" data-error-msg="Pag-Ibig is required!">
                                                                  <option value="0">No</option>
                                                                  <option value="1">Yes</option>
                                                                </select>
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <div class="col-md-4">
                                                             <label class="control-label boldlabel" style="text-align:left;">Pag-Ibig :</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                <select class="form-control" id="emp_exemptphilhealth" name="emp_exemptphilhealth" data-error-msg="Phil health is required!">
                                                                  <option value="0">No</option>
                                                                  <option value="1">Yes</option>
                                                                </select>
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-12">

                                                              <label class="control-label boldlabel" ><i class="fa fa-user" aria-hidden="true"></i> Loan</label>
                                                        <hr style="margin-top:0px !important;height:1px;background-color:black;">
                                                        </hr>


                                                        </div>
                                                        <div class="col-md-6">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Loan Date:</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                 <input type="text" name="emp_loandate" class="date-picker form-control" value="" placeholder="Loan Date" data-error-msg="Employment Date is required!">
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <div class="col-md-3">
                                                             <label class="control-label boldlabel" style="text-align:left;">Amount :</label>
                                                        </div>
                                                          <div class="form-group">

                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-file-code-o"></i>
                                                                 </span>
                                                                 <input type="text" name="emp_loanamount" class="form-control" value="" placeholder="Loan Amount" data-error-msg="Loan Amount is required!">
                                                                </div>
                                                          </div>
                                                        </div>


                                                    <br/>
                                                </form>
                                    </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-sm-9 col-sm-offset-3">
                                            <button id="btn_save" class="btn-primary btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Save Changes</button>
                                            <button id="btn_cancelempfields" class="btn-default btn" style="text-transform: capitalize;font-family: Tahoma, Georgia, Serif;">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end of div employee fields -->
                    </div>


                        <displayiv id="div_rates_duties_list" style="display:none;">


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

			<!-- MONTHLY / SEMI EDITED-->

            <div id="modal_view_tax_monthly" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#2ecc71;">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"> </span>Withholding Tax Table (MONTHLY)</h4>
                            <p style="color:white;margin:0px;" id="dataname">	</p>
                        </div>

                        <div class="modal-body">
                        	<table id="tbl_view_tax" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                	<!-- MONTHLY -->
                                	<tr>
                                    	<th></th>
                                    	<th>1</th>
                                    	<th>2</th>
                                    	<th>3</th>
                                    	<th>4</th>
                                    	<th>5</th>
                                    	<th>6</th>
                                    </tr>

                                    <tr>
                                        <td><b>Compensation Level (CL)</b></td>
                                        <td><tbltax id="0col1_cl"></tbltax> <br> <below class="below"></below></td>
                                        <td><tbltax id="0col2_cl"></tbltax></td>
                                        <td><tbltax id="0col3_cl"></tbltax></td>
                                        <td><tbltax id="0col4_cl"></tbltax></td>
                                        <td><tbltax id="0col5_cl"></tbltax></td>
                                        <td><tbltax id="0col6_cl"></tbltax></td>
                                     </tr>
                                     <tr>
                                     	<td><b>Prescribed Minimum Withholding Tax</b></td>
                                     	<td class="tdTax"><tbltax id="0col1_amount"></tbltax> <br> <tbltax id="0col1_percent"></tbltax> </td>
                                     	<td class="tdTax"><tbltax id="0col2_amount"></tbltax> <br> <tbltax id="0col2_percent"></tbltax> </td>
                                     	<td class="tdTax"><tbltax id="0col3_amount"></tbltax> <br> <tbltax id="0col3_percent"></tbltax> </td>
                                     	<td class="tdTax"><tbltax id="0col4_amount"></tbltax> <br> <tbltax id="0col4_percent"></tbltax> </td>
                                     	<td class="tdTax"><tbltax id="0col5_amount"></tbltax> <br> <tbltax id="0col5_percent"></tbltax> </td>
                                     	<td class="tdTax"><tbltax id="0col6_amount"></tbltax> <br> <tbltax id="0col6_percent"></tbltax> </td>
                                     </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                    </div><!---content-->
                </div>
                </div>
            </div><!---modal-->

            <!-- SEMI MONTHLY / MONTHLY EDITED-->

            <div id="modal_view_tax_semimonthly" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#2ecc71;">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"> </span>Withholding Tax Table (SEMI-MONTHLY)</h4>
                            <p style="color:white;margin:0px;" id="dataname">	</p>
                        </div>

                        <div class="modal-body">
                        	<table id="tbl_view_tax" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <!-- SEMIMONTHLY -->
                                    <tr>
                                        <th></th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>6</th>
                                    </tr>

                                    <tr>
                                        <td><b>Compensation Level (CL)</b></td>
                                        <td><tbltax id="0col1_cl1"></tbltax> <br> <below class="below"></below></td>
                                        <td><tbltax id="0col2_cl1"></tbltax></td>
                                        <td><tbltax id="0col3_cl1"></tbltax></td>
                                        <td><tbltax id="0col4_cl1"></tbltax></td>
                                        <td><tbltax id="0col5_cl1"></tbltax></td>
                                        <td><tbltax id="0col6_cl1"></tbltax></td>
                                     </tr>
                                     <tr>
                                        <td><b>Prescribed Minimum Withholding Tax</b></td>
                                        <td class="tdTax"><tbltax id="0col1_amount1"></tbltax> <br> <tbltax id="0col1_percent1"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col2_amount1"></tbltax> <br> <tbltax id="0col2_percent1"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col3_amount1"></tbltax> <br> <tbltax id="0col3_percent1"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col4_amount1"></tbltax> <br> <tbltax id="0col4_percent1"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col5_amount1"></tbltax> <br> <tbltax id="0col5_percent1"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col6_amount1"></tbltax> <br> <tbltax id="0col6_percent1"></tbltax> </td>
                                     </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                    </div><!--content-->
                </div>
                </div>
            </div><!---modal-->

            <!-- DAILY -->

            <div id="modal_view_tax_daily" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#2ecc71;">
                            <button type="button" class="close"   data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"> </span>Withholding Tax Table (DAILY)</h4>
                            <p style="color:white;margin:0px;" id="dataname">	</p>
                        </div>

                        <div class="modal-body">
                        	<table id="tbl_view_tax" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <!-- DAILY -->
                                    <tr>
                                        <th></th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>6</th>
                                    </tr>

                                    <tr>
                                        <td><b>Compensation Level (CL)</b></td>
                                        <td><tbltax id="0col1_cl2"></tbltax> <br> <below class="below"></below></td>
                                        <td><tbltax id="0col2_cl2"></tbltax></td>
                                        <td><tbltax id="0col3_cl2"></tbltax></td>
                                        <td><tbltax id="0col4_cl2"></tbltax></td>
                                        <td><tbltax id="0col5_cl2"></tbltax></td>
                                        <td><tbltax id="0col6_cl2"></tbltax></td>
                                     </tr>
                                     <tr>
                                        <td><b>Prescribed Minimum Withholding Tax</b></td>
                                        <td class="tdTax"><tbltax id="0col1_amount2"></tbltax> <br> <tbltax id="0col1_percent2"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col2_amount2"></tbltax> <br> <tbltax id="0col2_percent2"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col3_amount2"></tbltax> <br> <tbltax id="0col3_percent2"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col4_amount2"></tbltax> <br> <tbltax id="0col4_percent2"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col5_amount2"></tbltax> <br> <tbltax id="0col5_percent2"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col6_amount2"></tbltax> <br> <tbltax id="0col6_percent2"></tbltax> </td>
                                     </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                    </div><!---content-->
                </div>
                </div>
            </div><!---modal-->

            <!-- WEEKLY -->

            <div id="modal_view_tax_weekly" class="modal fade" tabindex="-1" role="dialog"><!--modal-->
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#2ecc71;">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title" style="color:#ecf0f1;"><span id="modal_mode"> </span>Withholding Tax Table (Weekly)</h4>
                            <p style="color:white;margin:0px;" id="dataname">   </p>
                        </div>

                        <div class="modal-body">
                            <table id="tbl_view_tax" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <!-- WEEKLY -->
                                    <tr>
                                        <th></th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>6</th>
                                    </tr>

                                    <tr>
                                        <td><b>Compensation Level (CL)</b></td>
                                        <td><tbltax id="0col1_cl3"></tbltax> <br> <below class="below"></below></td>
                                        <td><tbltax id="0col2_cl3"></tbltax></td>
                                        <td><tbltax id="0col3_cl3"></tbltax></td>
                                        <td><tbltax id="0col4_cl3"></tbltax></td>
                                        <td><tbltax id="0col5_cl3"></tbltax></td>
                                        <td><tbltax id="0col6_cl3"></tbltax></td>
                                     </tr>
                                     <tr>
                                        <td><b>Prescribed Minimum Withholding Tax</b></td>
                                        <td class="tdTax"><tbltax id="0col1_amount3"></tbltax> <br> <tbltax id="0col1_percent3"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col2_amount3"></tbltax> <br> <tbltax id="0col2_percent3"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col3_amount3"></tbltax> <br> <tbltax id="0col3_percent3"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col4_amount3"></tbltax> <br> <tbltax id="0col4_percent3"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col5_amount3"></tbltax> <br> <tbltax id="0col5_percent3"></tbltax> </td>
                                        <td class="tdTax"><tbltax id="0col6_amount3"></tbltax> <br> <tbltax id="0col6_percent3"></tbltax> </td>
                                     </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                    </div><!---content-->
                </div>
                </div>
            </div><!---modal-->
<?php echo $_rights; ?>
<script src="assets/plugins/formatter/autoNumeric.js" type="text/javascript"></script>
<script src="assets/plugins/formatter/accounting.js" type="text/javascript"></script>
<script>

$(document).ready(function(){
    var dt; var _txnMode; var _selectedID; var _selectRowObj;

    var initializeControls=function(){
        dt=$('#tbl_wtax_list').DataTable({
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ajax" : "RefWTax/transaction/list",
            "columns": [
                {
                    "targets": [0],
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { targets:[1],data: "payment_type" }

            ],
            language: {
                         searchPlaceholder: "Search Tax Table"
                     },
            "rowCallback":function( row, data, index ){

                $(row).find('td').eq(5).attr({
                    "align": "right"
                });
            }
        });






        $('.numeric').autoNumeric('init');


    }();

    var bindEventHandlers=(function(){
        var detailRows = [];

        $('#tbl_wtax_list tbody').on( 'click', 'tr td.details-control', function () {
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.ref_payment_type_id;

            	if(_selectedID==2){
		            $('#modal_view_tax_monthly').modal('show');
			            viewTaxMonthly().done(function(response){

                            $('.below').text('below');

                            $('#0col1_cl').text(accounting.formatNumber(response.data[0].col1_cl) + ' and');
                            $('#0col2_cl').text(accounting.formatNumber(response.data[0].col2_cl));
                            $('#0col3_cl').text(accounting.formatNumber(response.data[0].col3_cl));
                            $('#0col4_cl').text(accounting.formatNumber(response.data[0].col4_cl));
                            $('#0col5_cl').text(accounting.formatNumber(response.data[0].col5_cl));
                            $('#0col6_cl').text(accounting.formatNumber(response.data[0].col6_cl));

                            $('#0col1_amount').text(accounting.formatNumber(response.data[0].col1_amount,2));
                            $('#0col2_amount').text(accounting.formatNumber(response.data[0].col2_amount,2));
                            $('#0col3_amount').text(accounting.formatNumber(response.data[0].col3_amount,2));
                            $('#0col4_amount').text(accounting.formatNumber(response.data[0].col4_amount,2));
                            $('#0col5_amount').text(accounting.formatNumber(response.data[0].col5_amount,2));
                            $('#0col6_amount').text(accounting.formatNumber(response.data[0].col6_amount,2));

                            $('#0col2_percent').text(('+' + response.data[0].col2_percent*100) + '% over CL' );
                            $('#0col3_percent').text(('+' + response.data[0].col3_percent*100) + '% over CL' );
                            $('#0col4_percent').text(('+' + response.data[0].col4_percent*100) + '% over CL' );
                            $('#0col5_percent').text(('+' + response.data[0].col5_percent*100) + '% over CL' );
                            $('#0col6_percent').text(('+' + response.data[0].col6_percent*100) + '% over CL' );
		                })
				}

				else if(_selectedID==1) {
					$('#modal_view_tax_semimonthly').modal('show');
					viewTaxSemiMonthly().done(function(response){

			            	$('.below').text('below');

                            $('#0col1_cl1').text(accounting.formatNumber(response.data[0].col1_cl) + ' and');
                            $('#0col2_cl1').text(accounting.formatNumber(response.data[0].col2_cl));
                            $('#0col3_cl1').text(accounting.formatNumber(response.data[0].col3_cl));
                            $('#0col4_cl1').text(accounting.formatNumber(response.data[0].col4_cl));
                            $('#0col5_cl1').text(accounting.formatNumber(response.data[0].col5_cl));
                            $('#0col6_cl1').text(accounting.formatNumber(response.data[0].col6_cl));

                            $('#0col1_amount1').text(accounting.formatNumber(response.data[0].col1_amount,2));
                            $('#0col2_amount1').text(accounting.formatNumber(response.data[0].col2_amount,2));
                            $('#0col3_amount1').text(accounting.formatNumber(response.data[0].col3_amount,2));
                            $('#0col4_amount1').text(accounting.formatNumber(response.data[0].col4_amount,2));
                            $('#0col5_amount1').text(accounting.formatNumber(response.data[0].col5_amount,2));
                            $('#0col6_amount1').text(accounting.formatNumber(response.data[0].col6_amount,2));

                            $('#0col2_percent1').text(('+' + response.data[0].col2_percent*100) + '% over CL' );
                            $('#0col3_percent1').text(('+' + response.data[0].col3_percent*100) + '% over CL' );
                            $('#0col4_percent1').text(('+' + response.data[0].col4_percent*100) + '% over CL' );
                            $('#0col5_percent1').text(('+' + response.data[0].col5_percent*100) + '% over CL' );
                            $('#0col6_percent1').text(('+' + response.data[0].col6_percent*100) + '% over CL' );
		                })
				}

				else if(_selectedID==3) {
					$('#modal_view_tax_daily').modal('show');
					viewTaxDaily().done(function(response){

			            	
                            $('.below').text('below');

                            $('#0col1_cl2').text(accounting.formatNumber(response.data[0].col1_cl) + ' and');
                            $('#0col2_cl2').text(accounting.formatNumber(response.data[0].col2_cl));
                            $('#0col3_cl2').text(accounting.formatNumber(response.data[0].col3_cl));
                            $('#0col4_cl2').text(accounting.formatNumber(response.data[0].col4_cl));
                            $('#0col5_cl2').text(accounting.formatNumber(response.data[0].col5_cl));
                            $('#0col6_cl2').text(accounting.formatNumber(response.data[0].col6_cl));

                            $('#0col1_amount2').text(accounting.formatNumber(response.data[0].col1_amount,2));
                            $('#0col2_amount2').text(accounting.formatNumber(response.data[0].col2_amount,2));
                            $('#0col3_amount2').text(accounting.formatNumber(response.data[0].col3_amount,2));
                            $('#0col4_amount2').text(accounting.formatNumber(response.data[0].col4_amount,2));
                            $('#0col5_amount2').text(accounting.formatNumber(response.data[0].col5_amount,2));
                            $('#0col6_amount2').text(accounting.formatNumber(response.data[0].col6_amount,2));

                            $('#0col2_percent2').text(('+' + response.data[0].col2_percent*100) + '% over CL' );
                            $('#0col3_percent2').text(('+' + response.data[0].col3_percent*100) + '% over CL' );
                            $('#0col4_percent2').text(('+' + response.data[0].col4_percent*100) + '% over CL' );
                            $('#0col5_percent2').text(('+' + response.data[0].col5_percent*100) + '% over CL' );
                            $('#0col6_percent2').text(('+' + response.data[0].col6_percent*100) + '% over CL' );
		                })
				}

                else if(_selectedID==4) {
                    $('#modal_view_tax_weekly').modal('show');
                    viewTaxWeekly().done(function(response){

                            $('.below').text('below');

                            $('#0col1_cl3').text(accounting.formatNumber(response.data[0].col1_cl) + ' and');
                            $('#0col2_cl3').text(accounting.formatNumber(response.data[0].col2_cl));
                            $('#0col3_cl3').text(accounting.formatNumber(response.data[0].col3_cl));
                            $('#0col4_cl3').text(accounting.formatNumber(response.data[0].col4_cl));
                            $('#0col5_cl3').text(accounting.formatNumber(response.data[0].col5_cl));
                            $('#0col6_cl3').text(accounting.formatNumber(response.data[0].col6_cl));

                            $('#0col1_amount3').text(accounting.formatNumber(response.data[0].col1_amount,2));
                            $('#0col2_amount3').text(accounting.formatNumber(response.data[0].col2_amount,2));
                            $('#0col3_amount3').text(accounting.formatNumber(response.data[0].col3_amount,2));
                            $('#0col4_amount3').text(accounting.formatNumber(response.data[0].col4_amount,2));
                            $('#0col5_amount3').text(accounting.formatNumber(response.data[0].col5_amount,2));
                            $('#0col6_amount3').text(accounting.formatNumber(response.data[0].col6_amount,2));

                            $('#0col2_percent3').text(('+' + response.data[0].col2_percent*100) + '% over CL' );
                            $('#0col3_percent3').text(('+' + response.data[0].col3_percent*100) + '% over CL' );
                            $('#0col4_percent3').text(('+' + response.data[0].col4_percent*100) + '% over CL' );
                            $('#0col5_percent3').text(('+' + response.data[0].col5_percent*100) + '% over CL' );
                            $('#0col6_percent3').text(('+' + response.data[0].col6_percent*100) + '% over CL' );
                        })
                }

        } );

        $('#btn_new').click(function(){
            clearFields($('#frm_wtax'))
            _txnMode="new";
            hideemployeeList();
            hideRatesduties();
            showemployeeFields();
        });

        $('#tbl_wtax_list tbody').on('click','button[name="edit_duties"]',function(){

            _txnMode="ratesduties";
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.employee_id;
            _selectedname= '[Name : ' + data.emp_fname +' ' + data.emp_mname + ' ' + data.emp_lname + '] ' + '[Position :null]';
            $('#dataname').text(_selectedname);
            //alert(_selectedID);
            hideemployeeList();
            hideemployeeFields();
            showRatesduties();
            getratesandduties();
        });

        $('#tbl_wtax_list tbody').on('click','button[name="edit_info"]',function(){
            _txnMode="edit";
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.employee_id;

			$('#emp_civilstatus').val(data.emp_civilstatus);
            $('#emp_religion').val(data.emp_religion);
            $('#emp_religion').val(data.emp_religion);
            $('#emp_processaccount').val(data.emp_processaccount);
            $('#emp_taxcode').val(data.emp_taxcode);
            $('#emp_exemptss').val(data.emp_exemptss);
            $('#emp_exemptphilhealth').val(data.emp_exemptphilhealth);
            $('#emp_exemptpagibig').val(data.emp_exemptphilhealth);

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

            hideRatesduties();
            hideemployeeList();
            showemployeeFields();

        });

        $('#tbl_wtax_list tbody').on('click','button[name="remove_info"]',function(){
            _selectRowObj=$(this).closest('tr');
            var data=dt.row(_selectRowObj).data();
            _selectedID=data.employee_id;

            $('#modal_confirmation').modal('show');
        });

        $('#btn_yes').click(function(){
            removeEmployee().done(function(response){
                showNotification(response);
                dt.row(_selectRowObj).remove().draw();
            });
        });

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
        $('#btn_cancelempfields').click(function(){
            hideemployeeFields();
            hideRatesduties();
            showemployeeList();
        });

        $('#btn_cancelratesandduties').click(function(){
            hideRatesduties();
            hideemployeeFields();
            showemployeeList();
            dt_rates.destroy();
        });

        $('#btn_save').click(function(){
            if(validateRequiredFields($('#frm_wtax'))){
                if(_txnMode=="new"){
                    createEmployee().done(function(response){
                        showNotification(response);
                        dt.row.add(response.row_added[0]).draw();
                        clearFields($('#frm_wtax'))

                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                    return;
                }

                if(_txnMode=="edit"){
                    updateEmployee().done(function(response){
                        showNotification(response);
                        dt.row(_selectRowObj).data(response.row_updated[0]).draw();
                        clearFields($('#frm_wtax'))
                        showList(true);
                    }).always(function(){
                        showSpinningProgress($('#btn_save'));
                    });
                    return;
                }
            }
        });

        $('#btn_saveratesandduties').click(function(){
            if(validateRequiredFields($('#frm_ratesandduties'))){
                if(_txnMode=="ratesduties"){
                    createRatesandDuties().done(function(response){
                        showNotification(response);
                        dt.row.add(response.row_added[0]).draw();
                        clearFields($('#frm_ratesandduties'))

                    }).always(function(){

                    });
                    return;
                }

                else{
                    //do nothing :D
                }
            }
        });

    })();


    var validateRequiredFields=function(f){
        var stat=true;

        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',f).each(function(){


                if($(this).val()==""){
                    showNotification({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }

        });

        return stat;
    };

    var viewTaxMonthly=function(){
        var _data=$('#').serializeArray();
        _data.push({name : "ref_payment_type_id" ,value : _selectedID});
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"RefWTax/transaction/taxMonthly",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var viewTaxSemiMonthly=function(){
        var _data=$('#').serializeArray();
        _data.push({name : "ref_payment_type_id" ,value : _selectedID});
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"RefWTax/transaction/taxSemiMonthly",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var viewTaxDaily=function(){
        var _data=$('#').serializeArray();
        _data.push({name : "ref_payment_type_id" ,value : _selectedID});
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"RefWTax/transaction/taxDaily",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var viewTaxWeekly=function(){
    	var _data=$('#').serializeArray();
    	_data.push({name : "ref_payment_type_id" ,value : _selectedID});
    	return $.ajax({
    		"dataType":"json",
    		"type":"POST",
    		"url":"RefWTax/transaction/taxWeekly",
    		"beforesend": showSpinningProgress($('#btn_save'))
    	});
    };

    var createEmployee=function(){
        var _data=$('#frm_wtax').serializeArray();

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"RefWTax/transaction/create",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var createRatesandDuties=function(){
        var _data=$('#frm_wtax').serializeArray();
        _data.push({name : "employee_id" ,value : _selectedID});
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"RatesDuties/transaction/testlist",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var updateEmployee=function(){
        var _data=$('#frm_wtax').serializeArray();

        console.log(_data);
        _data.push({name : "employee_id" ,value : _selectedID});
        //_data.push({name:"is_inventory",value: $('input[name="is_inventory"]').val()});

        //alert($('input[name="is_inventory"]').val());
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"RefWTax/transaction/update",
            "data":_data,
            "beforeSend": showSpinningProgress($('#btn_save'))
        });
    };

    var removeEmployee=function(){
        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"RefWTax/transaction/delete",
            "data":{employee_id : _selectedID}
        });
    };

    var showList=function(b){
        if(b){
            $('#div_product_list').show();
            $('#div_product_fields').hide();
        }else{
            $('#div_product_list').hide();
            $('#div_product_fields').show();
        }
    };

    var hideemployeeList=function(){
         $('#div_product_list').hide();
    };

    var showemployeeList=function(){
        $('#div_product_list').show();
    };

    var hideemployeeFields=function(){
        $('#div_product_fields').hide();
    };

    var showemployeeFields=function(){
        $('#div_product_fields').show();
    };

    var hideRatesduties=function(){
        $('#div_rates_duties_list').hide();
    };

    var showRatesduties=function(){
        $('#div_rates_duties_list').show();
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
        $(e).find('span').toggleClass('glyphicon glyphicon-refresh spinning');
    };

    var clearFields=function(f){
        $('input,textarea',f).val('');
        $(f).find('input:first').focus();
    };

    function format ( d ) {
        return '<div class="container-fluid">'+
        '<div class="col-md-12">'+
        '<h3 class="boldlabel"> ' + d.col5_amount +' ' + d.col5 + ' ' +d.emp_lname + '</h3>'+
        '<p>[ SAMPLE : '+d.tax_code+'] [ ID : '+d.ref_payment_type_id+' ]</p>'+
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

</html>
