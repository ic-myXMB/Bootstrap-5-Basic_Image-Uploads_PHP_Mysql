                <h4><i class="fa-solid fa-code"></i> BS5 Basic Carousel Slide Image Upload</h4>
                <?php
                // Demo Breadcrumb 

                $is_page = 'view_all_slides.php';

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
                
                <!-- View All Slides Table -->
                <div class="table-responsive">
                   <table class="table table-striped table-bordered">
                      <tr>
                         <thead class="bg-white">
                             <th width="5%">ID</th>
                             <th width="85%">Image</th>                            
                             <th width="10%" colspan="2">Operations</th>
                         </thead>                                                                          
                      </tr>
                      <?php
                         /*
                          * Simple Carousel Slide Image Upload (BS5)
                          * Author - ic-myXMB
                          */
                         
                         // Connect to database
                         // Include db connect 
                         include("db.php");

                         // Do DB function
                         doDB();

                         // File Slide Image Upload Directory  
                         $file_dir = "images/slides";                         

                         // Query Select
                         $sql = "SELECT * FROM `slides`";
                         $slides = mysqli_query($mysqli, $sql);

                         // While
                         while ($data_slide = mysqli_fetch_assoc($slides)) {
                         	
                             // Old Image
                             $old_image = $data_slide['slide_image'];

                             // Slide ID     
                             $slide_id = $data_slide['slide_id'];

                             // Slide Image
                             $slide_image = $data_slide['slide_image'];
                        ?><!-- Slide -->
                      <tr>
                         <td><?php echo $slide_id; ?></td>
                         <td><img height="50" width="50" class="img-responsive" src="<?php echo $file_dir; ?>/<?php echo $slide_image; ?>"></td>
                         <td><a href="slides.php?delete=<?php echo $slide_id; ?>" class="btn btn-danger"><span class="fa-solid fa-trash"></span></a></td> 
                         <td><a href="slides.php?ops=edit_slide&slide_id=<?php echo $slide_id; ?>" class="btn btn-success"><span class="fa-solid fa-edit"></span></a></td>   
                      </tr>  
                      <?php
                         }
				           
                            // Delete Slide
                            // If Is Get Delete 
                            if (isset($_GET['delete'])) {

                             // Slide Id
                             $slide_id = $_GET['delete'];

                             // Query Delete
                             $sql = "DELETE FROM `slides` WHERE slide_id = '$slide_id'";
                             $slide_delete = mysqli_query($mysqli, $sql);

                                // If slide delete
                                if ($slide_delete) {

                                 // Unlink Old Image
                            	 unlink("$file_dir/$old_image");                                    	
                                    	
                                 // Redirect 
                                 header("Location: slides.php");

                                }
                            }
                        ?>                                                          
                  </table>
               </div>
                
