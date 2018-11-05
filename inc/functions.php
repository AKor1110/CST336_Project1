<?php

session_start();

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
    
    echo json_encode($records, JSON_NUMERIC_CHECK);
    $i = 0;
    
    echo "<table border = '1'>";
    
    while ($i < 10 && $i < count($records)) {
        $record = $records[$i];
        
        echo "<tr>";
        echo "<td><img src = '". $record["productImage"] . "'></td>";
        echo "<td><h4>". $record["productName"] . "</h4></td>";
        echo "<td><h4>$" . $record["price"]. "</h4></td>";
    
        echo "<form method = 'post'>";
        echo "<input type = 'hidden' name = 'itemName' value = '" . $record["productId"] . "'>";
        
        echo "<td><button class = 'btn btn-warning'> Add </button></td>";
        
        echo "</form>";
        
        echo "</tr>";
        
        $i++;
    }
    
    echo "</table>";
}

function includeNavBar() {
    $count = getCartCount();
    echo "<nav class='navbar navbar-default - navbar-fixed-top'>
                <div class='container-fluid'>
                    <div class='navbar-header'>
                        <a class='navbar-brand' href='#'>OtterShoes</a>
                    </div>
                    <ul class='nav navbar-nav'>
                        <li><a href='index.php'>Home</a></li>
                        <li><a href='core/shoppingCart.php'>
                        <span class = 'glyphicon glyphicon-shopping-cart' aria-hidden = 'true'></span>
                        Cart: $count </a></li>
                    </ul>
                </div>
            </nav>";
}

function getCartCount() {
    if (!isset($_SESSION["cart"])) {
        return 0;
    }
    
    $res = 0;
    
    foreach ($_SESSION["cart"] as $item) {
        $res += $item["quantity"];   
    }
    
    return $res;
}

?>