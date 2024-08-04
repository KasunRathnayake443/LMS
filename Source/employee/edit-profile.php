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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Leave Management System</title>
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
                <span class="navbar-text">
                    Welcome, <?php echo htmlspecialchars($employee['E_name']); ?> 
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
                <button type="submit" class="btn btn-primary w-100">Update Profile</button>
            </form>
        </div>
    </div>
</div>

<script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="logout.js"></script>
</body>
</html>

<?php
$stml->close();
$conn->close();
?>