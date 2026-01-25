<?php
require "../includes/auth_check.php";
require "../config/db.php";
include "../includes/header.php";

$id = $_GET["id"];
$isAdmin = $_SESSION["role"] === "admin";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["message"])) {
    $stmt = $conn->prepare(
        "INSERT INTO ticket_messages (ticket_id, sender_id, message_text, date_sent)
         VALUES (?, ?, ?, NOW())"
    );
    $stmt->bind_param("iis", $id, $_SESSION["user_id"], $_POST["message"]);
    $stmt->execute();
}

$messages = $conn->query(
    "SELECT tm.message_text, tm.date_sent, u.name
     FROM ticket_messages tm
     JOIN users u ON tm.sender_id=u.user_id
     WHERE tm.ticket_id=$id
     ORDER BY tm.date_sent"
);
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

