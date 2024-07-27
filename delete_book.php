<?php

require_once "./partials/connection.php";

session_start();
if (!isset($_SESSION['user'])) {
    header("location: ./");
}

if ((isset($_GET['id']) && !empty($_GET['id']))) {
    $id = $_GET['id'];
} else {
    header("location: ./dashboard_admin.php");
}
if (!isset($_GET['id'])) {
    header("location: ./dashboard_admin.php");
}

$sql = "SELECT * FROM `books` WHERE `id` = '$id';";
$result = $conn->query($sql);
$book = $result->fetch_assoc();

echo "<pre>";
print_r($book);
echo "</pre>";


$image_path = $book['picture'];

if (file_exists($image_path)) {
    if (unlink($image_path)) {
        echo "Image deleted successfully.";
        $sql = "DELETE FROM `books` WHERE `id` = '$id';";
        if ($conn->query($sql)) {
            header("location: ./dashboard_admin.php");
        } else {
            die("Failed to connect!");
        }
    } else {
        echo "Error deleting the image.";
    }
} else {
    echo "Image file not found.";
}
