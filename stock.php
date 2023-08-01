<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Stock</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>users</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" s>
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">
    <!-- <script>
        function fun(i) {
            let x = document.getElementById(i).value;
            const p = i + 'hi'
            let y = document.getElementById(p).value;
            alert(x + y);
        }
    </script> -->
 

</head>

<body>

<<<<<<< HEAD

   <h1 class="title">Stock</h1>
   <?php
    $table_name = "stock";

    // Retrieve column names from the table
    $sql_columns = "SHOW COLUMNS FROM $table_name";
    $stmt = $conn->prepare($sql_columns);
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    ?>

    <center>
        <table class="table" border="1" align="center">
            <tr>
                <th>Products</th>
                <th>Quantity Bought</th>
            </tr>
            <?php
            // Display column names (excluding the first column)
            for ($i = 1; $i < count($columns); $i++) {
                echo "<tr>";
                echo "<td>{$columns[$i]}</td>";

                $sql = $conn->prepare("SELECT {$columns[$i]} FROM stock WHERE user_id=?");
                $sql->execute([$user_id]);
                $quantity_bought = $sql->fetchColumn();
                echo "<td><h3>{$quantity_bought}</h3></td>";

                $sql = $conn->prepare("SELECT {$columns[$i]} FROM stock_used WHERE user_id=?");
                $sql->execute([$user_id]);
                $quantity_used = $sql->fetchColumn();
                echo "<td><h3>{$quantity_used}</h3></td>";

                echo "</tr>";
            }
            ?>
        </table>
    </center>
                <!-- <div class="box">
=======
    <?php include 'header.php'; ?>
    <div id="content">
        <section class="placed-orders">
            <h1 class="title">Stock</h1>
            <?php
            $table_name = "stock";
            // Retrieve column names from the table
            $sql_columns = "SHOW COLUMNS FROM $table_name";
            $stmt = $conn->prepare($sql_columns);
            $stmt->execute();
            $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
            ?>
            <form method='POST'>
                <center>
                    <table border="1">
                        <tr>
                            <th>
                                <h1>Products</h1>
                            </th>
                            <th>
                                <h1>Quantity Bought</h1>
                            </th>
                            <th>
                                <h1>Quantity Used</h1>
                            </th>
                            <th>
                                <h1>Update
                            </th>
                        </tr>
                        <?php
                        // Display column names (excluding the first column)
                        for ($i = 1; $i < count($columns); $i++) {
                            echo "<tr>";
                            $k = $i . 'hi';
                            echo "<td> <input type='text' id=$k name=$k value='{$columns[$i]}'/> </td>";
                            $sql = $conn->prepare("SELECT {$columns[$i]} FROM stock WHERE user_id=?");
                            $sql->execute([$user_id]);
                            $quantity_bought = $sql->fetchColumn();
                            echo "<td><h3>{$quantity_bought}</h3></td>";
                            $sql = $conn->prepare("SELECT {$columns[$i]} FROM stock_used WHERE user_id=?");
                            $sql->execute([$user_id]);
                            $quantity_used = $sql->fetchColumn();
                            echo "<td><h3>{$quantity_used}</h3></td>";
                            echo "<td><input type='number' id=$i name $i class='box'/>  <input onclick='fun($i)' type='button' value='update'/> </td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </center>
            </form>
    </div>
    </section>
    <!-- <div class="box">
>>>>>>> c06a679 (modify)
                  <p> Products : <span><?= $fetch_orders['user_id']; ?></span> </p>
                  <p> Quantity : <span><?= $fetch_orders['placed_on']; ?></span> </p>
                 </div> -->

    <script src="script.js"></script>

</body>

</html>