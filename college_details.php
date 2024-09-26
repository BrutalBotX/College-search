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
    <link rel="stylesheet" href="style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/Corpus_Christi_College_New_Court%2C_Cambridge%2C_UK_-_Diliff.jpg/1920px-Corpus_Christi_College_New_Court%2C_Cambridge%2C_UK_-_Diliff.jpg'); 
             background-size: cover; 
             background-position: center; 
             background-repeat: no-repeat; 
             height: 100vh; 
             margin: 0;">


   <!-- Modern Navbar -->
   <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">College Search</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="search.php?">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <?php if (isset($_SESSION['username'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?logout='1'">Logout</a>
                    </li>
                    <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

<div class="background-image" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/Corpus_Christi_College_New_Court%2C_Cambridge%2C_UK_-_Diliff.jpg/1920px-Corpus_Christi_College_New_Court%2C_Cambridge%2C_UK_-_Diliff.jpg'); background-size: cover; background-position: center;">
    <div class="container mt-4" style="border-radius: 10px; padding: 20px;">
        <div class="card shadow-lg">
            <div class="card-body">
                <h2 class="card-title"><?php echo $college['college_name']; ?></h2>
                <ul class="list-group mt-3">
                    <li class="list-group-item"><strong>University:</strong> <?php echo $college['university']; ?></li>
                    <li class="list-group-item"><strong>Genders Accepted:</strong> <?php echo $college['genders_accepted']; ?></li>
                    <li class="list-group-item"><strong>Campus Size:</strong> <?php echo ($college['campus_size'] == 0) ? '-' : $college['campus_size']; ?> Acres </li>
                    <li class="list-group-item"><strong>Total Student Enrollments:</strong> <?php echo $college['total_student_enrollments']; ?></li>
                    <li class="list-group-item"><strong>Total Faculty:</strong> <?php echo $college['total_faculty']; ?></li>
                    <li class="list-group-item"><strong>Established Year:</strong> <?php echo $college['established_year']; ?></li>
                    <li class="list-group-item"><strong>Rating:</strong> <?php echo ($college['rating'] == 0) ? '-' : $college['rating']; ?></li>
                    <li class="list-group-item"><strong>Courses:</strong> <?php echo nl2br($college['courses']); ?></li>
                    <li class="list-group-item"><strong>Facilities:</strong> <?php echo nl2br($college['facilities']); ?></li>
                    <li class="list-group-item"><strong>City:</strong> <?php echo $college['city']; ?></li>
                    <li class="list-group-item"><strong>State:</strong> <?php echo $college['state']; ?></li>
                    <li class="list-group-item"><strong>Country:</strong> <?php echo $college['country']; ?></li>
                    <li class="list-group-item"><strong>College Type:</strong> <?php echo $college['college_type']; ?></li>
                    <li class="list-group-item"><strong>Average Fees:</strong> <?php echo $college['average_fees']; ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

</body>
</html>