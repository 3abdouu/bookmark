<?php
$conn = mysqli_connect("localhost", "root", "", "projetweb");
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $email = $_POST['email'];
    $password = $_POST['pwd'];

    // Check for empty fields
    if (empty($email) || empty($password)) {
        // Return error message
        echo json_encode(array("error" => "Please enter both email and password."));
        exit;
    }

    // Check if the entered email and password are for admin
    if ($email == 'admin@gmail.com' && $password == 'admin') {
        // Return success message
        echo json_encode(array("success" => "Welcome dear admin"));
        exit;
    }

    // Proceed with regular sign-in process
    $sql = "SELECT id, name, email, pwd FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Verify password
        if ($password == $user['pwd']) {
            // Sign-in successful
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            echo json_encode(array("success" => "Sign-in successful."));
            exit();
        } else {
            // Incorrect password
            echo json_encode(array("error" => "Incorrect password. Please try again."));
            exit();
        }
    } else {
        // User does not exist
        echo json_encode(array("error" => "User does not exist. Please sign up."));
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
