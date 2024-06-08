$(document).ready(function() {
    // Search form functionality
    $('#searchBtn').click(function() {
        var $btn = $(this);
        $btn.prop('disabled', true).text('Searching...');
        
        var formData = $('#searchForm').serialize();
        $.ajax({
            url: 'search.php',
            type: 'POST',
            data: formData,
            success: function(data) {
                $('#results').html(data);
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error.message);
            },
            complete: function() {
                $btn.prop('disabled', false).text('Search Hotels');
            }
        });
    });

    // Other custom JavaScript functionalities
    // Add your custom scripts here as needed
});
