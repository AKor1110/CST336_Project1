<?php
session_start();
include 'Connection.php';
include "inc/functions.php";
$dbConn = getDatabaseConnection("ottershoes");
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
if (isset($_POST['productName'])) {
    
    $newItem = array();
    $newItem['id'] = $_POST['productId'];
    $newItem['img'] = $_POST['productImage'];
    $newItem['name'] = $_POST['productName'];
    $newItem['price'] = $_POST['productPrice'];
    
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($newItem['id'] == $item['id']) {
            $item['quantity'] += 1;
            $found = true;
        }
    }
    if ($found != true) {
        $newItem['quantity'] = 1;
        array_push($_SESSION['cart'], $newItem);
    }
}
function displayBrand() { 
    global $dbConn;
    
    $sql = "SELECT * FROM os_brand ORDER BY brandName";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($records as $record) {
        echo "<option value='".$record['brandId']."'>" . $record['brandName'] . "</option>";
    }
}
function displayColor() { 
    global $dbConn;
    
    $sql = "SELECT * FROM os_color ORDER BY shoeColor";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($records as $record) {
        echo "<option value='".$record['colorId']."'>" . $record['shoeColor'] . "</option>";
    }
}
function displayGender() { 
    global $dbConn;
    
    $sql = "SELECT * FROM os_gender ORDER BY gender";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($records as $record) {
        echo "<option value='".$record['genderId']."'>" . $record['gender'] . "</option>";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title> OtterShoes </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <header>
        <br /> <br /> <br />
            <img src= "img/mb.png">
    </header>
    <body>
        <h1>OTTERSHOES</h1>
        <?= includeNavBar() ?>
        
        <form method = "GET">
            
            Product: <input type="text" name="productName" placeholder="Product keyword" /> <br />
            <br />
            
            Shoe Brand: 
            <select name="brand">
               <option value=""> Select one </option>  
               <?=displayBrand()?>
            </select>
            <br />
            <br />
            
            Shoe Color: 
            <select name="color">
               <option value=""> Select one </option>  
               <?=displayColor()?>
            </select>
            <br />
            <br />
            
            Gender: 
            <select name="gender">
               <option value=""> Select one </option>  
               <?=displayGender()?>
            </select>
            
            <br />
            <br />
            
            Select Order:
            <input type = "radio" name = "order" value = "ASC"> A-Z </input>
            <input type = "radio" name = "order" value = "DESC"> Z-A </input>
            
            <br />
            <br />

            <input type="submit" name="searchForm" value="Search"/>
        </form>
        <br>
        <hr>
        
        <?= displayResults() ?>
        

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    </body>
</html>