<?php
include '../config.php';
session_start();


if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    echo "<script>
        alert('Please login first.');
        window.location.href='../../index.php';
    </script>";
    exit;
}

date_default_timezone_set('Asia/Kolkata');

$id = $_SESSION['id'];
$name = $_SESSION['name'];
$leave_type = $_POST['leaveType'];
$from_date = $_POST['leaveStart'];
$to_date = $_POST['leaveEnd'];
$reason = $_POST['leaveReason'];
$status = "Pending";
$seen = 1;
$submissionDate = date('Y-m-d H:i:s');

$stml = $conn->prepare("INSERT INTO leave_list (E_name, E_id, leave_type, Start, End, Status, Comment , seen , submission_date) VALUES (?,?,?,?,?,?,?,?,?)");
$stml->bind_param("sssssssss", $name, $id, $leave_type, $from_date, $to_date, $status, $reason, $seen, $submissionDate);
$stml->execute();
$stml->close();

echo "<script>
    
    alert('Leave application submitted successfully.');
    window.location.href='e-dashboard.php';
</script>";
?>