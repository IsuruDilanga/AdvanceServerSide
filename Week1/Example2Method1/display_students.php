<?php

$studentData = [
    "Samwise Gamgee" => 88,
    "Frodo Baggins" => 56,
    "Elrond Half-Elven" => 92,
    "Gandalf Mithrandir" => 35,
    "Merry Brandybuck" => 41,
    "Pippin Took" => 25,
    "Legolas Greenleaf" => 67,
];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $enteredStudentName = $_POST["studentName"];
    $enteredMark = $_POST["mark"];

    $studentData[$enteredStudentName] = $enteredMark;

    echo "<h2>Updated Student List:</h2>";

    foreach($studentData as $student => $mark){
        echo "$student: $mark<br>";
    }
}