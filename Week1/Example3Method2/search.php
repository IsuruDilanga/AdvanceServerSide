<?php

use Example3Method2\BookSearch;
use Example3Method2\Database;

include('Database.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];

    // Create an instance of the Database class
    $db = new Database();

    // Create an instance of the BookSearch class
    $bookSearch = new BookSearch($db);

    // Use the BookSearch class to perform the search
    $bookSearch->searchBooks($title, $author, $year);
}

?>
