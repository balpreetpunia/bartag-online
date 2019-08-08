<?php

foreach ($_POST as $param_name => $param_val) {
    echo "Param: $param_name; Value: $param_val<br />\n";
}
echo "<br /> <br />";

foreach ($_GET as $param_name => $param_val) {
    echo "Param: $param_name; Value: $param_val<br />\n";
}