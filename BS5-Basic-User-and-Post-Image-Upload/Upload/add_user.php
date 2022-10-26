                <h4><i class="fa-solid fa-code"></i> Bootstrap 5 Basic User Image Upload</h4>
                <?php 
                // Demo Breadcrumb
                
                $is_page = 'add_user.php';

                $is_current_page = ucwords(str_replace("_", " ", (basename($is_page, ".php"))));

                $page = $_SERVER['PHP_SELF'];

                $is_current_dir = ucwords(basename(dirname($page)));

                $is_current_dir_icon = '<i class="fa-solid fa-image"></i> ';

                $is_current_page_icon = '<i class="fa-solid fa-user-plus"></i> ';

                ?>

                <!-- Breadcrumb -->
                <ol class="breadcrumb mb-2 mt-4 p-2 bg-white border border-default rounded-3">
                     <li class="breadcrumb-item"><?php echo $is_current_dir_icon; ?><a href="../<?php echo $is_current_dir; ?>"><?php echo $is_current_dir; ?></a></li>                   
                     <li class="breadcrumb-item active"><?php echo $is_current_page_icon; ?><?php echo $is_current_page; ?></li>
                </ol>
                <?php
                    /*
                     * Simple User Image Upload (BS5)
                     * Author - ic-myXMB
                     */

                    // Connect to database
                    // Include db connect 
                    include("db.php");

                    // Do DB function
                    doDB();
                     
                    // Define Upload file directory
                    $file_dir = "images/users";                    

                    // Since empty define default avatar image display
                    $user_avatar = "default_avatar.png";

                    // If button add user 
                    if (isset($_POST['btn_add_user'])) {

                    	 // File Upload
                    	 // File User Image Name
                         $user_image = $_FILES['user_image']['name'];
                         // File User Image Temp Name
                         $user_temp = $_FILES['user_image']['tmp_name']; 

                        // If image empty on upload
                        if (empty($user_image)) {

                         // Default avatar image locale
                         $default_avatar = "$file_dir/default_avatar.png";

                         // Default avatar image name
                         $default_avatar_name = "default_avatar.png";

                         // Then, rename said file
                         $temp = explode(".", $default_avatar_name);

                         // Then, do new file name
                         $new_filename = round(microtime(true)) . '.' . end($temp);

                         // Avatar image is new file name
                         $avatar_image = "$file_dir/".$new_filename;

                         // Copy default avatar image to avatar image
                         copy($default_avatar, $avatar_image);	

                         // User avatar is new file name
                         $user_avatar = $new_filename;

                         // Query Insert    
                         $sql = "INSERT INTO `users` (user_image) VALUES('$user_avatar')";
                         $result = mysqli_query($mysqli, $sql); 

                         // Get the id of last insert
                         $user_id = mysqli_insert_id($mysqli);

                         // Echo Alert Edit Success
                         echo '<div class="alert alert-success">Edit success.</div>';

                         // Then redirect to the users edit user page
                         header("Refresh:1; url= users.php?ops=edit_user&user_id=$user_id", true, 303);
	                                                   
                        }                        

                        // If is uploaded file
                        if (is_uploaded_file($user_temp)) {

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
                                     echo '<div class="alert alert-danger">The image size is smaller than is allowed! Please upload an image 100px by 100px in size.</div>';

                                     // If so, then redirect back to fileupload form
                                     header("Refresh:1; url= users.php?ops=add_user", true, 303);

                                    }	

                                    // If width & height is greater than allowed 100x100 then such is not allowed
                                    if ($width > $max_width || $height > $max_height) {
                                      // If so, cancel the upload

                                     // If so, echo Alert a no go notice
                                     echo '<div class="alert alert-danger">The image size is larger than is allowed! Please upload an image 100px by 100px in size.</div>';

                                     // If so, then redirect back to fileupload form
                                     header("Refresh:1; url= users.php?ops=add_user", true, 303);	

                                    }
    
                                    // If width & height is equal to allowed 100x100 then such is allowed
                                    if ($width == $max_width || $height == $max_height) {
	                                   // If so, do the upload

	                                   // If is an uploaded file
	                                   if (is_uploaded_file($user_image["tmp_name"])) {

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

		                                 // Query Insert                            
		                                 $sql = "INSERT INTO `users` (user_image) VALUES('$user_avatar')";
		                                 $result = mysqli_query($mysqli, $sql); 

		                                 // Get the id of last insert
		                                 $user_id = mysqli_insert_id($mysqli);

	                                     // If so, is an image file so echo Alert image uploaded success notice
	                                     echo '<div class="alert alert-success">Add User Success!</div>';

	                                     // If so, then redirect to the users edit user page
	                                     header("Refresh:1; url= users.php?ops=edit_user&user_id=$user_id", true, 303);

		                            }

	                            } else {

	                                 // File type is not an image file type so echo Alert an invalid image format notice
	                                 echo '<div class="alert alert-warning">File is not an image thus it is an invalid image format. Only upload JPG or JPEG or GIF or PNG file types.</div>';

	                                 // Echo Alert Query Failed
	                                 echo '<div class="alert alert-danger">Query Failed.</div>';

	                                 // Redirect back to the add user form
	                                 header("Refresh:1; url= users.php?ops=add_user", true, 303);	        	    

	                            }

                            }  

                        }

                    }
                ?>                  
                <!-- Card: Add User -->
                <div class="card mb-4">
                    <div class="card-body">
                         <h5 class="card-title border-bottom pb-3"><i class="fa-solid fa-user-plus"></i> Add User</h5> 
                            <!-- Add User: Form -->
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                     <label class="mb-3"> User Image: </label>
                                     <br />
                                     <img height="150" width="150" class="img-responsive mb-3 img-thumbnail" src="<?php echo $file_dir; ?>/<?php echo $user_avatar; ?>">
                                     <div class="alert alert-warning mb-3">Upload must be an image & be 100px by 100px in size.</div>
                                         <input type="file" name="user_image" class="form-control">
                                </div>                                                                           
                                <div class="mb-3">
                                     <button class="btn btn-success" type="submit" name="btn_add_user"><i class="fa-solid fa-add"></i> Add User</button>
                                </div>
                         </form>
                    </div>
                </div>
                
