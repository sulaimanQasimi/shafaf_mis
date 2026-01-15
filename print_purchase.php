<?php
    // Start session first, before any output
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check if user is logged in
    if(!isset($_SESSION["username"])) {
        header("location:index.php");
        exit;
    }
    
    include_once("database.php");
    include("jdf.php");
   
    // Get purchase_id from URL parameter
    if(!isset($_GET['purchase_id']) || empty($_GET['purchase_id'])) {
        header("location:purchased_items.php");
        exit;
    }
    
    $purchase_id = intval($_GET['purchase_id']);
    
    // Get company settings
    $sql_query_company = mysqli_query($connection,"SELECT * FROM company_settings ORDER BY id DESC LIMIT 1");
    $company_settings = array();
    if(mysqli_num_rows($sql_query_company) > 0)
    {
        $company_settings = mysqli_fetch_assoc($sql_query_company);
        $company_name = $company_settings["company_name"];
        $company_logo = $company_settings["company_logo"];
    }
    else
    {
        $company_name = "shafaf MIS";
        $company_logo = "";
    }
    
    // Get purchase major information
    $sql_query_purchase = mysqli_query($connection,"SELECT 
        purchase_major.id AS bill_number,
        COALESCE(suppliers.full_name, '') AS supplier_name,
        COALESCE(suppliers.phone_number, '') AS supplier_phone,
        COALESCE(suppliers.address, '') AS supplier_address,
        COALESCE(currencies.name, '') AS currency_name,
        purchase_major.date AS purchase_date,
        purchase_major.reciept AS total_reciept,
        COALESCE((SELECT SUM(purchase_minor.purchase_price * purchase_minor.amount) FROM purchase_minor WHERE purchase_minor.purchase_major_id = purchase_major.id), 0) AS total_purchased_price,
        COALESCE((SELECT SUM(purchase_minor.extra_expense * purchase_minor.amount) FROM purchase_minor WHERE purchase_minor.purchase_major_id = purchase_major.id), 0) AS total_extra_price,
        COALESCE((SELECT SUM(reciepts.amount / reciepts.rate) FROM reciepts WHERE reciepts.purchase_id = purchase_major.id), 0) AS total_reciepts_price
    FROM purchase_major
    LEFT JOIN suppliers ON suppliers.id = purchase_major.supplier_id
    LEFT JOIN currencies ON currencies.id = purchase_major.currency_id
    WHERE purchase_major.id = '$purchase_id'");
    
    if(mysqli_num_rows($sql_query_purchase) == 0) {
        header("location:purchased_items.php");
        exit;
    }
    
    $purchase_data = mysqli_fetch_assoc($sql_query_purchase);
    
    // Get purchase minor items - using direct query instead of view
    $sql_query_items = mysqli_query($connection,"SELECT 
        purchase_minor.id AS purchase_minor_id,
        purchase_minor.purchase_major_id AS purchase_major_id,
        purchase_minor.amount AS amount,
        purchase_minor.purchase_price AS purchase_price,
        purchase_minor.extra_expense AS extra_expense,
        purchase_minor.details AS details,
        (SELECT unit_minor.unit_name FROM unit_minor WHERE unit_minor.id = (SELECT stock_major.minor_unit_id FROM stock_major WHERE stock_major.id = purchase_minor.item_id_stock_major)) AS minor_unit_name,
        (SELECT stock_minor.item_name FROM stock_minor WHERE stock_minor.id = (SELECT stock_major.item_id FROM stock_major WHERE stock_major.id = purchase_minor.item_id_stock_major)) AS item_name
    FROM purchase_minor
    WHERE purchase_minor.purchase_major_id = '$purchase_id'
    ORDER BY purchase_minor.id");
    
    // Check if query was successful
    if(!$sql_query_items) {
        die("خطا در اجرای کوئری: " . mysqli_error($connection));
    }
    
    // Calculate totals
    $total_purchased_price = $purchase_data["total_purchased_price"];
    $total_extra_price = $purchase_data["total_extra_price"];
    $total_reciepts_price = round($purchase_data["total_reciepts_price"], 2);
    $final_total = $total_purchased_price + $total_extra_price;
    $total_remain = $final_total - $total_reciepts_price;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app-rtl.min.css" rel="stylesheet" type="text/css" />

    <style>
    table tr td,
    table tr th {
        border: 1px solid black !important;
        color: black !important;
        font-weight: bold;
    }
    
    /* Ensure table headers are always visible */
    table thead {
        display: table-header-group !important;
        visibility: visible !important;
    }
    
    table thead th {
        display: table-cell !important;
        visibility: visible !important;
    }

    @media print {
        @page {
            size: A4;
            margin: 10mm 15mm;
        }

        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        html, body {
            background: white !important;
            font-family: 'Arial', 'Tahoma', 'DejaVu Sans', sans-serif !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            height: auto !important;
            direction: rtl !important;
        }

        .wrapper {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        .card-box {
            border: none !important;
            box-shadow: none !important;
            padding: 10px !important;
            margin: 0 !important;
            background: white !important;
            width: 100% !important;
        }

        /* Header Section */
        .clearfix {
            margin-bottom: 20px !important;
            padding-bottom: 15px !important;
            border-bottom: 2px solid #333 !important;
            display: block !important;
            width: 100% !important;
        }

        .clearfix .row {
            display: table !important;
            width: 100% !important;
            table-layout: fixed !important;
        }

        .clearfix .row > div {
            display: table-cell !important;
            vertical-align: middle !important;
            padding: 5px !important;
        }

        .clearfix .col-md-6:first-child {
            width: 40% !important;
        }

        .clearfix .col-md-6:last-child {
            width: 60% !important;
            text-align: right !important;
        }

        .clearfix img,
        .print-logo {
            height: 50px !important;
            max-width: 180px !important;
            object-fit: contain !important;
            display: block !important;
        }

        .invoice-title {
            display: block !important;
            font-size: 22px !important;
            font-weight: bold !important;
            color: #2c3e50 !important;
            margin: 0 0 8px 0 !important;
            text-align: right !important;
        }

        .company-name-print {
            display: block !important;
            font-size: 16px !important;
            font-weight: bold !important;
            color: #34495e !important;
            margin: 5px 0 0 0 !important;
            text-align: right !important;
        }

        .print-only {
            display: block !important;
        }

        .invoice-date-print {
            display: block !important;
            font-size: 12px !important;
            color: #7f8c8d !important;
            margin: 5px 0 0 0 !important;
            text-align: right !important;
        }

        .invoice-date-print span {
            font-weight: bold !important;
            color: #34495e !important;
        }

        /* Hide non-printable elements */
        .print-display,
        .d-print-none,
        header,
        footer,
        .rightbar-overlay,
        .modal,
        .page-title-box,
        .page-title-alt-bg,
        .breadcrumb {
            display: none !important;
        }

        /* Table Styling */
        .table-responsive {
            overflow: visible !important;
            width: 100% !important;
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin: 15px 0 !important;
            page-break-inside: avoid;
            table-layout: fixed !important;
            font-size: 12px !important;
        }

        table thead {
            background-color: #2c3e50 !important;
            color: white !important;
            display: table-header-group !important;
        }

        table thead th {
            background-color: #2c3e50 !important;
            color: white !important;
            padding: 10px 6px !important;
            font-size: 12px !important;
            font-weight: bold !important;
            text-align: center !important;
            border: 1px solid #1a252f !important;
            word-wrap: break-word !important;
            overflow: hidden !important;
        }

        table tbody {
            display: table-row-group !important;
        }

        table tbody td {
            padding: 8px 6px !important;
            font-size: 11px !important;
            text-align: center !important;
            border: 1px solid #ddd !important;
            vertical-align: middle !important;
            word-wrap: break-word !important;
            overflow: hidden !important;
        }

        table tbody tr {
            page-break-inside: avoid;
            break-inside: avoid !important;
        }

        table tbody tr:nth-child(even) {
            background-color: #f8f9fa !important;
        }

        table tbody tr:hover {
            background-color: #e9ecef !important;
        }

        table tfoot {
            background-color: #34495e !important;
            color: white !important;
            display: table-footer-group !important;
        }

        table tfoot th {
            background-color: #34495e !important;
            color: white !important;
            padding: 10px 8px !important;
            font-size: 12px !important;
            font-weight: bold !important;
            text-align: right !important;
            border: 1px solid #1a252f !important;
            width: 20% !important;
        }

        table tfoot td {
            background-color: #34495e !important;
            color: white !important;
            padding: 10px 8px !important;
            font-size: 12px !important;
            font-weight: bold !important;
            text-align: center !important;
            border: 1px solid #1a252f !important;
        }

        /* Supplier Row Styling */
        table thead tr:first-child {
            background-color: #3498db !important;
            display: table-row !important;
            visibility: visible !important;
        }

        table thead tr:first-child th {
            background-color: #3498db !important;
            color: white !important;
            font-size: 13px !important;
            padding: 12px 8px !important;
            border: 1px solid #2980b9 !important;
            display: table-cell !important;
            visibility: visible !important;
        }
        
        table thead tr:nth-child(2) {
            display: table-row !important;
            visibility: visible !important;
        }
        
        table thead tr:nth-child(2) th {
            display: table-cell !important;
            visibility: visible !important;
        }

        table thead tr:first-child th p {
            margin: 0 !important;
            font-size: 13px !important;
            font-weight: bold !important;
            color: white !important;
        }

        /* Column Widths */
        table thead tr:nth-child(2) th:nth-child(1),
        table tbody td:nth-child(1) {
            width: 5% !important;
        }

        table thead tr:nth-child(2) th:nth-child(2),
        table tbody td:nth-child(2) {
            width: 20% !important;
        }

        table thead tr:nth-child(2) th:nth-child(3),
        table tbody td:nth-child(3) {
            width: 10% !important;
        }

        table thead tr:nth-child(2) th:nth-child(4),
        table tbody td:nth-child(4) {
            width: 10% !important;
        }

        table thead tr:nth-child(2) th:nth-child(5),
        table tbody td:nth-child(5) {
            width: 10% !important;
        }

        table thead tr:nth-child(2) th:nth-child(6),
        table tbody td:nth-child(6) {
            width: 10% !important;
        }

        table thead tr:nth-child(2) th:nth-child(7),
        table tbody td:nth-child(7) {
            width: 15% !important;
        }

        table thead tr:nth-child(2) th:nth-child(8),
        table tbody td:nth-child(8) {
            width: 20% !important;
        }

        /* Total Section */
        #total_remain {
            font-size: 13px !important;
            font-weight: bold !important;
            color: white !important;
            display: block !important;
            padding: 8px !important;
        }

        /* Invoice Title */
        .bill_number {
            font-size: 20px !important;
            font-weight: bold !important;
            color: #2c3e50 !important;
            text-align: center !important;
            margin: 15px 0 !important;
        }

        /* Additional Spacing */
        .row {
            margin: 0 !important;
            display: block !important;
        }

        .col-md-12,
        .col-sm-12 {
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .mt-4 {
            margin-top: 15px !important;
        }

        .mt-3 {
            margin-top: 10px !important;
        }

        /* Footer totals styling */
        table tfoot tr:last-child {
            background-color: #27ae60 !important;
            border-top: 2px solid #1e8449 !important;
        }

        table tfoot tr:last-child th,
        table tfoot tr:last-child td {
            background-color: #27ae60 !important;
            font-size: 13px !important;
            font-weight: bold !important;
            padding: 12px 8px !important;
        }

        table tfoot tr:last-child #total_remain {
            font-size: 14px !important;
            font-weight: bolder !important;
        }

        /* Invoice Info Section */
        .invoice-info {
            display: block !important;
            margin: 20px 0;
            padding: 15px;
            background-color: #ecf0f1 !important;
            border-radius: 5px;
            border: 1px solid #bdc3c7;
        }

        .invoice-info p {
            margin: 5px 0;
            font-size: 13px;
            color: #2c3e50;
        }

        /* Remove all shadows and effects */
        * {
            box-shadow: none !important;
            text-shadow: none !important;
        }

        /* Print-specific spacing */
        .card-box > * {
            margin-bottom: 10px !important;
        }

        /* Ensure proper text rendering */
        table th,
        table td {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Fix for RTL layout */
        table {
            direction: rtl !important;
        }

        table th,
        table td {
            text-align: center !important;
        }

        /* Page break handling */
        @page {
            margin: 10mm 15mm;
        }

        /* Prevent page breaks inside important elements */
        .clearfix,
        table thead,
        table tfoot {
            page-break-inside: avoid !important;
        }

        /* Better header spacing */
        .clearfix {
            margin-bottom: 20px !important;
            padding-bottom: 15px !important;
        }
    }
    </style>
</head>

<body>

    <!-- Navigation Bar-->
    <?php include("header.php"); ?>
    <!-- End Navigation Bar-->

    <div class="wrapper">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="page-title-alt-bg print-display"></div>
            <div class="page-title-box print-display">
                <div class="page-title-right print-display">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">شفاف</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">صفحات</a></li>
                        <li class="breadcrumb-item active">چاپ فاکتور خرید</li>
                    </ol>
                </div>
                <p class="page-title">چاپ فاکتور خرید</p>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card-box">

                        <!-- Logo & title -->
                        <div class="clearfix">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="float-left">
                                        <?php if($company_logo != "") { ?>
                                            <img src="stuff_documents/images/<?php echo $company_logo; ?>" alt="<?php echo $company_name; ?>" height="20" class="print-logo">
                                        <?php } else { ?>
                                            <img src="assets/images/logo-dark.png" alt="<?php echo $company_name; ?>" height="20" class="print-logo">
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <h2 class="invoice-title print-only" style="display: none;">فاکتور خرید</h2>
                                    <h3 class="company-name-print" style="margin-top: 10px; font-size: 18px; font-weight: bold;"><?php echo $company_name; ?></h3>
                                    <p class="invoice-date-print" style="margin-top: 10px; font-size: 14px; color: #7f8c8d;">
                                        <span>تاریخ: <?php echo $purchase_data["purchase_date"]; ?></span>
                                    </p>
                                    <p class="invoice-date-print" style="margin-top: 5px; font-size: 14px; color: #7f8c8d;">
                                        <span>شماره بل: <?php echo $purchase_data["bill_number"]; ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table mt-4 table-sm table-centered">
                                        <thead>
                                            <tr>
                                                <th colspan="2">
                                                    <p style="text-align:center; font-size:25px;" for="search_input_id">
                                                        تمویل کننده : </p>
                                                </th>
                                                <th colspan="6">
                                                    <p style="text-align:center; font-size:18px; margin: 0;">
                                                        <?php echo $purchase_data["supplier_name"]; ?>
                                                        <?php if(!empty($purchase_data["supplier_phone"])) { ?>
                                                            <br><small style="font-size: 14px;">تلفن: <?php echo $purchase_data["supplier_phone"]; ?></small>
                                                        <?php } ?>
                                                    </p>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="width: 5%">#</th>
                                                <th style="width: 20%">جنس</th>
                                                <th style="width: 10%">واحد خرید</th>
                                                <th style="width: 10%">مقدار</th>
                                                <th style="width: 10%" class="text-right">قیمت خرید | 1</th>
                                                <th style="width: 10%" class="text-right">مصارف اضافی | 1</th>
                                                <th style="width: 15%" class="text-right">مجموع</th>
                                                <th style="width: 20%" class="text-right">توضیحات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $count = 1;
                                                while ($item = mysqli_fetch_assoc($sql_query_items))
                                                {
                                                    $row_total = ($item["purchase_price"] + $item["extra_expense"]) * $item["amount"];
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $item["item_name"]; ?></td>
                                                <td><?php echo $item["minor_unit_name"]; ?></td>
                                                <td><?php echo number_format($item["amount"], 2); ?></td>
                                                <td><?php echo number_format($item["purchase_price"], 2); ?></td>
                                                <td><?php echo number_format($item["extra_expense"], 2); ?></td>
                                                <td class="text text-success"><?php echo number_format($row_total, 2); ?></td>
                                                <td><?php echo $item["details"]; ?></td>
                                            </tr>
                                            <?php
                                                $count++;
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="7">مجموع خرید</th>
                                                <th><?php echo number_format($total_purchased_price, 2); ?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="7">مجموع مصارف اضافی</th>
                                                <th><?php echo number_format($total_extra_price, 2); ?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="7">مجموع نهایی</th>
                                                <th><?php echo number_format($final_total, 2); ?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="7">مجموع رسید</th>
                                                <th><?php echo number_format($total_reciepts_price, 2); ?></th>
                                            </tr>
                                            <tr>
                                                <th colspan="7">مجموع باقی</th>
                                                <th id="total_remain"><?php echo number_format($total_remain, 2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div> <!-- end table-responsive -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="mt-4 mb-1">
                            <div class="text-right d-print-none">
                                <a href="javascript:window.print()"
                                    class="btn btn-danger waves-effect btn-sm waves-light"><i
                                        class="mdi mdi-printer mr-1"></i>چاپ</a>
                                <a href="purchased_items.php"
                                    class="btn btn-secondary waves-effect btn-sm waves-light"><i
                                        class="mdi mdi-arrow-right mr-1"></i>بازگشت</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- end row -->

        </div> <!-- end container -->
    </div>
    <!-- end wrapper -->

    <!-- Footer Start -->
    <?php include_once("footer.php"); ?>
    <!-- end Footer -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="assets/js/jquery.min.js"></script>

    <!-- Auto print on load (optional - uncomment if needed) -->
    <!-- <script>
        window.onload = function() {
            window.print();
        }
    </script> -->

</body>

</html>
