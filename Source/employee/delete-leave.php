<?php
include '../config.php';
session_start();

if ( !isset($_POST['leave_id'])) {
    echo "<script>
        alert('Invalid request.');
        window.location.href='leave-history.php';
    </script>";
    exit;
}


$leave_id = $_POST['leave_id'];

$stml = $conn->prepare("DELETE FROM leave_list WHERE  leave_id = ?");
$stml->bind_param("s", $leave_id);

if ($stml->execute()) {
    echo "<script>
        
        window.location.href='leave-history.php';
    </script>";
} else {
    echo "<script>
        alert('Error deleting leave request.');
        window.location.href='leave-history.php';
    </script>";
}

$stml->close();
$conn->close();
?>