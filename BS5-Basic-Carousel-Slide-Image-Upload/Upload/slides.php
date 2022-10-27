<?php
// Switch Demo Page Titles
// If Is Get Operations
if (isset($_GET['ops'])) {
    // Operations
    $ops = $_GET['ops'];
} else {
    // Operations
    $ops = '';       
}
// Switch Ops
switch ($ops) {
// Add Slide
case 'add_slide':
 // Page Title 
 $page_title = 'Add Slide';
// Break 
break;
// Edit Slide
case 'edit_slide':
 // Page Title 
 $page_title = 'Edit Slide';
// Break
break;
// View All Slides
default:
 // Page Title
 $page_title = 'View All Slides';
// Break
break;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
           <title>Demo - <?php echo $page_title; ?></title>
           <!-- CSS Files -->
           <!-- Bootstrap CSS -->  
           <link rel="stylesheet" href="includes/bootstrap/css/bootstrap.min.css" />
           <!-- Font Awesome CSS -->
           <link rel="stylesheet" href="includes/font-awesome/css/all.min.css" />   
      </head>  
      <body class="bg-light">  
           <!-- Container -->
           <div class="container mt-5">
           	<?php
                 // If Is Get Operations
                 if (isset($_GET['ops'])) {
                     // Operations
                     $ops = $_GET['ops'];
                 } else {
                     // Operations 
                     $ops = '';       
                 }
                 // Switch Ops
                 switch ($ops) {
                     // Add Slide
                     case 'add_slide':
                         // Require
                         require_once('add_slide.php');
                     // Break
                     break;
                     // Edit Slide
                     case 'edit_slide':
                         // Require                          
                         require_once('edit_slide.php');
                     // Break
                     break;
                     // View All Slides
                     // Is Default
                     default:
                         // Require
                         require_once('view_all_slides.php');
                     // Break
                     break;
                    }
                ?>
         </div>  <!-- ./ End container -->                     
         <!-- JS Files -->
         <!-- JQuery JS -->
         <script src="includes/jquery/jquery-3.5.1.min.js"></script> 
         <!-- Bootstrap JS -->
         <script src="includes/bootstrap/jscripts/bootstrap.bundle.min.js"></script> 
    </body>  
</html> 
                   