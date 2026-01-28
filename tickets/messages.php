<?php
require "../includes/auth_check.php";
require "../config/db.php";
include "../includes/header.php";

$id = (int)($_GET["id"] ?? 0);
$isAdmin = $_SESSION["role"] === "admin";

if ($id <= 0) {
    die("Invalid ticket");
}

$ticketStmt = $conn->prepare(
    "SELECT ticket_id, user_id FROM tickets WHERE ticket_id = ?"
);
$ticketStmt->bind_param("i", $id);
$ticketStmt->execute();
$ticket = $ticketStmt->get_result()->fetch_assoc();

if (!$ticket || (!$isAdmin && (int)$ticket["user_id"] !== (int)$_SESSION["user_id"])) {
    die("Access denied");
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["message"])) {
    $stmt = $conn->prepare(
        "INSERT INTO ticket_messages (ticket_id, sender_id, message_text, date_sent)
         VALUES (?, ?, ?, NOW())"
    );
    $stmt->bind_param("iis", $id, $_SESSION["user_id"], $_POST["message"]);
    $stmt->execute();
}

$messagesStmt = $conn->prepare(
    "SELECT tm.message_text, tm.date_sent, u.name
     FROM ticket_messages tm
     JOIN users u ON tm.sender_id=u.user_id
     WHERE tm.ticket_id=?
     ORDER BY tm.date_sent"
);
$messagesStmt->bind_param("i", $id);
$messagesStmt->execute();
$messages = $messagesStmt->get_result();
?>

<div class="container">
<div class="card">

<?php if ($isAdmin): ?>
<form method="POST" action="/tickets/update_status.php" style="margin-bottom:1rem;">
<input type="hidden" name="ticket_id" value="<?= $id ?>">
<select name="status">
<option>Open</option>
<option>In Progress</option>
<option>Closed</option>
</select>
<button>Update Status</button>
</form>
<?php endif; ?>

<div class="chat-container">
<?php while ($m = $messages->fetch_assoc()): ?>
<div class="bubble">
<div class="bubble-meta"><?= $m["name"] ?> • <?= $m["date_sent"] ?></div>
<?= htmlspecialchars($m["message_text"]) ?>
</div>
<?php endwhile; ?>
</div>

<form method="POST" class="form-group">
<textarea name="message" required></textarea>
<button>Send</button>
</form>

</div>
</div>

<?php include "../includes/footer.php"; ?>
