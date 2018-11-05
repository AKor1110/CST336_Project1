<?php
    include "inc/functions.php";
    function displayItems(){ // Displays the users items in the shopping cart
            if (isset($_SESSION['cart'])) {
                echo "<table class='table'>";
                foreach ($_SESSION['cart'] as $item) {
                    $itemId = $item['id'];
                    $itemQuant = $item['quantity'];
                    
                    //echo '<tr>';
                    
                    
                    echo "<tr><img src='". $item['img'] ."'></td>";
                    echo "<td><h4>". $item['name'] ."</h4></td>";
                    echo "<td><h4>$". $item['price'] ."</h4></td>";
                    
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='itemId' value='$itemId'>";
                    echo "<td><input type='text' name='update' class='form-control' placeHolder='$itemQuant'></td>";
                    echo '<td><button class="btn btn-danger">Update</button></td>';
                    echo '</form>';
                    
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='removeId' value='$itemId'>";
                    echo '<td><button class="btn btn-danger">Remove</button></td>';
                    echo '</form>';
                    
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
        <?= includeNavBar() ?>
        </br></br></br>
        <h1>Shopping Cart</h1>
        <div>
            <form method="get">
              <button type="submit" value="Submit" name="remove">Remove all</button>
            </form>
            <?php 
            displayItems();
            clearItems(); ?>
        </div>
    </body>
</html>