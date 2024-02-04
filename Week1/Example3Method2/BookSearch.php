<?php

namespace Example3Method2;

class BookSearch {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function searchBooks($title, $author, $year) {
        $query = "SELECT * FROM books WHERE 1=1";

        if (!empty($title)) {
            $query .= " AND Title LIKE '%$title%'";
        }

        if (!empty($author)) {
            $query .= " AND Author LIKE '%$author%'";
        }

        if (!empty($year)) {
            $query .= " AND `Year of Publication` = $year";
        }

        $result = mysqli_query($this->conn, $query);

        $this->displayResults($result);

        $this->closeConnection();
    }

    private function displayResults($result) {
        echo "<html><head><title>Book Search Results</title></head><body>";

        echo "<h2>Matching Books:</h2>";
        echo "<table border='1'><tr><th>Title</th><th>Author</th><th>Year</th><th>Price</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>{$row['Title']}</td><td>{$row['Author']}</td><td>{$row['Year of Publication']}</td><td>{$row['Price']}</td></tr>";
        }

        echo "</table>";
        echo "</body></html>";
    }

    private function closeConnection() {
        $db = new Database();
        $db->closeConnection();
    }
}

?>