<?php
include '../config.php';
session_start();
error_reporting(E_ALL ^ E_WARNING);
ini_set('display_errors', 0);

if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
    echo "<script>
        alert('Please login first.');
        window.location.href='../../index.php';
    </script>";
    exit;
}

$id = $_SESSION['id'];
$name = $_SESSION['name'];
$leave_type = $_POST['leaveType'];
$from_date = $_POST['leaveStart'];
$to_date = $_POST['leaveEnd'];
$reason = $_POST['leaveReason'];
$status = "Pending";

$stml = $conn->prepare("INSERT INTO leave_list (E_name, E_id, leave_type, Start, End, Status, Comment) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stml->bind_param("sssssss", $name, $id, $leave_type, $from_date, $to_date, $status, $reason);
$stml->execute();
$stml->close();

echo "<script>
    
    alert('Leave application submitted successfully.');
    window.location.href='e-dashboard.php';
</script>";
?>