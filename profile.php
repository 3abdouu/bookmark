<?php
session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include your database connection code if not already included
$conn = mysqli_connect("localhost", "root", "", "projetweb");

if (!$conn) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}

// Fetch user information from the database using session user_id
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    // Handle error if user not found
    echo "User not found.";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Add your CSS styles here -->
    <link rel="stylesheet" href="styleprofile.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <div>
            <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <!-- You may not want to display the password -->
            <!-- <p><strong>Password:</strong> <?php echo $user['pwd']; ?></p> -->
            <form method="POST" action="uploadimg.php" enctype="multipart/form-data">
                <div class="form-group">
                    <input class="form-control" type="file" name="uploadfile" value="" /><br><br>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="upload" id="uploadbtn">Upload Profile Picture</button>
                </div>
            </form>
            <!-- <?php
                error_reporting(0);
                $msg = "";
                $img= $_POST['uploadfile'];
                // If upload button is clicked ...


                if (isset($_POST['upload'])) {

                    if ($_FILES["uploadfile"]["name"]=="") {
                        echo json_encode(array("error" => "Please fill in all fields."));
                        exit;
                    }else{
                
                    $filename = $_FILES["uploadfile"]["name"];
                    $tempname = $_FILES["uploadfile"]["tmp_name"];
                    $folder = "./image/" . $filename;
                
                    $db = mysqli_connect("localhost", "root", "", "projetweb");
                
                    // Get all the submitted data from the form
                    $sql = "INSERT INTO image (filename) VALUES ('$filename')";
                
                    // Execute query
                    mysqli_query($db, $sql);
                
                    // Now let's move the uploaded image into the folder: image
                }
                    }
            ?> -->
            
            <!-- <script>s
                $(document).ready(function() {
                    $('#uploadbtn').click(function() {
                        $.ajax({
                            type: 'POST',
                            url: 'uploadimg.php',   
                            dataType: 'json', // Expect JSON response
                            success: function(response) {
                                // Check if the response contains an error message
                                if (response.error) {
                                    // Display the error message
                                    // $('#signin-error').html(response.error);
                                    Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.error
                                });
                                }
                            }
                        });
                    });
                });
            </script> -->
            
            <button id="modifybtn">Modify</button>
            <button id="disconnectbtn">Disconnect</button>
        </div>
    </div>
    <!-- Include SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Include your JavaScript code -->
    <script>
        
        $(document).ready(function () {
            $('#disconnectbtn').click(function() {
                $.ajax({
                    success: function () {
                        Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Disconnect"
                        }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.html'
                        }
                        });
                }})
            })
            $('#modifybtn').click(function () {
                var userId = <?php echo $userId; ?>;
                modifyUser(userId);
            });

            function modifyUser(userId) {
                // Retrieve old user information from the database
                $.ajax({
                    type: 'POST',
                    url: 'get_user_info.php',
                    data: { id: userId },
                    dataType: 'json',
                    success: function (response) {
                        // Display the old information in the input fields
                        Swal.fire({
                            title: 'Modify User',
                            html: '<input id="new-name" class="swal2-input" placeholder="New Name" value="' + response.name + '">' +
                                '<input id="new-email" class="swal2-input" placeholder="New Email" value="' + response.email + '">' +
                                '<input id="new-password" class="swal2-input" placeholder="New Password" value="">', // Password should be left blank for security reasons
                            confirmButtonText: 'Modify',
                            showCancelButton: true,
                            preConfirm: () => {
                                const newName = Swal.getPopup().querySelector('#new-name').value;   
                                const newEmail = Swal.getPopup().querySelector('#new-email').value;
                                const newPassword = Swal.getPopup().querySelector('#new-password').value;
                                // Call the backend to modify user
                                $.ajax({
                                    type: 'POST',   
                                    url: 'modify_user.php',
                                    data: { id: userId, name: newName, email: newEmail, password: newPassword },
                                    dataType: 'json',
                                    success: function (response) {
                                        Swal.fire({
                                            icon: response.success ? 'success' : 'error',
                                            title: response.success ? 'Modified!' : 'Error!',
                                            text: response.message,
                                            timer: 2000
                                        }).then(() => {
                                            // Refresh the page after modification
                                            location.reload();
                                        });
                                    },
                                    error: function (xhr, status, error) {
                                        console.error(xhr.responseText);
                                    }
                                });
                            }
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    </script>
</body>
</html>
