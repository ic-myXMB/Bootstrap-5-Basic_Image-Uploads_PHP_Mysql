<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
           <title></title>
           <!-- CSS Files -->
           <!-- Bootstrap -->  
           <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />
           <!-- Font Awesome -->
           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />   
      </head>  
      <body>  
           <!-- Container -->
           <div class="container mt-5"> 
                <!-- Breadecrumb -->
                <ol class="breadcrumb mb-4">
                     <li class="breadcrumb-item"><i class="fa-solid fa-dashboard"></i> <a href="index.html">Dashboard</a></li>
                     <li class="breadcrumb-item active"><i class="fa-solid fa-user-edit"></i> Edit User</li>
                </ol> 
                <?php
                    // connect to database
                    // include db connect
                    include("db.php");

                    // do DB Func
                    doDB();

                    // define upload file directory
                    $file_dir = "users";

                         // Define as user id 1 form demo
                         $User_ID = 1;

                         // Query Select
                         $sql = "SELECT * FROM `users` WHERE user_id = '$User_ID'";
                         $result = mysqli_query($mysqli, $sql);

                          // While
                          while ($row = mysqli_fetch_assoc($result)) {

                             // User Image
                             $user_image = $row['user_image'];

                           }

                          // Update Record
                          // If edit user button
                          if (isset($_POST['btn_edit_user'])) {

                            // File Upload
                            $User_Image = $_FILES['user_image']['name'];
                            $User_Temp = $_FILES['user_image']['tmp_name'];                          
 
                            // If image empty on upload
                            if (empty($User_Image)) {

                              // Query Select
                              $query = "SELECT * FROM `users` WHERE user_id = '$User_ID'";
                              $result = mysqli_query($mysqli, $sql);

                              // While
                              while ($row = mysqli_fetch_assoc($result)) {

                              	// User Image
                                $User_Image = $row['user_image'];

                              }

                              // Query Update
                              $sql = "UPDATE `users` SET user_image = '$user_image' WHERE user_id = '$User_ID'";
                              $result = mysqli_query($mysqli, $sql);

                              // Echo
                              echo '<div class="alert alert-success">Edit success.</div>';

	                          // Echo
	                          echo '<div class="alert alert-warning">No upload file was selected thus the Old image was retained.</div>'; 

		                      // Redirect
		                      header("Refresh:2; url= edit_user.php", true, 303);	                                                        

                            }


                            // If is uploaded file
                            if (is_uploaded_file($User_Temp)) {

                             // Query Select
                             $query = "SELECT * FROM `users` WHERE user_id = '$User_ID'";
                             $result = mysqli_query($mysqli, $sql);

                                // While
                                while ($row = mysqli_fetch_assoc($result)) {

                                 // Old Image
                                 $old = $row['user_image'];                              

                                }                              

                                // For each file as file name
                                foreach($_FILES as $file_name => $user_image) {

                                 // If is image file type then get image width and height
                                 list($width, $height) = getimagesize($user_image["tmp_name"]);

                                 // Echo file extension info
                                 $path = $user_image["name"]; // file name
                                 $ext = pathinfo($path, PATHINFO_EXTENSION); // extension name

                                   // If such file is an image file type
                                   if ($ext == "jpg" OR $ext == "jpeg" OR $ext == "gif" OR $ext == "png") {	
                                     // if so, also display image dimension infos

                                     // Allowed max width & height
                                     $max_width = 100; // allowed width
                                     $max_height = 100; // allowed height

                                       // If width & height is less than allowed 100x100 then such is not allowed
                                       if ($width < $max_width || $height < $max_height) {
                                         // If so, cancel the upload

                                         // If so, echo a no go notice
                                         echo '<div class="alert alert-warning">The image size is smaller than is allowed! Please upload an image 100px by 100px in size.</div>';

                                         // Echo
                                         echo '<div class="alert alert-danger">Upload Failed: Old image retained.</div>';

                                         // Show old image
                                         $user_image = $old;                                   

                                        }	

                                       // If width & height is greater than allowed 100x100 then such is not allowed
                                       if ($width > $max_width || $height > $max_height) {
                                          // if so, cancel the upload

                                         // If so, echo a no go notice
                                         echo '<div class="alert alert-warning">The image size is larger than is allowed! Please upload an image 100px by 100px in size.</div>';

                                         // Echo
                                         echo '<div class="alert alert-danger">Upload Failed: Old image retained.</div>';

                                         // Show old image
                                         $user_image = $old;	

                                        }
    
                                        // if width & height is equal to allowed 100x100 then such is allowed
                                        if ($width == $max_width || $height == $max_height) {
	                                      // if so, do the upload

	                                      // If is an uploaded file
	                                      if (is_uploaded_file($user_image["tmp_name"])) {

	                                   	     // Unlink Old Image
	                                   	     unlink("users/$old"); 

		                                     // If so, rename said file
		                                     $temp = explode(".", $user_image["name"]);

		                                     // If so, do new file name
		                                     $new_filename = round(microtime(true)) . '.' . end($temp);

		                                     // If so, display the uploaded image file
		                                     $avatar_image = $new_filename; 
		                                     $user_avatar = $avatar_image;

		                                     // If so, move upload file or die
		                                     move_uploaded_file($user_image["tmp_name"], "$file_dir/$user_avatar"); 

		                                     // If so, is an image file so echo image uploaded success notice
		                                     echo '<div class="alert alert-primary">The image file was uploaded!</div><br/>';

		                                    }

                                         // Query Update
                                         $sql = "UPDATE `users` SET user_image = '$user_avatar' WHERE user_id = '$User_ID'";

                                         $result = mysqli_query($mysqli, $sql);

                                         // user image is user avatar
                                         $user_image = $user_avatar;

		                                 // If so, is an image file so echo image uploaded success notice
		                                 echo '<div class="alert alert-success">Edit User Success!</div>';

		                                 // Redirect
		                                 header("Refresh:2; url= edit_user.php", true, 303);

		                                }

	                                } else {

	                                 // File type is not an image file type so echo an invalid image format notice
	                                 echo '<div class="alert alert-warning">Upload File is not an image type. Only upload JPG or JPEG or GIF or PNG file types.</div>';

	                                 // Show old image
	                                 $user_image = $old;

	                                 // Echo
	                                 echo '<div class="alert alert-danger">Upload Failed: Old image retained.</div>';	        	    

	                                }
	                                
                                }

                            }

                        }
                ?>
                <!-- Card Edit User -->
                <div class="card mb-4">
                  <div class="card-body">
                       <h5 class="card-title border-bottom pb-3"><i class="fa-solid fa-user-edit"></i> Edit User</h5>  	
                       <!-- Edit User Form -->
                       <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                 <label class="mb-3"> User Image: </label>
                                 <br />
                                 <img height="150" width="150" class="img-responsive img-thumbnail mb-3" src="<?php echo $file_dir;?>/<?php echo $user_image; ?>">
                                 <div class="alert alert-warning mb-3">Upload must be an image & be 100px by 100px in size.</div>                       
                                     <input type="file" name="user_image" class="form-control">
                                 </div>                              
                                 <div class="mb-3">
                                     <button class="btn btn-success" type="submit" name="btn_edit_user"><i class="fa-solid fa-edit"></i> Edit User</button>
                                 </div>
                            </div>
                        </form>
                  </div>
                </div>
           </div>  <!-- ./ end container -->
           <!-- JS Files -->
           <!-- JQuery -->
           <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
           <!-- Bootstrap -->
           <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script> 
      </body>  
 </html>  
