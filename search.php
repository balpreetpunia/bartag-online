<?php


if (isset($_GET['term'])){
    $return_arr = array();
    try {
        $dbh = new PDO( "mysql:host=localhost;dbname=bartag", "root", "" );
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        $stmt = $dbh->prepare('SELECT Model FROM data WHERE Model LIKE :term');
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