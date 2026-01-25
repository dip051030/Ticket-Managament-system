<?php
require "../includes/auth_check.php";
require "../config/db.php";

if ($_SESSION["role"] !== "admin") die;

$stmt = $conn->prepare(
    "UPDATE tickets SET status=? WHERE ticket_id=?"
);
$stmt->bind_param("si", $_POST["status"], $_POST["ticket_id"]);
$stmt->execute();

header("Location: /tickets/messages.php?id=".$_POST["ticket_id"]);
exit;

