<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UFA Holidays - Search</title>
</head>
<body>
<form id="searchForm" class="form-inline justify-content-center mt-3" action="assets/pages/search.php" method="POST">
                <select name="holiday-type" class="form-control mb-2 mr-sm-2" aria-label="Holiday Type" required>
                    <option value="" selected disabled>Holiday Type</option>
                    <option value="honeymoon">Honeymoon</option>
                    <option value="diving">Diving</option>
                    <option value="luxury">Luxury</option>
                    <option value="spa">Spa</option>
                    <option value="family">Family</option>
                    <option value="budget">Budget</option>
                    <option value="safari">Safari</option>
                    <option value="surfing">Surfing</option>
                    <option value="all-inclusive">All Inclusive</option>
                    <option value="lifestyle">Lifestyle</option>
                    <option value="laid-back">Laid Back</option>
                    <option value="adults-only">Adults Only</option>
                    <option value="big">Big Resorts</option>
                    <option value="small">Small Resorts</option>
                </select>
                <select name="distance" class="form-control mb-2 mr-sm-2" aria-label="Distance from Male' Airport" required>
                    <option value="" selected disabled>Distance from Male' Airport</option>
                    <option value="0-20">&lt;20km</option>
                    <option value="20-50">20km to 50km</option>
                    <option value="50-100">50km to 100km</option>
                    <option value="100-200">100km to 200km</option>
                    <option value="200-300">200km to 300km</option>
                    <option value="300+">&gt;300km</option>
                </select>
                <input type="date" name="check_in" class="form-control mb-2 mr-sm-2" placeholder="Check-in" aria-label="Check-in Date" required>
                <input type="date" name="check_out" class="form-control mb-2 mr-sm-2" placeholder="Check-out" aria-label="Check-out Date" required>
                <button type="submit" class="btn btn-primary mb-2">Search Hotels</button>
            </form>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const form = document.getElementById('searchForm');

                    form.addEventListener('submit', function (event) {
                        event.preventDefault();  // Prevent default form submission
                        const formData = new FormData(form);

                        fetch(form.action, {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text();
                        })
                        .then(data => {
                            document.getElementById('results').innerHTML = data;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            document.getElementById('results').innerHTML = '<p>An error occurred while searching. Please try again later.</p>';
                        });
                    });
                });
            </script>
</body>
</html>