<footer class="site-footer">
    <div class="footer-inner">

        <div class="footer-section">
            <div class="footer-title">System</div>
            <div class="footer-links">
                <a href="/dashboard.php">Dashboard</a>
                <a href="/tickets/create.php">New Ticket</a>
            </div>
        </div>

        <div class="footer-section">
            <div class="footer-title">Account</div>
            <div class="footer-links">
                <a href="/logout.php">Logout</a>
            </div>
        </div>

    </div>
</footer>

<script>
(function () {
    var navToggle = document.getElementById("navToggle");
    var navLinks = document.getElementById("navLinks");

    if (navToggle && navLinks) {
        navToggle.addEventListener("click", function () {
            navLinks.classList.toggle("active");
        });

        document.addEventListener("click", function (e) {
            if (!navToggle.contains(e.target) && !navLinks.contains(e.target)) {
                navLinks.classList.remove("active");
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

