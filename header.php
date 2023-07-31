<?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>

<header class="header">

   <div class="flex">
      <span class="logo" >
         <img src="vuu.png" width="7%" height="7%"/> &emsp;
         <h3>VIGNAN'S GROUP</h3> 
         
         
</span>

<nav class="navbar">
   <a href="home.php" data-page="home">home</a>
   <a href="shop.php" data-page="shop">shop</a>
   <a href="orders.php" data-page="orders">orders</a>
   <!-- <a href="about.php" data-page="about">about</a> -->
   <a href="contact.php" data-page="contact">contact</a>
</nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="search_page.php" class="fas fa-search" data-page="search"></a>
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
         ?>
         <!-- <a href="wishlist.php" class="fas fa-heart" data-page="wishlist"><span>(<?= $count_wishlist_items->rowCount(); ?>)</span></a> -->
         <a href="cart.php" class="fas fa-shopping-cart" data-page="cart"><span>(<?= $count_cart_items->rowCount(); ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
         <p><?= $fetch_profile['name']; ?></p>
         <a href="user_profile_update.php" class="btn">update profile</a>
         <a href="logout.php" class="delete-btn">logout</a>
         <!-- <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div> -->
      </div>

   </div>

</header>
<!-- Your existing HTML content -->
<boby>
<script>
   document.addEventListener("DOMContentLoaded", function () {
      const navbarLinks = document.querySelectorAll(".navbar a");
      const iconsLinks = document.querySelectorAll(".icons a"); // Select the anchor tags inside the icons div

      // Function to add "active" class to the clicked page's link
      function setActiveLink() {
         const currentPath = window.location.pathname;
         navbarLinks.forEach((link) => {
            const linkPath = link.getAttribute("href");
            if (currentPath.includes(linkPath)) {
               link.classList.add("active");
            } else {
               link.classList.remove("active");
            }
         });

         // Check iconsLinks and add "active" class to the clicked link
         iconsLinks.forEach((link) => {
            const linkPath = link.getAttribute("href");
            if (currentPath.includes(linkPath)) {
               link.classList.add("active");
            } else {
               link.classList.remove("active");
            }
         });
      }

      // Set initial "active" class when the page loads
      setActiveLink();

      // Add event listeners to each link for handling clicks
      navbarLinks.forEach((link) => {
         link.addEventListener("click", () => {
            // Remove "active" class from all links
            navbarLinks.forEach((link) => link.classList.remove("active"));
            // Add "active" class to the clicked link
            link.classList.add("active");
         });
      });
   });
</script>
</body>

