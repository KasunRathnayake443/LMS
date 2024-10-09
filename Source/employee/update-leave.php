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

$leave_id = $_SESSION['leave_id'];

$leave_type = $_POST['leaveType'];
$from_date = $_POST['leaveStart'];
$to_date = $_POST['leaveEnd'];
$reason = $_POST['leaveReason'];


$stml = $conn->prepare("UPDATE leave_list SET  leave_type = ?, Start = ?, End = ?,  Comment = ? WHERE leave_id = ?");
$stml->bind_param("sssss",  $leave_type, $from_date, $to_date, $reason, $leave_id);
$stml->execute();
$stml->close();

echo "<script>
    
    window.location.href='leave-history.php?notifications1=1';
</script>";
?>