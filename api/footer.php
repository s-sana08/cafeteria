<footer class="page-footer">
    <p class="mb-0">Copyright © 2026. All right reserved.</p>
</footer>

<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
let role = "<?php echo $_SESSION['emp_role'] ?? ''; ?>";
let user = "<?php echo $_SESSION['username'] ?? ''; ?>";

// log only meaningful buttons automatically
$(document).on("click", "button, input[type=submit], a", function(e) {

    if (role !== "Admin") return;

    let text = "";

    // button text
    if ($(this).is("button")) {
        text = $(this).text().trim();
    }

    // input submit value
    if ($(this).is("input[type=submit]")) {
        text = $(this).val();
    }

    // link text
    if ($(this).is("a")) {
        text = $(this).text().trim();
    }

    if (text === "") return;

    // filter useless clicks (IMPORTANT)
    let ignoreList = ["", "close", "cancel", "x"];
    if (ignoreList.includes(text.toLowerCase())) return;

    $.post("save_log.php", {
        message: user + " clicked " + text
    });

});
</script>