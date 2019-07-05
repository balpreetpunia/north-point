<?php

require 'shared/connect.php';

$sql = "select model, counted, qty_in_hand, last_updated , list_cost from inventory where counted > 0 order by last_updated desc";
$sth = $dbh->prepare($sql);
$sth->execute();
$available = $sth->fetchAll();
$count = $sth->rowCount();


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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script></head>
<body>
<div class="container">
    <div class="jumbotron pb-4">
        <h1><a href="/" >Count Inventory</a></h1>
        <p>View Counted Inventory</p>
        <p><a href="/">&lt;&lt;Back</a></p>
    </div>
    <hr class="pb-3">
    <div class="input-group mb-3" id="stickForm">
        <input type="text" id="myInput" onkeyup="myFunction()" class="form-control" placeholder="Search By Model..." title="Type in a model">
        <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <button type="button" class="btn btn-outline-dark" onclick="showRed()">▼</button>
            <button type="button" class="btn btn-outline-dark" onclick="showYellow()">▲</button>
        </div>
        <div class="input-group-append">

        </div>
    </div>
    <div class="table-responsive">
        <table id="myTable" class="table table-bordered table-stripped table-hover">
            <thead>
            <tr>
                <td>Model</td>
                <td>Counted</td>
                <td>In Hand</td>
                <td>Cost</td>
                <td>Amount</td>
                <td>Time Counted</td>
            </tr>
            </thead>
            <tbody>
            <?php $total = 0;?>
            <?php foreach ($available as $avail ): ?>
            <?php $a_counted = $avail['counted'];$a_hand = $avail['qty_in_hand'];?>
                <tr<?php
                if($a_counted == $a_hand){
                    echo " class =  table-normal";
                }
                else if($a_counted > $a_hand){
                    echo " class = table-info";
                }
                else
                    echo " class = table-danger";
                ?>>
                    <td><?= $avail['model']?></td>
                    <td><?= $a_counted?></td>
                    <td><?= $a_hand?></td>
                    <td><?= $avail['list_cost']?></td>
                    <td><?php $total += ($a_counted*$avail['list_cost']); echo $a_counted*$avail['list_cost'];?></td>
                    <td><?php $date = date_create($avail['last_updated']); echo date_format($date, 'g:i:s A');?></td>
                </tr>
            <?php endforeach ?>
            <tr><td>Total : <?=$total?></td></tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    function myFunction() {
        var input, filter, table, tr, td, i, index;

        index = 0;
        input = document.getElementById("myInput");

        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");


        for (i = 1; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[index];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    var red = 0;
    var yellow = 0;
    function showRed() {
        this.reset();
        var table = document.getElementById("myTable");
        var tn = table.getElementsByClassName("table-normal");
        var ty = table.getElementsByClassName("table-info");
        if(red == 0) {
            for (var i = 0;i < tn . length;i++){
                tn[i] . style . display = "none";
            }
            for (var i = 0;i<ty.length;i++){
                ty[i].style.display = "none";
            }
            red = 1;
            yellow = 0;
        }
        else{
            for (var i = 0;i < tn . length;i++){
                tn[i] . style . display = "";
            }
            for (var i = 0;i<ty.length;i++){
                ty[i].style.display = "";
            }
            red = 0;
            yellow = 0;
        }
    }
    function showYellow() {
        this.reset();
        var table = document.getElementById("myTable");
        var tn = table.getElementsByClassName("table-normal");
        var td = table.getElementsByClassName("table-danger");
        if(yellow == 0) {
            for (var i = 0;i < tn . length;i++){
                tn[i] . style . display = "none";
            }
            for (var i = 0;i<td.length;i++){
                td[i].style.display = "none";
            }
            red = 0;
            yellow = 1;
        }
        else{
            for (var i = 0;i < tn . length;i++){
                tn[i] . style . display = "";
            }
            for (var i = 0;i<td.length;i++){
                td[i].style.display = "";
            }
            red = 0;
            yellow = 0;
        }
    }
    function reset() {
        var table = document.getElementById("myTable");
        var tr = table.getElementsByTagName("tr");

        for (var i = 1;i<tr.length;i++){
            {
                tr[i].style.display = "";
            }
        }
    }
</script>
</body>
</html>