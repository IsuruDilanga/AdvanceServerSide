<?php

use Module\ModuleMarkCalculator;

if($_SERVER["REQUEST_METHOD"] == "POST"){
        $cw1 = $_POST["cw1"];
        $cw2 = $_POST["cw2"];

        // Include the class file
        include 'ModuleMarkCalculator.php';

        // Create an instance of ModuleMarkCalculator
        $calculator = new ModuleMarkCalculator($cw1, $cw2);

        $overallMark = $calculator->calculateOverallMark();

        echo "Your overall module mark is: " . $overallMark;
    }

?>
