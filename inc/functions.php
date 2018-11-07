<?php

session_start();

function displayResults() {
    global $dbConn;

    
    $namedParameters= array();
    $product = $_GET['productName'];
    $sql= "SELECT * FROM os_product WHERE 1";
    
    if (isset($_GET) && !empty($_GET)) {
        if (isset($product)){
            if (!empty($product)) {
                $sql .=  " AND productDescription LIKE :product";
                $namedParameters[':product'] = "%$product%";   
            } else {
                echo "<h2> Product name cannot be empty! </h2>";
                return; 
            }
        }
    
        if (!empty($_GET['brand'])){
            $sql .=  " AND brandId =  :brand";
            $namedParameters[':brand'] = $_GET['brand'];
        }
        
        if (!empty($_GET['color'])){
            $sql .=  " AND colorId =  :color";
            $namedParameters[':color'] = $_GET['color'];
        }
        
        if (!empty($_GET['gender'])){
            $sql .=  " AND genderId =  :gender";
            $namedParameters[':gender'] = $_GET['gender'];
        }
        
        $sql .= " ORDER BY productName " . $_GET["order"];
        
        $stmt = $dbConn->prepare($sql);
        $stmt->execute($namedParameters);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        
        if (empty($records)) {
            echo "<h2> No product results! </h2>";
            return;
        }
        
        $i = 0;
        
        echo "<table border = '1' align='center' width='100%'>";
        
        while ($i < 10 && $i < count($records)) {
            $record = $records[$i];
            
            echo "<tr>";
            echo "<td><img src = '". $record["productImage"] . "'></td>";
            echo "<td><h4>". $record["productName"] . "<br />";
            showAdditionalInfo($record["productDescription"], $record["productImage"], $record["productName"], $record["price"], $i);
            echo "</h4></td>";
            echo "<td><h4>$" . $record["price"]. "</h4></td>";
        
            echo "<form method='post'>";
            echo "<input type='hidden' name='productName' value='".$record["productName"]. "'>";
            echo "<input type='hidden' name='productId' value='".$record["productId"]. "'>";
            echo "<input type='hidden' name='productImage' value='".$record["productImage"]. "'>";
            echo "<input type='hidden' name='productPrice' value='".$record["price"]. "'>";
            
            echo "<td><button class = 'btn btn-warning'> Add </button></td>";
            
            echo "</form>";
            
            echo "</tr>";
            
            $i++;
        }
        
        echo "</table>";
        }
        
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
                        <li><a href='shoppingCart.php'>
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

function showAdditionalInfo ($desc, $img, $name, $price, $num) {
        echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter$num'>";
      echo "Additional Product Info";
    echo "</button>";
    
    echo "<div class='modal fade' id='exampleModalCenter$num' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>";
      echo "<div class='modal-dialog modal-dialog-centered' role='document'>";
        echo "<div class='modal-content'>";
          echo "<div class='modal-header'>";
            echo "<h5 class='modal-title' id='exampleModalCenterTitle'>Full Product Info</h5>";
            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
              echo "<span aria-hidden='true'>&times;</span>";
            echo "</button>";
          echo "</div>";
          echo "<div class='modal-body'>";
            echo "<img src = '$img'>";
            echo "<br />";
            echo $name;
            echo "<br />";
            echo $desc;
            echo "<br />";
            echo "$$price";
          echo "</div>";
          echo "<div class='modal-footer'>";
            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
          echo "</div>";
        echo "</div>";
      echo "</div>";
    echo "</div>";
}
?>