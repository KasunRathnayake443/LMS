<?php
include '../config.php';
session_start();

if (!isset($_SESSION['email'])) {
    echo "<script>
        alert('Please login as admin.');
        window.location.href='admin-login.php';
    </script>";
    exit;
}

$A_id = $_SESSION['A_id'];
$A_name = $_SESSION['A_name'];
$admin_email = $_SESSION['email'];
$leave_id = $_GET['leave_id'];

$stml = $conn->prepare("SELECT * FROM leave_list WHERE leave_id = ?");
$stml->bind_param("i", $leave_id);
$stml->execute();
$result = $stml->get_result();
$leave_request = $result->fetch_assoc();
$stml->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_remark = $_POST['admin_remark'];
    $status = $_POST['status'];
    $seen = 0;

    $update_stml = $conn->prepare("UPDATE leave_list SET a_remark = ?, seen = ?, Status = ?, A_id = ? WHERE leave_id = ?");
    $update_stml->bind_param("sssii", $admin_remark,$seen, $status, $A_id, $leave_id);

    if ($update_stml->execute()) {
        echo "<script>
            alert('Leave request updated successfully.');
            window.location.href='leave-requests.php';
        </script>";
    } else {
        echo "<script>
            alert('Error updating leave request.');
        </script>";
    }

    $update_stml->close();
}

$pending_leave_requests_count = $conn->query("SELECT COUNT(*) as count FROM leave_list WHERE Status = 'Pending'")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request Action - Leave Management System</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="d-flex">
    <nav class="nav flex-column bg-light p-3" style="width: 300px; height: 100vh;">
        <a class="navbar-brand" href="a-dashboard.php">Leave Management System</a>
        <a class="nav-link" href="a-dashboard.php">Dashboard</a>
        <a class="nav-link" href="employees.php">Employees</a>
        <a class="nav-link d-flex justify-content-between align-items-center" href="leave-requests.php">
    Leave Requests
    <?php if ($pending_leave_requests_count > 0): ?>
        <span class="badge bg-warning"><?php echo $pending_leave_requests_count; ?></span>
    <?php endif; ?>
</a>
        <a class="nav-link" href="leave-types.php">Leave Types</a>
        <a class="nav-link" href="departments.php">Departments</a>
        <a class="nav-link" href="admins.php">Admins</a>
        <a class="nav-link" href="logout.php" onclick="return confirmLogout();">Logout</a>
    </nav>
    
    <div class="flex-grow-1">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <span class="navbar-text">
            Welcome, <?php echo $admin_name; ?>
        </span>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="leave-requests.php">
                        Pending Requests 
                        <?php if ($pending_leave_requests_count > 0): ?>
                            <span class="badge bg-warning"><?php echo $pending_leave_requests_count; ?></span>
                        <?php endif; ?>
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
            <h2 class="text-secondary">Leave Request Details</h2>
            <table class="table table-bordered mt-4">
                <tr>
                    <th>Leave Type</th>
                    <td><?php echo htmlspecialchars($leave_request['Leave_type']); ?></td>
                </tr>
                <tr>
                    <th>Start Date</th>
                    <td><?php echo htmlspecialchars($leave_request['Start']); ?></td>
                </tr>
                <tr>
                    <th>End Date</th>
                    <td><?php echo htmlspecialchars($leave_request['End']); ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?php echo htmlspecialchars($leave_request['Status']); ?></td>
                </tr>
                <tr>
                    <th>Employee Comment</th>
                    <td><?php echo htmlspecialchars($leave_request['Comment']); ?></td>
                </tr>
                <tr>
                    <th>Admin Remark</th>
                    <td><?php echo htmlspecialchars($leave_request['a_remark']); ?></td>
                </tr>
            </table>

            <h2 class="text-secondary">Update Leave Request</h2>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="admin_remark" class="form-label">Admin Remark</label>
                    <textarea class="form-control" id="admin_remark" name="admin_remark" required><?php echo htmlspecialchars($leave_request['a_remark']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Pending" <?php echo $leave_request['Status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Approved" <?php echo $leave_request['Status'] == 'Approved' ? 'selected' : ''; ?>>Approved</option>
                        <option value="Declined" <?php echo $leave_request['Status'] == 'Declined' ? 'selected' : ''; ?>>Declined</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Leave Request</button>
            </form>
        </div>
    </div>
</div>

<script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="logout.js"></script>
</body>
</html>

<?php
$conn->close();
?>