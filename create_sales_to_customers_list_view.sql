-- Create view sales_to_customers_list
-- This view lists all customers with their total sales

DROP VIEW IF EXISTS `sales_to_customers_list`;

CREATE VIEW `sales_to_customers_list` AS 
SELECT 
    `customers`.`id` AS `id`, 
    `customers`.`full_name` AS `full_name`, 
    `customers`.`phone_number` AS `phone_number`, 
    `customers`.`address` AS `address`, 
    `customers`.`date` AS `date`, 
    COALESCE(SUM(`sale_minor`.`sale_rate` * `sale_minor`.`amount`), 0) AS `total_sale_price` 
FROM 
    `customers` 
    LEFT JOIN `sale_major` ON `customers`.`id` = `sale_major`.`customer_id` 
    LEFT JOIN `sale_minor` ON `sale_minor`.`sale_major_id` = `sale_major`.`id` 
GROUP BY 
    `customers`.`id`, 
    `customers`.`full_name`, 
    `customers`.`phone_number`, 
    `customers`.`address`, 
    `customers`.`date`;
