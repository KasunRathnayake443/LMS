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

$leave_types_query = "SELECT leave_name FROM leave_types";
$leave_types_result = $conn->query($leave_types_query);

if (!$leave) {
    echo "<script>
        alert('Leave request not found.');
        window.location.href='leave-history.php';
    </script>";
    exit;
}


$notification_query = "SELECT COUNT(*) as count FROM leave_list WHERE E_id = ? AND seen = 0";
$notification_stml = $conn->prepare($notification_query);
$notification_stml->bind_param("s", $id);
$notification_stml->execute();
$notification_result = $notification_stml->get_result();
$notification_row = $notification_result->fetch_assoc();
$notification_count = $notification_row['count'];
$notification_stml->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Leave - Leave Management System</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/e-dashboard.css">
    <link rel="icon" type="image/x-icon" href="../img/icon.png">
    <link rel="stylesheet" href="../css/spinner.css">
</head>
<body>


<div id="spinner" class="show">
<div class="spinner-border text-success" role="status">
  <span class="sr-only"></span>
</div>
</div>
<script src="../js/spinner.js"></script>
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
                    <a class="nav-link" href="notification.php">
                        Notifications 
                        <?php if ($notification_count > 0): ?>
                            <span class="badge bg-warning"><?php echo $notification_count; ?></span>
                        <?php endif; ?>
                    </a>
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
            <h2 class="text-secondary">Edit Leave Request</h2>
            <form action="update-leave.php" method="post">
                <input type="hidden" name="leave_id" value="<?php echo htmlspecialchars($leave_id); ?>">
                <div class="mb-3">
                    <label for="leaveType" class="form-label">Leave Type</label>
                    <select class="form-select" id="leaveType" name="leaveType" required>
                        <?php
                        if ($leave_types_result->num_rows > 0) {
                            while ($row = $leave_types_result->fetch_assoc()) {
                                $selected = ($leave['leave_type'] == $row['leave_name']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($row['leave_name']) . '" ' . $selected . '>' . htmlspecialchars($row['leave_name']) . '</option>';
                            }
                        }
                        ?>
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var leaveStart = document.getElementById('leaveStart');
        var leaveEnd = document.getElementById('leaveEnd');
        
       
        var today = new Date().toISOString().split('T')[0];
        leaveStart.setAttribute('min', today);
        
       
        leaveEnd.disabled = true;

       
        leaveStart.addEventListener('change', function() {
            if (leaveStart.value) {
                leaveEnd.disabled = false;
                leaveEnd.setAttribute('min', leaveStart.value);
            } else {
                leaveEnd.disabled = true;
                leaveEnd.removeAttribute('min');
            }
        });
    });
</script>

<script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="logout.js"></script>
</body>
</html>

<?php
$_SESSION['leave_id'] = $leave_id;
$stml->close();
$conn->close();
?>