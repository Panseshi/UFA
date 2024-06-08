<?php
// Include database connection
include 'db_connect.php';

// Fetch hotel types from the database
$query = "SELECT DISTINCT hotel_type FROM hotels";
$result = mysqli_query($conn, $query);

// Check if there are hotel types available
if (mysqli_num_rows($result) > 0) {
    // Output data of each row as options for the select dropdown
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['hotel_type'] . "'>" . $row['hotel_type'] . "</option>";
    }
} else {
    echo "<option value=''>No hotel types available</option>";
}

// Close database connection
mysqli_close($conn);
?>
