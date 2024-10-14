<?php
$conn = mysqli_connect("localhost", "root", "", "projetweb");
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $userId = $_POST['id'];

    $sql = "DELETE FROM users WHERE id = $userId";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(array("success" => true, "message" => "User deleted successfully."));
    } else {
        echo json_encode(array("success" => false, "message" => "Failed to delete user."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request."));
}

mysqli_close($conn);
?>
