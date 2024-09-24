<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'college');

// Check if college_name is set in the URL
if (isset($_GET['college_name'])) {
    $college_name = mysqli_real_escape_string($db, $_GET['college_name']);
    
    // Query the database for full details of the selected college
    $query = "SELECT * FROM college WHERE college_name = '$college_name'";
    $result = mysqli_query($db, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $college = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='alert alert-danger'>No details found for this college.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>No college selected.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <title>College Details</title>
</head>
<body>
    <div class="container mt-4">
        <h2><?php echo $college['college_name']; ?></h2>
        <ul class="list-group mt-3">
            <li class="list-group-item"><strong>University:</strong> <?php echo $college['university']; ?></li>
            <li class="list-group-item"><strong>Genders Accepted:</strong> <?php echo $college['genders_accepted']; ?></li>
            <li class="list-group-item"><strong>Campus Size:</strong> <?php echo $college['campus_size']; ?></li>
            <li class="list-group-item"><strong>Total Student Enrollments:</strong> <?php echo $college['total_student_enrollments']; ?></li>
            <li class="list-group-item"><strong>Total Faculty:</strong> <?php echo $college['total_faculty']; ?></li>
            <li class="list-group-item"><strong>Established Year:</strong> <?php echo $college['established_year']; ?></li>
            <li class="list-group-item"><strong>Rating:</strong> <?php echo $college['rating']; ?></li>
            <li class="list-group-item"><strong>Courses:</strong> <?php echo nl2br($college['courses']); ?></li>
            <li class="list-group-item"><strong>Facilities:</strong> <?php echo nl2br($college['facilities']); ?></li>
            <li class="list-group-item"><strong>City:</strong> <?php echo $college['city']; ?></li>
            <li class="list-group-item"><strong>State:</strong> <?php echo $college['state']; ?></li>
            <li class="list-group-item"><strong>Country:</strong> <?php echo $college['country']; ?></li>
            <li class="list-group-item"><strong>College Type:</strong> <?php echo $college['college_type']; ?></li>
            <li class="list-group-item"><strong>Average Fees:</strong> <?php echo $college['average_fees']; ?></li>
        </ul>
    </div>
</body>
</html>
