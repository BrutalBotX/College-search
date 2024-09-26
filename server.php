<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'college');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: search.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: search.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

// SEARCH COLLEGES
/*if (isset($_GET["search"])) { 
  $search = mysqli_real_escape_string($db, $_GET["search"]);
  
  $query = "SELECT * FROM college WHERE college_name LIKE '%$search%' OR university LIKE '%$search%'" ;
  $result = mysqli_query($db, $query);
  
  $result_check = mysqli_num_rows($result);

  if ($result_check > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      echo $row['college_name'] . "<br>";
    }
  } else {
    echo "No colleges found matching your search.";
  }
}*/
// SEARCH COLLEGES WITH PAGINATION
if (isset($_GET["search"])) {
  $search = mysqli_real_escape_string($db, $_GET["search"]);
  $gender = isset($_GET['gender']) ? $_GET['gender'] : [];
  $campus_size = isset($_GET['campus_size']) ? $_GET['campus_size'] : [];
  $college_type = isset($_GET['college_type']) ? $_GET['college_type'] : [];
  $college_type = isset($_GET['college_type']) ? $_GET['college_type'] : [];
  $fees_range = isset($_GET['fees_range']) ? (int)$_GET['fees_range'] : null; // Get fees range
  $selected_facilities = isset($_GET['facilities']) ? $_GET['facilities'] : []; // Get facilities
  $selected_state = isset($_GET['state']) ? mysqli_real_escape_string($db, $_GET['state']) : null; // Get selected state
  $course = mysqli_real_escape_string($db, $_GET["course"]);


  // Pagination variables
  $results_per_page = 12; // Limit the number of results per page
  $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
  $offset = ($current_page - 1) * $results_per_page;

  // Base query
  $query = "SELECT * FROM college WHERE (college_name LIKE '%$search%' OR university LIKE '%$search%')";


  if (!empty($course)) {
    $query .= " AND courses LIKE '%$course%' ";
  }

  // Add gender filter
  if (!empty($gender)) {
      $gender_filter = implode("','", $gender);
      $query .= " AND genders_accepted IN ('$gender_filter')";
  }

  // Add college type filter
  if (!empty($college_type)) {
      $type_filter = implode("','", $college_type);
      $query .= " AND college_type IN ('$type_filter')";
  }

   // Add fees range filter
   if ($fees_range !== null) {
    $query .= " AND average_fees <= $fees_range"; // Assuming 'fees' is the column name in your database
}

// Add state filter
if ($selected_state) {
    $query .= " AND state = '$selected_state'"; // Assuming 'state' is the column name in your database
}

// Add facilities filter
if (!empty($selected_facilities)) {
  $facility_conditions = [];
  foreach ($selected_facilities as $facility) {
      $facility_conditions[] = "facilities LIKE '%" . mysqli_real_escape_string($db, $facility) . "%'";
  }
  $query .= " AND (" . implode(" OR ", $facility_conditions) . ")";
}
  // Get total number of results before pagination
  $result = mysqli_query($db, $query);
  if (!$result) {
    die("Database query failed: " . mysqli_error($db)); // Error handling
}
  $total_results = mysqli_num_rows($result);

  // Modify query to limit the results based on the current page
  $query .= " LIMIT $offset, $results_per_page";

  $result = mysqli_query($db, $query);
  if (!$result) {
    die("Database query failed: " . mysqli_error($db)); // Error handling
}
  $result_check = mysqli_num_rows($result);

  if ($result_check > 0) {
    echo "<div class='container mt-4'>";
    echo "<div class='row' style='margin-top: 100px;'>";
    
    $index = 0; // Initialize index
    while ($row = mysqli_fetch_assoc($result)) {
        // Determine the background color class based on index
        $bg_class = $index % 2 == 0 ? 'card-light-gray' : 'card-alternate-color'; // Alternate classes
    
        echo "<div class='col-md-3 mb-4 d-flex align-items-stretch'>"; // Equal-sized cards with flexbox
        echo "<a href='college_details.php?college_name=" . urlencode($row['college_name']) . "' class='card text-center $bg_class' style='min-width: 200px; min-height: 200px; text-decoration: none; color: inherit;'>"; // Link to college_details.php
        echo "<div class='card-body d-flex flex-column justify-content-center'>"; // Center content vertically
        echo "<h4 class='card-title'>" . $row['college_name'] . "</h4>"; // Use h4 for title
        echo "<p class='card-text'><strong>University:</strong> " . $row['university'] . "</p>";
        echo "<p class='card-text'><strong>City:</strong> " . $row['city'] . "</p>";
        echo "</div>"; // card-body
        echo "</a>"; // Closing anchor tag
        echo "</div>";
    
        $index++; // Increment index for next iteration
    }
    
    echo "</div>"; // row
    echo "</div>";

// Pagination navigation
$total_pages = ceil($total_results / $results_per_page);
$visible_pages = 5; // Number of page links to show around the current page

if ($total_pages > 1) {
    echo "<nav aria-label='Page navigation'>";
    echo "<ul class='pagination justify-content-center mt-4'>";

    // Previous button
    if ($current_page > 1) {
        $prev_page = $current_page - 1;
        echo "<li class='page-item'><a class='page-link' href='?search=$search&page=$prev_page'>Previous</a></li>";
    }

    // Determine the range of pages to show
    $start_page = max(1, $current_page - floor($visible_pages / 2));
    $end_page = min($total_pages, $current_page + floor($visible_pages / 2));

    // Ensure that there are always $visible_pages shown, adjusting start and end if necessary
    if ($current_page < ceil($visible_pages / 2)) {
        $end_page = min($total_pages, $visible_pages);
    } elseif ($current_page > $total_pages - floor($visible_pages / 2)) {
        $start_page = max(1, $total_pages - $visible_pages + 1);
    }

    // First page button
    if ($start_page > 1) {
        echo "<li class='page-item'><a class='page-link' href='?search=$search&page=1'>1</a></li>";
        if ($start_page > 2) {
            echo "<li class='page-item disabled'><span class='page-link'>...</span></li>"; // Dots for gap
        }
    }

    // Page numbers
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $current_page) {
            echo "<li class='page-item active'><a class='page-link' href='?search=$search&page=$i'>$i</a></li>";
        } else {
            echo "<li class='page-item'><a class='page-link' href='?search=$search&page=$i'>$i</a></li>";
        }
    }

    // Last page button
    if ($end_page < $total_pages) {
        if ($end_page < $total_pages - 1) {
            echo "<li class='page-item disabled'><span class='page-link'>...</span></li>"; // Dots for gap
        }
        echo "<li class='page-item'><a class='page-link' href='?search=$search&page=$total_pages'>$total_pages</a></li>";
    }

    // Next button
    if ($current_page < $total_pages) {
        $next_page = $current_page + 1;
        echo "<li class='page-item'><a class='page-link' href='?search=$search&page=$next_page'>Next</a></li>";
    }

    echo "</ul>";
    echo "</nav>";
}
  } else {
      echo "<div class='alert alert-warning' role='alert'>No colleges found matching your search.</div>";
  }
}