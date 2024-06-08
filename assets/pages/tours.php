<?php
// Include your database connection file here
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Tours Page</title>
    <base href="https://localhost/UFA/">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
    </style>
</head>
<body>
    <header>
        <h1>Explore Our Tours</h1>
    </header>
    <main>
    <?php include 'navbar.php'; ?>
        <div class="tour-container">
            <!-- PHP code to display tours data -->
            <!-- Use PHP echo statements to output tour details -->
            <?php
            include 'db_connect.php';

            if ($conn) {
                $sql = "SELECT * FROM tour_types";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="tour-item">';
                        echo '<h2>' . $row['type_name'] . '</h2>';
                        echo '<p>Price: $' . $row['base_price'] . '</p>';
                        echo '<p>Duration: ' . $row['type_duration'] . ' hours</p>';
                        echo '<img src="' . $row['type_image'] . '" alt="' . $row['type_name'] . '" class="tour-image">';
                        echo '</div>';
                    }
                } else {
                    echo "No tours available.";
                }

                mysqli_close($conn);
            } else {
                echo "Error: Unable to connect to the database.";
            }
            ?>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>