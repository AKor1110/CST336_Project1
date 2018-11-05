<?php

function displayResults() {
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
        $namedParameters[':brand'] = "%". $_GET['brand']. "%" ;
    }
    
    if (!empty($_GET['color'])){
        $sql .=  " AND colorId =  :color";
        $namedParameters[':color'] = "%".$_GET['color'] . "%" ;
    }
    
    if (!empty($_GET['gender'])){
        $sql .=  " AND genderId =  :gender";
        $namedParameters[':gender'] = "%". $_GET['gender'] . "%" ;
    }
    
    $sql .= " ORDER BY productName " . $_GET["order"];
    
    $stmt = $dbConn->prepare($sql);
    $stmt->execute($namedParameters);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);        
    
    /*
    foreach ($records as $record) {
        
        echo $record['productName'];
        echo "</a> ";
        echo $record['productDescription'] . " $" .  $record['price'] .   "<br>";   
        
    }
    */
}

?>