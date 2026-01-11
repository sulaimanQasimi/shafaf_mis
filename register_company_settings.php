<?php
    include("database.php");
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
    <link href="assets/css/persian-datepicker.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <!-- Jquery Toast css -->
    <link href="assets/libs/jquery-toast/jquery.toast.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />




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
                        <li class="breadcrumb-item active"> تنظیمات شرکت</li>
                    </ol>
                </div>
                <p class="page-title">صفحه تنظیمات شرکت</pack>
            </div>
            <!-- end page title -->
            <?php 
                 $sql_query_001 = mysqli_query($connection,"SELECT * FROM `company_settings` ORDER BY id DESC LIMIT 1");
                 if(mysqli_num_rows($sql_query_001) > 0)
                 {
                     $fetch_001 = mysqli_fetch_assoc($sql_query_001);
                ?>
  <!-- Form row -->
  <div class="row">
                <div class="col-md-12">
                    <div class="card-box">


                        <form method="post" action="server.php" id="uploadForm" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="company_name" class="col-form-label">نام شرکت</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control  border border-dark"
                                        name="company_name"
                                        oninvalid="this.setCustomValidity('این بخش الزامی میباشد')"
                                        oninput="this.setCustomValidity('')" required id="company_name" value="<?php echo $fetch_001["company_name"]; ?>"
                                        placeholder="بنویسید .. ">
                                        <input type="hidden" name="edit" value="<?php echo $fetch_001["id"]; ?>">

                                </div>
                                <div class="form-group col-md-3">
                                    <label for="company_phone" class="col-form-label">شماره تماس شرکت</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control border border-dark" data-toggle="input-mask"
                                        name="company_phone" oninvalid="this.setCustomValidity('این بخش الزامی میباشد')"
                                        oninput="this.setCustomValidity('')" required id="company_phone"
                                        data-mask-format="(00) 0000-0000" placeholder="بنویسید .. " value="<?php echo $fetch_001["company_phone"]; ?>" maxlength="20">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="company_address" class="col-form-label">آدرس شرکت</label>
                                    <textarea class="form-control border border-dark" name="company_address" id="company_address"
                                        placeholder="بنویسید .. "><?php echo $fetch_001["company_address"]; ?></textarea>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="company_logo" class="col-form-label">لوگو شرکت</label>
                                    <input type="file" class="form-control border border-dark" name="company_logo" id="company_logo" accept="image/*">
                                    <?php if($fetch_001["company_logo"] != "") { ?>
                                    <small class="text-muted">لوگو فعلی: <img src="stuff_documents/images/<?php echo $fetch_001["company_logo"]; ?>" height="50" alt="Logo"></small>
                                    <?php } ?>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light btn-sm">ثبت
                                اطلاعات</button>



                        </form>
                    </div> <!-- end card-box -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
                <?php 
                 }
                 else
                 {
                ?>
  <!-- Form row -->
  <div class="row">
                <div class="col-md-12">
                    <div class="card-box">


                        <form method="post" action="server.php" id="uploadForm" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="company_name" class="col-form-label">نام شرکت</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control  border border-dark"
                                        name="company_name"
                                        oninvalid="this.setCustomValidity('این بخش الزامی میباشد')"
                                        oninput="this.setCustomValidity('')" required id="company_name"
                                        placeholder="بنویسید .. ">
                                        <input type="hidden" name="edit" value="">

                                </div>
                                <div class="form-group col-md-3">
                                    <label for="company_phone" class="col-form-label">شماره تماس شرکت</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control border border-dark" data-toggle="input-mask"
                                        name="company_phone" oninvalid="this.setCustomValidity('این بخش الزامی میباشد')"
                                        oninput="this.setCustomValidity('')" required id="company_phone"
                                        data-mask-format="(00) 0000-0000" placeholder="بنویسید .. " maxlength="20">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="company_address" class="col-form-label">آدرس شرکت</label>
                                    <textarea class="form-control border border-dark" name="company_address" id="company_address"
                                        placeholder="بنویسید .. "></textarea>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="company_logo" class="col-form-label">لوگو شرکت</label>
                                    <input type="file" class="form-control border border-dark" name="company_logo" id="company_logo" accept="image/*">
                                </div>

                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light btn-sm">ثبت
                                اطلاعات</button>



                        </form>
                    </div> <!-- end card-box -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
                <?php 
                 }
                ?>

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

    
    <script type="text/javascript">
        $(document).ready(function (e) {
            $("#uploadForm").on('submit',(function(e) {
                        e.preventDefault();
                    
                        
                        $.ajax({
                            url: "server.php",
                            type: "POST",
                            data:  new FormData(this),
                            contentType: false,
                            cache: false,
                            processData:false,
                            success: function(data)
                            {
                            if(data.trim() == 'success' || data.trim().includes('success'))
                            {
                                document.getElementById("uploadForm").reset();
    
                                $.toast({
                                    heading: ' پاسخ ',
                                    text: 'اطلاعات با موفقیت ثبت شد',
                                    icon: 'success',
                                    loader: true,  
                                    position: 'top-right',      // Change it to false to disable loader
                                    loaderBg: '#9EC600',
                                    bgColor: '#34A853',
                                    textColor: 'white' // To change the background
                                });

                                setTimeout(function(){
                                    location.reload();
                                },1000);
                            }
                            else
                            {
                                document.getElementById("uploadForm").reset();

                                $.toast({
                                    heading: ' پاسخ ',
                                    text: 'خطا در ثبت اطلاعات !',
                                    icon: 'info',
                                    loader: true,  
                                    position: 'top-right',      // Change it to false to disable loader
                                    loaderBg: '#9EC600',
                                    bgColor: '#ff0000',
                                    textColor: 'white' // To change the background
                                });
                            }	
                            },
                            error: function() 
                            {
    
                            } 	        
                        });
                    
                }));
            
        });
        </script>
    
</body>
</html>
