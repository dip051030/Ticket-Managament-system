<footer class="site-footer">
    <div class="footer-inner">

        <div class="footer-section">
            <div class="footer-title">Navigation</div>
            <div class="footer-links">
                <a href="/dashboard.php">Dashboard</a>
                <a href="/tickets/create.php">New Ticket</a>
            </div>
        </div>

        <div class="footer-section">
            <div class="footer-title">Account</div>
            <div class="footer-links">
                <?php if (isset($_SESSION["user_id"])): ?>
                    <a href="/auth/logout.php">Logout</a>
                <?php else: ?>
                    <a href="/auth/login.php">Login</a>
                    <a href="/auth/register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer-section">
            <div class="footer-title">Support</div>
            <div class="footer-links">
                <span>Email: support@example.com</span>
                <span>Response time: 24h</span>
            </div>
        </div>

    </div>
    <div class="footer-bottom">
        &copy; <?= date("Y") ?> SupportPortal. All rights reserved.
    </div>
</footer>

<script>
(function () {
    var navToggle = document.getElementById("navToggle");
    var navLinks = document.getElementById("navLinks");

    if (navToggle && navLinks) {
        navToggle.addEventListener("click", function () {
            navLinks.classList.toggle("show");
            navToggle.classList.toggle("active");
        });

        document.addEventListener("click", function (e) {
            if (!navToggle.contains(e.target) && !navLinks.contains(e.target)) {
                navLinks.classList.remove("show");
                navToggle.classList.remove("active");
            }
        });
    }

    var footerTitles = document.querySelectorAll(".footer-title");
    footerTitles.forEach(function (title) {
        title.addEventListener("click", function () {
            title.parentElement.classList.toggle("active");
        });
    });
})();
</script>

</body>
</html>

