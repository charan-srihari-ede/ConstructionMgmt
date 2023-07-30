<?php
// session_start();
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

      <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="admin_page.php" data-page="home">home</a>
         <a href="admin_products.php"data-page="products">products</a>
         <a href="admin_orders_placed.php" data-page="orders">orders</a>
         <a href="admin_users.php" data-page="users">users</a>
         <a href="admin_contacts.php" data-page="messages">messages</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="admin_search.php" class="fas fa-search" data-page="search"></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
         <p><?= $fetch_profile['name']; ?></p>
         <a href="admin_update_profile.php" class="btn">update profile</a>
         <a href="logout.php" class="delete-btn">logout</a>
         <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
      </div>

   </div>

</header>
<body>
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