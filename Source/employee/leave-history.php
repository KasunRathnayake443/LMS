<?php
include '../config.php';
session_start();

if (!isset($_SESSION['id'])) {
    echo "<script>
        alert('Please login first.');
        window.location.href='../../index.php';
    </script>";
    exit;
}

$id = $_SESSION['id'];

$stml = $conn->prepare("SELECT leave_id, leave_type, Start, End, Status, Comment, a_remark FROM leave_list WHERE E_id = ? ORDER BY CASE Status WHEN 'Pending' THEN 1 WHEN 'Approved' THEN 2 ELSE 3 END");
$stml->bind_param("s", $id);
$stml->execute();
$result = $stml->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave History - Leave Management System</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/e-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .container {
            margin-top: 20px;
        }
        .table {
            margin-top: 20px;
        }
        .btn-edit {
            margin: 0;
        }
    </style>
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
                <span class="navbar-text">
                    Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> 
                </span>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
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
            <h2 class="text-secondary">Leave History</h2>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Reason</th>
                        <th>Admin Remark</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['leave_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['Start']); ?></td>
                        <td><?php echo htmlspecialchars($row['End']); ?></td>
                        <td><?php 
                            echo htmlspecialchars($row['Status']); 
                            if ($row['Status'] == 'Pending') {
                                echo '<i style="color: orange; margin-left: 24px;" class="fas fa-hourglass-start status-icon status-pending"></i>';
                            } elseif ($row['Status'] == 'Approved') {
                                echo '<i style="color: green; margin-left: 10px;" class="fas fa-check-circle status-icon status-approved"></i>';
                            } elseif ($row['Status'] == 'Declined') {
                                echo '<i style="color: red; margin-left: 18px;" class="fas fa-times-circle status-icon status-declined"></i>';
                            }
                        ?></td>
                        <td><?php echo htmlspecialchars($row['Comment']); ?></td>
                        <td><?php echo htmlspecialchars($row['a_remark']); ?></td>
                        <td>
                            <?php if ($row['Status'] == 'Pending'): ?>
                                <a href="edit-leave.php?leave_id=<?php echo htmlspecialchars($row['leave_id']); ?>"><i class="fas fa-edit"></i></a>
                                <a href="delete-leave.php?leave_id=<?php echo htmlspecialchars($row['leave_id']); ?>" class="btn-edit" onclick="return confirm('Are you sure you want to delete this leave request?')"><i class="fas fa-trash"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="logout.js"></script>
</body>
</html>

<?php
$_SESSION['id'] = $id;
$stml->close();
$conn->close();
?>