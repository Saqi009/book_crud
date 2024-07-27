<?php

require_once "./partials/connection.php";
$errors = [];
$name = $email = '';
if (isset($_POST['submit'])) {

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirm_password']);

    if (empty($name)) {
        $errors['name'] = "Enter your name!";
    }
    if (empty($email)) {
        $errors['email'] = "Enter your email!";
    }
    if (empty($password)) {
        $errors['password'] = "Set your password!";
    }
    if ($password !== $confirm_password) {
        $errors['password'] = "Password does not match!";
    }
    if (count($errors) === 0) {

        $sql = "SELECT * FROM `users` WHERE `email` = '$email';";
        $result = $conn->query($sql);

        if ($result->num_rows === 0) {
            $encrypted_password = sha1($password);
            $sql = "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('$name','$email','$encrypted_password');";
            if ($conn->query($sql)) {
                $success = "Magic has been spelled!";
            } else {
                $failure = "Failed to connect!";
            }
        } else {
            $failure = "Email already exists!";
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
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1>Registration</h1>
                            <p class="lead">
                                Register your account to continue..
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-3">
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                                        <?php require_once "./partials/alert.php" ?>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input class="form-control form-control-lg <?php if (isset($errors['name'])) {
                                                                                            echo "is-invalid";
                                                                                        } ?>" id="name" type="text" name="name" placeholder="Enter your name" value="<?php echo $name ?>" />
                                            <?php
                                            if (isset($errors['name'])) { ?>
                                                <div class="text-danger"><?php echo $errors['name'] ?></div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input class="form-control form-control-lg <?php if (isset($errors['name'])) {
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
                                            <input class="form-control form-control-lg  <?php if (isset($errors['name'])) {
                                                                                            echo "is-invalid";
                                                                                        } ?>" id="password" type="password" name="password" placeholder="Enter your password" />
                                            <?php
                                            if (isset($errors['password'])) { ?>
                                                <div class="text-danger"><?php echo $errors['password'] ?></div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirm Password</label>
                                            <input class="form-control form-control-lg <?php if (isset($errors['name'])) {
                                                                                            echo "is-invalid";
                                                                                        } ?>" id="confirm_password" type="password" name="confirm_password" placeholder="Enter your password" />
                                        </div>
                                        <div>
                                            <div class="form-check align-items-center">
                                                <input id="customControlInline" type="checkbox" class="form-check-input" value="remember-me" name="remember-me" checked>
                                                <label class="form-check-label text-small" for="customControlInline">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="d-grid gap-2 mt-3">
                                            <input type="submit" name="submit" class="btn btn-lg btn-info">
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