<?php

try {
    $host = "localhost";
    $dbname = "hotel-booking";
    $user = "root";
    $pass = "";

    $conn = new PDO("mysql: host=$host; dbname=$dbname;", $user, $pass);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "err is: " . $e->getMessage();
}
