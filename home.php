
<?php include("database.php"); ?>
<?php include("jdf.php"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- jvectormap -->
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <!-- DataTables -->
        <link href="assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css"/>        

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app-rtl.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/persian-datepicker.css" rel="stylesheet" type="text/css" />


        <style>
            th{
                color: black;
            }
        </style>

    </head>

    <body>

        <!-- Navigation Bar-->
        <?php include("header.php"); ?>
        <!-- End Navigation Bar-->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="wrapper">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="page-title-alt-bg"></div>
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">شفاف</a></li>
                            <li class="breadcrumb-item active">صفحه گزارشات</li>
                        </ol>
                    </div>
                    <h4 class="page-title">صفحه گزارشات</h4>
                </div> 
                <!-- end page title -->

                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="from_date">از تاریخ</label>
                            <input type="date" id="from_date" name="from_date" class="form-control" >
                        </div>
                        <div class="col-sm-4">
                            <label for="to_date">تا تاریخ</label>
                            <input type="date" id="to_date" name="to_date" class="form-control" >
                        </div>
                        <div class="col-sm-4">
                            <label for="submit_btn">.</label>
                            <input type="submit" id="submit_btn" value="جستجو" name="btn_search_submit" class="form-control btn btn-primary" >
                        </div>
                    </div>
                </form>
                <br>
                <?php
                if(isset($_POST["btn_search_submit"])){
                    $from_m = $_POST["from_date"];
                    $to_m = $_POST["to_date"];

                    echo '<h3 style="text-align:center;">گزارشات ('.$from_m.' - '.$to_m.')</h3>';

                    $sql_query_002 = mysqli_query($connection,"SELECT SUM(sale_minor.sale_rate * sale_minor.amount) as total_sold_price,(SELECT SUM(reciepts.amount/reciepts.rate) FROM reciepts WHERE reciepts.sale_id IS NOT NULL ) as total_reciepts, SUM((sale_minor.sale_rate - (purchase_minor.purchase_price + purchase_minor.extra_expense))  * sale_minor.amount) as total_profit FROM sale_minor LEFT JOIN purchase_minor ON purchase_minor.id = sale_minor.purchase_minor_id");

                    $sql_query_004 = mysqli_query($connection,"SELECT SUM((purchase_minor.purchase_price + purchase_minor.extra_expense) * purchase_minor.amount) as total_purchase_price,(SELECT SUM(reciepts.amount/reciepts.rate) FROM reciepts WHERE reciepts.purchase_id IS NOT NULL ) as total_reciepts,SUM((purchase_minor.amount - (SELECT SUM(sale_minor.amount) FROM sale_minor WHERE sale_minor.purchase_minor_id = purchase_minor.id)) * (purchase_minor.purchase_price + purchase_minor.extra_expense)) as total_remain_purchase_budgets FROM purchase_minor");

                    $sql_query_005 = mysqli_query($connection,"SELECT SUM(expenses.amount/expenses.rate) as total_expenses FROM expenses where expenses.date between '$from_m' and '$to_m'");


                }
                else
                {
                    $sql_query_002 = mysqli_query($connection,"SELECT SUM(sale_minor.sale_rate * sale_minor.amount) as total_sold_price,(SELECT SUM(reciepts.amount/reciepts.rate) FROM reciepts WHERE reciepts.sale_id IS NOT NULL ) as total_reciepts, SUM((sale_minor.sale_rate - (purchase_minor.purchase_price + purchase_minor.extra_expense))  * sale_minor.amount) as total_profit FROM sale_minor LEFT JOIN purchase_minor ON purchase_minor.id = sale_minor.purchase_minor_id");

                    $sql_query_004 = mysqli_query($connection,"SELECT SUM((purchase_minor.purchase_price + purchase_minor.extra_expense) * purchase_minor.amount) as total_purchase_price,(SELECT SUM(reciepts.amount/reciepts.rate) FROM reciepts WHERE reciepts.purchase_id IS NOT NULL ) as total_reciepts,SUM((purchase_minor.amount - (SELECT SUM(sale_minor.amount) FROM sale_minor WHERE sale_minor.purchase_minor_id = purchase_minor.id)) * (purchase_minor.purchase_price + purchase_minor.extra_expense)) as total_remain_purchase_budgets FROM purchase_minor");

                    $sql_query_005 = mysqli_query($connection,"SELECT SUM(expenses.amount/expenses.rate) as total_expenses FROM expenses");

                    

                }
                ?>
                <div class="row">
                    <div class="col-xl-3">

                        <div class="card-box widget-chart-one  bx-shadow-lg " style="color:black !important; border:1px solid green">
                        
                            <div class="widget-chart-one-content text-right" style="text-align:center !important;">
                                <p class="text-black mb-0 mt-2">بخش فروش</p>
                                <table class="table table-bordered table-striped">
                                    <?php 
                                    

                                    $fetch_002 = mysqli_fetch_assoc($sql_query_002);
                                    ?>
                                    <thead>
                                        <tr>
                                            <th>مجموع فروش</th>
                                            <th><?php echo $fetch_002["total_sold_price"]; ?> </th>
                                        </tr>
                                        <tr>
                                            <th>مجموع رسید</th>
                                            <th><?php echo round($fetch_002["total_reciepts"],2); ?> </th>
                                        </tr>
                                        <tr>
                                            <th>مجموع باقی</th>
                                            <th><?php echo round($fetch_002["total_sold_price"] - $fetch_002["total_reciepts"],2); ?> </th>
                                        </tr>
                                        <tr  class="bg bg-success">
                                            <th>مجموع فایده</th>
                                            <th ><?php echo round($fetch_002["total_profit"],2); ?> </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div> <!-- end card-box-->

                    </div> <!-- end col -->

                    <div class="col-xl-3">

                        <div class="card-box widget-chart-one  bx-shadow-lg " style="color:black !important; border:1px solid green">
                        
                            <div class="widget-chart-one-content text-right" style="text-align:center !important;">
                                <p class="text-black mb-0 mt-2">بخش خرید</p>
                                <table class="table table-bordered table-striped">
                                <?php 
                                   

                                    $fetch_004 = mysqli_fetch_assoc($sql_query_004);
                                ?>
                                    <thead>
                                        <tr>
                                            <th>مجموع خرید</th>
                                            <th><?php echo $fetch_004["total_purchase_price"]; ?> </th>
                                        </tr>
                                        <tr>
                                            <th>مجموع رسید</th>
                                            <th><?php echo round($fetch_004["total_reciepts"],2); ?> </th>
                                        </tr>
                                        <tr>
                                            <th>مجموع باقی</th>
                                            <th class="text text-danger"><?php echo $fetch_004["total_purchase_price"]-round($fetch_004["total_reciepts"],2); ?> </th>
                                        </tr>
                                        <tr>
                                            <th>مجموع سرمایه موجود خرید</th>
                                            <th><?php echo $fetch_004["total_remain_purchase_budgets"]; ?> </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div> <!-- end card-box-->

                    </div> <!-- end col -->
                    <div class="col-xl-3">

                        <div class="card-box widget-chart-one  bx-shadow-lg " style="color:black !important; border:1px solid green">
                        
                            <div class="widget-chart-one-content text-right" style="text-align:center !important;">
                                <p class="text-black mb-0 mt-2">بخش مصارفات</p>
                                <table class="table table-bordered table-striped">
                                <?php 
                                    
                                    $fetch_005 = mysqli_fetch_assoc($sql_query_005);
                                ?>
                                    <thead>
                                        <tr>
                                            <th>مجموع مصارف</th>
                                            <th><?php echo round($fetch_005["total_expenses"],2); ?> </th>
                                        </tr>
                                       
                                    </thead>
                                </table>
                            </div>
                        </div> <!-- end card-box-->

                    </div> <!-- end col -->
                    <div class="col-xl-3">

                        <div class="card-box widget-chart-one  bx-shadow-lg " style="color:black !important; border:1px solid green">
                        
                            <div class="widget-chart-one-content text-right" style="text-align:center !important;">
                                <p class="text-black mb-0 mt-2">بخش بیلانس</p>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>مجموع باقی مفاد  </th>
                                            <th><?php echo round($fetch_002["total_profit"]  - $fetch_005["total_expenses"],2); ?> </th>
                                        </tr>
                                        <tr>
                                            <th>مجموع  پول دخل  </th>
                                            <th><?php echo round($fetch_002["total_reciepts"] - $fetch_004["total_reciepts"] - $fetch_005["total_expenses"],2); ?> </th>
                                        </tr>
                                       
                                    </thead>
                                </table>
                            </div>
                        </div> <!-- end card-box-->

                    </div> <!-- end col -->

                  

                </div>
                <!-- end row -->


                
            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

        <!-- Footer Start -->
        <?php include_once("footer.php"); ?>
      <!-- end Footer -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div class="rightbar-title">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="mdi mdi-close"></i>
                </a>
                <h4 class="m-0 text-white">Settings</h4>
            </div>
            <div class="slimscroll-menu">
                <!-- User box -->
                <div class="user-box">
                    <div class="user-img">
                        <img src="assets/images/users/avatar.jpg" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                        <a href="javascript:void(0);" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                    </div>
            
                    <h5><a href="javascript: void(0);">Agnes Kennedy</a> </h5>
                    <p class="text-muted mb-0"><small>Admin Head</small></p>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h5 class="pl-3">Basic Settings</h5>
                <hr class="mb-0" />


                <div class="p-3">
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="checkbox1" type="checkbox" checked>
                        <label for="checkbox1">
                            Notifications
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="checkbox2" type="checkbox" checked>
                        <label for="checkbox2">
                            API Access
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="checkbox3" type="checkbox">
                        <label for="checkbox3">
                            Auto Updates
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="checkbox4" type="checkbox" checked>
                        <label for="checkbox4">
                            Online Status
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-0">
                        <input id="checkbox5" type="checkbox" checked>
                        <label for="checkbox5">
                            Auto Payout
                        </label>
                    </div>
                </div>

                <!-- Timeline -->
                <hr class="mt-0" />
                <h5 class="pl-3 pr-3">Messages <span class="float-right badge badge-pill badge-danger">25</span></h5>
                <hr class="mb-0" />
                <div class="p-3">
                    <div class="inbox-widget">
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/avatar.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Chadengle</a></p>
                            <p class="inbox-item-text">Hey! there I'm available...</p>
                            <p class="inbox-item-date">13:40 PM</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/avatar.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Tomaslau</a></p>
                            <p class="inbox-item-text">I've finished it! See you so...</p>
                            <p class="inbox-item-date">13:34 PM</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/avatar.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                            <p class="inbox-item-text">This theme is awesome!</p>
                            <p class="inbox-item-date">13:17 PM</p>
                        </div>

                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/avatar.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                            <p class="inbox-item-text">Nice to meet you</p>
                            <p class="inbox-item-date">12:20 PM</p>

                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/avatar.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Shahedk</a></p>
                            <p class="inbox-item-text">Hey! there I'm available...</p>
                            <p class="inbox-item-date">10:15 AM</p>

                        </div>
                    </div> <!-- end inbox-widget -->
                </div> <!-- end .p-3-->

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
        

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- KNOB JS -->
        <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
        <!-- Chart JS -->
        <script src="assets/libs/chart-js/Chart.bundle.min.js"></script>

        <!-- Jvector map -->
        <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="assets/libs/jqvmap/jquery.vmap.usa.js"></script>
        
        <!-- Datatable js -->
        <script src="assets/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="assets/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables/responsive.bootstrap4.min.js"></script>
        
        <!-- Dashboard Init JS -->
        <script src="assets/js/pages/dashboard.init.js"></script>
        <script src="assets/js/persian-datepicker.js"></script>

        
        <!-- App js -->
        <script src="assets/js/app-rtl.min.js"></script>
        <script src="assets/js/languages.js"></script>

     
    </body>
</html>