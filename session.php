<?php
    session_start();
    
    if(isset($_SESSION["username"]))
    {
        
    }
    else{
        header("location:index.php");
    }

?>
  <!-- <link rel="shortcut icon" href="images/asrepoya/logo.png" type="image/x-icon">
  <title>سیستم دقیق</title> -->
  <?php
    include("database.php");
    $sql_query_company = mysqli_query($connection,"SELECT * FROM company_settings ORDER BY id DESC LIMIT 1");
    if(mysqli_num_rows($sql_query_company) > 0)
    {
        $company_settings = mysqli_fetch_assoc($sql_query_company);
        $company_name = $company_settings["company_name"];
    }
    else
    {
        $company_name = "shafaf MIS";
    }
  ?>
  <title><?php echo $company_name; ?></title>

