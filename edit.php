<?php

    $model = isset($_GET['model']) ? $_GET['model'] : '';
    $model = strtoupper($model);

    /*if(isset($_GET['save'])){
        header("location :index?model=$model");
    }*/

    $modelUpdate = isset($_POST['modelUpdate']) ? $_POST['modelUpdate'] : '';
    $modelUpdate = strtoupper($modelUpdate);

    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $brand = isset($_POST['brand']) ? $_POST['brand'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    require_once( 'shared/connect.php' );

    $sql = "select * from data where model = '$model'";
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $available = $sth->fetchAll();
    $count = $sth->rowCount();

    if ($model != ''){
        foreach ($available as $avail ) {
            $id = $avail["id"];
        }
    }

    if ($modelUpdate != ''){
        $sqlUpdate = "update data set model = '$modelUpdate', title = '$title', brand = '$brand', description = '$description', price = $price where id = $id";
        $dbh->exec($sqlUpdate);

        $success = 1;
    }

    $dbh=null;



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barcode Received</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="JsBarcode.all.min.js"></script>
    <!--<script src="bar.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="style.css">-->
</head>
<body>
<div class="container" id="container1">
    <div class="jumbotron">
        <h1>Teletime Barcode Tags</h1>
        <p>Enter Data to generate tag</p>
    </div>
    <div class="input-field">
        <form id="calculator" method="post" action="edit.php">
            <div class="form-group">
                <input id="model" name="modelUpdate" class="form-control" placeholder="Model" type="text" />
            </div>
            <div class="form-group input-group">
                <select class="form-control" id="brand" name="brand">
                    <option value="">Select Brand</option>
                    <?php include 'shared/brand.php';  getBrand(); ?>
                </select>
            </div>
            <div class=" form-group input-group">
                <textarea id="title" name="title" class="form-control" placeholder="Title" type="text"></textarea>
            </div>
            <div class=" form-group input-group">
                <textarea id="description" name="description" class="form-control" placeholder="Description" type="text"></textarea>
            </div>
            <div class=" form-group input-group">
                <input id="price" name="price" class="form-control" placeholder="Price" type="number" step="any" />
            </div>
            <div class=" form-group input-group">
                <input name="id" value="<?= $id ?>" type="hidden" />
            </div>
            <div class="btn-group d-flex" role="group">
                <button class="btn btn-success w-100" id="clickMe" type="submit" value="save">Save</button>
                <button class="btn btn-primary w-100" id="clickMe3" type="button" onclick="location.href='index?model=<?= $model?>'" >Back</button>
            </div>
        </form>
    </div>
</div>
<hr>
<script>
    <?php
        if($model != ''){
            foreach ($available as $avail ){
                $title = $avail["TITLE"];
                $title = addslashes($title);
                $title = str_replace("\n", " ", $title);
                $title = str_replace("\r", " ", $title);

                $description = $avail["DESCRIPTION"];
                $description = addslashes($description);
                $description = str_replace("\n", " ", $description);
                $description = str_replace("\r", " ", $description);


                echo 'document.getElementById("model").value = "'.$avail["MODEL"].'";';
                echo "document.getElementById('title').value = '". $title."';";
                echo "document.getElementById('description').value = '". $description."';";
                echo 'document.getElementById("price").value = "'.$avail["PRICE"].'";';
                echo 'document.getElementById("brand").value = "'.strtoupper($avail['BRAND']).'";';
            }
        }

        if(isset($success) && $success ==1){
            echo 'alert("Update Successful. ");';
            //echo "window.location = 'index?model=$modelUpdate'";
            echo "window.location = '/bartag/edit?model=aaaaaaaaaa'";
        }
    ?>
</script>
<script>
    /*document.addEventListener('keydown', function(event) {
        if( event.keyCode == 13 || event.keyCode == 17 || event.keyCode == 74 )
            event.preventDefault();
    });*/
</script>

</body>
</html>