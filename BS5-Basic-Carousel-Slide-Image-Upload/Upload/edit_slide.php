                <h4><i class="fa-solid fa-code"></i> BS5 Basic Carousel Slide Image Upload</h4>
                <?php
                // Demo Breadcrumb

                $is_page = 'edit_slide.php';

                $is_current_page = ucwords(str_replace("_", " ", (basename($is_page, ".php"))));

                $page = $_SERVER['PHP_SELF'];

                $is_current_dir = ucwords(basename(dirname($page)));

                $is_current_dir_icon = '<i class="fa-solid fa-image"></i> ';

                $is_current_page_icon = '<i class="fa-solid fa-sliders"></i> ';
                
                ?>

                <!-- Breadcrumb -->
                <ol class="breadcrumb mb-4 mt-4 p-2 bg-white border border-default rounded-3">
                     <li class="breadcrumb-item"><?php echo $is_current_dir_icon; ?><a href="../<?php echo $is_current_dir; ?>"><?php echo $is_current_dir; ?></a></li>                   
                     <li class="breadcrumb-item active"><?php echo $is_current_page_icon; ?><?php echo $is_current_page; ?></li>
                </ol>
                <?php
                    /*
                     * Simple Carousel Slide Image Upload (BS5)
                     * Author - ic-myXMB
                     */

                    // Connect to database
                    // Include db connect
                    include("db.php");

                    // Do DB Func
                    doDB();

                    // Define upload file directory
                    $file_dir = "images/slides";

                       // If not get slide_id
                       if (!isset($_GET['slide_id'])) {

                         // Define as Slide ID '1' - since is form demo
                         $Slide_ID = '1';
                         
                         // Query Select
                         $sql = "SELECT * FROM `slides` WHERE slide_id = '$Slide_ID'";
                         $result = mysqli_query($mysqli, $sql);

                          // While
                          while ($row = mysqli_fetch_assoc($result)) {

                             // Slide Image
                             $slide_image = $row['slide_image'];

                           }

                        }

                       // If get slide_id
                       if (isset($_GET['slide_id'])) {

                         $Slide_ID = $_GET['slide_id'];

                         // Query Select
                         $sql = "SELECT * FROM `slides` WHERE slide_id = '$Slide_ID'";
                         $result = mysqli_query($mysqli, $sql);

                          // While
                          while ($row = mysqli_fetch_assoc($result)) {

                             // Slide Image
                             $slide_image = $row['slide_image'];

                           }

                        }

                          // Update Record
                          // If edit slide button
                          if (isset($_POST['btn_edit_slide'])) {

                            // File Upload
                            // File Slide Image Name
                            $Slide_Image = $_FILES['slide_image']['name'];
                            // File Slide Image Temp Name
                            $Slide_Temp = $_FILES['slide_image']['tmp_name'];                          
 
                            // If image empty on upload
                            if (empty($Slide_Image)) {

                              // Query Select
                              $query = "SELECT * FROM `slides` WHERE slide_id = '$Slide_ID'";
                              $result = mysqli_query($mysqli, $sql);

                              // While
                              while ($row = mysqli_fetch_assoc($result)) {

                              	// Slide Image
                                $Slide_Image = $row['slide_image'];

                              }

                              // Query Update
                              $sql = "UPDATE `slides` SET slide_image = '$slide_image' WHERE slide_id = '$Slide_ID'";
                              $result = mysqli_query($mysqli, $sql);

                              // Echo Alert Edit Success
                              echo '<div class="alert alert-success">Edit success.</div>';

	                          // Echo Alert No Upload Old Image Retained
	                          echo '<div class="alert alert-warning">No upload file was selected thus the Old image was retained.</div>'; 

		                      // Redirect
		                      header("Refresh:2; url= slides.php?ops=edit_slide&slide_id=$Slide_ID", true, 303);	                                                        

                            }


                            // If is uploaded file
                            if (is_uploaded_file($Slide_Temp)) {

                             // Query Select
                             $query = "SELECT * FROM `slides` WHERE slide_id = '$Slide_ID'";
                             $result = mysqli_query($mysqli, $sql);

                                // While
                                while ($row = mysqli_fetch_assoc($result)) {

                                 // Old Image
                                 $old_image = $row['slide_image'];                              

                                }                              

                                // For each file as file name
                                foreach($_FILES as $file_name => $slide_image) {

                                 // If is image file type then get image width and height
                                 list($width, $height) = getimagesize($slide_image["tmp_name"]);

                                 // Echo file extension info
                                 $path = $slide_image["name"]; // file name
                                 $ext = pathinfo($path, PATHINFO_EXTENSION); // extension name

                                   // If such file is an image file type
                                   if ($ext == "jpg" OR $ext == "jpeg" OR $ext == "gif" OR $ext == "png") {	
                                     // If so, then check dimensions

                                     // Allowed max width & height
                                     $max_width = 900; // Allowed width
                                     $max_height = 500; // Allowed height

                                       // If width & height is less than allowed 900x500 then such is not allowed
                                       if ($width < $max_width || $height < $max_height) {
                                         // If so, cancel the upload

                                         // If so, echo Alert - a no go notice
                                         echo '<div class="alert alert-warning">The image size is smaller than is allowed! Please upload an image 900px by 500px in size.</div>';

                                         // Echo Alert Upload Failed Old Image Retained
                                         echo '<div class="alert alert-danger">Upload Failed: Old image retained.</div>';

                                         // Show old image
                                         $slide_image = $old_image;                                   

                                        }	

                                       // If width & height is greater than allowed 900x500 then such is not allowed
                                       if ($width > $max_width || $height > $max_height) {
                                         // If so, cancel the upload

                                         // If so, echo Alert a no go notice
                                         echo '<div class="alert alert-warning">The image size is larger than is allowed! Please upload an image 900px by 500px in size.</div>';

                                         // Echo Alert Upload Failed Old Image Retained
                                         echo '<div class="alert alert-danger">Upload Failed: Old image retained.</div>';

                                         // Show old image
                                         $slide_image = $old_image;	

                                        }
    
                                        // if width & height is equal to allowed 900x500 then such is allowed
                                        if ($width == $max_width || $height == $max_height) {
	                                      // If so, do the upload

	                                      // If is an uploaded file
	                                      if (is_uploaded_file($slide_image["tmp_name"])) {

	                                   	     // Unlink Old Image
	                                   	     unlink("$file_dir/$old_image"); 

		                                     // If so, rename said file
		                                     $temp = explode(".", $slide_image["name"]);

		                                     // If so, do new file name
		                                     $new_filename = round(microtime(true)) . '.' . end($temp);

		                                     // If so, display the uploaded image file
		                                     $slideimage_image = $new_filename; 
		                                     $slide_slideimage = $slideimage_image;

		                                     // If so, move upload file or die
		                                     move_uploaded_file($slide_image["tmp_name"], "$file_dir/$slide_slideimage"); 

		                                     // If so, is an image file so echo Alert image uploaded success notice
		                                     echo '<div class="alert alert-primary">The image file was uploaded!</div><br/>';

		                                    }

                                         // Query Update
                                         $sql = "UPDATE `slides` SET slide_image = '$slide_slideimage' WHERE slide_id = '$Slide_ID'";
                                         $result = mysqli_query($mysqli, $sql);

                                         // Slide image is slide slideimage
                                         $slide_image = $slide_slideimage;

		                                 // If so, is an image file so echo image uploaded success notice
		                                 echo '<div class="alert alert-success">Edit Slide Success!</div>';

		                                 // Redirect
		                                 header("Refresh:2; url= slides.php?ops=edit_slide&slide_id=$Slide_ID", true, 303);

		                                }

	                                } else {

	                                 // File type is not an image file type so echo Alert an invalid image format notice
	                                 echo '<div class="alert alert-warning">Upload File is not an image type. Only upload JPG or JPEG or GIF or PNG file types.</div>';

	                                 // Show old image
	                                 $slide_image = $old_image;

	                                 // Echo Alert Upload Failed Old Image Retained
	                                 echo '<div class="alert alert-danger">Upload Failed: Old image retained.</div>';	        	    

	                                }
	                                
                                }

                            }

                        }
                ?>
                
                <!-- Card: Edit Slide -->
                <div class="card mb-4">
                  <div class="card-body">
                       <h5 class="card-title border-bottom pb-3"><i class="fa-solid fa-file-image"></i> Edit Slide</h5>  	
                       <!-- Edit Slide: Form -->
                       <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                 <label class="mb-3"> Slide Image: </label>
                                 <br />
                                 <img height="500" width="900" class="img-responsive img-thumbnail mb-3 w-100 rounded-3" src="<?php echo $file_dir;?>/<?php echo $slide_image; ?>">
                                 <div class="alert alert-warning mb-3">Upload must be an image & be 900px by 500px in size.</div>              
                                     <input type="file" name="slide_image" class="form-control">
                            </div>                              
                            <div class="mb-3">
                                <button class="btn btn-success" type="submit" name="btn_edit_slide"><i class="fa-solid fa-edit"></i> Edit Slide</button>
                            </div>
                        </form>
                  </div>
                </div>

