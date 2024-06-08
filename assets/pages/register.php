<?php
session_start();
if (isset($_SESSION['user_id'])) {
    // Redirect logged-in users to the profile or dashboard page
    header("Location: profile.php");
    exit();
}

// Include database connection
include('db_connect.php');

// Define variables to store user input
$guest_first_name = $guest_last_name = $guest_email = $guest_phone = $guest_date_of_birth = $guest_username = $guest_password = '';
$guest_first_name_err = $guest_last_name_err = $guest_email_err = $guest_phone_err = $guest_date_of_birth_err = $guest_username_err = $guest_password_err = '';

// Helper function to sanitize and trim input data
function sanitize_input($data) {
    return trim(htmlspecialchars($data));
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate guest first name
    if (empty(sanitize_input($_POST["guest_first_name"]))) {
        $guest_first_name_err = "Please enter your first name.";
    } else {
        $guest_first_name = sanitize_input($_POST["guest_first_name"]);
    }

    // Validate guest last name
    if (empty(sanitize_input($_POST["guest_last_name"]))) {
        $guest_last_name_err = "Please enter your last name.";
    } else {
        $guest_last_name = sanitize_input($_POST["guest_last_name"]);
    }

    // Validate guest email
    if (empty(sanitize_input($_POST["guest_email"]))) {
        $guest_email_err = "Please enter your email.";
    } else {
        $guest_email = sanitize_input($_POST["guest_email"]);
    }

    // Validate guest phone number
    if (empty(sanitize_input($_POST["guest_phone"]))) {
        $guest_phone_err = "Please enter your phone number.";
    } else {
        $guest_phone = sanitize_input($_POST["guest_phone"]);
    }

    // Validate guest date of birth
    if (empty(sanitize_input($_POST["guest_date_of_birth"]))) {
        $guest_date_of_birth_err = "Please enter your date of birth.";
    } else {
        $guest_date_of_birth = sanitize_input($_POST["guest_date_of_birth"]);
    }

    // Validate guest username
    if (empty(sanitize_input($_POST["guest_username"]))) {
        $guest_username_err = "Please enter a username.";
    } else {
        $guest_username = sanitize_input($_POST["guest_username"]);

        // Check if guest username already exists
        $check_query = "SELECT * FROM users WHERE user_login = ?";
        $stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($stmt, "s", $guest_username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $guest_username_err = "This username is already taken.";
        }
        mysqli_stmt_close($stmt);
    }

    // Validate guest password
    if (empty(sanitize_input($_POST["guest_password"]))) {
        $guest_password_err = "Please enter a password.";
    } else {
        $guest_password = sanitize_input($_POST["guest_password"]);
    }

    // If no errors, insert into database
    if (empty($guest_first_name_err) && empty($guest_last_name_err) && empty($guest_email_err) && empty($guest_phone_err) &&
        empty($guest_date_of_birth_err) && empty($guest_username_err) && empty($guest_password_err)) {
        // Hash the guest password
        $hashed_guest_password = password_hash($guest_password, PASSWORD_DEFAULT);

        // Prepare SQL insert statement for guest registration
        $insert_query = "INSERT INTO users (user_first_name, user_last_name, user_email, user_phone, user_date_of_birth, user_login, user_password, role_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $insert_query);

        if ($stmt_insert) {
            $role_id = 3; // Role ID for guests
            mysqli_stmt_bind_param($stmt_insert, "sssssssi", $guest_first_name, $guest_last_name, $guest_email, $guest_phone, $guest_date_of_birth, $guest_username, $hashed_guest_password, $role_id);
            mysqli_stmt_execute($stmt_insert);

            if (mysqli_stmt_affected_rows($stmt_insert) > 0) {
                echo "<div class='alert alert-success' role='alert'>Registration successful! You can now login.</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error: Unable to register. Please try again later.</div>";
            }

            mysqli_stmt_close($stmt_insert);
        } else {
            echo "<div class='alert alert-danger' role='alert'>Database error: Unable to prepare statement.</div>";
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<base href="https://localhost/UFA/">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UFA Holidays - Registration</title>
<link rel="stylesheet" href="assets/css/styles.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-light bg-light">
    <div class="container">
    <a class="navbar-brand" href="#">
            <img src="assets/img/logo-small.png" alt="Logo">
            UNIQUE FIRST-CLASS ADVENTURES
        </a>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mt-4 mb-3">Guest Registration</h2>
            <!-- Register Form -->
            <form id="registerForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                    <label for="guest_first_name">First Name</label>
                    <input type="text" class="form-control" id="guest_first_name" name="guest_first_name" value="<?php echo $guest_first_name; ?>" required>
                    <span class="text-danger"><?php echo $guest_first_name_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="guest_last_name">Last Name</label>
                    <input type="text" class="form-control" id="guest_last_name" name="guest_last_name" value="<?php echo $guest_last_name; ?>" required>
                    <span class="text-danger"><?php echo $guest_last_name_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="guest_email">Email</label>
                    <input type="email" class="form-control" id="guest_email" name="guest_email" value="<?php echo $guest_email; ?>" required>
                    <span class="text-danger"><?php echo $guest_email_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="guest_phone">Phone</label>
                    <input type="text" class="form-control" id="guest_phone" name="guest_phone" value="<?php echo $guest_phone; ?>" required>
                    <span class="text-danger"><?php echo $guest_phone_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="guest_date_of_birth">Date of Birth</label>
                    <input type="date" class="form-control" id="guest_date_of_birth" name="guest_date_of_birth" value="<?php echo $guest_date_of_birth; ?>" required>
                    <span class="text-danger"><?php echo $guest_date_of_birth_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="guest_username">Username</label>
                    <input type="text" class="form-control" id="guest_username" name="guest_username" value="<?php echo $guest_username; ?>" required>
                    <span class="text-danger"><?php echo $guest_username_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="guest_password">Password</label>
                    <input type="password" class="form-control" id="guest_password" name="guest_password" required>
                    <span class="text-danger"><?php echo $guest_password_err; ?></span>
                </div>
                <button type="submit" class="btn btn-primary mt-3 mb-3">Register</button>
            </form>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
