<?php
    error_reporting(0);
    $msg = "";



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
?>