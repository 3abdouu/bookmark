<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="stylesadmin.css">
    <script src="admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Welcome, Admin!</h1>
        <button id="show-all-users-btn">Manage Users</button>
        <button id="disconnect">Disconnect</button>

        <div id="user-list">
            <!-- User list will be displayed here -->
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#show-all-users-btn').click(function () {
                // Get the list of all users
                $.ajax({
                    type: 'GET',
                    url: 'show_all_users.php',
                    dataType: 'html',
                    success: function (response) {
                        $('#user-list').html(response);
                        // window.location.href = 'show_all_users.php'
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
            $('#disconnect').click(function() {
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
        });
    </script>
</body>
</html>
