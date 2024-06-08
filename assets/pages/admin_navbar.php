<?php
if (!isset($_SESSION)) {
    session_start();
}

// Include env setup
require_once __DIR__ . '/../../env_setup.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Navbar</title>
<base href="http://localhost/UFA/"> <!-- Set the base URL -->
<link rel="stylesheet" href="assets/css/styles.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand bg-dark" href="#">
            <img src="<?php echo ASSETS_PATH; ?>img/logo.png" alt="Logo">
            <span class="text-light">UFA - Admin</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user_id']) && $_SESSION['role_id'] === 1): // Check if user is admin ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PAGES_PATH; ?>admin_dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PAGES_PATH; ?>manage_hotels.php">Hotels</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PAGES_PATH; ?>manage_users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PAGES_PATH; ?>manage_tours.php">Tours</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo PAGES_PATH; ?>manage_souvenirs.php">Souvenir</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger nav-btn nav-btn-login" href="<?php echo PAGES_PATH; ?>logout.php">Sign Out</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
