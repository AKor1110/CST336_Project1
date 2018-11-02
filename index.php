<?php

include '../inc/dbConnection.php';
$dbConn = ottershoe("ottershoes");

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
function display() {
    global $dbConn;

    
    $namedParameters= array();
    $product = $_GET['productName'];
    $sql= "SELECT * FROM os_product WHERE 1";

 if (!empty($product)){

         $sql .=  " AND productName LIKE :product OR productDescription LIKE :product";
         $namedParameters[':product'] = "%$product%";
    }  
  if (!empty($_GET['brand'])){

         $sql .=  " AND brandId =  :brand";
          $namedParameters[':brand'] = $_GET['brand'] ;
    }
  if (!empty($_GET['color'])){

         $sql .=  " AND colorId =  :color";
          $namedParameters[':color'] = $_GET['color'] ;
    }
  if (!empty($_GET['gender'])){

         $sql .=  " AND genderId =  :gender";
          $namedParameters[':gender'] = $_GET['gender'] ;
    }
    
    $stmt = $dbConn->prepare($sql);
    $stmt->execute($namedParameters);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);        
    
    foreach ($records as $record) {
        
        echo $record['productName'];
        echo "</a> ";
        echo $record['productDescription'] . " $" .  $record['price'] .   "<br>";   
        
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <title> </title>
    </head>
    <header>
            <img src= "img/mb.png">
        </header>
    <body>
        <h1>OTTERSHOES</h1>
        
        <form>
            
            Product: <input type="text" name="productName" placeholder="Product keyword" /> <br />

            Shoe Brand: 
            <select name="brand">
               <option value=""> Select one </option>  
               <?=displayBrand()?>
            </select>
            Shoe Color: 
            <select name="color">
               <option value=""> Select one </option>  
               <?=displayColor()?>
            </select>
            Gender: 
            <select name="gender">
               <option value=""> Select one </option>  
               <?=displayGender()?>
            </select>

            <input type="submit" name="searchForm" value="Search"/>
        </form>
        <br>
        <hr>
         <?=display()?>

    </body>
</html>
