<?php
    include("database.php");
    include("session.php");
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

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app-rtl.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/jquery-toast/jquery.toast.min.css" rel="stylesheet" type="text/css" />

    <style>
        .backup-card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: none;
        }
        .backup-info-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 20px;
        }
        .backup-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }
        .info-item {
            padding: 15px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .btn-backup {
            padding: 15px 40px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s;
        }
        .btn-backup:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        .backup-history {
            max-height: 300px;
            overflow-y: auto;
        }
        .backup-item {
            padding: 15px;
            border-left: 4px solid #5cb85c;
            background: #f8f9fa;
            margin-bottom: 10px;
            border-radius: 5px;
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
            <div class="page-title-alt-bg print-display"></div>
            <div class="page-title-box print-display">
                <div class="page-title-right print-display">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">شفاف</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">تنظیمات</a></li>
                        <li class="breadcrumb-item active"> پشتیبان‌گیری از پایگاه داده</li>
                    </ol>
                </div>
                <p class="page-title">
                    <i class="mdi mdi-database-export mr-2"></i>پشتیبان‌گیری از پایگاه داده
                </p>
            </div>
            <!-- end page title -->

            <div class="row">
                <!-- Backup Information Card -->
                <div class="col-lg-12">
                    <div class="backup-info-card">
                        <div class="text-center">
                            <i class="mdi mdi-database backup-icon"></i>
                            <h3 class="mb-3">پشتیبان‌گیری از پایگاه داده</h3>
                            <p class="mb-4">ایجاد نسخه پشتیبان کامل از تمام جداول و داده‌های پایگاه داده</p>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="info-item">
                                    <i class="mdi mdi-database-check mr-2"></i>
                                    <strong>نام پایگاه داده:</strong> shafaf_mis
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <i class="mdi mdi-table-multiple mr-2"></i>
                                    <strong>تعداد جداول:</strong> 
                                    <?php
                                        $tables_query = mysqli_query($connection, "SHOW TABLES");
                                        $table_count = mysqli_num_rows($tables_query);
                                        echo $table_count;
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-item">
                                    <i class="mdi mdi-calendar-clock mr-2"></i>
                                    <strong>تاریخ:</strong> <?php echo date("Y-m-d H:i:s"); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup Action Card -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card backup-card">
                        <div class="card-body p-4">
                            <h4 class="mb-4">
                                <i class="mdi mdi-download mr-2 text-primary"></i>
                                دانلود نسخه پشتیبان
                            </h4>

                            <div class="alert alert-info" role="alert">
                                <i class="mdi mdi-information-outline mr-2"></i>
                                <strong>توجه:</strong> این عملیات یک فایل SQL کامل از تمام جداول و داده‌های پایگاه داده ایجاد می‌کند. 
                                این فایل را در مکانی امن نگهداری کنید.
                            </div>

                            <div class="text-center mt-4 mb-4">
                                <a href="download_backup.php" class="btn btn-success btn-backup waves-effect waves-light">
                                    <i class="mdi mdi-database-export mr-2"></i>
                                    دانلود نسخه پشتیبان کامل
                                </a>
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3">
                                <i class="mdi mdi-information-outline mr-2"></i>
                                اطلاعات مهم:
                            </h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="mdi mdi-check-circle text-success mr-2"></i>
                                    فایل پشتیبان شامل ساختار کامل جداول (CREATE TABLE) می‌باشد
                                </li>
                                <li class="mb-2">
                                    <i class="mdi mdi-check-circle text-success mr-2"></i>
                                    تمام داده‌های موجود در جداول در فایل پشتیبان ذخیره می‌شود
                                </li>
                                <li class="mb-2">
                                    <i class="mdi mdi-check-circle text-success mr-2"></i>
                                    فایل پشتیبان با فرمت SQL قابل بازگردانی در phpMyAdmin می‌باشد
                                </li>
                                <li class="mb-2">
                                    <i class="mdi mdi-alert-circle text-warning mr-2"></i>
                                    توصیه می‌شود به صورت منظم از پایگاه داده پشتیبان تهیه کنید
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Database Tables List -->
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card backup-card">
                        <div class="card-body">
                            <h4 class="mb-3">
                                <i class="mdi mdi-table mr-2"></i>
                                لیست جداول پایگاه داده
                            </h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>نام جدول</th>
                                            <th>تعداد ردیف‌ها</th>
                                            <th>اندازه (تقریبی)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $tables_query = mysqli_query($connection, "SHOW TABLES");
                                            $counter = 1;
                                            while ($table = mysqli_fetch_array($tables_query)) {
                                                $table_name = $table[0];
                                                
                                                // Get row count
                                                $count_query = mysqli_query($connection, "SELECT COUNT(*) as count FROM `$table_name`");
                                                $count_result = mysqli_fetch_assoc($count_query);
                                                $row_count = $count_result['count'];
                                                
                                                // Get table size
                                                $size_query = mysqli_query($connection, "SELECT 
                                                    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS size_mb 
                                                    FROM information_schema.TABLES 
                                                    WHERE table_schema = 'shafaf_mis' 
                                                    AND table_name = '$table_name'");
                                                $size_result = mysqli_fetch_assoc($size_query);
                                                $table_size = $size_result ? $size_result['size_mb'] . ' MB' : 'N/A';
                                        ?>
                                        <tr>
                                            <td><?php echo $counter++; ?></td>
                                            <td><strong><?php echo $table_name; ?></strong></td>
                                            <td><?php echo number_format($row_count); ?></td>
                                            <td><?php echo $table_size; ?></td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- end container -->
    </div>
    <!-- end wrapper -->

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    <!-- Footer Start -->
    <?php include_once("footer.php"); ?>
    <!-- end Footer -->

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/jquery-toast/jquery.toast.min.js"></script>

</body>
</html>
