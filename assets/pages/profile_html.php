<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UFA Holidays - Profile</title>
    <base href="http://localhost/UFA/">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mt-4 mb-3">Profile</h2>
                <!-- Display user information -->
                <p><strong>Name:</strong> <?php echo htmlspecialchars($user_first_name . ' ' . $user_last_name); ?>
                </p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user_email); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user_phone); ?></p>
                <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user_date_of_birth); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user_login); ?></p>
                <!-- Logout button -->
                <a href="assets/pages/logout.php" class="btn btn-danger mt-3">Logout</a>
                <h3 class="mt-5">Your Reservations</h3>
                <!-- Display reservations -->
                <?php if (empty($reservations)): ?>
                    <p>You have no reservations.</p>
                <?php else: ?>
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Hotel Name</th>
                                <th>Room Number</th>
                                <th>Check-In</th>
                                <th>Check-Out</th>
                                <th>Total Price</th>
                                <th>Days of Stay</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $reservation): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($reservation['hotel_name']); ?></td>
                                    <td><?php echo htmlspecialchars($reservation['room_number']); ?></td>
                                    <td><?php echo htmlspecialchars($reservation['check_in']); ?></td>
                                    <td><?php echo htmlspecialchars($reservation['check_out']); ?></td>
                                    <td><?php echo htmlspecialchars($reservation['total_price']); ?></td>
                                    <td><?php echo htmlspecialchars($reservation['days_of_stay']); ?></td>
                                    <td>
                                        <!-- Delete reservation form -->
                                        <form action="assets/pages/delete_reservation.php" method="post"
                                            onsubmit="return confirm('Are you sure you want to delete this reservation?');">
                                            <input type="hidden" name="reservation_id"
                                                value="<?php echo $reservation['reservation_id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <h3 class="mt-5">Your Souvenir Purchases</h3>
                <!-- Display souvenir purchases -->
                <?php if (empty($purchases)): ?>
                    <p>You have no souvenir purchases.</p>
                <?php else: ?>
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Purchase ID</th>
                                <th>Purchase Date</th>
                                <th>Souvenir Name</th>
                                <th>Souvenir Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($purchases as $purchase): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($purchase['purchase_id']); ?></td>
                                    <td><?php echo htmlspecialchars($purchase['purchase_date']); ?></td>
                                    <td><?php echo htmlspecialchars($purchase['souvenir_name']); ?></td>
                                    <td><?php echo htmlspecialchars($purchase['souvenir_price']); ?></td>
                                    <td>
                                        <!-- Delete souvenir purchase form -->
                                        <form action="assets/pages/delete_purchase.php" method="post"
                                            onsubmit="return confirm('Are you sure you want to delete this souvenir purchase?');">
                                            <input type="hidden" name="purchase_id"
                                                value="<?php echo $purchase['purchase_id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
