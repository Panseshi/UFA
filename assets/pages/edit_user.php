<?php
// Include your database connection file here
include 'db_connect.php';

// Check if the user is logged in and has admin privileges
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] !== 1) {
    // Redirect to login page or unauthorized access page
    header("Location: login.php");
    exit();
}

// Check if user ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: manage_users.php"); // Redirect if ID is not provided
    exit();
}

// Get the user ID from the URL
$user_id = $_GET['id'];

// Fetch user data based on the user ID
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Redirect if user not found
    header("Location: manage_users.php");
    exit();
}

// Handle form submission for updating user information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date_of_birth = $_POST['date_of_birth'];
    $role_id = $_POST['role_id'];

    // Update user information in the database
    $update_sql = "UPDATE users SET user_first_name = '$first_name', user_last_name = '$last_name', user_email = '$email', user_phone = '$phone', user_date_of_birth = '$date_of_birth', role_id = '$role_id' WHERE user_id = $user_id";
    if (mysqli_query($conn, $update_sql)) {
        // Redirect to manage_users.php after successful update
        header("Location: manage_users.php");
        exit();
    } else {
        // Handle update failure
        $update_error = "Error updating user information: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <base href="http://localhost/UFA/">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/admin_dashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>
    <div class="container">
        <h1>Edit User</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $user_id); ?>">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $user['user_first_name']; ?>" required><br>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $user['user_last_name']; ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['user_email']; ?>" required><br>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $user['user_phone']; ?>"><br>

            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $user['user_date_of_birth']; ?>"><br>

            <label for="role_id">Role:</label>
            <select id="role_id" name="role_id">
                <option value="1" <?php echo ($user['role_id'] == 1) ? 'selected' : ''; ?>>Admin</option>
                <option value="2" <?php echo ($user['role_id'] == 2) ? 'selected' : ''; ?>>User</option>
            </select><br>

            <input type="submit" value="Update">
        </form>
        <a href="assets/pages/manage_users.php" class="btn btn-secondary">Go Back</a>
        <?php
        if (isset($update_error)) {
            echo "<p class='error'>$update_error</p>";
        }
        ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
