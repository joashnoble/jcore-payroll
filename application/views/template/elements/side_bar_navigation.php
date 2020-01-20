<div class="static-sidebar-wrapper sidebar-black">
    <div class="static-sidebar">
        <div class="sidebar">
            <div class="widget">
                <div class="widget-body">
                    <div class="userinfo">
                        <div class="avatar">
                            <img src="<?php echo $this->session->main_directory.'/'.$this->session->user_photo; ?>" class="img-responsive img-circle" style="height:100%;">
                        </div>
                        <div class="info">
                            <span class="username"><?php echo $this->session->user_fullname; ?></span>
                            <span class="useremail"><?php echo $this->session->user_email; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget stay-on-collapse" id="widget-sidebar">
                <nav role="navigation" class="widget-body">
                    <ul class="acc-menu">
                        <li class="nav-separator"><span>Explore</span></li>
                        <li><a href="Dashboard"><i class="ti ti-home"></i><span>Dashboard</span></a></li>
                        <li class="right_payrollparent_view"><a href="javascript:void();"><i class="fa fa-pie-chart" aria-hidden="true"></i><span>Payroll</span></a>
                            <ul class="acc-menu">
                                <li class="right_dtr_view"><a href="Payroll" class="departmentjs" id="departmentjs">Daily time Record</a>
                                </li>
                                <li class="right_processpayroll_view"><a href="ProcessPayroll" class="departmentjs" id="departmentjs">Process Payroll</a>
                                </li>
                                <li class="right_payslip_view"><a href="PaySlip" class="departmentjs" id="departmentjs">Pay Slip</a>
                                </li>
                                <!-- <li class="right_loanadjustment_view"><a href="javascript:void();" class="closingadjustments" id="closingadjustments">Loans/Advances Adjustments</a>
                                </li> -->
                                <li class="right_dtrverification_view"><a href="DtrVerification" class="" id="">DTR Verification List</a>
                                </li>
                                <!-- <li><a href="PayrollSummary" class="" id="payroll_register_summary">Payroll Register (Summary)</a>
                                </li> -->
                                <li class="right_payrollhistory_view"><a href="EmployeePayrollHistory" class="" id="employee_payroll_history">Employee Payroll History</a>
                                </li>
                                <li class="right_monthlypayroll_view"><a href="EmployeeMonthlyPayrollSalary" class="" id="employee_monthly_salary">Employee Monthly Salary</a>
                                </li>
                                <li class="right_yearlypayroll_view"><a href="EmployeeYearlyPayrollSalary" class="" id="employee_yearly_salary">Employee Yearly Salary</a>
                                </li>
                                <li class="right_ledger_view"><a href="EmployeeLedgers" class="" id="employee_loan_ledger">Employee Ledgers</a>
                                </li>
                                <li class="right_13thmonthpay_view"><a href="Employee13thMonthPay" class="" id="13thmonth_pay">Process 13th Month</a>
                                </li>
                                <li class="right_emp_13thmonthpay_view"><a href="Emp13thMonthPay" class="" id="13thmonth_pay">13th Month Pay</a>
                                </li>
                                <li class="right_employee_compensation_view"><a href="EmployeeCompensation">Employee Compensation</a>
                                </li>
                                <li class="right_employee_deduction_view"><a href="EmployeeDeductionHistory">Employee Deduct. History</a>
                                </li>
                                <li class="right_alphalist_view"><a href="AlphaList">Alpha List of Employee</a></li>
                                <li class="right_1601C_report_view"><a href="Report1601C">1601C Report</a></li>
                                <li class="right_monthly_work_hours_view"><a href="MonthlyWorkedHours">Monthly Worked Hours</a></li>
                                <li class="right_monthly_loan_view"><a href="MonthlyLoan">Monthly Loan Report</a></li>
                            </ul>
                        </li>
                        <li class="right_payroll_register_view"><a href="javascript:void();"><i class="fa fa-file-text" aria-hidden="true"></i><span>Payroll Register</span></a>
                            <ul class="acc-menu">
                                <li class="right_13thmonthpay_register_view"><a href="Employee13thMonthPay_register" class="">13th Month Register</a></li>
                                <li class="right_payroll_register_waccount_view"><a href="EmployeePayrollRegister" class="">Payroll Register W/ Accounts</a>
                                </li>
                                <li class="right_payroll_register_cash_view"><a href="EmployeePayrollRegisterCash" class="">Payroll Register Cash</a>
                                </li>
                                <li class="right_payrollsummary_view"><a href="EmployeePayrollSummary" class="">Payroll Summary</a>
                                </li>
                            </ul>
                        </li>
                        <li class="right_payrollreports_view"><a href="javascript:void();"><i class="fa fa-file-text" aria-hidden="true"></i><span>Payroll Reports</span></a>
                            <ul class="acc-menu">
                                <li class="right_sssreport_view"><a href="SSSReport" class="" id="sss_list_reports">SSS Report</a>
                                </li>
                                <li class="right_philhealthreport_view"><a href="PHILHEALTHReport" class="" id="philhealth_list_reports">PHILHEALTH Report</a>
                                </li>
                                <li class="right_pagibigreport_view"><a href="PagIbigReports" class="" id="pagibig_list_reports">Pag-Ibig Report</a>
                                </li>
                                <li class="right_wtaxreport_view"><a href="WTaxReports" class="" id="wtax_list_reports">WTAX Reports</a>
                                </li>
                                <li class="Bir2316 right_bir2316_view"><a href="Bir2316" class="" id="">BIR FORM 2316</a>
                                </li>
                            </ul>
                        </li>
                        <li class="right_payrollreferenceparent_view"><a href="javascript:void();"><i class="fa fa-folder" aria-hidden="true"></i><span>Payroll References</span></a>
                            <ul class="acc-menu">
                                <li class="right_clearancereason_view"><a href="RefClearanceReason" class="departmentjs" id="  departmentjs">Clearance Reason</a>
                                </li>
                                <li class="right_payperiod_view"><a href="RefPayPeriodSetup" class="departmentjs" id="  departmentjs">Pay Period</a>
                                </li>
                                <li class="right_earningtype_view"><a href="RefEarningType" class="departmentjs" id="departmentjs">Earning Type</a>
                                <li class="right_earningsetup_view"><a href="RefEarningSetup" class="departmentjs" id="departmentjs">Earning Setup</a>
                                </li>
                                </li>
                                <li class="right_deductiontype_view"><a href="RefDeductionType" class="departmentjs" id="departmentjs">Deduction Type</a>
                                </li>
                                <li class="right_deductionsetup_view"><a href="RefDeductionSetup" class="departmentjs" id="departmentjs">Deduction Setup</a>
                                </li>
                                <li class="right_deductionperiod_view"><a href="AdvancedSettings" class="departmentjs" id="">Deduction Period</a>
                                </li>
                                <li class="right_taxtable_view"><a href="RefWTax" class="" id="departmentjs">Tax File</a>
                                </li>
                            </ul>
                        </li>  
                        <li class="right_employeeclearance_view"><a href="EmployeeClearance"><i class="fa fa-user"></i><span>Employee Clearance / Exit</span></a></li>
                        <li class="right_adminparent_view"><a href="javascript:void();"><i class="fa fa-cog" aria-hidden="true"></i><span>Settings</span></a>
                            <ul class="acc-menu">
                                <li class="right_useracccount_view"><a href="Users" class="usersjs" id="departmentjs">User Account</a>
                                </li>
                                <li class="right_usergroup_view"><a href="UserGroups" class="" id="departmentjs">User Group</a>
                                </li>
                                <li class="right_reffactorfile_view"><a href="RefFactorFile" class="" id="departmentjs">Factor File</a>
                                </li>

                            </ul>
                        </li> 
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- MODAL HRIS REPORTS -->

  <div class="modal fade" id="modal_adjustments_closing" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color:#e67e22;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:white;">Loans Adjustments & Advances Closing</h4>
        </div>
        <div class="modal-body" style="padding-top:0px;padding-bottom:0px;margin-top:0px;">
            <div class="container-fluid">
                <div class="col-md-4">
                    <h4>Employee :</h4>
                    <div id="select2fix"></div>
                    <select class="form-control" name="employee_loan_filter_closing" id="employee_loan_filter_closing" data-error-msg="Type of Loan is required" required>
                        <?php
                            $employee_loan_list = $this->db->query('SELECT employee_id,CONCAT(el.first_name," ",el.middle_name," ",el.last_name) as fullname FROM employee_list as el WHERE is_deleted=0');
                                                                foreach($employee_loan_list->result() as $emp_loan)
                                                                {
                                                                    echo '<option value="'.$emp_loan->employee_id  .'">'.$emp_loan->fullname.'</option>';
                                                                }
                                                                ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <h4>Type of Loan :</h4>
                    <select class="form-control" name="employee_loan_type_filter_closing" id="employee_loan_type_filter_closing" data-error-msg="Type of Loan is required" required>
                        <?php
                            $deduction_loan = $this->db->query('SELECT deduction_id,deduction_desc FROM refdeduction WHERE deduction_id=5 OR deduction_id=6
                                                                OR deduction_id=7 OR deduction_id=8 OR deduction_id=9');
                                                                foreach($deduction_loan->result() as $loans)
                                                                {
                                                                    echo '<option value="'.$loans->deduction_id  .'">'.$loans->deduction_desc.'</option>';
                                                                }
                                                                ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <h4>Loan Amount : <totalloanamount id="totalloanamountclosing"style="color:#27ae60;"></totalloanamount></h4>
                    <h4>Deduct Per Pay : <deductperpay id="deductperpayclosing" style="color:#c0392b;"></deductperpay></h4>
                    <h4>Loan Balance : <loanbalance id="loanbalanceclosing" style="color:#2980b9;"></loanbalance></h4>
                </div>
                <div class="col-md-12">
                    <form id="frm_loans_closing">
                    <div style="height:1px;background-color:#95a5a6"></div>
                    <div class="col-md-12">
                            <div class="form-group">
                            <h5>Particular :</h5>
                            <input type="text" id="particular" name="particular" class="form-control" placeholder="XXXXXX"data-error-msg="Particular required" required>
                            </div>
                    </div>
                    <div class="col-md-8">
                        <div class="col-md-6">
                            <input type="hidden" name="reg_id_loan" id="reg_id_loan">
                            <h5>Debit :</h5>
                            <div class="form-group">
                            <input type="text" id="debitloan" name="debitloan" class="form-control numeric" value="0.00" data-error-msg="Debit is required" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Credit :</h5>
                            <div class="form-group">
                            <input type="text" id="creditloan" name="creditloan" class="form-control numeric" value="0.00" data-error-msg="Credit is required" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Date : </h5>
                            <div class="form-group">
                            <input class="form-control date-picker" name="date_adjusted" id="date_adjusted" data-error-msg="Date is required" required></input>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Reason : </h5>
                            <div class="form-group">
                            <textarea class="form-control" name="reasonloan" rows="3" id="reasonloan" data-error-msg="Reason is required" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h3>Details</h3>
                        <h4>New Loan Balance : <newval style="color:#27ae60;" id="newval"></newval></h4>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn" id="btn_closing_loans_save" style="background-color:#27ae60;color:white;">Save changes</button>
        </div>
      </div>

    </div>
  </div>

  <div class="modal fade" id="modal_payroll_register_summary" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Payroll Register (Summary)</h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid" id="payroll_register_summary_preview" style="overflow:scroll;width:100%;">

          </div>
        </div>
        <div class="modal-footer">
            <div class="form-group">
                <label class="col-sm-3" style="float:left;" for="inputEmail1">Branch Filter :</label>
                <div class="col-sm-5">
                    <select class="form-control" name="payroll_summary_filter_branch" id="payroll_summary_filter_branch" data-error-msg="Branch Filter is required" required>
                        <option value="all">All</option>
                        <?php
                            $branch_choice = $this->db->get_where('ref_branch', array('is_deleted' => FALSE));
                            foreach($branch_choice->result() as $branch)
                                {
                                    echo '<option value="'.$branch->ref_branch_id  .'">'.$branch->branch.'</option>';
                                }
                            ?>
                    </select>
                </div>
                <button type="button" class="btn col-sm-3" id="print_payroll_register_summary" style="background-color:#27ae60;color:white;">PRINT</button>
            </div>
            <div class="form-group">
                <label class="col-sm-3" style="float:left;" for="inputEmail1">Month Filter :</label>
                <div class="col-sm-5">
                    <select class="form-control" name="payroll_register_month_filter" id="payroll_register_month_filter" data-error-msg="Payroll Register Month Filter is required" required>
                        <option value="all">All</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <button type="button" class="btn col-sm-3" id="download_payroll_register_summary" style="background-color:#27ae60;color:white;">Download PDF</button>
            </div>
        </div>
      </div>

    </div>
  </div>
<script>
var f_dept; var f_branch; var m_branch; var _default_emp="all"; var n; var p_branch;
var _default_emp_monthly="all"; var _default_emp_yearly="all"; var _default_emp_13="all";
var m; var y;
$(document).ready(function(){
        var getemployee=function(){
            var _data=$('#').serializeArray();

        return $.ajax({
            "dataType":"json",
            "type":"POST",
            "url":"Employee/transaction/active",
            "data":_data
            });
        };

        var getpayrollhistory=function(){
            $.ajax({
            "dataType":"html",
            "type":"POST",
            "url":"PayrollHistory/layout/employeee-payroll-history/"+_default_emp+"/"+n+"/"+p_branch+"/fullview",
            beforeSend : function(){
                        $('#employee_payroll_history_preview').html("<center><img src='assets/img/loader/preloaderimg.gif'><h3>Loading...</h3></center>");
                    },
                }).done(function(response){
                    $('#employee_payroll_history_preview').html(response);
                });
        }

        var getmonthlysalary=function(){
            $.ajax({
            "dataType":"html",
            "type":"POST",
            "url":"PayrollHistory/layout/employeee-monthly-salary/"+_default_emp_monthly+"/"+m+"/"+p_branch+"/fullview",
            beforeSend : function(){
                        $('#employee_monthly_salary_preview').html("<center><img src='assets/img/loader/preloaderimg.gif'><h3>Loading...</h3></center>");
                    },
                }).done(function(response){
                    $('#employee_monthly_salary_preview').html(response);
                });
        }

        var getyearlysalary=function(){
            $.ajax({
            "dataType":"html",
            "type":"POST",
            "url":"PayrollHistory/layout/employeee-yearly-salary/"+_default_emp_yearly+"/"+y+"/"+p_branch+"/fullview",
            beforeSend : function(){
                        $('#employee_yearly_salary_preview').html("<center><img src='assets/img/loader/preloaderimg.gif'><h3>Loading...</h3></center>");
                    },
                }).done(function(response){
                    $('#employee_yearly_salary_preview').html(response);
                });
        }

        var get13thmonthpay=function(){
            $.ajax({
            "dataType":"html",
            "type":"POST",
            "url":"PayrollHistory/layout/employeee-13thmonth-pay/"+_default_emp_13+"/"+n+"/"+p_branch+"/fullview",
            beforeSend : function(){
                        $('#13thmonthpay_preview').html("<center><img src='assets/img/loader/preloaderimg.gif'><h3>Loading...</h3></center>");
                    },
                }).done(function(response){
                    $('#13thmonthpay_preview').html(response);
                });
        }

        $("#closingadjustments").click(function(){
            var employee_loan_filter= $('#employee_loan_filter_closing').val();
            var employee_loan_type_filter= $('#employee_loan_type_filter_closing').val();
            getemployeeloantotalamountclosing(employee_loan_filter,employee_loan_type_filter);
            $('#modal_adjustments_closing').modal('toggle');
            recomputebalclosing();
        });

        $("#employee_loan_filter_closing").change(function(){
            var employee_loan_filter= $('#employee_loan_filter_closing').val();
            var employee_loan_type_filter= $('#employee_loan_type_filter_closing').val();
            getemployeeloantotalamountclosing(employee_loan_filter,employee_loan_type_filter);
        });

        $("#employee_loan_type_filter_closing").change(function(){
            var employee_loan_filter= $('#employee_loan_filter_closing').val();
            var employee_loan_type_filter= $('#employee_loan_type_filter_closing').val();
            getemployeeloantotalamountclosing(employee_loan_filter,employee_loan_type_filter);
        });

        $("#creditloan").keyup(function(){
            recomputebalclosingadd();
        });

        $("#debitloan").keyup(function(){
            recomputebalclosingadd();
        });

        var recomputebalclosingadd=function(){
            var loanbaltemp = $('#loanbalanceclosing').text() || 0;
            var loanbalanceclosing = loanbaltemp.replace(/,/g, "");

            var creditloantemp = $('#creditloan').val() || 0;
            var creditloan = creditloantemp.replace(/,/g, "");
            /*alert(debitloan);*/
            var debitloantemp = $('#debitloan').val() || 0;
            var debitloan = debitloantemp.replace(/,/g, "");
            var totalnewval = Math.abs(parseInt(loanbalanceclosing) - (parseInt(debitloan)-parseInt(creditloan)));
            $('#newval').text(accounting.formatNumber(totalnewval,2));
            /*alert('aw');*/
        }


        // $("#employee_loan_ledger").click(function(){
        //     var employee_loan_filter= $('#employee_loan_filter').val();
        //     var employee_loan_type_filter= $('#employee_loan_type_filter').val();
        //     getemployeeloantotalamount(employee_loan_filter,employee_loan_type_filter);
        //     getemployeeloanledger(employee_loan_filter,employee_loan_type_filter);
        //     $('#modal_employee_loan_ledger').modal('toggle');
        // });
        //
        // $("#employee_loan_filter").change(function(){
        //     var employee_loan_filter= $('#employee_loan_filter').val();
        //     var employee_loan_type_filter= $('#employee_loan_type_filter').val();
        //     getemployeeloantotalamount(employee_loan_filter,employee_loan_type_filter);
        //     getemployeeloanledger(employee_loan_filter,employee_loan_type_filter);
        // });
        //
        // $("#employee_loan_type_filter").change(function(){
        //     var employee_loan_filter= $('#employee_loan_filter').val();
        //     var employee_loan_type_filter= $('#employee_loan_type_filter').val();
        //     getemployeeloantotalamount(employee_loan_filter,employee_loan_type_filter);
        //     getemployeeloanledger(employee_loan_filter,employee_loan_type_filter);
        // });
        //
        // /*$("#print_employee_ledger").click(function(){
        //     var employee_loan_filter= $('#employee_loan_filter').val();
        //     var employee_loan_type_filter= $('#employee_loan_type_filter').val();
        //     window.open('PayrollReports/payrollreports/payroll-employee-ledger/'+employee_loan_filter+'/'+employee_loan_type_filter+'/0/preview', '_blank');
        //     //alert(_selectedID);
        // });*/
        //
        // $('#print_employee_ledger').click(function(event){
        //     /*printing_notif();*/
        //     var currentURL = window.location.href;
        //     var output = currentURL.match(/^(.*)\/[^/]*$/)[1];
        //     output = output+"/assets/css/css_special_files.css";
        //     $("#employee_loans_ledger_view").printThis({
        //         debug: false,
        //         importCSS: true,
        //         importStyle: false,
        //         printContainer: false,
        //         loadCSS: output,
        //         formValues:false
        //     });
        //
        // });
        //
        // $("#download_employee_ledger").click(function(){
        //     var employee_loan_filter= $('#employee_loan_filter').val();
        //     var employee_loan_type_filter= $('#employee_loan_type_filter').val();
        //     window.open('PayrollReports/payrollreports/payroll-employee-ledger/'+employee_loan_filter+'/'+employee_loan_type_filter+'/0/pdf', '_blank');
        //     //alert(_selectedID);
        // });
        //
        // var getemployeeloanledger=function(employee_loan_filter,employee_loan_type_filter){
        //     $.ajax({
        //     "dataType":"html",
        //     "type":"POST",
        //     "url":"PayrollReports/payrollreports/payroll-employee-ledger/"+employee_loan_filter+"/"+employee_loan_type_filter+"/0/fullview",
        //     beforeSend : function(){
        //                 $('#employee_loans_ledger_view').html("<center><img src='assets/img/loader/preloaderimg.gif'><h3>Loading...</h3></center>");
        //             },
        //     }).done(function(response){
        //         $('#employee_loans_ledger_view').html(response);
        //     });
        // }
        //
        // var getemployeeloantotalamountclosing=function(employee_loan_filter,employee_loan_type_filter){
        //     $.ajax({
        //     "dataType":"html",
        //     "type":"POST",
        //     "url":"PayrollReports/payrollreports/payroll-loan-amount-get/"+employee_loan_filter+"/"+employee_loan_type_filter+"/0/fullview",
        //     beforeSend : function(){
        //                 $('#employee_loans_ledger_view').html("<center><img src='assets/img/loader/preloaderimg.gif'><h3>Loading...</h3></center>");
        //             },
        //     }).done(function(response){
        //         var json = JSON.parse(response);
        //         /*alert(json.total_loan_amount);*/
        //
        //         $('#reg_id_loan').val(json.deduction_regular_id);
        //         $('#totalloanamountclosing').text(json.total_loan_amount);
        //         $('#deductperpayclosing').text(json.deduction_per_pay_amount);
        //         $('#loanbalanceclosing').text(json.deduction_total_amount);
        //         /*alert(json.deduction_regular_id);*/
        //     });
        // }
        //
        // var getemployeeloantotalamount=function(employee_loan_filter,employee_loan_type_filter){
        //     $.ajax({
        //     "dataType":"html",
        //     "type":"POST",
        //     "url":"PayrollReports/payrollreports/payroll-loan-amount-get/"+employee_loan_filter+"/"+employee_loan_type_filter+"/0/fullview",
        //     beforeSend : function(){
        //                 $('#employee_loans_ledger_view').html("<center><img src='assets/img/loader/preloaderimg.gif'><h3>Loading...</h3></center>");
        //             },
        //     }).done(function(response){
        //         var json = JSON.parse(response);
        //         /*alert(json.total_loan_amount);*/
        //         $('#totalloanamount').text(json.total_loan_amount);
        //         $('#deductperpay').text(json.deduction_per_pay_amount);
        //         $('#loanbalance').text(json.deduction_total_amount);
        //     });
        // }
        //
        // _employee_loan_filter=$("#employee_loan_filter").select2({
        // dropdownParent: $("#modal_employee_loan_ledger"),
        //     placeholder: "Select Employee",
        //     allowClear: true
        // });
        //
        //  _employee_loan_filter.select2('val', null);
        //
        // _employee_loan_filter_closing=$("#employee_loan_filter_closing").select2({
        // dropdownParent: $("#modal_adjustments_closing"),
        //     placeholder: "Select Employee",
        //     allowClear: true
        // });
        //
        //  _employee_loan_filter_closing.select2('val', null);
        //
        //  $('#btn_closing_loans_save').click(function(){
        //     if(validateRequiredFieldsside($('#frm_loans_closing'))){
        //         createAdjustment().done(function(response){
        //                     showNotificationside(response);
        //                 }).always(function(){
        //                     clearFields($('#frm_loans_closing'));
        //                     $.unblockUI();
        //                 });
        //     }
        //     else{
        //     }
        //
        // });

         var clearFields=function(f){
        $('input,textarea',f).val('');
        $('select',f).val(0);
        $(f).find('input:first').focus();
        };

        var createAdjustment=function(){
            var _data=$('#frm_loans_closing').serializeArray();
                return $.ajax({
                    "dataType":"json",
                    "type":"POST",
                    "url":"AdjustmentsClosing/transaction/create",
                    "data":_data,
                    "beforeSend": showSpinningProgressside($('#btn_save'))
            });
        };

        var showSpinningProgressside=function(e){
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

        var validateRequiredFieldsside=function(f){
        var stat=true;

        $('div.form-group').removeClass('has-error');
        $('input[required],textarea[required],select[required]',f).each(function(){

                if($(this).is('select')){
                if($(this).val()==0 || $(this).val()==null){
                    showNotificationside({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }

                }else{
                if($(this).val()==""){
                    showNotificationside({title:"Error!",stat:"error",msg:$(this).data('error-msg')});
                    $(this).closest('div.form-group').addClass('has-error');
                    $(this).focus();
                    stat=false;
                    return false;
                }
            }




        });

        return stat;
        };

        var showNotificationside=function(obj){
        PNotify.removeAll();
        new PNotify({
            title:  obj.title,
            text:  obj.msg,
            type:  obj.stat
        });

    };
        /*_employee_payrollhistory_filter=$("#payroll_history_filter_employee").select2({
        dropdownParent: $("#modal_employee_payroll_history"),
            placeholder: "Select Employee",
            allowClear: true
        });

         _employee_payrollhistory_filter.select2('val', null);*/



});
</script>
