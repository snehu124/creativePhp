<?php
if (isset($_POST['image'])) {
    $data = $_POST['image'];
    $data = str_replace('data:image/png;base64,', '', $data);
    $data = str_replace(' ', '+', $data);
    $imageData = base64_decode($data);

    $fileName = 'photos/photo_' . time() . '.png';
    file_put_contents($fileName, $imageData);

    // Return full URL
    $fullUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/' . $fileName;
    echo $fullUrl;
}
?>
