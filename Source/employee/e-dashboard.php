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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - Leave Management System</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/e-dashboard.css">
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
            <h1 class="text-secondary">Welcome to the Employee Dashboard</h1>
            <div class="container mt-5">
                <h2 class="text-center text-secondary">Apply Leave</h2>
                <div class="row justify-content-center mt-3">
                    <div class="col-md-8">
                        <form action="leave-submit.php" method="post">
                            <div class="mb-3 row">
                                <label for="leaveType" class="col-sm-3 col-form-label">Leave Type</label>
                                <div class="col-sm-9">
                                    <select class="form-select" id="leaveType" name="leaveType" required>
                                        <option value="" selected disabled>Select leave type</option>
                                        <?php
                                        if ($leave_types_result->num_rows > 0) {
                                            while ($row = $leave_types_result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['leave_name']) . '">' . htmlspecialchars($row['leave_name']) . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="leaveStart" class="col-sm-3 col-form-label">Start Date</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="leaveStart" name="leaveStart" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="leaveEnd" class="col-sm-3 col-form-label">End Date</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="leaveEnd" name="leaveEnd" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="leaveReason" class="col-sm-3 col-form-label">Reason</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="leaveReason" name="leaveReason" rows="3" required></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Apply</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('leaveStart').setAttribute('min', today);
    });
</script>

<?php
$_SESSION['name'] = $name;
$_SESSION['id'] = $id;
?>

<script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="logout.js"></script>
</body>
</html>