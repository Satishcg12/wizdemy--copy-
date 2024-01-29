<?php
if (isset($_SESSION['toastMessage'])) {

    $msg = $_SESSION['toastMessage']['message'];
    $type = $_SESSION['toastMessage']['type'];
    $duration = $_SESSION['toastMessage']['duration'];

    echo "<div class='toast toast-$type' data-duration='$duration'>".htmlspecialchars($msg)."</div>";

    unset($_SESSION['toastMessage']);
}
unset($_SESSION['old']);
?>
</body>

</html>