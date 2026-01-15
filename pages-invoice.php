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
?>
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

    <!-- App css -->
    <!-- <link href="assets/libs/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app-rtl.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/persian-datepicker.css" rel="stylesheet" type="text/css" />



    <style>
    table tr td,
    table tr th,
    input,
    select {
        border: 1px solid black !important;
        color: black !important;
        font-weight: bold;
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

        /* Fix tfoot colspan */
        table tfoot tr th:first-child {
            width: 20% !important;
        }

        table tfoot tr th:last-child {
            width: 80% !important;
        }

        /* Form Controls in Print */
        .form-control,
        input[type="text"],
        input[type="number"],
        input[readonly],
        input[name="purchase_item_name"],
        input[name="purchase_date"],
        input[name="remain_amount"],
        input[name="unit_name"],
        input[name="amount"],
        input[name="purchase_price"],
        input[name="sale_price"],
        input[name="row_total"] {
            border: none !important;
            background: transparent !important;
            font-size: 11px !important;
            font-weight: normal !important;
            padding: 2px 4px !important;
            margin: 0 !important;
            width: 100% !important;
            text-align: center !important;
            color: inherit !important;
            box-shadow: none !important;
            display: block !important;
            min-height: auto !important;
            height: auto !important;
        }

        select.form-control,
        #customer_id {
            border: none !important;
            background: transparent !important;
            font-size: 12px !important;
            font-weight: bold !important;
            padding: 4px !important;
            margin: 0 !important;
            width: 100% !important;
            text-align: center !important;
            color: white !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            direction: rtl !important;
        }

        /* Customer Row Styling */
        table thead tr:first-child {
            background-color: #3498db !important;
        }

        table thead tr:first-child th {
            background-color: #3498db !important;
            color: white !important;
            font-size: 13px !important;
            padding: 12px 8px !important;
            border: 1px solid #2980b9 !important;
        }

        table thead tr:first-child th p {
            margin: 0 !important;
            font-size: 13px !important;
            font-weight: bold !important;
            color: white !important;
        }

        table thead tr:first-child th[colspan="2"] {
            width: 20% !important;
        }

        table thead tr:first-child th[colspan="9"] {
            width: 80% !important;
        }

        /* Column Widths for Data Rows */
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
            width: 8% !important;
        }

        table thead tr:nth-child(2) th:nth-child(6),
        table tbody td:nth-child(6) {
            width: 8% !important;
        }

        table thead tr:nth-child(2) th:nth-child(7),
        table tbody td:nth-child(7) {
            width: 10% !important;
        }

        table thead tr:nth-child(2) th:nth-child(8),
        table tbody td:nth-child(8) {
            width: 10% !important;
        }

        table thead tr:nth-child(2) th:nth-child(9),
        table tbody td:nth-child(9) {
            width: 10% !important;
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

        /* Fix input in tfoot */
        table tfoot input {
            font-size: 12px !important;
            font-weight: bold !important;
            color: white !important;
            background: transparent !important;
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

        /* Better spacing for table rows */
        table tbody td input {
            min-height: auto !important;
            height: auto !important;
        }

        /* Hidden inputs should not take space */
        input[type="hidden"] {
            display: none !important;
        }

        /* Textarea in print */
        textarea {
            display: none !important;
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
                        <li class="breadcrumb-item active">صفحه بل فروش</li>
                    </ol>
                </div>
                <p class="page-title">صفحه بل فروش</p>
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
                                    <h2 class="invoice-title print-only" style="display: none;">فاکتور فروش</h2>
                                    <h3 class="company-name-print" style="margin-top: 10px; font-size: 18px; font-weight: bold;"><?php echo $company_name; ?></h3>
                                    <p class="invoice-date-print" style="margin-top: 10px; font-size: 14px; color: #7f8c8d; display: none;">
                                        <span id="print_sale_date"></span>
                                    </p>
                                </div>
                            </div>
                        </div>



                        <div class="row mt-3">
                            <div class="col-md-4 print-display">
                                <div class="form-group ">
                                    <label for="">جستجو اجناس</label>
                                    <input type="search" id="search_input_id" list="items_list" class="form-control"
                                        required placeholder="جستجو ..." />
                                </div>

                                <datalist id="items_list">
                                    <?php
                                            $sql_query_01 = mysqli_query($connection,"SELECT (SELECT stock_minor.item_name FROM stock_minor WHERE stock_minor.id = stock_major.item_id) as item_name,stock_major.id,(SELECT unit_minor.unit_name FROM unit_minor WHERE unit_minor.id = stock_major.minor_unit_id) as minor_unit_name FROM stock_major;");
                                            while ($row = mysqli_fetch_assoc($sql_query_01))
                                            {
                                        ?>

                                    <option value="<?php echo $row["id"]; ?>">
                                        <?php echo $row["item_name"].'  -  '.$row["minor_unit_name"] ?></option>
                                    <?php
                                            }
                                        ?>
                                </datalist>
                            </div> <!-- end col -->
                            <div class="col-md-4 print-display">
                                <div class="form-group ">
                                    <label for="">تاریخ فروش</label>
                                    <input type="date" name="sale_date" value="<?php echo date("Y-m-d"); ?>"
                                        class="form-control" id="sale_date">
                                </div>
                            </div>

                            <div class="col-md-2 print-display">
                                <div class="form-group ">
                                    <label for="">واحد پولی</label>
                                    <select id="currency" name="currency" class="select2 form-control">
                                        <?php
                                                                $sql_query_01 = mysqli_query($connection,"select * from currencies");
                                                                while ($row = mysqli_fetch_assoc($sql_query_01))
                                                                {
                                                            ?>

                                        <option value="<?php echo $row["id"]; ?>">
                                            <?php echo $row["name"]; ?></option>
                                        <?php
                                                                }
                                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                    <label for="rate" class="col-form-label">نرخ</label>
                                    <span class="text-danger">*</span>
                                    <input type="number" step="0.01" value="1" class="form-control border border-dark" name="rate" id="rate"  >
                                </div>  


                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table mt-4 table-sm table-centered">
                                        <thead>
                                            <tr>
                                                <th colspan="2">
                                                    <p style="text-align:center; font-size:25px;" for="search_input_id">
                                                        مشتری : </p>

                                                </th>
                                                <th colspan="9">

                                                    <select id="customer_id" class="select2 form-control">
                                                        <?php
                                                                $sql_query_01 = mysqli_query($connection,"select * from customers");
                                                                while ($row = mysqli_fetch_assoc($sql_query_01))
                                                                {
                                                            ?>

                                                        <option value="<?php echo $row["id"]; ?>">
                                                            <?php echo $row["full_name"]; ?></option>
                                                        <?php
                                                                }
                                                            ?>
                                                    </select>

                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="width: 10%">#</th>
                                                <th style="width: 25%">جنس</th>
                                                <th style="width: 10%">تاریخ خرید</th>
                                                <th style="width: 10%">مقدار موجود</th>
                                                <th style="width: 10%">واحد </th>
                                               
                                                <th style="width: 10%">مقدار</th>
                                                <th style="width: 10%" class="text-right">قیمت خرید | 1</th>
                                                <th style="width: 10%" class="text-right">قیمت فروش | 1</th>
                                                <th style="width: 10%" class="text-right">مجموع</th>
                                                <th style="width: 10%" class="text-right print-display">توضیحات</th>
                                                <th style="width: 10%" class="text-right print-display">عمل</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bill_tbody">


                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>مجموع مقدار</th>
                                                <th><input type="number" id="total_price_final" readonly
                                                        name="total_price"
                                                        class="form-control total_reciept form-control-sm"></th>
                                            </tr>
                                            <tr>
                                                <th>مجموع رسید</th>
                                                <th><input type="number" id="total_reciept"
                                                        class="form-control total_reciept form-control-sm"></th>
                                            </tr>
                                            <tr>
                                                <th>مجموع باقی</th>
                                                <th id="total_remain">0</th>
                                            </tr>

                                        </tfoot>
                                    </table>
                                </div> <!-- end table-responsive -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->


                        <div class="mt-4 mb-1">
                            <div class="text-right d-print-none">
                                <button type="button" class="btn btn-sm btn-success waves-effect waves-light"
                                    id="button_submit">ذخیره</button>
                            </div>
                        </div>
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
    <?php include_once("footer.php"); ?>
      <!-- end Footer -->
    <!-- Button to Open the Modal -->
    <button type="button" style="display: none;" id="btn_modal" class="btn btn-primary" data-toggle="modal"
        data-target="#exampleModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">لیست خرید ها </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="purchase_list">انتخاب از لیست خرید</label>
                                <select name="purchase_list" class="form-control" id="purchase_list"></select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="add_purchased_item_btn" class="btn btn-primary" data-dismiss="modal">ذخیره</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <!-- Vendor js -->
    <!-- <script src="assets/js/vendor.min.js"></script> -->
    <!-- <script src="assets/js/bootstrap.js"></script> -->
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
    <script src="assets/libs/bootstrap-select/bootstrap-select.min.js"></script>
    <!-- persian datepicker js -->
    <script src="assets/js/persian-datepicker.js"></script>
    <script src="assets/js/languages.js"></script>
    <script src="assets/libs/select2/select2.min.js"></script>




    <!-- App js -->
    <!-- <script src="assets/js/app.min.js"></script> -->
    <script>
    var count_2 = 1;

    $(function() {
        $("#search_input_id").on("search", function() {

            var search_input_id = $("#search_input_id").val();

            $.ajax({
                type: "POST",
                data: {
                    major_stock_item_id_purchase_list: search_input_id,

                },
                url: "server.php",
                success: function(response) {
                    var options = "";
                    var responses = JSON.parse(response);
                    var num_of_rows = (Object.keys(responses).length);
                    var counter = 1;
                    for (let index = 0; index < num_of_rows; index++) {

                        var purchase_id = responses[index][0];
                        var purchase_date = responses[index][7];
                        var purchase_quantity = responses[index][3];
                        var sold_quantity = responses[index][9];
                        var purchase_price_per = Number(responses[index][4]) + Number(responses[index][5]);
                        var item_name = responses[index][8];
                        var unit_name = responses[index][10];
                        var remain_amount = Number(purchase_quantity) - Number(sold_quantity);


                        options += '<option value="' + purchase_id + '">' + item_name +
                            " - " + unit_name + " - " + purchase_date + " - باقی : " +
                            remain_amount + " " + unit_name + '</option>';


                        counter++;

                    }
                    $("#purchase_list").html(options);
                    $("#btn_modal").click();


                    // // var row =
                    // //     "<tr id='row_id_" + count_2 + "'>";
                    // // row += "<td class='idss'>" + count_2 + "</td>";
                    // // row +=
                    // //     "<td><input type='text' class='form-control' readonly name='purchase_item_name' value='" +
                    // //     responses_x1["item_name"] +
                    // //     "' /><input type='hidden' class='form-control' readonly name='major_stock_id' value='" +
                    // //     responses_x1["id"] + "' /></td>";
                    // // row +=
                    // //     "<td><input type='text' class='form-control' readonly name='unit_name' value='" +
                    // //     responses_x1["unit_name"] +
                    // //     "' /></td>";
                    // // row +=
                    // //     "<td><input type='text' class='form-control amount'  name='amount' id='amount_" +
                    // //     count_2 + "'  value='0' /></td>";
                    // // row +=
                    // //     "<td><input type='text' class='form-control purchase_price' id='purchase_price_" +
                    // //     count_2 + "' name='purchase_price' value='0' /></td>";
                    // // row +=
                    // //     "<td><input type='text' class='form-control extra_expense'  name='extra_expense' id='extra_expense_" +
                    // //     count_2 + "'  value='0' /></td>";
                    // // row +=
                    // //     "<td><input type='text' class='form-control row_total' readonly name='row_total' id='row_total_" +
                    // //     count_2 + "' value='0' /></td>";
                    // // row +=
                    // //     "<td class='text-right print-display'><textarea name='details'></textarea></td>";
                    // // row +=
                    // //     "<td class='text-center print-display'><span class='fa fa-trash text text-danger delete_btn' id='" +
                    // //     count_2 + "'></span></td>";
                    // // row += "</tr>";


                    // // $("#bill_tbody").append(row);
                    // total_cal(count_2);
                    count_2++;


                    // $("#search_input_id").val("");
                }
            });






        });

    });

    $("#add_purchased_item_btn").on("click", function() {
        // var search_input_id = $("#search_input_id").val();
        var purchase_list_id = $("#purchase_list").val();

        $.ajax({
            type: "POST",
            data: {
                purchase_list_id: purchase_list_id,

            },
            url: "server.php",
            success: function(response_x1) {
                var responses_x1 = JSON.parse(response_x1);
                var purchase_id = responses_x1[0][0];
                var purchase_date = responses_x1[0][7];
                var purchase_quantity = responses_x1[0][3];
                var sold_quantity = responses_x1[0][9];
                var purchase_price_per = Number(responses_x1[0][4]) + Number(responses_x1[0][5]);
                var item_name = responses_x1[0][8];
                var unit_name = responses_x1[0][10];
                var remain_amount = Number(purchase_quantity) - Number(sold_quantity);

                var row =
                    "<tr id='row_id_" + count_2 + "'>";
                row += "<td class='idss'>" + count_2 + "</td>";
                row +=
                    "<td><input type='text' class='form-control' readonly name='purchase_item_name' value='" +
                    item_name +
                    "' /><input type='hidden' class='form-control' readonly name='purchase_id' value='" +
                    purchase_id + "' /></td>";
                row +=
                "<td><input type='text' class='form-control' readonly name='purchase_date' value='" +
                purchase_date +
                "' /></td>";
                row +=
                "<td><input type='text' class='form-control item_remain_amount' readonly name='remain_amount' id='item_remain_amount_" +
                    count_2 + "' value='" +
                remain_amount +
                "' /><input type='hidden' class='form-control item_remain_amount' readonly name='remain_amount' id='item_remain_amount_hidden_" +
                    count_2 + "' value='" +
                remain_amount +
                "' /></td>";
                row +=
                    "<td><input type='text' class='form-control' readonly name='unit_name' value='" +
                    unit_name +
                    "' /></td>";
                row +=
                    "<td><input type='text' class='form-control amount'  name='amount' id='amount_" +
                    count_2 + "'  value='1' /></td>";
                row +=
                    "<td><input type='text' class='form-control purchase_price' id='purchase_price_" +
                    count_2 + "' name='purchase_price' readonly value='"+purchase_price_per+"' /></td>";
                row +=
                "<td><input type='text' class='form-control sale_price' id='sale_price_" +
                count_2 + "' name='sale_price' value='0' /></td>";
                row +=
                    "<td><input type='text' class='form-control row_total' readonly name='row_total' id='row_total_" +
                    count_2 + "' value='0' /></td>";
                row +=
                    "<td class='text-right print-display'><textarea name='details'></textarea></td>";
                row +=
                    "<td class='text-center print-display'><span class='fa fa-trash text text-danger delete_btn' id='" +
                    count_2 + "'></span></td>";
                row += "</tr>";


                $("#bill_tbody").append(row);
                total_cal(count_2);
                count_2++;


                // $("#search_input_id").val("");
            }
        });


    });

    function total_cal(count) {

        var total_price = 0;
        for (var x = 1; x <= count; x++) {
            // alert($('#amount_' + x).val());
           

            var sale_price = Number($('#sale_price_' + x).val());

            if(isNaN(sale_price))
            {
                sale_price = 0;
                amount = 0;
            }
            else
            {
                var sale_price = Number($('#sale_price_' + x).val());
                // alert(row_id_price);
                var amount = Number($('#amount_' + x).val());
            }
            
            var item_remain_amount = Number($('#item_remain_amount_hidden_' + x).val());
            var actual_price = sale_price * amount;
            $('#row_total_' + x).val(actual_price);
            $('#item_remain_amount_' + x).val(item_remain_amount - amount);
            
            total_price = total_price + Number(actual_price);
            // $('#total_amount_' + x).val(actual_price.toFixed(0));

        }
        $('#total_price_final').val(total_price.toFixed(2));

        var total_price = Number($('#total_price_final').val());

        var total_reciept = Number($('#total_reciept').val());
        $("#total_remain").html(total_price - total_reciept);

    }


    // $(function() {
    //     $("#return_date").hide();
    // });
    $(document).on('keyup', '.total_reciept', function() {

        var total_price = parseFloat($('#total_price_final').val());
        var total_reciept = parseFloat($('#total_reciept').val());
        var rate = Number($('#rate').val());
        $("#total_remain").html((total_price - (total_reciept/rate)).toFixed(2));

    });
    $(document).on('keyup', '.amount', function() {
        
        total_cal(count_2);

    });
    $(document).on('keyup', '.sale_price', function() {
        total_cal(count_2);

    });

    // Update print date when sale date changes
    $(document).on('change', '#sale_date', function() {
        var saleDate = $(this).val();
        if(saleDate) {
            // Format date for display (you can customize this format)
            var dateObj = new Date(saleDate);
            var formattedDate = dateObj.toLocaleDateString('fa-IR');
            $('#print_sale_date').text('تاریخ: ' + saleDate);
        }
    });

    // Initialize print date on page load
    $(document).ready(function() {
        var saleDate = $('#sale_date').val();
        if(saleDate) {
            $('#print_sale_date').text('تاریخ: ' + saleDate);
        } else {
            var today = new Date().toISOString().split('T')[0];
            $('#print_sale_date').text('تاریخ: ' + today);
        }
    });
    </script>

    <script>
    $(document).on('click', '.delete_btn', function() {
        var row_id = $(this).attr("id");
        $("#row_id_" + row_id).remove();

        total_cal(count_2);


        set_ids_front();




    });

    function set_ids_front() {
        var num_ids = $('.idss').length;

        // $('.idss').index(0).text("wqd");
        for (var x = 1; x <= num_ids; x++) {
            document.getElementsByClassName("idss")[x - 1].innerHTML = x;
        }
    }
    </script>
    <script>
    $(document).ready(() => {

        $('#input_date').datepicker({
            changeMonth: true,
            changeYear: true
        });

    });
    </script>

    <script>
    $("#button_submit").on("click", function() {
        var currency = $("#currency").val();
        var rate = $("#rate").val();
        var sale_date = $("#sale_date").val();
        var customer_id = $("#customer_id").val();
        var total_reciept = $("#total_reciept").val() || 0;

        var purchase_id = $('input[name^=purchase_id]').map(function(idx, elem) {
            return $(elem).val();
        }).get();

        var sale_price = $('input[name^=sale_price]').map(function(idx, elem) {
            return $(elem).val();
        }).get();

        var amount = $('input[name^=amount]').map(function(idx, elem) {
            return $(elem).val();
        }).get();

        var details = $('textarea[name^=details]').map(function(idx, elem) {
            return $(elem).val();
        }).get();

        // Validate required fields
        if(!sale_date || !currency || !customer_id)
        {
            alert("لطفاً تمام فیلدهای الزامی را پر کنید");
            return;
        }
        
        if(purchase_id.length == 0)
        {
            alert("لطفاً حداقل یک جنس اضافه کنید");
            return;
        }

        $.ajax({
            type: "POST",
            data: {
                add_sale_purchase_id: purchase_id,
                amount: amount,
                sale_price: sale_price,
                details: details,
                currency: currency,
                rate: rate,
                sale_date: sale_date,
                total_reciept: total_reciept,
                customer_id: customer_id,
            },
            url: "server.php",
            success: function(response) {
                alert(response);
                if(response.indexOf("موفق") !== -1)
                {
                    // Reload page or clear form on success
                    location.reload();
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("خطا در ارتباط با سرور: " + error);
            }
        });

    });
    </script>
    <script>
    $(function() {
        $(".select2").select2();
    });
    </script>
 

</body>

</html>