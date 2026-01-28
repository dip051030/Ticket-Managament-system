<?php
require "../includes/auth_check.php";
require "../config/db.php";
require "../includes/flash.php";

if($_SESSION["role"]!=="admin") die;

$id = (int)($_POST["ticket_id"] ?? 0);
$new = $_POST["status"] ?? "";
$allowed = ["Open", "In Progress", "Closed"];

if ($id <= 0) {
    die("Invalid ticket");
}

if (!in_array($new, $allowed, true)) {
    set_flash("Invalid status", "error");
    header("Location:/tickets/messages.php?id=$id");
    exit;
}

$oldStmt = $conn->prepare(
    "SELECT status FROM tickets WHERE ticket_id=?"
);
$oldStmt->bind_param("i", $id);
$oldStmt->execute();
$oldRes = $oldStmt->get_result()->fetch_assoc();
$old = $oldRes ? $oldRes["status"] : null;

if ($old === null) {
    die("Ticket not found");
}

$updateStmt = $conn->prepare(
    "UPDATE tickets SET status=? WHERE ticket_id=?"
);
$updateStmt->bind_param("si", $new, $id);
$updateStmt->execute();

$logStmt = $conn->prepare(
    "INSERT INTO ticket_status_log
     (ticket_id,old_status,new_status,changed_by)
     VALUES(?,?,?,?)"
);
$logStmt->bind_param("issi", $id, $old, $new, $_SESSION["user_id"]);
$logStmt->execute();

set_flash("Status updated");
header("Location:/tickets/messages.php?id=$id");
exit;
