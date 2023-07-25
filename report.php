<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>report</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
    <?php include 'admin_header.php';?>
    <?php
$start_date = $_POST['date1'];
$end_date = $_POST['date2'];
    $sql = "SELECT * FROM `orders` WHERE placed_on BETWEEN '$start_date' AND '$end_date'";
    $stmt = $conn->prepare($sql);

    // Bind the parameters to the statement
    $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
    $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);

    // Execute the query
    $stmt->execute();

    // Fetch all the rows into an associative array
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any rows were returned
    if (count($result) > 0) {
        // Loop through the result set and process each row
        foreach ($result as $row) {
            // Access the data in the row
            // Example: $row["column_name"]
            // Replace "column_name" with the actual column names from your table
            echo $row['user_id'].':'.$row['total_price'].'<br>';
        }
    } else {
        echo "No records found between $start_date and $end_date";
    }

?>
    <script src="script.js"></script>
</body>
</html>