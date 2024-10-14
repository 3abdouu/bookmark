<?php
// Include your database connection code here if not already included
$conn = mysqli_connect("localhost", "root", "", "projetweb");

if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $userId = $_POST['id'];
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];

    // Check for empty fields or invalid user ID
    if (empty($userId) || empty($newName) || empty($newEmail) || empty($newPassword)) {
        // Return error message
        echo json_encode(array("success" => false, "message" => "Invalid request."));
        exit;
    }

    // Update the user record in the database
    $sql = "UPDATE users SET name=?, email=?, pwd=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $newName, $newEmail, $newPassword, $userId);
    if ($stmt->execute()) {
        // User updated successfully
        echo json_encode(array("success" => true, "message" => "User updated successfully."));
    } else {
        // Failed to update user
        echo json_encode(array("success" => false, "message" => "Failed to update user."));
    }

    $stmt->close();
    $conn->close();
}
?>
