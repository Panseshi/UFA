<?php
// Include database connection or any other necessary files
include 'db_connect.php';

// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required form fields are set and not empty
    if (
        isset($_POST["holiday_type"]) && is_array($_POST["holiday_type"]) &&
        isset($_POST["distance"]) && !empty($_POST["distance"]) &&
        isset($_POST["check_in"]) && !empty($_POST["check_in"]) &&
        isset($_POST["check_out"]) && !empty($_POST["check_out"])
    ) {
        // Sanitize and validate form data
        $holidayTypes = array_map('intval', $_POST["holiday_type"]); // Assuming holiday_type is an array of integers
        $distance = filter_input(INPUT_POST, "distance", FILTER_SANITIZE_STRING);
        $checkIn = filter_input(INPUT_POST, "check_in", FILTER_SANITIZE_STRING);
        $checkOut = filter_input(INPUT_POST, "check_out", FILTER_SANITIZE_STRING);

        // Prepare the SQL query with placeholders for multiple holiday types
        $placeholders = implode(',', array_fill(0, count($holidayTypes), '?'));
        $sql = "SELECT DISTINCT h.* FROM hotels h 
                INNER JOIN hotel_holiday_types ht ON h.hotel_id = ht.hotel_id
                WHERE ht.type_id IN ($placeholders)
                AND h.hotel_distance >= ? AND h.hotel_distance <= ?
                AND NOT EXISTS (
                    SELECT 1 FROM reservations r
                    WHERE r.hotel_id = h.hotel_id
                    AND (
                        (r.check_in_date <= ? AND r.check_out_date >= ?)
                        OR (r.check_in_date <= ? AND r.check_out_date >= ?)
                        OR (r.check_in_date >= ? AND r.check_out_date <= ?)
                    )
                )";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Set distance ranges based on the selected option
            switch ($distance) {
                case "0-20":
                    $distanceMin = 0;
                    $distanceMax = 20;
                    break;
                case "20-50":
                    $distanceMin = 20;
                    $distanceMax = 50;
                    break;
                // Add cases for other distance ranges as needed
                default:
                    // Handle default case or invalid range
                    break;
            }

            // Bind parameters for holiday types and distances
            $typesString = str_repeat('i', count($holidayTypes)) . 'iiiiiiii';
            $bindParams = array_merge([$typesString], $holidayTypes, [$distanceMin, $distanceMax, $checkIn, $checkOut, $checkIn, $checkOut, $checkIn, $checkOut]);
            $stmt->bind_param(...$bindParams);
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            // Prepare the modal content
            $modalContent = '<div class="row">';
            while ($row = $result->fetch_assoc()) {
                $modalContent .= '<div class="col-md-4">';
                $modalContent .= '<div class="card">';
                $modalContent .= '<img src="' . htmlspecialchars($row['hotel_image']) . '" class="card-img-top" alt="' . htmlspecialchars($row['hotel_name']) . '">';
                $modalContent .= '<div class="card-body">';
                $modalContent .= '<h5 class="card-title">' . htmlspecialchars($row['hotel_name']) . '</h5>';
                $modalContent .= '<p class="card-text">' . htmlspecialchars($row['hotel_description']) . '</p>';
                $modalContent .= '</div></div></div>';
            }
            $modalContent .= '</div>';

            // Close the statement
            $stmt->close();

            // Output the modal content (HTML) to be displayed in the modal
            echo $modalContent;
        } else {
            // Handle prepare statement error
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        // Handle if any required form field is missing
        echo "All form fields are required.";
    }
} else {
    // Handle if the form was not submitted using POST method
    echo "Form submission method not allowed.";
}
?>
