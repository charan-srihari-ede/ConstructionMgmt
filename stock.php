<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="user-accounts">

   <h1 class="title">user accounts</h1>

   <div class="box-container">

      <?php
         $select_users = $conn->prepare("SELECT * FROM `stock`");
         $select_users->execute();
         while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box" style="<?php if($fetch_users['id'] == $admin_id){ echo 'display:none'; }; ?>">
         <!-- <img src="uploaded_img/<?= $fetch_users['image']; ?>" alt=""> -->
         <p> user id : <span><?= $fetch_users['id']; ?></span></p>
         <p> cement : <span><?= $fetch_users['cement']; ?></span></p>
         <p>rods : <span><?= $fetch_users['rods']; ?></span></p>
         <!-- <p> user type : <span style=" color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'orange'; }; ?>"><?= $fetch_users['user_type']; ?></span></p>
         <a href="admin_users.php?delete=<?= $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete</a> -->
      </div>
      <?php
      }
      ?>
   </div>

</section>

<script src="script.js"></script>

</body>
</html>