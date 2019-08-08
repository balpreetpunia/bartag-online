<?php

    try{
        $dbh = new PDO( "mysql:host=den1.mysql6.gear.host;dbname=bartag", "bartag", "Sv4Pl-18ZU!R" );
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch (PDOException $e){
        echo 'Database connection failed: ' . $e->getMessage();
    }

?>
