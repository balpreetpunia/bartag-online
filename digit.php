<?php

if (isset($_POST["code"])) {
    $query = strtoupper($_POST["code"]);
    $queryj = $query;
    //Get rid of multiple commas and/or commas at the end.
    $query = strtoupper($query);
    $query = rtrim($query, ',');
    $query = preg_replace('/,+/', ',', $query);

    $vals = explode(',', $query);

    //Trim whitespace
    foreach($vals as $key => $val) {
        $vals[$key] = trim($val);
    }

    $o_array = array_diff($vals, array(""));

}

function generate_upc_checkdigit($upc_code)
{
    $odd_total  = 0;
    $even_total = 0;

    for($i=0; $i<11; $i++)
    {
        if((($i+1)%2) == 0) {
            /* Sum even digits */
            $even_total += $upc_code[$i];
        } else {
            /* Sum odd digits */
            $odd_total += $upc_code[$i];
        }
    }

    $sum = (3 * $odd_total) + $even_total;

    /* Get the remainder MOD 10*/
    $check_digit = $sum % 10;

    /* If the result is not zero, subtract the result from ten. */
    return ($check_digit > 0) ? 10 - $check_digit : $check_digit;

    //$digit = ($check_digit > 0) ? 10 - $check_digit : $check_digit;
    //echo $upc_code.$digit;
}

generate_upc_checkdigit("62802440007");

$serial = 1;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check Digit Generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="JsBarcode.all.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container" id="container1">
    <div class="jumbotron">
        <h1>Check Digit Generator</h1>
        <p>Enter code seperated with comma. (62802430000,62802430001,62802430002)</p>
    </div>
    <div class="input-field">
        <form id="calculator" method="post" action="">
            <div class="form-group">
                <input id="code" name="code" class="auto form-control" placeholder="Enter code seperated with comma. (62802430000,62802430001,62802430002)" type="text" />
            </div>
                <button class="btn btn-primary w-100" id="generate" type="submit">Generate</button>
        </form>
    </div>
</div>
<hr>
<div class="container">
    <?php if (!empty($query)): ?>
    <div class="table-responsive-sm">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <td>#</td>
                <td>Original</td>
                <td>Check Digit</td>
                <td>GTIN Code</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($o_array as $value ): ?>
            <tr>
                <td><?php echo $serial; $serial ++;?></td>
                <td><?=$value?></td>
                <td><?php $digit=generate_upc_checkdigit($value); echo $digit?></td>
                <td><?=$value.$digit?></td>
            </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <?php endif ?>
</div>
<script>
    <?php if (!empty($query)): ?>
    document.getElementById('code').value = '<?=$queryj?>';
    <?php endif ?>
</script>
</body>
</html>