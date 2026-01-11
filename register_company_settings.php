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

    <style>
        .company-settings-card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: none;
        }
        .form-section-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }
        .form-group label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        .form-control:focus {
            border-color: #5cb85c;
            box-shadow: 0 0 0 0.2rem rgba(92, 184, 92, 0.25);
        }
        .logo-preview-container {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .logo-preview-container img {
            max-width: 100%;
            max-height: 120px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .logo-upload-area {
            position: relative;
            cursor: pointer;
        }
        .logo-upload-icon {
            font-size: 48px;
            color: #6c757d;
            margin-bottom: 10px;
        }
        .info-icon {
            color: #17a2b8;
            margin-left: 5px;
        }
        .btn-submit {
            padding: 12px 40px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .input-group-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10;
        }
        .form-group {
            position: relative;
        }
        .required-field::after {
            content: " *";
            color: #dc3545;
            font-weight: bold;
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
                        <li class="breadcrumb-item active"> تنظیمات شرکت</li>
                    </ol>
                </div>
                <p class="page-title">
                    <i class="mdi mdi-settings mr-2"></i>صفحه تنظیمات شرکت
                </p>
            </div>
            <!-- end page title -->

            <?php 
                 $sql_query_001 = mysqli_query($connection,"SELECT * FROM `company_settings` ORDER BY id DESC LIMIT 1");
                 $is_edit = false;
                 $fetch_001 = array();
                 if(mysqli_num_rows($sql_query_001) > 0)
                 {
                     $is_edit = true;
                     $fetch_001 = mysqli_fetch_assoc($sql_query_001);
                 }
            ?>

            <!-- Form row -->
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-10">
                    <div class="card company-settings-card">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <h4 class="mb-1">
                                    <i class="mdi mdi-office-building mr-2 text-primary"></i>
                                    <?php echo $is_edit ? 'ویرایش اطلاعات شرکت' : 'ثبت اطلاعات شرکت'; ?>
                                </h4>
                                <p class="text-muted mb-0">لطفاً اطلاعات شرکت خود را وارد کنید</p>
                            </div>

                            <form method="post" action="server.php" id="uploadForm" enctype="multipart/form-data">
                                
                                <!-- Company Information Section -->
                                <div class="form-section-title">
                                    <i class="mdi mdi-information-outline mr-2"></i>
                                    اطلاعات اصلی شرکت
                                </div>

                                <div class="row">
                                    <!-- Company Name -->
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="company_name" class="required-field">
                                                <i class="mdi mdi-office-building-outline mr-1"></i>
                                                نام شرکت
                                            </label>
                                            <div class="position-relative">
                                                <input type="text" 
                                                    class="form-control form-control-lg border" 
                                                    name="company_name"
                                                    id="company_name"
                                                    value="<?php echo $is_edit ? htmlspecialchars($fetch_001["company_name"]) : ''; ?>"
                                                    placeholder="نام شرکت را وارد کنید"
                                                    oninvalid="this.setCustomValidity('این بخش الزامی میباشد')"
                                                    oninput="this.setCustomValidity('')" 
                                                    required>
                                                <i class="mdi mdi-office-building input-group-icon"></i>
                                            </div>
                                            <input type="hidden" name="edit" value="<?php echo $is_edit ? $fetch_001["id"] : ''; ?>">
                                        </div>
                                    </div>

                                    <!-- Company Phone -->
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="company_phone" class="required-field">
                                                <i class="mdi mdi-phone mr-1"></i>
                                                شماره تماس شرکت
                                            </label>
                                            <div class="position-relative">
                                                <input type="text" 
                                                    class="form-control form-control-lg border" 
                                                    name="company_phone"
                                                    id="company_phone"
                                                    value="<?php echo $is_edit ? htmlspecialchars($fetch_001["company_phone"]) : ''; ?>"
                                                    placeholder="شماره تماس را وارد کنید"
                                                    data-toggle="input-mask"
                                                    data-mask-format="(00) 0000-0000"
                                                    oninvalid="this.setCustomValidity('این بخش الزامی میباشد')"
                                                    oninput="this.setCustomValidity('')" 
                                                    required
                                                    maxlength="20">
                                                <i class="mdi mdi-phone input-group-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Company Address -->
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="company_address">
                                                <i class="mdi mdi-map-marker-outline mr-1"></i>
                                                آدرس شرکت
                                            </label>
                                            <textarea class="form-control border" 
                                                name="company_address" 
                                                id="company_address"
                                                rows="3"
                                                placeholder="آدرس کامل شرکت را وارد کنید"><?php echo $is_edit ? htmlspecialchars($fetch_001["company_address"]) : ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Logo Section -->
                                <div class="form-section-title mt-4">
                                    <i class="mdi mdi-image-outline mr-2"></i>
                                    لوگو شرکت
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="company_logo">
                                                <i class="mdi mdi-image mr-1"></i>
                                                آپلود لوگو
                                                <i class="mdi mdi-information-outline info-icon" 
                                                   data-toggle="tooltip" 
                                                   title="فرمت‌های مجاز: JPG, PNG, GIF. حداکثر اندازه: 2MB"></i>
                                            </label>
                                            
                                            <!-- Logo Preview Area -->
                                            <div class="logo-preview-container mb-3" id="logoPreviewContainer">
                                                <?php if($is_edit && $fetch_001["company_logo"] != "") { ?>
                                                    <img src="stuff_documents/images/<?php echo htmlspecialchars($fetch_001["company_logo"]); ?>" 
                                                         alt="لوگو فعلی" 
                                                         id="currentLogoPreview">
                                                    <small class="text-muted mt-2 d-block">لوگو فعلی</small>
                                                <?php } else { ?>
                                                    <div class="logo-upload-area">
                                                        <i class="mdi mdi-cloud-upload logo-upload-icon"></i>
                                                        <p class="text-muted mb-0">برای آپلود لوگو کلیک کنید</p>
                                                        <small class="text-muted">فرمت‌های مجاز: JPG, PNG, GIF</small>
                                                    </div>
                                                <?php } ?>
                                            </div>

                                            <!-- File Input -->
                                            <div class="custom-file">
                                                <input type="file" 
                                                    class="custom-file-input" 
                                                    name="company_logo" 
                                                    id="company_logo" 
                                                    accept="image/*"
                                                    onchange="previewLogo(this)">
                                                <label class="custom-file-label" for="company_logo">
                                                    <i class="mdi mdi-file-image mr-2"></i>
                                                    انتخاب فایل لوگو
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">
                                                <i class="mdi mdi-information-outline mr-1"></i>
                                                لوگو در تمام صفحات سیستم نمایش داده می‌شود
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-success btn-submit waves-effect waves-light">
                                            <i class="mdi mdi-content-save mr-2"></i>
                                            <?php echo $is_edit ? 'ذخیره تغییرات' : 'ثبت اطلاعات'; ?>
                                        </button>
                                        <button type="reset" class="btn btn-secondary waves-effect waves-light ml-2">
                                            <i class="mdi mdi-refresh mr-2"></i>
                                            بازنشانی فرم
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-box -->
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

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>
    <script src="assets/libs/jquery-toast/jquery.toast.min.js"></script>

    <script type="text/javascript">
        // Logo Preview Function
        function previewLogo(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    var previewContainer = document.getElementById('logoPreviewContainer');
                    previewContainer.innerHTML = '<img src="' + e.target.result + '" alt="پیش‌نمایش لوگو" style="max-width: 100%; max-height: 120px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);"><small class="text-muted mt-2 d-block">پیش‌نمایش لوگو جدید</small>';
                };
                
                reader.readAsDataURL(input.files[0]);
                
                // Update file input label
                var fileName = input.files[0].name;
                var label = input.nextElementSibling;
                label.innerHTML = '<i class="mdi mdi-file-image mr-2"></i>' + fileName;
            }
        }

        // Bootstrap file input label update
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html('<i class="mdi mdi-file-image mr-2"></i>' + fileName);
        });

        // Initialize tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        // Form Submission
        $(document).ready(function (e) {
            $("#uploadForm").on('submit',(function(e) {
                e.preventDefault();
                
                // Show loading state
                var submitBtn = $(this).find('button[type="submit"]');
                var originalText = submitBtn.html();
                submitBtn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-2"></i>در حال ذخیره...');
                
                $.ajax({
                    url: "server.php",
                    type: "POST",
                    data:  new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data)
                    {
                        var response = data.trim();
                        if(response == 'success' || response.includes('success'))
                        {
                            $.toast({
                                heading: 'موفقیت',
                                text: 'اطلاعات با موفقیت ثبت شد',
                                icon: 'success',
                                loader: true,  
                                position: 'top-right',
                                loaderBg: '#9EC600',
                                bgColor: '#34A853',
                                textColor: 'white'
                            });

                            setTimeout(function(){
                                location.reload();
                            }, 1500);
                        }
                        else
                        {
                            var errorMsg = 'خطا در ثبت اطلاعات !';
                            if(response.includes('failed:'))
                            {
                                errorMsg = 'خطا: ' + response.split('failed:')[1];
                            }

                            $.toast({
                                heading: 'خطا',
                                text: errorMsg,
                                icon: 'error',
                                loader: true,  
                                position: 'top-right',
                                loaderBg: '#9EC600',
                                bgColor: '#ff0000',
                                textColor: 'white'
                            });
                            
                            // Restore button
                            submitBtn.prop('disabled', false).html(originalText);
                        }	
                    },
                    error: function() 
                    {
                        $.toast({
                            heading: 'خطا',
                            text: 'خطا در ارتباط با سرور',
                            icon: 'error',
                            loader: true,  
                            position: 'top-right',
                            loaderBg: '#9EC600',
                            bgColor: '#ff0000',
                            textColor: 'white'
                        });
                        
                        // Restore button
                        submitBtn.prop('disabled', false).html(originalText);
                    } 	        
                });
            }));
        });
    </script>
    
</body>
</html>
