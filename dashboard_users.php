<?php

require_once "./partials/connection.php";
session_start();
if (!isset($_SESSION['user'])) {
	header("location: ./");
}

$sql = "SELECT * FROM `books`;";
$result = $conn->query($sql);

$books = $result->fetch_all(MYSQLI_ASSOC);

// echo "<pre>";
// print_r($result);
// echo "</pre>";

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
					</div>

					<?php
					if ($result->num_rows !== 0) { ?>
						<div class="row mt-3">
							<?php
							foreach ($books as $book) { ?>
								<div class="col-4">
									<div class="card p-2">
										<div class="card_header text-center">
											<img style="border-radius:50%;" src="<?php echo $book['picture'] ?>" height="200px" width="200px">
										</div>
										<div class="card-body">
											<div class="card-title">
												<h4><strong>Name: </strong><?php echo $book['name'] ?></h4>
											</div>
											<p><strong>Author: </strong><?php echo $book['author'] ?></p>
											<p class="card-text"><strong>Description: </strong><?php echo $book['description'] ?></p>
											<p><strong>Publishing Year: </strong><?php echo $book['publish_year'] ?></p>
											<p style="color: green;"><strong>Price: <?php echo $book['price'] ?> PKR</strong></p>
											<p><strong>Rating: <input type="range" name="range" id="range"></strong></p>
										</div>

									</div>
								</div>
							<?php
							}
							?>
						</div>
					<?php
					} else { ?>
						<div class="alert alert-info">No book found!</div>
					<?php
					}
					?>


			</main>

			<?php require_once "./partials/footer.php" ?>

		</div>
	</div>

	<script src="./template/js/app.js"></script>

</body>

</html>