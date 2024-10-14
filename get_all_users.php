<?php
$conn = mysqli_connect("localhost", "root", "", "projetweb");
if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

$users = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    echo json_encode($users);
} else {
    echo json_encode(array("error" => "Failed to fetch users."));
}

mysqli_close($conn);
?>
