<?php
function dbConnect() {
    $host = 'localhost'; // Database host
    $user = 'root';      // Database username
    $pass = '';          // Database password (leave blank if none)
    $dbname = 'dct-ccs-finals'; // Your database name

    // Create a connection
    $connection = new mysqli($host, $user, $pass, $dbname);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    return $connection;
}
?>
