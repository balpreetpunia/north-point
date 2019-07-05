<?php

date_default_timezone_set("America/Toronto");

$model = isset($_POST['model']) ? $_POST['model'] : '';
$model = strtoupper($model);
$qty = !empty($_POST['qty']) ? $_POST['qty'] : 1;
$error = -1;
$time = date("Y-m-d H:i:s");
$postQty = 0;

require "shared/connect.php";

if ($model != ''){

    $sql = "select model, qty_in_hand, counted from inventory_ra where model = '$model'";
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $available = $sth->fetchAll();
    $count = $sth->rowCount();

    if($count > 0){
        if($qty == '') {
            $sql = "UPDATE inventory_ra SET counted = counted +1 WHERE model = '$model'";
            $dbh->exec($sql);
            $error = 0;
            $postQty = 1;
        }
        else{
            $sql = "UPDATE inventory_ra SET counted = counted +$qty WHERE model = '$model'";
            $dbh->exec($sql);
            $error = 0;
            $postQty = $qty;
        }
    }
    else{
        $error = 1;
    }
}

$dbh=null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Count</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
</head>
<body>
<div class="container" id="container1">
    <div class="jumbotron">
        <h1>Count Inventory</h1>
        <p>Select model to add to inventory. DO NOT REFRESH AFTER ADDING.</p>
        <button class="btn btn-outline-primary w-100" onclick="location='view.php'"><i class="fas fa-th-list"></i> VIEW ADDED MODELS</button>
    </div>
    <div class="input-field">
        <form id="calculator" method="post" action="">
            <div class="form-group">
                <input id="model" name="model" class="auto form-control" placeholder="Model" type="text" />
            </div>
            <div class="form-group">
                <input id="qty" name="qty" class="form-control" placeholder="Qty" type="number" />
            </div>
            <div class="btn-group d-flex" role="group">
                <button class="btn btn-primary w-100" id="generate" type="submit"><i class="fas fa-plus"></i> ADD</button>
            </div>
        </form>
    </div>
    <hr>
    <?php
    if ($error==0){
        echo"<h3 class='text-center'>$model Added</h3><br><h6 class='text-center'>In Hand: ".$available[0]['qty_in_hand']." Counted: ".($available[0]['counted']+($postQty))."</h6>";}
    elseif($error ==1){
        echo "<h3 class='text-center'>Model not found <a href='add_ra.php?model=$model&qty=$qty'>Add $model to Database Qty : $qty</a></h3>";
    }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(function() {

        //autocomplete
        $(".auto").autocomplete({
            source: "search.php",
            minLength: 1
        });

    });
</script>
<script>
    document.getElementById("model").focus();
</script>
<script>console.log("Balpreet Punia \nhttps://balpreetpunia.github.io \n705-500-4784");</script>
</body>
</html>
