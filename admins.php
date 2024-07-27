<?php
session_start();
require_once "./partials/connection.php";
$errors = [];
$email = '';
if (isset($_POST['submit'])) {

	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);

	if (empty($email)) {
		$errors['email'] = "Enter your email!";
	}
	if (empty($password)) {
		$errors['password'] = "Enter your password";
	}
	if (count($errors) === 0) {
		
		$encrypted_password = sha1($password);
		$sql = "SELECT * FROM `admins` WHERE `email` = '$email' AND `password` = '$encrypted_password';";
		$result = $conn->query($sql);

		if ($result->num_rows !== 0) {
			$success = "Magic has been spelled!";
			$user = $result->fetch_assoc();
			$_SESSION['user'] = $user;
			header("location: ./dashboard_admin.php");
		} else {
			$failure = "Invalid email or password!";
		}

	}
}


?>

<!DOCTYPE html>
<html lang="en">

<?php
$title = "index";
require_once "./partials/head.php";
?>

<body>
	<?php require_once "./partials/nevigation.php" ?>

	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h2>Admin Login</h2>
							<p class="lead">
								Login to continue
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
										<?php require_once "./partials/alert.php" ?>
										<div class="mb-3">
											<label for="email" class="form-label">Email</label>
											<input class="form-control form-control-lg <?php if (isset($errors['email'])) {
																							echo "is-invalid";
																						} ?>" id="email" type="email" name="email" placeholder="Enter your email" value="<?php echo $email ?>" />
											<?php
											if (isset($errors['email'])) { ?>
												<div class="text-danger"><?php echo $errors['email'] ?></div>
											<?php
											}
											?>
										</div>
										<div class="mb-3">
											<label for="password" class="form-label">Password</label>
											<input class="form-control form-control-lg <?php if (isset($errors['password'])) {
                                                                                            echo "is-invalid";
                                                                                        } ?>" id="password" type="password" name="password" placeholder="Enter your password" />
																						<?php
											if (isset($errors['password'])) { ?>
												<div class="text-danger"><?php echo $errors['password'] ?></div>
											<?php
											}
											?>
										</div>
										<div>
											<div class="form-check align-items-center">
												<input id="customControlInline" type="checkbox" class="form-check-input" value="remember-me" name="remember-me" checked>
												<label class="form-check-label text-small" for="customControlInline">Remember me</label>
											</div>
										</div>
										<div class="d-grid gap-2 mt-3">
											<input type="submit" value="Login" name="submit" class="btn btn-lg btn-info">
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="./template/js/app.js"></script>

</body>

</html>