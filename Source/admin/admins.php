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

$admin_count_query = "SELECT COUNT(*) as count FROM admin";
$admin_count_result = $conn->query($admin_count_query);
$admin_count = $admin_count_result->fetch_assoc()['count'];

$admin_query = "SELECT * FROM admin";
$admin_result = $conn->query($admin_query);

$admin_query = "SELECT * FROM admin";
$admin_result = $conn->query($admin_query);

$pending_leave_requests_count = $conn->query("SELECT COUNT(*) as count FROM leave_list WHERE Status = 'Pending'")->fetch_assoc()['count'];

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
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="d-flex">
    <nav class="nav flex-column bg-light p-3" style="width: 300px; min-height: 100vh;">
        <a class="navbar-brand" href="a-dashboard.php">Leave Management System</a>
        <a class="nav-link" href="a-dashboard.php"> Dashboard</a>
        <a class="nav-link" href="employees.php"> Employees</a>
        <a class="nav-link d-flex justify-content-between align-items-center" href="leave-requests.php">
    Leave Requests
    <?php if ($pending_leave_requests_count > 0): ?>
        <span class="badge bg-warning"><?php echo $pending_leave_requests_count; ?></span>
    <?php endif; ?>
    </a>
        <a class="nav-link" href="leave-types.php"> Leave Types</a>
        <a class="nav-link" href="departments.php"> Departments</a>
        <a class="nav-link" href="admins.php"> Admins</a>
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
            <div class="row">
                <div class="col-md-6" style="max-width: 30rem;">
                <div class="card text-white bg-info mb-3" style="max-width: 20rem;">
                        <div class="card-header">Number of Admins</div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $admin_count; ?></h5>
                            <p class="card-text">Number of Admins</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6" >
                    <h2 class="text-secondary">Add New Admin</h2>
                    <form action="add-admin.php"  method="post">
                        <div class="mb-3">
                            <label for="adminName" class="form-label">Admin Name</label>
                            <input type="text" class="form-control" id="adminName" name="adminName" required>
                        </div>
                        <div class="mb-3">
                            <label for="adminEmail" class="form-label">Admin Email</label>
                            <input type="email" class="form-control" id="adminEmail" name="adminEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="adminPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="adminPassword" name="adminPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Admin</button>
                    </form>
                </div>
            </div>

            <div class="mt-5">
                <h2 class="text-secondary">All Admins</h2>
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Admin ID</th>
                            <th>Admin Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $admin_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['A_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['A_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['A_email']); ?></td>
                            
                            <td>
                                <a href="edit-admin.php?A_id=<?php echo htmlspecialchars($row['A_id']); ?>" ><i class="fas fa-edit"></i></a>
                                <a href="admin-delete.php?A_id=<?php echo htmlspecialchars($row['A_id']); ?>" onclick="return confirm('Are you sure you want to delete this Admin?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
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