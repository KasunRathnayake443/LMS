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

$admin_email = $_SESSION['email'];

$stml = $conn->prepare("SELECT A_id, A_name FROM admin WHERE A_email = ?");
$stml->bind_param("s", $admin_email);
$stml->execute();
$stml->store_result();
$stml->bind_result($admin_id, $admin_name);
$stml->fetch();
$stml->close();

$employees_count_query = "SELECT COUNT(*) as count FROM employees";
$employees_count_result = $conn->query($employees_count_query);
$employees_count = $employees_count_result->fetch_assoc()['count'];

$employees_query = "SELECT * FROM employees";
$employees_result = $conn->query($employees_query);




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

        <div class="container mt-4">
            <div class="d-flex justify-content-around">
                <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                    <div class="card-header">Number of Employees</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $employees_count; ?></h5>
                        <p class="card-text">Number of Employees</p>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="text-secondary">Most Recent Leave Requests</h2>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $employees_result->fetch_assoc()): ?>
                    <tr>
                    <td><?php echo htmlspecialchars($row['E_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['E_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['E_department']); ?></td>
                        <td><?php echo htmlspecialchars($row['E_email']); ?></td>
                        <td>
                        <a href="employee-edit-profile.php?leave_id=<?php echo htmlspecialchars($row['E_id']); ?>" > <i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

    </div>
</div>

<script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="logout.js"></script>

</body>
</html>

<?php
$conn->close();
?>