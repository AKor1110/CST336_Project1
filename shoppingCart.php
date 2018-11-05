<?php
    include "inc/functions.php";
    function displayItems(){ // Displays the users items in the shopping cart
            if (isset($_SESSION['cart'])) {
                echo "<table border = '1' align='center' width='100%'>";
                foreach ($_SESSION['cart'] as $item) {
                    $itemId = $item['id'];
                    $itemQuant = $item['quantity'];
                    
                    echo '<tr>';
                    
                    
                    echo "<td><img src='". $item['img'] ."'></td>";
                    echo "<td><h4>". $item['name'] ."</h4></td>";
                    echo "<td><h4>". $itemQuant ."</h4></td>";
                    echo "<td><h4>$". $item['price'] ."</h4></td>";
                    echo "</tr>";
            }
            echo "</table>";
        }
    }
    
    function clearItems(){ // Clears all the items currently in the shopping cart
        if (!empty($_GET['remove'])) {
            $_SESSION['cart'] = array();
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Shopping Cart</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php clearItems(); ?>
        <?= includeNavBar() ?>
        </br></br></br>
        <h1>Shopping Cart</h1>
        <div>
            <form method="get">
              <button type="submit" value="Submit" name="remove">Remove all</button>
            </form>
            <?php 
            displayItems();
            ?>
        </div>
    </body>
</html>