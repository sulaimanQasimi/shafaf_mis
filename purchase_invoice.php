<?php
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
    <link href="assets/libs/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
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

        table tr td,
        table tr th,
        input,
        select {
            font-size: 40px;
            font-weight: bolder;
            text-align: center !important;
        }

        .bill_number {
            font-size: 40px;
            font-weight: bolder;
            color: black !important;
        }

        .print-display {
            display: none !important;
        }

        .form-control {
            border: none !important;
            font-size: 40px !important;
            font-weight: bolder;

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">وزین</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">صفحات</a></li>
                        <li class="breadcrumb-item active">صفحه بل خرید</li>
                    </ol>
                </div>
                <p class="page-title">صفحه بل خرید</pack>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card-box">

                        <!-- Logo & title -->
                        <div class="clearfix">
                            <div class="float-left">
                                <?php if($company_logo != "") { ?>
                                    <img src="stuff_documents/images/<?php echo $company_logo; ?>" alt="<?php echo $company_name; ?>" height="20">
                                <?php } else { ?>
                                    <img src="assets/images/logo-dark.png" alt="<?php echo $company_name; ?>" height="20">
                                <?php } ?>
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
                                            $sql_query_01 = mysqli_query($connection,"SELECT stock_major.id,(SELECT stock_minor.item_name FROM stock_minor WHERE stock_minor.id = stock_major.item_id) as item_name,stock_major.amount,(SELECT unit_major.unit_name FROM unit_major WHERE unit_major.id = stock_major.unit_id) as unit_name  FROM `stock_major` ");
                                            while ($row = mysqli_fetch_assoc($sql_query_01))
                                            {
                                        ?>

                                    <option value="<?php echo $row["id"]; ?>">
                                        <?php echo $row["item_name"].' - '. $row["unit_name"]; ?></option>
                                    <?php
                                            }
                                        ?>
                                </datalist>
                            </div> <!-- end col -->
                            <div class="col-md-4 print-display">
                                <div class="form-group ">
                                    <label for="">تاریخ خرید</label>
                                    <input type="date" value="<?php echo date("Y-m-d"); ?>" name="purchase_date" 
                                        class="form-control" id="purchase_date">
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
                                                        تمویل کننده : </p>

                                                </th>
                                                <th colspan="8">

                                                    <select id="supplier_major_id" class="select2 form-control">
                                                        <?php
                                                                $sql_query_01 = mysqli_query($connection,"select * from suppliers");
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
                                                <th style="width: 15%">جنس</th>
                                                <th style="width: 10%">واحد</th>
                                                <th style="width: 10%">مقدار</th>
                                                <th style="width: 10%" class="text-right">قیمت خرید | 1</th>
                                                <th style="width: 10%" class="text-right">هزینه اضافی | 1</th>
                                                <th style="width: 10%" class="text-right">مجموع</th>
                                                <th style="width: 10%" class="text-right print-display">توضیحات</th>
                                                <th style="width: 5%" class="text-right print-display">عمل</th>
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
                                <a href="javascript:window.print()"
                                    class="btn btn-danger waves-effect btn-sm waves-light"><i
                                        class="mdi mdi-printer mr-1"></i>چاپ</a>
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



    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <!-- Vendor js -->
    <!-- <script src="assets/js/vendor.min.js"></script> -->
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/libs/bootstrap-select/bootstrap-select.min.js"></script>
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
                    major_stock_item_id: search_input_id,

                },
                url: "server.php",
                success: function(response_x1) {
                    var responses_x1 = JSON.parse(response_x1);

                    var row =
                        "<tr id='row_id_" + count_2 + "'>";
                    row += "<td class='idss'>" + count_2 + "</td>";
                    row +=
                        "<td><input type='text' class='form-control' readonly name='purchase_item_name' value='" +
                        responses_x1["item_name"] +
                        "' /><input type='hidden' class='form-control' readonly name='major_stock_id' value='" +
                        responses_x1["id"] + "' /></td>";
                    row +=
                        "<td><input type='text' class='form-control' readonly name='unit_name' value='" +
                        responses_x1["unit_name"] +
                        "' /></td>";
                    row +=
                        "<td><input type='text' class='form-control amount'  name='amount' id='amount_" +
                        count_2 + "'  value='0' /></td>";
                    row +=
                        "<td><input type='text' class='form-control purchase_price' id='purchase_price_" +
                        count_2 + "' name='purchase_price' value='0' /></td>";
                    row +=
                        "<td><input type='text' class='form-control extra_expense'  name='extra_expense' id='extra_expense_" +
                        count_2 + "'  value='0' /></td>";
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


                    $("#search_input_id").val("");
                }
            });






        });

    });

    function total_cal(count) {
        var total_price = 0;

        for (var x = 1; x <= count; x++) {
            // alert($('#amount_' + x).val());

            var purchase_price = Number($('#purchase_price_' + x).val());
            var extra_expense = Number($('#extra_expense_' + x).val());
            var amount = Number($('#amount_' + x).val());

            if(isNaN(purchase_price))
            {
                purchase_price = 0;
                extra_expense = 0;
                amount = 0;
            }
            else
            {
                var purchase_price = Number($('#purchase_price_' + x).val());
                var extra_expense = Number($('#extra_expense_' + x).val());
                var amount = Number($('#amount_' + x).val());
            }
            
            

            var actual_price = (purchase_price + extra_expense) * amount;
            $('#row_total_' + x).val(actual_price);
            total_price = total_price + Number(actual_price);
            // $('#total_amount_' + x).val(actual_price.toFixed(0));



        }
        // alert(total_price);
        $('#total_price_final').val(total_price.toFixed(2));

        var total_price = Number($('#total_price_final').val());

        var total_reciept = Number($('#total_reciept').val());
        $("#total_remain").html(total_price - total_reciept);

    }


    // $(function() {
    //     $("#return_date").hide();
    // });
    $(document).on('keyup', '.total_reciept', function() {

        var total_price = Number($('#total_price_final').val());
        var total_reciept = Number($('#total_reciept').val());
        var rate = Number($('#rate').val());
        $("#total_remain").html((total_price - (total_reciept/rate)).toFixed(2));


    });
    $(document).on('keyup', '.amount', function() {
        total_cal(count_2 - 1);

    });
    $(document).on('keyup', '.purchase_price', function() {
        total_cal(count_2 - 1);

    });
    $(document).on('keyup', '.extra_expense', function() {
        total_cal(count_2 - 1);

    });
    </script>

    <script>
    $(document).on('click', '.delete_btn', function() {
        var row_id = $(this).attr("id");
        $("#row_id_" + row_id).remove();

        total_cal(count_2 - 1);


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
        var purchase_date = $("#purchase_date").val();;

        var total_price_final = $("#total_price_final").val();
        var total_reciept = $("#total_reciept").val();
        var supplier_major_id = $("#supplier_major_id").val();

        // var purchase_item_name = $('input[name^=purchase_item_name]').map(function(idx, elem) {
        //     return $(elem).val();
        // }).get();


        var add_purchase_major_stock_id = $('input[name^=major_stock_id]').map(function(idx, elem) {
            return $(elem).val();
        }).get();

        var amount = $('input[name^=amount]').map(function(idx, elem) {
            return $(elem).val();
        }).get();

        var purchase_price = $('input[name^=purchase_price]').map(function(idx, elem) {
            return $(elem).val();
        }).get();

        var extra_expense = $('input[name^=extra_expense]').map(function(idx, elem) {
            return $(elem).val();
        }).get();


        var details = $('textarea[name^=details]').map(function(idx, elem) {
            return $(elem).val();
        }).get();


        $.ajax({
            type: "POST",
            data: {
                add_purchase_major_stock_id: add_purchase_major_stock_id,
                amount: amount,
                purchase_price: purchase_price,
                extra_expense: extra_expense,
                details: details,
                currency: currency,
                rate: rate,
                purchase_date: purchase_date,
                total_price_final: total_price_final,
                total_reciept: total_reciept,
                supplier_major_id: supplier_major_id,
            },
            url: "server.php",
            success: function(response) {
                alert(response);
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
