<?php


if (isset($_GET['term'])){
    $return_arr = array();
    try {
        $dbh = new PDO("mysql:host=den1.mysql5.gear.host;dbname=teletimeinven","teletimeinven","Fr47flr_?293");
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        $stmt = $dbh->prepare('SELECT Model FROM inventory_ra WHERE Model LIKE :term');
        $stmt->execute(array('term' => $_GET['term'].'%'));

        while($row = $stmt->fetch()) {
            $return_arr[] =  $row['Model'];
        }
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
}
?>