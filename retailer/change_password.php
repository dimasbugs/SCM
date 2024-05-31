<?php
	include("../includes/config.php");
	include("../includes/validate_data.php");
	session_start();
	if(isset($_SESSION['retailer_login'])) {
		$id = $_SESSION['retailer_id'];
		$requireErr = $oldPasswordErr = $matchErr ="";
		if($_SERVER['REQUEST_METHOD'] == "POST") {
			if(!empty($_POST['txtOldPassword'])){
				$password = $_POST['txtOldPassword'];
				$query_oldPassword = "SELECT password FROM retailer WHERE retailer_id='$id' AND password='$password'";
				$result_oldPassword = mysqli_query($con,$query_oldPassword);
				$row_oldPassword = mysqli_fetch_array($result_oldPassword);
				if($row_oldPassword) {
					if(!empty($_POST['txtNewPassword']) && !empty($_POST['txtConfirmPassword'])){
						$newPassword = $_POST['txtNewPassword'];
						$confirmPassword = $_POST['txtConfirmPassword'];
						if(strcmp($newPassword,$confirmPassword) == 0) {
							$query_UpdatePassword = "UPDATE retailer SET password='$confirmPassword' WHERE retailer_id='$id'";
							if(mysqli_query($con,$query_UpdatePassword)) {
								echo "<script> alert(\"Password berhasil diupdate\"); </script>";
								header("Refresh:0");
							}
							else {
								$requireErr = "* Update password gagal";
							}
						}
						else {
							$matchErr = "* Password tidak cocok";
						}
					}
					else {
						$requireErr = "* Kolom harus diisi";
					}
				}
				else {
					$oldPasswordErr = "* Password lama tidak cocok";
				}
			}
	}
	}
	else {
		header('Location:../index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title> Edit Profil </title>
	<link rel="stylesheet" href="../includes/main_style.css" >
</head>
<body>
	<?php
		include("../includes/header.inc.php");
		include("../includes/nav_retailer.inc.php");
		include("../includes/aside_retailer.inc.php");
	?>
	<section>
		<h1>Edit Profil</h1>
		<form action="" method="POST" class="form">
		<ul class="form-list">
		<li>
			<div class="label-block"> <label for="oldPassword">Password Lama</label> </div>
			<div class="input-box"> <input type="password" id="oldPassword" name="txtOldPassword" placeholder="Password Lama" required /> </div> <span class="error_message"><?php echo $oldPasswordErr; ?></span>
		</li>
		<li>
			<div class="label-block"> <label for="newPassword">Password Baru</label> </div>
			<div class="input-box"> <input type="password" id="newPassword" name="txtNewPassword" placeholder="Password Baru"  required /> </div>
		</li>
		<li>
			<div class="label-block"> <label for="confirmPassword">Konfirmasi Password</label> </div>
			<div class="input-box"> <input type="password" id="confirmPassword" name="txtConfirmPassword" placeholder="Ketik Password Baru"  required /> </div><span class="error_message"><?php echo $matchErr; ?></span>
		</li>
		<li>
			<input type="submit" value="Ubah Password" class="submit_button" /> <span class="error_message"> <?php echo $requireErr; ?>
		</li>
		</ul>
		</form>
	</section>
	<?php
		include("../includes/footer.inc.php");
	?>
</body>
</html>