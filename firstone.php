<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="stylefirstone.css">
    <!-- <style>
        /* Style for the navbar */
        nav {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav div {
            display: flex;
            align-items: center;
        }

        nav div span {
            margin-left: 10px;
        }

        /* Style for the profile button */
        .profile-btn {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-right: 20px;
            cursor: pointer;
        }

        /* Style for the profile button on hover */
        .profile-btn:hover {
            background-color: #45a049;
        }
    </style> -->
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div>
            <!-- Your logo or website name here -->
            <h1>My Website</h1>
        </div>
        <div>
            <!-- Display the username -->
            <?php
            session_start();
            if (isset($_SESSION['user_name'])) {
                $username = $_SESSION['user_name'];
                echo '<span>Welcome, ' . $username . '!</span>';
                echo '<a href="profile.php" class="profile-btn">My Profile</a>';
            }
            ?>
        </div>
    </nav>

    <!-- Rest of the content goes here -->
    <div>
        <h2>Welcome to our website!</h2>
        <!-- Add more content here -->
    </div>
</body>
</html>
