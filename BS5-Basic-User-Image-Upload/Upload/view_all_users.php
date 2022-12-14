                <h4><i class="fa-solid fa-code"></i> Bootstrap 5 Basic User Image Upload</h4>
                <?php 
                // Demo Breadcrumb

                $is_page = 'view_all_users.php';

                $is_current_page = ucwords(str_replace("_", " ", (basename($is_page, ".php"))));

                $page = $_SERVER['PHP_SELF'];

                $is_current_dir = ucwords(basename(dirname($page)));

                $is_current_dir_icon = '<i class="fa-solid fa-image"></i> ';

                $is_current_page_icon = '<i class="fa-solid fa-users"></i> ';

                ?>

                <!-- Breadcrumb -->
                <ol class="breadcrumb mb-4 mt-4 p-2 bg-white border border-default rounded-3">
                     <li class="breadcrumb-item"><?php echo $is_current_dir_icon; ?><a href="../<?php echo $is_current_dir; ?>"><?php echo $is_current_dir; ?></a></li>                   
                     <li class="breadcrumb-item active"><?php echo $is_current_page_icon; ?><?php echo $is_current_page; ?></li>
                </ol>
                
                <!-- View All Users Table -->
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
                          * Simple User Image Upload (BS5)
                          * Author - ic-myXMB
                          */
                         
                         // Connect to database
                         // Include db connect 
                         include("db.php");

                         // Do DB function
                         doDB();

                         // File User Image Upload Directory  
                         $file_dir = "images/users";                         

                         // Query Select
                         $sql = "SELECT * FROM `users`";
                         $users = mysqli_query($mysqli, $sql);

                         // While
                         while ($data_user = mysqli_fetch_assoc($users)) {

                             // Old Image
                             $old_image = $data_user['user_image'];

                             // User ID     
                             $user_id = $data_user['user_id'];

                             // User Image
                             $user_image = $data_user['user_image'];
                        ?><!-- User -->
                      <tr>
                         <td><?php echo $user_id; ?></td>
                         <td><img height="50" width="50" class="img-responsive" src="<?php echo $file_dir; ?>/<?php echo $user_image; ?>"></td>
                         <td><a href="users.php?delete=<?php echo $user_id; ?>" class="btn btn-danger"><span class="fa-solid fa-trash"></span></a></td> 
                         <td><a href="users.php?ops=edit_user&user_id=<?php echo $user_id; ?>" class="btn btn-success"><span class="fa-solid fa-edit"></span></a></td>   
                      </tr>  
                      <?php
                         }
				           
                            // Delete User
                            // If Is Get Delete 
                            if (isset($_GET['delete'])) {

                             // User Id
                             $user_id = $_GET['delete'];

                             // Query Delete
                             $sql = "DELETE FROM `users` WHERE user_id = '$user_id'";
                             $user_delete = mysqli_query($mysqli, $sql);

                                // If user delete
                                if ($user_delete) {

                                 // Unlink Old Image
                            	 unlink("$file_dir/$old_image");                                    	
                                    	
                                 // Redirect 
                                 header("Location: users.php");

                                }
                            }
                        ?>                                                        
                  </table>
               </div>
                
