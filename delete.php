<?php
    

    // delete major_unit_id
    if(isset($_GET["major_unit_id"]))
    {
        $major_unit_id = $_GET["major_unit_id"];
        delete_func($major_unit_id,"unit_major");
    }
    // delete minor_unit_id
    if(isset($_GET["minor_unit_id"]))
    {
        $minor_unit_id = $_GET["minor_unit_id"];
        delete_func($minor_unit_id,"unit_minor");
    }
  
    // delete customer_id
    if(isset($_GET["customer_id"]))
    {
        $customer_id = $_GET["customer_id"];
        delete_func($customer_id,"customers");
    }

    // delete expense_id
    if(isset($_GET["expense_id"]))
    {
        $expense_id = $_GET["expense_id"];
        delete_func($expense_id,"expenses");
    }
    // delete good_id
    if(isset($_GET["good_id"]))
    {
        $good_id = $_GET["good_id"];
        delete_func($good_id,"stock_minor");
    }
    // delete supplier_id
    if(isset($_GET["supplier_id"]))
    {
        $supplier_id = $_GET["supplier_id"];
        delete_func($supplier_id,"suppliers");
    }
 
    // delete employee_id
    if(isset($_GET["employee_id"]))
    {
        $employee_id = $_GET["employee_id"];
        delete_func($employee_id,"staff");
    }
 
    // delete user_id
    if(isset($_GET["user_id"]))
    {
        $user_id = $_GET["user_id"];
        delete_func($user_id,"user_account");
    }
    // delete purchased_items
    if(isset($_GET["purchase_id"]))
    {
        $purchase_id = $_GET["purchase_id"];
        delete_func($purchase_id,"purchase_major");
    }
    // delete purchased_item_id
    if(isset($_GET["purchased_item_id"]))
    {
        $purchased_item_id = $_GET["purchased_item_id"];
        delete_func($purchased_item_id,"purchase_minor");
    }
    // delete sale_id
    if(isset($_GET["sale_id"]))
    {
        $sale_id = $_GET["sale_id"];
        delete_func($sale_id,"sale_major");
    }
    // delete reciept_id
    if(isset($_GET["reciept_id"]))
    {
        $reciept_id = $_GET["reciept_id"];
        delete_func($reciept_id,"reciepts");
    }
 
    // delete sales_reciept_id
    if(isset($_GET["sales_reciept_id"]))
    {
        $sales_reciept_id = $_GET["sales_reciept_id"];
        delete_func($sales_reciept_id,"reciepts");
    }
 


    function delete_func($id,$table)
    {
        include_once("database.php");
        $sql_query_01 = mysqli_query($connection,"delete from $table where id='$id'");
        if($sql_query_01)
        {
            echo $id;
        }
        else {
            echo $id;
        }

    }
?>