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
// Add User
case 'add_user':
 // Page Title 
 $page_title = 'Add User';
// Break
break;
// Edit User
case 'edit_user':
 // Page Title 
 $page_title = 'Edit User';
// Break 
break;
// View All Users
default:
 // Page Title
 $page_title = 'View All Users';
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
           <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" />
           <!-- Font Awesome CSS -->
           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />   
      </head>  
      <body>  
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
                     // Add User
                     case 'add_user':
                         // Require
                         require_once('add_user.php');
                     // Break
                     break;
                     // Edit User
                     case 'edit_user':
                         // Require                          
                         require_once('edit_user.php');
                     // Break
                     break;
                     // View All Users
                     // Is Default
                     default:
                         // Require
                         require_once('view_all_users.php');
                     // Break
                     break;
                    }
                ?>
         </div>  <!-- ./ End container -->                     
         <!-- JS Files -->
         <!-- JQuery JS -->
         <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
         <!-- Bootstrap JS -->
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script> 
    </body>  
</html> 
                   