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
  	header('location: index.php');
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
  	  header('location: index.php');
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
// SEARCH COLLEGES
if (isset($_GET["search"])) { 
  $search = mysqli_real_escape_string($db, $_GET["search"]);
  $gender = isset($_GET['gender']) ? $_GET['gender'] : [];
  $campus_size = isset($_GET['campus_size']) ? $_GET['campus_size'] : [];
  $college_type = isset($_GET['college_type']) ? $_GET['college_type'] : [];

  // Base query
  $query = "SELECT * FROM college WHERE (college_name LIKE '%$search%' OR university LIKE '%$search%')";

  // Add gender filter
  if (!empty($gender)) {
      $gender_filter = implode("','", $gender);
      $query .= " AND genders_accepted IN ('$gender_filter')";
  }

  // Add campus size filter
  if (!empty($campus_size)) {
      $size_filter = implode("','", $campus_size);
      $query .= " AND campus_size IN ('$size_filter')";
  }

  // Add college type filter
  if (!empty($college_type)) {
      $type_filter = implode("','", $college_type);
      $query .= " AND college_type IN ('$type_filter')";
  }

  $result = mysqli_query($db, $query);
  $result_check = mysqli_num_rows($result);

  if ($result_check > 0) {
    echo "<div class='container mt-4'>";
    echo "<div class='row'>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        // Wrap the entire card in an anchor tag
        echo "<div class='col-md-3 mb-4 d-flex align-items-stretch'>"; // Equal-sized cards with flexbox
        echo "<a href='college_details.php?college_name=" . urlencode($row['college_name']) . "' class='card text-center' style='min-width: 200px; min-height: 200px; text-decoration: none; color: inherit;'>"; // Link to college_details.php
        echo "<div class='card-body d-flex flex-column justify-content-center'>"; // Center content vertically
        echo "<h4 class='card-title'>" . $row['college_name'] . "</h4>"; // Use h4 for title
        echo "<p class='card-text'><strong>University:</strong> " . $row['university'] . "</p>";
        echo "<p class='card-text'><strong>City:</strong> " . $row['city'] . "</p>";
        echo "</div>"; // card-body
        echo "</a>"; // Closing anchor tag
        echo "</div>"; // col-md-3
    }
    
    echo "</div>"; // row
    echo "</div>"; // container
  } else {
      echo "<div class='alert alert-warning' role='alert'>No colleges found matching your search.</div>";
  }
}



?>