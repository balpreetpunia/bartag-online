<?php

require_once( 'shared/connect.php' );

$sql = "select * from data ORDER BY BRAND";
$sth = $dbh->prepare($sql);
$sth->execute();
$available = $sth->fetchAll();

$dbh=null;

$serial = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Barcode Tag Generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
    <style>
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(img/loading.gif) center no-repeat #fff;
        }
        .load{
            position: fixed;
            left:43%;
            top: 15%;
            font-weight: bold;
            font-size: xx-large;
            color: pink;
            text-shadow: -1px 0 deeppink, 0 1px deeppink, 1px 0 deeppink, 0 -1px deeppink;
        }
    </style>
    <script>
        $(window).load(function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");
            $("body").removeAttr("style");
        });
    </script>
    <style>
        .stickyForm {
            position: sticky;
            top: 0px;
            padding-top: 10px;
            padding-bottom: 10px;
            left: 5%;
            width: 100%;
            background-color: white;
            border: 0px solid silver;
            border-bottom-width: 1px;
        }
    </style>
</head>
<body style="overflow: hidden;">
<div class="se-pre-con"><span class="load">Loading...</span></div>
<div class="container">
    <div class="jumbotron">
        <h1>Teletime Barcode Tag Generator</h1>
        <p>Enter Data to generate tag</p>
    </div>
</div>
<hr>
<div class="container">
    <div class="input-group mb-3" id="stickForm">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input type="text" id="myInput" onkeyup="myFunction('model')" class="form-control" placeholder="Search By Model..." title="Type in a model">
        <input type="text" id="myInputB" onkeyup="myFunction('brand')" class="form-control" placeholder="Search By Brand..." title="Type in a brand">
        <div class="input-group-append">
            <button class="btn btn-success" type="button" onclick="location.href='index'"><i class="fas fa-arrow-circle-left"></i>&nbsp;Back</button>
        </div>
    </div>
    <div id="table-div" class="table-responsive-sm table-sm">
        <table id="myTable" class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Model</th>
                <th>Brand</th>
                <th>Title</th>
                <!--<th>Description</th>-->
                <th>Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($available as $row ): ?>
            <tr>
                <td><?php echo $serial; $serial++;?></td>
                <td><?= $row['MODEL']?></td>
                <td><?= $row['BRAND']?></td>
                <td><?= $row['TITLE']?></td>
                <!--<td><?/*= $row['DESCRIPTION']*/?></td>-->
                <td><?php if(!empty($row['PRICE'])) echo '$'.$row['PRICE']?></td>
                <td>&nbsp;<a title="Generate Tag" href="index?model=<?=$row['MODEL']?>"><i class="fas fa-tag"></i></a>
                    &nbsp;&nbsp;<a title="Edit" href="edit?model=<?=$row['MODEL']?>"><i class="fas fa-edit"></i></a>
                    &nbsp;&nbsp;<a title="Delete" href="delete?model=<?=$row['MODEL']?>&source=list" style="color: red"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    function myFunction(type) {
        var input, filter, table, tr, td, i, index;

        if(type == 'model'){
            index = 1;
            input = document.getElementById("myInput");
            document.getElementById("myInputB").value="";
        }
        else if (type == 'brand'){
            index = 2;
            input = document.getElementById("myInputB");
            document.getElementById("myInput").value="";
        }

        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");


        for (i = 0; i < tr.length; i++) {
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
</script>
<script>
    window.onscroll = function() {stickyFunction()}/*,stickyFunction2()*/;

    var stick = document.getElementById("stickForm");
    var sticky = stick.offsetTop;
    var table = document.getElementById("myTable");

    // Add the sticky class / Remove sticky
    function stickyFunction() {
        if (window.pageYOffset >= sticky) {
            stick.classList.add("stickyForm");
        } else {
            stick.classList.remove("stickyForm");
        }
        /*if((window.pageYOffset-400) >= sticky){
            stick.style.display = "none";
        }
        else{
            stick.style.display = "flex";
        }*/
    }
</script>
</body>
</html>