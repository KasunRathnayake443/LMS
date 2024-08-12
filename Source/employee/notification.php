<?php
include '../config.php';
session_start();
error_reporting(E_ALL ^ E_WARNING);
ini_set('display_errors', 0);

if (!isset($_SESSION['email'])) {
    echo "<script>
        alert('Please login first.');
        window.location.href='../../index.php';
    </script>";
    exit;
}

$email = $_SESSION['email'];
$stml = $conn->prepare("SELECT E_id, E_name FROM employees WHERE E_email = ?");
$stml->bind_param("s", $email);
$stml->execute();
$stml->store_result();
$stml->bind_result($id, $name);
$stml->fetch();
$stml->close();

$leave_types_query = "SELECT leave_name FROM leave_types";
$leave_types_result = $conn->query($leave_types_query);

$notification_query = "SELECT COUNT(*) as count FROM leave_list WHERE E_id = ? AND seen = 0";
$notification_stml = $conn->prepare($notification_query);
$notification_stml->bind_param("s", $id);
$notification_stml->execute();
$notification_result = $notification_stml->get_result();
$notification_row = $notification_result->fetch_assoc();
$notification_count = $notification_row['count'];
$notification_stml->close();


$status_changed_query = "SELECT * FROM leave_list WHERE E_id = ? AND seen = 0";
$status_changed_stml = $conn->prepare($status_changed_query);
$status_changed_stml->bind_param("s", $id);
$status_changed_stml->execute();
$status_changed_result = $status_changed_stml->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - Leave Management System</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/e-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="d-flex">
    <nav class="nav flex-column bg-light p-3" style="width: 300px; height: 100vh;">
        <a class="navbar-brand" href="#">Leave Management System</a>
        <a class="nav-link" href="e-dashboard.php">Apply Leave</a>
        <a class="nav-link" href="leave-history.php">Leave History</a>
        <a class="nav-link" href="edit-profile.php">Profile</a>
        <a class="nav-link" href="logout.php" onclick="return confirmLogout();">Logout</a>
    </nav>
    <div class="flex-grow-1">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <span class="navbar-text">Welcome, <?php echo htmlspecialchars($name); ?></span>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="notification.php">
                                Notifications 
                                <?php if ($notification_count > 0): ?>
                                    <span class="badge bg-warning"><?php echo $notification_count; ?></span>
                               
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="edit-profile.php">
                                <img src="../img/profile_icon.png" alt="Profile Icon" style="width: 30px; height: 30px;"> Edit Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php" onclick="return confirmLogout();">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-4">
            <?php if ($status_changed_result->num_rows > 0): ?>
                <h2 class="text-secondary">Notifications</h2>
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Submitted Date</th>
                            <th>Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Reason</th>
                            <th>Admin Remark</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $status_changed_result->fetch_assoc()): ?>
        <tr style="
            <?php if ($row['Status'] == 'Pending'): ?>
                background-color: yellow;
            <?php elseif ($row['Status'] == 'Approved'): ?>
                background-color: lightgreen;
            <?php elseif ($row['Status'] == 'Declined'): ?>
                background-color: lightcoral;
            <?php endif; ?>
        ">  
            <td><?php echo htmlspecialchars($row['submission_date']); ?></td>
            <td><?php echo htmlspecialchars($row['Leave_type']); ?></td>
            <td><?php echo htmlspecialchars($row['Start']); ?></td>
            <td><?php echo htmlspecialchars($row['End']); ?></td>
            <td>
                <?php 
                    echo htmlspecialchars($row['Status']); 
                    if ($row['Status'] == 'Pending') {
                        echo '<i style="color: orange; margin-left: 24px;" class="fas fa-hourglass-start status-icon status-pending"></i>';
                    } elseif ($row['Status'] == 'Approved') {
                        echo '<i style="color: green; margin-left: 10px;" class="fas fa-check-circle status-icon status-approved"></i>';
                    } elseif ($row['Status'] == 'Declined') {
                        echo '<i style="color: red; margin-left: 18px;" class="fas fa-times-circle status-icon status-declined"></i>';
                    }
                ?>
            </td>
            <td><?php echo htmlspecialchars($row['Comment']); ?></td>
            <td><?php echo htmlspecialchars($row['a_remark']); ?></td>
        </tr>
    <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No New Messages.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="logout.js"></script>
</body>
</html>

<?php

$update_seen_query = "UPDATE leave_list SET seen = 1 WHERE E_id = ?";
$update_seen_stml = $conn->prepare($update_seen_query);
$update_seen_stml->bind_param("s", $id);
$update_seen_stml->execute();
$update_seen_stml->close();  

$_SESSION['name'] = $name;
$_SESSION['id'] = $id;
?>