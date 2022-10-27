<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
           <title>Demo - Carousel</title>
           <!-- CSS Files -->
           <!-- Bootstrap CSS -->  
           <link rel="stylesheet" href="includes/bootstrap/css/bootstrap.min.css" />
           <!-- Font Awesome CSS -->
           <link rel="stylesheet" href="includes/font-awesome/css/all.min.css" /> 
           <style>
           .carousel {
             background: #fff;
           }
           .carousel-item .img-fluid {
             width: 100%;
             /* height:auto; */
             max-height: 400px;
           }
           .carousel-item a {
             display: block;
             width: 100%;
           }
           </style>  
      </head>  
      <body class="bg-light">  
           <!-- Container -->
           <div class="container mt-5">
                <!-- Heading -->
                <h4><i class="fa-solid fa-code"></i> BS5 Basic Carousel Slide Image Upload</h4>
                <?php
                // Demo Breadcrumb

                $is_page = 'carousel.php';

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

           	 <!-- Carousel -->
             <div id="carouselDemoFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
             	  <!-- Carousel Inner -->
                  <div class="carousel-inner">
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
                         	
                             // Slide ID     
                             $slide_id = $data_slide['slide_id'];

                             // Slide Image
                             $slide_image = $data_slide['slide_image'];

                             // Slide Status    
                             $slide_status = $data_slide['slide_status'];                             

				           // If Slide status equal to 1
				           if ($slide_status === '1') {

				             // is active status status
				             $is_active = ' active';

				           } 
				           // If Slide status equal to 0
				           if ($slide_status === '0') {

				             // is not active status
				             $is_active = '';     
				                            	
				           }

                        ?><!-- Slide -->
                        <div class="carousel-item<?php echo $is_active; ?>">
                             <img height="500" width="900" src="<?php echo $file_dir; ?>/<?php echo $slide_image; ?>" class="img-responsive d-block img-fluid img-thumbnail rounded-3" alt="...">
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselDemoFade" data-bs-slide="prev">
                         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                         <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselDemoFade" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
             </div> <!-- ./ End carousel --> 

         </div>   <!-- ./ End container -->                   
         <!-- JS Files -->
         <!-- JQuery JS -->
         <script src="includes/jquery/jquery-3.5.1.min.js"></script> 
         <!-- Bootstrap JS -->
         <script src="includes/bootstrap/jscripts/bootstrap.bundle.min.js"></script> 
    </body>  
</html> 
                   