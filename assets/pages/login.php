<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    // Assuming $_SESSION['role_id'] holds the user's role
    if ($_SESSION['role_id'] == 1) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        header("Location: profile.php");
        exit();
    }
}

// Include env setup
include __DIR__ . '/../../env_setup.php';

// Include database connection
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL query to fetch user data
    $query = "SELECT user_id, user_password, role_id FROM users WHERE user_login = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_id, $hashed_password, $role_id);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, start a session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['role_id'] = $role_id;  // Save the user's role in the session

            // Redirect based on role
            if ($role_id == 1) {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: profile.php");
            }
            exit();
        } else {
            // Invalid credentials
            $_SESSION['error'] = "Invalid username or password.";
            header("Location: login.php");
            exit();
        }
    } else {
        // Failed to prepare the statement
        $_SESSION['error'] = "Database error: Unable to prepare statement.";
        header("Location: login.php");
        exit();
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UFA Holidays - Login</title>
<base href="http://localhost/UFA/">
<link rel="stylesheet" href="assets/css/styles.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php include 'navbar.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mt-4 mb-3">Login</h2>
            <!-- Login Form -->
            <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3 mb-3">Login</button>
            </form>

            <!-- Sign up link -->
            <p class="mt-3">Don't have an account? <a href="assets/pages/register.php">Sign up now</a></p>

            <?php
            if (isset($_SESSION['error'])) {
                echo "<div class='alert alert-danger' role='alert'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
            }
            ?>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
