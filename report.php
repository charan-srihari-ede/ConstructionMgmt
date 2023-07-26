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
    <div id="content">
    <section  class="placed-orders">


   
    <?php
$start_date = $_POST['date1'];
$end_date = $_POST['date2'];
    $sql = "SELECT * FROM `orders` WHERE payment_status='completed'AND placed_on BETWEEN :start_date AND :end_date ";
    $stmt = $conn->prepare($sql);

    // Bind the parameters to the statement
    $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
    $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);

    // Execute the query
    $stmt->execute();

    if ($stmt -> rowCount()>0){
        
        echo "<h1 class='title'>RANGE BETWEEN " .$start_date . " and " . $end_date."</h1>"."<br><div class='box-container'>" ;
        $total=0;
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        ?>
         <div class="box">
            
            
         <p> user id : <span><?= $result['user_id']; ?></span> </p>
         <p> placed on : <span><?= $result['placed_on']; ?></span> </p>
         <p> name : <span><?= $result['name']; ?></span> </p>
         <p> email : <span><?= $result['email']; ?></span> </p>
         <p> number : <span><?= $result['number']; ?></span> </p>
         <!-- <p> address : <span><?= $result['address']; ?></span> </p> -->
         <p> total products : <span><?= $result['total_products']; ?></span> </p>
         <p> total price : <span>Rs<?= $result['total_price']; ?>/-</span> </p>
         <?php $total=$total+$result['total_price']; ?>
         <!-- <p> payment method : <span><?= $result['method']; ?></span> </p> -->
      </div>
      <?php
         }
      }
      else{
          echo '<p class="empty">no orders placed yet!</p>';
        }
        echo "</div><h1 class='title'>over all price:".$total."</h1>";

      ?>

         

</section>
</div>
<form>
    <div align="center">
        <input type="button" class="delete-btn" value="Print" onclick="printContent()" />
        </div>
    </form>

    <script>
        function printContent() {
            var content = document.getElementById('content');
            var pri = window.open('', '_blank', 'height=500,width=500');
pri.document.write('<html><head><title>Print</title><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"><link rel="stylesheet" href="css/admin_style.css"></head><body>');
            pri.document.write(content.innerHTML);
            pri.document.write('</body></html>');
            pri.document.close();
            pri.print();
        }
    </script>
    <script src="script.js"></script>
</body>
</html>