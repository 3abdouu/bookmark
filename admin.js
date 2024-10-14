$(document).ready(function() {
    // Modify User button action
    $('#modify-btn').click(function() {
        // Redirecting to a modify user page
        window.location.href = 'modify_user.php';
    });

    // Delete User button action
    $('#delete-btn').click(function() {
        // Implement the action here to retrieve and display user list with delete buttons
        $.ajax({
            type: 'GET',
            url: 'get_users.php',
            dataType: 'json',
            success: function(response) {
                displayUsers(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Show All Users button action
    $('#show-users-btn').click(function() {
        // Redirecting to a page to show all users
        window.location.href = 'show_all_users.php';
    });

    // Function to display users with delete buttons
    function displayUsers(users) {
        var userListHtml = '<h2>User List</h2>';
        userListHtml += '<ul>';
        users.forEach(function(user) {
            userListHtml += '<li>' + user.name + ' - <button class="delete-user-btn" data-id="' + user.id + '">Delete</button></li>';
        });
        userListHtml += '</ul>';
        $('#user-list').html(userListHtml);

        // Delete user button click action
        $('.delete-user-btn').click(function() {
            var userId = $(this).data('id');
            deleteUserData(userId);
        });
    }

    // Function to delete user data
    function deleteUserData(userId) {
        // Implement the action here to delete user data
        $.ajax({
            type: 'POST',
            url: 'delete_user.php',
            data: { id: userId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'User Deleted',
                        text: 'The user has been successfully deleted.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Failed to delete user. Please try again later.',
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
});
