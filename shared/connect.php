<?php
    try{


        $dbh = new PDO("mysql:host=den1.mysql5.gear.host;dbname=teletimeinven","teletimeinven","Fr47flr_?293");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e){
    echo 'Database Connection failed: ' . $e->getMessage();
    }