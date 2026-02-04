<?php


include 'db_config.php';
$result = $conn->query("SELECT id, image FROM captured_images");

while ($row = $result->fetch_assoc()) {
    $base64 = base64_encode($row['image']);
    echo "<img src='data:image/png;base64,{$base64}' width='300' /><hr>";
}


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// // Example: Preview all images from DB
// include 'db_config.php';
// $result = $conn->query("SELECT * FROM captured_images");

// while ($row = $result->fetch_assoc()) {
//     echo "<img src='get_image.php?id={$row['id']}' width='300' /><hr>";
// }
?>