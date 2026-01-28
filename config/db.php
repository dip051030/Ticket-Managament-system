<?php
$host = "localhost";
$user = "root";
$pass = "StrongRootPassword123";
$db   = "ticketing_system";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed");
}

