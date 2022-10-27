                <h4><i class="fa-solid fa-code"></i> BS5 Basic Carousel Slide Image Upload</h4>
                <?php
                // Demo Breadcrumb 

                $is_page = 'add_slide.php';

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

                    // Do DB func
                    doDB();
                     
                    // Define upload file directory
                    $file_dir = "images/slides";                    

                    // Since empty define default slideimage image display
                    $slide_slideimage = "default_slide.jpg";

                    // If button add slide 
                    if (isset($_POST['btn_add_slide'])) {

                    	 // File Upload 
                    	 // File Slide Image Name
                         $slide_image = $_FILES['slide_image']['name'];
                         // File Slide Image Temp Name
                         $slide_temp = $_FILES['slide_image']['tmp_name']; 

                        // If image empty on upload
                        if (empty($slide_image)) {

                         // Default slideimage image locale
                         $default_slideimage = "$file_dir/default_slide.jpg";

                         // Default slideimage image name
                         $default_slideimage_name = "default_slide.jpg";

                         // Then, rename said file
                         $temp = explode(".", $default_slideimage_name);

                         // Then, do new file name
                         $new_filename = round(microtime(true)) . '.' . end($temp);

                         // Slideimage image is new file name
                         $slideimage_image = "$file_dir/".$new_filename;

                         // Copy default slideimage image to slideimage image
                         copy($default_slideimage, $slideimage_image);	

                         // Slide slideimage is new file name
                         $slide_slideimage = $new_filename;

                         // Slide status
                         $slide_status = '0';

                         // Query Insert    
                         $sql = "INSERT INTO `slides` (slide_image, slide_status) VALUES('$slide_slideimage', '$slide_status')";
                         $result = mysqli_query($mysqli, $sql); 

                         // Get the id of last insert
                         $slide_id = mysqli_insert_id($mysqli);

                         // Echo Alert Edit Success
                         echo '<div class="alert alert-success">Edit success.</div>';

                         // Then redirect to the slides edit slide page
                         header("Refresh:1; url= slides.php?ops=edit_slide&slide_id=$slide_id", true, 303);
	                                                   
                        }                        

                        // If is uploaded file
                        if (is_uploaded_file($slide_temp)) {

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

                                     // If so, echo Alert a no go notice
                                     echo '<div class="alert alert-danger">The image size is smaller than is allowed! Please upload an image 900px by 500px in size.</div>';

                                     // If so, then redirect back to fileupload form
                                     header("Refresh:1; url= slides.php?ops=add_slide", true, 303);

                                    }	

                                    // If width & height is greater than allowed 900x500 then such is not allowed
                                    if ($width > $max_width || $height > $max_height) {
                                     // If so, cancel the upload

                                     // If so, echo Alert a no go notice
                                     echo '<div class="alert alert-danger">The image size is larger than is allowed! Please upload an image 900px by 500px in size.</div>';

                                     // If so, then redirect back to fileupload form
                                     header("Refresh:1; url= slides.php?ops=add_slide", true, 303);	

                                    }
    
                                    // if width & height is equal to allowed 900x500 then such is allowed
                                    if ($width == $max_width || $height == $max_height) {
	                                   // If so, do the upload

	                                   // If is an uploaded file
	                                   if (is_uploaded_file($slide_image["tmp_name"])) {

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

		                                 // Slide status
		                                 $slide_status = '0';

		                                 // Query Insert                            
		                                 $sql = "INSERT INTO `slides` (slide_image, slide_status) VALUES('$slide_slideimage', '$slide_status')";
		                                 $result = mysqli_query($mysqli, $sql); 

		                                 // Get the id of last insert
		                                 $slide_id = mysqli_insert_id($mysqli);

	                                     // If so, is an image file so echo Alert image uploaded success notice
	                                     echo '<div class="alert alert-success">Add Slide Success!</div>';

	                                     // If so, then redirect to the slides edit slide page
	                                     header("Refresh:1; url= slides.php?ops=edit_slide&slide_id=$slide_id", true, 303);

		                            }

	                            } else {

	                                 // File type is not an image file type so echo Alert an invalid image format notice
	                                 echo '<div class="alert alert-warning">File is not an image thus it is an invalid image format. Only upload JPG or JPEG or GIF or PNG file types.</div>';

	                                 // Echo Alert Query Failed
	                                 echo '<div class="alert alert-danger">Query Failed.</div>';

	                                 // Redirect back to the add slide form
	                                 header("Refresh:1; url= slides.php?ops=add_slide", true, 303);	        	    

	                            }

                            }  

                        }

                    }
                ?>                  
                <!-- Card: Add Slide -->
                <div class="card mb-4">
                    <div class="card-body">
                         <h5 class="card-title border-bottom pb-3"><i class="fa-solid fa-file-image"></i> Add Slide</h5> 
                            <!-- Add Slide: Form -->
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                     <label class="mb-3"> Slide Image: </label>
                                     <br />
                                     <img height="500" width="900" class="img-responsive mb-3 img-thumbnail w-100 rounded-3" src="<?php echo $file_dir; ?>/<?php echo $slide_slideimage; ?>">
                                     <div class="alert alert-warning mb-3">Upload must be an image & be 900px by 500px in size.</div>
                                         <input type="file" name="slide_image" class="form-control">
                                </div>                                                                           
                                <div class="mb-3">
                                     <button class="btn btn-success" type="submit" name="btn_add_slide"><i class="fa-solid fa-add"></i> Add Slide</button>
                                </div>
                         </form>
                    </div>
                </div>
                
