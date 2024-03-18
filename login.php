<?php
session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
        $pdo = new PDO("mysql:host=localhost;dbname=exam", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Authentication successful, set session variables
			$_SESSION['email'] = $email;
            $_SESSION['name'] = $user['name']; 
            // Redirect to a home page or some other secure location
            header("Location:/login/exam1/home.php");
            exit();
        } else {
            // Authentication failed, display an error message
            echo "Invalid email or password. Please try again.";
        }
}
?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" type="jpg"  href="https://www.negros-occ.gov.ph/wp-content/uploads/2019/12/CPSU-LOGO.jpg" >
	<style>
		/* Reset some default styles */
* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    overflow: hidden;
}

/* Styles for the wave image */
.wave {
    position: fixed;
    bottom: 0;
    left: 0;
    height: 100%;
    z-index: -1;
}

/* Container styles */
.container {
    width: 100vw;
    height: 100vh;
    display: grid;
    grid-template-columns: 1fr 1fr; /* Two columns */
    grid-gap: 2rem;
    padding: 0 2rem;
}

/* Styles for the form (switched to the left) */
.img {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    order: 1; /* Rearrange the order to make it appear on the left */
}

.img img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

/* Styles for the login content (switched to the right) */
.login-content {
    display: flex;
    justify-content: center; /* Center the content horizontally */
    align-items: center;
    text-align: center;
    flex-direction: column;
    order: 2;
}
.login-content img {
    height: 100px;
}

.login-content h2 {
    margin: 15px 0;
    color: #333;
    text-transform: uppercase;
    font-size: 2.9rem;
}

/* Styles for the form */
form {
    width: 360px;
	margin: auto;
}

.input-div {
    position: relative;
    display: grid;
    grid-template-columns: 7% 93%;
    margin: 25px 0;
    padding: 5px 0;
    border-bottom: 2px solid #d9d9d9;
}

.input-div.one {
    margin-top: 0;
}

.i {
    color: #d9d9d9;
    display: flex;
    justify-content: center;
    align-items: center;
}

.i i {
    transition: 0.3s;
}

.input-div > div {
    position: relative;
    height: 45px;
}

.input-div > div > h5 {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
    font-size: 18px;
    transition: 0.3s;
}

.input-div:before,
.input-div:after {
    content: '';
    position: absolute;
    bottom: -2px;
    width: 0%;
    height: 2px;
    background-color: #38d39f;
    transition: 0.4s;
}

.input-div:before {
    right: 50%;
}

.input-div:after {
    left: 50%;
}

.input-div.focus:before,
.input-div.focus:after {
    width: 50%;
}

.input-div.focus > div > h5 {
    top: -5px;
    font-size: 15px;
}

.input-div.focus > .i > i {
    color: #38d39f;
}

.input-div > div > input {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    border: none;
    outline: none;
    background: none;
    padding: 0.5rem 0.7rem;
    font-size: 1.2rem;
    color: #555;
    font-family: 'Poppins', sans-serif;
}

.input-div.pass {
    margin-bottom: 4px;
}

/* Styles for links */
a {
    display: block;
    text-align: right;
    text-decoration: none;
    color: #999;
    font-size: 0.9rem;
    transition: 0.3s;
}

a:hover {
    color: #38d39f;
}

/* Styles for the login button */
.btn {
    display: block;
    width: 100%;
    height: 50px;
    border-radius: 25px;
    outline: none;
    border: none;
    background-image: linear-gradient(to right, #32be8f, #38d39f, #32be8f);
    background-size: 200%;
    font-size: 1.2rem;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    text-transform: uppercase;
    margin: 1rem 0;
    cursor: pointer;
    transition: 0.5s;
}

.btn:hover {
    background-position: right;
}

/* Media query for smaller screens */
@media screen and (max-width: 1050px) {
    .container {
        grid-gap: 5rem;
    }
}

/* Media query for even smaller screens */
@media screen and (max-width: 1000px) {
    form {
        width: 290px;
    }

    .login-content h2 {
        font-size: 2.4rem;
        margin: 8px 0;
    }

    .img img {
        width: 400px;
    }
}

/* Media query for very small screens */
@media screen and (max-width: 900px) {
    .container {
        grid-template-columns: 1fr;
    }

    .img {
        display: none;
    }
    .wave {
        display: none;
    }

    .login-content {
        justify-content: center;
    }
}
		</style>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="#">
			<img src="https://www.negros-occ.gov.ph/wp-content/uploads/2019/12/CPSU-LOGO.jpg" width="30" height="30" class="d-inline-block align-top" alt="CPSU Logo">
			CPSU EXAM SCHEDULING
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<a class="nav-link" href="http://localhost/login/exam1/home.php">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">About</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Services</a>
				</li>
                <li class="nav-item">
	               <a class="nav-link" href="register.php">Create Acoount</a>
               </li>
			</ul>
		</div>
	</nav>

	<img class="wave" src="img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/bg.svg">
		</div>
		<div class="login-content">
			<form method="post">
				<img class="avatar" src="img/avatar.svg"> 
				<h2 class="title">Log-in</h2>
        <div class="input-div one">
    <div class="i">
        <i class="fas fa-user"></i>
    </div>
    <div class="div">
        <h5>Email</h5>
        <input type="email" name="email" class="input" required>
    </div>
     </div>
				<div class="input-div one">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div class="div">
						<h5>Password</h5>
						<input type="password" name="password" class="input" required>
					</div>
				</div>
    <a href="resend_email.php">Did not recieve your verification email? Resend</a>
				<input type="submit" name="submit"  class="btn" value="login">
                <a href="password_update.php"> Forgot Password</a>
			</form>
		</div>
	</div>
	<script src="https://code.jquery.com/   jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
</body>
</html>
