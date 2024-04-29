<?php
require_once './../core/functions.php';
require_once './../core/validitions.php';
require_once './../core/sessions.php';
require_once './../config/connection.php';

session_start();

// Check if the user is not logged in, then redirect to the index page
if (!issetSession('id') && !issetSession('username')):
  redirectPage('./../index.php');
else:
  // Get the username from the session
  $userName = $_SESSION['username'];

  // Check if the form is submitted and the submit button is clicked
  if (postMethod() && issetInput($_POST['submit'])):
    // Iterate over the uploaded files
    foreach ($_FILES as $key => $value):
      foreach ($value as $key => $file):
        $$key = $file; // Assign variables with file names
      endforeach;
    endforeach;

    // Extract the file extension
    $file_extension = explode('.', $name);
    $file_autual_extension = strtolower(end($file_extension));

    // List of allowed extensions
    $allowed_extension = ['jpg', 'jpeg', 'png', 'svg', 'webp'];

    // Check if a file is provided
    if (!requireInput($name)):
      // Check if the file extension is allowed
      if (checkItemInArray($file_autual_extension, $allowed_extension)):
        // Check if there are no errors in upload
        if ($error === 0):
          // Check the file size
          if ($size < 3000000):  // 1000000 = 1mb

            // Generate a new file name
            $file_new_name = uniqid('', true) . '.' . $file_autual_extension;

            // Target path for the new file
            $target = './../image/' . $file_new_name;

            // Fetch the old profile image name from the database
            $select = "SELECT `profile_image` FROM `users` WHERE `username` = '$userName' LIMIT 1";
            $select_result = mysqli_query($conn, $select);
            $data = mysqli_fetch_assoc($select_result);

            // Update the profile image name in the database
            $update = "UPDATE `users` SET `profile_image` = '$file_new_name' WHERE `username` = '$userName'";
            $result = mysqli_query($conn, $update);

            // If the update is successful
            if ($result === true):
              // Check if the old profile image is not 'male.jpeg' or 'female.jpeg'
              if ($data['profile_image'] !== 'male.jpeg' && $data['profile_image'] !== 'female.jpeg'):
                // Delete the old profile image from the folder
                unlink("./../image/" . $data['profile_image']);
              endif;
            endif;

            // Move the file to the target path
            move_uploaded_file($tmp_name, $target);

            // Redirect the user to the home page
            redirectPage('./../home.php');

          else:
            $error = 'Your photo is too big!'; // Error message if the photo size is too large
          endif;
        else:
          $error = 'Error in upload photo!'; // Error message if there's an error during upload
        endif;
      else:
        $error = 'You can\'t upload photo of this type!'; // Error message if the uploaded file type is not allowed
      endif;
    else:
      $error = 'Please choose Image'; // Error message if no image is chosen
    endif;

    // Check if there's an error message, if yes, display it to the user
    if (requireInput($error)):
      createSession('success', 'Your photo was updated'); // Create a success session if the update is successful
      redirectPage('./../home.php'); // Redirect to the home page
    else:
      createSession('error', $error); // Create an error session if there's any error
      redirectPage('./../home.php'); // Redirect to the home page
    endif;

  endif;

endif;
