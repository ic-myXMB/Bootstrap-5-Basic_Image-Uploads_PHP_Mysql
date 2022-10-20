<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
           <title>Add Post - Example</title>
           <!-- CSS Files -->
           <!-- Bootstrap CSS -->  
           <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />
           <!-- Font Awesome CSS -->
           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />   
      </head>  
      <body>  
           <!-- Container -->
           <div class="container mt-5">
                <!-- Breadrcrumb -->
                <ol class="breadcrumb mb-4">
                     <li class="breadcrumb-item"><i class="fa-solid fa-dashboard"></i> <a href="index.html">Dashboard</a></li>
                     <li class="breadcrumb-item active"><i class="fa-solid fa-file-edit"></i> Add Post</li>
                </ol>
                <?php
                    /*
                     * Simple Post Image Upload (BS5)
                     * Author - ic-myXMB
                     */

                    // Connect to database
                    // Include db connect 
                    include("db.php");

                    // Do DB function
                    doDB();
                     
                    // Define Upload file directory
                    $file_dir = "posts";                    

                    // Since empty define default postimage image display
                    $post_postimage = "default_post.jpg";

                    // If button add post 
                    if (isset($_POST['btn_add_post'])) {

                    	 // File Upload 
                    	 // File Post Image Name
                         $post_image = $_FILES['post_image']['name'];
                         // File Post Image Temp Name
                         $post_temp = $_FILES['post_image']['tmp_name']; 

                        // If image empty on upload
                        if (empty($post_image)) {

                         // Default postimage image locale
                         $default_postimage = "$file_dir/default_post.jpg";

                         // Default postimage image name
                         $default_postimage_name = "default_post.jpg";

                         // Then, rename said file
                         $temp = explode(".", $default_postimage_name);

                         // Then, do new file name
                         $new_filename = round(microtime(true)) . '.' . end($temp);

                         // Postimage image is new file name
                         $postimage_image = "$file_dir/".$new_filename;

                         // Copy default postimage image to postimage image
                         copy($default_postimage, $postimage_image);	

                         // Post postimage is new file name
                         $post_postimage = $new_filename;

                         // Query Insert    
                         $sql = "INSERT INTO `posts` (post_image) VALUES('$post_postimage')";
                         $result = mysqli_query($mysqli, $sql); 

                         // Get the id of last insert
                         $post_id = mysqli_insert_id($mysqli);

                         // Echo Alert Edit Success
                         echo '<div class="alert alert-success">Edit success.</div>';

                         // Then redirect to the posts edit post page
                         header("Refresh:1; url= add_post.php", true, 303);
	                                                   
                        }                        

                        // If is uploaded file
                        if (is_uploaded_file($post_temp)) {

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

                                   // If width & height is less than allowed 850x3500 then such is not allowed
                                   if ($width < $max_width || $height < $max_height) {
                                     // If so, cancel the upload

                                     // If so, echo Alert a no go notice
                                     echo '<div class="alert alert-danger">The image size is smaller than is allowed! Please upload an image 850px by 350px in size.</div>';

                                     // If so, then redirect back to fileupload form
                                     header("Refresh:1; url= add_post.php", true, 303);

                                    }	

                                    // If width & height is greater than allowed 850x350 then such is not allowed
                                    if ($width > $max_width || $height > $max_height) {
                                     // If so, cancel the upload

                                     // If so, echo Alert a no go notice
                                     echo '<div class="alert alert-danger">The image size is larger than is allowed! Please upload an image 850px by 350px in size.</div>';

                                     // If so, then redirect back to fileupload form
                                     header("Refresh:1; url= add_post.php", true, 303);	

                                    }
    
                                    // if width & height is equal to allowed 100x100 then such is allowed
                                    if ($width == $max_width || $height == $max_height) {
	                                   // If so, do the upload

	                                   // If is an uploaded file
	                                   if (is_uploaded_file($post_image["tmp_name"])) {

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

		                                 // Query Insert                            
		                                 $sql = "INSERT INTO `posts` (post_image) VALUES('$post_postimage')";
		                                 $result = mysqli_query($mysqli, $sql); 

		                                 // Get the id of last insert
		                                 $post_id = mysqli_insert_id($mysqli);

	                                     // If so, is an image file so echo Alert image uploaded success notice
	                                     echo '<div class="alert alert-success">Add Post Success!</div>';

	                                     // If so, then redirect to the posts edit post page
	                                     header("Refresh:1; url= add_post.php", true, 303);

		                            }

	                            } else {

	                                 // File type is not an image file type so echo Alert an invalid image format notice
	                                 echo '<div class="alert alert-warning">File is not an image thus it is an invalid image format. Only upload JPG or JPEG or GIF or PNG file types.</div>';

	                                 // Echo Alert Query Failed
	                                 echo '<div class="alert alert-danger">Query Failed.</div>';

	                                 // Redirect back to the add post form
	                                 header("Refresh:1; url= add_post.php", true, 303);	        	    

	                            }

                            }  

                        }

                    }
                ?>                  
                <!-- Card: Add Post -->
                <div class="card mb-4">
                    <div class="card-body">
                         <h5 class="card-title border-bottom pb-3"><i class="fa-solid fa-file-edit"></i> Add Post</h5> 
                            <!-- Add Post: Form -->
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                     <label class="mb-3"> Post Image: </label>
                                     <br />
                                     <img height="350" width="850" class="img-responsive mb-3 img-thumbnail" src="<?php echo $file_dir; ?>/<?php echo $post_postimage; ?>">
                                     <div class="alert alert-warning mb-3">Upload must be an image & be 850px by 350px in size.</div>
                                         <input type="file" name="post_image" class="form-control">
                                     </div>                                                                           
                                     <div class="mb-3">
                                         <button class="btn btn-success" type="submit" name="btn_add_post"><i class="fa-solid fa-add"></i> Add Post</button>
                                     </div>
                                </div>
                         </form>
                    </div>
                </div>
           </div>  <!-- ./ End container -->                     
           <!-- JS Files -->
           <!-- JQuery JS -->
           <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
           <!-- Bootstrap JS -->
           <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script> 
      </body>  
 </html> 
                   