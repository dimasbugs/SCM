<?php
    include('includes/config.php'); 

    // Define variables and set to empty values
    $usernameErr = $passwordErr = $successMsg = $errorMsg = "";
    $username = $password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate input
        if (empty($_POST["txtUsername"])) {
            $usernameErr = "Username harus diisi";
        } else {
            $username = test_input($_POST["txtUsername"]);
        }

        if (empty($_POST["txtPassword"])) {
            $passwordErr = "Password harus diisi";
        } else {
            $password = test_input($_POST["txtPassword"]);
        }

        // Insert data into the database
        if (empty($usernameErr) && empty($passwordErr)) {
            $stmt = $con->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);

            if ($stmt->execute()) {
                // Redirect to index.php if the insertion is successful
                header("Location: index.php");
                exit(); // Ensure no further code is executed after the redirect
            } else {
                $errorMsg = "Error: " . $stmt->error;
            }

            $stmt->close();
		}
    }

    // Function to sanitize user input
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Register</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="my-login.css">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="images/logo.jpg" alt="bootstrap 4 login page">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Register</h4>
							<form method="POST" class="my-login-validation" novalidate="">
								<div class="form-group">
									<label for="name">Nama</label>
									<input id="register:username" type="text" class="form-control" name="txtUsername" required autofocus>
									<div class="invalid-feedback">
										Masukan nama
									</div>
								</div>

								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" type="password" class="form-control" name="txtPassword" required data-eye>
									<div class="invalid-feedback">
										Password harus diisi
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Register
									</button>
									<span class="error_message"><?php echo $usernameErr; echo $passwordErr; echo $successMsg; echo $errorMsg; ?></span>
								</div>
								<div class="mt-4 text-center">
									Sudah punya akun? <a href="index.php">Login</a>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Supply Chain Management
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="my-login.js"></script>
</body>
</html>