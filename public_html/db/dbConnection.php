<?php
$servername = "localhost";
$username = "id7886184_weebguy1";
$dbname = "id7886184_wp_stuff";
$password = "pcsamsung12";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Check connection
if ($conn->connect_error) {
    //die("Connection failed: " . $conn->connect_error);
} else{
    //echo "Connected successfully";
}



?>