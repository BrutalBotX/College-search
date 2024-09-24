<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>College Search</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Add custom styles here */
        .filter-section {
            display: none; /* Hide the filter section by default */
            margin-top: 20px;
        }
    </style>
    <script>
        function toggleFilters() {
            const filterSection = document.getElementById('filterSection');
            filterSection.style.display = filterSection.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <div class="header">
        <h2>Search for your College</h2>
    </div>
    
    <form method="get" action="search.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
            <label>College</label>
            <input type="text" name="search" class="form-control" required>
        </div>
        <div class="input-group">
            <button type="button" class="btn btn-primary" onclick="toggleFilters()">Toggle Filters</button>
        </div>

        <div class="filter-section" id="filterSection">
            <h5>Filters</h5>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="gender[]" value="male" id="male">
                <label class="form-check-label" for="male">Male Only</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="gender[]" value="female" id="female">
                <label class="form-check-label" for="female">Female Only</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="campus_size[]" value="small" id="small">
                <label class="form-check-label" for="small">Small Campus</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="campus_size[]" value="medium" id="medium">
                <label class="form-check-label" for="medium">Medium Campus</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="campus_size[]" value="large" id="large">
                <label class="form-check-label" for="large">Large Campus</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="college_type[]" value="public" id="public">
                <label class="form-check-label" for="public">Public College</label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="college_type[]" value="private" id="private">
                <label class="form-check-label" for="private">Private College</label>
            </div>
            <!-- Add more filters as needed -->
        </div>

        <div class="input-group">
            <button type="submit" class="btn btn-success" name="search_btn">Search</button>
        </div>
    </form>
</body>
</html>
