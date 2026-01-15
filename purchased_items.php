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
                            <li class="breadcrumb-item active"> نمایش  صفحه خرید</li>
                        </ol>
                    </div>
                    <p class="page-title">  نمایش   صفحه خرید</p>
                </div> 
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card-box table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>شماره</th>
                                    
                                    <th>نمیر بل</th>
                                    <th> تمویل کننده</th>
                                    <th>واحد پولی</th>
                                    <th>تاریخ خرید</th>
                                    <th>مجموع خرید</th>
                                    <th>مجموع مصارف اضافی</th>
                                    <th>مجموع رسید</th>
                                    <th>مجموع نهایی</th>
                                    <th>مجموع باقی</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>

                            <div id="accordion">
                                <?php
                                    $count = 1;
                                    $sql_query_001 = mysqli_query($connection,"SELECT 
                                        purchase_major.id AS bill_number,
                                        COALESCE(suppliers.full_name, '') AS supplier_name,
                                        COALESCE(currencies.name, '') AS currency_name,
                                        purchase_major.date AS purchase_date,
                                        purchase_major.reciept AS total_reciept,
                                        COALESCE((SELECT SUM(purchase_minor.purchase_price * purchase_minor.amount) FROM purchase_minor WHERE purchase_minor.purchase_major_id = purchase_major.id), 0) AS total_purchased_price,
                                        COALESCE((SELECT SUM(purchase_minor.extra_expense * purchase_minor.amount) FROM purchase_minor WHERE purchase_minor.purchase_major_id = purchase_major.id), 0) AS total_extra_price,
                                        COALESCE((SELECT SUM(reciepts.amount / reciepts.rate) FROM reciepts WHERE reciepts.purchase_id = purchase_major.id), 0) AS total_reciepts_price
                                    FROM purchase_major
                                    LEFT JOIN suppliers ON suppliers.id = purchase_major.supplier_id
                                    LEFT JOIN currencies ON currencies.id = purchase_major.currency_id
                                    ORDER BY purchase_major.id DESC");
                                    while ($row = mysqli_fetch_assoc($sql_query_001))
                                    {
                                        
                                ?>
                                    <tr>
                                        <th><?php echo $count; ?></th>
                                        <th><?php echo $row["bill_number"]; ?></th>
                                        <th><?php echo $row["supplier_name"]; ?></th>
                                        <th><?php echo $row["currency_name"]; ?></th>
                                        <th><?php
                        
                                            echo $row["purchase_date"];?>
                                        </th>
                                        <th><?php echo $row["total_purchased_price"]; ?></th>
                                        <th><?php echo $row["total_extra_price"]; ?></th>
                                        <th><?php echo round($row["total_reciepts_price"],2); ?></th>
                                        <th class="text text-success"><?php echo ($row["total_purchased_price"] + $row["total_extra_price"]) ?></th>
                                        <th class="text text-danger"><?php echo ($row["total_purchased_price"] + $row["total_extra_price"]) - round($row["total_reciepts_price"],2); ?></th>
                                      
                                        
                                        <th><a class="collapsed card-link" data-toggle="collapse" href="#collapse_<?php echo $count; ?>"><span class="fa fa-eye"></span> </a> | <a href="print_purchase.php?purchase_id=<?php echo $row['bill_number']; ?>" target="_blank"><span class="fa fa-print text text-primary" title="چاپ"></span></a> | <span class="fa fa-trash text text-danger" onclick="delete_func(<?php echo $row['bill_number']; ?>)"></span> | <a href="reciepts.php?purchase_id=<?php echo $row['bill_number']; ?>"><span class="fa fa-plus text text-success" ></span></a>
                                        </th>
                                    </tr>
                                                
                                            
                                    <tr>
                                        <td colspan="13">

                                            <div id="collapse_<?php echo $count; ?>" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th colspan='11' class="text text-center">جزیات خرید</th>
                                                            </tr>
                                                            <tr>
                                                                <th>شماره</th>
                                                                <th>نام جنس</th>
                                                                <th>واحد خرید</th>
                                                                <th>مقدار</th>
                                                                <th>قیمت خرید | 1</th>
                                                                <th>مصارف اضافی | 1</th>
                                                                <th>مجموع  </th>
                                                                <th>توضیحات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $parent_id = $row["bill_number"];
                                                                $count_2 = 1;
                                                                $sql_query_004 = mysqli_query($connection,"SELECT * FROM `purchased_items_list` where purchase_major_id='$parent_id'");

                                                                while ($fetch_004 = mysqli_fetch_assoc($sql_query_004))
                                                                {
                                                            ?>
                                                            <tr id="purchased_item_<?php echo $fetch_004['purchase_minor_id']; ?>">
                                                                <td><?php echo $count_2; ?></td>
                                                                <td><?php echo $fetch_004["item_name"]; ?></td>
                                                                <td><?php echo $fetch_004["minor_unit_name"]; ?></td>
                                                                <td><?php echo $fetch_004["amount"]; ?></td>
                                                                <td><?php echo $fetch_004["purchase_price"]; ?></td>
                                                                <td><?php echo $fetch_004["extra_expense"]; ?></td>
                                                                <td class="text text-success"><?php echo ($fetch_004["purchase_price"] + $fetch_004["extra_expense"]) * $fetch_004["amount"]; ?></td>
                                                               
                                                                <td><?php echo $fetch_004["details"]; ?></td>
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
        <script src="assets/js/languages.js"></script>

        <!-- Datatables init -->
        <script src="assets/js/pages/datatables.init.js"></script>        

        <!-- App js -->
        <script src="assets/js/app-rtl.min.js"></script>
        <script>
            function delete_func(id){
            var confirm  = window.confirm("اطلاعات حذف خواهد شد برای لغو cancel را بزنید");
            if(confirm == true)
            {
                $.ajax({
                type: "GET",
                data: {
                purchase_id:id,
                },
                url: "delete.php",
                success: function(msg) {
                window.open("purchased_items.php",'_self');            
                
                }
            });
            }
            else
            {
                
            }
            

            }
        </script>
        
    </body>
</html>