<?php

require_once "./partials/connection.php";

session_start();
if (!isset($_SESSION['user'])) {
	header("location: ./");
}

if ((isset($_GET['id']) && !empty($_GET['id']))) {
	$id = $_GET['id'];
} else {
	// header("location: ./dashboard_admin.php");
}
if (!isset($_GET['id'])) {
	// header("location: ./dashboard_admin.php");
}
// $id = $_SESSION['id'];

$id = $_GET['id'];

// echo "<pre>";
// print_r($_GET);
// echo "</pre>";

// die;


$sql = "SELECT * FROM `books` WHERE `id` = '$id';";
$result = $conn->query($sql);
$book = $result->fetch_assoc();

// echo "<pre>";
// print_r($book);
// echo "</pre>";

$errors = [];
$author = $book['author'];
$name = $book['name'];
$description = $book['description'];
$price = $book['price'];
$publish_year = $book['publish_year'];


if (isset($_POST['submit'])) {

	$picture = $_FILES['picture'];
	$author = htmlspecialchars($_POST['author']);
	$name = htmlspecialchars($_POST['name']);
	$description = htmlspecialchars($_POST['description']);
	$price = htmlspecialchars($_POST['price']);
	$publish_year = htmlspecialchars($_POST['publish_year']);

	if ($picture['error'] !== 0) {
		$errors['picture'] = "Select a profile image!";
	}
	if (empty($author)) {
		$errors['author'] = "Author is required!";
	}
	if (empty($name)) {
		$errors['name'] = "Book name is required!";
	}
	if (empty($description)) {
		$errors['description'] = "Write book description!";
	}
	if (empty($price)) {
		$errors['price'] = "Enter price of book!";
	}
	if (empty($publish_year)) {
		$errors['publish_year'] = "Publishing year is required!";
	}
	if (count($errors) === 0) {

		$picture_name = $picture['name'];
		$form = $picture['tmp_name'];

		$extension_array =  explode(".", $picture_name);

		$extension = strtolower(end($extension_array));

		$allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];

		if (in_array($extension, $extension_array)) {
			$new_name = "ACI-" . microtime(true) . rand() . "." . $extension;

			$to = "./img/" . $new_name;

			$sql = "SELECT * FROM `books` WHERE `id` = '$id';";
			$result = $conn->query($sql);
			$book = $result->fetch_assoc();

			// Existing image file path
			$existing_image_path = $book['picture'];

			// Check if the existing image file exists
			if (file_exists($existing_image_path)) {
				// Delete the existing image file
				if (unlink($existing_image_path)) {
					// echo "Existing image deleted successfully.";
				} else {
					$img_error = "Error deleting the existing image.";
					return;
				}
			}

			if (move_uploaded_file($form, $to)) {

				$sql = "UPDATE `books` SET `picture` = '$to', `author` = '$author', `name` = '$name', `description` = '$description',  `price` = '$price', `publish_year` = '$publish_year' WHERE `id` = '$id';";

				if ($conn->query($sql)) {
					$success = "Successfully Uploaded";
					// $success = "Magic has been spelled!";
				} else {
					$failure = "Failed to connect!";
				}
			} else {
				$errors['picture'] = "Failed to upload!";
			}
		} else {
			$errors['picture'] = "Only JPG, JPEG, PNG, and webP are allowed!";
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<?php
$title = "dashboard";
require_once "./partials/head.php";
?>

<body>
	<div class="wrapper">
		<?php require_once "./partials/sidebar.php" ?>

		<div class="main">
			<?php require_once "./partials/navbar.php" ?>

			<main class="content">
				<div class="container-fluid p-0">

					<div class="row">
						<div class="col-6">
							<h1 class="h3 mb-3">Books</h1>
						</div>
						<div class="col-6 text-end">
							<a href="./dashboard_admin.php" class="btn btn-primary">Back</a>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
										<?php require_once "./partials/alert.php" ?>
										<div class="mb-3">
											<label for="picture" class="form-label">Profile Picture</label>
											<input type="file" id="picture" name="picture" class="form-control <?php if (isset($errors['picture'])) {
																													echo "is-invalid";
																												} ?>">
											<?php
											if (isset($errors['picture'])) { ?>
												<div class="text-danger"><?php echo $errors['picture'] ?></div>
											<?php
											}
											?>
										</div>
										<div class="mb-3">
											<label for="author" class="form-label">Author</label>
											<input type="text" id="author" name="author" class="form-control <?php if (isset($errors['author'])) {
																													echo "is-invalid";
																												} ?>" placeholder="Enter author" value="<?php echo $author ?>">
											<?php
											if (isset($errors['author'])) { ?>
												<div class="text-danger"><?php echo $errors['author'] ?></div>
											<?php
											}
											?>
										</div>
										<div class="mb-3">
											<label for="name" class="form-label">Name</label>
											<input type="text" id="name" name="name" class="form-control <?php if (isset($errors['name'])) {
																												echo "is-invalid";
																											} ?>" placeholder="Enter book name" value="<?php echo $name ?>">
											<?php
											if (isset($errors['name'])) { ?>
												<div class="text-danger"><?php echo $errors['name'] ?></div>
											<?php
											}
											?>
										</div>
										<div class="mb-3">
											<label for="description" class="form-label">Description</label>
											<textarea id="description" name="description" class="form-control <?php if (isset($errors['description'])) {
																													echo "is-invalid";
																												} ?>" placeholder="Enter book description"><?php echo $description ?></textarea>
											<?php
											if (isset($errors['description'])) { ?>
												<div class="text-danger"><?php echo $errors['description'] ?></div>
											<?php
											}
											?>
										</div>
										<div class="mb-3">
											<label for="price" class="form-label">Price</label>
											<div class="input-group">
												<div class="input-group-text">$</div>
												<input type="number" id="price" name="price" class="form-control <?php if (isset($errors['price'])) {
																														echo "is-invalid";
																													} ?>" placeholder="Enter book price" value="<?php echo $price ?>">
											</div>
											<?php
											if (isset($errors['price'])) { ?>
												<div class="text-danger"><?php echo $errors['price'] ?></div>
											<?php
											}
											?>
										</div>
										<div class="mb-3">
											<label for="publish_year" class="form-label">Publish Year</label>
											<input type="number" id="publish_year" name="publish_year" class="form-control <?php if (isset($errors['publish_year'])) {
																																echo "is-invalid";
																															} ?>" placeholder="Enter book publish_year" value="<?php echo $publish_year ?>">
											<?php
											if (isset($errors['publish_year'])) { ?>
												<div class="text-danger"><?php echo $errors['publish_year'] ?></div>
											<?php
											}
											?>
										</div>
										<div class="mt-3">
											<input type="submit" name="submit" value="Update" class="btn btn-success">
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</main>

			<?php require_once "./partials/footer.php" ?>

		</div>
	</div>

	<script src="./template/js/app.js"></script>

</body>

</html>