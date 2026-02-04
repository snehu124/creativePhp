<?php

// upload_image.php

include 'db_config.php';

header("Content-Type: application/json");

// Get raw JSON input
$input = json_decode(file_get_contents("php://input"), true);

if (isset($input['image']) && isset($input['name']) && isset($input['phone'])) {
    $name = $input['name'];
    $phone = $input['phone'];
    $base64Image = $input['image'];

    $base64Image = preg_replace('#^data:image/\w+;base64,#i', '', $base64Image);
    $imageData = base64_decode($base64Image);

    $stmt = $conn->prepare("INSERT INTO captured_images (name, phone, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $phone, $imageData);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "✅ Image and data uploaded"]);
    } else {
        echo json_encode(["success" => false, "message" => "❌ Upload failed: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "❌ Missing data"]);
}


?>