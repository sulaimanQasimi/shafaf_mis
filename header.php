<?php 
include_once("session.php");
include("database.php");  

$emp_id = $_SESSION["employee_id"];

$sql_query_001 = mysqli_query($connection,"select id,full_name,image from staff where id='$emp_id'");
$fetch_001 = mysqli_fetch_assoc($sql_query_001);
if(!$fetch_001) {
    $fetch_001 = array("id" => "", "full_name" => "User", "image" => "");
}

// Get company settings
$sql_query_company = mysqli_query($connection,"SELECT * FROM company_settings ORDER BY id DESC LIMIT 1");
$company_settings = array();
if(mysqli_num_rows($sql_query_company) > 0)
{
    $company_settings = mysqli_fetch_assoc($sql_query_company);
    $company_name = $company_settings["company_name"];
    $company_logo = $company_settings["company_logo"];
    $company_phone = $company_settings["company_phone"];
    $company_address = $company_settings["company_address"];
}
else
{
    $company_name = "shafaf MIS";
    $company_logo = "";
    $company_phone = "";
    $company_address = "";
}

?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap');
    
    body, li a {
        font-family: 'Amiri', serif !important;
        font-weight: bold;
    }

    /* Enhanced Header Styles */
    #topnav {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 2px 20px rgba(0,0,0,0.1);
    }

    .navbar-custom {
        background: transparent;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .logo-box {
        padding-right: 30px;
        padding-left: 20px;
    }

    .logo {
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .logo:hover {
        transform: scale(1.05);
    }

    .logo-lg {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo-lg img {
        transition: all 0.3s ease;
    }

    .logo-lg:hover img {
        transform: rotate(5deg);
    }

    .company-name-text {
        color: #fff;
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .nav-user {
        padding: 8px 15px !important;
        border-radius: 50px;
        transition: all 0.3s ease;
        background: transparent;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #fff;
    }

    .nav-user:hover {
        background: transparent;
        transform: translateY(-2px);
        color: #fff;
        text-decoration: none;
    }

    .nav-user img {
        width: 40px;
        height: 40px;
        border: 2px solid rgba(255,255,255,0.3);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }

    .nav-user:hover img {
        border-color: rgba(255,255,255,0.6);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .pro-user-name {
        color: #fff;
        font-weight: 600;
        font-size: 14px;
    }

    .profile-dropdown {
        border-radius: 10px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        border: none;
        margin-top: 10px;
        padding: 10px 0;
        min-width: 250px;
    }

    .profile-dropdown .dropdown-item {
        padding: 12px 20px;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .profile-dropdown .dropdown-item:hover {
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.1) 0%, transparent 100%);
        border-left-color: #667eea;
        padding-right: 25px;
    }

    .profile-dropdown .noti-title {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 15px 20px;
        border-radius: 10px 10px 0 0;
        margin: -10px 0 10px 0;
    }

    .profile-dropdown .noti-title h6 {
        color: #fff;
        font-weight: 700;
        font-size: 16px;
    }

    .profile-dropdown .notify-item {
        color: #495057;
        font-weight: 600;
    }

    .profile-dropdown .notify-item i {
        margin-left: 10px;
        color: #667eea;
        font-size: 18px;
    }

    .profile-dropdown .notify-item:hover {
        color: #667eea;
    }

    /* Enhanced Navigation Menu */
    .navigation-menu > li > a {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        padding: 15px 20px;
        border-radius: 8px;
        margin: 5px 3px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .navigation-menu > li > a::before {
        content: '';
        position: absolute;
        top: 0;
        right: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.1);
        transition: right 0.3s ease;
        z-index: 0;
    }

    .navigation-menu > li > a:hover::before {
        right: 0;
    }

    .navigation-menu > li > a:hover {
        background: rgba(255,255,255,0.15);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .navigation-menu > li > a i {
        font-size: 18px;
        margin-left: 8px;
        position: relative;
        z-index: 1;
    }

    .navigation-menu > li > a .arrow-down {
        position: relative;
        z-index: 1;
    }

    .navigation-menu > li.has-submenu.active > a {
        background: rgba(255,255,255,0.2);
        color: #fff;
    }

    /* Enhanced Submenu */
    .submenu {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        border: none;
        padding: 10px 0;
        margin-top: 5px;
    }

    .submenu li a {
        padding: 12px 25px;
        color: #495057;
        font-weight: 600;
        transition: all 0.3s ease;
        border-right: 3px solid transparent;
    }

    .submenu li a:hover {
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.1) 0%, transparent 100%);
        color: #667eea;
        border-right-color: #667eea;
        padding-right: 30px;
    }

    .submenu hr {
        margin: 8px 0;
        border-color: #e9ecef;
    }

    /* Mobile Menu Toggle */
    .navbar-toggle {
        background: rgba(255,255,255,0.1);
        border-radius: 8px;
        padding: 10px;
        transition: all 0.3s ease;
    }

    .navbar-toggle:hover {
        background: rgba(255,255,255,0.2);
    }

    .navbar-toggle .lines span {
        background-color: #fff;
    }

    /* Topbar Menu */
    .topbar-menu {
        background: rgba(0,0,0,0.05);
        backdrop-filter: blur(10px);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .company-name-text {
            display: none;
        }
        
        .pro-user-name {
            display: none;
        }
    }

    /* Animation */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .profile-dropdown {
        animation: fadeInDown 0.3s ease;
    }

    /* Badge for notifications (if needed in future) */
    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ff4757;
        color: #fff;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
</style>
<title><?php echo $company_name; ?></title>

<header id="topnav">

    <!-- Topbar Start -->
    <div class="navbar-custom">
        <div class="container-fluid">
            <ul class="list-unstyled topnav-menu float-right mb-0">

                <li class="dropdown notification-list">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle nav-link">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </li>

        
                <li class="dropdown notification-list">
                    <a href="logout.php" class="nav-link nav-user mr-0 waves-effect waves-light" role="button">
                        <i class="dripicons-power" style="font-size: 20px;"></i>
                    </a>
                </li>
            </ul>
    
            <ul class="list-unstyled menu-left mb-0">
                <li class="float-left logo-box">
                    <a href="home.php" class="logo">
                        <span class="logo-lg">
                            <?php if($company_logo != "") { ?>
                                <img src="stuff_documents/images/<?php echo $company_logo; ?>" alt="<?php echo $company_name; ?>" height="32">
                            <?php } else { ?>
                                <img src="assets/images/logo-light.png" alt="<?php echo $company_name; ?>" height="32">
                            <?php } ?>
                            <span class="company-name-text d-none d-md-inline"><?php echo $company_name; ?></span>
                        </span>
                        <span class="logo-sm">
                            <?php if($company_logo != "") { ?>
                                <img src="stuff_documents/images/<?php echo $company_logo; ?>" alt="<?php echo $company_name; ?>" height="28">
                            <?php } else { ?>
                                <img src="assets/images/logo-sm.png" alt="<?php echo $company_name; ?>" height="28">
                            <?php } ?>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- end Topbar -->

    <div class="topbar-menu">
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">

                    <li class="has-submenu">
                        <a href="home.php">
                            <i class="dripicons-meter"></i>
                            <span class="d-none d-lg-inline">صفحه اصلی</span>
                        </a>
                    </li>
                    <li class="has-submenu">
                        <a href="#">
                            <i class="mdi mdi-sale"></i>
                            <span class="d-none d-lg-inline">فروش</span>
                            <div class="arrow-down"></div>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="pages-invoice.php">صفحه ث فروش</a>
                            </li>
                            <li>
                                <a href="selled_page.php">نمایش صفحه فروش</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#">
                            <i class="mdi mdi-cart"></i>
                            <span class="d-none d-lg-inline">خرید</span>
                            <div class="arrow-down"></div>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="purchase_invoice.php">صفحه بل خرید</a>
                            </li>
                            <li>
                                <a href="purchased_items.php">نمایش صفحه خرید</a>
                            </li>
                            
                        </ul>
                    </li>

                    

                    <li class="has-submenu">
                        <a href="#">
                            <i class="icon-user-following"></i>
                            <span class="d-none d-lg-inline">کارمندان</span>
                            <div class="arrow-down"></div>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="register_employee.php">ثبت کارمند</a>
                            </li>
                            <li>
                                <a href="registered_employees.php">کارمندان ثبت شده</a>
                            </li>
                            <hr>
                            <li>
                                <a href="register_user.php">ثبت کاربر</a>
                            </li>
                            <li>
                                <a href="registered_users.php">کاربران ثبت شده</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#">
                            <i class="mdi mdi-account-badge-horizontal"></i>
                            <span class="d-none d-lg-inline">تامین کنندگان</span>
                            <div class="arrow-down"></div>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="register_supplier.php">ثبت تامین کننده</a>
                            </li>
                            <li>
                                <a href="registered_suppliers.php">تامین کنندگان ثبت شده</a>
                            </li>
                            <li>
                                <a href="suppliers_billance.php">بیلانس تامین کنندگان</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#">
                            <i class="mdi mdi-source-branch"></i>
                            <span class="d-none d-lg-inline">کالاها</span>
                            <div class="arrow-down"></div>
                        </a>
                        <ul class="submenu">
                         
                            <li>
                                <a href="register_exist_good.php">ثبت کالای موجود</a>
                            </li>
                            <li>
                                <a href="stock_minor_units.php">موجودی واحدهای فرعی</a>
                            </li>
                            <hr>
                            <li>
                                <a href="register_good.php">ثبت کالا</a>
                            </li>
                            <li>
                                <a href="registered_goods.php">کالاهای ثبت شده</a>
                            </li>

                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#">
                            <i class="mdi mdi-home-currency-usd"></i>
                            <span class="d-none d-lg-inline">مخارج</span>
                            <div class="arrow-down"></div>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="register_expense.php">ثبت مخارج</a>
                            </li>
                            <li>
                                <a href="registered_expenses.php">مخارج ثبت شده</a>
                            </li>
                            <li>
                                <a href="register_expense_category.php">ثبت دسته مخارج</a>
                            </li>
                            <li>
                                <a href="registered_expenses_category.php">دسته‌های مخارج ثبت شده</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#">
                            <i class="mdi mdi-account-group"></i>
                            <span class="d-none d-lg-inline">مشتریان</span>
                            <div class="arrow-down"></div>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="register_customer.php">ثبت مشتری</a>
                            </li>
                            <li>
                                <a href="registered_customers.php">مشتریان ثبت شده</a>
                            </li>
                            <li>
                                <a href="customers_billance.php">بیلانس مشتریان</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#">
                            <i class="mdi mdi-settings"></i>
                            <span class="d-none d-lg-inline">تنظیمات</span>
                            <div class="arrow-down"></div>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="register_company_settings.php">
                                    <i class="mdi mdi-office-building mr-2"></i>
                                    تنظیمات شرکت
                                </a>
                            </li>
                            <li>
                                <a href="database_backup.php">
                                    <i class="mdi mdi-database-export mr-2"></i>
                                    پشتیبان‌گیری از پایگاه داده
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#">
                            <i class="mdi mdi-format-list-checkbox"></i>
                            <span class="d-none d-lg-inline">واحدها</span>
                            <div class="arrow-down"></div>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="register_minor_unit.php">ثبت واحد فرعی</a>
                            </li>
                            <li>
                                <a href="registered_minor_units.php">واحدهای فرعی ثبت شده</a>
                            </li>
                            <hr>
                            <li>
                                <a href="register_major_unit.php">ثبت واحد اصلی</a>
                            </li>
                            <li>
                                <a href="registered_major_units.php">واحدهای اصلی ثبت شده</a>
                            </li>
                            
                        </ul>
                    </li>
                    
                   

                </ul>
                <!-- End navigation menu -->

                <div class="clearfix"></div>
            </div>
            <!-- end #navigation -->
        </div>
        <!-- end container -->
    </div>
    <!-- end navbar-custom -->

</header>

        
