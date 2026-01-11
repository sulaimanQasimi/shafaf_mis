<?php
    include("database.php");
    include("jdf.php");
?>
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

        <!-- third party css -->
        <link href="assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />            

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app-rtl.min.css" rel="stylesheet" type="text/css" />

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
                <div class="page-title-alt-bg print-display"></div>
                <div class="page-title-box print-display">
                    <div class="page-title-right print-display">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">شفاف</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">صفحات</a></li>
                            <li class="breadcrumb-item active"> نمایش گدام  </li>
                        </ol>
                    </div>
                    <p class="page-title">  نمایش  گدام </pack>
                </div> 
                <!-- end page title -->

               

                <!-- <div class="row">
                    <div class="col-md-2">
                        <a href="registered_goods_major_unit.php"><button class="btn btn-primary btn-sm">نمایش گدام به اساس واحد اصلی</button></a>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-12">
                        <div class="card-box table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered  nowrap">
                                <thead>
                                    <tr>
                                        <th>شماره</th>
                                        <th>نام جنس</th>
                                        <th> واحد اصلی</th>
                                        <th>واحد فرعی</th>
                                        <th>مقدار خرید شده</th>
                                        <th>مقدار فروش شده</th>
                                        <th>مقدار باقی مانده</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    
                                 <div id="accordion">
                                 <?php
                                        $count = 1;
                                        $sql_query_001 = mysqli_query($connection,"SELECT stock_major.*,(SELECT stock_minor.item_name FROM stock_minor WHERE stock_minor.id = stock_major.item_id) as item_name,(SELECT unit_major.unit_name FROM unit_major WHERE unit_major.id = stock_major.unit_id) as major_unit,(SELECT unit_minor.unit_name FROM unit_minor WHERE unit_minor.id = stock_major.minor_unit_id ) as minor_unit FROM stock_major GROUP BY stock_major.item_id,stock_major.minor_unit_id");
                                        while ($row = mysqli_fetch_assoc($sql_query_001))
                                        {
                                            $total_purchased_amount = 0;
                                            $total_sold_amount = 0;

                                            $stock_major_id = $row["id"];
                                            $sql_query_002 = mysqli_query($connection,"SELECT purchase_minor.id,purchase_minor.amount,(SELECT sum(sale_minor.amount) FROM sale_minor WHERE sale_minor.purchase_minor_id = purchase_minor.id) as total_sold_amount FROM purchase_minor WHERE purchase_minor.item_id_stock_major = '$stock_major_id'");
                                            while($row_2 = mysqli_fetch_assoc($sql_query_002))
                                            {
                                                $total_purchased_amount = $total_purchased_amount + $row_2["amount"];
                                                $total_sold_amount = $total_sold_amount + $row_2["total_sold_amount"];
                                            }
                                        ?>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $row["item_name"]; ?></td>
                                            <td><?php echo $row["major_unit"]; ?></td>
                                            <td><?php echo $row["minor_unit"]; ?></td>
                                            <td class="text text-primary"><?php echo $total_purchased_amount .' '. $row["minor_unit"]; ?></td>
                                            <td class="text text-success"><?php echo $total_sold_amount .' '. $row["minor_unit"]; ?></td>
                                            <td class="text text-danger"><?php echo ($total_purchased_amount - $total_sold_amount) .' '. $row["minor_unit"]; ?></td>
                                        
                                            
                                          
                                        <th><a class="collapsed card-link" data-toggle="collapse" href="#collapse_<?php echo $count; ?>"><span class="fa fa-eye"></span> </a>
                                        </th>
                                    </tr>
                                                
                                            
                                    <tr>
                                        <td colspan="13">

                                            <div id="collapse_<?php echo $count; ?>" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th colspan='11' class="text text-center">جزیات </th>
                                                            </tr>
                                                            <tr>
                                                                <th>شماره</th>
                                                                <th>تاریخ خرید</th>
                                                                <th> واحد اصلی</th>
                                                                <th>واحد فرعی</th>
                                                                <th>مقدار خرید شده</th>
                                                                <th>مقدار فروش شده</th>
                                                                <th>مقدار باقی مانده</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                             
                                                                $count_2 = 1;
                                                                $sql_query_004 = mysqli_query($connection,"SELECT purchase_minor.*,(SELECT sum(sale_minor.amount) FROM sale_minor WHERE sale_minor.purchase_minor_id = purchase_minor.id) as total_sold_amount,(SELECT purchase_major.date FROM purchase_major WHERE purchase_major.id = purchase_minor.purchase_major_id) as purchase_date FROM purchase_minor WHERE purchase_minor.item_id_stock_major = '$stock_major_id'");

                                                                while ($fetch_004 = mysqli_fetch_assoc($sql_query_004))
                                                                {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $count_2; ?></td>
                                                                <td><?php echo $fetch_004["purchase_date"]; ?></td>
                                                                <td><?php echo $row["major_unit"]; ?></td>
                                                                <td><?php echo $row["minor_unit"]; ?></td>
                                                                <td><?php echo $fetch_004["amount"]; ?></td>
                                                                <td><?php echo $fetch_004["total_sold_amount"]; ?></td>
                                                                <td class="text text-success"><?php echo ($fetch_004["amount"] - $fetch_004["total_sold_amount"]); ?></td>
                                                               
                                                            </tr>

                                                            <?php
                                                            
                                                            $count_2++;

                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                <?php
                                $count++;

                                    }
                                ?>
                                
                            </div>
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                
            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

        <!-- Footer Start -->
        <?php include("footer.php"); ?>
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
                        <img src="assets/images/users/avatar-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
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
                            <div class="inbox-item-img"><img src="assets/images/users/avatar-1.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Chadengle</a></p>
                            <p class="inbox-item-text">Hey! there I'm available...</p>
                            <p class="inbox-item-date">13:40 PM</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/avatar-2.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Tomaslau</a></p>
                            <p class="inbox-item-text">I've finished it! See you so...</p>
                            <p class="inbox-item-date">13:34 PM</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/avatar-3.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                            <p class="inbox-item-text">This theme is awesome!</p>
                            <p class="inbox-item-date">13:17 PM</p>
                        </div>

                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/avatar-4.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                            <p class="inbox-item-text">Nice to meet you</p>
                            <p class="inbox-item-date">12:20 PM</p>

                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/avatar-5.jpg" class="rounded-circle" alt=""></div>
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

        <!-- datatable js -->
        <script src="assets/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="assets/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables/responsive.bootstrap4.min.js"></script>
        
        <script src="assets/libs/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/libs/datatables/buttons.bootstrap4.min.js"></script>
        <script src="assets/libs/datatables/buttons.html5.min.js"></script>
        <script src="assets/libs/datatables/buttons.flash.min.js"></script>
        <script src="assets/libs/datatables/buttons.print.min.js"></script>

        <script src="assets/libs/datatables/dataTables.keyTable.min.js"></script>
        <script src="assets/libs/datatables/dataTables.select.min.js"></script>

        <!-- Datatables init -->
        <script src="assets/js/pages/datatables.init.js"></script>        

        <!-- App js -->
        <script src="assets/js/languages.js"></script>
        <script src="assets/js/app-rtl.min.js"></script>

    </body>
</html>