<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
           <title>Edit Post - Example</title>
           <!-- CSS Files -->
           <!-- Bootstrap CSS -->  
           <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />
           <!-- Font Awesome CSS -->
           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />   
      </head>  
      <body>  
           <!-- Container -->
           <div class="container mt-5"> 
                <!-- Breadecrumb -->
                <ol class="breadcrumb mb-4">
                     <li class="breadcrumb-item"><i class="fa-solid fa-dashboard"></i> <a href="index.html">Dashboard</a></li>
                     <li class="breadcrumb-item active"><i class="fa-solid fa-file-edit"></i> Edit Post</li>
                </ol> 
                <?php
                    /*
                     * Simple Post Image Upload (BS5)
                     * Author - ic-myXMB
                     */
                                    
                    // Connect to database
                    // Include db connect
                    include("db.php");

                    // Do DB Function
                    doDB();

                    // Define Upload file directory
                    $file_dir = "posts";

                         // Define as Post ID '1' - since is form demo
                         $Post_ID = '1';

                         // Query Select
                         $sql = "SELECT * FROM `posts` WHERE post_id = '$Post_ID'";
                         $result = mysqli_query($mysqli, $sql);

                          // While
                          while ($row = mysqli_fetch_assoc($result)) {

                             // Post Image
                             $post_image = $row['post_image'];

                           }

                          // Update Record
                          // If edit post button
                          if (isset($_POST['btn_edit_post'])) {

                            // File Upload
                            // File Post Image Name
                            $Post_Image = $_FILES['post_image']['name'];
                            // File Post Image Temp Name
                            $Post_Temp = $_FILES['post_image']['tmp_name'];                          
 
                            // If image empty on upload
                            if (empty($Post_Image)) {

                              // Query Select
                              $query = "SELECT * FROM `posts` WHERE post_id = '$Post_ID'";
                              $result = mysqli_query($mysqli, $sql);

                              // While
                              while ($row = mysqli_fetch_assoc($result)) {

                              	// Post Image
                                $Post_Image = $row['post_image'];

                              }

                              // Query Update
                              $sql = "UPDATE `posts` SET post_image = '$post_image' WHERE post_id = '$Post_ID'";
                              $result = mysqli_query($mysqli, $sql);

                              // Echo Alert Edit Success
                              echo '<div class="alert alert-success">Edit success.</div>';

	                          // Echo Alert No Upload Old Image Retained
	                          echo '<div class="alert alert-warning">No upload file was selected thus the Old image was retained.</div>'; 

		                      // Redirect
		                      header("Refresh:2; url= edit_post.php", true, 303);	                                                        

                            }


                            // If is uploaded file
                            if (is_uploaded_file($Post_Temp)) {

                             // Query Select
                             $query = "SELECT * FROM `posts` WHERE post_id = '$Post_ID'";
                             $result = mysqli_query($mysqli, $sql);

                                // While
                                while ($row = mysqli_fetch_assoc($result)) {

                                 // Old Image
                                 $old = $row['post_image'];                              

                                }                              

                                // For each file as file name
                                foreach($_FILES as $file_name => $post_image) {

                                 // If is image file type then get image width and height
                                 list($width, $height) = getimagesize($post_image["tmp_name"]);

                                 // Echo file extension info
                                 $path = $post_image["name"]; // file name
                                 $ext = pathinfo($path, PATHINFO_EXTENSION); // extension name

                                   // If such file is an image file type
                                   if ($ext == "jpg" OR $ext == "jpeg" OR $ext == "gif" OR $ext == "png") {	
                                     // If so, then check dimensions

                                     // Allowed max width & height
                                     $max_width = 850; // Allowed width
                                     $max_height = 350; // Allowed height

                                       // If width & height is less than allowed 850x350 then such is not allowed
                                       if ($width < $max_width || $height < $max_height) {
                                         // If so, cancel the upload

                                         // If so, echo Alert - a no go notice
                                         echo '<div class="alert alert-warning">The image size is smaller than is allowed! Please upload an image 850px by 350px in size.</div>';

                                         // Echo Alert Upload Failed Old Image Retained
                                         echo '<div class="alert alert-danger">Upload Failed: Old image retained.</div>';

                                         // Show old image
                                         $post_image = $old;                                   

                                        }	

                                       // If width & height is greater than allowed 850x350 then such is not allowed
                                       if ($width > $max_width || $height > $max_height) {
                                         // If so, cancel the upload

                                         // If so, echo Alert a no go notice
                                         echo '<div class="alert alert-warning">The image size is larger than is allowed! Please upload an image 850px by 350px in size.</div>';

                                         // Echo Alert Upload Failed Old Image Retained
                                         echo '<div class="alert alert-danger">Upload Failed: Old image retained.</div>';

                                         // Show old image
                                         $post_image = $old;	

                                        }
    
                                        // if width & height is equal to allowed 850x350 then such is allowed
                                        if ($width == $max_width || $height == $max_height) {
	                                      // If so, do the upload

	                                      // If is an uploaded file
	                                      if (is_uploaded_file($post_image["tmp_name"])) {

	                                   	     // Unlink Old Image
	                                   	     unlink("$file_dir/$old"); 

		                                     // If so, rename said file
		                                     $temp = explode(".", $post_image["name"]);

		                                     // If so, do new file name
		                                     $new_filename = round(microtime(true)) . '.' . end($temp);

		                                     // If so, display the uploaded image file
		                                     $postimage_image = $new_filename; 
		                                     $post_postimage = $postimage_image;

		                                     // If so, move upload file or die
		                                     move_uploaded_file($post_image["tmp_name"], "$file_dir/$post_postimage"); 

		                                     // If so, is an image file so echo Alert image uploaded success notice
		                                     echo '<div class="alert alert-primary">The image file was uploaded!</div><br/>';

		                                    }

                                         // Query Update
                                         $sql = "UPDATE `posts` SET post_image = '$post_postimage' WHERE post_id = '$Post_ID'";
                                         $result = mysqli_query($mysqli, $sql);

                                         // Post image is post postimage
                                         $post_image = $post_postimage;

		                                 // If so, is an image file so echo image uploaded success notice
		                                 echo '<div class="alert alert-success">Edit Post Success!</div>';

		                                 // Redirect
		                                 header("Refresh:2; url= edit_post.php", true, 303);

		                                }

	                                } else {

	                                 // File type is not an image file type so echo Alert an invalid image format notice
	                                 echo '<div class="alert alert-warning">Upload File is not an image type. Only upload JPG or JPEG or GIF or PNG file types.</div>';

	                                 // Show old image
	                                 $post_image = $old;

	                                 // Echo Alert Upload Failed Old Image Retained
	                                 echo '<div class="alert alert-danger">Upload Failed: Old image retained.</div>';	        	    

	                                }
	                                
                                }

                            }

                        }
                ?>
                <!-- Card: Edit Post -->
                <div class="card mb-4">
                  <div class="card-body">
                       <h5 class="card-title border-bottom pb-3"><i class="fa-solid fa-file-edit"></i> Edit Post</h5>  	
                       <!-- Edit Post: Form -->
                       <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                 <label class="mb-3"> Post Image: </label>
                                 <br />
                                 <img height="350" width="850" class="img-responsive img-thumbnail mb-3" src="<?php echo $file_dir; ?>/<?php echo $post_image; ?>">
                                 <div class="alert alert-warning mb-3">Upload must be an image & be 850px by 350px in size.</div>              
                                     <input type="file" name="post_image" class="form-control">
                                 </div>                              
                                 <div class="mb-3">
                                     <button class="btn btn-success" type="submit" name="btn_edit_post"><i class="fa-solid fa-edit"></i> Edit Post</button>
                                 </div>
                            </div>
                        </form>
                  </div>
                </div>
           </div>  <!-- ./ End Container -->
           <!-- JS Files -->
           <!-- JQuery JS -->
           <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
           <!-- Bootstrap JS -->
           <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script> 
      </body>  
 </html>  
