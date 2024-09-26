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
            background-attachment: fixed;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        

        .about-section {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 50px;
            margin: 100px auto;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            font-size: 1.2rem;
            line-height: 1.6;
            color: #555;
        }

        .container {
            margin-top: 0px;
        }

  
</style>

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
    <div class="container">
        <div class="about-section">
            <h1>About Us</h1>
            <p>
                Welcome to my college search platform! The primary goal of this site is to provide students with comprehensive information 
                about colleges and universities so that they can make informed decisions.
            </p>
            <p>
                We believe that every student deserves the opportunity to explore their options and find a college that 
                best suits their needs. Whether you're searching for information on admission, facilities, or campus life, 
                this site is here to help.
            </p>
            <p>
                This platform gets the dataset of the colleges from
                <a href="https://www.kaggle.com/datasets/shrirangmhalgi/engineering-colleges-in-india"> Kaggle. </a> </p>
                <p>So, thank you for making the dataset available publically and giving this site a chance to be born. </p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>
