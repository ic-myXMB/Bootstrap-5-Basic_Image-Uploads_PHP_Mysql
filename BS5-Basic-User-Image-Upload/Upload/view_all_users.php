<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
           <title>View All Users - Example</title>
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
                     <li class="breadcrumb-item active"><i class="fa-solid fa-users"></i> View All Users</li>
                </ol>
                <!-- View All Users Table -->
                <div class="table-responsive">
                   <table class="table table-striped table-bordered">
                      <tr>
                         <thead class="thead-white">
                             <th width="5%">ID</th>
                             <th width="85%">Image</th>                            
                             <th width="10%" colspan="2">Operations</th>
                         </thead>                                                                          
                      </tr>
                      <tr>
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

                         // File User Image Upload Directory  
                         $file_dir = "users";                         

                         // Query Select
                         $sql = "SELECT * FROM `users`";
                         $users = mysqli_query($mysqli, $sql);

                         // While
                         while ($data_user = mysqli_fetch_assoc($users)) {

                             // User ID     
                             $user_id = $data_user['user_id'];

                             // User Image
                             $user_image = $data_user['user_image'];

                        ?>
                         <td><?php echo $user_id; ?></td>
                         <td><img height="50" width="50" class="img-responsive" src="<?php echo $file_dir; ?>/<?php echo $user_image; ?>"></td>
                         <td><a href="#" class="btn btn-danger"><span class="fa-solid fa-trash"></span></a></td> 
                         <td><a href="#" class="btn btn-success"><span class="fa-solid fa-edit"></span></a></td>   
                      </tr>  
					  <?php
				           }
                        ?>                                                        
                  </table>
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
                   