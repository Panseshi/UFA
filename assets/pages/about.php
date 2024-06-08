<!DOCTYPE html>
<html lang="en">
<head>
    <base href="https://localhost/UFA/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UFA Holidays - About Us</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/about.css">
</head>
<body>
    <!-- Navigation bar -->
    <?php 
    $current_page = basename($_SERVER['PHP_SELF']);
    include 'navbar.php'; ?>

    <!-- Hero section -->
    <div class="hero">
        <h1>About UFA Holidays</h1>
    </div>

    <!-- Main content -->
    <div class="container content-section">
        <div class="row">
            <div class="col-lg-6 mt-3">
                <h3>Our Story</h3>
                <p>Founded recently, UFA Holidays is a promising new startup in the travel industry, backed by a team of experienced and passionate professionals. Our vision is to revolutionize the way people experience travel by offering luxury travel services that are personalized to meet each client's unique needs and preferences.</p>
                <h3>Our Mission</h3>
                <p>Our mission is to provide exceptional, personalized service to luxury travelers. We aim to create bespoke travel experiences that cater to the diverse tastes and desires of our clients, ensuring every journey is memorable and extraordinary.</p>
                <h3>Why Choose Us?</h3>
                <ul>
                    <li>Experienced and knowledgeable travel experts specializing in luxury travel.</li>
                    <li>Customized travel packages tailored to your unique preferences and needs.</li>
                    <li>Access to exclusive deals and premium services.</li>
                    <li>24/7 customer support for a seamless travel experience.</li>
                    <li>Strong partnerships with top luxury hotels, airlines, and service providers.</li>
                </ul>
                <h3>Our Vision</h3>
                <p>At UFA Holidays, we see a world where travel is not just about visiting new places, but about creating unforgettable experiences that enrich your life. We are dedicated to bringing this vision to life through our commitment to excellence and innovation.</p>
            </div>
        </div>
    </div>
    
    <!-- Include the footer -->
    <?php include 'footer.php'; ?>

    <!-- Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
