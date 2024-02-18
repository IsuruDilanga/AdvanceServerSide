<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $cw1 = $_POST["cw1"];
    $cw2 = $_POST["cw2"];
    $overallMark = ($cw1 * 0.4) + ($cw2 * 0.6);
    echo "Your overall module mark is: " . $overallMark;
}

?>
