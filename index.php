<?php

$model = isset($_GET['model']) ? $_GET['model'] : '';
$model = strtoupper($model);
require_once( 'shared/connect.php' );

$sql = "select * from data where model = '$model'";
$sth = $dbh->prepare($sql);
$sth->execute();
$available = $sth->fetchAll();
$count = $sth->rowCount();

$dbh=null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barcode Tag Generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="JsBarcode.all.min.js"></script>
    <!--<script src="bar.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container" id="container1">
    <div class="jumbotron">
        <h1>Teletime Barcode Tag Generator</h1>
        <p>Enter Data to generate tag</p>
    </div>
    <div class="input-field">
        <form id="calculator" method="get" action="">
            <div class="form-group">
                <input id="model" name="model" class="auto form-control" placeholder="Model" type="text" />
                <!--<span class="input-group-btn">
                    <button class="btn btn-secondary" type="button">Scan</button>
                </span>-->
            </div>
            <div class="btn-group d-flex" role="group">
                <button class="btn btn-primary w-100" id="generate" onclick="code1();" type="submit"><i class="fas fa-tag"></i>&nbsp;Generate</button>
                <button class="btn btn-dark w-100"  type="button" onclick="window.print();" ><i class="fas fa-print"></i>&nbsp;Print</button>
                <button class="btn btn-success w-100"  type="button" id="edit" onclick="return code2();"><i class="fas fa-edit"></i>&nbsp;Edit</button>
                <button type="button" class="btn btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: solid; border-width: 0.5px;">
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="new" >New Model</a>
                    <a class="dropdown-item" href="multiple" >Multiple Tags</a>
                    <a class="dropdown-item" href="list" >List All Models</a>
                </div>
            </div>
        </form>
    </div>
</div>
<hr>
<div>
    <?php foreach ($available as $avail ): ?>
        <div class="container">
            <div class="col-print-12 col-lg-7 offset-lg-3 card p-6 pt-2 " >
                <div id="teletime" class="row">
                    <div id="title-div" class="col-8 p-0 pl-3 pt-3">
                        <p id="title"><strong><?= strtoupper($avail['TITLE'])?></strong></p>
                    </div>
                    <div class="col-4 p-0 pt-2">
                        <div id="brand" class="pr-3">
                            <?php include 'shared/brand.php'; $brand=$avail['BRAND']; getImage($brand); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-7 p-0 pl-3 pt-1">
                        <?php
                            $description = ucwords(strtolower($avail['DESCRIPTION']));
                            $description = str_replace("•","<br>• ",$description,$count);
                        ?>
                        <p id="description" class="mb-0"><?= $description?></p>
                        <div class="col-8 mt-2 pl-0">
                            <svg id="barcode" class="barcode img-fluid"></svg>
                        </div>
                    </div>
                    <div class="col-5 mt-2 p-0 pr-3">
                        <p id="price1" class="text-right mb-0 pr-1">Sale Price</p>
                        <p id="price2" class="text-right mt-0 mb-0 pr-1" ><?=floatval($avail['PRICE']) ?></p>
                    </div>
                </div>
                <div class="row p-0 mb-1">
                    <div class="col-6  pl-3">
                        <p id="model_display" ><?= $avail['MODEL'];?></p>
                    </div>
                    <div class="col-6 pr-3  ">
                        <p id="info2" class="text-right pr-1 m-0 mb-0">Ask About 0% Finance (O.A.C)</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
<br><br>
<script>
    <?php
    if($model != ''){
        echo 'JsBarcode("#barcode", "'.$model.'", {
            margin: 0,
            height: 25,
            displayValue: false
            });';

        foreach ($available as $avail ){

            echo 'document.getElementById("model").value = "'.$avail["MODEL"].'";';
        }
    }
    ?>
</script>
<!--To prevent barcode scanner from opening Downloads page -->
<script>
    /*document.addEventListener('keydown', function(event) {
        if( event.keyCode == 13 || event.keyCode == 17 || event.keyCode == 74 )
            event.preventDefault();
    });*/
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
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
    function code1() {

        if(document.getElementById("model").value.toString() === ''){
            window.alert("Enter Model Number");
        }

    }

    function code2() {

        if(document.getElementById("teletime") == null){
            window.confirm("Generate tag to edit");
            return false;
        }
        else{
            location.href = "edit?model=<?= $model ?>";
        }
    }
</script>
<script>
    $(document).ready(function(){
        $("br:first-child").remove();
    });
</script>
<script>console.log("Balpreet Punia \nhttps://balpreetpunia.github.io \n705-500-4784");</script>
</body>
</html>
