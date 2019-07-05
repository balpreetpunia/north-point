<?php

    $model = isset($_GET['model']) ? $_GET['model'] : '';
    $count = isset($_GET['qty']) ? $_GET['qty'] : 0;

    if($model != ''){

        require 'shared/connect.php';

        $sql = "select model from inventory where model = '$model'";
        $sth = $dbh->prepare($sql);
        $sth->execute();

        if ($count > 0){
            $sql = "INSERT INTO inventory(model,counted) VALUES ('$model',$count)";
            $dbh->exec($sql);
        }
        else{
            $sql = "INSERT INTO inventory(model,counted) VALUES ('$model',1)";
            $dbh->exec($sql);
        }

        $dbh = null;

    }

    header('Location: /');


?>