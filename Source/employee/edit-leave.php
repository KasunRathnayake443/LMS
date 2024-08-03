<?php
include '../config.php';
session_start();


if (!isset($_SESSION['id']) || !isset($_GET['leave_id'])) {
    echo "<script>
        alert('Invalid request.');
        window.location.href='leave-history.php';
    </script>";
    exit;
}

$id = $_SESSION['id'];
$leave_id = $_GET['leave_id'];


$stml = $conn->prepare("SELECT leave_type, Start, End, Comment FROM leave_list WHERE E_id = ? AND leave_id = ?");
$stml->bind_param("ss", $id, $leave_id);
$stml->execute();
$result = $stml->get_result();
$leave = $result->fetch_assoc();

if (!$leave) {
    echo "<script>
        alert('Leave request not found.');
        window.location.href='leave-history.php';
    </script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Leave - Leave Management System</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>
<body>
<div class="d-flex">
   
    <nav class="nav flex-column bg-light p-3" style="width: 300px; height: 100vh;">
        <a class="navbar-brand" href="#">Leave Management System</a>
        <a class="nav-link" href="e-dashboard.php">Apply Leave</a>
        <a class="nav-link" href="leave-history.php">Leave History</a>
        <a class="nav-link" href="profile.php">Profile</a>
        <a class="nav-link" href="logout.php">Logout</a>
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
                            <a class="nav-link" href="profile.php">
                                <img src="../img/profile_icon.png" alt="Profile Icon" style="width: 30px; height: 30px;"> Edit Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            <h2 class="text-secondary">Edit Leave Request</h2>
            <form action="update-leave.php" method="post">
                <input type="hidden" name="leave_id" value="<?php echo htmlspecialchars($leave_id); ?>">
                <div class="mb-3">
                    <label for="leaveType" class="form-label">Leave Type</label>
                    <select class="form-select" id="leaveType" name="leaveType" required>
                        <option value="Sick Leave" <?php if ($leave['leave_type'] == 'Sick Leave') echo 'selected'; ?>>Sick Leave</option>
                        <option value="Casual Leave" <?php if ($leave['leave_type'] == 'Casual Leave') echo 'selected'; ?>>Casual Leave</option>
                        <option value="Paid Leave" <?php if ($leave['leave_type'] == 'Paid Leave') echo 'selected'; ?>>Paid Leave</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="leaveStart" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="leaveStart" name="leaveStart" value="<?php echo htmlspecialchars($leave['Start']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="leaveEnd" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="leaveEnd" name="leaveEnd" value="<?php echo htmlspecialchars($leave['End']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="leaveReason" class="form-label">Reason</label>
                    <textarea class="form-control" id="leaveReason" name="leaveReason" rows="3" required><?php echo htmlspecialchars($leave['Comment']); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update</button>
            </form>
        </div>
    </div>
</div>

<script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stml->close();
$conn->close();
?>