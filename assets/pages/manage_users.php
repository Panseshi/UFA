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

// Check if the connection is successful
if ($conn) {
    // SQL query to fetch all users
    $sql = "SELECT * FROM users";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        // Fetch data from the result set
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        // Display an error message if the query fails
        $users = [];
        echo "Error: " . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);
} else {
    // Display an error message if the connection fails
    echo "Error: Unable to connect to the database.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <base href="https://localhost/UFA/">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <main>
        <?php include 'navbar.php'; ?>
        <h1>Manage Users</h1>
        <div class="container">
            <!-- Display users in a table -->
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="mt-3">
                    <!-- PHP Loop to populate table rows -->
                    <?php foreach ($users as $user): ?>
                        <tr class="mt-3">
                            <td><?php echo $user['user_id']; ?></td>
                            <td><?php echo $user['user_login']; ?></td>
                            <td><?php echo $user['user_email']; ?></td>
                            <td><?php echo $user['role_id']; ?></td>
                            <td>
                                <a href="assets/pages/edit_user.php?id=<?php echo $user['user_id']; ?>">Edit</a>
                                <a href="assets/pages/delete_user.php?id=<?php echo $user['user_id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- "Go Back" button -->
            <a href="javascript:history.back()" class="btn btn-secondary">Go Back</a>
        </div>
    </main>
    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>