<?php

$model = isset($_GET['model']) ? $_GET['model'] : '';
$source = isset($_GET['source']) ? $_GET['source'] : 'index';


if(!empty($model)){
    require_once( 'shared/connect.php' );

    $sql = "DELETE FROM data WHERE MODEL = '$model'";

    $dbh->exec($sql);

    $conn = null;
}
?>
<script>
    alert("<?=$model?> deleted successfully.");
    window.location.href = '<?=$source?>';
</script>

