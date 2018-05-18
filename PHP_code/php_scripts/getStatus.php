<?php

$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "testDB";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM bayregister";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $json = array();
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $json[] = $row;
    }
    echo json_encode($json);
} else {
    echo "0 results";
}

mysqli_close($conn);

$status = 0;
?>
