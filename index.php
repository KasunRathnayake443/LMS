<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS</title>
    <link rel="stylesheet" href="source/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="source/css/e-login.css">
    <script src="source/js/load.js"></script>
</head>
<body>
    <div class="container" id="content">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mt-5">Leave Management System</h1> 
                <h3 class="text-center mt-3">Employee Login</h3>
                <form action="login.php" method="post" class="mt-3">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="row mb-4 rmber-area">
                        <div class="col-6">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                                <label class="form-check-label" for="rememberMe">Remember Me</label>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            <a href="password-recovery.php">Forgot Password?</a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <div class="form-footer text-center mt-5">
                        <p class="text-muted"><a href="Source/admin/admin-login.php">Go to Admin Panel</a></p>
                    </div>
                </form>
                <div class="mt-3">
                    <?php
                        if (isset($_GET['error'])) {
                            echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['error']) . '</div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>