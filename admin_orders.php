<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_POST['update_order'])) {
   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
   $update_orders = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_orders->execute([$update_payment, $order_id]);
   $message[] = 'Payment has been updated!';

   if ($update_payment == 'completed') {
      $s = $_POST['total_products'];
      $user_id = $_POST['user_id'];
      $s1 = "";
      $i1 = 0;
      $f = 0;
      $f1 = 0;

//, bricks ( 1 ), cement ( 3 )

      for ($i = 2; $i < strlen($s); $i++) {
         if ($s[$i - 2] == ',' && $s[$i - 1] == ' ') {
            for ($j = $i; $j < strlen($s); $j++) {
               if ($s[$j] == ' ') {
                  $f = 1;
                  break;
               } else {
                  $s1 .= $s[$j];
               }
            }
         } elseif ($s[$i - 2] == '(' && $s[$i - 1] == ' ') {
            $f1 = 1;
            $i1 = intval($s[$i]);
         }

         if ($f && $f1) {
            $column_name = trim($s1); // Trim any leading/trailing spaces from $s1
            $cart_query = $conn->prepare("UPDATE `stock` SET $column_name = ? WHERE user_id = ?");

            //eswar
            $s_p = 0;
            $sql = "SELECT $column_name FROM `stock` WHERE user_id = ?";
            $stock_present = $conn->prepare($sql);
            $stock_present->execute([$user_id]);

            if ($stock_present->rowCount() > 0) {
               $s_p = $stock_present->fetchColumn(); // Fetch the actual column value directly
            }else{
               echo "error : 404";
            }
            
            //eswar

            if ($cart_query->execute([$s_p + $i1, $user_id])) {
               //echo "Database has been updated successfully";
            } else {
               echo "Error updating database: ";
            }
            $f = 0;
            $f1 = 0;
            $s1="";
         }
      }
   }
};

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_orders->execute([$delete_id]);
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

   <?php include 'admin_header.php'; ?>

   <section class="placed-orders">

      <h1 class="title">placed orders</h1>

      <div class="box-container">

         <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders` where payment_status= ?");
         $select_orders->execute(["pending"]);
         if ($select_orders->rowCount() > 0) {
            while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
         ?>
               <div class="box">
                  <p> user id : <span><?= $fetch_orders['user_id']; ?></span> </p>
                  <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
                  <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
                  <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
                  <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
                  <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
                  <p> total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
                  <p> total price : <span>Rs<?= $fetch_orders['total_price']; ?>/-</span> </p>
                  <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>
                  <form action="" method="POST">
                     <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                     <input type="hidden" name="user_id" value="<?= $fetch_orders['user_id']; ?>">
                     <input type="hidden" name="total_products" value="<?= $fetch_orders['total_products']; ?>">
                     <select name="update_payment" class="drop-down">
                        <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
                        <option value="pending">pending</option>
                        <option value="completed">completed</option>
                     </select>
                     <div class="flex-btn">
                        <input type="submit" name="update_order" class="option-btn" value="update">
                        <a href="admin_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
                     </div>
                  </form>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">no orders placed yet!</p>';
         }
         ?>

      </div>

   </section>












   <script src="script.js"></script>

</body>

</html>