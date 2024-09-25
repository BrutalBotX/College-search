<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>College Search</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/de4128e755.js" crossorigin="anonymous"></script>
    <style>
    body {
        background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/0/0f/Corpus_Christi_College_New_Court%2C_Cambridge%2C_UK_-_Diliff.jpg/1920px-Corpus_Christi_College_New_Court%2C_Cambridge%2C_UK_-_Diliff.jpg');
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat; 
        background-attachment: fixed; /* Make the background fixed */
        height: 100vh; 
        margin: 0;
        font-family: 'Arial', sans-serif;
    }
        /* Add custom styles here */
        .filter-section {
            display: none; /* Hide the filter section by default */
            margin-top: 20px;
        }
        
body {
  margin: 0;
  padding: 0;
  font-family: 'Arial', sans-serif;
}

.alert {
    padding: 15px;
    background-color: #f9f9f9;
    color: #333;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 20px;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
}

.card {
  background: rgba(255, 255, 255, 0.7); 
}

form {
    width: 60%;
}

.header {
    width: 60%;
    margin-top: 100px;
}

input {
  width: 90%;
  height: 50px;
  background: transparent;
  border: 0;
  outline: 0;
  font-size: 18px;
  color: #333;
  margin-left: 40px;
}

button {
  background: transparent;
  border: 0px;
  outline: 0px;
}

.form-check-label {
    vertical-align: middle; 
    margin-left: 5px; 
    margin-top: 18px;
}

.form-control {
  width: 90%;
  border: none;
}

button .fa-solid {
  width: 25px;
  color: #555;
  font-size: 22px;
  cursor: pointer;
  margin-left: 5px;
}

.result-box ul {
  border-top: 1px solid #999;
  padding: 15px 10px;
}

.result-box ul li {
  list-style: none;
  border-radius: 3px;
  padding: 15px 10px;
}
.result-box ul li:hover {
    background: #e9f3ff;
}
.result-box {
    max-height: 300px;
    overflow-y: scroll;
}

.notification-container {
    margin-top: auto; /* Push to the bottom */
    padding: 10px; /* Optional padding */
}

.alert {
    margin-bottom: 10px; /* Space between alerts */
}

.card-light-gray {
    background-color: #9baead; /* Light gray background */
}

