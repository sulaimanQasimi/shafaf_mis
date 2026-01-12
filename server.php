<?php
    include("database.php");
    include("jdf.php");
    session_start();
    if(isset($_POST["login_username"]))
    {
        $login_username = $_POST["login_username"];
        $password = base64_encode($_POST["password"]);
        
        $sql_query_001 = mysqli_query($connection,"select * from user_account where user_name='$login_username' and password = '$password'");
        
        if (mysqli_num_rows($sql_query_001) > 0)
        {   
            $fetch_001 = mysqli_fetch_assoc($sql_query_001);
            $_SESSION["username"] = $fetch_001["user_name"];
            $_SESSION["password"] = base64_decode($fetch_001["password"]);
            $_SESSION["employee_id"] = $fetch_001["employee_id"];

            echo "success";
        }
        else
        {
            echo json_encode([
                'status' => 'error',
                'username' => $login_username,
                'password' => $password
            ],JSON_UNESCAPED_UNICODE);
        }

        exit();
        
    }

    // $user_id = $_SESSION["user_id"];

    
    
    if(isset($_POST["units_list"]))
    {
        $sql_query_001 = mysqli_query($connection,"SELECT * FROM minor_units");
        
        $array_tb = array();
        $counter = 0;
        while ($rows = mysqli_fetch_array($sql_query_001)) {
            
            array_push($array_tb,$rows);

            $counter++;
        }

        print_r(json_encode($array_tb));

        exit();
        
    }


    if(isset($_POST["major_stock_item_id"]))
    {
        $stock_minor_id = $_POST["major_stock_item_id"];

        $sql_query_001 = mysqli_query($connection,"SELECT stock_major.id,stock_minor.item_name,stock_major.amount,unit_major.unit_name  FROM `stock_major` LEFT JOIN stock_minor ON stock_major.item_id = stock_minor.id LEFT JOIN  unit_major on unit_major.id = stock_major.unit_id where stock_minor.id='$stock_minor_id' LIMIT 1");
        
        
       
        print_r(json_encode(mysqli_fetch_array($sql_query_001)));

        exit();
        
    }
    if(isset($_POST["major_stock_item_id_purchase_list"]))
    {
        $major_stock_item_id_purchase_list = $_POST["major_stock_item_id_purchase_list"];

        $sql_query_001 = mysqli_query($connection,"SELECT purchase_minor.*,purchase_major.date as purchase_date,stock_minor.item_name,(SELECT sum(sale_minor.amount) FROM sale_minor WHERE sale_minor.purchase_minor_id = purchase_minor.id) as total_sold_amount,(SELECT unit_minor.unit_name from unit_minor WHERE unit_minor.id = (SELECT stock_major.minor_unit_id FROM stock_major WHERE stock_major.id = purchase_minor.item_id_stock_major)) as minor_unit_name FROM `purchase_minor` LEFT JOIN purchase_major ON purchase_minor.purchase_major_id = purchase_major.id LEFT JOIN stock_minor ON stock_minor.id = purchase_minor.item_id_stock_major where purchase_minor.item_id_stock_major = '$major_stock_item_id_purchase_list' and purchase_minor.amount > 0;");
        
        
       
        $array_tb = array();
        $counter = 0;
        while ($rows = mysqli_fetch_array($sql_query_001)) {
            
            array_push($array_tb,$rows);

            $counter++;
        }

        print_r(json_encode($array_tb));

        exit();
        
    }

    if(isset($_POST["purchase_list_id"]))
    {
        $purchase_list_id = $_POST["purchase_list_id"];

        $sql_query_001 = mysqli_query($connection,"SELECT purchase_minor.*,purchase_major.date as purchase_date,stock_minor.item_name,(SELECT sum(sale_minor.amount) FROM sale_minor WHERE sale_minor.purchase_minor_id = purchase_minor.id) as total_sold_amount,(SELECT unit_minor.unit_name from unit_minor WHERE unit_minor.id = (SELECT stock_major.minor_unit_id FROM stock_major WHERE stock_major.id = purchase_minor.item_id_stock_major)) as minor_unit_name FROM `purchase_minor` LEFT JOIN purchase_major ON purchase_minor.purchase_major_id = purchase_major.id LEFT JOIN stock_minor ON stock_minor.id = purchase_minor.item_id_stock_major WHERE purchase_minor.id ='$purchase_list_id'");
        
        
       
        $array_tb = array();
        $counter = 0;
        while ($rows = mysqli_fetch_array($sql_query_001)) {
            
            array_push($array_tb,$rows);

            $counter++;
        }

        print_r(json_encode($array_tb));

        exit();
        
    }


    if(isset($_POST["minor_unit_id"]))
    {
        $minor_unit_id = $_POST["minor_unit_id"];
        $sql_query_001 = mysqli_query($connection,"SELECT pack_quantity,kg_factor FROM minor_units where id='$minor_unit_id'");
        
        $array_tb = array();
            array_push($array_tb,mysqli_fetch_array($sql_query_001));

        print_r(json_encode($array_tb));

        exit();
        
    }

    if(isset($_POST["stuff_full_name"]))
    {
        $stuff_full_name = $_POST["stuff_full_name"];
        $phone_number = $_POST["phone_number"];
        $address = $_POST["address"];

        // upload the image 
        $picUpload = $_FILES['image']['name'];
        $picSource = $_FILES['image']['tmp_name'];
        $picTarget = 'stuff_documents/images/'.$_FILES['image']['name'];
        move_uploaded_file($picSource, $picTarget);


        $input_date = $_POST["input_date"];
        $date =  $input_date;

        

        $sql_query_001 = mysqli_query($connection,"INSERT INTO `staff` (`id`, `full_name`, `phone_number`, `address`, `image`, `date`) VALUES (NULL, '$stuff_full_name', '$phone_number', '$address', '$picUpload', '$date')");
        
        if ($sql_query_001)
        {
            echo "success";
        }
        else
        {
            echo "failed";
        }

        exit();
        
    }

    if(isset($_POST["user_name_employee"]))
    {
        $user_name_employee = $_POST["user_name_employee"];
        $employee_id = $_POST["employee_id"];
        $password_employee = base64_encode($_POST["password_employee"]);
        $authority = $_POST["authority"];

        $sql_query_001 = mysqli_query($connection,"INSERT INTO `user_account` (`id`, `employee_id`, `user_name`, `password`, `authority`) VALUES (NULL, '$employee_id', '$user_name_employee', '$password_employee', '$authority')");
        
        if ($sql_query_001)
        {
            echo "success";
        }
        else
        {
            echo "failed";
        }

        exit();
        
    }

    

    if(isset($_POST["agency_name"]))
    {
        $agency_name = $_POST["agency_name"];
        $agency_type = $_POST["agency_type"];   
        $agency_admin_id = $_POST["agency_admin_id"];   
        $date = date("Y-m-d");

        $sql_query_001 = mysqli_query($connection,"INSERT INTO `agencies` (`id`, `agency_name`, `agency_admin_id`,`agency_type`, `user_id`, `date`) VALUES (NULL, '$agency_name','$agency_admin_id', '$agency_type', '$user_id', '$date')");
        
        if ($sql_query_001)
        {
            echo "success";
        }
        else
        {
            echo "failed";
        }

        exit();
        
    }

    

    if(isset($_POST["good_name"]))
    {
        $good_name = mysqli_real_escape_string($connection, $_POST["good_name"]);
        $edit = mysqli_real_escape_string($connection, $_POST["edit"]);
        
        
      
        if($edit == "")
        {
            $sql_query_001 = mysqli_query($connection,"INSERT INTO `stock_minor` (`item_name`) VALUES ('$good_name')");


            if ($sql_query_001)
            {
                echo "success-";
            }
            else
            {
                echo "failed-: " . mysqli_error($connection);
            }
        }
        else
        {
            $sql_query_001 = mysqli_query($connection,"UPDATE stock_minor SET item_name='$good_name' WHERE id='$edit'");
            if ($sql_query_001)
            {
                echo "success - registered_goods.php";
            }
            else
            {
                echo "failed - registered_goods.php: " . mysqli_error($connection);
            }
        }

        exit();
        
    }

    if(isset($_POST["add_exist_good_id"]))
    {
        $add_exist_good_id = $_POST["add_exist_good_id"];
        $amount = $_POST["amount"];
        $major_unit_id = $_POST["major_unit_id"];
        $add_minor_unit_id = $_POST["add_minor_unit_id"];
        
        $sql_query_001 = mysqli_query($connection,"INSERT INTO `stock_major` (`id`, `item_id`, `amount`, `unit_id`, `minor_unit_id`) VALUES (NULL, '$add_exist_good_id', '$amount', '$major_unit_id', '$add_minor_unit_id')");
        
        if ($sql_query_001)
        {
            echo "success";
        }
        else
        {
            echo "failed";
        }

        exit();
        
    }

    if(isset($_POST["customer_full_name"]))
    {
        $customer_full_name = $_POST["customer_full_name"];
        $phone_number = $_POST["phone_number"];
        $address = $_POST["address"];
        $date = date("Y-m-d");
        $edit = $_POST["edit"];
        
        
        if($edit == "")
        {
            $sql_query_001 = mysqli_query($connection,"INSERT INTO `customers` (`id`, `full_name`, `phone_number`, `address`, `date`) VALUES (NULL, '$customer_full_name', '$phone_number', '$address', '$date')");

            if ($sql_query_001)
            {
                echo "success-";
            }
            else
            {
                echo "failed-";
            }
        }
        else
        {
            $sql_query_001 = mysqli_query($connection,"UPDATE customers set full_name='$customer_full_name',phone_number='$phone_number',address='$address' WHERE id='$edit'");
            if ($sql_query_001)
            {
                echo "success - registered_customers.php";
            }
            else
            {
                echo "failed - registered_customers.php";
            }
        }
        

        exit();
        
    }

    if(isset($_POST["supplier_full_name"]))
    {
        $supplier_full_name = $_POST["supplier_full_name"];
        $phone_number = $_POST["phone_number"];
        $address = $_POST["address"];
        $date = date("Y-m-d");
        
       
        $edit = $_POST["edit"];
        
        
        if($edit == "")
        {
            $sql_query_001 = mysqli_query($connection,"INSERT INTO `suppliers` (`id`, `full_name`, `phone_number`, `address`, `date`) VALUES (NULL, '$supplier_full_name', '$phone_number', '$address', '$date')");
        
            if ($sql_query_001)
            {
                echo "success-";
            }
            else
            {
                echo "failed-";
            }
        }
        else
        {
            $sql_query_001 = mysqli_query($connection,"UPDATE suppliers SET full_name='$supplier_full_name',phone_number='$phone_number',address='$address' WHERE id='$edit'");
        
            if ($sql_query_001)
            {
                echo "success - registered_suppliers.php";
            }
            else
            {
                echo "failed - registered_suppliers.php";
            }
        }
        


        exit();
        
    }


    if(isset($_POST["add_minor_unit_major_id"]))
    {
        $add_minor_unit_major_id = $_POST["add_minor_unit_major_id"];
        $unit_name = $_POST["unit_name"];
        $unit_pack_qantity = $_POST["unit_pack_qantity"];
        $kg_factor = $_POST["kg_factor"];
        $edit = $_POST["edit"];
        
        
        if($edit == "")
        {
            $sql_query_001 = mysqli_query($connection,"INSERT INTO `unit_minor` (`id`, `unit_major_id`, `unit_name`, `pack_quantity`, `major_factor`) VALUES (NULL, '$add_minor_unit_major_id', '$unit_name', '$unit_pack_qantity', '$kg_factor')");
            if ($sql_query_001)
            {
                echo "success-";
            }
            else
            {
                echo "failed-";
            }
        }
        else
        {
            $sql_query_001 = mysqli_query($connection,"UPDATE unit_minor SET unit_major_id='$add_minor_unit_major_id',unit_name='$unit_name',pack_quantity='$unit_pack_qantity',major_factor='$kg_factor' WHERE id='$edit'");
            if ($sql_query_001)
            {
                echo "success - registered_minor_units.php";
            }
            else
            {
                echo "failed - registered_minor_units.php";
            }
        }

        exit();
        
    }
    if(isset($_POST["major_unit_name"]))
    {
        $major_unit_name = $_POST["major_unit_name"];
        $edit = $_POST["edit"];
        
        if($edit == "")
        {
            $sql_query_001 = mysqli_query($connection,"INSERT INTO `unit_major` (`id`, `unit_name`) VALUES (NULL, '$major_unit_name')");
            if ($sql_query_001)
            {
                echo "success-";
            }
            else
            {
                echo "failed-";
            }
        }
        else
        {
            $sql_query_001 = mysqli_query($connection,"UPDATE unit_major SET unit_name='$major_unit_name' WHERE id ='$edit'");
            if ($sql_query_001)
            {
                echo "success-registered_major_units.php";
            }
            else
            {
                echo "failed-registered_major_units.php";
            }
        }
        

        exit();
        
    }
    if(isset($_POST["expenses_category"]))
    {
        $expenses_category = $_POST["expenses_category"];
        
        
        $sql_query_001 = mysqli_query($connection,"INSERT INTO `expenses_categories` (`id`, `name`) VALUES (NULL, '$expenses_category')");
        
        if ($sql_query_001)
        {
            echo "success";
        }
        else
        {
            echo "failed";
        }

        exit();
        
    }

    if(isset($_POST["expense_category_id"]))
    {
        $expense_category_id = $_POST["expense_category_id"];
        $details = $_POST["details"];
        $amount = $_POST["amount"];
        $rate = $_POST["rate"];
        $expense_currency_id = $_POST["expense_currency_id"];
        $edit = $_POST["edit"];



        $input_date = $_POST["input_date"];
        $date =  $input_date ;
        

        if($edit == "")
        {
            $sql_query_001 = mysqli_query($connection,"INSERT INTO `expenses` (`id`, `ex_cate_id`, `details`, `amount`,`rate`, `currenycy_id`, `date`) VALUES (NULL, '$expense_category_id', '$details', '$amount','$rate', '$expense_currency_id', '$date')");

            if ($sql_query_001)
            {
                echo "success-";
            }
            else
            {
                echo "failed-";
            }
        }
        else
        {
            


        $input_date = $_POST["input_date"];
        $date =   $input_date;
        
            $sql_query_001 = mysqli_query($connection,"UPDATE expenses SET ex_cate_id='$expense_category_id',details='$details',amount='$amount',rate='$rate',currenycy_id='$expense_currency_id',date='$date' WHERE id='$edit'");

            if ($sql_query_001)
            {
                echo "success - registered_expenses.php";
            }
            else
            {
                echo "failed - registered_expenses.php";
            }
        }
        

        exit();
        
    }

    if(isset($_POST["rate_agency_admin_id"]))
    {
        $rate_agency_admin_id = $_POST["rate_agency_admin_id"];
        $good_id = $_POST["good_id"];
        $purchase_rate = $_POST["purchase_rate"];
        $sale_rate = $_POST["sale_rate"];
        $date = date("Y-m-d");
        
        $sql_query_001 = mysqli_query($connection,"INSERT INTO `rates_tb` (`id`, `agency_id`, `item_stock_minor_id`, `purchase_rate`, `sale_rate`,`date`) VALUES (NULL, '$rate_agency_admin_id', '$good_id', '$purchase_rate', '$sale_rate','$date')");
        
        if ($sql_query_001)
        {
            echo "success";
        }
        else
        {
            echo "failed";
        }

        exit();
        
    }


    if(isset($_POST["add_purchase_major_stock_id"]))
    {
        
        $currency = $_POST["currency"];
        $rate = $_POST["rate"];
        $total_price_final = $_POST["total_price_final"];
        $total_reciept = $_POST["total_reciept"];
        $supplier_major_id = $_POST["supplier_major_id"];

        $purchase_date =  $_POST["purchase_date"];
     
        // Validate required fields
        if(empty($supplier_major_id) || empty($purchase_date) || empty($currency))
        {
            echo "خطا: فیلدهای الزامی خالی است";
            exit();
        }
        
        $sql_query_001 = mysqli_query($connection,"INSERT INTO `purchase_major` (`id`, `supplier_id`, `reciept`, `currency_id`, `date`) VALUES (NULL, '$supplier_major_id', '$total_reciept', '$currency', '$purchase_date')");
       
        if($sql_query_001)
        {
            
            $sql_query_003 = mysqli_query($connection,"SELECT purchase_major.id FROM `purchase_major`  ORDER BY id DESC LIMIT 1");
            $fetch_003 = mysqli_fetch_assoc($sql_query_003);
           
            // map
            $add_purchase_major_stock_id_arr = $_POST["add_purchase_major_stock_id"];
            $amount_arr = $_POST["amount"];
            $purchase_price_arr = $_POST["purchase_price"];
            $extra_expense_arr = $_POST["extra_expense"];
            $details_arr = $_POST["details"];
            $purchase_major_id = $fetch_003["id"];
            
            // Get supplier full_name
            $sql_query_supplier = mysqli_query($connection,"SELECT full_name FROM suppliers WHERE id='$supplier_major_id' LIMIT 1");
            $supplier_full_name = "";
            if($sql_query_supplier && mysqli_num_rows($sql_query_supplier) > 0)
            {
                $fetch_supplier = mysqli_fetch_assoc($sql_query_supplier);
                $supplier_full_name = mysqli_real_escape_string($connection, $fetch_supplier["full_name"]);
            }
            
            // Insert receipt
            $sql_query_001_x = mysqli_query($connection,"INSERT INTO `reciepts` (`id`, `full_name`, `amount`, `currency_id`,`rate`, `purchase_id`, `sale_id`, `date`, `details`) VALUES (NULL, '$supplier_full_name', '$total_reciept', '$currency','$rate',  '$purchase_major_id',NULL, '$purchase_date', '')");
            
            if(!$sql_query_001_x)
            {
                echo "خطا در ذخیره رسید: " . mysqli_error($connection);
                exit();
            }

            $success_count = 0;
            $failed_count = 0;
            
            for ($i=0; $i < count($add_purchase_major_stock_id_arr); $i++)
            {
                
                $add_purchase_major_stock_id = mysqli_real_escape_string($connection, $add_purchase_major_stock_id_arr[$i]);
                $amount = mysqli_real_escape_string($connection, $amount_arr[$i]);
                $purchase_price = mysqli_real_escape_string($connection, $purchase_price_arr[$i]);
                $extra_expense = mysqli_real_escape_string($connection, $extra_expense_arr[$i]);
                $details = mysqli_real_escape_string($connection, $details_arr[$i]);

                $sql_query_002 = mysqli_query($connection,"INSERT INTO `purchase_minor` (`id`,`purchase_major_id`, `item_id_stock_major`, `amount`, `purchase_price`, `extra_expense`,`details`) VALUES (NULL, '$purchase_major_id','$add_purchase_major_stock_id', '$amount', '$purchase_price', '$extra_expense','$details')");
                
                if ($sql_query_002)
                {
                    $success_count++;
                }
                else
                {
                    $failed_count++;
                }
            }
            
            if($failed_count == 0)
            {
                echo "موفق: " . $success_count . " آیتم ذخیره شد";
            }
            else
            {
                echo "خطا: " . $failed_count . " آیتم ذخیره نشد. خطا: " . mysqli_error($connection);
            }

        }
        else
        {
            echo "خطا در ذخیره بل خرید: " . mysqli_error($connection);
        }
        

        exit();
        
    }

    if(isset($_POST["add_sale_purchase_id"]))
    {
        
        $currency = $_POST["currency"];
        $rate = $_POST["rate"];

        $sale_date =  $_POST["sale_date"];
        
        $total_reciept = $_POST["total_reciept"];
        $customer_id = $_POST["customer_id"];
     
        
            $sql_query_001 = mysqli_query($connection,"INSERT INTO `sale_major` (`id`, `customer_id`, `reciept`, `currency_id`, `date`) VALUES (NULL, '$customer_id', '$total_reciept', '$currency', '$sale_date')");


        if($sql_query_001)
        {

            $sql_query_003 = mysqli_query($connection,"SELECT sale_major.id FROM `sale_major`  ORDER BY id DESC LIMIT 1");
            $fetch_003 = mysqli_fetch_assoc($sql_query_003);

            // map
            $add_sale_purchase_id_arr = $_POST["add_sale_purchase_id"];
            $amount_arr = $_POST["amount"];
            $sale_price_arr = $_POST["sale_price"];
            $details_arr = $_POST["details"];
            $sale_major_id = $fetch_003["id"];

            // Get customer full_name
            $sql_query_customer = mysqli_query($connection,"SELECT full_name FROM customers WHERE id='$customer_id' LIMIT 1");
            $customer_full_name = "";
            if($sql_query_customer && mysqli_num_rows($sql_query_customer) > 0)
            {
                $fetch_customer = mysqli_fetch_assoc($sql_query_customer);
                $customer_full_name = mysqli_real_escape_string($connection, $fetch_customer["full_name"]);
            }

            $sql_query_001_x = mysqli_query($connection,"INSERT INTO `reciepts` (`id`, `full_name`, `amount`, `currency_id`,`rate`, `purchase_id`, `sale_id`, `date`, `details`) VALUES (NULL, '$customer_full_name', '$total_reciept', '$currency','$rate', NULL, '$sale_major_id', '$sale_date', '')");
    
            for ($i=0; $i < count($add_sale_purchase_id_arr); $i++)
            {
                
                $add_sale_purchase_id = $add_sale_purchase_id_arr[$i];
                $amount = $amount_arr[$i];
                $sale_price = $sale_price_arr[$i];
                $details = $details_arr[$i];
                
                $sql_query_002 = mysqli_query($connection,"INSERT INTO `sale_minor` (`id`, `amount`, `sale_rate`, `details`, `purchase_minor_id`,`sale_major_id`) VALUES (NULL, '$amount', '$sale_price', '$details', '$add_sale_purchase_id','$sale_major_id')
                ");
                
                

                    if ($sql_query_002)
                    {
                        echo "success";
                    }
                    else
                    {
                        echo "failed";
                    }



                // }
            
            }


        }
        

        exit();
        
    }

    if(isset($_POST["tr_fr_fac_supply_id"]))
    {
        
        $to_agency_admin_id = $_POST["to_agency_admin_id"];
        
        
        
        $transfer_date = date("Y-m-d");
        
        
        $sql_query_001 = mysqli_query($connection,"INSERT INTO `transfer_fr_factory_to_agencies_major` (`id`, `from_agency_id`, `to_agency_id`, `sender_status`, `receiver_status`, `user_id`, `date`, `details`) VALUES (NULL, '$agency_id_user', '$to_agency_admin_id', '', '', '$user_id', '$transfer_date', '')");
        
        if($sql_query_001)
        {

            $sql_query_003 = mysqli_query($connection,"SELECT transfer_fr_factory_to_agencies_major.id FROM `transfer_fr_factory_to_agencies_major`  ORDER BY id DESC LIMIT 1");
            $fetch_003 = mysqli_fetch_assoc($sql_query_003);

            // map
            $tr_fr_fac_supply_id_arr = $_POST["tr_fr_fac_supply_id"];
            $to_agency_admin_id = $_POST["to_agency_admin_id"];
            $minor_units_arr = $_POST["minor_units"];
            $details_arr = $_POST["details"];
            $quantity_arr = $_POST["quantity"];
            $transfer_major_id = $fetch_003["id"];
    
            for ($i=0; $i < count($tr_fr_fac_supply_id_arr); $i++)
            {
                
                $tr_fr_fac_supply_id = $tr_fr_fac_supply_id_arr[$i];
                $minor_units = $minor_units_arr[$i];
                $details = $details_arr[$i];
                $quantity = $quantity_arr[$i];


                $sql_query_002 = mysqli_query($connection,"INSERT INTO `transfer_fr_factory_to_agencies_minor` (`id`, `transfer_major_id`, `item_id_stock_minor`, `amount`, `unit_id`, `details`) VALUES (NULL, '$transfer_major_id', '$tr_fr_fac_supply_id', '$quantity', '$minor_units', '$details')");

                if ($sql_query_002)
                {
                    $sql_query_004 = mysqli_query($connection,"SELECT * FROM stock_major where item_id='$tr_fr_fac_supply_id' and agency_id='$to_agency_admin_id' and unit_id='$minor_units'");

                    $fetch_004 = mysqli_fetch_assoc($sql_query_004);
                    $major_stock_amount = $fetch_004["amount"];
                    
                    $remain_amount = $major_stock_amount + $quantity;

                    $sql_query_005 = mysqli_query($connection,"UPDATE stock_major SET amount='$remain_amount' where item_id='$tr_fr_fac_supply_id' and agency_id='$to_agency_admin_id' and unit_id='$minor_units'");

                    if ($sql_query_005)
                    {
                        echo "success";
                    }
                    else
                    {
                        echo "failed";
                    }



                }
            
            }


        }
        

        exit();
        
    }


    if(isset($_POST["tr_fr_ag_to_ag_supply_id"]))
    {
        
        $from_agency_admin_id = $_POST["from_agency_admin_id"];
        $to_agency_admin_id = $_POST["to_agency_admin_id"];
        
        
        
        $transfer_date = date("Y-m-d");
        
        
        $sql_query_001 = mysqli_query($connection,"INSERT INTO `transfer_fr_agency_to_agencies_major` (`id`, `from_agency_id`, `to_agency_id`, `sender_status`, `receiver_status`, `user_id`, `date`, `details`) VALUES (NULL, '$from_agency_admin_id', '$to_agency_admin_id', '', '', '$user_id', '$transfer_date', '')");
        
        if($sql_query_001)
        {

            $sql_query_003 = mysqli_query($connection,"SELECT transfer_fr_agency_to_agencies_major.id FROM `transfer_fr_agency_to_agencies_major`  ORDER BY id DESC LIMIT 1");
            $fetch_003 = mysqli_fetch_assoc($sql_query_003);

            // map
            $tr_fr_ag_to_ag_supply_id_arr = $_POST["tr_fr_ag_to_ag_supply_id"];
            $minor_units_arr = $_POST["minor_units"];
            $details_arr = $_POST["details"];
            $quantity_arr = $_POST["quantity"];
            $transfer_major_id = $fetch_003["id"];
    
            for ($i=0; $i < count($tr_fr_ag_to_ag_supply_id_arr); $i++)
            {
                
                $tr_fr_ag_to_ag_supply_id = $tr_fr_ag_to_ag_supply_id_arr[$i];
                $minor_units = $minor_units_arr[$i];
                $details = $details_arr[$i];
                $quantity = $quantity_arr[$i];


                $sql_query_002 = mysqli_query($connection,"INSERT INTO `transfer_fr_agency_to_agencies_minor` (`id`, `transfer_major_id`, `item_id_stock_major`, `amount`, `unit_id`, `details`) VALUES (NULL, '$transfer_major_id', '$tr_fr_ag_to_ag_supply_id', '$quantity', '$minor_units', '$details')");

                if ($sql_query_002)
                {
                    $sql_query_004 = mysqli_query($connection,"SELECT * FROM stock_major where item_id='$tr_fr_ag_to_ag_supply_id' and agency_id='$from_agency_admin_id' and unit_id='$minor_units'");

                    $fetch_004 = mysqli_fetch_assoc($sql_query_004);
                    $major_stock_amount = $fetch_004["amount"];
                    
                    $remain_amount = $major_stock_amount - $quantity;

                    $sql_query_005 = mysqli_query($connection,"UPDATE stock_major SET amount='$remain_amount' where item_id='$tr_fr_ag_to_ag_supply_id' and agency_id='$from_agency_admin_id' and unit_id='$minor_units'");

                    if ($sql_query_005)
                    {
                        echo "success";
                    }
                    else
                    {
                        echo "failed";
                    }



                }
            
            }


        }
        

        exit();
        
    }



    if(isset($_POST["load_major_unit_id"]))
    {
        $load_major_unit_id = $_POST["load_major_unit_id"];

        $sql_query_001 = mysqli_query($connection,"SELECT * FROM `unit_minor` where unit_major_id='$load_major_unit_id'");
        
        $array_tb = array();
        $counter = 0;
        while ($rows = mysqli_fetch_array($sql_query_001)) {
            
            array_push($array_tb,$rows);

            $counter++;
        }

        print_r(json_encode($array_tb));

        exit();
        
    }

    if(isset($_POST["company_name"]))
    {
        $company_name = mysqli_real_escape_string($connection, $_POST["company_name"]);
        $company_address = mysqli_real_escape_string($connection, $_POST["company_address"]);
        $company_phone = mysqli_real_escape_string($connection, $_POST["company_phone"]);
        $edit = mysqli_real_escape_string($connection, $_POST["edit"]);
        $date = date("Y-m-d");

        // Handle logo upload
        $logoUpload = "";
        if(isset($_FILES['company_logo']) && $_FILES['company_logo']['name'] != "")
        {
            $logoUpload = mysqli_real_escape_string($connection, $_FILES['company_logo']['name']);
            $logoSource = $_FILES['company_logo']['tmp_name'];
            $logoTarget = 'stuff_documents/images/'.$_FILES['company_logo']['name'];
            move_uploaded_file($logoSource, $logoTarget);
        }
        else
        {
            // If no new logo uploaded, get existing logo
            if($edit != "")
            {
                $sql_query_check = mysqli_query($connection,"SELECT company_logo FROM company_settings WHERE id='$edit'");
                if($sql_query_check && mysqli_num_rows($sql_query_check) > 0)
                {
                    $fetch_check = mysqli_fetch_assoc($sql_query_check);
                    $logoUpload = $fetch_check["company_logo"];
                }
            }
        }
        
        if($edit == "")
        {
            // Ensure logoUpload is not empty (use empty string if no logo)
            if($logoUpload == "")
            {
                $logoUpload = "";
            }
            
            $sql_query_001 = mysqli_query($connection,"INSERT INTO `company_settings` (`company_name`, `company_address`, `company_phone`, `company_logo`, `date`) VALUES ('$company_name', '$company_address', '$company_phone', '$logoUpload', '$date')");

            if ($sql_query_001)
            {
                echo "success";
            }
            else
            {
                $error = mysqli_error($connection);
                echo "failed: " . $error;
            }
        }
        else
        {
            if($logoUpload != "")
            {
                $sql_query_001 = mysqli_query($connection,"UPDATE company_settings SET company_name='$company_name',company_address='$company_address',company_phone='$company_phone',company_logo='$logoUpload' WHERE id='$edit'");
            }
            else
            {
                $sql_query_001 = mysqli_query($connection,"UPDATE company_settings SET company_name='$company_name',company_address='$company_address',company_phone='$company_phone' WHERE id='$edit'");
            }
            
            if ($sql_query_001)
            {
                echo "success";
            }
            else
            {
                echo "failed: " . mysqli_error($connection);
            }
        }

        exit();
        
    }

    if(isset($_POST["get_company_settings"]))
    {
        $sql_query_001 = mysqli_query($connection,"SELECT * FROM `company_settings` ORDER BY id DESC LIMIT 1");
        
        if(mysqli_num_rows($sql_query_001) > 0)
        {
            $fetch_001 = mysqli_fetch_assoc($sql_query_001);
            print_r(json_encode($fetch_001));
        }
        else
        {
            echo json_encode([]);
        }

        exit();
        
    }
    
    
?>