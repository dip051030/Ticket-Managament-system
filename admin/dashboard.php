<?php
require "../includes/auth_check.php";
require "../config/db.php";
include "../includes/header.php";

$isAdmin = $_SESSION["role"] === "admin";
$userId = $_SESSION["user_id"];

/* ===== ADMIN ANALYTICS ===== */
if ($isAdmin) {

    $stats = $conn->query("
        SELECT
            COUNT(*) total,
            SUM(status='Open') open,
            SUM(status='In Progress') progress,
            SUM(status='Closed') closed,
            SUM(DATE(date_created)=CURDATE()) today,
            SUM(date_created >= NOW() - INTERVAL 7 DAY) week
        FROM tickets
    ")->fetch_assoc();

    $topUsers = $conn->query("
        SELECT u.name, COUNT(t.ticket_id) total
        FROM tickets t
        JOIN users u ON t.user_id = u.user_id
        GROUP BY t.user_id
        ORDER BY total DESC
        LIMIT 5
    ");

    $recent = $conn->query("
        SELECT t.ticket_id, t.subject, t.status, t.date_created, u.name
        FROM tickets t
        JOIN users u ON t.user_id=u.user_id
        ORDER BY t.date_created DESC
        LIMIT 10
    ");

} else {

    /* ===== USER ANALYTICS ===== */
    $stats = $conn->query("
        SELECT
            COUNT(*) total,
            SUM(status='Open') open,
            SUM(status='Closed') closed,
            SUM(DATE(date_created)=CURDATE()) today,
            SUM(date_created >= NOW() - INTERVAL 7 DAY) week
        FROM tickets
        WHERE user_id=$userId
    ")->fetch_assoc();

    $recent = $conn->query("
        SELECT ticket_id, subject, status, date_created
        FROM tickets
        WHERE user_id=$userId
        ORDER BY date_created DESC
        LIMIT 10
    ");
}
?>

<div class="container">
<div class="page-header">
    <h2><?= $isAdmin ? "Admin Analytics Dashboard" : "My Activity Dashboard" ?></h2>
    <p class="page-sub">
        <?= $isAdmin ? "System-wide ticket statistics and usage" : "Overview of your support activity" ?>
    </p>
</div>

<!-- ===== STAT CARDS ===== -->
<section class="stats-grid">
    <div class="stat-card">
        <span>Total Tickets</span>
        <strong><?= $stats["total"] ?></strong>
    </div>

    <div class="stat-card blue">
        <span>Open</span>
        <strong><?= $stats["open"] ?></strong>
    </div>

    <?php if ($isAdmin): ?>
    <div class="stat-card amber">
        <span>In Progress</span>
        <strong><?= $stats["progress"] ?></strong>
    </div>
    <?php endif; ?>

    <div class="stat-card green">
        <span>Closed</span>
        <strong><?= $stats["closed"] ?></strong>
    </div>

    <div class="stat-card">
        <span>Created Today</span>
        <strong><?= $stats["today"] ?></strong>
    </div>

    <div class="stat-card">
        <span>Last 7 Days</span>
        <strong><?= $stats["week"] ?></strong>
    </div>
</section>

<?php if ($isAdmin): ?>
<!-- ===== TOP USERS ===== -->
<div class="card analytics-section" style="margin-bottom: 1.5rem;">
    <h3>Most Active Users</h3>

    <?php while ($u = $topUsers->fetch_assoc()): ?>
        <div class="analytics-row">
            <span><?= htmlspecialchars($u["name"]) ?></span>
            <strong><?= $u["total"] ?> tickets</strong>
        </div>
    <?php endwhile; ?>
</div>
<?php endif; ?>

<!-- ===== RECENT ACTIVITY ===== -->
<div class="card analytics-section">
    <h3>Recent Tickets</h3>

    <?php if ($recent->num_rows === 0): ?>
        <p class="page-sub">No activity found.</p>
    <?php endif; ?>

    <?php while ($t = $recent->fetch_assoc()): ?>
        <div class="analytics-row">
            <div>
                <strong><?= htmlspecialchars($t["subject"]) ?></strong><br>
                <small><?= date("d M Y, H:i", strtotime($t["date_created"])) ?></small>
            </div>

            <span class="badge status-<?= strtolower(str_replace(' ','-',$t["status"])) ?>">
                <?= htmlspecialchars($t["status"]) ?>
            </span>
        </div>
    <?php endwhile; ?>
</div>
</div>

<?php include "../includes/footer.php"; ?>

