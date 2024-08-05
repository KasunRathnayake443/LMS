<?php
include '../config.php';
session_start();

if (!isset($_SESSION['email'])|| !isset($_GET['E_id'])) {
    echo "<script>
        alert('Please login as admin.');
        window.location.href='admin-login.php';
    </script>";
    exit;
}

$E_id = $_GET['E_id'];

$stml = $conn->prepare("SELECT E_name, E_email, E_department FROM employees WHERE E_id = ?");
$stml->bind_param("s", $E_id);
$stml->execute();
$result = $stml->get_result();
$employee = $result->fetch_assoc();



$admin_email = $_SESSION['email'];


$stml = $conn->prepare("SELECT A_id, A_name FROM admin WHERE A_email = ?");
$stml->bind_param("s", $admin_email);
$stml->execute();
$stml->store_result();
$stml->bind_result($admin_id, $admin_name);
$stml->fetch();
$stml->close();


$departments_query = "SELECT d_name FROM departments";
$departments_result = $conn->query($departments_query);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Leave Management System</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       
    </style>
</head>
<body>
<div class="d-flex">
    <nav class="nav flex-column bg-light p-3" style="width: 300px; height: 100vh;">
        <a class="navbar-brand" href="a-dashboard.php">Leave Management System</a>
        <a class="nav-link" href="a-dashboard.php"> DashBoard</a>
        <a class="nav-link" href="employees.php"> Employees</a>
        <a class="nav-link" href="leave-requests.php"> Leave Requests</a>
        <a class="nav-link" href="leave-types.php"> Leave Types</a>
        <a class="nav-link" href="departments.php"> Departments</a>
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
                        <a class="nav-link" href="logout.php" onclick="return confirmLogout();">Logout</a>
                    </ul>
                </div>
            </div>
        </nav>

        <h2 class="text-secondary">Employee, <?php echo htmlspecialchars($employee['E_name']); ?></h2>
        <div class="container mt-4">
            <h3 class="text-secondary">Edit Profile</h3>
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
$conn->close();
?>