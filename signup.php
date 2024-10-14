<?php
$conn = mysqli_connect("localhost", "root", "", "projetweb");
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pwd'];

    if (empty($name) || empty($email) || empty($password)) {
        echo json_encode(array("error" => "Please fill in all fields."));
        exit;
    }

    $sql = "INSERT INTO users (name, email, pwd) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);
    $stmt->execute();

    if ($stmt->affected_rows == 1) {
        echo json_encode(array("success" => "Sign-up successful."));
        exit();
    } else {
        echo json_encode(array("error" => "Registration failed. Please try again."));
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>