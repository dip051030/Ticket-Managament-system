<?php
require "../includes/auth_check.php";
require "../config/db.php";

if ($_SESSION["role"] !== "admin") die;

$stmt = $conn->prepare(
    "DELETE FROM tickets WHERE ticket_id=?"
);
$stmt->bind_param("i", $_POST["ticket_id"]);
$stmt->execute();

header("Location: /dashboard.php");
exit;

