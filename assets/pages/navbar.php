<?php
// Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}

// Include environment setup
require_once __DIR__ . '/../../env_setup.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <!-- Font link for Montserrat Thin -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom styles -->
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container container-no-margin">
        <a class="navbar-brand bg-dark" href="#">
            <img src="<?php echo ASSETS_PATH; ?>img/logo.png" alt="Logo">
            <span class="brand-name text-light">UFA</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Use PHP to dynamically set active class for each navbar item -->
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' || basename($_SERVER['PHP_SELF']) == '') ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo BASE_URL; ?>index.php">Home</a>
                </li>
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'offers.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo PAGES_PATH; ?>offers.php">Offers</a>
                </li>
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'services.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo PAGES_PATH; ?>services.php">Services</a>
                </li>
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'souvenir.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo PAGES_PATH; ?>souvenir.php">Souvenir</a>
                </li>
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo PAGES_PATH; ?>about.php">About</a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role_id'] === 1): // Admin ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo PAGES_PATH; ?>admin_dashboard.php">Dashboard</a>
                        </li>
                    <?php else: // Regular user ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo PAGES_PATH; ?>profile.php">Profile</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="btn btn-danger nav-btn nav-btn-login" href="<?php echo PAGES_PATH; ?>logout.php">Sign Out</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary nav-btn nav-btn-login" href="<?php echo PAGES_PATH; ?>login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