.card-alternate-color {
    background-color: #fbe9d0; /* Change to desired alternate color, e.g., Alice Blue */
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

    <div class="header">
        <h2>Search for your College</h2>
    </div>
    
    <form method="get" action="search.php">
        <?php include('errors.php'); ?>
        <div class="search-box">
    <div class="row">
        <input type="text" name="search" class="form-control" placeholder="Search for Colleges" autocomplete="off" required>
        <button><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>
    
</div>


        <div class="input-group">
            <button type="button" class="btn btn-primary" onclick="toggleFilters()">Toggle Filters</button>
        </div>

        <div class="filter-section" id="filterSection">
            <h5>Filters</h5>

            <!-- Gender Filters (Collapsible) -->
            <div class="card mt-3">
                <div class="card-header">
                    <a class="btn btn-link" data-toggle="collapse" href="#collapseGender" aria-expanded="false">
                        Gender Filters
                    </a>
                </div>
                <div id="collapseGender" class="collapse">
                    <div class="card-body">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="genders_accepted[]" value="Male" id="Male">
                            <label class="form-check-label" for="Male">Male Only</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="genders_accepted[]" value="Female" id="Female">
                            <label class="form-check-label" for="Female">Female Only</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="genders_accepted[]" value="Co-Ed" id="Co-Ed">
                            <label class="form-check-label" for="Co-Ed">Co-Ed</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- College Type Filters (Collapsible) -->
            <div class="card mt-3">
                <div class="card-header">
                    <a class="btn btn-link" data-toggle="collapse" href="#collapseCollegeType" aria-expanded="false">
                        College Type
                    </a>
                </div>
                <div id="collapseCollegeType" class="collapse">
                    <div class="card-body">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="college_type[]" value="public" id="public">
                            <label class="form-check-label" for="public">Public College</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="college_type[]" value="private" id="private"> <!-- Fixed value -->
                            <label class="form-check-label" for="private">Private College</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fees Slider (Collapsible) -->
            <div class="card mt-3">
                <div class="card-header">
                    <a class="btn btn-link" data-toggle="collapse" href="#collapseFees" aria-expanded="false">
                        Fees Range
                    </a>
                </div>
                <div id="collapseFees" class="collapse">
                    <div class="card-body">
                        <label for="feesRange">Fees Range:</label>
                        <input type="range" class="form-range" id="feesRange" name="fees_range" min="0" max="1000000" step="10000"
                            oninput="this.nextElementSibling.value = this.value">
                        <output>500000</output> <!-- Default output value -->
                    </div>
                </div>
            </div>

            <!-- Facilities Checkboxes (Collapsible) -->
            <div class="card mt-3">
                <div class="card-header">
                    <a class="btn btn-link" data-toggle="collapse" href="#collapseFacilities" aria-expanded="false">
                        Facilities
                    </a>
                </div>
                <div id="collapseFacilities" class="collapse">
                    <div class="card-body">
                        <?php 
                        $facilities = ['Library', 'Hostel', 'Cafeteria', 'Sports', 'Laboratories', 'Wifi', 'Transportation', 'Gym', 'Auditorium', 'Medical Facilities', 'Banks', 'Parking', 'Guest Room'];
                        foreach ($facilities as $facility): ?>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="facilities[]" value="<?php echo $facility; ?>" id="<?php echo $facility; ?>">
                            <label class="form-check-label" for="<?php echo $facility; ?>"><?php echo $facility; ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Dropdown for Indian States (Collapsible) -->
            <div class="card mt-3">
                <div class="card-header">
                    <a class="btn btn-link" data-toggle="collapse" href="#collapseState" aria-expanded="false">
                        Select State
                    </a>
                </div>
                <div id="collapseState" class="collapse">
                    <div class="card-body">
                        <label for="stateSelect">Select State:</label>
                        <select class="form-select" id="stateSelect" name="state">
                            <option value="">Choose a state...</option>
                            <?php 
                            $states = ['Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 
                                    'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand',
                                    'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 
                                    'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 
                                    'Odisha', 'Punjab', 'Rajasthan', 'Sikkim',
                                    'Tamil Nadu', 'Telangana', 'Tripura', 
                                    'Uttar Pradesh', 'Uttarakhand', 
                                    'West Bengal'];
                            foreach ($states as $state): ?>
                                <option value="<?php echo $state; ?>"><?php echo $state; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Search Box for Courses with Autocomplete -->
            <br>
            <div class="search-box">
                <div class="row">
                    <input type="text" name="course" id="input-box" placeholder="Search for courses" autocomplete="off">
                    <button><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>

                <div class="result-box">
                </div>
            </div>

        </div> <!-- End of filter-section -->

        <div class="input-group">
            <button type="submit" class="btn btn-success" name="search_btn">Search</button>
        </div>
    </form>


    <div class="notification-container">
    <!-- Notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="alert alert-success">
            <strong>Success!</strong> 
            <?php 
                echo $_SESSION['success']; 
                unset($_SESSION['success']);
            ?>
        </div>
    <?php endif ?>

    <!-- Logged in user information -->
    <?php if (isset($_SESSION['username'])) : ?>
        <div class="alert alert-info">
            You're logged in as <strong><?php echo $_SESSION['username']; ?></strong>
            <a href="index.php?logout='1'" class="btn btn-danger btn-sm">Logout</a>
        </div>
    <?php endif ?>
</div>



<!-- Include Bootstrap JS for dismissible alerts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="courses.js"></script>
</body>
</html>
