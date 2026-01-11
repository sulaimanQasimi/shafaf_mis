<?php
    include("database.php");
    include("session.php");
    
    // Set headers for file download
    $filename = 'shafaf_mis_backup_' . date('Y-m-d_H-i-s') . '.sql';
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    
    // Start output buffering
    ob_start();
    
    // SQL Dump Header
    echo "-- phpMyAdmin SQL Dump\n";
    echo "-- Shafaf MIS Database Backup\n";
    echo "-- Generated: " . date("Y-m-d H:i:s") . "\n";
    echo "-- Database: shafaf_mis\n";
    echo "-- \n\n";
    
    echo "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
    echo "SET AUTOCOMMIT = 0;\n";
    echo "START TRANSACTION;\n";
    echo "SET time_zone = \"+00:00\";\n\n";
    
    echo "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\n";
    echo "/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\n";
    echo "/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\n";
    echo "/*!40101 SET NAMES utf8mb4 */;\n\n";
    
    echo "--\n";
    echo "-- Database: `shafaf_mis`\n";
    echo "--\n\n";
    
    // Get all tables
    $tables_query = mysqli_query($connection, "SHOW TABLES");
    $tables = array();
    while ($table = mysqli_fetch_array($tables_query)) {
        $tables[] = $table[0];
    }
    
    // Dump each table
    foreach ($tables as $table) {
        echo "-- --------------------------------------------------------\n\n";
        echo "--\n";
        echo "-- Table structure for table `$table`\n";
        echo "--\n\n";
        
        // Get CREATE TABLE statement
        $create_query = mysqli_query($connection, "SHOW CREATE TABLE `$table`");
        $create_result = mysqli_fetch_array($create_query);
        echo "DROP TABLE IF EXISTS `$table`;\n";
        echo $create_result[1] . ";\n\n";
        
        // Get table data
        $data_query = mysqli_query($connection, "SELECT * FROM `$table`");
        $num_rows = mysqli_num_rows($data_query);
        
        if ($num_rows > 0) {
            echo "--\n";
            echo "-- Dumping data for table `$table`\n";
            echo "--\n\n";
            
            // Get column names
            $columns_query = mysqli_query($connection, "SHOW COLUMNS FROM `$table`");
            $columns = array();
            while ($column = mysqli_fetch_array($columns_query)) {
                $columns[] = $column['Field'];
            }
            
            // Insert data
            $row_count = 0;
            while ($row = mysqli_fetch_assoc($data_query)) {
                $values = array();
                foreach ($columns as $column) {
                    if (isset($row[$column])) {
                        if (is_null($row[$column])) {
                            $values[] = "NULL";
                        } else {
                            $value = mysqli_real_escape_string($connection, $row[$column]);
                            $values[] = "'$value'";
                        }
                    } else {
                        $values[] = "NULL";
                    }
                }
                
                if ($row_count == 0) {
                    echo "INSERT INTO `$table` (`" . implode("`, `", $columns) . "`) VALUES\n";
                } else {
                    echo ",\n";
                }
                
                echo "(" . implode(", ", $values) . ")";
                $row_count++;
            }
            
            if ($row_count > 0) {
                echo ";\n\n";
            }
        }
    }
    
    // Add indexes
    echo "--\n";
    echo "-- Indexes for dumped tables\n";
    echo "--\n\n";
    
    foreach ($tables as $table) {
        $indexes_query = mysqli_query($connection, "SHOW INDEXES FROM `$table`");
        $primary_key_added = false;
        
        while ($index = mysqli_fetch_assoc($indexes_query)) {
            if ($index['Key_name'] == 'PRIMARY' && !$primary_key_added) {
                echo "--\n";
                echo "-- Indexes for table `$table`\n";
                echo "--\n";
                echo "ALTER TABLE `$table`\n";
                echo "  ADD PRIMARY KEY (`" . $index['Column_name'] . "`);\n";
                $primary_key_added = true;
            }
        }
    }
    
    echo "\nCOMMIT;\n\n";
    echo "/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\n";
    echo "/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\n";
    echo "/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;\n";
    
    // Flush output
    ob_end_flush();
    exit();
?>
