                <?php
                // Demo Breadcrumb

                $is_page = 'edit_user.php';

                $is_current_page = ucwords(str_replace("_", " ", (basename($is_page, ".php"))));

                $page = $_SERVER['PHP_SELF'];

                $is_current_dir = ucwords(basename(dirname($page)));

                $is_current_dir_icon = '<i class="fa-solid fa-image"></i> ';

                $is_current_page_icon = '<i class="fa-solid fa-user-edit"></i> ';
                
                ?>

                <!-- Breadcrumb -->
                <ol class="breadcrumb mb-4">
                     <li class="breadcrumb-item"><?php echo $is_current_dir_icon; ?> <a href="../<?php echo $is_current_dir; ?>"><?php echo $is_current_dir; ?></a></li>                   
                     <li class="breadcrumb-item active"><?php echo $is_current_page_icon; ?> <?php echo $is_current_page; ?></li>
                </ol>
                <?php
                    /*
                     * Simple User Image Upload (BS5)
                     * Author - ic-myXMB
                     */

                    // Connect to database
                    // Include db connect
                    include("db.php");

                    // Do DB Function
                    doDB();

                     // Define Upload file directory
                     $file_dir = "users";

                       // If not get user_id
                       if (!isset($_GET['user_id'])) {

                         // Define as User ID '1' - since is form demo
                         $User_ID = '1';
                         
                         // Query Select
                         $sql = "SELECT * FROM `users` WHERE user_id = '$User_ID'";
                         $result = mysqli_query($mysqli, $sql);

                          // While
                          while ($row = mysqli_fetch_assoc($result)) {

                             // User Image
                             $user_image = $row['user_image'];

                           }

                        }

                       // If get user_id
                       if (isset($_GET['user_id'])) {

                         $User_ID = $_GET['user_id'];

                         // Query Select
                         $sql = "SELECT * FROM `users` WHERE user_id = '$User_ID'";
                         $result = mysqli_query($mysqli, $sql);

                          // While
                          while ($row = mysqli_fetch_assoc($result)) {

                             // User Image
                             $user_image = $row['user_image'];

                           }

                        }

                        // Update Record
                        // If edit user button
                        if (isset($_POST['btn_edit_user'])) {

                            // File Upload
                            // File User Image Name
                            $User_Image = $_FILES['user_image']['name'];
                            // File User Image Temp Name
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

                              // Echo Alert Edit Success
                              echo '<div class="alert alert-success">Edit success.</div>';

	                          // Echo Alert No Upload Old Image Retained
	                          echo '<div class="alert alert-warning">No upload file was selected thus the Old image was retained.</div>'; 

		                      // Redirect
		                      header("Refresh:2; url= users.php?opt=edit_user&user_id=$User_ID", true, 303);	                                                        

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
                                     // If so, then check image dimensions

                                     // Allowed max width & height
                                     $max_width = 100; // Allowed width
                                     $max_height = 100; // Allowed height

                                       // If width & height is less than allowed 100x100 then such is not allowed
                                       if ($width < $max_width || $height < $max_height) {
                                         // If so, cancel the upload

                                         // If so, echo Alert a no go notice
                                         echo '<div class="alert alert-warning">The image size is smaller than is allowed! Please upload an image 100px by 100px in size.</div>';

                                         // Echo Alert Upload Failed Old Image Retained
                                         echo '<div class="alert alert-danger">Upload Failed: Old image retained.</div>';

                                         // Show old image
                                         $user_image = $old;                                   

                                        }	

                                       // If width & height is greater than allowed 100x100 then such is not allowed
                                       if ($width > $max_width || $height > $max_height) {
                                          // If so, cancel the upload

                                         // If so, echo Alert a no go notice
                                         echo '<div class="alert alert-warning">The image size is larger than is allowed! Please upload an image 100px by 100px in size.</div>';

                                         // Echo Alert Upload Failed Old Image Retained
                                         echo '<div class="alert alert-danger">Upload Failed: Old image retained.</div>';

                                         // Show old image
                                         $user_image = $old;	

                                        }
    
                                        // If width & height is equal to allowed 100x100 then such is allowed
                                        if ($width == $max_width || $height == $max_height) {
	                                      // If so, do the upload

	                                      // If is an uploaded file
	                                      if (is_uploaded_file($user_image["tmp_name"])) {

	                                   	     // Unlink Old Image
	                                   	     unlink("$file_dir/$old"); 

		                                     // If so, rename said file
		                                     $temp = explode(".", $user_image["name"]);

		                                     // If so, do new file name
		                                     $new_filename = round(microtime(true)) . '.' . end($temp);

		                                     // If so, display the uploaded image file
		                                     $avatar_image = $new_filename; 
		                                     $user_avatar = $avatar_image;

		                                     // If so, move upload file or die
		                                     move_uploaded_file($user_image["tmp_name"], "$file_dir/$user_avatar"); 

		                                     // If so, is an image file so echo Alert image uploaded success notice
		                                     echo '<div class="alert alert-primary">The image file was uploaded!</div><br/>';

		                                    }

                                         // Query Update
                                         $sql = "UPDATE `users` SET user_image = '$user_avatar' WHERE user_id = '$User_ID'";
                                         $result = mysqli_query($mysqli, $sql);

                                         // User image is user avatar
                                         $user_image = $user_avatar;

		                                 // If so, is an image file so echo Alert image uploaded success notice
		                                 echo '<div class="alert alert-success">Edit User Success!</div>';

		                                 // Redirect
		                                 header("Refresh:2; url= users.php?opt=edit_user&user_id=$User_ID", true, 303);

		                                }

	                                } else {

	                                 // File type is not an image file type so echo Alert an invalid image format notice
	                                 echo '<div class="alert alert-warning">Upload File is not an image type. Only upload JPG or JPEG or GIF or PNG file types.</div>';

	                                 // Show old image
	                                 $user_image = $old;

	                                 // Echo Alert Upload Failed Old Image Retained
	                                 echo '<div class="alert alert-danger">Upload Failed: Old image retained.</div>';	        	    

	                                }
	                                
                                }

                            }

                        }
                ?>

                <!-- Card: Edit User -->
                <div class="card mb-4">
                  <div class="card-body">
                       <h5 class="card-title border-bottom pb-3"><i class="fa-solid fa-user-edit"></i> Edit User</h5>  	
                       <!-- Edit User: Form -->
                       <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                 <label class="mb-3"> User Image: </label>
                                 <br />
                                 <img height="150" width="150" class="img-responsive img-thumbnail mb-3" src="<?php echo $file_dir; ?>/<?php echo $user_image; ?>">
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
                
