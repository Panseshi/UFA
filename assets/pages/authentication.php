<?php
// Include database connection
include('../../assets/pages/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the username and password match in the database
    $sql = "SELECT * FROM login WHERE login_username = '$username' AND login_password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Username and password matched, redirect to welcome page
        header("Location: ../../assets/pages/welcome.php");
        exit(); // Stop script execution after redirect
    } else {
        echo "<h1>Login failed. Invalid username or password.</h1>";
    }

    mysqli_close($conn);
}
?>
