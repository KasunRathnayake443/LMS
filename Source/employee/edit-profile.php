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

$stml = $conn->prepare("SELECT E_name, E_email, E_department FROM employees WHERE E_id = ?");
$stml->bind_param("s", $id);
$stml->execute();
$result = $stml->get_result();
$employee = $result->fetch_assoc();

if (!$employee) {
    echo "<script>
        alert('Profile not found.');
        window.location.href='e-dashboard.php';
    </script>";
    exit;
}

$departments_query = "SELECT d_name FROM departments";
$departments_result = $conn->query($departments_query);



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
    <title>Edit Profile - Leave Management System</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/e-dashboard.css">
    <link rel="icon" type="image/x-icon" href="../img/icon.png">
    <link rel="stylesheet" href="../css/spinner.css">
    <link rel="stylesheet" href="../css/alerts.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    Welcome, <?php echo htmlspecialchars($employee['E_name']); ?> 
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
            <h2 class="text-secondary">Edit Profile</h2>
            <form action="update-profile.php" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($employee['E_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($employee['E_email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <select class="form-select" id="department" name="department" required>
                    <?php
                        if ($departments_result->num_rows > 0) {
                            while ($row = $departments_result->fetch_assoc()) {
                                $selected = ($employee['E_department'] == $row['d_name']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($row['d_name']) . '" ' . $selected . '>' . htmlspecialchars($row['d_name']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small class="form-text text-muted">Leave blank to keep the current password.</small>
                </div>
                <div class="success2" id="alertBox">
                        <i class="fa fa-check fa-2x"></i> 
                         <span class="message-text">Profile updated successfully.</span>
                       <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    </div>
                    <div class="nothing2" id="alertBox2">
                        <i class="fa fa-info-circle fa-2x"></i> 
                        <span class="message-text">No changes made to the profile.</span>
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    </div>

                <button type="submit" class="btn btn-primary w-100">Update Profile</button>
            </form>
        </div>
    </div>
</div>

<script src="../js/notifications1.js"></script>
<script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="logout.js"></script>
</body>
</html>

<?php
$stml->close();
$conn->close();
?>