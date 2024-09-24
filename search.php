<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>College Search</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Search for your College</h2>
  </div>
	 
  <form method="get" action="search.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>College</label>
  		<input type="text" name="search" >
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="search_btn">Search</button>
  	</div>
  </form>
</body>
</html>