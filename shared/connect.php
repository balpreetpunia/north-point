<?php
    try{


        $dbh = new PDO("mysql:host=den1.mysql2.gear.host;dbname=northpoint","northpoint","Vr95K6yg_5?5");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e){
    echo 'Database Connection failed: ' . $e->getMessage();
    }
