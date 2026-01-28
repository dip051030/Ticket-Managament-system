<?php
$host = "localhost";
$user = "root";
$pass = "StrongRootPassword123";
$db   = "25123800";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed");
}

