<?php
require "../includes/auth_check.php";
require "../config/db.php";

$id  = $_GET["id"];
$uid = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT * FROM tickets
     WHERE ticket_id = ? AND user_id = ? AND status = 'Open'"
);
$stmt->bind_param("ii", $id, $uid);
$stmt->execute();
$ticket = $stmt->get_result()->fetch_assoc();

if (!$ticket) {
    die("Access denied");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare(
        "UPDATE tickets SET subject = ?, description = ? WHERE ticket_id = ?"
    );
    $stmt->bind_param(
        "ssi",
        $_POST["subject"],
        $_POST["description"],
        $id
    );
    $stmt->execute();
    header("Location: view.php");
}
?>

<h2>Edit Ticket</h2>

<form method="POST">
    <input name="subject"
           value="<?= htmlspecialchars($ticket["subject"]) ?>" required>
    <textarea name="description" required><?= htmlspecialchars($ticket["description"]) ?></textarea>
    <button>Update</button>
</form>

