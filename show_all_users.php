<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show All Users</title>
    <link rel="stylesheet" href="stylesadmin.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>All Users</h1>
        <div id="user-list">
            <!-- User list will be displayed here -->
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Get the list of all users
            $.ajax({
                type: 'GET',
                url: 'get_all_users.php',
                dataType: 'json',
                success: function (response) {
                    displayUsers(response);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

            function displayUsers(users) {
                var userListHtml = '<h2>User List</h2>';
                userListHtml += '<table>';
                userListHtml += '<tr><th>Name</th><th>Email</th><th>Action</th></tr>';
                users.forEach(function (user) {
                    userListHtml += '<tr>';
                    userListHtml += '<td>' + user.name + '</td>';
                    userListHtml += '<td>' + user.email + '</td>';
                    userListHtml += '<td><button class="modify-user-btn" data-id="' + user.id + '">Modify</button> - <button class="delete-user-btn" data-id="' + user.id + '">Delete</button></td>';
                    userListHtml += '</tr>';
                });
                userListHtml += '</table>';
                $('#user-list').html(userListHtml);

                // Modify user button click action
                $('.modify-user-btn').click(function () {
                    var userId = $(this).data('id');
                    // Call the modify user function
                    modifyUser(userId);
                });

                // Delete user button click action
                $('.delete-user-btn').click(function () {
                    var userId = $(this).data('id');
                    // Call the delete user function
                    deleteUser(userId);
                });
            }



            function modifyUser(userId) {
                // Retrieve old user information from the database
                $.ajax({
                    type: 'POST',
                    url: 'get_user_info.php', // Create a new PHP file to handle this request
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
                                            // Refresh the user list after modification
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


            function deleteUser(userId) {
                // Confirm deletion with a SweetAlert dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this user!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If user confirms deletion, proceed to delete
                        $.ajax({
                            type: 'POST',
                            url: 'delete_user.php',
                            data: { id: userId },
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    // If user is deleted successfully, show success message and reload user list
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'User Deleted',
                                        text: 'The user has been successfully deleted.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    // If deletion fails, show error message
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Failed to delete user. Please try again later.',
                                    });
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            }

        });
    </script>
</body>

</html>
