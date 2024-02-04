<?php

global $conn;
include('db.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];

    // Build the query based on the provided criteria
    $query = "SELECT * FROM books WHERE 1=1";
    if (!empty($title)) {
        $query .= " AND title LIKE '%$title%'";
    }
    if (!empty($author)) {
        $query .= " AND author LIKE '%$author%'";
    }
    if (!empty($year)) {
        $query .= " AND year_of_publication = $year";
    }

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Build the HTML page with the results
    echo "<html><head><title>Book Search Results</title></head><body>";

    // Display the matching books
    echo "<h2>Matching Books:</h2>";
    echo "<table border='1'><tr><th>Title</th><th>Author</th><th>Year</th><th>Price</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['title']}</td><td>{$row['author']}</td><td>{$row['year_of_publication']}</td><td>{$row['price']}</td></tr>";
    }
    echo "</table>";

    echo "</body></html>";

    // Close the database connection
    mysqli_close($conn);
}
?>
