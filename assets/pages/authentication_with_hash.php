<?php
session_start();

// Include database connection
include('../../assets/pages/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // No need to escape, will be hashed

    $sql = "SELECT * FROM login WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Verify hashed password
            if (password_verify($password, $row['password'])) {
                // Password is correct, set session and redirect
                $_SESSION['login_user'] = $username;
                mysqli_stmt_close($stmt);
                header("Location: ../../assets/pages/welcome.php");
                exit(); // Stop script execution after redirect
            } else {
                echo "<h1>Login failed. Invalid username or password.</h1>";
            }
        } else {
            echo "<h1>Login failed. User not found.</h1>";
        }
    } else {
        echo "<h1>Error in SQL statement.</h1>";
    }
    mysqli_close($conn);
}
?>
