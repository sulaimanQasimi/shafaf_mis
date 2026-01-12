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