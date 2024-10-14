<?php
$conn = mysqli_connect("localhost", "root", "", "projetweb");
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $userId = $_POST['id'];

    // Retrieve user information from the database
    $sql = "SELECT name, email FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // Return user information as JSON response
        echo json_encode($row);
    } else {
        // User not found
        echo json_encode(array("error" => "User not found."));
    }
} else {
    // Invalid request
    echo json_encode(array("error" => "Invalid request."));
}

mysqli_close($conn);
?>
